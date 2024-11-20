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

    public function getemps()
    {
        $empresas = Empresa::all(); // O el modelo que uses
        return response()->json($empresas);
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'codigo' => 'required|string|max:50|unique:empresas,codigo',
                'rut' => 'required|string|max:12|unique:empresas,rut',
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:empresas,email',
                'contacto' => 'required|string|max:50',
            ]);

            // Crear la nueva empresa
            Empresa::create($validatedData);

            return redirect()->route('empresa.index')->with('success', 'Empresa creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la empresa: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Buscar la empresa por su ID
            $empresa = Empresa::findOrFail($id);

            // Validar los datos de entrada
            $validatedData = $request->validate([
                'codigo' => 'required|string|max:50|unique:empresas,codigo,' . $empresa->id,
                'rut' => 'required|string|max:12|unique:empresas,rut,' . $empresa->id,
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:empresas,email,' . $empresa->id,
                'contacto' => 'required|string|max:50',
            ]);

            // Actualizar los datos de la empresa
            $empresa->update($validatedData);

            return redirect()->route('empresa.index')->with('success', 'Empresa actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la empresa: ' . $e->getMessage());
        }
    }




    public function destroy($id)
    {
        try {
            // Buscar la empresa
            $empresa = Empresa::with('encuestas')->findOrFail($id);

            // Verificar si la empresa tiene encuestas asociadas
            if ($empresa->encuestas->isNotEmpty()) {
                return redirect()->back()->with('error', 'No se puede eliminar la empresa porque está asociada a una o más encuestas.');
            }

            // Eliminar la empresa
            $empresa->delete();

            return redirect()->route('empresa.index')->with('success', 'Empresa eliminada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al eliminar la empresa: ' . $e->getMessage());
        }
    }


}
