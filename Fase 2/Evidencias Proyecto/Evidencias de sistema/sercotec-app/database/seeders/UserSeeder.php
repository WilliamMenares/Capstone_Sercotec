<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Administrador',
            'telefono' => '+56000000000',
            'rut' => '88888888-8',
            'rol' => 0,
            'email' => 'williammenares0@gmail.com',
            'email_verified_at' => null, // O puedes poner la fecha de verificación si ya la tienes
            'password' => Hash::make('adminadmin'), // Contraseña hasheada
            'remember_token' => Str::random(60), // Esto genera un token aleatorio
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}