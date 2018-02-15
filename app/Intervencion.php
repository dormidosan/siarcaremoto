<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervencion extends Model
{
    //
	protected $table = 'intervenciones';

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
