<?php

namespace App\Http\Controllers;



use App\Periodo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Requests;
use App\Http\Requests\PropuestaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Agenda;
use App\Punto;
use App\Propuesta;
use App\Intervencion;
use App\Asambleista;
use App\Peticion;
use App\EstadoPeticion;
use App\Comision;
use App\Seguimiento;
use App\EstadoSeguimiento;
use App\Asistencia;
use App\Facultad;
use App\Tiempo;
use App\Parametro;
use App\Dieta;

class AgendaController extends Controller
{
    public function getRomanNumerals($decimalInteger)
    {
        $n = intval($decimalInteger);
        $res = '';

        $roman_numerals = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach ($roman_numerals as $roman => $numeral) {
            $matches = intval($n / $numeral);
            $res .= str_repeat($roman, $matches);
            $n = $n % $numeral;
        }

        return $res;
    }

    public function historial_agendas(Request $request,Redirector $redirect)
    {
        $agendas = Agenda::where('id','!=','0')->orderBy('created_at', 'ASC')->get();
        $disco = "../storage/documentos/";
        
        return view('Agenda.historial_agendas')
        ->with('disco', $disco)
        ->with('agendas',$agendas);
    }


    public function resolverPunto($id_punto,$id_agenda) //$this->resolverPunto($request->id_punto,$request->id_agenda);
    {
        // ******* CUERPO DEL METODO
        $punto = Punto::where('id', '=', $id_punto)->first();
        $punto->activo = '0';
        $punto->save();
        $peticion = Peticion::where('id', '=', $punto->peticion_id)->first();
        $peticion->estado_peticion_id = EstadoPeticion::where('estado', '=', 'rs')->first()->id;
        $peticion->resuelto = '1';
        $peticion->agendado = '0';
        $peticion->asignado_agenda = '0';
        $peticion->comision = '0';
        $peticion->save();


        // ******* CUERPO DEL METODO


        $agenda = Agenda::where('id', '=', $id_agenda)->first();
        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get();
        $actualizado = 0;
        return view('Agenda.listado_puntos_plenaria')
            ->with('actualizado', $actualizado)
            ->with('agenda', $agenda)
            ->with('puntos', $puntos);
    }

    public function sala_sesion_plenaria(Request $request,Redirector $redirect)
    {


    	$agenda = Agenda::where('id', '=', $request->id_agenda)->first();

        if ($agenda->puntos->isEmpty()) {

            $agendas = Agenda::where('vigente','=','1')->orderBy('created_at', 'ASC')->get();
            $request->session()->flash("warning_puntos", 'La agenda "'.$agenda->codigo.'"  contiene 0 PUNTOS asociados');

            return view('Agenda.consultar_agendas_vigentes')
            ->with('agendas',$agendas);
        }

        $periodo_activo = Periodo::where('activo','=', 1)->first();
        $array_asambleistas_sesion = Asistencia::where('agenda_id','=',$agenda->id)->pluck('asambleista_id')->toArray();


        $asambleistas = Asambleista::where('activo','=', 1)            
            ->where('periodo_id','=',$periodo_activo->id)
            //->where('facultad_id','=','5')
            ->whereNotIn('id',$array_asambleistas_sesion)
            ->get();

        $ultimos_ingresos  = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->take(5)->get();
        $facultades = Facultad::where('id','!=','0')->get();
        $asistentes = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->get();

        $conteo = array(
                        "pro" => "0",
                        "csup" => "0",
                        "cpro" => "0",
                        "sup" => "0",
                        "total" => "0",
                    );
        $conteo["pro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.propietario','=','1')
                                            ->count();

        $conteo["csup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','0')
                                            ->where('asambleistas.propietario','=','1')
                                            ->count();

        $conteo["cpro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.propietario','=','0')
                                            ->count();

        $conteo["sup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','0')
                                            ->where('asambleistas.propietario','=','0')
                                            ->count();

        $conteo["total"] = Asistencia::where('agenda_id','=',$agenda->id)->count();



        //return view('Agenda.CrearSesionPlenaria')
        //dd($asambleistas);
        return view('Agenda.sala_sesion_plenaria')        
        ->with('agenda', $agenda)
        ->with('conteo', $conteo)
        ->with('facultades', $facultades)
        ->with('asistentes', $asistentes)
        ->with('asambleistas', $asambleistas)
        ->with('ultimos_ingresos', $ultimos_ingresos);






    }

    public function iniciar_sesion_plenaria(Request $request, Redirector $redirect)
    {
    	$agenda = Agenda::where('id', '=', $request->id_agenda)->first();
    	$puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero','ASC')->get();

        // qmt es minimo trascendental , qmn es minimo para sesion normal 
        if ($agenda->trascendental == 1) {
            $quorum_minimo = Parametro::where('parametro','=','qmt')->first();
        } else {
            $quorum_minimo = Parametro::where('parametro','=','qmn')->first();
        }
        
        
        $quorum_actual = Asistencia::where('agenda_id','=',$agenda->id)->where('propietaria','=','1')->count();
 
        //si el quorum actual es menor que el minimo requerido , regresa a la pantalla anterior
        if($quorum_actual < $quorum_minimo->valor ){

                $request->session()->flash("warning", 'No hay quorum minimo. Hay '. $quorum_actual.' propietarios presentes');
                $periodo_activo = Periodo::where('activo','=', 1)->first();

                $array_asambleistas_sesion = Asistencia::where('agenda_id','=',$agenda->id)->pluck('asambleista_id')->toArray();

                $asambleistas = Asambleista::where('activo','=', 1)            
                    ->where('periodo_id','=',$periodo_activo->id)
                    ->whereNotIn('id',$array_asambleistas_sesion)
                    ->get();

                $ultimos_ingresos  = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->take(5)->get();
                $facultades = Facultad::where('id','!=','0')->get();
                $asistentes = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->get();

                $conteo = array(
                    "pro" => "0",
                    "csup" => "0",
                    "cpro" => "0",
                    "sup" => "0",
                    "total" => "0",
                );
                $conteo["pro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                    ->where('asistencias.agenda_id','=',$agenda->id)
                    ->where('asistencias.propietaria','=','1')
                    ->where('asambleistas.propietario','=','1')
                    ->count();

                $conteo["csup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                    ->where('asistencias.agenda_id','=',$agenda->id)
                    ->where('asistencias.propietaria','=','0')
                    ->where('asambleistas.propietario','=','1')
                    ->count();

                $conteo["cpro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                    ->where('asistencias.agenda_id','=',$agenda->id)
                    ->where('asistencias.propietaria','=','1')
                    ->where('asambleistas.propietario','=','0')
                    ->count();

                $conteo["sup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                    ->where('asistencias.agenda_id','=',$agenda->id)
                    ->where('asistencias.propietaria','=','0')
                    ->where('asambleistas.propietario','=','0')
                    ->count();

                $conteo["total"] = Asistencia::where('agenda_id','=',$agenda->id)->count();

                return view('Agenda.sala_sesion_plenaria')        
                ->with('agenda', $agenda)
                ->with('conteo', $conteo)
                ->with('facultades', $facultades)
                ->with('asistentes', $asistentes)
                ->with('asambleistas', $asambleistas)
                ->with('ultimos_ingresos', $ultimos_ingresos);
        }

    	if ($request->get("retornar") == "retornar"){
            $agenda->vigente = '1'; // ya esta vigente asi que no es necesario realmente
            $agenda->activa = '1';
            $agenda->save();
            //dd($request->get("retornar"));
        }

        $actualizado = 0;

        return view('Agenda.listado_puntos_plenaria')
            ->with('actualizado', $actualizado)
            ->with('agenda', $agenda)
            ->with('puntos', $puntos);
    }

    public function finalizar_sesion_plenaria(Request $request,Redirector $redirect)
    {
        
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero','ASC')->get();
        $puntos_activos = Punto::where('agenda_id', '=', $agenda->id)->where('activo', '=', '1')->count();
        
        // si ya no hay puntos activos , regresar a pantalla de listado de sesiones plenarias
        if ($puntos_activos == '0') {
            //$agendas = Agenda::where('vigente','=', '1')->orderBy('created_at', 'ASC')->get();
            $agenda->activa  = '0';
            $agenda->vigente = '0';
            //$agenda->fin=Carbon::now();
            $agenda->save();

            $agendas = Agenda::where('vigente','=','1')->orderBy('created_at', 'ASC')->get();
            // ###############################################################################
            // ##################   INSERTAR CODIGO AQUI JAIME ###############################
            // ###############################################################################
            


             $tiempos_sin_terminar =  Tiempo::where('salida','=',NULL)->get();
             // dd($tiempos_sin_terminar);
            foreach ($tiempos_sin_terminar as $tiempo_individual) {
                $asistencia_individual = $tiempo_individual->asistencia;
                $asistencia_individual->salida = Carbon::now()->toTimeString();
                $asistencia_individual->save();

                $tiempo_individual->salida = Carbon::now()->toTimeString();
                $tiempo_individual->save();

            }
            //$tiempos_sin_terminar =  Tiempo::where('salida','=',NULL)->get();
            //dd($tiempos_sin_terminar);

                $busqueda=DB::table('asambleistas')  //todos los asambleistas que participaron como propietario en la plenaria a finalizar 
                ->join('asistencias','asistencias.asambleista_id','=','asambleistas.id')
                ->join('agendas','agendas.id','=','asistencias.agenda_id')
                ->join('tiempos','tiempos.asistencia_id','=','asistencias.id')
                ->join('estado_asistencias','estado_asistencias.id','=','tiempos.estado_asistencia_id')
                ->where('agendas.id','=',$agenda->id)
                ->where('estado_asistencias.estado','=','nor')
                ->where('tiempos.tiempo_propietario','=',1)//1 para los que fueron propietarios            
                ->get();

                //dd($busqueda);
               
                $mesyanio=explode('-', $agenda->fecha);  // mes y año de la agenda 
                $anio_agend=$mesyanio[0];
                $mes_agend=$mesyanio[1];
                $mes=$this->numero_mes($mes_agend);


                //dd($busqueda);
        $porcentaje_asistencia = 0.0;
        $monto_dieta = 0.0;


        $parametros = DB::table('parametros')->get();

                foreach ($parametros as $parametro) {
                    if ($parametro->nombre_parametro == 'porcentaje_asistencia') {
                        $porcentaje_asistencia = ($parametro->valor) * 100;
                    }
                    if ($parametro->nombre_parametro == 'monto_dieta') {
                        $monto_dieta = $parametro->valor;
                    }
                }

               //dd($parametros);

        
        foreach ($busqueda as $busq) {

            $agendas_anio = DB::table('agendas')->where('agendas.id','=',$request->id_agenda)->get();


           // dd($agendas_anio);

            foreach ($agendas_anio as $agendas_in) {

                /*$horasreunion = DB::table('agendas') //total de duracion de la reunion                   
                    ->where('agendas.id', '=', $agendas_in->id)
                    ->select('agendas.inicio','agendas.fin')
                    ->get();*/

                $horasreunion = DB::table('agendas') //total de duracion de la reunion 
                    ->selectRaw('ABS(sum(time_to_sec(timediff(inicio,fin)))/3600) as suma')
                    ->where('agendas.id', '=', $agendas_in->id)
                    ->get();

                  //  dd($agendas->id);
                //dd($horasreunion);

                   $horasasistencia = DB::table('tiempos')
                    ->selectRaw('ABS(sum(time_to_sec(timediff(tiempos.entrada,tiempos.salida)))/3600) as suma')
                    ->join('asistencias', 'asistencias.id', '=', 'tiempos.asistencia_id')
                    ->join('estado_asistencias','estado_asistencias.id','=','tiempos.estado_asistencia_id')
                    //s->where('estado_asistencias.estado','=','nor')         
                    ->where('tiempos.tiempo_propietario','=',1)                  
                    ->where('asistencias.asambleista_id', '=', $busq->id)
                    ->where('asistencias.agenda_id', '=', $agendas_in->id)
                    ->get();

                    /*$horasasistencia = DB::table('asistencias')
                    ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id') 
                    ->join('estado_asistencias','estado_asistencias.id','=','tiempos.estado_asistencia_id')                       
                    ->where('asistencias.asambleista_id', '=', $busq->id)
                    ->where('asistencias.agenda_id', '=', $agendas_in->id)//por el momento solo filtro por el id
                    ->get();*/





                    //dd($horasasistencia);

                if ($horasreunion[0]->suma > 0.0) {

                    $porcAsistencia = ($horasasistencia[0]->suma / $horasreunion[0]->suma) * 100; // porcentage de asistencia por asambleista
                } else {

                    $porcAsistencia = 0.0; // 

                }

                 //dd($porcAsistencia);

                if ($porcAsistencia >= $porcentaje_asistencia) {

                    $cantDiet = Dieta::where('dietas.asambleista_id', '=', $busq->id) //registro del mes y año de la agenda del asambleista
                        ->where('dietas.mes','=',$mes) // mes de la junta
                        ->where('dietas.anio','=',$anio_agend)// año de la junta
                        ->first();

                        //dd($cantDiet);

                    if($cantDiet==NULL){ //aqui inserta si no hay

                            $cargo=DB::table('cargos')
                            ->join('comisiones','comisiones.id','=','cargos.comision_id')
                            ->where('cargos.asambleista_id','=',$busq->id)
                            ->where('cargos.activo','=',1) //
                            ->select('cargos.comision_id','comisiones.codigo')
                            ->first();

                           // dd($cargo);
                            $cantDiet = new Dieta();
                            $cantDiet->asambleista_id=$busq->id;
                            $cantDiet->mes=$mes;

                            $cantDiet->anio=$anio_agend;
                            //dd($cantDiet);
                            $cantDiet->asistencia=1; //lo inserta de un solo con 1 porquue alcanzo el porcentage de asistencia minimo para aplicar a la dieta
                            if($cargo->codigo=='jda'){
                            $cantDiet->junta_directiva=1;
                            }
                            else{
                            $cantDiet->junta_directiva=0;
                            }
                            //dd($cantDiet);
                            $cantDiet->save();
                        

                    }

                    else{ // aqui actualiza si hay
            
                        if($cantDiet->asistencia<4){ // si es de junta puede tener hasta 8 dietas al mes
                            $cantDiet->asistencia=$cantDiet->asistencia+1;
                            //dd($cantDiet);
                            $cantDiet->save();
                        }
                  
                    }

                }

            }

            
           
        }


            // ###############################################################################
            // ##################   INSERTAR CODIGO AQUI JAIME ###############################
            // ###############################################################################
            return view('Agenda.consultar_agendas_vigentes')
            ->with('agendas',$agendas);

        } 
        
        
        $actualizado = 0;
        $request->session()->flash("warning", 'Existen '.$puntos_activos.' punto(s) sin discutir');

        return view('Agenda.listado_puntos_plenaria')
        ->with('actualizado',$actualizado)
        ->with('agenda', $agenda)
        ->with('puntos', $puntos);
    }

    public function pausar_sesion_plenaria(Request $request,Redirector $redirect)
    {
        
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $agenda->fin = Carbon::now()->format('Y-m-d H:i:s');
        $agenda->save();
        
        $agendas = Agenda::where('vigente','=','1')->orderBy('created_at', 'ASC')->get();
        //$puntos = Punto::all();
        return view('Agenda.consultar_agendas_vigentes')
        ->with('agendas',$agendas);
    }

    public function comision_punto_plenaria(Request $request,Redirector $redirect)
    {
        
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();
        $peticion = Peticion::where('id', '=', $punto->peticion_id)->first();


        //$id_peticion = $request->id_peticion;

        //$peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null
        //$reunion = Reunion::where('id', '=', $request->id_reunion)->firstOrFail();
        //$comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $comisiones = Comision::where('id', '!=', '1')->pluck('nombre', 'id');  // traer todas las comisiones menos la JD
        $seguimientos = Seguimiento::where('peticion_id', '=', $peticion->id)->where('activo', '=', 1)->get();

        return view('Agenda.lista_asignacion_plenaria')
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('peticion', $peticion)
            ->with('comisiones', $comisiones)
            ->with('seguimientos', $seguimientos);

    }

    public function asignar_comision_punto(Request $request,Redirector $redirect)
    {
        //dd($request->all());

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();

        $id_peticion = $request->id_peticion;
        $id_comision = $request->comisiones;
        $descripcion = $request->descripcion;

        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        $comision = Comision::where('id', '=', $id_comision)->firstOrFail();


        if (!$peticion->comisiones->contains($id_comision)) {

            $seguimiento = new Seguimiento();
            $seguimiento->peticion_id = $peticion->id;
            $seguimiento->comision_id = $comision->id;
            $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "se")->first()->id; // SE Seguimiento
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
        $punto->activo   = '0';
        $punto->retirado = '0';
        $punto->save();

        //$peticion = Peticion::where('id','=',$id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null
        $comisiones = Comision::where('id', '!=', '1')->pluck('nombre', 'id');  // traer todas las comisiones menos la JD
        $seguimientos = Seguimiento::where('peticion_id', '=', $id_peticion)->where('activo', '=', 1)->get();

        return view('Agenda.lista_asignacion_plenaria')
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('peticion', $peticion)          ////
            ->with('comisiones', $comisiones)      ////
            ->with('seguimientos', $seguimientos); ////
      

    }

    public function discutir_punto_plenaria(Request $request,Redirector $redirect)

    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();


        // ******* CUERPO

        // ******* CUERPO


        $propuestas = Propuesta::where('punto_id', '=', $punto->id)->orderBy('pareja', 'ASC')->orderBy('ronda', 'ASC')->get();
        //remplazar esta busqueda con los asambleistas realmente presentes
        $presentes = Asambleista::where('id', '<', '6')->get();
        $asambleistas_plenaria[] = array();
        foreach ($presentes as $asambleista) {
            $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                . ' ' . $asambleista->user->persona->segundo_nombre
                . ' ' . $asambleista->user->persona->primer_apellido
                . ' ' . $asambleista->user->persona->segundo_apellido;
        }
        unset($asambleistas_plenaria[0]);
        $disco = "../storage/documentos/";

        return view('Agenda.discutir_punto_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('asambleistas_plenaria', $asambleistas_plenaria)
            ->with('propuestas', $propuestas);
    }

    public function agregar_propuesta(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();
        //dd($request->all());

        // ******* CUERPO DEL METODO
        $propuesta = new Propuesta();
        $propuesta->punto_id = $punto->id;
        $propuesta->asambleista_id = $request->asambleista_id;
        $propuesta->nombre_propuesta = $request->nueva_propuesta;
        $propuesta->votado = '0';
        $propuesta->activa = '1';
        $propuesta->ronda = '1';
        $propuesta->pareja = 1 + Propuesta::where('punto_id', '=', $punto->id)->max('pareja');
        $propuesta->save();
        // ******* CUERPO DEL METODO


        $propuestas = Propuesta::where('punto_id', '=', $punto->id)->orderBy('pareja', 'ASC')->orderBy('ronda', 'ASC')->get();
        //remplazar esta busqueda con los asambleistas realmente presentes
        $presentes = Asambleista::where('id', '<', '6')->get();
        $asambleistas_plenaria[] = array();
        foreach ($presentes as $asambleista) {
            $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                . ' ' . $asambleista->user->persona->segundo_nombre
                . ' ' . $asambleista->user->persona->primer_apellido
                . ' ' . $asambleista->user->persona->segundo_apellido;
        }
        unset($asambleistas_plenaria[0]);
        $disco = "../storage/documentos/";

        return view('Agenda.discutir_punto_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('asambleistas_plenaria', $asambleistas_plenaria)
            ->with('propuestas', $propuestas);
    }

    public function modificar_propuesta(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();


        // ******* CUERPO DEL METODO
        $propuesta_antigua = Propuesta::where('id', '=', $request->id_propuesta)->first();

        // opcion 1 es para segunda ronda , opcion 2 es para eliminar la propuesta
        if ($request->opcion == 1) {
            $propuesta_nueva = new Propuesta();
            $propuesta_nueva->punto_id = $punto->id;
            $propuesta_nueva->asambleista_id = $propuesta_antigua->asambleista_id;
            $propuesta_nueva->nombre_propuesta = $propuesta_antigua->nombre_propuesta;
            $propuesta_nueva->votado = '0';
            $propuesta_nueva->activa = '1';
            $propuesta_nueva->ronda = '2';
            $propuesta_nueva->pareja = $propuesta_antigua->pareja;
            $propuesta_nueva->save();
            $propuesta_antigua->activa = '0';
            $propuesta_antigua->save();
        } else {
            $propuesta_antigua->delete();
        }
        // ******* CUERPO DEL METODO


        $propuestas = Propuesta::where('punto_id', '=', $punto->id)->orderBy('pareja', 'ASC')->orderBy('ronda', 'ASC')->get();
        //remplazar esta busqueda con los asambleistas realmente presentes
        $presentes = Asambleista::where('id', '<', '6')->get();
        $asambleistas_plenaria[] = array();
        foreach ($presentes as $asambleista) {
            $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                . ' ' . $asambleista->user->persona->segundo_nombre
                . ' ' . $asambleista->user->persona->primer_apellido
                . ' ' . $asambleista->user->persona->segundo_apellido;
        }
        unset($asambleistas_plenaria[0]);
        $disco = "../storage/documentos/";

        return view('Agenda.discutir_punto_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('asambleistas_plenaria', $asambleistas_plenaria)
            ->with('propuestas', $propuestas);
    }

    public function guardar_votacion(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();


        // ******* CUERPO DEL METODO
        if ($agenda->trascendental == 1) {
            $votacion_minima = Parametro::where('parametro','=','vmt')->first();// votacion minima trascendental
        } else {
            $votacion_minima = Parametro::where('parametro','=','vmn')->first();// votacion minima normal 
        }
         

        $propuesta = Propuesta::where('id', '=', $request->id_propuesta)->first();
        $propuesta->favor = $request->favor;
        $propuesta->contra = $request->contra;
        $propuesta->abstencion = $request->abstencion;
        $propuesta->nulo = $request->nulo;
        $propuesta->votado = '1';
        $propuesta->activa = '1';
        if($request->favor >= $votacion_minima->valor){
            $propuesta->ganadora = '1';
            // EN CASO QUE SE QUIERA TERMINAR EL PUNTO CUANDO SE ALCANZA LA VOTACION MINIMA
            //$propuesta->save();
            //return $this->resolverPunto($request->id_punto,$request->id_agenda);
        }else{
            $propuesta->ganadora = '0';
        }

        $propuesta->save();
        // ******* CUERPO DEL METODO


        $propuestas = Propuesta::where('punto_id', '=', $punto->id)->orderBy('pareja', 'ASC')->orderBy('ronda', 'ASC')->get();
        //remplazar esta busqueda con los asambleistas realmente presentes
        $presentes = Asambleista::where('id', '<', '6')->get();
        $asambleistas_plenaria[] = array();
        foreach ($presentes as $asambleista) {
            $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                . ' ' . $asambleista->user->persona->segundo_nombre
                . ' ' . $asambleista->user->persona->primer_apellido
                . ' ' . $asambleista->user->persona->segundo_apellido;
        }
        unset($asambleistas_plenaria[0]);
        $disco = "../storage/documentos/";

        return view('Agenda.discutir_punto_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('asambleistas_plenaria', $asambleistas_plenaria)
            ->with('propuestas', $propuestas);
    }

    public function agregar_intervencion(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();


        // ******* CUERPO DEL METODO
        $intervencion = new Intervencion();
        $intervencion->punto_id = $punto->id;
        $intervencion->asambleista_id = $request->asambleista_id_intervencion;
        $intervencion->descripcion = $request->nueva_intervencion;
        $intervencion->save();
        // ******* CUERPO DEL METODO


        $propuestas = Propuesta::where('punto_id', '=', $punto->id)->orderBy('pareja', 'ASC')->orderBy('ronda', 'ASC')->get();
        //remplazar esta busqueda con los asambleistas realmente presentes
        $presentes = Asambleista::where('id', '<', '6')->get();
        $asambleistas_plenaria[] = array();
        foreach ($presentes as $asambleista) {
            $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                . ' ' . $asambleista->user->persona->segundo_nombre
                . ' ' . $asambleista->user->persona->primer_apellido
                . ' ' . $asambleista->user->persona->segundo_apellido;
        }
        unset($asambleistas_plenaria[0]);
        $disco = "../storage/documentos/";
        //dd($punto->intervenciones);
        return view('Agenda.discutir_punto_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('asambleistas_plenaria', $asambleistas_plenaria)
            ->with('propuestas', $propuestas);
    }

    public function seguimiento_peticion_plenaria(Request $request, Redirector $redirect)
    {
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();
        $regresar = $request->regresar;

        // ******* CUERPO DEL METODO
        $id_peticion = $punto->peticion->id;


        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail(); //->paginate(10); para obtener todos los resultados  o null
        // ******* CUERPO DEL METODO

        $disco = "../storage/documentos/";
        return view('Agenda.seguimiento_peticion_plenaria')
            ->with('disco', $disco)
            ->with('agenda', $agenda)
            ->with('punto', $punto)
            ->with('regresar', $regresar)
            ->with('peticion', $peticion);

    }

    public function retirar_punto_plenaria(Request $request, Redirector $redirect)
    {


        // ******* CUERPO DEL METODO
        $punto = Punto::where('id', '=', $request->id_punto)->first();
        $punto->activo = '0';
        $punto->retirado = '1';
        $punto->save();
        //$peticion = Peticion::where('id', '=', $punto->peticion_id)->first();
        //$peticion->estado_peticion_id = EstadoPeticion::where('estado', '=', 'jd')->first()->id;

        // ******* CUERPO DEL METODO


        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get();
        $actualizado = 0;
        return view('Agenda.listado_puntos_plenaria')
            ->with('actualizado', $actualizado)
            ->with('agenda', $agenda)
            ->with('puntos', $puntos);
    }

    public function resolver_punto_plenaria(Request $request, Redirector $redirect)
    {

        return $this->resolverPunto($request->id_punto,$request->id_agenda);
        
    }

    public function fijar_puntos(Request $request, Redirector $redirect)
    {

        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $puntos = Punto::where('agenda_id', '=', $agenda->id)->orderBy('numero', 'ASC')->get();


        // ******* CUERPO DEL METODO
        $agenda->fijada = '1';
        $agenda->save();
        // ******* CUERPO DEL METODO
        $actualizado = 0;
        return view('Agenda.listado_puntos_plenaria')
            ->with('actualizado', $actualizado)
            ->with('agenda', $agenda)
            ->with('puntos', $puntos);
    }

    public function nuevo_orden_plenaria(Request $request, Redirector $redirect)
    {
        //dd();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $punto = Punto::where('id', '=', $request->id_punto)->first();
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

        return view('Agenda.listado_puntos_plenaria')
            ->with('actualizado', $actualizado)
            ->with('agenda', $agenda)// a que agenda del viernes agendare este punto
            ->with('puntos', $puntos);
    }

    public function consultar_agendas_vigentes()
    {
        $agendas = Agenda::where('vigente','=','1')->orderBy('created_at', 'ASC')->get();
        //$puntos = Punto::all();
        return view('Agenda.consultar_agendas_vigentes')
        ->with('agendas',$agendas);
    }

    public function detalles_punto_agenda(Request $request)
    {
        $id_peticion = $request->id_peticion;
        $disco = "../storage/documentos/";

        $peticion = Peticion::where('id', '=', $id_peticion)->firstOrFail();
        return view('Agenda.detalles_punto_agenda')
            ->with('disco', $disco)
            ->with('peticion', $peticion);
    }

    public function agregar_asambleistas_sesion(Request $request){

        $id_asambleistas = $request->get("asambleistas");
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();

        foreach ($id_asambleistas as $id_asambleista) {
            $ingresado  = Asistencia::where('agenda_id','=',$agenda->id)->where('asambleista_id','=',$id_asambleista)->count();
                if ($ingresado == 0) {
                    $asambleista_dato = Asambleista::where('id','=',$id_asambleista)->first();
                    $asistencia = new Asistencia();
                    $asistencia->agenda_id = $agenda->id; //************
                    $asistencia->asambleista_id = $asambleista_dato->id; //************
                    //$asistencia->estado_asistencia_id = 3; // estado normal de asistencia es 3 
                    $asistencia->entrada = Carbon::now();

                    $propietarios = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$asambleista_dato->facultad_id)
                                            ->where('asambleistas.sector_id','=',$asambleista_dato->sector_id)
                                            ->count();
                    //si hay dos personas , las siguientes 2 solo pueden ser suplentes los
                    //cambios entre suplente y propietario se hacen en otra pantalla
                    if ($propietarios <= 1) {   
                        $asistencia->propietaria = 1;
                    } else {
                        $asistencia->propietaria = 0;
                    }

                    $asistencia->save();

                    $tiempo = new Tiempo();
                    $tiempo->asistencia_id = $asistencia->id;
                    $tiempo->estado_asistencia_id = 3;
                    $tiempo->entrada = Carbon::now();

                    if ($propietarios <= 1) {   
                        $tiempo->tiempo_propietario = 1;
                    } else {
                        $tiempo->tiempo_propietario = 0;
                    }
                    $tiempo->save();
                }
                else{
                        //dd("ya estaba");
                }
        }
                                    //dd($propietarios);

        //$request->session()->flash("success", "Asambleista(s) agregado(s) con exito " .$cargo->id);
        $request->session()->flash("success", "Asambleista(s) agregado(s) con exito ");

        //$agenda = Agenda::where('id', '=', $request->agenda_id)->first();
        $periodo_activo = Periodo::where('activo','=','1')->first();

        $array_asambleistas_sesion = Asistencia::where('agenda_id','=',$agenda->id)->pluck('asambleista_id')->toArray();
        /*dd($asistencias);
        $array_asambleistas_sesion = array();
        foreach ($asistencias as $asistencia){
            array_push($array_asambleistas_sesion,$asistencia->asambleista_id);
        }
        */
        //dd($array_asambleistas_sesion);
        //remover del select los asambleistas ya ingresas
        $asambleistas = Asambleista::where('activo','=', 1)
            ->where('periodo_id','=',$periodo_activo->id)
            //->where('facultad_id','=','5')
            ->whereNotIn('id',$array_asambleistas_sesion)
            ->get();

        $ultimos_ingresos  = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->take(5)->get();
        $facultades = Facultad::where('id','!=','0')->get();
        $asistentes = Asistencia::where('agenda_id','=',$agenda->id)->orderBy('created_at', 'DESC')->get();

        $conteo = array(
            "pro" => "0",
            "csup" => "0",
            "cpro" => "0",
            "sup" => "0",
            "total" => "0",
        );
        $conteo["pro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asistencias.propietaria','=','1')
            ->where('asambleistas.propietario','=','1')
            ->count();

        $conteo["csup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asistencias.propietaria','=','0')
            ->where('asambleistas.propietario','=','1')
            ->count();

        $conteo["cpro"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asistencias.propietaria','=','1')
            ->where('asambleistas.propietario','=','0')
            ->count();

        $conteo["sup"] = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asistencias.propietaria','=','0')
            ->where('asambleistas.propietario','=','0')
            ->count();

        $conteo["total"] = Asistencia::where('agenda_id','=',$agenda->id)->count();


        return view('Agenda.sala_sesion_plenaria')
            ->with('agenda', $agenda)
            ->with('facultades', $facultades)
            ->with('asistentes', $asistentes)
            ->with('asambleistas', $asambleistas)
            ->with('conteo', $conteo)
            ->with('ultimos_ingresos', $ultimos_ingresos);
    }

    //cambiar entre propietario y suplente para todos los asambleistas
    public function gestionar_asistencia(Request $request,Redirector $redirect)
    {
        $facultad = Facultad::where('id','=',$request->id_facultad)->first();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $periodo = Periodo::where('activo','=','1')->first();

        $asambleistas = Asambleista::where('activo','=', 1)
            ->where('periodo_id','=',$periodo->id)
            ->where('facultad_id','=',$facultad->id)
            ->get();

        $asistentes  =  Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asambleistas.facultad_id','=',$facultad->id)
            ->select('asistencias.*')
            ->get();

        //$sector1 = 
            /* */
        $sector1 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','1')
                                            ->count();
        $sector2 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','2')
                                            ->count();
        $sector3 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','3')
                                            ->count();
        
                                            
            

        return view('Agenda.gestionar_asistencia')
            ->with('sector1', $sector1)
            ->with('sector2', $sector2)
            ->with('sector3', $sector3)
            ->with('agenda', $agenda)
            ->with('facultad', $facultad)
            ->with('asistentes', $asistentes)
            ->with('asambleistas', $asambleistas);






    }

    public function cambiar_propietaria(Request $request)
    {
        $asistencia = Asistencia::where('id','=',$request->id_asistente)->first();

        if ($asistencia->propietaria == 1) {
            $asistencia->propietaria = 0 ;            
        } else {
            $asistencia->propietaria = 1 ;
        }
        $asistencia->save();

        //Cambiar el estado del ultimo registro de permanencia
        $ultimo_tiempo = Tiempo::where('asistencia_id','=',$asistencia->id)->latest()->first();
        if ($ultimo_tiempo) {
            $ultimo_tiempo->salida = Carbon::now();
            $ultimo_tiempo->estado_asistencia_id = '4';
            $ultimo_tiempo->save();
        }
        



        //crear uno nuevo por que cambia el estado para tomar en cuenta en dietas
        $tiempo = new Tiempo();
        $tiempo->asistencia_id = $asistencia->id;
        $tiempo->estado_asistencia_id = '3';
        $tiempo->entrada = Carbon::now();
        //el estado actual del asambleista dentro de la sesion plenaria
        $tiempo->tiempo_propietario = $asistencia->propietaria;
        
        $tiempo->save();
        
       //Pantalla antigua
        $facultad = Facultad::where('id','=',$request->id_facultad)->first();
        $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
        $periodo = Periodo::where('activo','=','1')->first();

        $asambleistas = Asambleista::where('activo','=', 1)
            ->where('periodo_id','=',$periodo->id)
            ->where('facultad_id','=',$facultad->id)
            ->get();

        $asistentes  =  Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id','=',$agenda->id)
            ->where('asambleistas.facultad_id','=',$facultad->id)
            ->select('asistencias.*')
            ->get();

        //$sector1 = 
            /* */
        $sector1 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','1')
                                            ->count();
        $sector2 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','2')
                                            ->count();
        $sector3 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
                                            ->where('asistencias.agenda_id','=',$agenda->id)
                                            ->where('asistencias.propietaria','=','1')
                                            ->where('asambleistas.facultad_id','=',$facultad->id)
                                            ->where('asambleistas.sector_id','=','3')
                                            ->count();
        
                                            
            

        return view('Agenda.gestionar_asistencia')
            ->with('sector1', $sector1)
            ->with('sector2', $sector2)
            ->with('sector3', $sector3)
            ->with('agenda', $agenda)
            ->with('facultad', $facultad)
            ->with('asistentes', $asistentes)
            ->with('asambleistas', $asambleistas);

     
    }

    public function obtener_datos_intervencion(Request $request){
        if ($request->ajax()){
            $intervencion = Intervencion::find($request->get("idIntervencion"));
            $respuesta = new \stdClass();
            $respuesta->asambleista = $intervencion->asambleista->user->persona->primer_nombre . ' ' . $intervencion->asambleista->user->persona->segundo_nombre . ' ' . $intervencion->asambleista->user->persona->primer_apellido . ' ' . $intervencion->asambleista->user->persona->segundo_apellido;
            $respuesta->contenido = $intervencion->descripcion;
            return new JsonResponse($respuesta);
        }
    }

    public function retiro_temporal(Request $request)
    {
        switch ($request->tipo) {
            //retiro temporal
            case 1:
                $asistencia = Asistencia::where("agenda_id", $request->agenda)->where("asambleista_id",$request->asambleista)->first();
                $asistencia->temporal = 1;
                $asistencia->save();
                $tiempo = Tiempo::where("asistencia_id",$asistencia->id)->orderBy('updated_at','desc')->first();
                $tiempo->estado_asistencia_id = 1;
                $tiempo->salida = Carbon::now();
                $tiempo->save();
                $request->session()->flash("success", "Retiro temporal realizado con exito ");
                break;
            //retiro permanente
            case 2:
                $asistencia = Asistencia::where("agenda_id", $request->agenda)->where("asambleista_id",$request->asambleista_permanente)->first();
                $asistencia->salida = Carbon::now();
                $asistencia->temporal = 2; //se concluyo
                $asistencia->save();
                $tiempo = Tiempo::where("asistencia_id",$asistencia->id)->orderBy('updated_at','desc')->first();
                $tiempo->estado_asistencia_id = 2;
                $tiempo->salida = Carbon::now();
                $tiempo->save();
                $request->session()->flash("success", "Retiro Permanente realizado con exito ");
                break;
            //reincorporar
            case 3:
                $asistencia = Asistencia::where("agenda_id", $request->agenda)->where("asambleista_id",$request->asambleista_reincorporar)->first();
                $asistencia->temporal = 0;
                $asistencia->save();
                $tiempo = new Tiempo();
                $tiempo->asistencia_id = $asistencia->id;
                $tiempo->estado_asistencia_id = 3; //normal
                $tiempo->tiempo_propietario = 0;
                $tiempo->entrada = Carbon::now();
                $tiempo->save();

                $request->session()->flash("success", "Asambleista reincorporado a la sesion vigente con exito ");
                break;
        }

        $facultad = Facultad::where('id', '=', $request->facultad_modal)->first();
        $agenda = Agenda::where('id', '=', $request->agenda)->first();
        $periodo = Periodo::where('activo', '=', '1')->first();

        $asambleistas = Asambleista::where('activo', '=', 1)
            ->where('periodo_id', '=', $periodo->id)
            ->where('facultad_id', '=', $facultad->id)
            ->get();

        $asistentes = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id', '=', $agenda->id)
            ->where('asambleistas.facultad_id', '=', $facultad->id)
            ->select('asistencias.*')
            ->get();

        //$sector1 =
        /* */
        $sector1 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id', '=', $agenda->id)
            ->where('asistencias.propietaria', '=', '1')
            ->where('asambleistas.facultad_id', '=', $facultad->id)
            ->where('asambleistas.sector_id', '=', '1')
            ->count();
        $sector2 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id', '=', $agenda->id)
            ->where('asistencias.propietaria', '=', '1')
            ->where('asambleistas.facultad_id', '=', $facultad->id)
            ->where('asambleistas.sector_id', '=', '2')
            ->count();
        $sector3 = Asistencia::join("asambleistas", "asambleistas.id", "=", "asistencias.asambleista_id")
            ->where('asistencias.agenda_id', '=', $agenda->id)
            ->where('asistencias.propietaria', '=', '1')
            ->where('asambleistas.facultad_id', '=', $facultad->id)
            ->where('asambleistas.sector_id', '=', '3')
            ->count();

        return view('Agenda.gestionar_asistencia')
            ->with('sector1', $sector1)
            ->with('sector2', $sector2)
            ->with('sector3', $sector3)
            ->with('agenda', $agenda)
            ->with('facultad', $facultad)
            ->with('asistentes', $asistentes)
            ->with('asambleistas', $asambleistas);
    }

    public function numero_mes($mesnum)
    {

        $mes = ' ';
        if ($mesnum == 1) {

            $mes = 'enero';
        }
        if ($mesnum == 2) {

            $mes = 'febrero';
        }
        if ($mesnum == 3) {

            $mes = 'marzo';
        }
        if ($mesnum == 4) {

            $mes = 'abril';
        }
        if ($mesnum == 5) {

            $mes = 'mayo';
        }
        if ($mesnum == 6) {

            $mes = 'junio';
        }
        if ($mesnum == 7) {

            $mes = 'julio';
        }
        if ($mesnum == 8) {

            $mes = 'agosto';
        }
        if ($mesnum == 9) {

            $mes = 'septiembre';
        }
        if ($mesnum == 10) {

            $mes = 'octubre';
        }
        if ($mesnum == 11) {

            $mes = 'noviembre';
        }
        if ($mesnum == 12) {

            $mes = 'diciembre';
        }

        return $mes;
    }

}
