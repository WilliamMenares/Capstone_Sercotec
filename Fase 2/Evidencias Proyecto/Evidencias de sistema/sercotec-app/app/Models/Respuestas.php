<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    use HasFactory;

    protected $table = 'respuestas';

    protected $fillable = ['id', 'id_tipo','id_encuesta', 'id_pregunta'];

    // Relación con Encuesta

    // Relación con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta');
    }

    // Relación con RespuestasTipo
    public function tipo()
    {
        return $this->belongsTo(RespuestasTipo::class, 'id_tipo');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuestas::class, 'id_encuesta');
    }
}
