<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambitos extends Model
{
    use HasFactory;

    protected $table = 'ambitos';

    protected $fillable = ['title'];

    public function formulario()
    {
        return $this->belongsToMany(Formularios::class, 'formulario_ambito', 'ambito_id', 'formulario_id');
    }

    public function pregunta()
    {
        return $this->hasMany(Preguntas::class, 'ambito_id'); // Un ambito puede tener varias preguntas
    }
}
