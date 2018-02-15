<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    //
	protected $table = 'asistencias';

    public function tiempos()
    {
        return $this->hasMany('App\Tiempo');
    }

	//LLAVES FORANEAS
	public function agenda()
    {
        return $this->belongsTo('App\Agenda');
    }
	
	public function asambleista()
    {
        return $this->belongsTo('App\Asambleista');
    }

    

}
