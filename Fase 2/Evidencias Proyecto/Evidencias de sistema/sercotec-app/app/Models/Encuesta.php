<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    protected $table = 'encuestas';

    protected $fillable = ['user_id', 'formulario_id', 'empresa_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class); // La encuesta pertenece a una empresa
    }

    public function user()
    {
        return $this->belongsTo(User::class); // La encuesta pertenece a un usuario
    }

    public function formulario()
    {
        return $this->belongsTo(Formularios::class, 'formulario_id'); // Una Encuesta tiene un Formulario
    }
}
