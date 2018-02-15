<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
	protected $table = 'personas';

	public function user()
    {
        return $this->hasOne('App\User');
    }
	
	

}
