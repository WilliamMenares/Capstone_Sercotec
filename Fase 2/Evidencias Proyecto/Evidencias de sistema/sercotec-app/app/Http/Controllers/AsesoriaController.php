<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Feedback;
use App\Models\Respuestas;
use Barryvdh\DomPDF\Facade\Pdf;
use Log;

class AsesoriaController extends Controller
{
    public function index()
    {

        $encuestas = Encuesta::with(['formulario.ambito.pregunta.respuesta.respuestasTipo', 'empresa'])->get();


        return view("asesorias", compact('encuestas'));
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


    // Método nuevo antes de generarPDF
    private function prepararLogoBase64()
    {
        $logoPath = public_path('img/Logo_Sercotec.png');

        // Verificar si el archivo existe
        if (!file_exists($logoPath)) {
            Log::error('Archivo de logo no encontrado: ' . $logoPath);
            return null;
        }

        try {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            return $logoBase64;
        } catch (\Exception $e) {
            Log::error('Error al procesar el logo: ' . $e->getMessage());
            return null;
        }
    }


    private function generarGraficoRadar($datos_encu, $encuesta_id)
    {
        // Configuración del gráfico
        $width = 400;
        $height = 400;
        $center_x = $width / 2;
        $center_y = $height / 2;
        $radio = min($width, $height) * 0.4;

        // Crear la imagen
        $image = imagecreatetruecolor($width, $height);

        // Definir colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $gray = imagecolorallocate($image, 200, 200, 200);
        $blue = imagecolorallocate($image, 54, 162, 235);
        $blueAlpha = imagecolorallocatealpha($image, 54, 162, 235, 80);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Hacer el fondo blanco
        imagefill($image, 0, 0, $white);

        // Dibujar círculos concéntricos y etiquetas de porcentaje
        for ($i = 1; $i <= 10; $i++) {
            $radius = $radio * $i / 10;
            imagearc($image, $center_x, $center_y, $radius * 2, $radius * 2, 0, 360, $gray);
            // Añadir etiqueta de porcentaje
            $percent = $i * 10;
            imagestring($image, 2, $center_x - 10, $center_y - $radius, $percent . '%', $gray);
        }

        // Preparar datos
        $datos = [];
        $etiquetas = [];
        foreach ($datos_encu[$encuesta_id]['ambitos'] as $amb) {
            $porcentaje = round(($amb['obtenido'] * 100) / $amb['resultado'], 2);
            $datos[] = $porcentaje;
            $etiquetas[] = $amb['nombre'];
        }

        $num_points = count($datos);
        $angle_step = 360 / $num_points;

        // Dibujar líneas radiales y etiquetas
        for ($i = 0; $i < $num_points; $i++) {
            $angle = deg2rad($i * $angle_step - 90);
            imageline(
                $image,
                $center_x,
                $center_y,
                $center_x + $radio * cos($angle),
                $center_y + $radio * sin($angle),
                $gray
            );

            // Añadir etiquetas de ámbitos
            $label_x = $center_x + ($radio + 20) * cos($angle);
            $label_y = $center_y + ($radio + 20) * sin($angle);
            imagestring($image, 3, $label_x - 20, $label_y - 10, $etiquetas[$i], $black);
        }

        // Dibujar polígono de datos
        $points = [];
        for ($i = 0; $i < $num_points; $i++) {
            $angle = deg2rad($i * $angle_step - 90);
            $distance = $radio * $datos[$i] / 100;
            $points[] = $center_x + $distance * cos($angle);
            $points[] = $center_y + $distance * sin($angle);
        }

        // Dibujar área rellena
        imagefilledpolygon($image, $points, $num_points, $blueAlpha);

        // Dibujar líneas del polígono
        for ($i = 0; $i < $num_points; $i++) {
            $next = ($i + 1) % $num_points;
            imageline(
                $image,
                $points[$i * 2],
                $points[$i * 2 + 1],
                $points[$next * 2],
                $points[$next * 2 + 1],
                $blue
            );
        }

        // Convertir la imagen a base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return base64_encode($imageData);
    }

    public function generarPDF($id)
    {
        try {
            // Validar ID
            if (!is_numeric($id) || $id <= 0) {
                throw new \InvalidArgumentException('ID de encuesta inválido');
            }

            // Preparar el logo antes de generar el PDF
            $logoBase64 = $this->prepararLogoBase64();
        } catch (\Exception $e) {
            Log::error('Error al preparar el logo: ' . $e->getMessage());
            return redirect()->back()->withErrors('Error al preparar el logo para el PDF.');
        }

        try {
            Log::info('Iniciando generación de PDF para la encuesta ID: ' . $id);
            // Obtener la encuesta con relaciones
            $encuesta = Encuesta::with([
                'formulario.ambito.pregunta.respuesta.respuestasTipo',
                'empresa',
                'user'
            ])->find($id);

            // Validar que la encuesta existe
            if (!$encuesta) {
                throw new \RuntimeException('Encuesta no encontrada');
            }


            // Validar relaciones necesarias
            if (!$encuesta->formulario) {
                throw new \RuntimeException('La encuesta no tiene un formulario asociado');
            }

            if (!$encuesta->empresa) {
                throw new \RuntimeException('La encuesta no tiene una empresa asociada');
            }

            if (!$encuesta->user) {
                throw new \RuntimeException('La encuesta no tiene un usuario asociado');
            }

            // Inicializar array de datos
            $datos_encu = [];

            // Procesar datos de la encuesta
            $datos_encu[$encuesta->id] = [
                'empresas' => [],
                'ambitos' => [],
                'responsable' => $encuesta->user->name ?? 'Sin responsable',
                'obtenido' => 0,
                'resultado' => 0,
            ];

            // Agregar datos de la empresa
            $datos_encu[$encuesta->id]['empresas'][] = [
                'rut' => $encuesta->empresa->rut ?? 'Sin RUT',
                'nombre' => $encuesta->empresa->nombre ?? 'Empresa sin nombre',
                'email' => $encuesta->empresa->email ?? 'Sin email',
                'contacto' => $encuesta->empresa->contacto ?? 'Sin contacto'
            ];

            $puntajeMaximoen = 0;
            $puntajeEncuesta = 0;
            $feedback = Feedback::all();

            // Procesar ámbitos
            foreach ($encuesta->formulario->ambito as $ambi) {
                if (!$ambi->title) {
                    continue;
                }

                $datoAmbito = [
                    'nombre' => $ambi->title,
                    'preguntas' => [],
                    'resultado' => 0,
                    'obtenido' => 0,
                    'porcentaje' => 0,  // Agregamos el campo para el porcentaje de cumplimiento
                ];

                $cantidadPreguntas = 0;
                $puntajeObtenido = 0;

                foreach ($ambi->pregunta as $pregu) {
                    if (!$pregu->title) {
                        continue;
                    }

                    $cantidadPreguntas++;
                    $preguntaData = [
                        'nombre' => $pregu->title,
                        'respuesta' => 'Sin respuesta',
                        'feedback' => [], // Inicializamos feedback como un array vacío
                    ];

                    foreach ($pregu->respuesta as $res) {
                        if ($encuesta->id == $res->encuesta_id && $res->respuestasTipo) {
                            $preguntaData['respuesta'] = $res->respuestasTipo->titulo ?? 'Sin respuesta';
                            $puntaje = $res->respuestasTipo->puntaje ?? 0;
                            $puntajeObtenido += $puntaje;

                            // Buscar feedback asociado a la respuesta
                            $feedbackData = $feedback->where('pregunta_id', $pregu->id)
                                ->where('respuestas_tipo_id', $res->respuestasTipo->id)
                                ->first();

                            // Agregar feedback si existe
                            if ($feedbackData) {
                                $preguntaData['feedback'] = [
                                    'situacion' => $feedbackData->situacion,
                                    'accion1' => $feedbackData->accion1,
                                    'accion2' => $feedbackData->accion2,
                                    'accion3' => $feedbackData->accion3,
                                    'accion4' => $feedbackData->accion4,
                                ];
                            }
                            break;
                        }
                    }

                    $datoAmbito['preguntas'][] = $preguntaData;
                }

                $datoAmbito['resultado'] = $cantidadPreguntas * 5;
                $datoAmbito['obtenido'] = $puntajeObtenido;
                $datoAmbito['porcentaje'] = ($datoAmbito['obtenido'] * 100) / $datoAmbito['resultado'];  // Calculamos el porcentaje



                // Solo agregar si el puntaje obtenido es mayor a 0
                if ($puntajeObtenido > 0) {
                    $datos_encu[$encuesta->id]['ambitos'][] = $datoAmbito;
                    $puntajeMaximoen += $cantidadPreguntas * 5;
                    $puntajeEncuesta += $puntajeObtenido;
                    Log::info($puntajeEncuesta);
                }
            }

            // Ordenar los ámbitos en función del porcentaje de cumplimiento
            usort($datos_encu[$encuesta->id]['ambitos'], function ($a, $b) {
                return $b['porcentaje'] <=> $a['porcentaje'];  // Ordenamos de mayor a menor
            });

            // Verificar la cantidad de ámbitos y seleccionamos los correctos
            $topAmbitos = [];
            $bottomAmbitos = [];

            // Si hay al menos un ámbito, seleccionamos el mejor (primer ámbito)
            if (count($datos_encu[$encuesta->id]['ambitos']) >= 1) {
                $topAmbitos[] = $datos_encu[$encuesta->id]['ambitos'][0];  // El mejor ámbito
            }

            // Si hay al menos tres ámbitos, seleccionamos los dos peores (últimos dos ámbitos)
            if (count($datos_encu[$encuesta->id]['ambitos']) == 2) {
                $bottomAmbitos[] = $datos_encu[$encuesta->id]['ambitos'][1];  // Los dos peores
            }

            // Si hay al menos tres ámbitos, seleccionamos los dos peores (últimos dos ámbitos)
            if (count($datos_encu[$encuesta->id]['ambitos']) >= 3) {
                $bottomAmbitos = array_slice($datos_encu[$encuesta->id]['ambitos'], -2);  // Los dos peores
            }

            // Combinamos el mejor con los dos peores sin duplicarlos
            $datos_encu[$encuesta->id]['ambitos'] = array_merge($topAmbitos, $bottomAmbitos);

            $datos_encu[$encuesta->id]['resultado'] = $puntajeMaximoen;
            $datos_encu[$encuesta->id]['obtenido'] = $puntajeEncuesta;
            $chartImageBase64 = $this->generarGraficoRadar($datos_encu, $encuesta->id);
            Log::info('Gráfico generado correctamente');
            try {
                $pdf = PDF::loadView('pdf', [
                    'encuesta' => $encuesta,
                    'datos_encu' => $datos_encu,
                    'logoBase64' => $logoBase64,
                    'chartImageBase64' => $chartImageBase64
                ])
                    ->setPaper('a4', 'portrait');
                Log::info('Vista PDF cargada correctamente');

                // Configurar headers para la descarga
                return response($pdf->output())
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'attachment; filename="asesoria_' . $id . '.pdf"')
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            } catch (\Exception $e) {
                Log::error('Error en la generación del PDF: ' . $e->getMessage());
                throw new \RuntimeException('Error al generar el archivo PDF: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('Error en generarPDF: ' . $e->getMessage());

            if (config('app.debug')) {
                throw $e;
            }

            return response()->json([
                'error' => 'No se pudo generar el PDF',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
