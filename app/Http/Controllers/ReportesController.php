<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportesRequest;
use App\Http\Requests\ReportesPermisosTemporalesRequest;
use App\Http\Requests\ReportesPermisosPermanentesRequest;
use App\Http\Requests\BuscarBitacoraCorrespRequest;
use App\Http\Requests\ReportesAsistenciasRequest;
use App\Http\Requests\ReportesConsolidadosRentaRequest;
use App\Http\Requests\ReporteAsambleistaPeriodoRequest;
use Illuminate\Support\Facades\DB;
use Response;
use App\Asambleista;
use Carbon\Carbon;
use App\Peticion;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\JsonResponse;
use App\Clases\Mensaje;
use App\Periodo;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function buscar_periodo()
    {

        $periodo = null;
        $resultados = NULL;
        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');

        return view('Reportes.Reporte_Asambleistas_Periodo')
            ->with('periodo', $periodo)
            ->with('periodos', $periodos)
            ->with('resultados', $resultados);


    }

    public function buscar_cumple()
    {

        $periodo = null;
        $resultados = NULL;
        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');


      

        return view('Reportes.Reporte_Asambleistas_Cumple')
            ->with('periodo', $periodo)
            ->with('periodos', $periodos)
            ->with('resultados', $resultados);


    }

    public function buscar_asambleistas_cumple(ReporteAsambleistaPeriodoRequest $request)
    {


        $periodo = $request->get("periodo");
        $mes = $request->get("mes");

        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');
//dd($periodo);

        $resultados = DB::table('asambleistas')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('periodos', 'asambleistas.periodo_id', '=', 'periodos.id')
            ->where('periodos.id', '=', $periodo)
            ->whereMonth('personas.nacimiento', '=', $mes)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'asambleistas.propietario', 'personas.dui', 'personas.nit', 'users.email', 'periodos.nombre_periodo')
            ->limit(1)
            ->get();;

        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }

        return view("Reportes.Reporte_Asambleistas_Cumple")
            ->with('resultados', $resultados)
            ->with('periodo', $periodo)
            ->with('periodos', $periodos)
            ->with('mesnom', $this->numero_mes($mes))
            ->with('mes', $mes);

    }

    public function buscar_asambleistas_periodo(ReporteAsambleistaPeriodoRequest $request)
    {


        $periodo = $request->get("periodo");
        $periodos = Periodo::where('id', '!=', '0')->pluck('nombre_periodo', 'id');
//dd($periodo);

        $resultados = DB::table('asambleistas')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->join('periodos', 'asambleistas.periodo_id', '=', 'periodos.id')
            ->where('periodos.id', '=', $periodo)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'facultades.nombre as NomFac', 'asambleistas.propietario', 'personas.dui', 'personas.nit', 'users.email', 'periodos.nombre_periodo')
            ->limit(1)
            ->get();;

        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }

        return view("Reportes.Reporte_Asambleistas_Periodo")
            ->with('resultados', $resultados)
            ->with('periodo', $periodo)
            ->with('periodos', $periodos);

    }

    public function Reporte_Asambleistas_Cumple($tipo)
    {

        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $periodo = $parametros[1];
        $mes = $parametros[2];

        $nombre_periodos = DB::table('periodos')
            ->where('periodos.id', '=', $periodo)
            ->first();

        $resultados = DB::table('asambleistas')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->join('periodos', 'asambleistas.periodo_id', '=', 'periodos.id')
            ->where('periodos.id', '=', $periodo)
            ->whereMonth('personas.nacimiento', '=', $mes)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'facultades.nombre as NomFac', 'asambleistas.propietario'
                , 'personas.dui', 'personas.nit', 'users.email', 'periodos.nombre_periodo', 'personas.nacimiento')
            ->orderBy('personas.nacimiento', 'asc')
            ->get();

        //dd($resultados);


        $mesnom = $this->numero_mes($mes);

        $view = \View::make('Reportes/Reporte_Asambleistas_Cumple_pdf', compact('resultados', 'nombre_periodos', 'mesnom'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Cumple_' . $mesnom . '_' . $nombre_periodos->nombre_periodo . '_' . $hoy . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Cumple_' . $mesnom . '_' . $nombre_periodos->nombre_periodo . '_' . $hoy . '.pdf');
        }

    }

    public function Reporte_Asambleista_Periodo($tipo)
    {

        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $periodo = $parametros[1];

        $nombre_periodos = DB::table('periodos')
            ->where('periodos.id', '=', $periodo)
            ->first();

        $resultados = DB::table('asambleistas')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->join('periodos', 'asambleistas.periodo_id', '=', 'periodos.id')
            ->where('periodos.id', '=', $periodo)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'facultades.nombre as NomFac', 'asambleistas.propietario', 'personas.dui', 'personas.nit', 'users.email', 'periodos.nombre_periodo')
            ->orderBy('facultades.nombre', 'desc')
            ->get();

        //dd($resultados);

        $view = \View::make('Reportes/Reporte_Asambleistas_Periodo_pdf', compact('resultados', 'nombre_periodos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter', 'landscape')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Asambleistas_' . $nombre_periodos->nombre_periodo . '_' . $hoy . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Asambleistas_' . $nombre_periodos->nombre_periodo . '_' . $hoy . '.pdf');
        }

    }


    public function Reporte_permisos_temporales($tipo)
    {


        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $idagenda = $parametros[1];
        $idperiodo = $parametros[2];
        $fecha = $parametros[3];

        $nombreperiodo1 = DB::table('periodos')
            ->where('periodos.id', '=', $idperiodo)
            ->select('periodos.nombre_periodo')
            ->get();

        $nombreperiodo = $nombreperiodo1[0]->nombre_periodo;
        //dd($nombreperiodo);


        $resultados = DB::table('asistencias')
            ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
            ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
            ->where('estado_asistencias.id', '=', 1)//1 por ser permisos temporales
            ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el id
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'asistencias.entrada', 'asistencias.salida', 'asistencias.propietaria')
            ->get();


        $view = \View::make('Reportes/Reporte_permisos_temporales_pdf', compact('resultados', 'fecha'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);


        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Permisos_Temporales_' . $fecha . '_' . $hoy . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Permisos_Temporales_' . $fecha . '_' . $hoy . '.pdf');
        }


    }

    public function Reporte_permisos_permanentes($tipo)
    {

        //dd($tipo);
        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $fechainicial = $parametros[1];
        $fechafinal = $parametros[2];


        $resultados = DB::table('permisos')
            ->join('asambleistas', 'permisos.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->where
            ([
                ['permisos.fecha_permiso', '>=', $fechainicial],
                ['permisos.fecha_permiso', '<=', $fechafinal]
            ])
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'personas.dui', 'personas.nit', 'personas.afp', 'personas.cuenta', 'permisos.motivo',
                'permisos.fecha_permiso', 'permisos.inicio', 'permisos.fin', 'permisos.delegado_id', 'personas.primer_apellido as delegado')
            ->get();


        $i = 0;
        foreach ($resultados as $resultado) {

            $delegado = DB::table('asambleistas')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre')
                ->where('asambleistas.id', '=', $resultado->delegado_id)
                ->first();

            if ($delegado == NULL) {

                $resultados[$i]->delegado = 'No Delegado';


            } else {

                $resultados[$i]->delegado = $delegado->primer_nombre . ' ' . $delegado->primer_apellido;

            }

        }


        $view = \View::make('Reportes/Reporte_permisos_permanentes_pdf', compact('resultados', 'fechainicial', 'fechafinal'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Permisos_permanentes_del_' . $fechainicial . '_al_' . $fechafinal . '_' . $hoy . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Permisos_permanentes_del_' . $fechainicial . '_al_' . $fechafinal . '_' . $hoy . '.pdf');
        }

    }


    public function Reporte_asistencias_sesion_plenaria($tipo)
    {


        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $sector = $parametros[1];
        $idagenda = $parametros[2];
        $fecheperiodo = $parametros[3];
        $idperiodo = $parametros[4];

        $nombreperiodo1 = DB::table('periodos')
            ->where('periodos.id', '=', $idperiodo)
            ->select('periodos.nombre_periodo')
            ->get();

        $nombre_agenda = DB::table('agendas')
            ->where('agendas.id', '=', $idagenda)
            ->first();


        $nombreperiodo = $nombreperiodo1[0]->nombre_periodo;

        if ($sector == 'E') {

            $resultados = DB::table('asistencias')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
                ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
                ->where('estado_asistencias.id', '=', 3)//3 por ser asistencias
                ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el id
                ->where('asambleistas.sector_id', '=', 1)//sector estudiantil
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'tiempos.entrada', 'tiempos.salida', 'asistencias.propietaria', 'facultades.nombre')
                ->orderBy('facultades.nombre', 'desc')
                ->get();
            $sector = 'ESTUDIANTIL';
        }


        if ($sector == 'D') {

            $resultados = DB::table('asistencias')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
                ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
                ->where('estado_asistencias.id', '=', 3)//3 por ser asistencias
                ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el i
                ->where('asambleistas.sector_id', '=', 2)//sector estudiantil
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'tiempos.entrada', 'tiempos.salida', 'asistencias.propietaria', 'facultades.nombre')
                ->orderBy('facultades.nombre', 'desc')
                ->get();
            $sector = 'DOCENTE';
        }


        if ($sector == 'ND') {

            $resultados = DB::table('asistencias')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
                ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
                ->where('estado_asistencias.id', '=', 3)//3 por ser asistencias
                ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el id
                ->where('asambleistas.sector_id', '=', 3)//sector estudiantil
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'tiempos.entrada', 'tiempos.salida', 'asistencias.propietaria', 'facultades.nombre')
                ->orderBy('facultades.nombre', 'desc')
                ->get();
            $sector = 'NO DOCENTE';
        }


        $view = \View::make('Reportes/Reporte_asistencias_sesion_plenaria_pdf', compact('resultados', 'sector', 'nombreperiodo'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'landscape')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Asistencias_' . $nombre_agenda->codigo . '_' . $nombre_agenda->fecha . '_' . $hoy . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Asistencias_' . $nombre_agenda->codigo . '_' . $nombre_agenda->fecha . '_' . $hoy . '.pdf');
        }

        //return $pdf->stream('invoice.pdf'); //mostrar pdf en pagina
        //return $pdf->download('invoice.pdf'); // descargar el archivo pdf


    }


    public function Reporte_bitacora_correspondencia($tipo)
    {

        //dd($tipo);

        $parametros = explode('.', $tipo);


        $tipodes = $parametros[0];
        $fechainicial = $parametros[1];
        $fechafinal = $parametros[2];


        $resultados = DB::table('peticiones')
            ->join('estado_peticiones', 'estado_peticiones.id', '=', 'peticiones.estado_peticion_id')
            ->where
            ([
                ['peticiones.fecha', '>=', $fechainicial],
                ['peticiones.fecha', '<=', $fechafinal]
            ])
            ->get();

        $view = \View::make('Reportes/Reporte_bitacora_correspondencia_pdf',
            compact('resultados', 'fechainicial', 'fechafinal'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        //$pdf->loadHTML($view)->setPaper('a4')->setOrientation('landscape'); // cambiar tamaño y orientacion del papel
        $pdf->loadHTML($view)->setPaper('letter', 'landscape')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($tipodes == 1) {
            return $pdf->stream('Bitacora_Correspondeica_del_' . $fechainicial . '_al_' . $fechafinal . '.pdf');
        }
        if ($tipodes == 2) {
            return $pdf->download('Bitacora_Correspondeica_del_' . $fechainicial . '_al_' . $fechafinal . '.pdf');
        }

        //return $pdf->stream('invoice.pdf'); //mostrar pdf en pagina
        //return $pdf->download('invoice.pdf'); // descargar el archivo pdf


    }

    public function buscar_consolidados_renta(ReportesConsolidadosRentaRequest $request)
    {
//dd($request->all());

        $mes = $this->numero_mes($request->fecha1);

        $mesnum = $request->fecha1;

        $tipodoc = 0;

        //dd($agenda);


        if ($request->tipoDocumento == 'E') {
            $tipodoc = 1;
        }
        if ($request->tipoDocumento == 'D') {
            $tipodoc = 2;

        }
        if ($request->tipoDocumento == 'ND') {
            $tipodoc = 3;

        }


        $resultados = DB::table('dietas')
            ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->where('dietas.mes', '=', $mes)
            ->where('dietas.anio', '=', $request->anio)
            ->where('sectores.id', '=', $tipodoc)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre')
            ->limit(1)
            ->get();

        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }


        return view("Reportes.Reporte_consolidados_renta")
            ->with('resultados', $resultados)
            ->with('mes', $mes)
            ->with('tipo', $request->tipoDocumento);


        return view("Reportes.Reporte_consolidados_renta", ['resultados' => NULL]);

    }


    public function buscar_planilla_dieta(ReportesRequest $request)
    {

        //dd($request->all());


        $mes = $this->numero_mes($request->fecha1);

        $mesnum = $request->fecha1;


        //dd($agenda);

        if ($request->tipoDocumento == 'A') {


            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->where('dietas.anio', '=', $request->anio)
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre', 'dietas.asambleista_id')->limit(1)->get();


            $agendas_anio = DB::table('agendas')//todas las agendas no vigentes del año seleccionado en las que participo cada hdp
            ->join('asistencias', 'asistencias.agenda_id', '=', 'agendas.id')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->whereYear('fecha', '=', $request->anio)
                ->where('agendas.vigente', '<>', 1)
                ->get();


            if ($agendas_anio == NULL) {

                $resultados = NULL;

            }
            //dd($resultados);


        }

        if ($request->tipoDocumento == 'E') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $request->anio)
                ->where('sectores.id', '=', 1)
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre')->limit(1)->get();


        }

        if ($request->tipoDocumento == 'D') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $request->anio)
                ->where('sectores.id', '=', 2)
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre')->limit(1)->get();


        }

        if ($request->tipoDocumento == 'ND') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $request->anio)
                ->where('sectores.id', '=', 3)
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre')->limit(1)->get();


        }
        /* $dieta = DB::table('dietas')
         ->join('asambleistas','dietas.asambleista_id','=','asambleistas.id')
         ->join('users','asambleistas.user_id','=','users.id')
         ->whereColumn(['users.name','like', $request->nombre],
                       ['dietas.mes','=',$mes])->select('users.name')->first();*/


        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }


        //echo($dieta->name);


        return view("Reportes.Reporte_planilla_dieta")
            ->with('resultados', $resultados)
            ->with('mesnum', $mesnum)
            ->with('tipo', $request->tipoDocumento);
    }


    public function buscar_permisos_temporales(ReportesPermisosTemporalesRequest $request)
    {


        //  dd($request->all());


        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;   


        $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Reportes.Reporte_permisos_temporales")
        ->with('resultados',NULL);
        }

         $resultados=DB::table('agendas')
        ->join('asistencias','asistencias.agenda_id','=','agendas.id')
        ->join('tiempos','asistencias.id','=','tiempos.asistencia_id')
        ->join('estado_asistencias','tiempos.estado_asistencia_id','=','estado_asistencias.id')
        ->where('estado_asistencias.id','=',1)//1 por ser permisos temporales 
        ->where
([
  ['agendas.fecha','>=',$this->convertirfecha($fechainicial)],
  ['agendas.fecha','<=',$this->convertirfecha($fechafinal)]
])
->select('agendas.id','agendas.fecha','agendas.periodo_id')
->distinct()
        ->get();
 



        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }


        return view("Reportes.Reporte_permisos_temporales")
            ->with('resultados', $resultados);

        // dd($resultados);


        return view("Reportes.Reporte_permisos_temporales", ['resultados' => NULL]);
    }





    public function buscar_asistencias(ReportesAsistenciasRequest $request)
    {



        // dd($request->all());


        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;
        
        $sector=$request->tipoDocumento;
        $tipo=$request->tipoDocumento;
        
       $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Reportes.Reporte_asistencias_sesion_plenaria")
        ->with('resultados',NULL);
        }

        if ($sector == 'E') {


            $sector = 'ESTUDIANTIL';
        }


        if ($sector == 'D') {


            $sector = 'DOCENTE';
        }


        if ($sector == 'ND') {


            $sector = 'NO DOCENTE';
        }


        $resultados = DB::table('agendas')
            ->join('asistencias', 'asistencias.agenda_id', '=', 'agendas.id')
            ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
            ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
            ->where('estado_asistencias.id', '=', 3)//1 por ser permisos temporales

            ->where
            ([
                ['agendas.fecha', '>=', $this->convertirfecha($fechainicial)],
                ['agendas.fecha', '<=', $this->convertirfecha($fechafinal)]
            ])
            ->select('agendas.id', 'agendas.fecha', 'agendas.periodo_id')
            ->distinct()
            ->get();


        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }


        return view("Reportes.Reporte_asistencias_sesion_plenaria")
            ->with('resultados', $resultados)
            ->with('sector', $sector)
            ->with('tipo', $tipo);






        return view("Reportes.Reporte_asistencias_sesion_plenaria", ['resultados' => NULL]);
    }



    public function buscar_bitacora_correspondencia(BuscarBitacoraCorrespRequest $request)
    {

        $fechainicial = $request->fecha1;

        $fechafinal = $request->fecha2;

           $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Reportes.Reporte_bitacora_correspondencia")
        ->with('resultados',NULL);
        }


        $resultados = DB::table('peticiones')
            ->where
            ([
                ['peticiones.fecha', '>=', $this->convertirfecha($fechainicial)],
                ['peticiones.fecha', '<=', $this->convertirfecha($fechafinal)]
            ])
            ->limit(1)
            ->get();


        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }


        $uno = $this->convertirfecha($fechainicial);
        $dos = $this->convertirfecha($fechafinal);
        return view("Reportes.Reporte_bitacora_correspondencia")
            ->with('fechainicial', $uno)
            ->with('fechafinal', $dos)
            ->with('resultados', $resultados);


        return view('Reportes.Reporte_bitacora_correspondencia', ['resultados' => NULL]);


    }


    public function Reporte_planilla_dieta($tipo)
    {

        $parametros = explode('.', $tipo); //se reciben id asambleista mes y año de la dieta separados por un espacio
        $verdescar = $parametros[0];
        $id = $parametros[1];
        $mes = $parametros[2];
        $anio = $parametros[3];
        $mesnum = $parametros[4];

        $busqueda = DB::table('asambleistas')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'sectores.nombre', 'personas.dui',
                'personas.nit', 'personas.afp', 'personas.cuenta', 'asambleistas.id', DB::raw('0 AS dieta'), DB::raw('0 AS renta'))
            ->get(); //todos los asambleistas

        //dd($busqueda);

        $iva = 0.0;
        $porcentaje_asistencia = 0.0;
        $renta = 0.0;
        $monto_dieta = 0.0;

        $cuenta = 0;
        foreach ($busqueda as $busq) {

            $agendas_anio = DB::table('agendas')//todas las agendas no vigentes del año seleccionado en las que participo cada asambleista
            ->join('asistencias', 'asistencias.agenda_id', '=', 'agendas.id')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->whereYear('fecha', '=', $anio)
                ->where('asambleistas.id', '=', $busq->id)
                ->where('agendas.vigente', '<>', 1)
                ->get();


            //dd($agendas_anio);

            foreach ($agendas_anio as $agendas) {

                $parametros = DB::table('parametros')->get();

                foreach ($parametros as $parametro) {

                    if ($parametro->nombre_parametro == 'iva') {
                        $iva = $parametro->valor;
                    }

                    if ($parametro->nombre_parametro == 'porcentaje_asistencia') {
                        $porcentaje_asistencia = ($parametro->valor) * 100;
                    }

                    if ($parametro->nombre_parametro == 'renta') {
                        $renta = $parametro->valor;
                    }

                    if ($parametro->nombre_parametro == 'monto_dieta') {
                        $monto_dieta = $parametro->valor;
                    }

                }


                $horasreunion = DB::table('agendas')
                    ->selectRaw('ABS(sum(time_to_sec(timediff(inicio,fin)))/3600) as suma')
                    ->where('agendas.id', '=', $agendas->id)//por el momento solo filtro por el id
                    ->where('agendas.vigente', '<>', 1)//este where tiene que ir para no mostrar reuniones no terminadas
                    ->get();


                $horasasistencia = DB::table('asistencias')
                    ->selectRaw('ABS(sum(time_to_sec(timediff(tiempos.entrada,tiempos.salida)))/3600) as suma')
                    ->join('tiempos', 'asistencias.id', '=', 'tiempos.asistencia_id')
                    ->join('estado_asistencias', 'tiempos.estado_asistencia_id', '=', 'estado_asistencias.id')
                    ->where('estado_asistencias.id', '=', 3)//3 por ser asistencia normal
                    ->where('asistencias.asambleista_id', '=', $busq->id)
                    ->where('asistencias.agenda_id', '=', $agendas->id)//por el momento solo filtro por el id
                    ->get();


                if ($horasreunion[0]->suma > 0.0) {

                    $porcAsistencia = ($horasasistencia[0]->suma / $horasreunion[0]->suma) * 100;
                } else {

                    $porcAsistencia = 0.0;

                }


                if ($porcAsistencia >= $porcentaje_asistencia) {

                    $cantDiet = DB::table('dietas')
                        ->where('dietas.asambleista_id', '=', $busq->id)
                        ->where('dietas.anio', '=', $anio)
                        ->selectRaw('SUM(asistencia) AS asistencia')
                        ->get();


                    $asistencianum = $cantDiet[0]->asistencia;


                    if ($asistencianum == 0) {
                        $monto_dieta = 0.0;
                    } else {

                        $monto_dieta = $monto_dieta * $asistencianum;

                    }

                    $busqueda[$cuenta]->dieta = $busqueda[$cuenta]->dieta + $monto_dieta;

                    $renta = $monto_dieta * $renta;
                    $renta = round($renta, 2);
                    $busqueda[$cuenta]->renta = $busqueda[$cuenta]->renta + $renta;
                }

            }

            if ($busqueda[$cuenta]->dieta == 0.0) {
                unset($busqueda[$cuenta]);
            }
            $cuenta = $cuenta + 1;
        }


        $sector = 0;
        $dui = 0;
        $nit = 0;
        $afp = 0;
        $cuenta = 0;


        $view = \View::make('Reportes/Reporte_planilla_dieta_pdf', compact('busqueda', 'sector', 'nit', 'mes', 'anio', 'horasreunion', 'monto_dieta', 'renta'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);
        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Planilla_Dieta_' . $anio . '_' . $sector . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Planilla_Dieta_' . $anio . '_' . $sector . '_' . $hoy . '.pdf');
        }
        //return $pdf->stream('reporte.pdf'); //mostrar pdf en pagina
        //return $pdf->download('reporte.pdf'); // descargar el archivo pdf
    }


    public function Reporte_planilla_dieta_prof_Est_pdf($tipo)
    {


        $parametros = explode('.', $tipo); //se reciben id asambleista mes y año de la dieta separados por un espacio
        $verdescar = $parametros[0];
        $mes = $parametros[1];
        $anio = $parametros[2];


        $resultados = DB::table('dietas')
            ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->where('dietas.mes', '=', $mes)
            ->where('dietas.anio', '=', $anio)
            ->where('sectores.id', '=', 1)//serctor 2 por ser profesional docente
            ->select('asambleistas.id', 'personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect',
                'facultades.nombre as nom_fact', 'dietas.asistencia', DB::raw('0 AS dieta'), DB::raw('0 AS renta'))->orderBy('nom_fact', 'desc')->get();

        $monto_dieta = DB::table('parametros')
            ->where('parametros.parametro', '=', 'mdi')
            ->select('parametros.valor')
            ->first();

        /*  $iva=0.0;
          $porcentaje_asistencia=0.0;
          $renta=0.0;
          $monto_dieta=0.0;
          $cuenta=0;
          //dd($resultados);
          foreach ($resultados as $resul) {

          $agendas_anio=DB::table('agendas') //todas las agendas
          ->join('asistencias','asistencias.agenda_id','=','agendas.id')
          ->join('asambleistas','asistencias.asambleista_id','=','asambleistas.id')
          ->whereYear('fecha','=',$anio)
          ->whereMonth('fecha','=',$mes)
          ->where('asambleistas.id','=',$resul->id)
          ->where('agendas.vigente','<>',1)
          ->get();

          dd($agendas_anio);

          foreach ($agendas_anio as $agendas) {

          $parametros=DB::table('parametros')->get();
          foreach ($parametros as $parametro) {
          if($parametro->nombre_parametro=='iva'){
              $iva=$parametro->valor;
          }
          if($parametro->nombre_parametro=='porcentaje_asistencia'){
              $porcentaje_asistencia=($parametro->valor)*100;
          }
          if($parametro->nombre_parametro=='renta'){
              $renta=$parametro->valor;
          }
          if($parametro->nombre_parametro=='monto_dieta'){
              $monto_dieta=$parametro->valor;
          }
          }


          $horasreunion=DB::table('agendas')
          ->selectRaw('ABS(sum(time_to_sec(timediff(inicio,fin)))/3600) as suma')
          ->where('agendas.id','=',$agendas->id) //por el momento solo filtro por el id
          ->where('agendas.vigente','<>',1) //este where tiene que ir para no mostrar reuniones no terminadas
          ->get();


             $horasasistencia=DB::table('asistencias')
          ->selectRaw('ABS(sum(time_to_sec(timediff(tiempos.entrada,tiempos.salida)))/3600) as suma')
          ->join('tiempos','asistencias.id','=','tiempos.asistencia_id')
          ->join('estado_asistencias','tiempos.estado_asistencia_id','=','estado_asistencias.id')
          ->where('estado_asistencias.id','=',3)//3 por ser asistencia normal
          ->where('asistencias.asambleista_id','=',$resul->id)
          ->where('asistencias.agenda_id','=',$agendas->id)//por el momento solo filtro por el id
          ->get();


          if($horasreunion[0]->suma>0.0){

          $porcAsistencia=($horasasistencia[0]->suma/$horasreunion[0]->suma)*100;
          }
          else{

          $porcAsistencia=0.0;

          }


          if($porcAsistencia>=$porcentaje_asistencia){

          $cantDiet = DB::table('dietas')
          ->where('dietas.asambleista_id','=',$resul->id)
          ->where('dietas.anio','=',$anio)
          ->where('dietas.mes','=',$mes)
          ->selectRaw('SUM(asistencia) AS asistencia')
          ->get();


          $asistencianum=$cantDiet[0]->asistencia;


          if($asistencianum==0)
          {
          $monto_dieta=0.0;
          }
          else{

          $monto_dieta=$monto_dieta*$asistencianum;

          }

          $resultados[$cuenta]->dieta=$resultados[$cuenta]->dieta+$monto_dieta;

          $renta=$monto_dieta*$renta;
          $renta=round($renta,2);
          $resultados[$cuenta]->renta=$resultados[$cuenta]->renta+$renta;
          }
          }

           if($resultados[$cuenta]->dieta==0.0){
          unset($resultados[$cuenta]);
          }
              $cuenta=$cuenta+1;

          }

  */


        $view = \View::make('Reportes/Reporte_planilla_dieta_prof_Est_pdf', compact('resultados', 'mes', 'anio', 'monto_dieta'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Dieta_Estudiantes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Dieta_Estudiantes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }

    }


    public function Reporte_planilla_dieta_prof_Doc_pdf($tipo)
    {


        $parametros = explode('.', $tipo); //se reciben id asambleista mes y año de la dieta separados por un espacio
        $verdescar = $parametros[0];
        $mes = $parametros[1];
        $anio = $parametros[2];


        $resultados = DB::table('dietas')
            ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->where('dietas.mes', '=', $mes)
            ->where('dietas.anio', '=', $anio)
            ->where('sectores.id', '=', 2)//serctor 2 por ser profesional docente
            ->select('asambleistas.id', 'personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect',
                'facultades.nombre as nom_fact', 'dietas.asistencia')->orderBy('nom_fact', 'desc')->get();


        $monto_dieta = DB::table('parametros')
            ->where('parametros.parametro', '=', 'mdi')
            ->select('parametros.valor')
            ->first();


        $view = \View::make('Reportes/Reporte_planilla_dieta_prof_Doc_pdf', compact('resultados', 'mes', 'anio', 'monto_dieta'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);


        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Dieta_Docentes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Dieta_Docentes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }


    }


    public function Reporte_planilla_dieta_prof_noDocpdf($tipo)
    {

        $parametros = explode('.', $tipo); //se reciben id asambleista mes y año de la dieta separados por un espacio
        $verdescar = $parametros[0];
        $mes = $parametros[1];
        $anio = $parametros[2];

        $resultados = DB::table('dietas')
            ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
            ->join('users', 'asambleistas.user_id', '=', 'users.id')
            ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
            ->where('dietas.mes', '=', $mes)
            ->where('dietas.anio', '=', $anio)
            ->where('sectores.id', '=', 3)
            ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'facultades.nombre as nom_fact', 'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect', 'dietas.asistencia'
            )->orderBy('nom_fact', 'desc')->get();


        $monto_dieta = DB::table('parametros')
            ->where('parametros.parametro', '=', 'mdi')
            ->select('parametros.valor')
            ->first();


        $view = \View::make('Reportes/Reporte_planilla_dieta_prof_noDocpdf', compact('resultados', 'mes', 'anio', 'monto_dieta'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Dieta_No_Docentes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Dieta_No_Docentes_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }

    }


    public function Reporte_consolidados_renta($tipo) //No docente
    {


        $parametros = explode('.', $tipo); //se reciben id asambleista mes y año de la dieta separados por un espacio
        $verdescar = $parametros[0];
        $sector = $parametros[1];
        $mes = $parametros[2];
        $anio = $parametros[3];


        $monto_dieta = DB::table('parametros')
            ->where('parametros.parametro', '=', 'mdi')
            ->select('parametros.valor')
            ->first();

        $renta = DB::table('parametros')
            ->where('parametros.parametro', '=', 'ren')
            ->select('parametros.valor')
            ->first();


        if ($sector == 'E') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $anio)
                ->where('sectores.id', '=', 1)//serctor 2 por ser profesional docente
                ->select('asambleistas.id', 'personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect',
                    'facultades.nombre as nom_fact', 'dietas.asistencia', 'personas.nit', DB::raw('0 as montodieta'), DB::raw('0 as renta'), DB::raw('0 as total'))->orderBy('nom_fact', 'desc')->get();
            //dd($resultados);
            $sector = 'ESTUDIANTIL';
        }

        if ($sector == 'D') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $anio)
                ->where('sectores.id', '=', 2)//serctor 2 por ser profesional docente
                ->select('asambleistas.id', 'personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect',
                    'facultades.nombre as nom_fact', 'dietas.asistencia', 'personas.nit', DB::raw('0 as montodieta'), DB::raw('0 as renta'), DB::raw('0 as total'))->orderBy('nom_fact', 'desc')->get();
            //dd($resultados);
            $sector = 'DOCENTE';
        }


        if ($sector == 'ND') {

            $resultados = DB::table('dietas')
                ->join('asambleistas', 'dietas.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('sectores', 'asambleistas.sector_id', '=', 'sectores.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->where('dietas.mes', '=', $mes)
                ->where('dietas.anio', '=', $anio)
                ->where('sectores.id', '=', 3)//serctor 2 por ser profesional docente
                ->select('asambleistas.id', 'personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'dietas.mes', 'dietas.anio', 'sectores.id', 'sectores.nombre as nom_sect',
                    'facultades.nombre as nom_fact', 'dietas.asistencia', 'personas.nit', DB::raw('0 as montodieta'), DB::raw('0 as renta'), DB::raw('0 as total'))->orderBy('nom_fact', 'desc')->get();

            $sector = 'NO DOCENTE';
        }


        $view = \View::make('Reportes/Reporte_consolidados_renta_pdf', compact('resultados', 'sector', 'monto_dieta', 'renta', 'mes', 'anio'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'landscape')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Consolidado_Renta_' . $sector . '_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Consolidado_Renta_' . $sector . '_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 3) {


            Excel::create('Consolidado_Renta_' . $sector . '_' . $mes . '_' . $anio . '_' . $hoy, function ($excel) use ($resultados) {
                $excel->sheet('Hoja1', function ($sheet) use ($resultados) {
                    $data = array();
                    foreach ($resultados as $result) {

                        $monto_dieta = DB::table('parametros')
                            ->where('parametros.parametro', '=', 'mdi')
                            ->select('parametros.valor')
                            ->first();

                        $renta = DB::table('parametros')
                            ->where('parametros.parametro', '=', 'ren')
                            ->select('parametros.valor')
                            ->first();


                        $result->montodieta = $result->asistencia * $monto_dieta->valor;
                        $result->renta = $result->asistencia * $monto_dieta->valor * $renta->valor;
                        $result->total = $result->montodieta - $result->renta;
                        $data[] = (array)$result;
                    }
                    $sheet->fromArray($data);
                });
            })->export('xls');
        }


    }


    public function Reporte_consolidados_renta_docente($tipo)
    {


        //dd($tipo);


        $parametros = explode('.', $tipo);
        $tipodes = $parametros[0];
        $sector = $parametros[1];
        $idagenda = $parametros[2];
        $fecheperiodo = $parametros[3];
        $idperiodo = $parametros[4];

        $nombreperiodo1 = DB::table('periodos')
            ->where('periodos.id', '=', $idperiodo)
            ->select('periodos.nombre_periodo')
            ->get();

        $nombreperiodo = $nombreperiodo1[0]->nombre_periodo;
        //dd($nombreperiodo);


        if ($sector == 'D') {

            $resultados = DB::table('asistencias')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el id
                ->where('asistencias.estado_asistencia_id', '=', 3)//3 por ser asistencias normales
                ->where('asambleistas.sector_id', '=', 2)//sector estudiantil
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'asistencias.entrada', 'asistencias.salida', 'asistencias.propietario', 'facultades.nombre', 'personas.nit')
                ->orderBy('facultades.nombre', 'desc')
                ->get();
            $sector = 'DOCENTE';
        }


        if ($sector == 'ND') {

            $resultados = DB::table('asistencias')
                ->join('asambleistas', 'asistencias.asambleista_id', '=', 'asambleistas.id')
                ->join('users', 'asambleistas.user_id', '=', 'users.id')
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('facultades', 'asambleistas.facultad_id', '=', 'facultades.id')
                ->where('asistencias.agenda_id', '=', $idagenda)//por el momento solo filtro por el id
                ->where('asistencias.estado_asistencia_id', '=', 3)//3 por ser asistencias normales
                ->where('asambleistas.sector_id', '=', 3)//sector estudiantil
                ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                    'personas.segundo_nombre', 'asistencias.entrada', 'asistencias.salida', 'asistencias.propietario', 'facultades.nombre', 'personas.nit')
                ->orderBy('facultades.nombre', 'desc')
                ->get();
            $sector = 'NO DOCENTE';
        }


        $view = \View::make('Reportes/Reporte_consolidados_renta_docente_pdf', compact('resultados', 'sector', 'nombreperiodo'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'landscape')->setWarnings(false);

        $hoy = Carbon::now()->format('Y-m-d');
        if ($verdescar == 1) {
            return $pdf->stream('Consolidado_Renta_' . $sector . '_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }
        if ($verdescar == 2) {
            return $pdf->download('Consolidado_Renta_' . $sector . '_' . $mes . '_' . $anio . '_' . $hoy . '.pdf');
        }


    }


    public function buscar_permisos_permanentes(ReportesPermisospermanentesRequest $request)
    {

        $fechainicial = $request->fecha1;
        $fechafinal = $request->fecha2;

        $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Reportes.Reporte_permisos_permanentes")
        ->with('resultados',NULL);
        }

        $resultados = DB::table('permisos')
            ->where
            ([
                ['permisos.fecha_permiso', '>=', $this->convertirfecha($fechainicial)],
                ['permisos.fecha_permiso', '<=', $this->convertirfecha($fechafinal)]
            ])
            ->limit(1)
            ->get();


        if ($resultados == NULL) {

            $request->session()->flash("warning", "No se encontraron registros");

        } else {
            $request->session()->flash("success", "Busqueda terminada con exito");
        }
        $uno = $this->convertirfecha($fechainicial);
        $dos = $this->convertirfecha($fechafinal);
        return view("Reportes.Reporte_permisos_permanentes")
            ->with('fechainicial', $uno)
            ->with('fechafinal', $dos)
            ->with('resultados', $resultados);


        return view("Reportes.Reporte_permisos_permanentes", ['resultados' => NULL]);
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function convertirfecha($fecha)
    {

        $fecha1conver = explode('/', $fecha);
        $fechatrans = $fecha1conver[2] . '-' . $fecha1conver[1] . '-' . $fecha1conver[0];
        $fechainicial = date('Y-m-d', strtotime($fechatrans));

        return $fechainicial;
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
