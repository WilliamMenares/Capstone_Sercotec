<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        // Paginar con 6 registros por página
        $datos_empresa = Empresa::orderBy('id', 'desc')->paginate(6);

        return view("empresa")->with("datos_empresa", $datos_empresa);
    }

    // Función para agregar una empresa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut' => [
                'required',
                'regex:/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]{1}$/',  // Formato para RUT
            ],
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Validar formato de correo
            'telefono' => [
                'required',
                'regex:/^\+569\d{8}$/',  // Formato para teléfono chileno
            ],
        ], [
            'rut.required' => 'El campo "Rut de la empresa" no puede estar vacío',
            'rut.regex' => 'El RUT debe contener punto y guión (XX.XXX.XXX-X)',
            'nombre.required' => 'El campo "Nombre de la empresa" no puede estar vacío',
            'email.required' => 'El campo "Email de la empresa" no puede estar vacío',
            'email.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'telefono.required' => 'El campo "Telefono de la empresa" no puede estar vacío',
            'telefono.regex' => 'El formato del telefono debe ser: +569XXXXXXXX',
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
        $validatedData = $request->validate([
            'nombre' => 'string|max:255',
            'email' => 'email|max:255', // Validar formato de correo
            'telefono' => [
                'regex:/^\+569\d{8}$/',  // Formato para teléfono chileno
            ],
            'rut' => [
                'regex:/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]{1}$/',  // Formato para RUT
            ],
        ], [
            'rut.regex' => 'El RUT debe contener punto y guión (XX.XXX.XXX-X)',
            'email.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'telefono.regex' => 'El formato del telefono debe ser: +569XXXXXXXX',
        ]);

        // Encontrar la empresa por ID
        $empresa = Empresa::findOrFail($id);

        // Actualizar la información de la empresa
        $empresa->update($validatedData);

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
