<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

use Mail;
use Session;
use Carbon\Carbon;
use App\Comision;
use App\Cargo;
use App\Reunion;
use App\Agenda;
use App\Asambleista;
use App\Periodo;
use Auth;

class MailController extends Controller
{
    //
    public function envio_convocatoria(Request $request)
    {	

    	if ($request->id_reunion) {
    		$reunion = Reunion::where('id', '=', $request->id_reunion)->first();
	        return view('correos.envio_convocatoria')
	        ->with('reunion', $reunion);
    	}else{
    		$agenda = Agenda::where('id', '=', $request->id_agenda)->first();
	        return view('correos.envio_convocatoria')
	        ->with('agenda', $agenda);
    	}
    	
    }
    public function enviar_correo(Request $request)
    {
    	//dd($request->all());
    	$mensaje = $request->mensaje;
        $usuario = Auth::user()->persona->primer_nombre.
    				" ".Auth::user()->persona->segundo_nombre.
    				" ".Auth::user()->persona->primer_apellido.
    				" ".Auth::user()->persona->segundo_apellido;

        // SOLO PARA REUNIONES
        if ($request->id_reunion) {
        	$reunion = Reunion::where('id', '=', $request->id_reunion)->first();
	        $comision = $reunion->comision->nombre;
	        $lugar = $reunion->lugar;
	        $fecha = Carbon::parse($reunion->convocatoria)->format('d-m-Y');
	        $hora = Carbon::parse($reunion->convocatoria)->format('h:i A');
	    	if ($reunion->comision->id == 1) {
	    		$this->correos_reunion_junta_directiva($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario);
	    	} else {
	    		$this->correos_reunion_comision($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario);
	    	}
	    	$request->session()->flash("Exito", 'Los correos han sido enviados satisfactoriamente');

        	return view('correos.envio_convocatoria')
	        ->with('reunion', $reunion);
        }else{
        	$agenda = Agenda::where('id', '=', $request->id_agenda)->first();
	        $lugar = $agenda->lugar;
	        $fecha = Carbon::parse($agenda->inicio)->format('d-m-Y');
	        $hora = Carbon::parse($agenda->inicio)->format('h:i A');
	        $hora2 = Carbon::parse($agenda->inicio)->addMinutes(30)->format('h:i A');

	        $this->correos_todas_peticiones_agendadas($agenda); // ENVIO CORREO A TODAS LAS PERSONAS QUE TIENEN PUNTO EN ESTA SESION
	        //dd('entro al display');
	    	$this->correos_agendas($agenda,$lugar,$fecha,$hora,$hora2,$mensaje,$usuario); // ENVIO CORREO A TODOS LOS ASAMBLEISTAS

	    	$request->session()->flash("Exito", 'Los correos han sido enviados satisfactoriamente');

        	return view('correos.envio_convocatoria')
	        ->with('agenda', $agenda);
        }
    	
		// SOLO PARA REUNIONES

		// SOLO PARA AGENDAS
		
    	
		// SOLO PARA AGENDAS

		//dd('mail enviado');
		$request->session()->flash("Exito", 'Correos enviado con exito');

        return view('correos.envio_convocatoria');
    }

    public function correos_reunion_junta_directiva($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario)
    {	
    	$asunto = "Convocatoria para reunion de ".$comision;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $cargos = Cargo::where('comision_id','=',$reunion->comision_id)->where('activo','=','1')->get();

		foreach ($cargos as $cargo) {
			$correo_destinatario = $cargo->asambleista->user->email;

	    	Mail::queue('correos.junta_directiva_mail', ['comision' => $comision,'lugar' => $lugar,
	    		'fecha' => $fecha,'hora' => $hora,'mensaje' => $mensaje,'usuario' => $usuario], 
				function ($mail) use ($asunto,$correo_destinatario) {
				$mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
	            $mail->to($correo_destinatario);
	            $mail->subject($asunto);
	        });	
        }

        return 0;
    	
    }

    public function correos_reunion_comision($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario)
    {	
    	$asunto = "Convocatoria para reunion de ".$comision;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
		$cargos = Cargo::where('comision_id','=',$reunion->comision_id)->where('activo','=','1')->get();

		foreach ($cargos as $cargo) {
			$correo_destinatario = $cargo->asambleista->user->email;

			Mail::queue('correos.comision_mail', ['comision' => $comision,'lugar' => $lugar,
				'fecha' => $fecha,'hora' => $hora,'mensaje' => $mensaje,'usuario' => $usuario], 
				function ($mail) use ($asunto,$correo_destinatario) {
				$mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
	            $mail->to($correo_destinatario);
	            $mail->subject($asunto);
        	});	
		}

         

    	

        return 0;
    	
    }

    public function correos_agendas($agenda,$lugar,$fecha,$hora,$hora2,$mensaje,$usuario)
    {	
    	$asunto = "Convocatoria para reunion de Sesion Plenaria ".$agenda->codigo;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $asambleistas = Asambleista::join("periodos","asambleistas.periodo_id","=","periodos.id")
                        ->where("periodos.activo","=",1)
                        ->where("asambleistas.activo","=",1)
                        ->get();

        foreach ($asambleistas as $asambleista) {
            $correo_destinatario = $asambleista->user->email;

	    	Mail::queue('correos.agenda_mail', ['agenda' => $agenda,'lugar' => $lugar,
	    		'fecha' => $fecha,'hora' => $hora,'hora2' => $hora2,'mensaje' => $mensaje,'usuario' => $usuario], 
				function ($mail) use ($asunto,$correo_destinatario) {
				$mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
	            $mail->to($correo_destinatario);
	            $mail->subject($asunto);
	        });	            
        }                
        

        return 0;
    	
    }

    public function correos_todas_peticiones_agendadas($agenda)
    {
    	foreach ($agenda->puntos as $punto) {
    		# code...
    		$peticion = $punto->peticion;
    		$this->correos_peticion_agendada($peticion,$agenda);
    	}
    	return 0;
    }




    public function correos_peticion_agendada($peticion,$agenda)
    {    
        $asunto = "Peticion agenedada para siguiente sesion plenaria";

            // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $correo_destinatario = $peticion->correo;
        //dd($fecha);
        
        Mail::queue('correos.peticion_agendada_mail', ['peticion' => $peticion,'agenda' => $agenda], 
            function ($mail) use ($asunto,$correo_destinatario) {
            $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
            $mail->to($correo_destinatario);
            $mail->subject($asunto);
        }); 
        
          

            return 0;
        
    }


}

























































   //  public function correos_reunion_junta_directiva($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario)
   //  {	
   //  	$asunto = "Convocatoria para reunion de ".$comision;

   //      // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
   //       $correo_destinatario = "metahuargen@gmail.com";

   //  	Mail::queue('correos.junta_directiva_mail', ['comision' => $comision,'lugar' => $lugar,'fecha' => $fecha,'hora' => $hora,'mensaje' => $mensaje,'usuario' => $usuario], 
			// function ($mail) use ($asunto,$correo_destinatario) {
			// $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
   //          $mail->to($correo_destinatario);
   //          $mail->subject($asunto);
   //      });	

   //      return 0;
    	
   //  }

   //  public function correos_reunion_comision($reunion,$comision,$lugar,$fecha,$hora,$mensaje,$usuario)
   //  {	
   //  	$asunto = "Convocatoria para reunion de ".$comision;

   //      // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
   //       $correo_destinatario = "metahuargen@gmail.com";

   //  	Mail::queue('correos.comision_mail', ['comision' => $comision,'lugar' => $lugar,'fecha' => $fecha,'hora' => $hora,'mensaje' => $mensaje,'usuario' => $usuario], 
			// function ($mail) use ($asunto,$correo_destinatario) {
			// $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
   //          $mail->to($correo_destinatario);
   //          $mail->subject($asunto);
   //      });	

   //      return 0;
    	
   //  }

   //  public function correos_agendas($agenda,$lugar,$fecha,$hora,$hora2,$mensaje,$usuario)
   //  {	
   //  	$asunto = "Convocatoria para reunion de Sesion Plenaria ".$agenda->codigo;

   //      // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
   //      $asambleistas = Asambleista::join("periodos","asambleistas.periodo_id","=","periodos.id")
   //                      ->where("periodos.activo","=",1)
   //                      ->where("asambleistas.activo","=",1)
   //                      ->get();

   //      foreach ($asambleistas as $asambleista) {
                        
   //                      }                
   //      $correo_destinatario = "metahuargen@gmail.com";

   //  	Mail::queue('correos.agenda_mail', ['agenda' => $agenda,'lugar' => $lugar,'fecha' => $fecha,'hora' => $hora,'hora2' => $hora2,'mensaje' => $mensaje,'usuario' => $usuario], 
			// function ($mail) use ($asunto,$correo_destinatario) {
			// $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU'); 
   //          $mail->to($correo_destinatario);
   //          $mail->subject($asunto);
   //      });	

   //      return 0;
    	
   //  }


