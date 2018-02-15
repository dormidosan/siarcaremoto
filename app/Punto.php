<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Punto extends Model
{
    //
	protected $table = 'puntos';

	public function intervenciones()
    {
        return $this->hasMany('App\Intervencion');
    }
	
	public function propuestas()
    {
        return $this->hasMany('App\Propuesta');
    }
	
    //LLAVES FORANEAS
	public function agenda()
    {
        return $this->belongsTo('App\Agenda');
    }
	
	public function peticion()
    {
        return $this->belongsTo('App\Peticion','peticion_id');
    }


}
