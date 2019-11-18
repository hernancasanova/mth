<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actualizacion extends Model
{
    protected $table = 'actualizaciones';
    public $timestamps=true;
    protected $fillable=['user_id','estado_id','caso_id','comentario','fecha_modificacion','created_at','updated_at'];
}
