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

        $encuestas = Encuesta::with(['formulario.ambito.pregunta.respuesta.respuestasTipo', 'empresa'])->get();

        $datos_encu = [];

        foreach ($encuestas as $encu) {
            $puntajeMaximoen = 0;
            $puntajeEncuesta = 0;

            if (!isset($datos_encu[$encu->id])) {
                $datos_encu[$encu->id] = [
                    'empresas' => [],
                    'ambitos' => [],
                    'obtenido' => 0,
                    'resultado' => 0,
                ];
            }
            ;
            $datos_encu[$encu->id]['empresas'][] = [
                'rut' => $encu->empresa->rut ?? '',
                'nombre' => $encu->empresa->nombre ?? '', // Usamos el valor del modelo o un valor vacío
                'email' => $encu->empresa->email ?? '',
                'contacto' => $encu->empresa->contacto ?? ''
            ];
           

            foreach ($encu->formulario->ambito as $ambi) {
                $datos_encu[$encu->id]['ambitos'][] = [
                    'nombre' => $ambi->title ?? '',
                    'preguntas' => [],
                    'resultado' => 0,
                    'obtenido' => 0,
                ];

                $cantidadPreguntas = 0;
                $puntajeObtenido = 0;
                // Obtener el índice del último ámbito agregado
                $ultimoIndice = array_key_last($datos_encu[$encu->id]['ambitos']);

                foreach ($ambi->pregunta as $pregu) {
                    $cantidadPreguntas += 1;
                    // Agregar las preguntas al ámbito correspondiente
                    $datos_encu[$encu->id]['ambitos'][$ultimoIndice]['preguntas'][] = [
                        'nombre' => $pregu->title ?? '',
                        'respuesta' => '',
                    ];

                    // Obtener el índice de la última pregunta agregada
                    $ultimoIndicePregunta = array_key_last($datos_encu[$encu->id]['ambitos'][$ultimoIndice]['preguntas']);


                    // Buscar y agregar respuesta correspondiente
                    foreach ($pregu->respuesta as $res) {
                        if ($encu->id == $res->encuesta_id) {
                            $datos_encu[$encu->id]['ambitos'][$ultimoIndice]['preguntas'][$ultimoIndicePregunta]['respuesta'] = $res->respuestasTipo->titulo ?? '';
                            $puntaje = $res->respuestasTipo->puntaje ?? 0;
                            $puntajeEncuesta += $puntaje;
                            $puntajeObtenido += $puntaje;
                            ;
                            break; // Salir del bucle una vez que encontramos la respuesta
                        }
                    }

                }
                $datos_encu[$encu->id]['ambitos'][$ultimoIndice]['resultado'] = $cantidadPreguntas * 5;
                $datos_encu[$encu->id]['ambitos'][$ultimoIndice]['obtenido'] = $puntajeObtenido;
                $puntajeMaximoen += $cantidadPreguntas * 5;
            }
            ;
            $datos_encu[$encu->id]['resultado'] = $puntajeMaximoen;
            $datos_encu[$encu->id]['obtenido'] = $puntajeEncuesta;
        }
        ;

        return view("asesorias", compact('datos_encu', 'encuestas'));
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

        $pdf = PDF::loadView('pdf', compact('encuesta', 'feedbacks'));

        return $pdf->download('asesoria_' . $id . '.pdf');
    }
}
