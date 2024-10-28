<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambitos extends Model
{
    use HasFactory;

    protected $table = 'ambitos';

    protected $fillable = ['title'];

    // Define la relación con Preguntas
    public function preguntas()
    {
        return $this->hasMany(Preguntas::class, 'id_ambito'); // 'id_ambito' es la clave foránea en Preguntas
    }
}
