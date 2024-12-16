<?php

namespace App\Http\Controllers;

use App\Models\Ambitos;
use App\Models\Formularios;
use Illuminate\Http\Request;

class FormulariosController extends Controller
{

    public function getformu()
    {
        $formularios = Formularios::with('ambito', 'user')->get();// O el modelo que uses
        return response()->json($formularios);
    }

    // Guardar un nuevo formulario en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'ambitos' => 'required|array|min:1',
            'ambitos.*' => 'exists:ambitos,id'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre tiene que tener máximo 255 caracteres.',

            'responsable.required' => 'El responsable es obligatorio.',
            'responsable.string' => 'El responsable debe ser una cadena de texto.',
            'responsable.max' => 'El responsable tiene que tener máximo 255 caracteres.',

            'ambitos.required' => 'El ámbito es obligatorio.',
            'ambitos.array' => 'El ámbito debe ser una lista.',
            'ambitos.*.exists' => 'El ámbito seleccionado no es válido.'
        ]);

        // Validar que cada ámbito tenga preguntas asociadas
        $ambitosSinPreguntas = Ambitos::whereIn('id', $validated['ambitos'])
            ->doesntHave('pregunta')
            ->pluck('title');

        if ($ambitosSinPreguntas->isNotEmpty()) {
            return back()->withErrors([
                'ambitos' => 'Algunos ámbitos seleccionados no tienen preguntas asociadas: '
                    . $ambitosSinPreguntas->implode(', ')
            ])->withInput();
        }

        try {
            // Crear el formulario
            $formulario = Formularios::create([
                'nombre' => $validated['nombre'],
                'user_id' => $validated['responsable'],
            ]);

            // Asociar los ámbitos seleccionados
            $formulario->ambito()->attach($validated['ambitos']);

            return redirect()->route('forms.index')
                ->with('success', 'Formulario creado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear formulario: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el formulario.')
                ->withInput();
        }
    }



    // Actualizar un formulario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ], [
            'nombre.required' => 'El pregunta es obligatorio.',
            'nombre.string' => 'El pregunta debe ser una cadena de texto.',
            'nombre.max' => 'El nombre tiene que tener maximo 255 caracteres',


        ]);

        // Encontrar el formulario y actualizarlo
        $formulario = Formularios::findOrFail($id);
        $formulario->update([
            'nombre' => $request->nombre
        ]);


        return redirect()->route('forms.index')->with('success', 'Formulario actualizado correctamente.');
    }

    // Eliminar un formulario
    public function destroy($id)
    {
        $formulario = Formularios::findOrFail($id);

        // Verificar si existen encuestas asociadas al formulario
        if ($formulario->encuesta()->count() > 0) {
            return redirect()->route('forms.index')->with('error', 'No se puede eliminar el formulario, ya que está asociado a una o más encuestas.');
        }

        // Desvincular todos los ámbitos antes de eliminar
        $formulario->ambito()->detach();
        $formulario->delete();

        return redirect()->route('forms.index')->with('success', 'Formulario eliminado correctamente.');
    }

}
