<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        // Paginar con 7 registros por página
        $usuarios = User::orderBy('id', 'desc')->get();

        return view("user")->with("usuarios", $usuarios); 
    }

    // Función para agregar un usuario
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'telefono' => 'required|string|max:12',
                'rut' => 'required|string|max:10|unique:users',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'rut' => $request->rut,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user.index')->with(
                'success',
                'Asesor registrado exitosamente'
            );
        } catch (\Exception $e) {
            // Depuración de errores
            return redirect()->back()->with('error', 'Error al registrar Asesor: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $empleado = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'telefono' => 'required|string|max:255',
            'rut' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $empleado->name = $request->name;
        $empleado->email = $request->email;
        $empleado->telefono = $request->telefono;
        $empleado->rut = $request->rut;

        if ($request->filled('password')) {
            $empleado->password = Hash::make($request->password);
        }

        $empleado->save();

        return redirect()->route('user.index')->with('success', 'Asesor actualizado con éxito');
    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Asesor eliminado con éxito.');
    }
    
}



