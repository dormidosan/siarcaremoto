<?php

namespace App\Http\Controllers;

use App\Documento;
use App\EstadoSeguimiento;
use App\Periodo;
use App\Asambleista;
use App\Cargo;
use App\Clases\Mensaje;
use App\Comision;
use App\Peticion;
use App\Presente;
use App\Reunion;
use App\Seguimiento;
use App\TipoCargo;
use App\TipoDocumento;
use App\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use DateTime;
use Auth;


class ComisionController extends Controller
{

    //funcion generica para obtener la comision, los integrantes de dicha comision y todos los asambleistas en la app
    public function obtener_datos(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = Comision::find($request->get("comision_id"));

        //se obtiene todos los asambleistas que pertenecen a la comision
        $resultados = Cargo::where("comision_id", $request->get("comision_id"))->where("activo", 1)->get();
        $asambleistas_ids = array();

        //array con los id de los asambleistas
        foreach ($resultados as $resultado)
            array_push($asambleistas_ids, $resultado->asambleista->id);

        //se obtienen todos aquellos asambleistas que no esten en la comision actual
        $asambleistas = Asambleista::where("asambleistas.activo", "=", 1)
            ->whereNotIn("asambleistas.id", $asambleistas_ids)
            ->get();

        //obtener los integrantes de la comision y que esten activos en el periodo activo
        $integrantes = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
            ->join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
            ->where("cargos.comision_id", $request->get("comision_id"))
            ->where("asambleistas.activo", 1)
            ->where("periodos.activo", 1)
            ->where("cargos.activo", 1)
            ->get();

        return ["comision" => $comision, "integrantes" => $integrantes, "asambleistas" => $asambleistas];
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    /******************** METODOS GET *********************************/

    //mostrar las comisiones activas e inactivas
    public function mostrar_comisiones()
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //se obtienen todas las comisiones en orden alfabetico
        $comisiones = Comision::orderBy("nombre", "asc")->get();
        $cargos = Cargo::all();
        return view("Comisiones.CrearComision", ['comisiones' => $comisiones, 'cargos' => $cargos]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //mostrar las comisiones activas
    public function administrar_comisiones()
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //obtener las comisiones, omitiendo la JD
        if (Auth::user()->rol_id == 1) {
            $comisiones = Comision::where("activa", 1)
                ->get();
        } else {

            $id_asambleista = Asambleista::where('user_id','=',Auth::user()->id)->where('activo','=','1')->first()->id;

            $comisiones = Comision::join("cargos", "cargos.comision_id", "=", "comisiones.id")
                ->Where(function ($query) use ($id_asambleista) {
                    $query->where("cargos.activo", "=", 1)
                        ->where("comisiones.activa", "=", 1)
                        ->where("cargos.asambleista_id", "=", $id_asambleista)
                        ->where("cargos.tipo_cargo_id", "=", '7');
                })
                ->orWhere(function ($query) use ($id_asambleista) {
                    $query->where("cargos.activo", "=", 1)
                        ->where("comisiones.activa", "=", 1)
                        ->where("cargos.asambleista_id", "=", $id_asambleista)
                        ->where("cargos.tipo_cargo_id", "=", '8');
                })
                //->where("asambleistas.id","=", $asambleista_id)
                //->where("dietas.mes", "=", $mes)
                //->where("dietas.anio", "=", $year)
                ->select('comisiones.*')
                ->get();
        }



        $cargos = Cargo::all();
        return view("Comisiones.AdministrarComision", ['comisiones' => $comisiones, 'cargos' => $cargos]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    /******************** METODOS POST *********************************/

    public function listado_peticiones_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //obtengo una comision
        $comision = Comision::find($request->get("comision_id"));
        $peticiones = $comision->peticiones()
            ->orderBy('peticiones.created_at', 'asc')
            ->get();


        return view("Comisiones.listado_peticiones_comision", ["comision" => $comision, "peticiones" => $peticiones]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function retirar_peticion_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $peticion = Peticion::where('id', '=', $request->id_peticion)->first();
        //dd($seguimiento);
        //dd($peticion->comisiones());
        //$peticion->comisiones()->attach('5');

        //$peticion->comisiones()->attach($id_comision);
        //obtengo una comision
        //dd($request->all());
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        //dd($peticion->comisiones->count());
        $seguimiento = Seguimiento::where('estado_seguimiento_id', '=', 2)
            ->where('peticion_id', '=', $peticion->id)
            ->where('comision_id', '=', $comision->id)
            ->where('activo', '=', 1)
            ->first();

        // estado seguimiento 2 es el metodo de control para decir que estuvo en transito en esta comision, y no debe ser eliminado
        //hay que consultar los seguimientos de esta peticion en esta comision que esten activos, y proceder a inactivarlos, por que ya paso por esta comision
        $seguimiento->activo = 0;
        $seguimiento->fin = Carbon::now();
        $seguimiento->save();

        //dd($comision);
        //$comision->peticiones()->detach($peticion->id);
        $peticion->comisiones()->detach($comision->id);
        if (($peticion->comisiones->count()) == 0) {
            $peticion->comision = 0;
            $peticion->save();
        }

        //dd($seguimiento);
        //dd($comision->peticiones());
        $request->session()->flash("success", "Peticion: " . $peticion->codigo . " retirada de la comision: ");
        $peticiones = $comision->peticiones()
            ->orderBy('peticiones.created_at', 'asc')
            ->get();


        return view("Comisiones.listado_peticiones_comision", ["comision" => $comision, "peticiones" => $peticiones]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //mostrar listado de las comisiones, con su total de integrantes
    public function gestionar_asambleistas_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $datos = $this->obtener_datos($request);
        return view("Comisiones.AdministrarIntegrantes", ["comision" => $datos["comision"], "integrantes" => $datos["integrantes"], "asambleistas" => $datos["asambleistas"]]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //funcion que se encarga de crear una comision
    public function crear_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = new Comision();
        $comision->codigo = $request->get("codigo");
        $comision->nombre = $request->get("nombre");
        $comision->permanente = 0; //0: transitoria, 1: permanente
        $comision->descripcion = $request->get("nombre");
        $comision->activa = 1;
        $comision->save();

        $request->session()->flash("success", "Comision " . $comision->nombre . " agregada con exito");
        return redirect()->route("mostrar_comisiones");
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //funcion para actualizar una comision
    public function actualizar_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()) {
            //se obtiene la comision que coincida con el id enviado
            $comision = Comision::find($request->get("id"));
            $respuesta = new \stdClass();

            //se actualiza el estado de la comision, dependiendo de su previo estado
            if ($comision->activa == 1) {
                $comision->activa = 0;
                $respuesta->mensaje = (new Mensaje("Exito", "Comision: " . $comision->nombre . " establecida como inactiva", "warning"))->toArray();
            } else {
                $comision->activa = 1;
                $respuesta->mensaje = (new Mensaje("Exito", "Comision: " . $comision->nombre . " establecida como activa", "success"))->toArray();
            }

            //una vez efectuado el cambio, se realiza el cambio en la BD
            $comision->save();

            //se genera la respuesta json
            return new JsonResponse($respuesta);
        }
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    //funcion para agregar asambleistas a una comision
    public function agregar_asambleistas_comision(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $asambleistas = $request->get("asambleistas");
        $comision = Comision::find($request->get("comision_id"));

        foreach ($asambleistas as $asambleista) {
            $cargo = new Cargo();
            $cargo->comision_id = $request->get("comision_id");
            $cargo->asambleista_id = $asambleista;
            $cargo->inicio = Carbon::now();
            //original sentence
            //$cargo->tipo_cargo_id = (TipoCargo::where("nombre_cargo","Asambleista")->first())->id;
            $tipo_cargo = TipoCargo::where("nombre_cargo","Asambleista")->first();
            $cargo->tipo_cargo_id = $tipo_cargo->id;
            $cargo->activo = 1;
            $cargo->save();
        }

        //$request->session()->flash("success", "Asambleista(s) agregado(s) con exito " .$cargo->id);
        $request->session()->flash("success", "Asambleista(s) agregado(s) con exito ");

        $datos = $this->obtener_datos($request);
        return view("Comisiones.AdministrarIntegrantes", ["comision" => $datos["comision"], "integrantes" => $datos["integrantes"], "asambleistas" => $datos["asambleistas"]]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function retirar_asambleista_comision(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $asambleista_id = $request->get("asambleista_id");
        $comision_id = $request->get("comision_id");

        $asambleista_comision = Cargo::where("asambleista_id", $asambleista_id)
            ->where("comision_id", $comision_id)
            ->where("activo", 1)
            ->first();

        $asambleista_comision->activo = 0;
        $asambleista_comision->fin = Carbon::now();
        $asambleista_comision->save();

        $request->session()->flash("success", "Asambleista retirado de la comision con exito");

        $datos = $this->obtener_datos($request);
        return view("Comisiones.AdministrarIntegrantes", ["comision" => $datos["comision"], "integrantes" => $datos["integrantes"], "asambleistas" => $datos["asambleistas"]]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function trabajo_comision(Request $request)
    {
        

        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");

            $comision = Comision::find($request->get("comision_id"));
            //dd(Route::currentRouteName()); //"trabajo_comision"
            //dd(Route::getCurrentRoute()->getPath());//"comisiones/trabajo_comision"
            //dd(Route::getFacadeRoot()->current()->uri()); //"comisiones/trabajo_comision"
            //dd(Route::currentRouteName()); //"trabajo_comision"
            //dd(Route::getCurrentRoute()->getActionName()); // use "App\Http\Controllers\ComisionController@trabajo_comision"
            //dd($request->path()); //"comisiones/trabajo_comision"
            //dd($request->url());  //"http://localhost/siarcaf/public/comisiones/trabajo_comision"
            //dd($request->route()->getName()); //"trabajo_comision"
            $periodo_actual = Periodo::latest()->first()->id;
            $resueltos = Seguimiento::where('comision_id', '=', $comision->id)->where('estado_seguimiento_id', '=', 2)->where('activo', '=', 0)->count(); //todos los resueltos
            //$resueltos = Peticion::where('resuelto', '=', '1')->count();
            $no_resueltos = Seguimiento::where('comision_id', '=', $comision->id)->where('estado_seguimiento_id', '=', 2)->where('activo', '=', 1)->count(); //todos los no resueltos
            //$no_resueltos = Peticion::where('resuelto', '=', '0')->count();
            $reuniones = Reunion::where('comision_id', '=', $comision->id) //YA************
            //->where('periodo_id', '=', $periodo_actual)
            ->where('vigente', '=', '0')
                ->get();

            $no_reuniones = $reuniones->count(); //YA************
            //dd($no_reuniones);
            $dic_reuniones = 0; //YA************
            foreach ($reuniones as $reunion) {
                foreach ($reunion->documentos as $documento) {
                    if ($documento->tipo_documento_id == 3) {
                        $dic_reuniones++; //YA************
                    }
                }
            }

            return view('Comisiones.TrabajoComision')
            ->with('comision', $comision)
            ->with('resueltos', $resueltos) //todos los  resueltos
            ->with('no_resueltos', $no_resueltos) //todos los no resueltos
            ->with('no_reuniones', $no_reuniones) //YA************
            ->with('dic_reuniones', $dic_reuniones); //YA************

        } 
        catch(\Exception $e){
           // catch code
            //dd("variable"); 
            //dd(Route::getCurrentRoute()->getPath()); 
            //dd($e); 
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            //return $e->getMessage();
            //return 0;
            return view('errors.catch');
        }

            



        

    }

    public function listado_reuniones_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', $request->comision_id)->orderBy('created_at', 'DESC')->get();
        $comision = Comision::find($request->get("comision_id"));

        return view('Comisiones.listado_reuniones_comision', ["reuniones" => $reuniones, "comision" => $comision]);
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function iniciar_reunion_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        // 0987
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        //$peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas
        $peticiones = $comision->peticiones()
            ->orderBy('peticiones.created_at', 'asc')
            ->get();

        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $reunion->activa = '1';
        $reunion->inicio = Carbon::now()->format('Y-m-d H:i:s');
        $reunion->save();


        $todos_puntos = 1;

        return view('Comisiones.reunion_comision')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticiones', $peticiones);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function asistencia_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $cargos = Cargo::where('comision_id', '=', $request->id_comision)->where('activo', '=', 1)->get();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $asistencias = Presente::where('reunion_id', $request->get("id_reunion"))
            ->get();
        //dd($asistencias);
        return view('Comisiones.asistencia_reunion_comision')
            ->with('cargos', $cargos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('asistencias', $asistencias);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function registrar_asistencia_comision(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $presente = new Presente();
        $presente->cargo_id = $request->get("cargo");
        $presente->reunion_id = $request->get("reunion");
        $presente->entrada = Carbon::now();
        $presente->save();

        $request->session()->flash("success", "Asistencia registrada con exito");

        $cargos = Cargo::where('comision_id', '=', $request->comision)->where('activo', '=', 1)->get();
        $reunion = Reunion::where('id', '=', $request->reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->comision)->firstOrFail();

        $asistencias = Presente::where('reunion_id', $request->get("reunion"))
            ->get();

        //dd($asistencia);
        return view('Comisiones.asistencia_reunion_comision')
            ->with('cargos', $cargos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('asistencias', $asistencias);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function seguimiento_peticion_comision(Request $request)
    {   
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $disco = "../storage/documentos/";
        $peticion = Peticion::find($request->get("id_peticion"));
        $comision = Comision::find($request->get("id_comision"));


        if ($request->get("id_reunion") == "") {
            return view('Comisiones.seguimiento_peticion_comision', array("disco" => $disco, "comision" => $comision, "peticion" => $peticion));
        } else {
            $reunion = Reunion::find($request->get("id_reunion"));
            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
            $seguimiento_exist = $this->existeSeguimiento($peticion->id, $comision->id, EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

            if ($seguimiento_exist == 0) {
                $seguimiento = new Seguimiento();
                $seguimiento->peticion_id = $peticion->id;
                $seguimiento->comision_id = $comision->id; // Esta si cuenta ya que comision esta guardando actualmente la comision en que se esta trabajando
                //$seguimiento->comision_id = $comision_jd; // ya que $comision->id esta guardando la comision a la cual se enviara, no la comision que esta trabajando

                $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ds")->first()->id; // ds estado discutido
                //$seguimiento->documento_id = $documento_jd->id;

                $seguimiento->reunion_id = $reunion->id;
                $seguimiento->inicio = Carbon::now();
                $seguimiento->fin = Carbon::now();
                $seguimiento->activo = '0';
                $seguimiento->agendado = '0';

                $seguimiento->descripcion = 'Peticion discutida en ' . $comision->nombre; //COLOCAR FECHA DESPUES
                $seguimiento->save();
            }

            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


            return view('Comisiones.seguimiento_peticion_comision', array("disco" => $disco, "comision" => $comision, "reunion" => $reunion, "peticion" => $peticion));
        }
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function finalizar_reunion_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //$cargos = Cargo::where('comision_id','=',$request->id_comision)->where('activo', '=', 1)->get();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $reunion->activa = '0';
        $reunion->vigente = '0';
        $reunion->fin = Carbon::now()->format('Y-m-d H:i:s');
        $reunion->save();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->id_comision)->orderBy('created_at', 'DESC')->get();
        $comision = Comision::find($request->get("id_comision"));
        return view('Comisiones.listado_reuniones_comision', array("reuniones" => $reuniones, "comision" => $comision));
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function historial_bitacoras(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $id_comision = $request->comision_id;
        $comision = Comision::where('id', '=', $id_comision)->first();
        $periodo = Periodo::latest()->first();
        $reuniones = Reunion::where('comision_id', '=', $comision->id)->where('periodo_id', '=', $periodo->id)->orderBy('created_at', 'DESC')->get();
        $disco = "../storage/documentos/";

        return view('Comisiones.historial_bitacoras')
            ->with('disco', $disco)
            ->with('comision', $comision)
            ->with('reuniones', $reuniones);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function historial_dictamenes(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $id_comision = $request->comision_id;
        $comision = Comision::where('id', '=', $id_comision)->first();
        $periodo = Periodo::latest()->first();
        $reuniones = Reunion::where('comision_id', '=', $comision->id)->where('periodo_id', '=', $periodo->id)->orderBy('created_at', 'DESC')->get();
        $disco = "../storage/documentos/";

        $seguimientos = Seguimiento::where('comision_id', '=', $comision->id)
            ->where('documento_id', '!=', NULL)
            ->get();

        //dd($seguimientos);

        return view('Comisiones.historial_dictamenes')
            ->with('disco', $disco)
            ->with('comision', $comision)
            ->with('reuniones', $reuniones)
            ->with('seguimientos', $seguimientos);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function convocatoria_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = Comision::where("id", $request->comision_id)->first();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->comision_id)->orderBy('created_at', 'DESC')->get();
        return view('Comisiones.convocatoria_comision')
            ->with('reuniones', $reuniones)
            ->with('comision', $comision);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function subir_documento_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $id_peticion = $request->id_peticion;
        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->first();

        $is_reunion = '0';
        if (($request->id_reunion) and ($request->id_reunion != 0)) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
            $is_reunion = '1';
        } else {
            $reunion = '0';
        }

        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        $tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id');

        $disco = "../storage/documentos/";

        return view('Comisiones.subir_documento_comision')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion)
            ->with('is_reunion', $is_reunion)
            ->with('seguimientos', $seguimientos)
            ->with('tipo_documentos', $tipo_documentos);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardar_documento_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //dd($request->all());
        $id_peticion = $request->id_peticion;
        $tipo_documento = $request->tipo_documentos;
        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->first();

        $is_reunion = '0';
        if (($request->id_reunion) and ($request->id_reunion != 0)) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
            $is_reunion = '1';


            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
            $seguimiento_exist = $this->existeSeguimiento($peticion->id, $comision->id, EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

            if ($seguimiento_exist == 0) {
                $seguimiento = new Seguimiento();
                $seguimiento->peticion_id = $peticion->id;
                $seguimiento->comision_id = $comision->id; // Esta si cuenta ya que comision esta guardando actualmente la comision en que se esta trabajando
                //$seguimiento->comision_id = $comision_jd; // ya que $comision->id esta guardando la comision a la cual se enviara, no la comision que esta trabajando

                $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ds")->first()->id; // ds estado discutido
                //$seguimiento->documento_id = $documento_jd->id;

                $seguimiento->reunion_id = $reunion->id;
                $seguimiento->inicio = Carbon::now();
                $seguimiento->fin = Carbon::now();
                $seguimiento->activo = '0';
                $seguimiento->agendado = '0';

                $seguimiento->descripcion = 'Peticion discutida en ' . $comision->nombre; //COLOCAR FECHA DESPUES
                $seguimiento->save();
            }

            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

        } else {
            $reunion = '0';
        }


        if ($request->hasFile('documento_comision')) {
            $documento_comision = $this->guardarDocumento($request->documento_comision, $tipo_documento, 'documentos');

        }

        $seguimiento = new Seguimiento();

        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = $comision->id;

        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "cr")->first()->id; // CR estado creado
        $seguimiento->documento_id = $documento_comision->id;

        if (!($is_reunion == 0)) {
            $seguimiento->reunion_id = $reunion->id;
        }


        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';

        $seguimiento->descripcion = 'carga de ' . TipoDocumento::where('id', '=', $tipo_documento)->first()->tipo;
        $seguimiento->save();

        if (!($is_reunion == 0)) {
            $reunion->documentos()->attach($documento_comision);
        }

        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        $tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id');

        $disco = "../storage/documentos/";
        $request->session()->flash("success", "Documento creado con exito");

        return view('Comisiones.subir_documento_comision')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion)
            ->with('is_reunion', $is_reunion)
            ->with('seguimientos', $seguimientos)
            ->with('tipo_documentos', $tipo_documentos);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function crear_reunion_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()) {

            $comision = Comision::where('id', '=', $request->id_comision)->first();
            $reunion = new Reunion();
            $reunion->comision_id = $comision->id;
            $reunion->periodo_id = Periodo::latest()->first()->id;
            $reunion->codigo = $comision->codigo . " " . \DateTime::createFromFormat('d-m-Y', $request->fecha)->format('d-m-y');
            $reunion->lugar = $request->lugar;
            $reunion->convocatoria = DateTime::createFromFormat('d-m-Y h:i A', $request->fecha . ' ' . date('h:i A', strtotime($request->hora)))->format('Y-m-d H:i:s');
            $reunion->vigente = '1';
            $reunion->activa = '0';
            $reunion->save();

            $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->id_comision)->orderBy('created_at', 'DESC')->get();

            $respuesta = new \stdClass();
            $respuesta->html = $this->generar_table_body($request->id_comision);
            $respuesta->mensaje = (new Mensaje("Exito", "Reunion creada con exito", "success"))->toArray();
            return new JsonResponse($respuesta);

        }
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function eliminar_reunion_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()){
            $comision = Comision::where('id', '=', $request->id_comision)->first();
            $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
            $reunion->delete();
            $respuesta = new \stdClass();
            $respuesta->html = $this->generar_table_body($request->id_comision);
            $respuesta->mensaje = (new Mensaje("Exito", "Reunion eliminada con exito", "error"))->toArray();
            return new JsonResponse($respuesta);
        }
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function subir_bitacora_comision(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $disco = "../storage/documentos/";
        return view('Comisiones.subir_bitacora_comision')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardar_bitacora_comision(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();

        if ($request->hasFile('documento_comision')) {
            $documento_comision = $this->guardarDocumento($request->documento_comision, '7', 'documentos'); //7 es bitacora
            $reunion->documentos()->attach($documento_comision);
        }
        $request->session()->flash("success", 'Archivo guardado con exito');
        $disco = "../storage/documentos/";
        return view('Comisiones.subir_bitacora_comision')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardarDocumento($doc, $tipo, $destino)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $archivo = $doc;
        $documento = new Documento();
        $documento->nombre_documento = $archivo->getClientOriginalName();
        $documento->tipo_documento_id = $tipo; // PETICION = 1
        $documento->periodo_id = Periodo::latest()->first()->id;
        $documento->fecha_ingreso = Carbon::now();
        $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();

        while (Documento::where('path', '=', $ruta)->first()) {
            $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        }

        $r1 = Storage::disk($destino)->put($ruta, \File::get($archivo));
        $documento->path = $ruta;
        $documento->save();
        return $documento;
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function listado_agenda_comision(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $agendas = Agenda::where('id', '!=', 0)->orderBy('updated_at', 'DESC')->get();
        return view('jdagu.listado_agenda_plenaria_jd')
            ->with('agendas', $agendas);
            } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }

    public function existeSeguimiento($peticion_id, $comision_id, $estado_seguimiento_id)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //dd($comision_id);

        $seguimiento_exist = Seguimiento::where('peticion_id', '=', $peticion_id)
            ->where('comision_id', '=', $comision_id)
            ->where('estado_seguimiento_id', '=', $estado_seguimiento_id)
            ->where('inicio', '=', Carbon::now()->toDateString())
            ->first();

        //dd($seguimiento_exist);
        if ($seguimiento_exist) {
            return $seguimiento_exist->id;
        } else {
            return '0';
        }
        } 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    private function generar_table_body($comision_id)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $comision = Comision::where("id", $comision_id)->first();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $comision_id)->orderBy('created_at', 'DESC')->get();
        $contador = 1;
        $table_body = "";

        foreach ($reuniones as $reunion) {
            $table_body .= "<tr>
                                <td>" . $contador++ . "</td>
                                <td>" . $reunion->codigo . "</td>
                                <td>" . $reunion->lugar . "</td>
                                <td>" . Carbon::parse($reunion->convocatoria)->format('d-m-Y h:i A') . "</td>";

            if ($reunion->inicio)
                $table_body .= "<td>" . Carbon::parse($reunion->inicio)->format('h:i A') . "</td>";
            else
                $table_body .= "<td>No iniciada</td>";

            if ($reunion->fin)
                $table_body .= "<td>" . Carbon::parse($reunion->fin)->format('h:i A') . "</td>";
            else
                $table_body .= "<td>No finalizada</td>";

            if ($reunion->vigente == 1){
                $id = 'c'.$reunion->id;
                $table_body .= "<td>
                                    <form id='$id' method='POST' route='". route('envio_convocatoria')."'>". csrf_field()."
                                        <input type='hidden' name='id_comision' id='id_comision' value='$reunion->comision_id'>
                                        <input type='hidden' name='id_reunion' id='id_reunion' value='$reunion->id'>
                                        <button type='submit' class='btn btn-info btn-xs btn-block'><i class='fa fa-eye'></i> Enviar Convocatoria</button>
                                    </form>
                                </td>";

                if ($reunion->activa == 0){
                    $id2 = 'd'.$reunion->id;
                    $table_body .= "<td>
                                    <button type='button' id='btn_eliminar' class='btn btn-danger btn-xs btn-block' onclick='mostrar_modal_eliminar(". $reunion->comision->id.",". $reunion->id.")'><i class='fa fa-trash'></i> Eliminar Reunion</button>
                                </td>";
                }else{
                    $table_body .= "<td></td>";
                }
            }else{
                $table_body .= "<td></td><td></td>";
            }

            $table_body .= "</tr>";
        }

        return $table_body;
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


