<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;
use Storage;
use Carbon\Carbon;
use App\Comision;
use App\Cargo;
use App\Reunion;
use App\Agenda;
use App\Asambleista;
use App\Periodo;
use App\Documento;
use Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class MailController extends Controller
{
    //
    public function envio_convocatoria(Request $request)
    {

        if ($request->id_reunion) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
            $comision = Comision::where('id', '=', $request->id_comision)->first();

            if ($request->correo_JD)
                return view('correos.envio_convocatoria')
                    ->with('reunion', $reunion)
                    ->with('comision', $comision)
                    ->with('jd', true);
            else
                return view('correos.envio_convocatoria')
                    ->with('reunion', $reunion)
                    ->with('comision', $comision)
                    ->with('jd', false);
        } else {
            $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
            return view('correos.envio_convocatoria')
                ->with('agenda', $agenda)
                ->with('jd', true);
        }

    }

    public function enviar_correo(Request $request)
    {
        //dd($request->all());
        $mensaje = $request->mensaje;
        $usuario = Auth::user()->persona->primer_nombre .
            " " . Auth::user()->persona->segundo_nombre .
            " " . Auth::user()->persona->primer_apellido .
            " " . Auth::user()->persona->segundo_apellido;

        $jd = true;

        // SOLO PARA REUNIONES
        if ($request->id_reunion) {
            $reunion = Reunion::where('id', '=', $request->id_reunion)->first();
            $comision = $reunion->comision->nombre;
            $lugar = $reunion->lugar;
            $fecha = Carbon::parse($reunion->convocatoria)->format('d-m-Y');
            $hora = Carbon::parse($reunion->convocatoria)->format('h:i A');
            if ($reunion->comision->id == 1) {
                $this->correos_reunion_junta_directiva($reunion, $comision, $lugar, $fecha, $hora, $mensaje, $usuario);
            } else {
                $this->correos_reunion_comision($reunion, $comision, $lugar, $fecha, $hora, $mensaje, $usuario);
            }
            $request->session()->flash("Exito", 'Los correos han sido enviados satisfactoriamente');

            if ($reunion->comision->id != 1)
                $jd = false;

            return view('correos.envio_convocatoria')
                ->with('reunion', $reunion)
                ->with('jd', $jd);
        } else {
            $agenda = Agenda::where('id', '=', $request->id_agenda)->first();
            $this->generar_documento_convocatoria($agenda);
            $lugar = $agenda->lugar;
            $fecha = Carbon::parse($agenda->inicio)->format('d-m-Y');
            $hora = Carbon::parse($agenda->inicio)->format('h:i A');
            $hora2 = Carbon::parse($agenda->inicio)->addMinutes(30)->format('h:i A');

            $this->correos_todas_peticiones_agendadas($agenda); // ENVIO CORREO A TODAS LAS PERSONAS QUE TIENEN PUNTO EN ESTA SESION
            //dd('entro al display');
            $this->correos_agendas($agenda, $lugar, $fecha, $hora, $hora2, $mensaje, $usuario); // ENVIO CORREO A TODOS LOS ASAMBLEISTAS

            $request->session()->flash("Exito", 'Los correos han sido enviados satisfactoriamente');

            return view('correos.envio_convocatoria')
                ->with('agenda', $agenda)
                ->with('jd', true);
        }

        // SOLO PARA REUNIONES

        // SOLO PARA AGENDAS


        // SOLO PARA AGENDAS

        //dd('mail enviado');
        $request->session()->flash("Exito", 'Correos enviado con exito');

        return view('correos.envio_convocatoria');
    }

    public function correos_reunion_junta_directiva($reunion, $comision, $lugar, $fecha, $hora, $mensaje, $usuario)
    {
        $asunto = "Convocatoria para reunion de " . $comision;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $cargos = Cargo::where('comision_id', '=', $reunion->comision_id)->where('activo', '=', '1')->get();

        foreach ($cargos as $cargo) {
            $correo_destinatario = $cargo->asambleista->user->email;

            Mail::queue('correos.junta_directiva_mail', ['comision' => $comision, 'lugar' => $lugar,
                'fecha' => $fecha, 'hora' => $hora, 'mensaje' => $mensaje, 'usuario' => $usuario],
                function ($mail) use ($asunto, $correo_destinatario) {
                    $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU');
                    $mail->to($correo_destinatario);
                    $mail->subject($asunto);
                });
        }

        return 0;

    }

    public function correos_reunion_comision($reunion, $comision, $lugar, $fecha, $hora, $mensaje, $usuario)
    {
        $asunto = "Convocatoria para reunion de " . $comision;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $cargos = Cargo::where('comision_id', '=', $reunion->comision_id)->where('activo', '=', '1')->get();

        foreach ($cargos as $cargo) {
            $correo_destinatario = $cargo->asambleista->user->email;

            Mail::queue('correos.comision_mail', ['comision' => $comision, 'lugar' => $lugar,
                'fecha' => $fecha, 'hora' => $hora, 'mensaje' => $mensaje, 'usuario' => $usuario],
                function ($mail) use ($asunto, $correo_destinatario) {
                    $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU');
                    $mail->to($correo_destinatario);
                    $mail->subject($asunto);
                });
        }


        return 0;

    }

    public function correos_agendas($agenda, $lugar, $fecha, $hora, $hora2, $mensaje, $usuario)
    {
        $asunto = "Convocatoria para reunion de Sesion Plenaria " . $agenda->codigo;

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $asambleistas = Asambleista::join("periodos", "asambleistas.periodo_id", "=", "periodos.id")
            ->where("periodos.activo", "=", 1)
            ->where("asambleistas.activo", "=", 1)
            ->get();

        foreach ($asambleistas as $asambleista) {
            $correo_destinatario = $asambleista->user->email;

            Mail::queue('correos.agenda_mail', ['agenda' => $agenda, 'lugar' => $lugar,
                'fecha' => $fecha, 'hora' => $hora, 'hora2' => $hora2, 'mensaje' => $mensaje, 'usuario' => $usuario],
                function ($mail) use ($asunto, $correo_destinatario) {
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
            $this->correos_peticion_agendada($peticion, $agenda);
        }
        return 0;
    }


    public function correos_peticion_agendada($peticion, $agenda)
    {
        $asunto = "Peticion agenedada para siguiente sesion plenaria";

        // $contenido = "El contenido del mail enviado desde el controlador a la vistas";
        $correo_destinatario = $peticion->correo;
        //dd($fecha);

        Mail::queue('correos.peticion_agendada_mail', ['peticion' => $peticion, 'agenda' => $agenda],
            function ($mail) use ($asunto, $correo_destinatario) {
                $mail->from('siarcaf@gmail.com', 'Sistema de acuerdos y actas AGU');
                $mail->to($correo_destinatario);
                $mail->subject($asunto);
            });


        return 0;

    }

    public function guardarDocumento($doc, $tipo, $destino)
    {
        $archivo = $doc;
        $documento = new Documento();
        $documento->nombre_documento = $archivo->getClientOriginalName();
        $documento->tipo_documento_id = $tipo; // PETICION = 1
        $documento->periodo_id = Periodo::latest()->first()->id;
        $documento->fecha_ingreso = Carbon::now();
        $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();

        while (Documento::where('path', '=', $ruta)->first()) {
            $ruta = MD5(microtime()) . "." . $archivo->getClientOriginalExtension();
        }

        $r1 = Storage::disk($destino)->put($ruta, \File::get($archivo));
        $documento->path = $ruta;
        $documento->save();
        return $documento;

    }


    public function generar_documento_convocatoria($agenda)
    {
        // ###############################################################################
        // ##################   INSERTAR CODIGO AQUI JAIME ###############################
        // ###############################################################################

        $fecha_generado=Carbon::now()->format('Y-m-d');

        $puntos=DB::table('puntos')
        ->where('puntos.agenda_id','=',$agenda->id)
        ->get();

        $periodo=DB::table('periodos')
        ->where('periodos.id','=',$agenda->periodo_id)
        ->first();

        $jefe=DB::table('asambleistas')
        ->join('users','users.id','=','asambleistas.user_id')
        ->join('personas','personas.id','=','users.persona_id')
        ->join('cargos','cargos.asambleista_id','=','asambleistas.id')
        ->where('cargos.tipo_cargo_id','=',1)
        ->select('personas.primer_apellido', 'personas.primer_nombre', 'personas.segundo_apellido',
                'personas.segundo_nombre')
        ->first();

       
        $primera_convocatoria=Carbon::parse($agenda->inicio)->format('H:i');
        $segunda_convocatoria=Carbon::parse($agenda->inicio)->addMinutes(30)->format('H:i');

        $view = \View::make('Reportes/Reporte_agenda_pdf', compact('fecha_generado','puntos','periodo','agenda','primera_convocatoria','segunda_convocatoria','jefe'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('letter', 'portrait')->setWarnings(false);

        $nombre_archivo = 'convocatoria_'.$fecha_generado.'.pdf';
        //$acta_de_jaime = Storage::disk('temporales')->getAdapter()->getPathPrefix().$nombre_archivo;
        //$acta_de_jaime=storage_path().'\app'.'\Convocatoria_'.$fecha_generado.'.pdf';

        //$pdf->save($acta_de_jaime);
        //$pdf->stream($nombre_archivo);
        // ###############################################################################
        // ##################   INSERTAR CODIGO AQUI JAIME ###############################
        // ###############################################################################
        // DEBES LLAMAR AL DOCUMENTO GENERADO POR VOS $acta_de_jaime y el solo lo guardara
        $nombre_aleatorio = $this->guardarDocumentoPDF($agenda,$nombre_archivo, '8', 'documentos'); //5  es CONVOCATORIA
        $acta_de_jaime = Storage::disk('documentos')->getAdapter()->getPathPrefix().$nombre_aleatorio;
        $pdf->save($acta_de_jaime);

        //dd($agenda->documentos);
        return 0;

    }


    public function guardarDocumentoPDF($agenda,$doc, $tipo, $destino)
    {
        $archivo = $doc;
        $documento = new Documento();
        $documento->nombre_documento = $archivo;
        $documento->tipo_documento_id = $tipo; // PETICION = 1
        $documento->periodo_id = Periodo::latest()->first()->id;
        $documento->fecha_ingreso = Carbon::now();
        $ruta = MD5(microtime()) . ".pdf";
        while (Documento::where('path', '=', $ruta)->first()) {
            $ruta = MD5(microtime()) . ".pdf";
        }
        //$r1 = Storage::disk($destino)->put($ruta, \File::get($stream));
        $documento->path = $ruta;
        $documento->save();
        $agenda->documentos()->attach($documento);
        return $documento->path;

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


