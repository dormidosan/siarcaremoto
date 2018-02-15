<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propuesta extends Model
{
    //
	protected $table = 'propuestas';
	
    //LLAVES FORANEAS	
	public function punto()
    {
        return $this->belongsTo('App\Punto');
    }

    public function asambleista()
    {
        return $this->belongsTo('App\Asambleista');
    }

}
