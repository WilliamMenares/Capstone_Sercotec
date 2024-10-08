<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $datos_empresa = Empresa::orderBy('id', 'desc')->get();;
        return view("empresa")->with("datos_empresa", $datos_empresa);
    }


    // Función para agregar una empresa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'telefono' => 'required|string|max:12',
        ]);

        Empresa::create($validatedData);

        return redirect()->route('empresa.index')->with(
            'status',
            'Empresa creada exitosamente'
        );
    }



    // Función para actualizar una empresa
    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20', 
            'rut' => 'required|string|max:12', 
        ]);

        // Encontrar la empresa por ID
        $empresa = Empresa::findOrFail($id);

        // Actualizar la información de la empresa
        $empresa->nombre = $request->input('nombre');
        $empresa->email = $request->input('email');
        $empresa->telefono = $request->input('telefono');
        $empresa->rut = $request->input('rut');

        // Guardar los cambios
        $empresa->save();

        // Redirigir o devolver respuesta
        return redirect()->route('empresa.index')->with('status', 'Empresa actualizada correctamente.');
    }



    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return redirect()->route('empresa.index')->with('status', 'Empresa eliminada con éxito');
    }

    
}
