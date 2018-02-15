<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    //
	protected $table = 'documentos';
	
	protected $fillable = ['nombre_documento', 'tipo_documento_id','periodo_id', 'fecha_ingreso', 'path'];

	public function peticiones()
    {
        return $this->belongsToMany('App\Peticion','documento_peticion')->withTimestamps();
    }
	
	public function reuniones()
    {
        return $this->belongsToMany('App\Reunion','documento_reunion')->withTimestamps();
    }

    public function agendas()
    {
        return $this->belongsToMany('App\Agenda','agenda_documento')->withTimestamps();
    }

    public function versiones()
    {
        return $this->hasMany('App\Version');
    }

    public function seguimiento()
    {
        return $this->hasOne('App\Seguimiento');
    }
	
    //LLAVES FORANEAS
	public function tipo_documento()
    {
        return $this->belongsTo('App\TipoDocumento');
    }
	
	public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

    

}
