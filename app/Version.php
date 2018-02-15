<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    //
    protected $table = 'versiones';

	public function documento()
    {
        return $this->belongsTo('App\Documento');
    }
}
