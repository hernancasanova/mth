<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //
    protected $fillable = ['nombre_usuario','contraseña','api_token'];
    //protected $table='usuarios';
}
