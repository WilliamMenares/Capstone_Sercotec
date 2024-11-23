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
            ], [
                'responsable.required' => 'El campo responsable es obligatorio.',
                'responsable.string' => 'El campo responsable debe ser una cadena de texto.',
                'responsable.max' => 'El campo responsable no puede tener más de 255 caracteres.',

                'id_empresa.required' => 'El campo empresa es obligatorio.',
                'id_empresa.integer' => 'El campo empresa debe ser un número entero.',

                'id_formulario.required' => 'El campo formulario es obligatorio.',
                'id_formulario.integer' => 'El campo formulario debe ser un número entero.',

                'respuesta.required' => 'El campo respuesta es obligatorio.',
                'respuesta.array' => 'El campo respuesta debe ser un conjunto de valores.',

                'respuesta.*.in' => 'Cada respuesta debe ser uno de los siguientes valores: 1, 2 o 3.',
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
                    'id_pregunta' => $id_pregunta,   // El ID de la pregunta (clave del array)
                    'id_tipo' => $respuesta,         // El valor de la respuesta (valor del array)
                ]);
            }

            return redirect()->route('diagnostico.index')->with(
                'success',
                'Diagnostico registrado exitosamente'
            );
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al registrar Diagnostico: ' . $e->getMessage());
        }
    }
}



