<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Log;

class EmpresaController extends Controller
{
    public function index()
    {
        // Contar la cantidad de empresas
    $cantidadEmpresas = Empresa::count(); // Contar todas las empresas

    // Paginar con 6 registros por página
    $datos_empresa = Empresa::orderBy('id', 'desc')->paginate(6);

    // Pasar la cantidad de empresas y los datos paginados a la vista
    return view("empresa")->with([
        "datos_empresa" => $datos_empresa,
        "cantidadEmpresas" => $cantidadEmpresas // Pasar la cantidad a la vista
    ]);
    }

    // Función para agregar una empresa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut_agregar' => [
                'required',
                'regex:/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]{1}$/',  // Formato para RUT
            ],
            'nombre_agregar' => 'required|string|max:255',
            'email_agregar' => 'required|email|max:255', // Validar formato de correo
            'telefono_agregar' => [
                'required',
                'regex:/^\+56\d{9}$/', // Formato requerido: +56 seguido de 9 dígitos
            ],
        ], [
            'rut_agregar.required' => 'El campo "Rut de la empresa" no puede estar vacío',
            'rut_agregar.regex' => 'El RUT debe contener punto y guión el formato es: 11.111.111-1',
            'nombre_agregar.required' => 'El campo "Nombre de la empresa" no puede estar vacío',
            'email_agregar.required' => 'El campo "Email de la empresa" no puede estar vacío',
            'email_agregar.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'telefono_agregar.required' => 'El campo "Telefono de la empresa" no puede estar vacío',
            'telefono_agregar.regex' => 'El número de teléfono debe estar en el formato +56XXXXXXXXX, con 9 dígitos después del +56.',
        ]);


        Empresa::create([
            'rut' => $validatedData['rut_agregar'],
            'email' => $validatedData['email_agregar'],
            'telefono' => $validatedData['telefono_agregar'],
            'nombre' => $validatedData['nombre_agregar'],
        ]);


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
            'nombre_editar' => 'nullable|string|max:255',
            'email_editar' => 'nullable|email|max:255', // Validar formato de correo
            'telefono_editar' => [
                'nullable',
                'regex:/^\+56\d{9}$/', // Formato requerido: +56 seguido de 9 dígitos
            ],
            'rut_editar' => [
                'nullable',
                'regex:/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]{1}$/',  // Formato para RUT
            ],
        ], [
            'rut_editar.regex' => 'El RUT debe contener punto y guión el formato es: 11.111.111-1',
            'email_editar.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'telefono_editar.regex' => 'El número de teléfono debe estar en el formato +56XXXXXXXXX, con 9 dígitos después del +56.'
        ]);

        // Encontrar la empresa por ID
        $empresa = Empresa::findOrFail($id);

        // Actualizar solo los campos proporcionados
        $empresa->update(array_filter([
            'rut' => $validatedData['rut_editar'] ?? $empresa->rut,
            'email' => $validatedData['email_editar'] ?? $empresa->email,
            'telefono' => $validatedData['telefono_editar'] ?? $empresa->telefono,
            'nombre' => $validatedData['nombre_editar'] ?? $empresa->nombre,
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
