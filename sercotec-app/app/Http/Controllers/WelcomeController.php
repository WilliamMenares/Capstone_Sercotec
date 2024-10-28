<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
class WelcomeController extends Controller
{
    public function index() {
        // Obtener las últimas 3 empresas
        $ultimasEmpresas = Empresa::orderBy('created_at', 'desc')->take(3)->get();      
        
        return view('welcome', compact('ultimasEmpresas'));
    }
}
