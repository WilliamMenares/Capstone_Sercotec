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

    public function getusers()
    {
        $usuarios = User::where('id', '!=', 0)->get();
        return response()->json($usuarios);

    }
    // Función para agregar un usuario
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|min:12|max:12',
            'rut' => 'required|string|max:10|unique:users',
            'rol' => 'required|integer',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.min' => 'El teléfono debe tener 12 caracteres como mínimo.',
            'telefono.max' => 'El teléfono no debe exceder los 12 caracteres.',

            'rut.required' => 'El RUT es obligatorio.',
            'rut.string' => 'El RUT debe ser una cadena de texto.',
            'rut.max' => 'El RUT no debe exceder los 10 caracteres.',
            'rut.unique' => 'Este RUT ya está registrado.',

            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rut' => $request->rut,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with(
            'success',
            'Asesor registrado exitosamente'
        );

    }

    public function update(Request $request, $id)
    {

        $empleado = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'telefono' => 'required|string|min:12|max:12',
            'rut' => 'required|string|max:10|unique:users,rut,' . $id,
            'rol' => 'required|integer',
            'password' => ['nullable', 'confirmed', 'min:8', Password::defaults()]
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.min' => 'El teléfono debe tener 12 caracteres como mínimo.',
            'telefono.max' => 'El teléfono no debe exceder los 12 caracteres.',

            'rut.required' => 'El RUT es obligatorio.',
            'rut.string' => 'El RUT debe ser una cadena de texto.',
            'rut.max' => 'El RUT no debe exceder los 10 caracteres.',
            'rut.unique' => 'Este RUT ya está registrado.',

            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $empleado->name = $request->name;
        $empleado->email = $request->email;
        $empleado->telefono = $request->telefono;
        $empleado->rut = $request->rut;
        $empleado->rol = $request->rol;

        if ($request->filled('password')) {
            $empleado->password = Hash::make($request->password);
        }

        $empleado->save();

        return redirect()->route('user.index')->with('success', 'Asesor actualizado con éxito');

    }

    // Función para eliminar un usuario
    public function destroy($id)
    {
        // Buscar al usuario a eliminar
        $user = User::findOrFail($id);

        // Reasignar los formularios asociados al usuario con id = 0
        if ($user->formularios()->exists()) {
            $user->formularios()->update(['user_id' => 0]);
        }

        // Reasignar las encuestas asociadas al usuario con id = 0
        if ($user->encuestas()->exists()) {
            $user->encuestas()->update(['user_id' => 0]);
        }

        // Eliminar al usuario una vez que las relaciones se han reasignado
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Asesor eliminado con éxito y sus relaciones han sido reasignadas.');
    }



}



