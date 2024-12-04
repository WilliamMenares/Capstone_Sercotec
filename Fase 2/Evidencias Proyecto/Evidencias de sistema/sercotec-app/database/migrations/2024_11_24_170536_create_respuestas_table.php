<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encuesta_id')->constrained('encuestas'); // Clave foránea a encuestas
            $table->foreignId('pregunta_id')->constrained('preguntas'); // Clave foránea a preguntas
            $table->foreignId('respuestatipo_id')->constrained('respuestas_tipo'); // Clave foránea a respuestas_tipo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
};
