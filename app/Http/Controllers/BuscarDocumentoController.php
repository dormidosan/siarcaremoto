<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TipoDocumento;
use App\Documento;
use App\Bitacora;
use Auth;

class BuscarDocumentoController extends Controller
{

    public function busqueda()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            // ////////////////////
            $tipo_documentos = TipoDocumento::all();
            $documentos = Documento::where('tipo_documento_id', '=', 0)->get(); //->paginate(10); para obtener ningun resultado ya que se pinta en blanco
            $periodos = Periodo::all();
            $disco = "../storage/documentos/";
            return view('General.BusquedaDocumentos', ['documentos' => $documentos, "disco" => $disco, "tipo_documentos" => $tipo_documentos, "periodos" => $periodos]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function buscar_documento(Request $request, Redirector $redirect)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            // ////////////////////
            // SOLO BUSCAR POR TIPO ACTUALMENTE
            //dd($request->all());
            $tipo_documentos = TipoDocumento::all();
            $periodos = Periodo::all();
            //SELECT * FROM documentos WHERE nombre_documento LIKE '%%' AND tipo_documento_id = 2;
            $documentos = Documento::where('tipo_documento_id', '=', $request->tipo_documento)->get();
            $disco = "../storage/documentos/";
            return view('General.BusquedaDocumentos', ['documentos' => $documentos, "disco" => $disco, "tipo_documentos" => $tipo_documentos, "periodos" => $periodos]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function descargar_documento($id)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            // ////////////////////
            $documento = Documento::find($id);
            $ruta_documento = "../storage/documentos/" . $documento->path;
            return response()->download($ruta_documento);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function guardar_bitacora($accion, $evento)
    {
        if (!(Auth::guest())) {
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





