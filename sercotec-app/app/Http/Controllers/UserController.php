<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Muestra el listado de usuarios con paginación
    public function index()
    {
        // Paginar con 7 registros por página
        $datos_user = User::orderBy('id', 'desc')->paginate(7);

        return view("user")->with("datos_user", $datos_user); 
    }

    // Función para agregar un usuario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'El campo "Nombre" es obligatorio.',
            'email.required' => 'El campo "Email" es obligatorio.',
            'email.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'email.unique' => 'Este email ya está en uso.',
            'password.required' => 'El campo "Contraseña" es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crea el usuario
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('user.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8', // La contraseña es opcional
        ], [
            'name.required' => 'El campo "Nombre" es obligatorio.',
            'email.required' => 'El campo "Email" es obligatorio.',
            'email.email' => 'El formato del correo debe ser válido: ejemplo@correo.com',
            'email.unique' => 'Este email ya está en uso.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = User::findOrFail($id); // Obtener el usuario

        // Actualizar solo los campos proporcionados
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        $mensaje = 'Usuario actualizado correctamente.'; 

        // Actualizar la contraseña solo si se proporciona
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password')); // Actualiza la contraseña si se provee
            $mensaje .= ' Contraseña editada correctamente.'; // Añadir mensaje de éxito solo si se cambió la contraseña
        }

        $user->save();

        // Enviar solo un mensaje con el método with
        return redirect()->route('user.index')->with('success', $mensaje);
    }


    // Función para eliminar un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Usuario eliminado con éxito.');
    }
    
}



