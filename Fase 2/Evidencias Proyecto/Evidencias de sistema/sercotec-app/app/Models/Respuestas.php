<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    use HasFactory;

    protected $table = 'respuestas';

    protected $fillable = ['id','id_tipo', 'id_encuesta', 'id_pregunta'];
}
