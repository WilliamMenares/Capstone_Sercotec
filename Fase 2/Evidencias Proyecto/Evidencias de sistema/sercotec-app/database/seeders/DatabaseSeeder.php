<?php

namespace Database\Seeders;

use App\Models\RespuestasTipo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

        // Llamar a otros seeders
        $this->call([
            UserSeeder::class,      // Llamar al seeder de usuarios
            FormulariosSeeder::class,   // Llamar al seeder de productos
            EmpresasSeeder::class
        ]);

    }
}
