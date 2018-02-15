<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presente extends Model
{
    //
    protected $table = 'presentes';


    
	//LLAVES FORANEAS
    public function cargo()
    {
        return $this->belongsTo('App\Cargo');
    }

    public function reunion()
    {
        return $this->belongsTo('App\Reunion');
    }


}
