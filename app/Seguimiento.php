<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    //
	protected $table = 'seguimientos';

    //LLAVES FORANEAS
	public function peticion()
    {
        return $this->belongsTo('App\Peticion');
    }
	
	public function comision()
    {
        return $this->belongsTo('App\Comision');
    }
	
	public function estado_seguimiento()
    {
        return $this->belongsTo('App\EstadoSeguimiento');
    }

    public function documento()
    {
        return $this->belongsTo('App\Documento');
    }

    public function reunion()
    {
        return $this->belongsTo('App\Reunion');
    }

}
