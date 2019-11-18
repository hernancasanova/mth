<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    //
    public $timestamps=true;
     protected $fillable = ['nombre_estado'];
}
