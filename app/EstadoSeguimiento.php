<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSeguimiento extends Model
{
    //
	protected $table = 'estado_seguimientos';

	public function seguimientos()
    {
        return $this->hasMany('App\Seguimiento');
    }
	
}
