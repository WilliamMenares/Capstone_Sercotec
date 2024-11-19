<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Formularios;
use App\Models\Preguntas;
use App\Models\Respuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiagnosticoController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        $formularios = Formularios::with('ambitos')->get();
        return view("diagnostico", compact('preguntas', 'formularios'));
    }

    public function store(Request $request)
    {
        try {

            Log::info('Datos recibidos:', $request->all());

            $request->validate([
                'responsable' => 'required|string|max:255',
                'id_empresa' => 'required|integer',
                'id_formulario' => 'required|integer',
                'respuesta' => 'required|array',
                'respuesta.*' => 'in:1,2,3',

            ]);

            // Crear la Encuesta y obtener el ID de la encuesta recién creada
            $encuesta = Encuesta::create([
                'responsable' => $request->responsable,
                'id_formulario' => $request->id_formulario,
                'id_empresa' => $request->id_empresa,
            ]);

            // Crear las respuestas asociadas a esta encuesta
            foreach ($request->respuesta as $id_pregunta => $respuesta) {
                Respuestas::create([
                    'id_encuesta' => $encuesta->id,  // Asociar la respuesta con la encuesta creada
                    'id_pregunta' => $id_pregunta,   // El ID de la pregunta (clave del array)
                    'id_tipo' => $respuesta,         // El valor de la respuesta (valor del array)
                ]);
            }

            return redirect()->route('diagnostico.index')->with(
                'success',
                'Ambito registrado exitosamente'
            );
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al registrar Encuesta: ' . $e->getMessage());
        }
    }
}



