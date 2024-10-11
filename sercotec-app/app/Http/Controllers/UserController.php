<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Paginar con 7 registros por página
        $datos_user = User::orderBy('id', 'desc')->paginate(7); 
        
        return view("user")->with("datos_user", $datos_user); // Cambiar vista a "user"
    }

     // Función para agregar un usuario
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:8|confirmed',
         ]);
 
         // Crea el usuario
         $user = User::create([
             'name' => $validatedData['name'],
             'email' => $validatedData['email'],
             'password' => bcrypt($validatedData['password']), 
         ]);
 
         // Redirigir con mensaje de éxito
         return redirect()->route('user.index')->with('success', 'Usuario creado exitosamente.');
     }
 
     // Función para actualizar un usuario
     public function update(Request $request, $id)
     {
         // Validar los datos entrantes
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|max:255|unique:users,email,' . $id, // Validar email único excluyendo el actual
         ]);
 
         // Encontrar el usuario por ID
         $user = User::findOrFail($id);
 
         // Actualizar la información del usuario
         $user->name = $request->input('name');
         $user->email = $request->input('email');
 
         // Guardar los cambios
         $user->save();
 
         // Redirigir con mensaje de éxito
         return redirect()->route('user.index')->with('success', 'Usuario actualizado correctamente.');
     }
 
     // Función para eliminar un usuario
     public function destroy($id)
     {
         $user = User::findOrFail($id);
         $user->delete();
         return redirect()->route('user.index')->with('success', 'Usuario eliminado con éxito.');
     }
 }
