<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    //
    public $timestamps=true;
    protected $fillable = ['fecha_creacion','fecha_envio','fecha_recepcion','fecha_respuesta_final','estado_id','empresa_id'];
}
