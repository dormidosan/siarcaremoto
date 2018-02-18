<?php

namespace App\Http\Controllers;

use App\Clases\Mensaje;
use App\Persona;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function mostrar_datos_usuario(){
        $user = User::find(Auth::user()->id);
        return view("Usuario.administrar_datos_usuario",['usuario'=>$user]);
    }

    public function actualizar_contraseña(Request $request){
        if ($request->ajax()){
            $user = User::find($request->id_user);
            $user->password = bcrypt($request->password);
            $user->save();
            $respuesta = new \stdClass();
            $respuesta->mensaje = (new Mensaje("Exito","Contraseña actualizada con exito","success"))->toArray();
            return new JsonResponse($respuesta);
        }
    }

    public function actualizar_imagen(Request $request){
        if ($request->ajax()){
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
            $respuesta->mensaje = (new Mensaje("Exito","Imagen actualizada con exito","success"))->toArray();
            return new JsonResponse($respuesta);
        }
    }
}
