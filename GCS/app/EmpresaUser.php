<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaUser extends Model
{
	protected $table = 'empresa_user';
    public $timestamps=false;
    protected $fillable = ['empresa_id','user_id'];
}
