<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Clave primaria de la tabla
            $table->foreignId('pregunta_id')->constrained('preguntas'); // Clave foránea de Preguntas
            $table->foreignId('respuestas_tipo_id')->constrained('respuestas_tipo'); // Clave foránea de RespuestasTipo
            $table->string('situacion');
            $table->string('accion1');
            $table->string('accion2');
            $table->string('accion3');
            $table->string('accion4');
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};
