<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hoja extends Model
{
    //
    protected $table = 'hojas';

    public function asambleista()
    {
        return $this->hasOne('App\Asambleista');
    }
}
