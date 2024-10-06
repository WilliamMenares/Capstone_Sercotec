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
            $table->increments('rut_empresa'); // PK autoincrementable
            $table->string('nombre_empresa');
            $table->string('email_empresa');
            $table->string('telefono_empresa');
            $table->timestamp('fecha_creacion_empresa')->default(DB::raw('CURRENT_TIMESTAMP')); // fecha de creación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
