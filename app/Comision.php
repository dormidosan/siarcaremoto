<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    //
	protected $table = 'comisiones';
	public $timestamps = true;

	public function peticiones()
    {
        return $this->belongsToMany('App\Peticion','comision_peticion')->withTimestamps();
    }
	
	public function cargos()
    {
        return $this->hasMany('App\Cargo');
    }
	
	public function reuniones()
    {
        return $this->hasMany('App\Reunion');
    }
	
	public function seguimientos()
    {
        return $this->hasMany('App\Seguimiento');
    }

}
