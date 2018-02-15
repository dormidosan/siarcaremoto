<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiempo extends Model
{
    //
	protected $table = 'tiempos';


	//LLAVES FORANEAS
	public function asistencia()
    {
        return $this->belongsTo('App\Asistencia');
    }

    public function estado_asistencia()
    {
        return $this->belongsTo('App\EstadoAsistencia');
    }
}
