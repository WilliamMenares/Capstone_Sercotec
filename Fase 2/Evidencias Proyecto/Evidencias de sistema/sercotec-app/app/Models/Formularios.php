<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formularios extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'responsable'];

    public function ambitos()
    {
        return $this->belongsToMany(Ambitos::class, 'ambito_formulario');
    }
}
