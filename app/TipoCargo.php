<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCargo extends Model
{
    //
    protected $table = 'tipo_cargos';

	public function cargos()
    {
        return $this->hasMany('App\Cargo');
    }
}
