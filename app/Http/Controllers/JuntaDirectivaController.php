<?php

namespace App\Http\Controllers;


use App\Clases\Mensaje;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Storage;
use App\Peticion;
use App\Comision;
use App\Seguimiento;
use App\EstadoSeguimiento;
use App\Reunion;
use App\Cargo;
use App\EstadoPeticion;
use App\Agenda;
use App\Punto;
use App\Presente;
use App\Periodo;
use App\TipoDocumento;
use App\Documento;
use DateTime;
use Mail;
use Session;



class JuntaDirectivaController extends Controller
{
    //
    public function trabajo_junta_directiva()
    {
        $periodo_actual = Periodo::latest()->first()->id;
        $resueltos = Peticion::where('resuelto', '=', '1')->count(); //--------------------------
        $no_resueltos = Peticion::where('resuelto', '=', '0')->count(); //--------------------------
        $reuniones = Reunion::where('comision_id', '=', '1')
            //->where('periodo_id', '=', $periodo_actual)
            ->where('vigente', '=', '0')
            ->get();

        $no_reuniones = $reuniones->count(); //--------------------------
        //dd($no_reuniones);
        $dic_reuniones = 0; //--------------------------
        foreach ($reuniones as $reunion) {
            foreach ($reunion->documentos as $documento) {
                if ($documento->tipo_documento_id == 3) {
                    $dic_reuniones++;
                }
            }
        }

        return view('jdagu.trabajo_junta_directiva')
            ->with('resueltos', $resueltos)
            ->with('no_resueltos', $no_resueltos)
            ->with('no_reuniones', $no_reuniones)
            ->with('dic_reuniones', $dic_reuniones);
    }

    public function listado_peticiones_jd()
    {
        //$peticiones = Peticion::where('id','!=',0)->get(); //->paginate(10); para obtener todos los resultados  o null
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get();

        return view('jdagu.listado_peticiones_jd')
            ->with('peticiones', $peticiones);
    }

    public function listado_reuniones_jd()
    {

        //$peticiones = Peticion::where('id','!=',0)->get(); //->paginate(10); para obtener todos los resultados  o null
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', '1')->orderBy('created_at', 'DESC')->get();

        return view('jdagu.listado_reuniones_jd')
            ->with('reuniones', $reuniones);
    }

    public function generar_reuniones_jd()
    {
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', '1')->orderBy('created_at', 'DESC')->get();
        return view('jdagu.generar_reuniones_jd')
            ->with('reuniones', $reuniones);
    }

    public function crear_reunion_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = new Reunion();
        $reunion->comision_id = $comision->id;
        $reunion->periodo_id = Periodo::latest()->first()->id;
        $reunion->codigo = $comision->codigo . " " . DateTime::createFromFormat('d-m-Y', $request->fecha)->format('d-m-y');
        $reunion->lugar = $request->lugar;
        $reunion->convocatoria = DateTime::createFromFormat('d-m-Y h:i A', $request->fecha . '' . date('h:i A', strtotime($request->hora)))->format('Y-m-d H:i:s');
        $reunion->vigente = '1';
        $reunion->activa = '0';
        $reunion->save();
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', '1')->orderBy('created_at', 'DESC')->get();

        return view('jdagu.generar_reuniones_jd')
            ->with('reuniones', $reuniones);
    }

    public function eliminar_reunion_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
        $reunion->delete();

        //$peticiones = Peticion::where('id','!=',0)->get(); //->paginate(10); para obtener todos los resultados  o null
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', '1')->orderBy('created_at', 'DESC')->get();

        return view('jdagu.generar_reuniones_jd')
            ->with('reuniones', $reuniones);
    }

    public function enviar_convocatoria_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', $request->id_comision)->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
        $cargos = $comision->cargos;
        //$contador = 0;
        foreach ($cargos as $cargo) {
            $destinatario = $cargo->asambleista->user->email;
            $nombre = $cargo->asambleista->user->persona->primer_nombre . " " . $cargo->asambleista->user->persona->segundo_nombre;
            Mail::queue('correo.contact', $request->all(), function ($message) use ($destinatario, $nombre, $comision) {
                $message->from('from@example.com');
                $message->subject("Convocatoria " . $comision->nombre . " para: " . $nombre);
                $message->to($destinatario, $nombre);
            });
            //$contador++;
        }

        //dd($contador);
        $request->session()->flash("success", 'Correos electronicos enviados');

        //$peticiones = Peticion::where('id','!=',0)->get(); //->paginate(10); para obtener todos los resultados  o null
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', '1')->orderBy('created_at', 'DESC')->get();

        return view('jdagu.generar_reuniones_jd')
            ->with('reuniones', $reuniones);
    }

    public function seguimiento_peticion_jd(Request $request, Redirector $redirect)
    {

        $id_peticion = $request->id_peticion;
        $es_reunion = $request->es_reunion;
        $disco = "../storage/documentos/";

        if ($es_reunion == 1) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
            $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        } else {
            $reunion = null;
            $comision = null;
        }


        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null

        //dd($peticion);
        return view('jdagu.seguimiento_peticion_individual_jd')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion)
            ->with('es_reunion', $es_reunion);

    }

    public function listado_agenda_plenaria_jd(Request $request, Redirector $redirect)
    {
        $agendas = Agenda::where('id', '!=', 0)->orderBy('updated_at', 'DESC')->get();
        return view('jdagu.listado_agenda_plenaria_jd')
            ->with('agendas', $agendas);

    }

    public function generar_agenda_plenaria_jd(Request $request, Redirector $redirect)
    {
        if ($request->ajax()) {
            $agenda = new Agenda();
            $agenda->codigo = $request->codigo;
            $agenda->periodo_id = Periodo::latest()->first()->id;
            $agenda->lugar = $request->lugar;
            $agenda->fecha = (DateTime::createFromFormat('d-m-Y', $request->fecha))->format('Y-m-d');
            $agenda->inicio = DateTime::createFromFormat('d-m-Y h:i A', $request->fecha . ' ' . date('h:i A', strtotime($request->hora)))->format('Y-m-d H:i:s');
            $agenda->trascendental = 0;
            if ($request->trascendental == 'on')
                $agenda->trascendental = 1;

            $agenda->vigente = 1;
            $agenda->activa = 0;
            $agenda->fijada = 0;
            $agenda->save();

            $agendas = Agenda::where('id', '!=', 0)->orderBy('updated_at', 'DESC')->get();
            /*return view('jdagu.listado_agenda_plenaria_jd')
                ->with('agendas', $agendas);*/
            $respuesta = new \stdClass();
            $respuesta->mensaje = (new Mensaje("Exito", "Agenda creada con exito", "success"))->toArray();
            return new JsonResponse($respuesta);

        }
    }

    public function eliminar_agenda_creada_jd(Request $request, Redirector $redirect)
    {   //dd($request->all());

        if ($request->ajax()) {
            $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
            $agenda->delete();
            $agendas = Agenda::where('id', '!=', 0)->orderBy('updated_at', 'DESC')->get();
            $respuesta = new \stdClass();
            $respuesta->mensaje = (new Mensaje("Exito", "Agenda eliminada con exito", "error"))->toArray();
            return new JsonResponse($respuesta);
        }
    }

    public function agendar_plenaria(Request $request, Redirector $redirect)
    {

    //dd($request->all());    
        //dd(Carbon::now()->format('l jS \\of F Y'));
        //dd(Carbon::now()->year);
    $peticion = Peticion::where('id','=',$request->id_peticion)->firstOrFail();
    if ($peticion->agendado == 1) {
        $peticion->agendado = 0;
        $peticion->estado_peticion_id = EstadoPeticion::where('estado', '=', 'jd')->first()->id;    
    }else{
        $peticion->agendado = 1;
        $peticion->estado_peticion_id = EstadoPeticion::where('estado', '=', 'aa')->first()->id;    
    }



        $peticion->save();


        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas

//********************************************************************************
//********************************************************************************
    $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision->id,EstadoSeguimiento::where('estado', '=', "ds")->first()->id);
     //$seguimiento_exist = Seguimiento::where('peticion_id','=',$peticion->id)
    //->where('comision_id','=',$comision->id)
    //->where('estado_seguimiento_id','=',EstadoSeguimiento::where('estado', '=', "ds")->first()->id)
    //->where('inicio','=',Carbon::now()->toDateString())
    //->first();



    if ($seguimiento_exist == 0) {
        $seguimiento = new Seguimiento();

        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = $comision->id;

        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ds")->first()->id; // ds estado discutido
        //$seguimiento->documento_id = $documento_jd->id;

        $seguimiento->reunion_id = $reunion->id;
        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';

        //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');


        $seguimiento->descripcion = 'Peticion discutida en JD'; //COLOCAR FECHA DESPUES
        $seguimiento->save();
    }

        

//********************************************************************************
//********************************************************************************

        $todos_puntos = 1;

        return view('jdagu.reunion_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticiones', $peticiones);
    }

    public function iniciar_reunion_jd(Request $request, Redirector $redirect)
    {
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas

        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $reunion->activa = '1';
        $reunion->inicio = Carbon::now()->format('Y-m-d H:i:s');
        $reunion->save();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();

        $todos_puntos = 1;
        return view('jdagu.reunion_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticiones', $peticiones);
    }

    public function subir_dictamen_jd(Request $request, Redirector $redirect)
    {
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas

        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $reunion->activa = '1';
        $reunion->inicio = Carbon::now()->format('Y-m-d H:i:s');
        $reunion->save();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();

        $todos_puntos = 1;
        return view('jdagu.subir_dictamen_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticiones', $peticiones);
    }

    public function puntos_agendados(Request $request, Redirector $redirect)
    {
        //dd();

        $peticiones = Peticion::where('agendado', '=', 1)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas

        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();

        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();

        $todos_puntos = 2;
        return view('jdagu.reunion_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticiones', $peticiones);
    }

    public function listado_sesion_plenaria(Request $request, Redirector $redirect)
    {

        $agendas = Agenda::where('id', '!=', 0)->orderBy('updated_at', 'DESC')->get(); // Primero ordenar por el estado, despues los estados
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();


        $todos_puntos = 3;
        return view('jdagu.listado_sesion_plenaria')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('agendas', $agendas);
    }

    public function agregar_puntos_jd(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->firstOrFail();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();

        $peticiones = Peticion::leftJoin("puntos", "puntos.peticion_id", "=", "peticiones.id")
            ->Where(function ($query) {
                $query->where('peticiones.agendado', '=', 1)
                    ->where('peticiones.asignado_agenda', '=', 0);
            })
            ->orWhere(function ($query) use ($agenda) {
                $query->where('peticiones.agendado', '=', 1)
                    ->where('peticiones.asignado_agenda', '=', 1)
                    ->where('puntos.agenda_id', '=', $agenda->id);
            })
            ->select('peticiones.*')
            ->orderBy('peticiones.created_at', 'ASC')
            ->get();

        $todos_puntos = 3;
        return view('jdagu.asignacion_puntos')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)////////////
            ->with('comision', $comision)////////////
            ->with('agenda', $agenda)// a que agenda del viernes agendare este punto
            ->with('peticiones', $peticiones);
    }

    public function crear_punto_plenaria(Request $request, Redirector $redirect)
    {
        //dd();   
        $agenda = Agenda::where('id', '=', $request->id_agenda)->firstOrFail();
        $peticion = Peticion::where('id', '=', $request->id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();

        if ($peticion->asignado_agenda == 0) {
            $ultimo_punto = Punto::where('agenda_id', '=', $agenda->id)->max('numero');
            //dd($ultimo_punto);
            $punto = new Punto();
            $punto->peticion_id = $peticion->id;
            $punto->agenda_id = $agenda->id;
            $punto->descripcion = $peticion->descripcion;
            $punto->numero = $ultimo_punto + 1;
            $punto->romano = $this->getRomanNumerals($ultimo_punto + 1);
            $punto->activo = 1;
            $punto->retirado = 0;
            $punto->save();

            $peticion->asignado_agenda = 1;
            $peticion->save();

            // #####################################
            $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision->id,EstadoSeguimiento::where('estado', '=', "ag")->first()->id);

            if ($seguimiento_exist == 0) {
                $seguimiento = new Seguimiento();
                $seguimiento->peticion_id = $peticion->id;
                $seguimiento->comision_id = $comision->id;
                $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ag")->first()->id; // ds estado discutido
                //$seguimiento->documento_id = $documento_jd->id;
                $seguimiento->reunion_id = $reunion->id;
                $seguimiento->inicio = Carbon::now();
                $seguimiento->fin = Carbon::now();
                $seguimiento->activo = '0';
                $seguimiento->agendado = '0';
                //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');
                $seguimiento->descripcion = 'Peticion agendada para Sesion Plenaria'; //COLOCAR FECHA DESPUES
                $seguimiento->save();
            }
            // #####################################

        } else {
            $punto_eliminado = Punto::where('peticion_id', '=', $peticion->id)->where('agenda_id', '=', $agenda->id)->first();
            $punto_eliminado->delete();

            $peticion->asignado_agenda = 0;
            $peticion->save();

            // #####################################
            $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision->id,EstadoSeguimiento::where('estado', '=', "ag")->first()->id); // ag estado agendado

            if ($seguimiento_exist != 0) {

                $seguimiento_eliminado = Seguimiento::where('id', '=', $seguimiento_exist)->first();
                $seguimiento_eliminado->delete();
            }
            // #####################################

            $puntos_desordenados = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get();
            $contador = 1;
            foreach ($puntos_desordenados as $punto_desorden) {
                $punto_desorden->numero = $contador;
                $punto_desorden->romano = $this->getRomanNumerals($contador);
                $punto_desorden->save();
                $contador++;
            }

            //ordenar numeros y roman o s
            //dd($puntos_eliminados);
            //dd();
        }

        //$peticiones = Peticion::where('agendado','=',1)->orderBy('created_at','ASC')->get(); // Primero ordenar por el estado, despues los estados 
        $peticiones = Peticion::leftJoin("puntos", "puntos.peticion_id", "=", "peticiones.id")
            //->where('peticiones.agendado','=',1)
            //->where('puntos.agenda_id','=',$agenda->id)
            ->Where(function ($query) {
                $query->where('peticiones.agendado', '=', 1)
                    ->where('peticiones.asignado_agenda', '=', 0);
            })
            ->orWhere(function ($query) use ($agenda) {
                $query->where('peticiones.agendado', '=', 1)
                    ->where('peticiones.asignado_agenda', '=', 1)
                    ->where('puntos.agenda_id', '=', $agenda->id);
            })
            ->select('peticiones.*')
            ->orderBy('peticiones.created_at', 'ASC')
            ->get();
        $todos_puntos = 3;
        return view('jdagu.asignacion_puntos')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)////////////
            ->with('comision', $comision)////////////
            ->with('agenda', $agenda)// a que agenda del viernes agendare este punto
            ->with('peticiones', $peticiones);
    }

    public function ordenar_puntos_jd(Request $request, Redirector $redirect)
    {
        //dd();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->firstOrFail();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();

        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get(); // Primero ordenar por el estado, despues los estados
        //$peticiones = Peticion::where('asignado_agenda','=',1)->orderBy('created_at','ASC')->firstOrFail(); // Primero ordenar por el estado, despues los estados 

        $todos_puntos = 3;
        $actualizado = 0;
        return view('jdagu.ordenar_puntos_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)////////////
            ->with('comision', $comision)////////////
            ->with('agenda', $agenda)// a que agenda del viernes agendare este punto
            ->with('actualizado', $actualizado)
            ->with('puntos', $puntos);
    }

    public function nuevo_orden(Request $request, Redirector $redirect)
    {
        //dd();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->firstOrFail();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $punto = Punto::where('id', '=', $request->id_punto)->firstOrFail();
        $actualizado = 0;

        if ($request->restar == 1) {
            $punto_anterior = Punto::where('agenda_id', '=', $agenda->id)->where('numero', '=', ($punto->numero - 1))->first();
            if ($punto_anterior) {
                $punto->numero = $punto->numero - 1;
                $punto->romano = $this->getRomanNumerals($punto->numero);
                $punto->save();
                $punto_anterior->numero = $punto_anterior->numero + 1;
                $punto_anterior->romano = $this->getRomanNumerals($punto_anterior->numero);
                $punto_anterior->save();
                $actualizado = $punto->id;
            }

        } else {
            $punto_siguiente = Punto::where('agenda_id', '=', $agenda->id)->where('numero', '=', ($punto->numero + 1))->first();
            if ($punto_siguiente) {
                $punto->numero = $punto->numero + 1;
                $punto->romano = $this->getRomanNumerals($punto->numero);
                $punto->save();
                $punto_siguiente->numero = $punto_siguiente->numero - 1;
                $punto_siguiente->romano = $this->getRomanNumerals($punto_siguiente->numero);
                $punto_siguiente->save();
                $actualizado = $punto->id;
            }
        }


        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get(); // Primero ordenar por el estado, despues los estados
        //$peticiones = Peticion::where('asignado_agenda','=',1)->orderBy('created_at','ASC')->firstOrFail(); // Primero ordenar por el estado, despues los estados 

        $todos_puntos = 3;
        return view('jdagu.ordenar_puntos_jd')
            ->with('todos_puntos', $todos_puntos)
            ->with('reunion', $reunion)////////////
            ->with('comision', $comision)////////////
            ->with('agenda', $agenda)// a que agenda del viernes agendare este punto
            ->with('actualizado', $actualizado)
            ->with('puntos', $puntos);
    }

    /*
        public function reunion_jd(Request $request,Redirector $redirect){
            $peticiones = Peticion::where('id','!=',0)->orderBy('estado_peticion_id','ASC')->orderBy('updated_at','ASC')->get(); // Primero ordenar por el estado, despues los estados ordenarlo por fechas

            $reunion = Reunion::where('id','=',$request->id_reunion)->firstOrFail();
            $reunion->activa = '1';
            $reunion->save();
            $comision = Comision::where('id','=',$request->id_comision)->firstOrFail();

            return view('jdagu.reunion_jd')
            ->with('reunion',$reunion)
            ->with('comision',$comision)
            ->with('peticiones',$peticiones);
        }
    */
    public function asistencia_jd(Request $request)
    {
        $cargos = Cargo::where('comision_id', '=', $request->id_comision)->where('activo', '=', 1)->get();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $asistencias = Presente::where('reunion_id', $request->get("id_reunion"))->get();
        //dd($asistencias);
        return view('jdagu.asistencia_reunion_JD')
            ->with('cargos', $cargos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('asistencias', $asistencias);

    }

    public function registrar_asistencia(Request $request)
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
        return view('jdagu.asistencia_reunion_JD')
            ->with('cargos', $cargos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('asistencias', $asistencias);

    }

    public function finalizar_reunion_jd(Request $request, Redirector $redirect)
    {

        //$cargos = Cargo::where('comision_id','=',$request->id_comision)->where('activo', '=', 1)->get();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $reunion->activa = '0';
        $reunion->vigente = '0';
        $reunion->fin = Carbon::now()->format('Y-m-d H:i:s');
        $reunion->save();
        //$comision = Comision::where('id','=',$request->id_comision)->firstOrFail();
        //dd($cargos);
        $reuniones = Reunion::where('id', '!=', 0)->where('comision_id', '=', $request->id_comision)->orderBy('created_at', 'DESC')->get();

        return view('jdagu.listado_reuniones_jd')
            ->with('reuniones', $reuniones);

    }

    public function asignar_comision_jd(Request $request, Redirector $redirect)
    {
        $id_peticion = $request->id_peticion;
        $disco = "../storage/documentos/";

        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $comisiones = Comision::where('id', '!=', '1')->pluck('nombre', 'id');  // traer todas las comisiones menos la JD
        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();

        return view('jdagu.lista_asignacion')
            ->with('comisiones', $comisiones)
            ->with('seguimientos', $seguimientos)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion);
    }

    public function subir_bitacora_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', '1')->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        $disco = "../storage/documentos/";
        return view('jdagu.subir_bitacora_jd')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision);
    }

    public function guardar_bitacora_jd(Request $request, Redirector $redirect)
    {
        //dd($request->all());
        //$id_peticion = $request->id_peticion;
        //$tipo_documento = $request->tipo_documentos;
        //$peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', '1')->first();
        $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();

        if ($request->hasFile('documento_jd')) {
            $documento_jd = $this->guardarDocumento($request->documento_jd, '7', 'documentos'); //7 es bitacora
            $reunion->documentos()->attach($documento_jd);
        }


        //**************************************************


        //**************************************************
        //$seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        //$tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id');
        //dd($tipo_documentos);

        $disco = "../storage/documentos/";

        $request->session()->flash("success", 'Archivo guardado con exito');
        return view('jdagu.subir_bitacora_jd')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision);
    }

    public function subir_acta_plenaria(Request $request, Redirector $redirect)
    {
        //$id_peticion = $request->id_peticion;
        //$peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        //$reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();

        //$seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        //$tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id'); 
        //dd($tipo_documentos);

        $disco = "../storage/documentos/";

        return view('jdagu.subir_acta_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda);
    }

    public function guardar_acta_plenaria(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();

        if ($request->hasFile('documento_jd')) {
            $documento_jd = $this->guardarDocumento($request->documento_jd, '5', 'documentos'); //5 es acta plenaria
            $agenda->documentos()->attach($documento_jd);

        }

        $disco = "../storage/documentos/";

        return view('jdagu.subir_acta_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda);
    }

    public function subir_documento_jd(Request $request, Redirector $redirect)
    {
        $id_peticion = $request->id_peticion;
        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', '1')->first();

        $is_reunion = '0';
        if (($request->id_reunion) and ($request->id_reunion != 0)) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
            $is_reunion = '1';
        } else {
            $reunion = '0';
        }


        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        $tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id');
        //dd($tipo_documentos);

        $disco = "../storage/documentos/";

        return view('jdagu.subir_documento_jd')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion)
            ->with('is_reunion', $is_reunion)
            ->with('seguimientos', $seguimientos)
            ->with('tipo_documentos', $tipo_documentos);
    }

    public function guardar_documento_jd(Request $request, Redirector $redirect)
    {
        //dd($request->all());

        $id_peticion = $request->id_peticion;
        $tipo_documento = $request->tipo_documentos;
        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', '1')->first();
        $comision_jd = $comision->id;

        $is_reunion = '0';
        if (($request->id_reunion) and ($request->id_reunion != 0)) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
            $is_reunion = '1';

            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
            $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision_jd,EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

            if ($seguimiento_exist == 0) {
                $seguimiento = new Seguimiento();

                $seguimiento->peticion_id = $peticion->id;
                //$seguimiento->comision_id = $comision->id;
                $seguimiento->comision_id = $comision_jd; // ya que $comision->id esta guardando la comision a la cual se enviara, no la comision que esta trabajando

                $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ds")->first()->id; // ds estado discutido
                //$seguimiento->documento_id = $documento_jd->id;
                
                $seguimiento->reunion_id = $reunion->id; 
                
                
                $seguimiento->inicio = Carbon::now();
                $seguimiento->fin = Carbon::now();
                $seguimiento->activo = '0';
                $seguimiento->agendado = '0';

                $seguimiento->descripcion = 'Peticion discutida en JD'; //COLOCAR FECHA DESPUES
                $seguimiento->save();
            }

            //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


        } else {
            $reunion = '0';
        }

        if ($request->hasFile('documento_jd')) {
            $documento_jd = $this->guardarDocumento($request->documento_jd, $tipo_documento, 'documentos');
            //dd();


        }


        

        //**************************************************

        $seguimiento = new Seguimiento();

        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = $comision->id;

        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "cr")->first()->id; // CR estado creado
        $seguimiento->documento_id = $documento_jd->id;

        if (!($is_reunion == 0)) {
            $seguimiento->reunion_id = $reunion->id;
        }


        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';

        //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');
        $seguimiento->descripcion = 'carga de ' . TipoDocumento::where('id', '=', $tipo_documento)->first()->tipo;
        $seguimiento->save();


        //**************************************************
        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();
        $tipo_documentos = TipoDocumento::where('tipo', '=', 'atestado')->orWhere('tipo', '=', 'dictamen')->pluck('tipo', 'id');
        //dd($tipo_documentos);

        $disco = "../storage/documentos/";

        return view('jdagu.subir_documento_jd')
            ->with('disco', $disco)
            ->with('reunion', $reunion)
            ->with('comision', $comision)
            ->with('peticion', $peticion)
            ->with('is_reunion', $is_reunion)
            ->with('seguimientos', $seguimientos)
            ->with('tipo_documentos', $tipo_documentos);
    }

    public function enlazar_comision(Request $request, Redirector $redirect)
    {
        //dd($request->all());
        $id_peticion = $request->id_peticion;
        $id_reunion = $request->id_reunion;
        $id_comision = $request->comisiones;
        $descripcion = $request->descripcion;
        $comision_jd = '1';

        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', $id_comision)->firstOrFail();
        $reunion = Reunion::where('id', '=', $id_reunion)->firstOrFail();

        //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        $seguimiento_exist = $this->existeSeguimiento($peticion->id,$comision_jd,EstadoSeguimiento::where('estado', '=', "ds")->first()->id);

        if ($seguimiento_exist == 0) {
            $seguimiento = new Seguimiento();

            $seguimiento->peticion_id = $peticion->id;
            //$seguimiento->comision_id = $comision->id;
            $seguimiento->comision_id = $comision_jd; // ya que $comision->id esta guardando la comision a la cual se enviara, no la comision que esta trabajando

            $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "ds")->first()->id; // ds estado discutido
            //$seguimiento->documento_id = $documento_jd->id;

            $seguimiento->reunion_id = $reunion->id;
            $seguimiento->inicio = Carbon::now();
            $seguimiento->fin = Carbon::now();
            $seguimiento->activo = '0';
            $seguimiento->agendado = '0';

            $seguimiento->descripcion = 'Peticion discutida en JD'; //COLOCAR FECHA DESPUES
            $seguimiento->save();
        }

        //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$




        if (!$peticion->comisiones->contains($id_comision)) {

            $seguimiento = new Seguimiento();
            $seguimiento->peticion_id = $peticion->id;
            $seguimiento->comision_id = $comision->id;
            $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "se")->first()->id; // SE Seguimiento
            $seguimiento->reunion_id = $reunion->id;
            $seguimiento->inicio = Carbon::now();
            //$seguimiento->fin = Carbon::now();
            $seguimiento->activo = '1';
            $seguimiento->agendado = '0';
            //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');
            $seguimiento->descripcion = "Inicio de control en: " . $comision->nombre . " - " . $descripcion;
            $guardado = $seguimiento->save();
            if ($guardado) {
                $peticion->comisiones()->attach($id_comision);
            }


            $seguimiento = new Seguimiento();
            $seguimiento->peticion_id = $peticion->id;
            $seguimiento->comision_id = $comision->id;
            $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "as")->first()->id; // AS Asignado
            $seguimiento->reunion_id = $reunion->id;
            $seguimiento->inicio = Carbon::now();
            $seguimiento->fin = Carbon::now();
            $seguimiento->activo = '0';
            $seguimiento->agendado = '0';
            //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');
            $seguimiento->descripcion = "Asignado a: " . $comision->nombre . " - " . $descripcion;
            $guardado = $seguimiento->save();

            //if($guardado){
            //$peticion->comisiones()->attach($id_comision);
            //}
            $peticion->comision = 1;  // quiere decir que este punto esta en una comision
            $peticion->agendado = 0;
            $peticion->asignado_agenda = 0;
            $peticion->estado_peticion_id = EstadoPeticion::where('estado', '=', "co")->first()->id; // AS Asignado
            $peticion->save();

        }


        //$peticion->comisiones()->sync([$id_comision], false);  //$model->sync(array $ids, $detaching = true)
        //$peticion->comisiones()->attach($id_comision);

        //


        //$peticion = Peticion::where('id','=',$id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null
        $comisiones = Comision::where('id', '!=', '1')->pluck('nombre', 'id');  // traer todas las comisiones menos la JD
        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();

        return view('jdagu.lista_asignacion')
            ->with('comisiones', $comisiones)
            ->with('seguimientos', $seguimientos)
            ->with('peticion', $peticion)
            ->with('reunion', $reunion);
    }

    public function historial_bitacoras_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', '1')->first();
        $periodo = Periodo::latest()->first();
        $reuniones = Reunion::where('comision_id', '=', $comision->id)->where('periodo_id', '=', $periodo->id)->orderBy('created_at', 'DESC')->get();
        $disco = "../storage/documentos/";

        return view('jdagu.historial_bitacoras_jd')
            ->with('disco', $disco)
            ->with('reuniones', $reuniones);
    }

    public function historial_dictamenes_jd(Request $request, Redirector $redirect)
    {
        $comision = Comision::where('id', '=', '1')->first();
        $periodo = Periodo::latest()->first();
        $reuniones = Reunion::where('comision_id', '=', $comision->id)->where('periodo_id', '=', $periodo->id)->orderBy('created_at', 'DESC')->get();
        $disco = "../storage/documentos/";

        $seguimientos = Seguimiento::where('comision_id','=',$comision->id)
        ->where('documento_id','!=',NULL)
        ->get();

        return view('jdagu.historial_dictamenes_jd')
            ->with('disco', $disco)
            ->with('reuniones', $reuniones)
            ->with('seguimientos', $seguimientos);
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
















    public function getRomanNumerals($decimalInteger) {
             $n = intval($decimalInteger);
             $res = '';

             $roman_numerals = array(
                'M'  => 1000,
                'CM' => 900,
                'D'  => 500,
                'CD' => 400,
                'C'  => 100,
                'XC' => 90,
                'L'  => 50,
                'XL' => 40,
                'X'  => 10,
                'IX' => 9,
                'V'  => 5,
                'IV' => 4,
                'I'  => 1);

             foreach ($roman_numerals as $roman => $numeral) 
             {
              $matches = intval($n / $numeral);
              $res .= str_repeat($roman, $matches);
              $n = $n % $numeral;
             }

             return $res;
    }

    public function convertirMes($mes) {
         

             switch ($mes) {
                 case 'january':
                     return 'Enero';
                     break;
                 case 'february':
                     return 'Febrero';
                     break;
                 case 'march':
                     return 'Marzo';
                     break;
                 case 'april':
                     return 'Abril';
                     break;
                 case 'may':
                     return 'Mayo';
                     break;
                 case 'june':
                     return 'Junio';
                     break;
                 case 'july':
                     return 'Julio';
                     break;
                 case 'august':
                     return 'Agosto';
                     break;
                 case 'september':
                     return 'Septiembre';
                     break;
                 case 'october':
                     return 'Octubre';
                     break;
                 case 'november':
                     return 'Noviembre';
                     break;
                 case 'december':
                     return 'Diciembre';
                     break;
                 
             }

       
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
