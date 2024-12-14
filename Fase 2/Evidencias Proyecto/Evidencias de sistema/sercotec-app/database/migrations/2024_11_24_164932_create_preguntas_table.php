<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->foreignId('ambito_id')->constrained('ambitos'); // Relación con ambitos
            $table->integer('prioridad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
};