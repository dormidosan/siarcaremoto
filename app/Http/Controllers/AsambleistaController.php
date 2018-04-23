<?php

namespace App\Http\Controllers;

use App\Asambleista;
use App\Cargo;
use App\Comision;
use App\Facultad;
use App\Bitacora;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Storage;

class AsambleistaController extends Controller
{

    //Muestra todos los asambleistas de un periodo activo por facultad
    public function listado_asambleistas_facultad(){
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $facultades = Facultad::all();
        $asambleistas = Asambleista::join("periodos","asambleistas.periodo_id","=","periodos.id")
                        ->where("periodos.activo","=",1)
                        ->where("asambleistas.activo","=",1)
                        ->get();
        //dd($asambleistas);
        $fotos = "../../storage/fotos/";
        $disco = "../../storage/hojas_vida/";

        return view("Asambleistas.ListadoAsambleistaFacultad",["facultades"=>$facultades,"asambleistas"=>$asambleistas,"fotos"=>$fotos,"disco"=>$disco]);
        // ////////////////////
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //Muestra todos los asambleistas de un periodo activo por comision
    public function listado_asambleistas_comision()
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //recuperar las comisiones que estan activas en el periodo vigente
        $comisiones = Comision::where('activa','=', 1)->where('codigo','!=','jda')->get();

        //se obtiene todos los asambleistas activos que pertenecen a una comision activa en el periodo vigente
        $cargos = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
            ->join("comisiones", "cargos.comision_id", "=", "comisiones.id")
            ->join("periodos","asambleistas.periodo_id","=","periodos.id")
            ->where("asambleistas.activo", 1)
            //->where("comisiones.activa",1)
            ->where("cargos.activo",1)
            ->where("periodos.activo", "=", 1)
            ->get();

        $fotos = "../../storage/fotos/";
        $disco = "../../storage/hojas_vida/";

        return view("Asambleistas.ListadoAsambleistasComision", ['comisiones' => $comisiones, 'cargos' => $cargos,"fotos"=>$fotos,"disco"=>$disco]);
        // ////////////////////
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    //Muestra asambleistas de un periodo activo que pertenecen a la JD
    public function listado_asambleistas_junta()
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //recuperar las comisiones que estan activas en el periodo vigente
        $comisiones = Comision::where('activa','=',1)
                        ->where('codigo','=','jda')
                        ->get();


        //se obtiene todos los asambleistas que pertenecen a una comision activa y que estos esten
        //activos
        $cargos = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
            ->join("comisiones", "cargos.comision_id", "=", "comisiones.id")
            ->join("periodos","asambleistas.periodo_id","=","periodos.id")
            ->where("asambleistas.activo", "=", 1)
            ->where("comisiones.activa", "=", 1)
            //->where("comisiones.nombre", "LIKE", "%junta directiva%")
            ->where("comisiones.nombre", "=", "junta directiva")
            ->where("periodos.activo", "=", 1)
            ->where("cargos.activo",1)
            ->get();
        //dd($asambleistas);
        //dd($asambleistas);
        $fotos = "../../storage/fotos/";
        $disco = "../../storage/hojas_vida/";

        return view("Asambleistas.ListadoAsambleistasJunta",["cargos"=>$cargos,"fotos"=>$fotos,"disco"=>$disco]);
        // ////////////////////
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function guardar_bitacora($accion,$evento)
    {
        if ( !(Auth::guest()) ) {
        $bitacora = new Bitacora();
        $bitacora->user_id = Auth::user()->id;
        $bitacora->accion = $accion;
        $bitacora->fecha = Carbon::now();
        $bitacora->hora = Carbon::now();
        $bitacora->comentario = $evento;

        $bitacora->save();
        }
        return 0;

    }
}
