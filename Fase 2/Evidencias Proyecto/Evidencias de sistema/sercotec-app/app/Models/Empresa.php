<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = ['codigo', 'rut', 'nombre', 'email', 'contacto'];

    public function encuesta()
    {
        return $this->hasMany(Encuesta::class); // Una empres puede tener varias encuestas
    }
}
