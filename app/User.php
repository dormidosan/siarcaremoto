<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	

    public function asambleistas()
    {
        return $this->hasMany('App\Asambleista');
    }

    //LLAVES FORANEAS
	public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function getModulosActivos(){
        //retorna todos los modulos que coincidan con la condicion
        return $this->getModulo()->filter(function($entry){
            return $entry->getEstado() != 0;
        });
    }

    /**
     * Get permisos
     * Este metodo retorna las rutas a las que el rol tiene permiso
     * @return array
     */
    public function getPermisos(){
        $permisos = array();
        $modulos = $this->getModulosActivos()->toArray();
        foreach($modulos as $modulo){
            $permisos[] = $modulo->getUrl();
        }

        return $permisos;
    }
	
	
	
	
}
