<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('formulario_ambito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulario_id')->constrained('formularios');
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_ambito');
    }
};
