<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuloRol extends Model
{
    //
    protected $table = 'modulo_rol';

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function modulo()
    {
        return $this->belongsTo('App\Modulo');
    }
}
