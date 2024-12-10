<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $asesoriasCount = Encuesta::count();
        $empresasCount = Empresa::count();
        $usuariosCount = User::count();

        $encuestas = Encuesta::with(['formulario.ambito.pregunta.respuesta.respuestasTipo'])->get();

        // Crear un array para almacenar los totales de preguntas y los puntajes de las respuestas por cada ámbito
        $ambitosConTotales = [];

        // Variable para almacenar la pregunta con más respuestas con puntaje 1
        $preguntaConMasRespuestasTipo1 = null;
        $maxRespuestasTipo1 = 0;

        foreach ($encuestas as $encuesta) {
            foreach ($encuesta->formulario->ambito as $ambito) {
                // Inicializamos las colecciones si no existen
                if (!isset($ambitosConTotales[$ambito->title])) {
                    $ambitosConTotales[$ambito->title] = [
                        'ambito' => '',
                        'total_preguntas' => 0,
                        'puntajes_respuestas' => 0,
                        'porcentaje_general' => 0,
                        'pregunta_mas_respuestas_tipo_1' => [],
                        'max_respuestas_tipo_1' => 0,
                    ];
                }
                $ambitosConTotales[$ambito->title]['ambito'] = $ambito->title;

                // Contar las preguntas del ámbito y multiplicar por 5
                $preguntasPorAmbito = $ambito->pregunta->count() * 5;
                $ambitosConTotales[$ambito->title]['total_preguntas'] += $preguntasPorAmbito;

                // Recorrer las respuestas de cada pregunta para obtener el puntaje
                foreach ($ambito->pregunta as $pregunta) {
                    foreach ($pregunta->respuesta as $respuesta) {
                        if ($encuesta->id == $respuesta->encuesta_id) {
                            $puntaje = $respuesta->respuestasTipo->puntaje;

                            // Almacenamos el puntaje de cada respuesta
                            $ambitosConTotales[$ambito->title]['puntajes_respuestas'] += $puntaje;

                            // Contar las respuestas con puntaje 1
                            if ($puntaje == 1) {
                                // Contabilizamos las respuestas con puntaje 1 para cada pregunta
                                $respuestasTipo1Count = isset($ambitosConTotales[$ambito->title]['pregunta_mas_respuestas_tipo_1'][$pregunta->id])
                                    ? $ambitosConTotales[$ambito->title]['pregunta_mas_respuestas_tipo_1'][$pregunta->id] + 1
                                    : 1;

                                // Actualizamos si esta pregunta tiene más respuestas tipo 1 que la anterior
                                if ($respuestasTipo1Count > $maxRespuestasTipo1) {
                                    $maxRespuestasTipo1 = $respuestasTipo1Count;
                                    $preguntaConMasRespuestasTipo1 = $pregunta;
                                }

                                // Guardamos el conteo de respuestas tipo 1 por pregunta
                                $ambitosConTotales[$ambito->title]['pregunta_mas_respuestas_tipo_1'][$pregunta->id] = $respuestasTipo1Count;
                            }
                        }
                    }
                }

                // Calcular el porcentaje general
                $puntajesRespuestas = $ambitosConTotales[$ambito->title]['puntajes_respuestas'];
                $totalPreguntas = $ambitosConTotales[$ambito->title]['total_preguntas'];

                if ($totalPreguntas > 0) {
                    $porcentajeGeneral = ($puntajesRespuestas * 100) / $totalPreguntas;
                    $ambitosConTotales[$ambito->title]['porcentaje_general'] = $porcentajeGeneral;
                }
            }
        }

        // Obtener las empresas con sus encuestas asociadas y calcular los puntajes
        $empresasConPuntajes = Empresa::with('encuesta.respuestas.respuestasTipo')  // Cargar encuestas con respuestas
            ->get()
            ->map(function ($empresa) {
                // Calcular el puntaje promedio de las encuestas de esta empresa
                $promedio = $empresa->encuesta->flatMap(fn($encuesta) => $encuesta->respuestas)  // Obtiene las respuestas de todas las encuestas
                    ->avg(fn($respuesta) => $respuesta->respuestasTipo->puntaje);  // Calcula el puntaje promedio de las respuestas
                return [
                    'empresa' => $empresa,
                    'promedio' => $promedio,
                ];
            })
            ->filter(fn($item) => $item['promedio'] !== null);  // Filtrar aquellas empresas sin puntajes

        // Obtener las 5 empresas con mejores y peores puntajes
        $mejoresEmpresas = $empresasConPuntajes->sortByDesc('promedio')->take(5);  // Las 5 empresas con mejor puntaje
        $peoresEmpresas = $empresasConPuntajes->sortBy('promedio')->take(5);  // Las 5 empresas con peor puntaje

        // Cálculo del promedio de puntajes de encuestas completadas
        $promedioPuntajes = Encuesta::with('respuestas.respuestasTipo')
            ->get()
            ->flatMap(fn($encuesta) => $encuesta->respuestas)
            ->avg(fn($respuesta) => $respuesta->respuestasTipo->puntaje);

        // Obtener las últimas 6 empresas
        $ultimasEmpresas = Encuesta::with('empresa') // Eager loading para cargar la empresa asociada a cada encuesta
            ->orderBy('created_at', 'desc') // Ordenar por la fecha de creación de la encuesta
            ->take(6) // Obtener las últimas 6 encuestas
            ->get()
            ->pluck('empresa'); // Extraer solo las empresas asociadas

        return view('welcome', compact(
            'asesoriasCount',
            'empresasCount',
            'usuariosCount',
            'ultimasEmpresas',
            'ambitosConTotales',
            'preguntaConMasRespuestasTipo1',
            'promedioPuntajes',
            'mejoresEmpresas',
            'peoresEmpresas'
        ));
    }
}
