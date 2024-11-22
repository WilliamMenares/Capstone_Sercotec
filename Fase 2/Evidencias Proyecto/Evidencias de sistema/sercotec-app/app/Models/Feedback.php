<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pregunta',
        'id_tipo',
        'situacion',
        'accion1',
        'accion2',
        'accion3',
        'accion4'
    ];

    public function pregunta()
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta');
    }
}