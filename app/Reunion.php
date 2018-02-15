<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    //
	protected $table = 'reuniones';

	
	public function documentos()
    {
        return $this->belongsToMany('App\Documento','documento_reunion')->withTimestamps();
    }





	/* ***************************************
	public function cargos()
    {
        return $this->belongsToMany('App\Cargo','presentes')->withTimestamps();
    }

    //**************************************** */
	public function presentes()
    {
        return $this->hasMany('App\Presente');
    }
    
    public function seguimientos()
    {
        return $this->hasMany('App\Seguimiento');
    }






    //LLAVES FORANEAS
	public function comision()
    {
        return $this->belongsTo('App\Comision');
    }
	
	public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }


}
