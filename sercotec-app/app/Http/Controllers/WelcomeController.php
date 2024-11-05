<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Empresa;

class WelcomeController extends Controller
{
    public function index()
    {
        // Obtener las últimas 5 empresas
        $ultimasEmpresas = Empresa::orderBy('created_at', 'desc')->take(5)->get(['nombre', 'created_at']);
        
        // Obtener la cantidad total de empresas
        $cantidadEmpresas = Empresa::count();
        
        // Obtener la fecha de hace 6 meses
        $haceSeisMeses = Carbon::now()->subMonths(6);

        // Obtener las empresas creadas en los últimos 6 meses
        $empresasUltimos6Meses = Empresa::where('created_at', '>=', $haceSeisMeses)
                                        ->orderBy('created_at', 'asc')
                                        ->get(['nombre', 'created_at']);

        // Agrupar por mes y contar las empresas
        $empresasPorMes = $empresasUltimos6Meses->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m'); // Agrupar por año-mes
        })->map(function ($row) {
            return count($row);
        });

        // Pasar todas las variables a la vista
        return view('welcome', compact('ultimasEmpresas', 'cantidadEmpresas', 'empresasPorMes'));
    }
}
