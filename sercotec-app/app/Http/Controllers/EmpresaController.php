<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Log;

class EmpresaController extends Controller
{
    public function index()
    {
        // Paginar con 6 registros por página
        $empresas = Empresa::orderBy('id', 'desc')->get();

        return view("empresa")->with("empresas", $empresas);
    }


    // Función para agregar una empresa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut' => 'required|string|max:255',  // Formato para RUT
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Validar formato de correo
            'telefono' => 'required|string|max:255', // Formato requerido: +56 seguido de 9 dígitos
            
        ]);


        Empresa::create([
            'rut' => $validatedData['rut'],
            'email' => $validatedData['email'],
            'telefono' => $validatedData['telefono'],
            'nombre' => $validatedData['nombre'],
        ]);


        return redirect()->route('empresa.index')->with(
            'status',
            'Empresa creada exitosamente'
        );
    }

    // Función para actualizar una empresa
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rut' => 'required|string|max:255',  // Formato para RUT
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Validar formato de correo
            'telefono' => 'required|string|max:255', // Formato requerido: +56 seguido de 9 dígitos
            
        ]);

        // Encontrar la empresa por ID
        $empresa = Empresa::findOrFail($id);

        // Actualizar solo los campos proporcionados
        $empresa->update(array_filter([
            'rut' => $validatedData['rut'] ?? $empresa->rut,
            'email' => $validatedData['email'] ?? $empresa->email,
            'telefono' => $validatedData['telefono'] ?? $empresa->telefono,
            'nombre' => $validatedData['nombre'] ?? $empresa->nombre,
        ]));

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
