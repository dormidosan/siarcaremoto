<?php

namespace App\Http\Controllers;

use App\Periodo;
use App\Peticion;
use App\Bitacora;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Redirector;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TipoDocumento;
use App\Documento;
use Auth;
use App\Http\Requests\DocumentoRequest;
use Illuminate\Support\Facades\Route;


class DocumentoController extends Controller
{
    public function busqueda()
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        // ////////////////////
        $nombre_documento = null ;
        $tipo_documento = null ;
        $periodo = null;
        $descripcion = null;
        $disco = "../storage/documentos/";
        
        if (Auth::guest()) {
            $tipo_documentos = TipoDocumento::where('tipo', '=', 'acuerdo')->orWhere('tipo', '=', 'acta')->pluck('tipo', 'id');
        } else {
            $tipo_documentos = TipoDocumento::where('id', '!=', '0')->pluck('tipo', 'id');
        }
        
        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');
        //$documentos = Documento::all();

        return view('General.BusquedaDocumentos')
        ->with('periodo', $periodo)
        ->with('periodos', $periodos)
        ->with('descripcion', $descripcion)
        ->with('tipo_documento', $tipo_documento)
        ->with('tipo_documentos', $tipo_documentos)
        ->with('nombre_documento', $nombre_documento)
        //->with('documentos', $documentos)
        ->with('disco', $disco);
                // ////////////////////
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
        


    }

    public function buscar_documentos(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        // ////////////////////
        //se obtienen los inputs
        //dd($request->all());
        $nombre_documento = $request->get("nombre_documento");
        $tipo_documento = $request->get("tipo_documento");
        $periodo = $request->get("periodo");
        $descripcion = $request->get("descripcion");

        //variables generales
        $disco = "../storage/documentos/";
        $tipo_documentos = TipoDocumento::where('id', '!=', '0')->pluck('tipo', 'id');
        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');


        $documentos = Documento::query();

        if($tipo_documento != "")
            $documentos = $documentos->where("documentos.tipo_documento_id", $tipo_documento);
        if($nombre_documento != "")
            $documentos = $documentos->where("documentos.nombre_documento","LIKE","%".$nombre_documento."%");
        if ($periodo != "")
            $documentos = $documentos->where("documentos.periodo_id", $periodo);
        if ($descripcion != "")
            $documentos = $documentos->join("seguimientos", "seguimientos.documento_id", "=", "documentos.id")
                ->join("peticiones", "seguimientos.peticion_id", "=", "peticiones.id")
                ->where("peticiones.descripcion", "LIKE", "%" . $descripcion . "%");

        $documentos = $documentos->get();


        return view('General.BusquedaDocumentos')
        ->with('disco', $disco)
        ->with('documentos', $documentos)
        ->with('periodo', $periodo)
        ->with('periodos', $periodos)
        ->with('descripcion', $descripcion)
        ->with('tipo_documento', $tipo_documento)
        ->with('tipo_documentos', $tipo_documentos)
        ->with('nombre_documento', $nombre_documento);
                // ////////////////////
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
        

    }


    public function descargar_documento($id)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        // ////////////////////
        //dd();
        $documento = Documento::find($id);
        $ruta_documento = "../storage/documentos/" . $documento->path;
        return response()->download($ruta_documento);
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
