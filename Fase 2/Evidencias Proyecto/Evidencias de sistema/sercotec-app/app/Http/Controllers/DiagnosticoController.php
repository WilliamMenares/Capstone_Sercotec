<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Formularios;
use App\Models\Preguntas;
use App\Models\Respuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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


    public function verificar(Request $request)
    {
        $empresaId = $request->input('empresa_id');

        // Buscar la última encuesta de la empresa
        $lastEncuesta = Encuesta::where('empresa_id', $empresaId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastEncuesta) {
            $lastCreatedAt = Carbon::parse($lastEncuesta->created_at); // Asegurar instancia de Carbon
            $oneYearAgo = Carbon::now()->subYear();
            $diasPasados = round($lastCreatedAt->diffInDays(Carbon::now()));


            // Si la última encuesta fue hace menos de un año
            if ($lastCreatedAt->greaterThan($oneYearAgo)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Esta empresa ya ha sido diagnosticada este año, hace $diasPasados días. ¿Desea continuar con el diagnóstico?",
                    'ultima_encuesta' => $lastCreatedAt->toDateString(),
                    'rango_un_ano' => $oneYearAgo->toDateString(),
                    'dias_transcurridos' => $diasPasados
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Puede crear una nueva encuesta.',
        ]);
    }


}



