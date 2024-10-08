<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id'); // Definir el campo como string
            $table->string('rut'); // Definir el campo como string
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono');
            $table->timestamps(); // Esto crea created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropTimestamps();  // Eliminar los campos en caso de rollback
        });
    }
};
