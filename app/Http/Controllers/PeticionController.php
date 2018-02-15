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
use App\Http\Requests\PeticionRequest;

class PeticionController extends Controller
{
    //


    public function registrar_peticion(Request $request, Redirector $redirect)
    {
        $peticion = Peticion::where('estado_peticion_id', '=', 0)->first(); // DEVUELVE CERO
        return view('General.registro_peticion')
            ->with('peticion', $peticion);
    }

    public function listado_peticiones()
    {
        $peticiones = Peticion::where('id', '!=', 0)->orderBy('estado_peticion_id', 'ASC')->orderBy('updated_at', 'ASC')->get();

        return view('General.listado_peticiones')
            ->with('peticiones', $peticiones);
    }


    public function registrar_peticion_post(Request $request, Redirector $redirect)
    {

        $disco = "../storage/documentos/";
        $documentos_id = array();
        $peticion = new Peticion();
        $seguimiento = new Seguimiento();

        $peticion->estado_peticion_id = '2'; // NUEVAS PETICIONES EN ESTADO JD
        $peticion->periodo_id = Periodo::latest()->first()->id;
        $peticion->codigo = hash("crc32", microtime(), false);
        //$peticion->nombre = $request->nombre;
        $peticion->descripcion = $request->descripcion;
        $peticion->peticionario = $request->peticionario;;
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
        $seguimiento->descripcion = "Inicio de control en: JD";
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

        return view('General.registro_peticion')
            ->with('disco', $disco)
            ->with('peticion', $peticion);
    }

    public function monitoreo_peticion()
    {
        return view("General.monitoreo_peticion", array("peticionBuscada" => ""));
    }

    public function consultar_estado_peticion(Request $request)
    {
        $peticionBuscada = Peticion::where("codigo", $request->get("codigo_peticion"))->first();
        $disco = "../storage/documentos/";
        return view("General.monitoreo_peticion", array("peticionBuscada" => $peticionBuscada,"disco"=>$disco));
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


}

