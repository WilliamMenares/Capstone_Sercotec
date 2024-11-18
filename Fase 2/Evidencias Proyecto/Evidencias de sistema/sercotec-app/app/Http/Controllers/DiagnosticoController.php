<?php

namespace App\Http\Controllers;

use App\Models\Formularios;
use App\Models\Preguntas;

class DiagnosticoController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        $formularios = Formularios::with('ambitos')->get();
        return view("diagnostico", compact('preguntas', 'formularios'));
    }


}



