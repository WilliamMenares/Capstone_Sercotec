<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
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
            ]);

            // Verificar si ya existe una pregunta con el mismo puntaje en el mismo ámbito
            $existePregunta = Preguntas::where('id_ambito', $request->id_ambito)
                ->where('puntaje', $request->puntaje)
                ->exists();

            if ($existePregunta) {
                return redirect()->back()->with('error', 'Ya existe una pregunta con este puntaje en el mismo ámbito.');
            }

            // Crear la nueva pregunta
            Preguntas::create([
                'title' => $request->title,
                'id_ambito' => $request->id_ambito,
                'puntaje' => $request->puntaje,
            ]);

            return redirect()->route('forms.index')->with(
                'success',
                'Pregunta registrada exitosamente'
            );
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al registrar Pregunta: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $pregunta = Preguntas::findOrFail($id);

            $request->validate([
                'nombrep' => 'required|string',
                'id_ambito' => 'required|integer',
                'puntaje' => 'required|integer'
            ]);

            // Verificar si ya existe una pregunta con el mismo puntaje en el mismo ámbito
            $existePregunta = Preguntas::where('id_ambito', $request->id_ambito)
                ->where('puntaje', $request->puntaje)
                ->exists();

            if ($existePregunta) {
                return redirect()->back()->with('error', 'Ya existe una pregunta con este puntaje en el mismo ámbito.');
            }

            $pregunta->title = $request->nombrep;
            $pregunta->id_ambito = $request->id_ambito;
            $pregunta->puntaje = $request->puntaje;

            $pregunta->save();

            return redirect()->route('forms.index')->with('success', 'Pregunta actualizada con éxito');
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al actualizar Pregunta: ' . $e->getMessage());
        }
    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        try {
            // Obtener la pregunta con su ámbito relacionado
            $pregunta = Preguntas::with('ambito.formularios')->findOrFail($id);

            // Verificar si el ámbito de la pregunta está enlazado a algún formulario
            if ($pregunta->ambito->formularios->isNotEmpty()) {
                return redirect()->back()->with('error', 'No se puede eliminar la pregunta porque el ámbito está enlazado a un formulario.');
            }

            // Eliminar la pregunta
            $pregunta->delete();

            return redirect()->route('forms.index')->with('success', 'Pregunta eliminada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al eliminar Pregunta: ' . $e->getMessage());
        }
    }


}



