<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Clave foránea a la tabla users
            $table->foreignId('formulario_id')->constrained('formularios'); // Clave foránea a la tabla formularios
            $table->foreignId('empresa_id')->constrained('empresas'); // Clave foránea a la tabla empresas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('encuestas');
    }
};