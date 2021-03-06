<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

use Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Documento;
use App\Peticion;
use App\Periodo;
use App\Seguimiento;
use App\EstadoSeguimiento;
use App\Bitacora;
use Auth;
use App\Http\Requests\PeticionRequest;
use Mail;
use Session;
use Illuminate\Support\Facades\Route;

class PeticionController extends Controller
{
    //


    public function registrar_peticion(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $peticion = Peticion::where('estado_peticion_id', '=', 0)->first(); // DEVUELVE CERO
        return view('General.registro_peticion')
            ->with('peticion', $peticion);      
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function listado_peticiones()
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get();

        return view('General.listado_peticiones')
            ->with('peticiones', $peticiones);      
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }


    public function registrar_peticion_post(Request $request, Redirector $redirect)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");

        $disco = "../storage/documentos/";
        $documentos_id = array();
        $peticion = new Peticion();
        $seguimiento = new Seguimiento();

        $peticion->estado_peticion_id = '2'; // NUEVAS PETICIONES EN ESTADO JD
        $peticion->periodo_id = Periodo::latest()->first()->id;
        $peticion->codigo = hash("crc32", microtime(), false);
        //$peticion->nombre = $request->nombre;
        $peticion->descripcion = $request->descripcion;
        $peticion->peticionario = $request->peticionario;
        $peticion->fecha = Carbon::now();
        $peticion->correo = $request->correo;
        $peticion->telefono = $request->telefono;
        $peticion->direccion = $request->direccion;
        $peticion->resuelto = 0;
        $peticion->agendado = 0;
        $peticion->asignado_agenda = 0;
        $peticion->comision = 0;

        if ($request->hasFile('documento_peticion')) {
            //$archivo = $request->documento_peticion;
            $documento = $this->guardarDocumento($request->documento_peticion, '1', 'documentos');
            array_push($documentos_id, $documento->id);
        }


        if ($request->hasFile('documento_atestado')) {
            foreach ($request->documento_atestado as $archivo) {

                $documento = $this->guardarDocumento($archivo, '2', 'documentos');
                array_push($documentos_id, $documento->id);
            }

        }

        $peticion->save();
        $peticion->documentos()->sync($documentos_id);


        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = '1';
        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "cr")->first()->id;  // CR estado creado
        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';
        $seguimiento->descripcion = 'creacion de peticion';
        $seguimiento->save();


        foreach ($documentos_id as $documento_seguimiento) {

            $seguimiento = new Seguimiento();

            $seguimiento->peticion_id = $peticion->id;
            $seguimiento->comision_id = '1';

            $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "cr")->first()->id; // CR estado creado
            $seguimiento->documento_id = $documento_seguimiento;
            $seguimiento->inicio = Carbon::now();
            $seguimiento->fin = Carbon::now();
            $seguimiento->activo = '0';
            $seguimiento->agendado = '0';

            //$seguimiento->descripcion = Parametro::where('parametro','=','des_nuevo_seguimiento')->get('valor');
            $seguimiento->descripcion = 'documento de creacion de peticion';
            $seguimiento->save();
        }


        // La JD siempre debe tener el seguimiento para la peticion
        $seguimiento = new Seguimiento();
        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = '1';

        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "se")->first()->id;  // CR estado creado
        // La JD siempre debe tener el seguimiento para la peticion
        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';
        $seguimiento->descripcion = "Control en: JD";
        $seguimiento->save();


        $seguimiento = new Seguimiento();
        $seguimiento->peticion_id = $peticion->id;
        $seguimiento->comision_id = '1';
        $seguimiento->estado_seguimiento_id = EstadoSeguimiento::where('estado', '=', "as")->first()->id; // AS Asignado
        $seguimiento->inicio = Carbon::now();
        $seguimiento->fin = Carbon::now();
        $seguimiento->activo = '0';
        $seguimiento->agendado = '0';
        $seguimiento->descripcion = "Asignado a: JD";
        $guardado = $seguimiento->save();

        $peticion_creada = $this->correos_peticion_creada($peticion);

        return view('General.registro_peticion')
            ->with('disco', $disco)
            ->with('peticion', $peticion);      
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function monitoreo_peticion()
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        return view("General.monitoreo_peticion", array("peticionBuscada" => ""));      
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function consultar_estado_peticion(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $peticionBuscada = Peticion::where("codigo", $request->get("codigo_peticion"))->first();
        $disco = "../storage/documentos/";
        return view("General.monitoreo_peticion", array("peticionBuscada" => $peticionBuscada,"disco"=>$disco));
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


    public function correos_peticion_creada($peticion)
    {    
        $asunto = "Creacion de peticion AGU ";

            // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $correo_destinatario = $peticion->correo;

         Mail::queue('correos.peticion_creada_mail', ['peticion' => $peticion], 
                function ($mail) use ($asunto,$correo_destinatario) {
                $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
                $mail->to($correo_destinatario);
                $mail->subject($asunto);
            });  

            return 0;
        
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

