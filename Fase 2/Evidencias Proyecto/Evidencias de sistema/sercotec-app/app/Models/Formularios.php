<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formularios extends Model
{
    use HasFactory;

    protected $table = 'formularios';

    protected $fillable = ['nombre', 'user_id'];

    // Modelo Formulario.php
    public function user()
    {
        return $this->belongsTo(User::class); // El formulario pertenece a un usuario
    }

    // Modelo Formulario.php
    public function ambito()
    {
        return $this->belongsToMany(Ambitos::class, 'formulario_ambito', 'formulario_id', 'ambito_id');
    }

    public function encuesta()
    {
        return $this->hasMany(Encuesta::class, 'formulario_id'); // Un formulario puede estar en varias encuestas
    }

}
