<?php

namespace App\Http\Controllers;

use App\Asambleista;
use App\Bitacora;
use App\Cargo;
use App\Clases\Mensaje;
use App\Comision;
use App\Dieta;
use App\Facultad;
use App\Modulo;
use App\Periodo;
use App\Permiso;
use App\Persona;
use App\Plantilla;
use App\Rol;
use App\Sector;
use App\User;
use App\Parametro;
use App\TipoCargo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DateTime;
use Storage;
use App\Http\Requests\PeriodoRequest;
use Illuminate\Support\Facades\Auth;
use Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

class AdministracionController extends Controller
{
    public function registrar_usuario()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $usuarios = User::all();
            $facultades = Facultad::all();
            $sectores = Sector::all();
            $tipos_usuario = Rol::all();
            return view("Administracion.RegistrarUsuarios", ["facultades" => $facultades, "sectores" => $sectores, "tipos_usuario" => $tipos_usuario, 'usuarios' => $usuarios]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardar_usuario(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {

                $total_tipos_usuarios = 0;
                $disco = "../storage/fotos/";

                if ($request->tipo_usuario == 3) {
                    $periodo_activo = Periodo::where("activo", 1)->first();
                    $total_tipos_usuarios = Asambleista::join("users", "asambleistas.user_id", "=", "users.id")
                        ->where("users.rol_id", 3)
                        ->where('asambleistas.propietario', $request->propietario)
                        ->where('asambleistas.facultad_id', $request->facultad)
                        ->where('asambleistas.sector_id', $request->sector)
                        ->where('asambleistas.activo', 1)
                        ->where('asambleistas.periodo_id', $periodo_activo->id)
                        ->count();
                }

                if ($total_tipos_usuarios == 2) {
                    $respuesta = new \stdClass();
                    $respuesta->error = true;
                    $facultad = Facultad::find($request->facultad);
                    $sector = Sector::find($request->sector);
                    $propietaria = ($request->propietario == 0) ? 'Suplentes' : 'Propietarios';
                    $respuesta->mensaje = (new Mensaje("Error", "Ya existe el total maximo de asambleistas " . $propietaria . " para la " . $facultad->nombre . " en el sector " . $sector->nombre, "error"))->toArray();
                    return new JsonResponse($respuesta);
                } else {
                    $persona = new Persona();
                    $persona->primer_nombre = $request->get("primer_nombre");
                    $persona->segundo_nombre = $request->get("segundo_nombre");
                    $persona->primer_apellido = $request->get("primer_apellido");
                    $persona->segundo_apellido = $request->get("segundo_apellido");
                    $persona->dui = $request->get("dui");
                    $persona->nit = $request->get("nit");
                    $persona->nacimiento = $request->get("fecha1");
                    $fecha1 = DateTime::createFromFormat('d-m-Y', $request->fecha1);
                    $persona->nacimiento = $fecha1->format('Y-m-d');

                    if ($request->hasFile('foto')) {
                        $file = $request->files->get('foto');
                        $ext = $file->guessExtension();
                        if ($ext == "jpeg" || $ext == "jpg" || $ext == "png" || $ext == "gif") {
                            $nombreArchivo = time() . '' . rand(1, 9999) . '.' . $file->getClientOriginalExtension();
                            $persona->foto = $nombreArchivo;
                            $archivo = $file->move($disco, $nombreArchivo);
                        }

                    } else {
                        $persona->foto = 'default-user.png';
                    }

                    $persona->afp = $request->get("afp");
                    $persona->cuenta = $request->get("cuenta");
                    $persona->save();

                    $usuario = new User();
                    $usuario->rol_id = $request->get("tipo_usuario");
                    $usuario->persona_id = $persona->id;
                    $usuario->name = $persona->primer_nombre . "." . $persona->primer_apellido;
                    $usuario->password = bcrypt("ATB");
                    $usuario->email = $request->get("correo");
                    $usuario->activo = 1;
                    $usuario->save();


                    if ($request->get("tipo_usuario") == 3) {
                        $periodo_activo = Periodo::where("activo", "=", 1)->first();
                        $asambleista = new Asambleista();
                        $asambleista->user_id = $usuario->id;
                        $asambleista->periodo_id = $periodo_activo->id;
                        $asambleista->facultad_id = $request->get("facultad");
                        $asambleista->sector_id = $request->get("sector");
                        $asambleista->propietario = $request->get("propietario");
                        //setea al user como un asambleista activo
                        $asambleista->activo = 1;

                        $hoy = Carbon::now();
                        $inicio_periodo = Carbon::createFromFormat("Y-m-d", $periodo_activo->inicio);

                        if ($hoy > $inicio_periodo) {
                            $asambleista->inicio = $hoy;
                        } else {
                            $asambleista->inicio = $inicio_periodo;
                        }
                        $asambleista->save();
                    }

                    $respuesta = new \stdClass();
                    $respuesta->error = false;
                    $respuesta->mensaje = (new Mensaje("Exito", "Usuario agregado con exito", "success"))->toArray();
                    return new JsonResponse($respuesta);
                }
            }
            //Se crea un objeto de tipo persona y se asocia lo que se recibe del form a su respectiva variable,
            //una vez ingresado la nueva persona, ya se tiene acceso a todos sus datos.
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function gestionar_plantillas()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $plantillas = Plantilla::all();
            return view("Administracion.gestionar_plantillas", ["plantillas" => $plantillas]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function descargar_plantilla($id)
    {
        $plantilla = Plantilla::find($id);
        $ruta_plantilla = "../storage/plantillas/" . $plantilla->path;
        return response()->download($ruta_plantilla);
    }

    public function mostrar_periodos_agu()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $periodos = Periodo::orderBy("id", "desc")->get();
            $periodo_activo = Periodo::where("activo", 1)->count();
            return view("Administracion.PeriodosAGU", ["periodos" => $periodos, "periodo_activo" => $periodo_activo]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardar_periodo(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $periodo_activo = Periodo::where("activo", 1)->first();
            if ($periodo_activo) {
                $request->session()->flash("error", "Ya existe un periodo activo");
                return redirect()->back();
            } else {
                $periodo = new Periodo();
                $periodo->nombre_periodo = $request->get("nombre_periodo");
                $periodo->inicio = Carbon::createFromFormat('d-m-Y', $request->get("inicio"));
                $periodo->fin = Carbon::createFromFormat('d-m-Y', $request->get("inicio"))->addYear(2);
                $periodo->activo = 1;
                $periodo->save();

                if ($request->hasFile("excel") && $request->file('excel')->isValid()) {
                    $extension = $request->excel->extension();
                    if ($extension == "xlsx" || $extension == "csv") {
                        $path = $request->excel->path();
                        $data = Excel::load($path, function ($reader) {
                            $results = $reader->ignoreEmpty();
                        })->get()->toArray();

                        $data = array_filter($data);
                        $datos = array();

                        foreach ($data as $row) {
                            $row = array_diff($row, [" ", "   ", "", null]);
                            if (count($row) != 0) {
                                array_push($datos, $row);
                            }
                        }

                        $usuarios = User::all();
                        $usuarios_correos = array();
                        foreach ($usuarios as $usuario) {
                            array_push($usuarios_correos, $usuario->email);
                        }

                        if (!empty($datos) && count($datos)) {
                            //dd($datos);
                            foreach ($datos as $row) {
                                /*
                                 * Al momento de ingresar un asambleista por medio del excel, si este ya se encuentra
                                 * realmente en el sistema se crea un record para el asambleista, en la tabla asambleista
                                 * y el usuario asociado a este se vuelve a activar
                                 */
                                if (in_array(trim($row["correo"]), $usuarios_correos)) {
                                    if ($row["tipo_usuario"] == "Asambleista") {
                                        $usuario_existente = User::where("email", trim($row["correo"]))->firstOrFail();
                                        $usuario_existente->activo = 1;
                                        $usuario_existente->save();

                                        $asambleista = new Asambleista();
                                        $asambleista->user_id = $usuario_existente->id;
                                        $asambleista->periodo_id = $periodo->id;
                                        $facultad_sql = Facultad::where("nombre", strtoupper($row["facultad"]))->first();
                                        $asambleista->facultad_id = $facultad_sql->id;
                                        $sector_sql = Sector::where("nombre", $row["sector"])->first();
                                        $asambleista->sector_id = $sector_sql->id;

                                        switch (strtoupper($row["propetario"])) {
                                            case "SI":
                                                $asambleista->propietario = 1;
                                                break;
                                            case "NO":
                                                $asambleista->propietario = 0;
                                                break;
                                        }
                                        //setea al user como un asambleista activo
                                        $asambleista->activo = 1;

                                        $hoy = Carbon::now();
                                        $inicio_periodo = $periodo->inicio;

                                        if ($hoy > $inicio_periodo) {
                                            $asambleista->inicio = $hoy;
                                        } else {
                                            $asambleista->inicio = $inicio_periodo;
                                        }
                                        $asambleista->save();
                                    }
                                } else {
                                    $persona = new Persona();
                                    if (array_key_exists('primer_nombre', $row))
                                        $persona->primer_nombre = trim($row["primer_nombre"]);
                                    if (array_key_exists('segundo_nombre', $row))
                                        $persona->segundo_nombre = trim($row["segundo_nombre"]);
                                    if (array_key_exists('primer_apellido', $row))
                                        $persona->primer_apellido = trim($row["primer_apellido"]);
                                    if (array_key_exists('segundo_apellido', $row))
                                        $persona->segundo_apellido = trim($row["segundo_apellido"]);
                                    if (array_key_exists('dui', $row))
                                        $persona->dui = trim($row["dui"]);
                                    if (array_key_exists('nit', $row))
                                        $persona->nit = trim($row["nit"]);
                                    if (array_key_exists('afp', $row))
                                        $persona->afp = trim($row["afp"]);
                                    if (array_key_exists('cuenta', $row))
                                        $persona->cuenta = trim($row["cuenta"]);
                                    $persona->foto = 'default-user.png';
                                    $persona->save();

                                    $usuario = new User();
                                    switch ($row["tipo_usuario"]) {
                                        case "Administrador":
                                            $usuario->rol_id = 1;
                                            break;
                                        case "Secretario":
                                            $usuario->rol_id = 2;
                                            break;
                                        case "Asambleista":
                                            $usuario->rol_id = 3;
                                            break;
                                    }

                                    $usuario->persona_id = $persona->id;
                                    $usuario->name = $persona->primer_nombre . "." . $persona->primer_apellido;
                                    $usuario->password = bcrypt("ATB");
                                    $usuario->email = trim($row["correo"]);
                                    $usuario->activo = 1;
                                    $usuario->save();

                                    if ($row["tipo_usuario"] == "Asambleista") {
                                        $asambleista = new Asambleista();
                                        $asambleista->user_id = $usuario->id;
                                        $asambleista->periodo_id = $periodo->id;
                                        $facultad_sql = Facultad::where("nombre", strtoupper($row["facultad"]))->first();
                                        $asambleista->facultad_id = $facultad_sql->id;
                                        $sector_sql = Sector::where("nombre", $row["sector"])->first();
                                        $asambleista->sector_id = $sector_sql->id;

                                        switch (strtoupper($row["propetario"])) {
                                            case "SI":
                                                $asambleista->propietario = 1;
                                                break;
                                            case "NO":
                                                $asambleista->propietario = 0;
                                                break;
                                        }
                                        //setea al user como un asambleista activo
                                        $asambleista->activo = 1;

                                        $hoy = Carbon::now();
                                        $inicio_periodo = $periodo->inicio;

                                        if ($hoy > $inicio_periodo) {
                                            $asambleista->inicio = $hoy;
                                        } else {
                                            $asambleista->inicio = $inicio_periodo;
                                        }
                                        $asambleista->save();
                                    }
                                }
                            }
                        }
                    }

                }
                $request->session()->flash("success", "Periodo creado con exito");
                return redirect()->route("periodos_agu");
            }

        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function finalizar_periodo(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $asambleistas = Asambleista::where("activo", 1)->where("periodo_id", $request->get("periodo_id"))->get();
            $usuarios = User::all();


            foreach ($asambleistas as $asambleista) {
                $asambleista->activo = 0;
                $asambleista->user->activo = 0;
                $asambleista->save();

                foreach ($usuarios as $usuario) {
                    if ($usuario->id === $asambleista->user_id) {
                        $usuario->activo = 0;
                        $usuario->save();
                    }
                }//fin foreach usuario

                try {
                    $cargo_asambleisa = Cargo::where("asambleista_id", $asambleista->id)->firstOrFail();
                    $cargo_asambleisa->activo = 0;
                    $cargo_asambleisa->save();
                } catch (ModelNotFoundException $e) {
                    continue;
                }//fin try
            }//fin foreach asambleistas

            $periodo = Periodo::find($request->get("periodo_id"));
            $periodo->activo = 0;
            $periodo->save();
            $request->session()->flash("success", "Periodo finalizado con exito");
            return redirect()->route("periodos_agu");
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function parametros(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $parametros = Parametro::all();
            return view('Administracion.Parametros')
                ->with('parametros', $parametros);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function almacenar_parametro(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            //dd($request->all());
            $parametro = Parametro::where('id', '=', $request->id_parametro)->firstOrFail();
            $parametro->valor = $request->nuevo_valor;
            $parametro->save();

            $parametros = Parametro::all();
            $request->session()->flash("success", "Parametro actualizado con exito");

            return redirect()->route("parametros");
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function almacenar_plantilla(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $vieja_plantilla_id = $request->plantilla_id;
            $nueva_plantilla = $this->guardarPlantilla($request->plantilla, $vieja_plantilla_id, 'plantillas');
            $plantillas = Plantilla::all();
            return view("Administracion.gestionar_plantillas", ["plantillas" => $plantillas]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function baja_asambleista()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $facultades = Facultad::all();
            //muestra incluso los asambleistas que no estan activos (0)
            $periodo = Periodo::where('activo', 1)->first();

            if (is_null($periodo) != true) {
                $asambleistas = Asambleista::where('periodo_id', $periodo->id)->get();
            } else {
                $asambleistas = array();
            }

            return view("Administracion.baja_asambleista", ["facultades" => $facultades, "asambleistas" => $asambleistas]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function modificar_estado_asambleista(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $asambleista = Asambleista::where("id", $request->get('id'))->first();
                //$asambleista->activo = 0;
                switch ($request->accion) {
                    case 1:
                        $asambleista->baja = 1;
                        break;
                    case 2:
                        $asambleista->baja = 0;
                        break;
                    case 3:
                        $asambleista->activo = 0;
                        break;
                    case 4:
                        $asambleista->activo = 1;
                        break;
                }
                $asambleista->save();
                $respuesta = new \stdClass();
                $respuesta->mensaje = (new Mensaje("Exito", "Asambleista modificado con exito", "success"))->toArray();
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function administracion_usuarios()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $comisiones = Comision::where("activa", 1)->get();
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function cambiar_perfiles()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $perfiles = Rol::all();
            $periodo_activo = Periodo::where("activo", 1)->first();

            if (is_null($periodo_activo) != true) {
                //$current_user = Asambleista::where("periodo_id", $periodo_activo->id)->where("activo", 1)->where("id", Auth::user()->id)->firstOrFail();
                $current_user = User::find(Auth::user()->id);
                //se genera el listado de asambleistas, sin incluir el actual logueado en el sistema
                $asambleistas = Asambleista::where("periodo_id", $periodo_activo->id)->where("activo", 1)->where("id", "!=", $current_user->id)->get();
            } else {
                $asambleistas = array();
            }
            return view("Administracion.cambiar_perfiles", ["perfiles" => $perfiles, "asambleistas" => $asambleistas]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function actualizar_perfil_usuario(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {

                $asambleista = Asambleista::find($request->get("idAsambleista"));

                $perfil = Rol::find($request->get("idPerfil"));
                $asambleista->user->rol_id = $perfil->id;
                $asambleista->user->save();

                //obtiendo la informacion necesaria para renderizarla y mostrarla al usuario
                $perfiles = Rol::all();
                $periodo_activo = Periodo::where("activo", 1)->firstOrFail();
                $current_user = Asambleista::where("periodo_id", $periodo_activo->id)->where("activo", 1)->where("id", Auth::user()->id)->firstOrFail();
                $asambleistas = Asambleista::where("periodo_id", $periodo_activo->id)->where("activo", 1)->where("id", "!=", $current_user->id)->get();

                $respuesta = new \stdClass();
                $body_tabla = "";
                foreach ($asambleistas as $asambleista) {
                    $body_tabla .= "<tr>
                                    <td>" . $asambleista->user->persona->primer_nombre . ' ' . $asambleista->user->persona->segundo_nombre . ' ' . $asambleista->user->persona->primer_apellido . ' ' . $asambleista->user->persona->segundo_apellido . "</td>
                                    <td>" . ucfirst($asambleista->user->rol->nombre_rol) . "</td>
                                    <td>
                                        <select id='perfil' class='form-control' onchange='actualizar_perfil_usuario(" . $asambleista->id . ",this.value)'>
                                            <option> -- Seleccione una opcion --</option>";

                    foreach ($perfiles as $perfil) {
                        $body_tabla .= "<option value='" . $perfil->id . "'>" . ucfirst($perfil->nombre_rol) . "</option>";
                    }//fin foreach perfiles


                    $body_tabla .= "</select>
                                    </td>
                               </tr>";
                }//fin foreach asambleistas

                $respuesta->body_tabla = $body_tabla;
                $respuesta->mensaje = (new Mensaje("Exito", "Asignación de nuevo perfil realizada con exito", "success"))->toArray();
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function cambiar_cargos_comision()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $comisiones = Comision::where("activa", 1)->where("nombre", "!=", "junta directiva")->get();
            return view("Administracion.cambiar_cargos_comision", ["comisiones" => $comisiones]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function mostrar_asambleistas_comision_post(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {

                $comision = Comision::find($request->get("idComision"));
                $tabla = $this->generarTabla($comision->id);
                /*
                $comision = Comision::find($request->get("idComision"));

                //obtener los integrantes de la comision y que esten activos en el periodo activo
                $integrantes = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
                    ->join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
                    ->where("cargos.comision_id", $request->get("idComision"))
                    ->where("asambleistas.activo", 1)
                    ->where("periodos.activo", 1)
                    ->where("cargos.activo", 1)
                    ->get();

                $tabla =
                    "<table class='table table-striped table-bordered table-condensed table-hover dataTable text-center'>
                        <thead>
                            <tr>
                                <th>Asambleista</th>
                                <th>Cargo</th>
                                <th>Coordinador</th>
                            </th>
                        </thead>
                        <tbody>";

                foreach ($integrantes as $integrante){
                    $tabla .= "<tr>
                                    <td>".$integrante->asambleista->user->persona->primer_nombre . " " . $integrante->asambleista->user->persona->segundo_nombre . " " . $integrante->asambleista->user->persona->primer_apellido . " " . $integrante->asambleista->user->persona->segundo_apellido."</td>
                                    <td>".$integrante->cargo."</td>";
                    if ($integrante->cargo == "Coordinador"){
                        $tabla .= "<td><div class='pretty p-icon p-curve'><input type='checkbox' checked disabled /><div class='state p-success'><i class='icon mdi mdi-check'></i><label>Coordinador de Comision</label></div></div></td>";
                    }
                    else{
                        $tabla .= "<td><div class='pretty p-icon p-curve'><input type='checkbox' onchange='actualizar_coordinador(".$integrante->asambleista->id.")'/><div class='state p-success'><i class='icon mdi mdi-check'></i><label></label></div></div></td>";
                    }

                }

                $tabla .= "</tbody></table>";

                */
                $respuesta = new \stdClass();
                $respuesta->comision = $comision->id;
                $respuesta->tabla = $tabla;

                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_coordinador(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $comision = $comision = Comision::find($request->get("idComision"));
                $asambleista = Asambleista::find($request->get("idAsambleista"));
                //se obtienen todos los asambleistas de la comision, con el fin de identificar el anterior coordinador
                $cargos_comision = Cargo::where("comision_id", $comision->id)->where("activo", 1)->get();
                $bandera_exito = false;

                foreach ($cargos_comision as $cargo) {
                    //se verifca quien es el coordinador actual y se le quita ese cargo, para asignarselo al nuevo coordinador
                    //y que no sea el asambleista nuevo
                    //$cargo_asambleista = $cargo->cargo;
                    $cargo_asambleista = $cargo->tipo_cargo->nombre_cargo;
                    switch ($cargo_asambleista) {
                        case "Coordinador":
                            if ($cargo->asambleista_id != $asambleista->id) {
                                $nuevo_cargo = TipoCargo::where("nombre_cargo", "Asambleista")->first();
                                //$cargo->cargo = "Asambleista";
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }//si el id del asambleista actual es el que se le envia se le quita el cargo y se le pone el de asambleista
                            break;
                        case "Asambleista":
                            $nuevo_cargo = TipoCargo::where("nombre_cargo", "Coordinador")->first();
                            if ($cargo->asambleista_id == $asambleista->id) {
                                //$cargo->cargo = "Coordinador";
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }
                            break;
                        case "Secretario":
                            $nuevo_cargo = TipoCargo::where("nombre_cargo", "Coordinador")->first();
                            if ($cargo->asambleista_id == $asambleista->id) {
                                //$cargo->cargo = "Coordinador";
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }
                            break;
                    }
                }

                $respuesta = new \stdClass();
                if ($bandera_exito) {
                    $respuesta->tabla = $this->generarTabla($comision->id);
                    $respuesta->mensaje = (new Mensaje("Exito", "Asignación de nuevo Coordinador realizada con exito", "success"))->toArray();
                } else {
                    $respuesta->mensaje = (new Mensaje("Error", "Asignación de nuevo Coordinador no se pudo realizar", "error"))->toArray();
                }
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_secretario(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $comision = $comision = Comision::find($request->get("idComision"));
                $asambleista = Asambleista::find($request->get("idAsambleista"));
                //se obtienen todos los asambleistas de la comision, con el fin de identificar el anterior coordinador
                $cargos_comision = Cargo::where("comision_id", $comision->id)->where("activo", 1)->get();
                $bandera_exito = false;

                foreach ($cargos_comision as $cargo) {
                    //se verifca quien es el coordinador actual y se le quita ese cargo, para asignarselo al nuevo coordinador
                    //y que no sea el asambleista nuevo
                    $cargo_asambleista = $cargo->tipo_cargo->nombre_cargo;
                    switch ($cargo_asambleista) {
                        //si hay un anterior secretario, se le quita ese cargo
                        case "Secretario":
                            if ($cargo->asambleista_id != $asambleista->id) {
                                $nuevo_cargo = TipoCargo::where("nombre_cargo", "Asambleista")->first();
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }
                            break;
                        case "Asambleista":
                            $nuevo_cargo = TipoCargo::where("nombre_cargo", "Secretario")->first();
                            if ($cargo->asambleista_id == $asambleista->id) {
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }
                            break;
                        case "Coordinador":
                            $nuevo_cargo = TipoCargo::where("nombre_cargo", "Secretario")->first();
                            if ($cargo->asambleista_id == $asambleista->id) {
                                $cargo->tipo_cargo_id = $nuevo_cargo->id;
                                $cargo->save();
                                $bandera_exito = true;
                            }
                            break;
                    }
                }

                $respuesta = new \stdClass();
                if ($bandera_exito) {
                    $respuesta->tabla = $this->generarTabla($comision->id);
                    $respuesta->mensaje = (new Mensaje("Exito", "Asignación de nuevo Secretario realizada con exito", "success"))->toArray();
                } else {
                    $respuesta->mensaje = (new Mensaje("Error", "Asignación de nuevo Secretario no se pudo realizar", "error"))->toArray();
                }

                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function cambiar_cargos_junta_directiva()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            //$cargos_jd = array("Presidente"=>"Presidente","Vicepresidente"=>"Vicepresidente","Secretario"=>"Secretario","Vocal 1"=>"Vocal 1","Vocal 2"=>"Vocal 2");
            $cargos_jd = TipoCargo::where('grupo', '=', 'jd')->get();
            //dd($cargos_jd2);

            $miembros_jd = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
                ->join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
                ->where("cargos.comision_id", 1)
                ->where("asambleistas.activo", 1)
                ->where("periodos.activo", 1)
                ->where("cargos.activo", 1)
                ->get();

            return view("Administracion.cambiar_cargos_junta_directiva", ["miembros_jd" => $miembros_jd, "cargos_jd" => $cargos_jd]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_cargo_miembro_jd(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $miembros_jd = Cargo::where("comision_id", 1)->where("activo", 1)->get();
                $cargo = TipoCargo::find(intval($request->get("nuevo_cargo")));
                $cargo_nulo = TipoCargo::where("nombre_cargo", "Sin Cargo")->first();
                foreach ($miembros_jd as $miembro) {
                    if ($miembro->tipo_cargo_id == $cargo->id) {
                        $miembro->tipo_cargo_id = $cargo_nulo->id;
                        //$miembro->cargo = $cargo_nulo->nombre_cargo;
                        $miembro->save();
                    }

                    if ($miembro->asambleista->id == $request->get("idMiembroJD")) {
                        $miembro->tipo_cargo_id = $cargo->id;
                        //$miembro->cargo = $cargo->nombre_cargo;
                        $miembro->save();
                    }
                }

                $respuesta = new \stdClass();
                $respuesta->tabla = $this->generarTabla(1);
                $respuesta->mensaje = (new Mensaje("Exito", "Asignación de nuevo cargo " . $cargo->nombre_cargo . " realizada con exito", "success"))->toArray();
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function gestionar_perfiles()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $perfiles = Rol::all();
            return view("Administracion.gestionar_perfiles", ["perfiles" => $perfiles]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function agregar_perfiles(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $rol = new Rol();
                $rol->nombre_rol = ucfirst($request->get("perfil"));
                $rol->save();

                $respuesta = new \stdClass();
                $respuesta->mensaje = (new Mensaje("Exito", "Perfil agregado con exito", "success"))->toArray();
                return new JsonResponse($respuesta);

            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

        //return redirect()->route("gestionar_perfiles");
    }

    public function administrar_acceso_modulos(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $modulos_padres = Modulo::where("tiene_hijos", 1)->get();
            $modulos_hijos = Modulo::all();
            $id_rol = Rol::find($request->get("id_rol"));
            $modulosArrayTemporal = $id_rol->modulos->toArray();
            $modulosArray = array();
            foreach ($modulosArrayTemporal as $mat) {
                array_push($modulosArray, $mat["pivot"]["modulo_id"]);
            }
            return view("Administracion.administrar_acceso_modulos", ["modulos_padres" => $modulos_padres, "modulos_hijos" => $modulos_hijos, "id_rol" => $id_rol, "modulosArray" => $modulosArray]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function asignar_acceso_modulos(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $id_rol = $request->get("id_rol");
            $modulos = $request->get("modulos");
            $rol = Rol::find($id_rol);

            //obtener los modulos que se encuentran en la tabla modulo_rol
            $roles = Rol::find($id_rol);
            $modulos_actuales = $roles->modulos()->get();
            //se remueven todos los modulos que tiene asociado el rol
            foreach ($modulos_actuales as $modulo) {
                $modulo->roles()->detach($rol->id);
            }

            //para salvar en la relacion ManyToMany de rol y modulo
            $arrayTemporal = array();
            $ModuloPadreTienePadre = false;
            array_push($arrayTemporal, 1);
            foreach ($modulos as $modulo) {
                $mod = Modulo::find($modulo);

                $mp = Modulo::find($mod->modulo_padre);
                if ($mp->modulo_padre != "") {
                    $mp2 = Modulo::find($mp->modulo_padre);
                    $ModuloPadreTienePadre = true;
                }

                switch ($ModuloPadreTienePadre) {
                    case false:
                        if (!in_array($mp->id, $arrayTemporal)) {
                            array_push($arrayTemporal, $mp->id);
                        }
                        break;
                    case true:
                        if (!in_array($mp->id, $arrayTemporal) && !in_array($mp2->id, $arrayTemporal)) {
                            array_push($arrayTemporal, $mp->id);
                            array_push($arrayTemporal, $mp2->id);
                        }
                        break;
                }
                $ModuloPadreTienePadre = false;
                array_push($arrayTemporal, $mod->id);
            }

            $rol->modulos()->attach($arrayTemporal);
            return redirect()->route("gestionar_perfiles");
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }

    }

    public function agregar_plantillas(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                if ($request->hasFile("plantillas")) {
                    foreach ($request->plantillas as $plantilla) {
                        $documento = new Plantilla();
                        $documento->nombre = $plantilla->getClientOriginalName();
                    }
                    $respuesta = new \stdClass();
                    $respuesta->mensaje = (new Mensaje("Exito", "Plantillas agregadas con exito", "success"))->toArray();
                    return new JsonResponse($respuesta);
                }
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function registro_permisos_temporales()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $periodo_activo = Periodo::where('activo', '=', 1)->first();
            if (is_null($periodo_activo)) {
                $asambleistas = [];
                $permisos = [];
            } else {
                $asambleistas = Asambleista::where('activo', '=', 1)
                    ->where('periodo_id', '=', $periodo_activo->id)
                    ->get();
                $permisos = Permiso::all();
            }

            return view("Administracion.registro_permisos_temporales", ['asambleistas' => $asambleistas, 'permisos' => $permisos]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function mostrar_delegados(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $respuesta = new \stdClass();
                $asambleista = Asambleista::find($request->id);

                if ($asambleista->propietario == 1) {
                    $suplentes = Asambleista::where("sector_id", $asambleista->sector_id)->where("activo", 1)->where("propietario", 0)->where("facultad_id", $asambleista->facultad_id)->get();

                    $dropdown = '<option value="">-- Seleccione un delegado --</option>';
                    foreach ($suplentes as $suplente) {
                        $dropdown .= '<option value="' . $suplente->id . '">' . $suplente->user->persona->primer_nombre . ' ' . $suplente->user->persona->segundo_nombre . ' ' . $suplente->user->persona->primer_apellido . ' ' . $suplente->user->persona->segundo_apellido . '</option>';
                    }
                    $respuesta->dropdown = $dropdown;
                } else {
                    $respuesta->esPropietario = 1;
                }
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardar_permiso(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $permiso = new Permiso();
                $permiso->asambleista_id = $request->get("asambleista");

                if ($request->delegado != "")
                    $permiso->delegado_id = $request->get("delegado");

                $permiso->fecha_permiso = Carbon::now();
                $permiso->motivo = $request->motivo;
                $permiso->inicio = Carbon::createFromFormat("d-m-Y", $request->startDate);
                $permiso->fin = Carbon::createFromFormat("d-m-Y", $request->endDate);
                $permiso->save();

                $respuesta = new \stdClass();
                $respuesta->mensaje = (new Mensaje("Exito", "Retiro Temporal registrado con exito", "success"))->toArray();
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function guardarPlantilla($doc, $plantilla_id, $destino)
    {
        $archivo = $doc;
        $vieja_plantilla = Plantilla::where('id', '=', $plantilla_id)->first();
        $vieja_plantilla->nombre = $archivo->getClientOriginalName();

        //$plantilla = new Plantilla();
        //$plantilla->nombre = $archivo->getClientOriginalName();
        $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        while (Plantilla::where('path', '=', $ruta)->first()) {
            $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        }
        //dd($ruta);
        $r1 = Storage::disk($destino)->put($ruta, \File::get($archivo));
        $vieja_plantilla->path = $ruta;
        $vieja_plantilla->save();

        return $vieja_plantilla;
    }

    public function obtener_usuario(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $usuario = User::find($request->id);
                $respuesta = new \stdClass();
                $respuesta->user_id = $usuario->id;
                $respuesta->primer_nombre = $usuario->persona->primer_nombre;
                $respuesta->segundo_nombre = $usuario->persona->segundo_nombre;
                $respuesta->primer_apellido = $usuario->persona->primer_apellido;
                $respuesta->segundo_apellido = $usuario->persona->segundo_apellido;
                $respuesta->foto = $usuario->persona->foto;
                $respuesta->correo = $usuario->email;
                $respuesta->dui = $usuario->persona->dui;
                $respuesta->nit = $usuario->persona->nit;
                $fecha_respuesta = DateTime::createFromFormat('Y-m-d', $usuario->persona->nacimiento);
                $respuesta->fecha = $fecha_respuesta->format('d-m-Y');
                $respuesta->afp = $usuario->persona->afp;
                $respuesta->cuenta = $usuario->persona->cuenta;
                $respuesta->tipo = $usuario->rol_id;
                if ($usuario->rol->id == 3) {
                    $asambleista = Asambleista::where("user_id", $request->id)->first();
                    $respuesta->sector = $asambleista->sector->id;
                    $respuesta->facultad = $asambleista->facultad->id;
                    $respuesta->propietario = $asambleista->propietario;
                }
                $respuesta->disco = "../storage/fotos/";
                return new JsonResponse($respuesta);
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_usuario(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {

                $total_tipos_usuarios = 0;
                $respuesta = new \stdClass();

                if ($request->tipo_usuario_actualizar == 3) {
                    $periodo_activo = Periodo::where("activo", 1)->first();
                    $total_tipos_usuarios = Asambleista::join("users", "asambleistas.user_id", "=", "users.id")
                        ->where("users.rol_id", 3)
                        ->where('asambleistas.propietario', $request->propietario_actualizar)
                        ->where('asambleistas.facultad_id', $request->facultad_actualizar)
                        ->where('asambleistas.sector_id', $request->sector_actualizar)
                        ->where('asambleistas.activo', 1)
                        ->where('asambleistas.periodo_id', $periodo_activo->id)
                        ->count();
                }

                if ($total_tipos_usuarios == 2 && $request->cambio_propietaria == 1) {
                    $respuesta->error = true;
                    $facultad = Facultad::find($request->facultad_actualizar);
                    $sector = Sector::find($request->sector_actualizar);
                    $propietaria = ($request->propietario_actualizar == 0) ? 'Suplentes' : 'Propietarios';
                    $respuesta->mensaje = (new Mensaje("Error", "Ya existe el total maximo de asambleistas " . $propietaria . " para la " . $facultad->nombre . " en el sector " . $sector->nombre, "error"))->toArray();
                    return new JsonResponse($respuesta);
                } else {

                    $usuario = User::find($request->user_id_actualizar);
                    $persona = Persona::find($usuario->persona->id);
                    $persona->primer_nombre = $request->get("primer_nombre_actualizar");
                    $persona->segundo_nombre = $request->get("segundo_nombre_actualizar");
                    $persona->primer_apellido = $request->get("primer_apellido_actualizar");
                    $persona->segundo_apellido = $request->get("segundo_apellido_actualizar");
                    $persona->dui = $request->get("dui_actualizar");
                    $persona->nit = $request->get("nit_actualizar");
                    //$persona->nacimiento = $request->get("fecha1_actualizar");
                    $fecha1_actualizar = DateTime::createFromFormat('d-m-Y', $request->fecha1_actualizar);
                    $persona->nacimiento = $fecha1_actualizar->format('Y-m-d');
                    //sentencia para agregar la foto
                    //$persona->foto = $request->get("foto");

                    $persona->afp = $request->get("afp_actualizar");
                    $persona->cuenta = $request->get("cuenta_actualizar");
                    $persona->save();

                    $usuario->rol_id = $request->get("tipo_usuario_actualizar");
                    //$usuario->persona_id = $persona->id;
                    $usuario->name = $persona->primer_nombre . "." . $persona->primer_apellido;
                    //$usuario->password = bcrypt("ATB");
                    $usuario->email = $request->get("correo_actualizar");
                    $usuario->activo = 1;
                    $usuario->save();


                    if ($request->get("tipo_usuario_actualizar") == 3) {
                        $asambleista = Asambleista::where("user_id", $usuario->id)->first();
                        //$periodo_activo = Periodo::where("activo", "=", 1)->first();
                        //$asambleista->user_id = $usuario->id;
                        //$asambleista->periodo_id = $periodo_activo->id;
                        $asambleista->facultad_id = $request->get("facultad_actualizar");
                        $asambleista->sector_id = $request->get("sector_actualizar");
                        $asambleista->propietario = $request->get("propietario_actualizar");
                        //setea al user como un asambleista activo
                        //$asambleista->activo = 1;

                        /*$hoy = Carbon::now();
                        $inicio_periodo = Carbon::createFromFormat("Y-m-d", $periodo_activo->inicio);

                        if ($hoy > $inicio_periodo) {
                            $asambleista->inicio = $hoy;
                        } else {
                            $asambleista->inicio = $inicio_periodo;
                        }*/
                        $asambleista->save();
                    }

                    $respuesta->error = false;
                    $respuesta->mensaje = (new Mensaje("Exito", "Usuario actualizado con exito", "success"))->toArray();
                    return new JsonResponse($respuesta);
                }
            }
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function dietas_asambleista(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $todos = 0;
            $dietas = collect();//Dieta::join("asambleistas","dietas.asambleista_id", "=","asambleistas.id")->get();

            $asambleistas_activos = Asambleista::where('id', '!=', '0')->where('activo', '=', '1')->get();
            $asambleistas_plenaria[] = array();
            foreach ($asambleistas_activos as $asambleista) {
                $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                    . ' ' . $asambleista->user->persona->segundo_nombre
                    . ' ' . $asambleista->user->persona->primer_apellido
                    . ' ' . $asambleista->user->persona->segundo_apellido;
            }
            unset($asambleistas_plenaria[0]);

            $meses = $this->getMeses();
            //dd($asambleistas_plenaria);
            $periodo = Periodo::latest()->first();
            $start = $periodo->inicio;//'2010-12-02';
            $end = $periodo->fin;//'2016-05-06';


            $getRangeYear = range(gmdate('Y', strtotime($start)), gmdate('Y', strtotime($end)));

            /*
                $integrantes = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
                        ->join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
                        ->where("cargos.comision_id", $request->get("idComision"))
                        ->where("asambleistas.activo", 1)
                        ->where("periodos.activo", 1)
                        ->where("cargos.activo", 1)
                        ->get();
            */
            //$todos = 0;
            return view('Administracion.dietas_asambleista')
                ->with('todos', $todos)
                ->with('meses', $meses)
                ->with('dietas', $dietas)
                ->with('getRangeYear', $getRangeYear)
                ->with('asambleistas_plenaria', $asambleistas_plenaria);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function busqueda_dietas_asambleista(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            dd($request->all());
            $todos = 0;
            $periodo = Periodo::latest()->first();
            $start = $periodo->inicio;//'2010-12-02';
            $end = $periodo->fin;//'2016-05-06';

            $getRangeYear = range(gmdate('Y', strtotime($start)), gmdate('Y', strtotime($end)));


            $mes = $request->meses;
            $year = $getRangeYear[$request->getRangeYear];
            $asambleista_id = $request->asambleista_id;
            //dd($year);

            if ($asambleista_id == "") {
                $dietas = Dieta::join("asambleistas", "dietas.asambleista_id", "=", "asambleistas.id")
                    ->where("asambleistas.activo", "=", 1)
                    //->where("asambleistas.id","=", $asambleista_id)
                    ->where("dietas.mes", "=", $mes)
                    ->where("dietas.anio", "=", $year)
                    ->select('dietas.*')
                    ->get();
                $todos = 1;
            } else {
                $dietas = Dieta::join("asambleistas", "dietas.asambleista_id", "=", "asambleistas.id")
                    ->where("asambleistas.activo", "=", 1)
                    ->where("asambleistas.id", "=", $asambleista_id)
                    ->where("dietas.mes", "=", $mes)
                    ->where("dietas.anio", "=", $year)
                    ->select('dietas.*')
                    ->get();
                $todos = 0;
            }

            //dd($dietas);
            $asambleistas_activos = Asambleista::where('id', '!=', '0')->where('activo', '=', '1')->get();
            $asambleistas_plenaria[] = array();
            foreach ($asambleistas_activos as $asambleista) {
                $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                    . ' ' . $asambleista->user->persona->segundo_nombre
                    . ' ' . $asambleista->user->persona->primer_apellido
                    . ' ' . $asambleista->user->persona->segundo_apellido;
            }
            unset($asambleistas_plenaria[0]);

            $meses = $this->getMeses();


            return view('Administracion.dietas_asambleista')
                ->with('todos', $todos)
                ->with('meses', $meses)
                ->with('dietas', $dietas)
                ->with('getRangeYear', $getRangeYear)
                ->with('asambleistas_plenaria', $asambleistas_plenaria);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function almacenar_dieta_asambleista(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            //dd($request->all());
            $todos = $request->todos;
            $periodo = Periodo::latest()->first();
            $start = $periodo->inicio;//'2010-12-02';
            $end = $periodo->fin;//'2016-05-06';

            $getRangeYear = range(gmdate('Y', strtotime($start)), gmdate('Y', strtotime($end)));

            $dieta = Dieta::where('id', '=', $request->id_dieta)->first();
            $dieta->asistencia = $request->asistencia;
            $dieta->junta_directiva = $request->junta_directiva;
            $dieta->save();
            $mes = $dieta->mes;
            $year = $dieta->anio;
            $asambleista_id = $dieta->asambleista_id;
            //dd($year);
            if ($todos == 1) {
                $dietas = Dieta::join("asambleistas", "dietas.asambleista_id", "=", "asambleistas.id")
                    ->where("asambleistas.activo", "=", 1)
                    //->where("asambleistas.id","=", $asambleista_id)
                    ->where("dietas.mes", "=", $mes)
                    ->where("dietas.anio", "=", $year)
                    ->select('dietas.*')
                    ->get();
            } else {
                $dietas = Dieta::join("asambleistas", "dietas.asambleista_id", "=", "asambleistas.id")
                    ->where("asambleistas.activo", "=", 1)
                    ->where("asambleistas.id", "=", $asambleista_id)
                    ->where("dietas.mes", "=", $mes)
                    ->where("dietas.anio", "=", $year)
                    ->select('dietas.*')
                    ->get();
            }
            //dd($dietas);
            $asambleistas_activos = Asambleista::where('id', '!=', '0')->where('activo', '=', '1')->get();
            $asambleistas_plenaria[] = array();
            foreach ($asambleistas_activos as $asambleista) {
                $asambleistas_plenaria[$asambleista->id] = $asambleista->user->persona->primer_nombre
                    . ' ' . $asambleista->user->persona->segundo_nombre
                    . ' ' . $asambleista->user->persona->primer_apellido
                    . ' ' . $asambleista->user->persona->segundo_apellido;
            }
            unset($asambleistas_plenaria[0]);

            $meses = $this->getMeses();


            return view('Administracion.dietas_asambleista')
                ->with('todos', $todos)
                ->with('meses', $meses)
                ->with('dietas', $dietas)
                ->with('getRangeYear', $getRangeYear)
                ->with('asambleistas_plenaria', $asambleistas_plenaria);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function bitacora_sistema()
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            $usuarios = User::where("activo", 1)->get();
            $bitacora = new Collection();
            return view("Administracion.bitacora_sistema", ["usuarios" => $usuarios, "bitacora" => $bitacora]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    public function consultar_bitacora(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            //dd($request->all());
            $usuario = $request->usuario;
            $fecha = $request->fecha;
            $accion = $request->accion;

            $bitacora = Bitacora::query();

            if ($usuario != "")
                $bitacora = $bitacora->where("user_id", $usuario);
            if ($fecha != "")
                $bitacora = $bitacora->where("fecha", date('Y-m-d', strtotime($fecha)));
            if ($accion != "")
                $bitacora = $bitacora->where("accion", "like", '%' . $accion . '%');
            //dd(date('H:i:s', strtotime($hora)));
            $bitacora = $bitacora->get();
            $usuarios = User::where("activo", 1)->get();
            return view("Administracion.bitacora_sistema", ["usuarios" => $usuarios, "bitacora" => $bitacora]);
        } catch (\Exception $e) {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), $e->getMessage());
            return view('errors.catch');
        }
    }

    private function generarTabla($idComision)
    {
        $comision = Comision::find($idComision);

        //obtener los integrantes de la comision y que esten activos en el periodo activo
        $integrantes = Cargo::join("asambleistas", "cargos.asambleista_id", "=", "asambleistas.id")
            ->join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
            ->where("cargos.comision_id", $idComision)
            ->where("asambleistas.activo", 1)
            ->where("periodos.activo", 1)
            ->where("cargos.activo", 1)
            ->get();

        //si el id que se recibe no es el que pertenece a JD
        if ($idComision != 1) {
            $tabla =
                "<table id='tabla_miembros' class='table table-striped table-bordered table-condensed table-hover dataTable text-center'>
                    <thead>
                        <tr>
                            <th>Asambleista</th>
                            <th>Cargo</th>
                            <th>Coordinador</th>
                            <th>Secretario</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($integrantes as $integrante) {
                $tabla .= "<tr>
                                <td>" . $integrante->asambleista->user->persona->primer_nombre . " " . $integrante->asambleista->user->persona->segundo_nombre . " " . $integrante->asambleista->user->persona->primer_apellido . " " . $integrante->asambleista->user->persona->segundo_apellido . "</td>
                                <td>" . $integrante->tipo_cargo->nombre_cargo . "</td>";

                if ($integrante->tipo_cargo->nombre_cargo == "Coordinador") {
                    $tabla .= "<td>
                                <div class='pretty p-icon p-curve'>
                                    <input type='checkbox' checked disabled />
                                    <div class='state p-success'><i class='icon mdi mdi-check'></i><label>Coordinador de Comision</label></div>
                                </div>
                          </td>";
                } else {
                    $tabla .= "<td>
                                <div class='pretty p-icon p-curve'>
                                    <input type='checkbox' onchange='actualizar_coordinador(" . $integrante->asambleista->id . ")'/>
                                    <div class='state p-success'><i class='icon mdi mdi-check'></i><label></label></div></div>
                           </td>";
                }

                if ($integrante->tipo_cargo->nombre_cargo == "Secretario") {
                    $tabla .= "<td>
                                <div class='pretty p-icon p-curve'>
                                    <input type='checkbox' checked disabled />
                                    <div class='state p-success'><i class='icon mdi mdi-check'></i><label>Secretario de Comision</label></div>
                                </div>
                          </td>";
                } else {
                    $tabla .= "<td>
                                <div class='pretty p-icon p-curve'>
                                    <input type='checkbox' onchange='actualizar_secretario(" . $integrante->asambleista->id . ")'/>
                                    <div class='state p-success'><i class='icon mdi mdi-check'></i><label></label></div></div>
                           </td>";
                }

            }

            $tabla .= "</tr></tbody></table>";
        } else { //si es JD
            $cargos_jd = TipoCargo::where('grupo', '=', 'jd')->get();
            $tabla =
                "<table id='tabla_miembros_jd' class='table table-striped table-bordered table-condensed table-hover dataTable text-center'>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cargo Actual</th>
                            <th>Nuevo Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($integrantes as $integrante) {
                $tabla .= "<tr>
                                <td>" . $integrante->asambleista->user->persona->primer_nombre . " " . $integrante->asambleista->user->persona->segundo_nombre . " " . $integrante->asambleista->user->persona->primer_apellido . " " . $integrante->asambleista->user->persona->segundo_apellido . "</td>
                                <td>" . $integrante->tipo_cargo->nombre_cargo . "</td>
                                <td>
                                    <select id='cargos_jd' name='cargos_jd' class='form-control' onchange='cambiar_cargo(" . $integrante->asambleista->id . ",this.value)'>
                                        <option>-- Seleccione un cargo --</option>";

                foreach ($cargos_jd as $cargo) {
                    $tabla .= "<option value='" . $cargo->id . "'>" . $cargo->nombre_cargo . "</option>";
                }
                $tabla .= "</select></td></tr>";
            }

            $tabla .= "</tbody></table>";
        }

        return $tabla;
    }

    public function getMeses()
    {
        $varMeses = [
            "enero" => "enero",
            "febrero" => "febrero",
            "marzo" => "marzo",
            "abril" => "abril",
            "mayo" => "mayo",
            "junio" => "junio",
            "julio" => "julio",
            "agosto" => "agosto",
            "septiembre" => "septiembre",
            "octubre" => "octubre",
            "noviembre" => "noviembre",
            "diciembre" => "diciembre",
        ];
        return $varMeses;
    }

    public function restaurar_contraseña(Request $request)
    {
        try {
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(), "ingreso");
            if ($request->ajax()) {
                $asambleista = Asambleista::find($request->id_asambleista);
                $user = User::find($asambleista->user_id);
                $user->password = bcrypt("ATB");
                $user->save();
                $respuesta = new \stdClass();
                $respuesta->mensaje = (new Mensaje("Exito", "Contraseña restaurada con exito", "success"))->toArray();
                return new JsonResponse($respuesta);
            }
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
