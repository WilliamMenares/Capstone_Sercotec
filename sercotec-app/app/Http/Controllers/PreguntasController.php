<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{


    // Función para agregar un usuario
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'id_ambito' => 'required|integer',
            ]);

            Preguntas::create([
                'title' => $request->title,
                'id_ambito' => $request->id_ambito,
            ]);

            return redirect()->route('forms.index')->with(
                'success',
                'Pregunta registrado exitosamente'
            );
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al registrar Pregunta: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pregunta = Preguntas::findOrFail($id);

            $request->validate([
                'nombrep' => 'required|string|max:255',
                'id_ambito' => 'required|integer'
            ]);

            $pregunta->title = $request->nombrep;
            $pregunta->id_ambito = $request->id_ambito;

            $pregunta->save();

            return redirect()->route('forms.index')->with('success', 'Ambito actualizado con éxito');
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al actualizar Pregunta: ' . $e->getMessage());
        }
    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        $pregunta = Preguntas::findOrFail($id);
        $pregunta->delete();
        return redirect()->route('forms.index')->with('success', 'Pregunta eliminado con éxito.');
    }

}



