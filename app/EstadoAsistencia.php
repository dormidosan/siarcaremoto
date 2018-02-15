<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoAsistencia extends Model
{
    //
    protected $table = 'estado_asistencias';

	public function tiempos()
    {
        return $this->hasMany('App\Tiempo');
    }
}
