<?php

namespace App\Http\Controllers;

use App\Models\Ambitos;
use App\Models\Formularios;
use App\Models\Preguntas;
use App\Models\RespuestasTipo;
use Illuminate\Http\Request;

class AmbitoController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        $ambitos = Ambitos::orderBy('id', 'desc')->get();
        $preguntas = Preguntas::with('ambito')->orderBy('id', 'desc')->get();
        $formularios = Formularios::with('ambitos')->get();
        $restipo = RespuestasTipo::orderBy('id', 'desc')->get();
        return view("forms", compact('preguntas', 'ambitos', 'formularios', 'restipo'));
    }

    public function getambis()
    {
        $ambitos = Ambitos::all(); // O el modelo que uses
        return response()->json($ambitos);
    }

    // Función para agregar un usuario
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255'
            ], [
                'title.required' => 'El ambito es obligatorio.',
                'title.string' => 'El ambito debe ser una cadena de texto.',
                'title.max' => 'El ambito no debe exceder los 255 caracteres.',

            
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
        ], [
            'title.required' => 'El ambito es obligatorio.',
            'title.string' => 'El ambito debe ser una cadena de texto.',
            'title.max' => 'El ambito no debe exceder los 255 caracteres.',

        
        ]);

        $ambito->title = $request->title;

        $ambito->save();

        return redirect()->route('forms.index')->with('success', 'Ambito actualizado con éxito');
    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        $ambito = Ambitos::findOrFail($id);

        // Verificar si el ámbito tiene preguntas asociadas
        if ($ambito->preguntas()->count() > 0) {
            return redirect()->route('forms.index')
                ->with('error', 'No se puede eliminar el ámbito porque tiene preguntas enlazadas.');
        }

        // Verificar si el ámbito tiene formularios asociados
        if ($ambito->formularios()->count() > 0) {
            return redirect()->route('forms.index')
                ->with('error', 'No se puede eliminar el ámbito porque tiene formularios enlazados.');
        }

        $ambito->delete();
        return redirect()->route('forms.index')->with('success', 'Ámbito eliminado con éxito.');
    }


}



