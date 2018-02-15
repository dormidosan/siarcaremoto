<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPeticion extends Model
{
    //
	protected $table = 'estado_peticiones';

	public function peticiones()
    {
        return $this->hasMany('App\Peticion');
    }
	
}
