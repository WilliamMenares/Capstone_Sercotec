<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::insert([
            [
                'codigo' => 'Sin Asignar',
                'rut' => '20880577-0',
                'nombre' => 'Meniaz',
                'email' => 'williammenares0@gmail.com',
                'contacto' => 'William Alexander Menares Diaz'
            ]

        ]);
    }
}
