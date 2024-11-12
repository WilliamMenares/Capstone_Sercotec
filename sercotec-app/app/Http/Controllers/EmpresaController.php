<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Log;

class EmpresaController extends Controller
{
    public function index()
    {
        // Paginar con 6 registros por página
        $empresas = Empresa::orderBy('id', 'desc')->get();

        return view("empresa")->with("empresas", $empresas);
    }

    public function getemps()

    {
        $empresas = Empresa::all(); // O el modelo que uses
        return response()->json($empresas);
    }

}
