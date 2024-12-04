<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasTipo extends Model
{
    use HasFactory;

    protected $table = 'respuestas_tipo';

    protected $fillable = ['titulo', 'puntaje'];

    // Relación con Respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuestas::class, 'respuestatipo_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'respuestas_tipo_id');
    }
}
