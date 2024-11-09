<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AsesoriasController extends Controller
{
    public function mostrarAsesorias()
    {
        // Obtén todos los usuarios
        $usuarios = User::all();

        // Retorna la vista asesorias y pásale los datos de usuarios
        return view('asesorias', compact('usuarios'));
    }

    public function descargarUsuariosPDF()
    {
        // Obtén los datos de los usuarios
        $usuarios = User::all();

        // Carga la vista asesorias y pásale los datos de los usuarios
        $pdf = Pdf::loadView('asesorias', compact('usuarios'));

        // Retorna el archivo PDF para que el usuario lo descargue
        return $pdf->download('usuarios.pdf');
    }
}
