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

        $datos_encu = [];

        foreach ($encuestas as $encu) {
            $puntajeMaximoen = 0;
            $puntajeEncuesta = 0;

            if (!isset($datos_encu[$encu->id])) {
                $datos_encu[$encu->id] = [
                    'empresas' => [],
                    'ambitos' => [],
                    'responsable' => '',
                    'obtenido' => 0,
                    'resultado' => 0,
                ];
            }
            ;
            $datos_encu[$encu->id]['responsable'] = $encu->user->name;


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
        try {
            // Validar ID
            if (!is_numeric($id) || $id <= 0) {
                throw new \InvalidArgumentException('ID de encuesta inválido');
            }

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
                        'respuesta' => 'Sin respuesta'
                    ];

                    foreach ($pregu->respuesta as $res) {
                        if ($encuesta->id == $res->encuesta_id && $res->respuestasTipo) {
                            $preguntaData['respuesta'] = $res->respuestasTipo->titulo ?? 'Sin respuesta';
                            $puntaje = $res->respuestasTipo->puntaje ?? 0;
                            $puntajeEncuesta += $puntaje;
                            $puntajeObtenido += $puntaje;
                            break;
                        }
                    }

                    $datoAmbito['preguntas'][] = $preguntaData;
                }

                $datoAmbito['resultado'] = $cantidadPreguntas * 5;
                $datoAmbito['obtenido'] = $puntajeObtenido;
                $puntajeMaximoen += $cantidadPreguntas * 5;

                $datos_encu[$encuesta->id]['ambitos'][] = $datoAmbito;
            }

            $datos_encu[$encuesta->id]['resultado'] = $puntajeMaximoen;
            $datos_encu[$encuesta->id]['obtenido'] = $puntajeEncuesta;

            // Generar el PDF con la vista actualizada
            try {
                $pdf = PDF::loadView('pdf', [
                    'encuesta' => $encuesta,
                    'datos_encu' => $datos_encu
                ])->setPaper('a4', 'portrait');

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
