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


        RespuestasTipo::create([
            'titulo' => 'Cumple',
            'puntaje' => 5,
        ]);
        RespuestasTipo::create([
            'titulo' => 'Cumple Parcialmente',
            'puntaje' => 3,
        ]);
        RespuestasTipo::create([
            'titulo' => 'No Cumple',
            'puntaje' => 1,
        ]);
    }
}
