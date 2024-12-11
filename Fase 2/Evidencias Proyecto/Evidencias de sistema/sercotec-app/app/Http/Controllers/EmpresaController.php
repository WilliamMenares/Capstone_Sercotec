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
            ], [
                'codigo.required' => 'El código es obligatorio.',
                'codigo.string' => 'El código debe ser una cadena de texto.',
                'codigo.max' => 'El código no puede tener más de 50 caracteres.',
                'codigo.unique' => 'El código ya está registrado en el sistema.',
            
                'rut.required' => 'El RUT es obligatorio.',
                'rut.string' => 'El RUT debe ser una cadena de texto.',
                'rut.max' => 'El RUT no puede tener más de 12 caracteres.',
                'rut.unique' => 'El RUT ya está registrado en el sistema.',
            
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe tener un formato válido.',
                'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
                'email.unique' => 'El correo electrónico ya está registrado en el sistema.',
            
                'contacto.required' => 'El contacto es obligatorio.',
                'contacto.string' => 'El contacto debe ser una cadena de texto.',
                'contacto.max' => 'El contacto no puede tener más de 50 caracteres.',
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
                'rut' => 'required|string|max:12|unique:empresas,rut,' . $empresa->id,
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:empresas,email,' . $empresa->id,
                'contacto' => 'required|string|max:50',
            ], [
                
            
                'rut.required' => 'El RUT es obligatorio.',
                'rut.string' => 'El RUT debe ser una cadena de texto.',
                'rut.max' => 'El RUT no puede tener más de 12 caracteres.',
                'rut.unique' => 'El RUT ya está registrado en el sistema.',
            
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe tener un formato válido.',
                'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
                'email.unique' => 'El correo electrónico ya está registrado en el sistema.',
            
                'contacto.required' => 'El contacto es obligatorio.',
                'contacto.string' => 'El contacto debe ser una cadena de texto.',
                'contacto.max' => 'El contacto no puede tener más de 50 caracteres.',
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
            $empresa = Empresa::with('encuesta')->findOrFail($id);

            // Verificar si la empresa tiene encuestas asociadas
            if ($empresa->encuesta->isNotEmpty()) {
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
