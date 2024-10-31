<?php

namespace App\Http\Controllers;

use App\Models\Formularios;
use Illuminate\Http\Request;

class FormulariosController extends Controller
{
    // Guardar un nuevo formulario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'ambitos' => 'required|array', // Validar que se seleccionen ámbitos
            'ambitos.*' => 'integer|exists:ambitos,id' // Validar cada ID de ámbito
        ]);

        // Crear el formulario
        $formulario = Formularios::create([
            'nombre' => $request->nombre,
            'responsable' => $request->responsable,
        ]);

        // Asociar los ámbitos seleccionados
        $formulario->ambitos()->attach($request->ambitos);

        return redirect()->route('forms.index')->with('success', 'Formulario creado correctamente.');
    }


    // Actualizar un formulario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'ambitos' => 'required|array'
        ]);

        // Encontrar el formulario y actualizarlo
        $formulario = Formularios::findOrFail($id);
        $formulario->update([
            'nombre' => $request->nombre,
            'responsable' => $request->responsable,
        ]);

        // Sincronizar los ámbitos seleccionados
        $formulario->ambitos()->sync($request->ambitos);

        return redirect()->route('forms.index')->with('success', 'Formulario actualizado correctamente.');
    }

    // Eliminar un formulario
    public function destroy($id)
    {
        $formulario = Formularios::findOrFail($id);

        // Desvincular todos los ámbitos antes de eliminar
        $formulario->ambitos()->detach();
        $formulario->delete();

        return redirect()->route('forms.index')->with('success', 'Formulario eliminado correctamente.');
    }
}
