<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
	protected $table = 'roles';

	public function users()
    {
        return $this->hasMany('App\User');
    }

    
	public function modulos()
    {
        return $this->belongsToMany('App\Modulo','modulo_rol')->withTimestamps();
    }
    
    /*
    public function modulo_rol()
    {
        return $this->hasMany('App\ModuloRol');
    }
*/


}
