<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peticion extends Model
{
    //
	protected $table = 'peticiones';

	public function seguimientos()
    {
        return $this->hasMany('App\Seguimiento');
    }


	public function puntos()
    {
        return $this->hasMany('App\Punto','peticion_id');
    }
	
	public function comisiones()
    {
        return $this->belongsToMany('App\Comision','comision_peticion')->withTimestamps();
    }
	
	public function documentos()
    {
        return $this->belongsToMany('App\Documento','documento_peticion')->withTimestamps();
    }

	//LLAVES FORANEAS
	
	public function estado_peticion()
    {
        return $this->belongsTo('App\EstadoPeticion');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }



}
