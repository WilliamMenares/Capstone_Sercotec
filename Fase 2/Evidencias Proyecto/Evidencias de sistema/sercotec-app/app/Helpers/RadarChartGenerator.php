<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class RadarChartGenerator
{
    public static function generateRadarChart($ambitos)
    {
        // Asegurar que el directorio de charts exista
        $chartDirectory = public_path('charts');
        if (!File::exists($chartDirectory)) {
            File::makeDirectory($chartDirectory, 0755, true);
        }

        // Preparar datos para el gráfico
        $labels = collect($ambitos)->pluck('nombre')->toArray();
        $percentages = collect($ambitos)->pluck('porcentaje')->toArray();

        // Generar nombre de archivo único
        $filename = 'radar_chart_' . uniqid() . '.png';
        $fullPath = $chartDirectory . '/' . $filename;

        // Crear el gráfico
        $chart = new Chart();
        $chart->labels($labels);
        $chart->dataset('Porcentaje de Cumplimiento', 'radar', $percentages)
            ->color('rgba(45, 126, 189, 1)')
            ->backgroundcolor('rgba(45, 126, 189, 0.2)');

        // Configurar opciones del gráfico
        $chart->options([
            'responsive' => true,
            'title' => [
                'display' => true,
                'text' => 'Análisis de Ámbitos'
            ],
            'scale' => [
                'ticks' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'stepSize' => 20
                ]
            ]
        ]);

        // Renderizar y guardar el gráfico como imagen
        $chart->width(600);
        $chart->height(400);
        $chart->save($fullPath, 'gd');

        // Devolver la ruta relativa de la imagen
        return 'charts/' . $filename;
    }
}