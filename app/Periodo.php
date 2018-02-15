<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    //
	protected $table = 'periodos';

	public function documentos()
    {
        return $this->hasMany('App\Documento');
    }
	
	public function reuniones()
    {
        return $this->hasMany('App\Reunion');
    }
	
	public function asambleistas()
    {
        return $this->hasMany('App\Asambleista');
    }
	
	public function agendas()
    {
        return $this->hasMany('App\Agenda');
    }

    public function peticiones()
    {
        return $this->hasMany('App\Peticion');
    }


}
