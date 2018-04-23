<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    //
	protected $table = 'bitacoras';


	//LLAVES FORANEAS
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
