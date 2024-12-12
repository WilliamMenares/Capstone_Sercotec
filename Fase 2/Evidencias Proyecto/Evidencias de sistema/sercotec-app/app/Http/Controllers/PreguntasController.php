<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Preguntas;
use App\Models\RespuestasTipo;
use DB;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public function getpregu()
    {
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        return response()->json($preguntas);
    }

    // Función para agregar un usuario
    public function store(Request $request)
    {
        try {
            // Validar los datos del request
            $request->validate([
                'title' => 'required|string',
                'id_ambito' => 'required|integer',
                'puntaje' => 'required|integer',
            ], [
                'title.required' => 'La pregunta es obligatorio.',
                'title.string' => 'La pregunta debe ser una cadena de texto.',

                'ambito_id.required' => 'El ambito_id es obligatorio.',
                'ambito_id.string' => 'El ambito_id debe ser una cadena de texto.',

                'puntaje.required' => 'El puntaje es obligatorio.',
                'puntaje.string' => 'El puntaje debe ser una cadena de texto.',

            ]);

            // Verificar si ya existe una pregunta con el mismo puntaje en el mismo ámbito
            $existePregunta = Preguntas::where('ambito_id', $request->id_ambito)
                ->where('prioridad', $request->puntaje)
                ->exists();

            if ($existePregunta) {
                return redirect()->back()->with('error', 'Ya existe una pregunta con este puntaje en el mismo ámbito.');
            }

            // Iniciar transacción de base de datos
            DB::beginTransaction();

            try {
                // Crear la nueva pregunta
                $pregunta = Preguntas::create([
                    'title' => $request->title,
                    'ambito_id' => $request->id_ambito,
                    'prioridad' => $request->puntaje,
                ]);

                // Obtener todos los tipos de respuestas
                $tipos = RespuestasTipo::all();

                // Recorrer todos los tipos y almacenar las respuestas
                foreach ($tipos as $tipo) {
                    Feedback::create([
                        'pregunta_id' => $pregunta->id,
                        'respuestas_tipo_id' => $tipo->id,  // Usamos el id de RespuestaTipo
                        'situacion' => $request->input("situacion_{$tipo->id}"),
                        'accion1' => $request->input("accion1_{$tipo->id}"),
                        'accion2' => $request->input("accion2_{$tipo->id}"),
                        'accion3' => $request->input("accion3_{$tipo->id}"),
                        'accion4' => $request->input("accion4_{$tipo->id}"),
                    ]);
                }

                DB::commit();

                return redirect()->route('forms.index')->with(
                    'success',
                    'Pregunta y feedback registrados exitosamente'
                );
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al registrar Pregunta y feedback: ' . $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $pregunta = Preguntas::findOrFail($id);

            // Validar los datos del request
            $request->validate([
                'nombrep' => 'required|string',
                
                'puntaje' => 'required|integer',
            ], [
                'nombrep.required' => 'La pregunta es obligatorio.',
                'nombrep.string' => 'La pregunta debe ser una cadena de texto.',

                

                'puntaje.required' => 'El puntaje es obligatorio.',
                'puntaje.string' => 'El puntaje debe ser una cadena de texto.',

            ]);

            // Verificar si ya existe otra pregunta con el mismo puntaje en el mismo ámbito
            $existePregunta = Preguntas::where('ambito_id', $request->id_ambito)
                ->where('prioridad', $request->puntaje)
                ->where('id', '!=', $id) // Excluir la pregunta actual
                ->exists();

            if ($existePregunta) {
                return redirect()->back()->with('error', 'Ya existe una pregunta con este puntaje en el mismo ámbito.');
            }

            DB::beginTransaction();

            try {
                // Actualizar pregunta
                $pregunta->update([
                    'title' => $request->nombrep,
                    'prioridad' => $request->puntaje
                ]);

                // Obtener todos los tipos de respuestas
                $tipos = RespuestasTipo::all();

                // Recorrer todos los tipos y actualizar o crear el feedback
                foreach ($tipos as $tipo) {
                    Feedback::updateOrCreate(
                        [
                            'pregunta_id' => $pregunta->id,
                            'respuestas_tipo_id' => $tipo->id,  // Usamos el id de RespuestaTipo
                        ],
                        [
                            'situacion' => $request->input("situacion_{$tipo->id}"),
                            'accion1' => $request->input("accion1_{$tipo->id}"),
                            'accion2' => $request->input("accion2_{$tipo->id}"),
                            'accion3' => $request->input("accion3_{$tipo->id}"),
                            'accion4' => $request->input("accion4_{$tipo->id}"),
                        ]
                    );
                }

                DB::commit();

                return redirect()->route('forms.index')->with('success', 'Pregunta y feedback actualizados con éxito');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar Pregunta y feedback: ' . $e->getMessage());
        }
    }


    // Función para eliminar un usuario
    public function destroy($id)
    {
        try {
            // Obtener la pregunta con su ámbito, feedbacks y respuestas
            $pregunta = Preguntas::with('ambito.formulario', 'feedbacks', 'respuesta')->findOrFail($id);

            // 1. Verificar si el ámbito está enlazado a un formulario
            if ($pregunta->ambito->formulario->isNotEmpty()) {
                return redirect()->back()->with('error', 'No se puede eliminar la pregunta porque el ámbito está enlazado a un formulario.');
            }

            // 3. Verificar si existen respuestas asociadas a la pregunta
            if ($pregunta->respuesta()->exists()) {
                return redirect()->back()->with('error', 'No se puede eliminar la pregunta porque tiene respuestas asociadas.');
            }

            // Si pasaron todas las verificaciones, proceder a eliminar los feedbacks y respuestas

            // Eliminar las respuestas asociadas
            $pregunta->respuesta()->delete(); // Elimina las respuestas asociadas

            // Eliminar los feedbacks asociados
            $pregunta->feedbacks()->delete(); // Elimina los feedbacks asociados

            // Eliminar la pregunta
            $pregunta->delete();

            return redirect()->route('forms.index')->with('success', 'Pregunta eliminada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al eliminar Pregunta: ' . $e->getMessage());
        }
    }





}



