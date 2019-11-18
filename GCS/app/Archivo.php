<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    //
    public $timestamps=true;
    protected $fillable=['nombre_original','nombre_fisico','ruta_fisica', 'actualizacion_id','tiposarchivo_id','created_at','updated_at'];
}
