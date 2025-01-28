<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Formularios;
use App\Models\Preguntas;
use App\Models\Respuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        $formularios = Formularios::with('ambito')->get();
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

            // Verificar si ya existe una encuesta para la misma empresa y si ha pasado un año
            $lastEncuesta = Encuesta::where('empresa_id', $request->id_empresa)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastEncuesta) {
                // Compara la fecha de creación de la última encuesta con la fecha actual
                $lastCreatedAt = $lastEncuesta->created_at;
                $oneYearAgo = now()->subYear(); // Obtener la fecha de hace un año

                if ($lastCreatedAt > $oneYearAgo) {
                    // Si la última encuesta es más reciente que un año, muestra el error
                    return redirect()->back()->with('error', 'No se puede crear una nueva encuesta para esta empresa. Debe pasar al menos un año.');
                }
            }

            // Crear la Encuesta y obtener el ID de la encuesta recién creada
            $encuesta = Encuesta::create([
                'user_id' => $request->responsable,
                'formulario_id' => $request->id_formulario,
                'empresa_id' => $request->id_empresa,
            ]);

            // Obtener el ID de la encuesta recién creada
            $id_encuesta = $encuesta->id; // Aquí obtienes el id de la encuesta creada

            // Crear las respuestas asociadas a esta encuesta
            foreach ($request->respuesta as $id_pregunta => $respuesta) {
                Respuestas::create([
                    'pregunta_id' => $id_pregunta,  // ID de la pregunta
                    'encuesta_id' => $id_encuesta,  // ID de la encuesta (que acabamos de crear)
                    'respuestatipo_id' => $respuesta,        // El valor de la respuesta (valor del array)
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



