<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    use HasFactory;

    protected $table = 'respuestas';

    protected $fillable = ['encuesta_id', 'pregunta_id', 'respuestatipo_id']; 

    // Relación con Encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class );
    }

    // Relación con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Preguntas::class);
    }


    public function respuestasTipo()
{
    return $this->belongsTo(RespuestasTipo::class, 'respuestatipo_id'); // Asegúrate de especificar el campo correctamente
}


}
