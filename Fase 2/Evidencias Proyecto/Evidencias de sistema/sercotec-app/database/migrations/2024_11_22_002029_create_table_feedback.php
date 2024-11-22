<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('cascade');
            $table->foreignId('id_tipo');
            $table->text('situacion')->nullable();
            $table->text('accion1')->nullable();
            $table->text('accion2')->nullable();
            $table->text('accion3')->nullable();
            $table->text('accion4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_feedback');
    }
};
