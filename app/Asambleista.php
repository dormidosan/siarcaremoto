<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asambleista extends Model
{
    //
	protected $table = 'asambleistas';

	public function dietas()
    {
        return $this->hasMany('App\Dieta');
    }
	
	public function permisos()
    {
        return $this->hasMany('App\Permiso');
    }
	
    public function delegado()
    {
        return $this->hasOne('App\Permiso');
    }

	public function cargos()
    {
        return $this->hasMany('App\Cargo');
    }

    public function asistencias()
    {
        return $this->hasMany('App\Asistencia');
    }

    public function intervenciones()
    {
        return $this->hasMany('App\Intervencion');
    }
    
    public function propuestas()
    {
        return $this->hasMany('App\Propuesta');
    }
	
    
    //LLAVES FORANEAS
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }

    public function facultad()
    {
        return $this->belongsTo('App\Facultad');
    }



}
