<?php

namespace App\Http\Controllers;

use App\Clases\Mensaje;
use App\Persona;
use App\User;
use App\Asambleista;
use App\Hoja;
use App\Bitacora;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class UsuarioController extends Controller
{
    public function mostrar_datos_usuario(Request $request)
    {
        
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $user = User::find(Auth::user()->id);
        $asambleista = Asambleista::where('user_id','=',$user->id)->first();
        $disco = "../storage/hojas_vida/";
        return view("Usuario.administrar_datos_usuario", ['usuario' => $user,"asambleista" => $asambleista,"disco"=>$disco]);       
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_contraseña(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()) {
            $user = User::find($request->id_user);
            $user->password = bcrypt($request->password);
            $user->save();
            $respuesta = new \stdClass();
            $respuesta->mensaje = (new Mensaje("Exito", "Contraseña actualizada con exito", "success"))->toArray();
            return new JsonResponse($respuesta);
        }       
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_imagen(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()) {
            $user = User::find(Auth::user()->id);
            $persona = Persona::find($user->persona_id);
            $disco = "../storage/fotos/";

            if ($request->hasFile('img')) {
                $file = $request->files->get('img');
                $ext = $file->guessExtension();
                if ($ext == "jpeg" || $ext == "jpg" || $ext == "png" || $ext == "gif") {
                    $nombreArchivo = time() . '' . rand(1, 9999) . '.' . $file->getClientOriginalExtension();
                    $persona->foto = $nombreArchivo;
                    $archivo = $file->move($disco, $nombreArchivo);
                    $persona->save();
                }
            }

            $respuesta = new \stdClass();
            $respuesta->mensaje = (new Mensaje("Exito", "Imagen actualizada con exito", "success"))->toArray();
            return new JsonResponse($respuesta);
        }       
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_datos(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        if ($request->ajax()) {
            $respuesta = new \stdClass();

            $usuario = User::find($request->user_id_actualizar);
            $persona = Persona::find($usuario->persona->id);
            $persona->primer_nombre = $request->get("primer_nombre_actualizar");
            $persona->segundo_nombre = $request->get("segundo_nombre_actualizar");
            $persona->primer_apellido = $request->get("primer_apellido_actualizar");
            $persona->segundo_apellido = $request->get("segundo_apellido_actualizar");
            $persona->dui = $request->get("dui_actualizar");
            $persona->nit = $request->get("nit_actualizar");
            $fecha1_actualizar = DateTime::createFromFormat('d-m-Y', $request->fecha1_actualizar);
            $persona->nacimiento = $fecha1_actualizar->format('Y-m-d');
            $persona->afp = $request->get("afp_actualizar");
            $persona->cuenta = $request->get("cuenta_actualizar");
            $persona->save();

            $usuario->name = $persona->primer_nombre . "." . $persona->primer_apellido;
            $usuario->email = $request->get("correo_actualizar");
            $usuario->activo = 1;
            $usuario->save();


            $respuesta->error = false;
            $respuesta->mensaje = (new Mensaje("Exito", "Usuario actualizado con exito", "success"))->toArray();
            return new JsonResponse($respuesta);

        }       
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }
    }

    public function actualizar_hoja(Request $request)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        //dd($request->all());
        $asambleista = $request->id_asambleista;
        //$asambleista = Asambleista::where('id','=',$request->id_asambleista)->first();
        $nuevahoja = $this->guardarhoja($request->hoja_vida, $asambleista, 'hojas_vida');
        //TERMINA EL ALMACENAMIENTO
        $request->session()->flash("success", "Documento actualizado");
        $user = User::find(Auth::user()->id);
        $asambleista = Asambleista::where('user_id','=',$user->id)->where('activo','=',1)->first();
        $disco = "../storage/hojas_vida/";
        return view("Usuario.administrar_datos_usuario", ['usuario' => $user,"asambleista" => $asambleista,"disco"=>$disco]);       
} 
        catch(\Exception $e){
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),$e->getMessage());
            return view('errors.catch');
        }

    }


    public function guardarhoja($doc, $asambleista_id, $destino)
    {
        try{
            $this->guardar_bitacora(Route::getCurrentRoute()->getPath(),"ingreso");
        $archivo = $doc;
        $asambleista = Asambleista::where('id','=',$asambleista_id)->first();
        //$vieja_plantilla->nombre = $archivo->getClientOriginalName();

        $hoja = new Hoja();
        $hoja->nombre = $archivo->getClientOriginalName();
        $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        while (Hoja::where('path', '=', $ruta)->first()) {
            $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        }
        //dd($ruta);
        $r1 = Storage::disk($destino)->put($ruta, \File::get($archivo));
        $hoja->path = $ruta ;
        $hoja->save();

        $asambleista->hoja_id = $hoja->id;
        $asambleista->save();

        return $hoja->id;       
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
