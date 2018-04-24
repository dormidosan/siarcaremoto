<?php

namespace App\Http\Controllers;

use App\Comision;
use App\Periodo;
use App\Peticion;
use App\Seguimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class GraficosController extends Controller
{
    //
    public function menu_graficos()
    {
        return view("Graficos.menu_graficos");
    }

    public function peticiones_por_mes()
    {
        $year = Carbon::today()->year;
        $peticiones_total = [];
        return view("Graficos.peticiones_por_mes", ["year" => $year, "peticiones" => $peticiones_total]);
    }

    public function peticiones_por_post(Request $request)
    {
        $peticiones = Peticion::where("fecha", "like", '%' . $request->anio . '%')->orderBy("fecha")->get();
        $peticiones_enero = 0;
        $peticiones_febrero = 0;
        $peticiones_marzo = 0;
        $peticiones_abril = 0;
        $peticiones_mayo = 0;
        $peticiones_junio = 0;
        $peticiones_julio = 0;
        $peticiones_agosto = 0;
        $peticiones_sept = 0;
        $peticiones_oct = 0;
        $peticiones_nov = 0;
        $peticiones_dic = 0;

        $peticiones_total = [];

        foreach ($peticiones as $peticion) {
            $fecha_array = explode("-", $peticion->fecha);

            switch ($fecha_array[1]) {
                case "01":
                    $peticiones_enero++;
                    break;
                case "02":
                    $peticiones_febrero++;
                    break;
                case "03":
                    $peticiones_marzo++;
                    break;
                case "04":
                    $peticiones_abril++;
                    break;
                case "05":
                    $peticiones_mayo++;
                    break;
                case "06":
                    $peticiones_junio++;
                    break;
                case "07":
                    $peticiones_julio++;
                    break;
                case "08":
                    $peticiones_agosto++;
                    break;
                case "09":
                    $peticiones_sept++;
                    break;
                case "10":
                    $peticiones_oct++;
                    break;
                case "11":
                    $peticiones_nov++;
                    break;
                case "12":
                    $peticiones_dic++;
                    break;
            }
        }//fin foreach

        array_push($peticiones_total, $peticiones_enero, $peticiones_febrero, $peticiones_marzo, $peticiones_abril, $peticiones_mayo, $peticiones_junio, $peticiones_julio, $peticiones_agosto, $peticiones_sept, $peticiones_oct, $peticiones_nov, $peticiones_dic);

        $contador = 0;
        foreach ($peticiones_total as $var){
            if ($var == 0)
                $contador++;
        }
        if ($contador == 12){
            $request->session()->flash("error", "No se encontraron resultados");
        }
        return view("Graficos.peticiones_por_mes", ["year" => $request->anio, "peticiones" => $peticiones_total]);
    }


    public function dictamenes_por_comision()
    {
        $periodos = Periodo::all();
        $dictamenes = [];
        return view("Graficos.dictamenes_comision", ["periodos" => $periodos, "dictamenes" => $dictamenes]);
    }

    public function dictamenes_comision_post(Request $request)
    {
        $comisiones = Comision::all();
        $periodos = Periodo::all();
        $dictamenes = [];

        foreach ($comisiones as $comision){
            $seguimientos = Seguimiento::join("peticiones", "seguimientos.peticion_id", "=", "peticiones.id")
                ->join("periodos", "peticiones.periodo_id", "=", "periodos.id")
                ->join("documentos","seguimientos.documento_id","=","documentos.id")
                ->where("documentos.tipo_documento_id", 3)
                ->where("periodos.id",$request->periodo)
                ->where("seguimientos.comision_id",$comision->id)
                ->get();

            if ($seguimientos->count() > 0)
                array_push($dictamenes,[$comision->nombre,$seguimientos->count()]);
        }

        if (empty($dictamenes)){
            $request->session()->flash("error", "No se encontraron resultados");
        }
        return view("Graficos.dictamenes_comision", ["periodos" => $periodos, "dictamenes" => $dictamenes]);
    }


}
