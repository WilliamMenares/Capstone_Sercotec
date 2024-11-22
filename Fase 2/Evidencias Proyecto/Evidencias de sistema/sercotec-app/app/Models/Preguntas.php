<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = ['title', 'id_ambito', 'puntaje'];

    // Definimos la relación con Ambitos
    public function ambito()
    {
        return $this->belongsTo(Ambitos::class, 'id_ambito');
    }
    public function respuestas()
    {
        return $this->hasMany(Respuestas::class, 'id_pregunta');
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_pregunta');
    }
}
