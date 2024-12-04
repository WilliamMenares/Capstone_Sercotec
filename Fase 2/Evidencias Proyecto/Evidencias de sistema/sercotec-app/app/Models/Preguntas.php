<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = ['title', 'ambito_id', 'prioridad'];

    public function ambito()
    {
        return $this->belongsTo(Ambitos::class,'ambito_id'); // La pregunta pertenece a un ambito
    }
     // Relación con Feedback
     public function feedbacks()
     {
         return $this->hasMany(Feedback::class, 'pregunta_id'); // Una pregunta tiene muchos feedbacks
     }

     public function respuesta()
     {
         return $this->hasMany(Respuestas::class, 'pregunta_id'); // Una pregunta tiene muchos feedbacks
     }
}
