<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    //
	protected $table = 'tipo_documentos';

	public function documentos()
    {
        return $this->hasMany('App\Documento');
    }
	

}
