<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $fillable = [
        'pregunta_id',
        'respuestas_tipo_id',  // Vinculamos Feedback con RespuestaTipo
        'situacion',
        'accion1',
        'accion2',
        'accion3',
        'accion4'
    ];

    // Relación con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Preguntas::class);
    }

    // Relación con RespuestaTipo
    public function respuestatipo()
    {
        return $this->belongsTo(RespuestasTipo::class);
    }
}
