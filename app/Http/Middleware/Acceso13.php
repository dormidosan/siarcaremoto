<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Modulo;

class Acceso13
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permiso = 0;
        $nivel_acceso = '13';
        $modulo_id = Modulo::where('nivel_acceso', '=', $nivel_acceso)->first()->id;
        $modulos = Auth::user()->rol->modulos;
        
        foreach ($modulos as $modulo) {
            if ($modulo->id == $modulo_id) {
                $permiso = 1;
            }
        }

        if ($permiso == 1) {

            return $next($request);
        } else {
           return abort(403);
        }
        

        
    }
}
