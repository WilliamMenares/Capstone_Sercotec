<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Feedback;
use App\Models\Respuestas;
use Barryvdh\DomPDF\Facade\Pdf;

class AsesoriaController extends Controller
{
    public function index()
    {
        $encuestas = Encuesta::with([
            'user',
            'empresa',
            'formulario.ambito.pregunta.respuesta.respuestasTipo'
        ])->get();

        $feedbacks = Feedback::all();

        return view("asesorias", compact('encuestas', 'feedbacks'));
    }

    public function getase()
    {
        $encuestas = Encuesta::with([
            'formulario.ambito.pregunta.respuesta.respuestasTipo',
            'empresa',
            'user'
        ])->get();

        return response()->json($encuestas);
    }







    public function destroy($id)
    {
        // Encuentra la encuesta
        $encuesta = Encuesta::findOrFail($id);

        // Encuentra todas las respuestas asociadas a la encuesta
        $respuestas = Respuestas::where('encuesta_id', $id)->get();

        // Elimina todas las respuestas
        foreach ($respuestas as $respuesta) {
            $respuesta->delete();
        }

        // Elimina la encuesta
        $encuesta->delete();

        // Redirige con mensaje de éxito
        return redirect()->route('asesorias.index')->with('success', 'Asesoria eliminada con éxito.');
    }

    public function generarPDF($id)
    {
        $encuesta = Encuesta::with([
            'formulario.ambito.pregunta.respuesta.respuestasTipo',
            'empresa',
            'user'
        ])->findOrFail($id);

        $feedbacks = Feedback::all();

        // Cálculo de porcentajes de ámbitos
        $ambitosConPorcentaje = [];
        foreach ($encuesta->formulario->ambito as $ambito) {
            $cantidadPreguntas = $ambito->pregunta->count();
            $maxPuntajePosible = 5 * $cantidadPreguntas;

            $puntajeActual = 0;
            foreach ($ambito->pregunta as $pregunta) {
                foreach ($pregunta->respuesta as $respuesta) {
                    $puntajeActual += $respuesta->respuestasTipo->puntaje;
                }
            }

            $porcentajeSatisfaccion = ($puntajeActual / $maxPuntajePosible) * 100;

            $ambitosConPorcentaje[] = [
                'ambito' => $ambito,
                'porcentaje' => $porcentajeSatisfaccion,
                'puntajeActual' => $puntajeActual,
                'maxPuntajePosible' => $maxPuntajePosible
            ];

            // Generar gráfico para cada ámbito
            $chartFileName = $this->generarGraficoCircular($porcentajeSatisfaccion, $ambito->id);
            $ambitosConPorcentaje[count($ambitosConPorcentaje) - 1]['chartFileName'] = $chartFileName;
        }

        // Ordenar ámbitos
        usort($ambitosConPorcentaje, function ($a, $b) {
            return $a['porcentaje'] <=> $b['porcentaje'];
        });

        // Ámbitos con menor porcentaje
        $ambitosMenorPorcentaje = array_slice($ambitosConPorcentaje, 0, 2);

        // Ámbito con mayor porcentaje
        $ambitoMayorPorcentaje = end($ambitosConPorcentaje);

        $pdf = PDF::loadView('pdf', compact(
            'encuesta',
            'feedbacks',
            'ambitosMenorPorcentaje',
            'ambitoMayorPorcentaje'
        ))->setPaper('a4', 'portrait');
        
        return $pdf->download('asesoria_' . $id . '.pdf');
    }

    private function generarGraficoCircular($porcentaje, $ambitoId)
    {
        // Crear una imagen de 200x200 píxeles
        $imagen = imagecreate(200, 200);

        // Definir colores
        $blanco = imagecolorallocate($imagen, 255, 255, 255);
        $azul = imagecolorallocate($imagen, 0, 0, 255);
        $rojo = imagecolorallocate($imagen, 255, 0, 0);
        $negro = imagecolorallocate($imagen, 0, 0, 0);

        // Rellenar el fondo
        imagefill($imagen, 0, 0, $blanco);

        // Dibujar el gráfico circular
        imagefilledarc($imagen, 100, 100, 180, 180, 0, $porcentaje * 3.6, $azul, IMG_ARC_PIE);
        imagefilledarc($imagen, 100, 100, 180, 180, $porcentaje * 3.6, 360, $rojo, IMG_ARC_PIE);

        // Agregar texto
        imagestring($imagen, 5, 70, 90, round($porcentaje) . "%", $negro);

        // Guardar la imagen
        $fileName = 'chart_' . $ambitoId . '.png';
        $filePath = public_path('charts/' . $fileName);
        imagepng($imagen, $filePath);
        imagedestroy($imagen);

        return $fileName;
    }
}
