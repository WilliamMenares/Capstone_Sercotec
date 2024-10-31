<?php

namespace App\Http\Controllers;

use App\Models\Ambitos;
use App\Models\Formularios;
use App\Models\Preguntas;
use Illuminate\Http\Request;

class AmbitoController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        $ambitos = Ambitos::orderBy('id', 'desc')->get();
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        $formularios = Formularios::with('ambitos')->get();
        return view("forms", compact('preguntas', 'ambitos','formularios'));
    }

    // Función para agregar un usuario
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255'
            ]);

            Ambitos::create([
                'title' => $request->title,
            ]);

            return redirect()->route('forms.index')->with(
                'success',
                'Ambito registrado exitosamente'
            );
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al registrar Ambito: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $ambito = Ambitos::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $ambito->title = $request->title;

        $ambito->save();

        return redirect()->route('forms.index')->with('success', 'Ambito actualizado con éxito');
    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        $ambito = Ambitos::findOrFail($id);
        $ambito->delete();
        return redirect()->route('forms.index')->with('success', 'Ambito eliminado con éxito.');
    }

}



