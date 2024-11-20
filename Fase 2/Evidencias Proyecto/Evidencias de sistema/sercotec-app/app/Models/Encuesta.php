<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    protected $table = 'encuestas';

    protected $fillable = ['id', 'responsable', 'id_formulario', 'id_empresa'];

    // Una Encuesta pertenece a un Formulario
    public function formulario()
    {
        return $this->belongsTo(Formularios::class, 'id_formulario');
    }

    // Una Encuesta pertenece a una Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa'); // Asumiendo que tienes un modelo Empresa
    }
}
