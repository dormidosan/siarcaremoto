<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
	protected $table = 'cargos';
	
	/* ***************************************
	public function reuniones()
    {
        return $this->belongsToMany('App\Cargo','presentes')->withTimestamps();
    } 
	//**************************************** */

    public function presentes()
    {
        return $this->hasMany('App\Presente');
    }
    
	

    //LLAVES FORANEAS
	public function comision()
    {
        return $this->belongsTo('App\Comision');
    }
	
	public function asambleista()
    {
        return $this->belongsTo('App\Asambleista');
    }

}
