<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
{
    $asesoriasCount = 243; // Reemplaza con datos reales
    $empresasCount = Empresa::count(); // Reemplaza con datos reales
    $usuariosCount = User::count(); // Reemplaza con datos reales
    
    // Obtener las últimas 10 empresas diagnosticadas
    $ultimasEmpresas = DB::table('empresas')
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    return view('welcome', compact(
        'asesoriasCount',
        'empresasCount',
        'usuariosCount',
        'ultimasEmpresas'
    ));
}
}
