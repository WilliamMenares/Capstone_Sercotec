<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = ['codigo', 'rut', 'nombre', 'email', 'contacto'];
    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'id_empresa');
    }
}
