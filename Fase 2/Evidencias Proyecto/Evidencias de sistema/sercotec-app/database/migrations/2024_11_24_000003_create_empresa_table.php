<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo'); // Agregamos la columna para el código de la empresa
            $table->string('rut')->unique();    // Agregamos la columna para el RUT de la empresa
            $table->string('nombre');           // Nombre de la empresa
            $table->string('email')->nullable(); // Correo de la empresa, puede ser nulo
            $table->string('contacto')->nullable(); // Contacto de la empresa, puede ser nulo
            $table->timestamps();               // Registra las fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
