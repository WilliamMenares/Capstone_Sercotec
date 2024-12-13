<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Feedback;
use App\Models\Respuestas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

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
        $encuesta = Encuesta::findOrFail($id);
        $respuestas = Respuestas::where('encuesta_id', $id)->get();

        foreach ($respuestas as $respuesta) {
            $respuesta->delete();
        }

        $encuesta->delete();

        return redirect()->route('asesorias.index')->with('success', 'Asesoria eliminada con éxito.');
    }

    private function prepararLogoBase64()
    {
        $logoPath = public_path('img/Logo_Sercotec.png');
        
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

    public function generarPDF($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \InvalidArgumentException('ID de encuesta inválido');
            }

            $logoBase64 = $this->prepararLogoBase64();

            $encuesta = Encuesta::with([
                'formulario.ambito.pregunta.respuesta.respuestasTipo',
                'empresa',
                'user'
            ])->find($id);

            if (!$encuesta) {
                throw new \RuntimeException('Encuesta no encontrada');
            }

            if (!$encuesta->formulario) {
                throw new \RuntimeException('La encuesta no tiene un formulario asociado');
            }

            if (!$encuesta->empresa) {
                throw new \RuntimeException('La encuesta no tiene una empresa asociada');
            }

            if (!$encuesta->user) {
                throw new \RuntimeException('La encuesta no tiene un usuario asociado');
            }

            $datos_encu = [];
            $datos_encu[$encuesta->id] = [
                'empresas' => [],
                'ambitos' => [],
                'responsable' => $encuesta->user->name ?? 'Sin responsable',
                'obtenido' => 0,
                'resultado' => 0,
            ];

            $datos_encu[$encuesta->id]['empresas'][] = [
                'rut' => $encuesta->empresa->rut ?? 'Sin RUT',
                'nombre' => $encuesta->empresa->nombre ?? 'Empresa sin nombre',
                'email' => $encuesta->empresa->email ?? 'Sin email',
                'contacto' => $encuesta->empresa->contacto ?? 'Sin contacto'
            ];

            $puntajeMaximoen = 0;
            $puntajeEncuesta = 0;
            $feedback = Feedback::all();

            foreach ($encuesta->formulario->ambito as $ambi) {
                if (!$ambi->title) {
                    continue;
                }

                $datoAmbito = [
                    'nombre' => $ambi->title,
                    'preguntas' => [],
                    'resultado' => 0,
                    'obtenido' => 0,
                    'porcentaje' => 0,
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
                        'feedback' => [],
                    ];

                    foreach ($pregu->respuesta as $res) {
                        if ($encuesta->id == $res->encuesta_id && $res->respuestasTipo) {
                            $preguntaData['respuesta'] = $res->respuestasTipo->titulo ?? 'Sin respuesta';
                            $puntaje = $res->respuestasTipo->puntaje ?? 0;
                            $puntajeObtenido += $puntaje;

                            $feedbackData = $feedback->where('pregunta_id', $pregu->id)
                                ->where('respuestas_tipo_id', $res->respuestasTipo->id)
                                ->first();

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
                $datoAmbito['porcentaje'] = ($datoAmbito['obtenido'] * 100) / $datoAmbito['resultado'];

                if ($puntajeObtenido > 0) {
                    $datos_encu[$encuesta->id]['ambitos'][] = $datoAmbito;
                    $puntajeMaximoen += $cantidadPreguntas * 5;
                    $puntajeEncuesta += $puntajeObtenido;
                }
            }

            usort($datos_encu[$encuesta->id]['ambitos'], function ($a, $b) {
                return $b['porcentaje'] <=> $a['porcentaje'];
            });

            $topAmbitos = [];
            $bottomAmbitos = [];

            if (count($datos_encu[$encuesta->id]['ambitos']) >= 1) {
                $topAmbitos[] = $datos_encu[$encuesta->id]['ambitos'][0];
            }

            if (count($datos_encu[$encuesta->id]['ambitos']) == 2) {
                $bottomAmbitos[] = $datos_encu[$encuesta->id]['ambitos'][1];
            }

            if (count($datos_encu[$encuesta->id]['ambitos']) >= 3) {
                $bottomAmbitos = array_slice($datos_encu[$encuesta->id]['ambitos'], -2);
            }

            $datos_encu[$encuesta->id]['ambitos'] = array_merge($topAmbitos, $bottomAmbitos);

            $datos_encu[$encuesta->id]['resultado'] = $puntajeMaximoen;
            $datos_encu[$encuesta->id]['obtenido'] = $puntajeEncuesta;

            $radarChartData = [
                'labels' => [],
                'percentages' => []
            ];
        
            foreach ($datos_encu[$encuesta->id]['ambitos'] as $ambito) {
                $porcentaje = round(($ambito['obtenido'] * 100) / $ambito['resultado'], 2);
                $radarChartData['labels'][] = $ambito['nombre'];
                $radarChartData['percentages'][] = $porcentaje;
            }

            // Generate the chart image
            $chartImagePath = $this->generateChartImage($radarChartData);

            $pdf = PDF::loadView('pdf', [
                'encuesta' => $encuesta,
                'datos_encu' => $datos_encu,
                'logoBase64' => $logoBase64,
                'radarChartData' => $radarChartData,
                'chartImagePath' => $chartImagePath
            ])->setPaper('a4', 'portrait');

            // Clean up the temporary image file
            Storage::delete($chartImagePath);

            return response($pdf->output())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="asesoria_' . $id . '.pdf"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');

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

    private function generateChartImage($radarChartData)
    {
        $html = view('chart', compact('radarChartData'))->render();

        $tempImagePath = 'temp/chart_' . uniqid() . '.png';

        Browsershot::html($html)
            ->setNodeBinary('/usr/bin/node') // Ajusta esta ruta a tu binario de Node.js
            ->setNpmBinary('/usr/bin/npm')   // Ajusta esta ruta a tu binario de npm
            ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox'])
            ->windowSize(500, 500)
            ->waitUntilNetworkIdle()
            ->save(storage_path('app/public/' . $tempImagePath));

        return Storage::url($tempImagePath);
    }
}

