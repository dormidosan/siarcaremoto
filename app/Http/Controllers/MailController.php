<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;

use Mail;
use Session;
use App\User;
use App\Comision;
use App\Reunion;
use App\Periodo;
use DateTime;

class MailController extends Controller
{
    //
    public function crear_convocatoria()
    {


        return view('correo.crear_convocatoria');
    }


    public function convocatoria_jd()
    {


        return view('jdagu.convocatoria_jd');
    }



    //public function mailing_jd(request $request){
    /*
    Mail::send('correo.contact',$request->all(),function($msj){
        $msj->from('siarcaf@gmail.com');
        $msj->subject('correo de contacto');
        $msj->to('siarcaf@gmail.com');
    });
*/
    //	$destinos = User::where('id','<','4')->get();
    //dd($destinos);
    /*
               foreach ($destinos as $user) {

                        Mail::later(5,'correo.contact',$request->all(), function ($message) use ($user) {
                         $message->from('from@example.com');
                         $message->to($user->email,$user->name)->subject($user->name." ".'Welcome!!!');
         });

               }
    */
    /*
         foreach ($destinos as $user) {

              Mail::queue('correo.contact',$request->all(), function ($message) use ($user) {
                $message->from('from@example.com');
                $message->subject("TODO ESTA PERDIDO ".$user->name." ".'Welcome!!!');
                $message->to($user->email,$user->name);
      });

         }

   dd($destinos);
           Session::flash('message','Mensaje enviado correctamente');

           return view('correo.crear_convocatoria');
       }
   */


    public function mailing_jd(Request $request, Redirector $redirect)
    {

        $comision = Comision::where('id', '=', $request->id_comision)->firstOrFail();
        $cargos = $comision->cargos;


        $reunion = new Reunion();
        //dd($request->fecha);
        $reunion->comision_id = $request->id_comision;
        $reunion->periodo_id = Periodo::latest()->first()->id;
        $reunion->codigo = $comision->codigo . " " . DateTime::createFromFormat('d/m/Y', $request->fecha)->format('d-m-y');
        $reunion->lugar = $request->lugar;
        $reunion->convocatoria = DateTime::createFromFormat('d/m/Y H:i:s', $request->fecha . '' . date('H:i:s', strtotime($request->hora)))->format('Y-m-d H:i:s');
        //$reunion->inicio
        //$reunion->fin           .''.date('H:i:s', strtotime($request->hora))
        $reunion->vigente = '1';
        $reunion->activa = '0';
        //date('j-m-y'); Carbon::now()->format('Y-m-d H:i:s')
        $reunion->save();
        //dd($reunion);
        foreach ($cargos as $cargo) {
            $destinatario = $cargo->asambleista->user->email;
            $nombre = $cargo->asambleista->user->persona->primer_nombre . " " . $cargo->asambleista->user->persona->segundo_nombre;
            Mail::queue('correo.contact', $request->all(), function ($message) use ($destinatario, $nombre, $comision) {
                $message->from('from@example.com');
                $message->subject("Convocatoria " . $comision->nombre . " para: " . $nombre);
                $message->to($destinatario, $nombre);
            });
        }


        $request->session()->flash("success", 'Correos electronicos enviados');
        //Session::flash('success','Mensaje enviado correctamente');
        //dd();

        Session::flash('message', 'Mensaje enviado correctamente');

        return view('jdagu.convocatoria_jd');
    }

}
