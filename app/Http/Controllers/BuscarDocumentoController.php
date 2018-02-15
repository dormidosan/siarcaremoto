<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Routing\Redirector;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TipoDocumento;
use App\Documento;

class BuscarDocumentoController extends Controller
{

    public function busqueda()
    {
        $tipo_documentos = TipoDocumento::all();
        $documentos = Documento::where('tipo_documento_id','=',0)->get(); //->paginate(10); para obtener ningun resultado ya que se pinta en blanco
        $periodos = Periodo::all();
        $disco = "../storage/documentos/";
        return view('General.BusquedaDocumentos', ['documentos' => $documentos, "disco" => $disco, "tipo_documentos" => $tipo_documentos, "periodos" => $periodos]);
    }

    public function buscar_documento(Request $request, Redirector $redirect)
    {
        // SOLO BUSCAR POR TIPO ACTUALMENTE
        //dd($request->all());
        $tipo_documentos = TipoDocumento::all();
        $periodos = Periodo::all();
        //SELECT * FROM documentos WHERE nombre_documento LIKE '%%' AND tipo_documento_id = 2;
        $documentos = Documento::where('tipo_documento_id', '=', $request->tipo_documento)->get();
        $disco = "../storage/documentos/";
        return view('General.BusquedaDocumentos', ['documentos' => $documentos, "disco" => $disco, "tipo_documentos" => $tipo_documentos, "periodos" => $periodos]);
    }

    public function descargar_documento($id)
    {
        $documento = Documento::find($id);
        $ruta_documento = "../storage/documentos/".$documento->path;
        return response()->download($ruta_documento);
    }
    
}





