<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasTipo extends Model
{
    use HasFactory;

    protected $table = 'respuestas_tipo';

    protected $fillable = ['id','titulo'];
}
