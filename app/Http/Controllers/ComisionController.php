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
use App\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use DateTime;


class ComisionController extends Controller
{

    //funcion generica para obtener la comision, los integrantes de dicha comision y todos los asambleistas en la app
    public function obtener_datos(Request $request)
    {
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

    /******************** METODOS GET *********************************/

    //mostrar las comisiones activas e inactivas
    public function mostrar_comisiones()
    {
        //se obtienen todas las comisiones en orden alfabetico
        $comisiones = Comision::orderBy("nombre", "asc")->get();
        $cargos = Cargo::all();
        return view("Comisiones.CrearComision", ['comisiones' => $comisiones, 'cargos' => $cargos]);
    }

    //mostrar las comisiones activas
    public function administrar_comisiones()
    {
        //obtener las comisiones, omitiendo la JD
        $comisiones = Comision::where("activa", 1)
            ->where("id", "!=", 1)
            ->get();
        $cargos = Cargo::all();
        return view("Comisiones.AdministrarComision", ['comisiones' => $comisiones, 'cargos' => $cargos]);
    }

    /******************** METODOS POST *********************************/

    public function listado_peticiones_comision(Request $request)
    {
        //obtengo una comision
        $comision = Comision::find($request->get("comision_id"));
        $peticiones = $comision->peticiones()
            ->orderBy('peticiones.created_at', 'asc')
            ->get();

 
        return view("Comisiones.listado_peticiones_comision", ["comision" => $comision, "peticiones" => $peticiones]);
    }

    //mostrar listado de las comisiones, con su total de integrantes
    public function gestionar_asambleistas_comision(Request $request)
    {
        $datos = $this->obtener_datos($request);
        return view("Comisiones.AdministrarIntegrantes", ["comision" => $datos["comision"], "integrantes" => $datos["integrantes"], "asambleistas" => $datos["asambleistas"]]);
    }

    //funcion que se encarga de crear una comision
    public function crear_comision(Request $request)
    {
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

    //funcion para actualizar una comision
    public function actualizar_comision(Request $request)
    {
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

    //funcion para agregar asambleistas a una comision
    public function agregar_asambleistas_comision(Request $request)
    {
        $asambleistas = $request->get("asambleistas");
        $comision = Comision::find($request->get("comision_id"));

        foreach ($asambleistas as $asambleista) {
            $cargo = new Cargo();
            $cargo->comision_id = $request->get("comision_id");
            $cargo->asambleista_id = $asambleista;
            $cargo->inicio = Carbon::now();
            $cargo->cargo = "Asambleista";
            $cargo->activo = 1;
            $cargo->save();
        }

        //$request->session()->flash("success", "Asambleista(s) agregado(s) con exito " .$cargo->id);
        $request->session()->flash("success", "Asambleista(s) agregado(s) con exito ");

        $datos = $this->obtener_datos($request);
        return view("Comisiones.AdministrarIntegrantes", ["comision" => $datos["comision"], "integrantes" => $datos["integrantes"], "asambleistas" => $datos["asambleistas"]]);
    }

    public function retirar_asambleista_comision(Request $request)
    {

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

    public function trabajo_comision(Request $request)
    {
        $comision = Comision::find($request->get("comision_id"));
        return view("Comisiones.TrabajoComision", ["comision" => $comision]);

    }

    public function listado_reuniones_comision(Request $request)
    {
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', $request->comision_id)->orderBy('created_at', 'DESC')->get();
        $comision = Comision::find($request->get("comision_id"));

        return view('Comisiones.listado_reuniones_comision', ["reuniones" => $reuniones, "comision" => $comision]);
    }

    public function iniciar_reunion_comision(Request $request)
    {
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

    public function asistencia_comision(Request $request)
    {
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

    public function registrar_asistencia_comision(Request $request)
    {

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

    public function seguimiento_peticion_comision(Request $request)
    {
        $disco = "../storage/documentos/";
        $peticion = Peticion::find($request->get("id_peticion"));
        $comision = Comision::find($request->get("id_comision"));

        if ($request->get("id_reunion") == "") {
            return view('Comisiones.seguimiento_peticion_comision', array("disco" => $disco, "comision" => $comision, "peticion" => $peticion));
        } else {
            $reunion = Reunion::find($request->get("id_reunion"));
            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
            $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision->id,EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

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

                $seguimiento->descripcion = 'Peticion discutida en '.$comision->nombre; //COLOCAR FECHA DESPUES
                $seguimiento->save();
            }

            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$



            
            return view('Comisiones.seguimiento_peticion_comision', array("disco" => $disco, "comision" => $comision, "reunion" => $reunion, "peticion" => $peticion));
        }


    }

    public function finalizar_reunion_comision(Request $request, Redirector $redirect)
    {

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

    public function historial_bitacoras(Request $request, Redirector $redirect)
    {
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

    public function historial_dictamenes(Request $request, Redirector $redirect)
    {
        $id_comision = $request->comision_id;
        $comision = Comision::where('id', '=', $id_comision)->first();
        $periodo = Periodo::latest()->first();
        $reuniones = Reunion::where('comision_id', '=', $comision->id)->where('periodo_id', '=', $periodo->id)->orderBy('created_at', 'DESC')->get();
        $disco = "../storage/documentos/";

        $seguimientos = Seguimiento::where('comision_id','=',$comision->id)
        ->where('documento_id','!=',NULL)
        ->get();

        //dd($seguimientos);

        return view('Comisiones.historial_dictamenes')
            ->with('disco', $disco)
            ->with('comision', $comision)
            ->with('reuniones', $reuniones)
            ->with('seguimientos', $seguimientos);
    }

    public function convocatoria_comision(Request $request, Redirector $redirect)
    {
        $comision = Comision::where("id", $request->comision_id)->first();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->comision_id)->orderBy('created_at', 'DESC')->get();
        return view('Comisiones.convocatoria_comision')
            ->with('reuniones', $reuniones)
            ->with('comision', $comision);
    }

    public function subir_documento_comision(Request $request, Redirector $redirect)
    {
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

    public function guardar_documento_comision(Request $request, Redirector $redirect)
    {
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
            $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision->id,EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

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

                $seguimiento->descripcion = 'Peticion discutida en '.$comision->nombre; //COLOCAR FECHA DESPUES
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

    public function crear_reunion_comision(Request $request, Redirector $redirect)
    {
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

        return view('Comisiones.convocatoria_comision')
            ->with('reuniones', $reuniones)
            ->with('comision', $comision);
    }

    public function eliminar_reunion_comision(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
        $reunion->delete();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->id_comision)->orderBy('created_at', 'DESC')->get();
        $request->session()->flash("error", 'Reunion eliminada con exito');
        return view('Comisiones.convocatoria_comision')
            ->with('reuniones', $reuniones)
            ->with('comision', $comision);
    }

    public function enviar_convocatoria_comision(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
        $cargos = $comision->cargos;
        foreach ($cargos as $cargo) {
            $destinatario = $cargo->asambleista->user->email;
            $nombre = $cargo->asambleista->user->persona->primer_nombre . " " . $cargo->asambleista->user->persona->segundo_nombre;
            Mail::queue('correo.contact', $request->all(), function ($message) use ($destinatario, $nombre, $comision) {
                $message->from('from@example.com');
                $message->subject("Convocatoria " . $comision->nombre . " para: " . $nombre);
                $message->to($destinatario, $nombre);
            });
        }

        $request->session()->flash("success", 'Correos electronicos enviados');
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->id_comision)->orderBy('created_at', 'DESC')->get();
        return view('Comisiones.convocatoria_comision')
            ->with('reuniones', $reuniones);
    }

    public function subir_bitacora_comision(Request $request)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $disco = "../storage/documentos/";
        return view('Comisiones.subir_bitacora_comision')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision);
    }

    public function guardar_bitacora_comision(Request $request)
    {
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

    public function guardarDocumento($doc, $tipo, $destino)
    {
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

    public function listado_agenda_comision(Request $request, Redirector $redirect)
    {
        $agendas = Agenda::where('id','!=',0)->orderBy('updated_at','DESC')->get();
        return view('jdagu.listado_agenda_plenaria_jd')
            ->with('agendas', $agendas);

    }

    public function existeSeguimiento($peticion_id,$comision_id,$estado_seguimiento_id) {
        //dd($comision_id);
         
        $seguimiento_exist = Seguimiento::where('peticion_id','=',$peticion_id)
        ->where('comision_id','=',$comision_id)
        ->where('estado_seguimiento_id','=',$estado_seguimiento_id)
        ->where('inicio','=',Carbon::now()->toDateString())
        ->first();

        //dd($seguimiento_exist);
        if ($seguimiento_exist) {
            return $seguimiento_exist->id;
        } else {
            return '0';
        }
    

    
    }


}
