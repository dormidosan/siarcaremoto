<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    //
    protected $table = 'facultades';

	public function asambleistas()
    {
        return $this->hasMany('App\Asambleista');
    }
}
