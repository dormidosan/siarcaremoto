<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\ActasRequest;
class PlantillasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


 public function buscar_actas(ActasRequest $request){
        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;   

        $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Plantillas.Plantilla_actas")
        ->with('resultados',NULL);
        }



        $resultados=DB::table('agendas')
     
        ->where('agendas.vigente','=',0)//0 por ser agenda vigente
        ->where
([
  ['agendas.fecha','>=',$this->convertirfecha($fechainicial)],
  ['agendas.fecha','<=',$this->convertirfecha($fechafinal)]
])->orderBy('agendas.fecha','desc')->get();

       // dd($resultados);

if($resultados==NULL){

 $request->session()->flash("warning", "No se encontraron registros");

}
else{
 $request->session()->flash("success", "Busqueda terminada con exito");
}

        return view("Plantillas.Plantilla_actas")
         ->with('resultados',$resultados);
      
    }



 public function buscar_acuerdos(ActasRequest $request){
        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;   


        $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Plantillas.Plantilla_acuerdos")
        ->with('resultados',NULL);
        }

        $resultados=DB::table('agendas')
        ->where('agendas.vigente','=',0)//0 por ser agenda vigente
        ->where
([
  ['agendas.fecha','>=',$this->convertirfecha($fechainicial)],
  ['agendas.fecha','<=',$this->convertirfecha($fechafinal)]
])->orderBy('agendas.fecha','desc')->get();

       // dd($resultados);

if($resultados==NULL){

 $request->session()->flash("warning", "No se encontraron registros");

}
else{
 $request->session()->flash("success", "Busqueda terminada con exito");
}

        return view("Plantillas.Plantilla_acuerdos")
         ->with('resultados',$resultados);


    }

public function buscar_propuesta($tipo){

        $parametros = explode('.', $tipo);
        $id_agenda=$parametros[0];
        $id_periodo=$parametros[1];
        $codigo_agenda=$parametros[2];
        $fecha_agenda=$parametros[3];
        $lugar_agenda=$parametros[4];

$resultados=DB::table('agendas')
->join('puntos','agendas.id','=','puntos.agenda_id')
->join('propuestas','puntos.id','=','propuestas.punto_id')
->where('agendas.id','=',$id_agenda)
->where('propuestas.ganadora','=',1)
->select('propuestas.id as pro_id','agendas.id as age_id','puntos.id as pun_id','propuestas.asambleista_id','propuestas.nombre_propuesta')
->get();


return view("Plantillas.Plantilla_acuerdos_encontrados")
->with('resultados',$resultados);



}


public function buscar_dictamenes(ActasRequest $request){
        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;   

        $date1 = Date($fechainicial);
        $date2 = Date($fechafinal);

        if($date1>$date2){
        $request->session()->flash("warning", "Fecha inicial no puede ser mayor a la fecha final");
        return view("Plantillas.Plantilla_acuerdos")
        ->with('resultados',NULL);
        }

        $resultados=DB::table('agendas')
     
        ->where('agendas.vigente','=',0)//0 por ser agenda vigente
        ->where
([
  ['agendas.fecha','>=',$this->convertirfecha($fechainicial)],
  ['agendas.fecha','<=',$this->convertirfecha($fechafinal)]
])->orderBy('agendas.fecha','desc')->get();

       // dd($resultados);

if($resultados==NULL){

 $request->session()->flash("warning", "No se encontraron registros");

}
else{
 $request->session()->flash("success", "Busqueda terminada con exito");
}

        return view("Plantillas.Plantilla_dictamenes")
         ->with('resultados',$resultados);


    }


     public function buscar_actas_JD(ActasRequest $request){
        $fechainicial=$request->fecha1;
        $fechafinal=$request->fecha2;   
        $resultados=DB::table('reuniones')
     
        ->where('reuniones.vigente','=',0)//0 por ser agenda vigente
        ->where
([
  ['reuniones.inicio','>=',$this->convertirfecha($fechainicial)],
  ['reuniones.inicio','<=',$this->convertirfecha($fechafinal)]
])->get();

       // dd($resultados);
        return view("Plantillas.Plantilla_actas_JD")
         ->with('resultados',$resultados);
      return view("Plantillas.Plantilla_Actas_JD",['resultados'=>NULL]);
    }



public function buscarFacultad($idFacultad){

$nombrefacultad='NO ASIGNADO';
$facultades=DB::table('facultades')        
        ->get();

foreach ($facultades as $facultad) {
    if($facultad->id==$idFacultad){
        $nombrefacultad=$facultad->nombre;
    }
}

return $nombrefacultad;

}


    public function desc_Plantilla_actas($tipo) //https://stackoverflow.com/questions/46202824/how-to-fix-warning-illegal-string-offset-in-laravel-5-4
    {
        
        $parametros = explode('.', $tipo);
        $id_agenda=$parametros[0];
        $id_periodo=$parametros[1];
        $codigo_agenda=$parametros[2];
        $fecha_agenda=$parametros[3];
        $lugar_agenda=$parametros[4];
        
        $periodos=DB::table('periodos')
        ->where('periodos.id','=', $id_periodo)
        ->first();

        $periodo_nombre=$periodos->nombre_periodo; //leido de la base
      

       
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section.
// To create a basic section:
$section = $PHPWord->createSection();

// After creating a section, you can append elements:

$PHPWord->addFontStyle('r2Style', array('bold'=>false, 'italic'=>false, 'size'=>12));
$PHPWord->addParagraphStyle('p2Style', array('align'=>'center'));
$PHPWord->addParagraphStyle('arial12', array('name'=>'Arial', 'size'=>10,'align'=>'both'));

//$PHPWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));

$header = $section->createHeader();
$textrun = $section->addTextRun('p2Style');


$header->addImage('C:\xampp\htdocs\siarcaf\public\images\Logo_UES.jpg', 
array('width'=>75, 'height'=>75, 'align'=>'Left','marginTop' => -1,
'wrappingStyle'=>'square',
       'positioning' => 'absolute',     
       'posVerticalRel' => 'line'));//margen izquierdo


$header->addImage('C:\xampp\htdocs\siarcaf\public\images\agu_web.jpg', 
array('width' => 120,
'height' => 120,
'align'=>'right',
'wrappingStyle' => 'square',
'positioning' => 'relative',
'marginTop' => 0

       ));  //margen derecho



$wrappingStyles = array('inline', 'behind', 'infront', 'square', 'tight');

$header->addText('UNIVERSIDAD DE EL SALVADOR','r2Style', 'p2Style');

$header->addText('ASAMBLEA GENERAL UNIVERSITARIA','r2Style', 'p2Style');

$header->addText('ACTA No.##/'.$periodo_nombre.' SESION PLENARIA ORDINARIA','r2Style', 'p2Style');




         $Asambleistas=DB::table('asistencias')
        ->join('asambleistas','asistencias.asambleista_id','=','asambleistas.id')
        ->join('users','asambleistas.user_id','=','users.id')
        ->join('personas','users.persona_id','=','personas.id')
        ->where('asistencias.agenda_id','=',$id_agenda)//por el momento solo filtro por el id
        ->select('personas.primer_apellido','personas.primer_nombre','personas.segundo_apellido',
                 'personas.segundo_nombre','asistencias.entrada','asistencias.salida','asistencias.propietaria','asambleistas.facultad_id')
        ->orderBy('asambleistas.facultad_id', 'asc')

        ->get();


$textrun = $section->addTextRun('arial12');

$textrun->addText('Realizado en '.$lugar_agenda.' de la Universidad de El Salvador realizado el '.$fecha_agenda.
    ' reunidos los siguientes Asambleistas:', 
array('name'=>'Arial', 'size'=>10, 'bold'=>true,'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));



$textrun1 = $section->addTextRun('p2Style');

$facultad='';

foreach ($Asambleistas as $Asambleista) {
     if(!($facultad==$this->buscarFacultad($Asambleista->facultad_id)))
     {
$textrun1->addText('<w:br/>'.$this->buscarFacultad($Asambleista->facultad_id).'<w:br/>'.'<w:br/>');
$facultad=$this->buscarFacultad($Asambleista->facultad_id);
     }
$textrun1->addText($Asambleista->primer_nombre.' '.$Asambleista->segundo_nombre.' '.$Asambleista->primer_apellido.' '.$Asambleista->segundo_apellido.'<w:br/>');
}



$textrun2 = $section->addTextRun('arial12');
$textrun2->addText('Para tratar la siguiente agenda propuesta por la junta directiva de este Organismo: <w:br/>');

$PHPWord->addNumberingStyle(
    'multilevel',
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'upperLetter', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
            array('format' => 'decimal', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720)
        )
    )
);


$textrun3 = $section->addTextRun('arial12');

//dd($id_agenda);
 $puntos=DB::table('puntos')
        ->where('puntos.agenda_id','=',$id_agenda)
        ->where('puntos.retirado','=',0)
         ->orderBy('puntos.romano','asc')
        ->get();
//dd($puntos);

foreach ($puntos as $punto) {
    $section->addListItem($punto->romano.' '.$punto->descripcion, 0, null, 'multilevel');

    $propuestas=DB::table('propuestas')
    ->where('propuestas.punto_id','=',$punto->id)
    ->get();
    foreach ($propuestas as $propuesta) {
   if($propuesta->ganadora==1){
    $section->addListItem($propuesta->nombre_propuesta.' FAVOR: '.$propuesta->favor.' CONTRA: '.$propuesta->contra.' (PROPUESTA GANADORA)', 1, null, 'multilevel');   
    }
    else{
    $section->addListItem($propuesta->nombre_propuesta.' FAVOR: '.$propuesta->favor.' CONTRA: '.$propuesta->contra, 1, null, 'multilevel');
    }
    }
    
}


$section->addText('Y para su conocimiento y efectos legales consiguientes, transcribo el presente Acuerdo en la 
    Ciudad Universitaria, San Salvador, '.$fecha_agenda);


$section->addText('Lic. César Alfredo Arias Hernández');
$section->addText('Secretario de la Junta Directiva');
$section->addText('Asamblea General Universitaria');


$footer = $section->createFooter();
//$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'right')); //Saca el numero de paginas del documento y lo agrega en el footer

$footer->addPreserveText('FINAL AVENIDA "Mártires Estudiantes del 30 de julio", Ciudad Universitaria
    Tel. Presidencia 2226-95950, Registro de Asociaciones Estudiantiles 2511-2057, Secretaria de la AGU 2225-7076,
    Unidad Financiera 2511-2022', array('align'=>'center'));

try {
      $objWriter =  \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007'); 
      $objWriter->save('Acta_'.$fecha_agenda.'_'. $codigo_agenda.'.docx'); // guarda los archivo en la carpeta public del proyecto

    } catch (Exception $e) {

    }

    

return response()->download('C:\xampp\htdocs\siarcaf\public\Acta_'.$fecha_agenda.'_'. $codigo_agenda.'.docx');


    }

 

    public function desc_Plantilla_acuerdos($tipo) //https://stackoverflow.com/questions/46202824/how-to-fix-warning-illegal-string-offset-in-laravel-5-4
    {
        
        $parametros = explode('.', $tipo);
        $id_propuesta=$parametros[0];
        $id_agenda=$parametros[1];
        $id_punto=$parametros[2];
      
      $agendas=DB::table('agendas')
      ->where('agendas.id','=',$id_agenda)
      ->first();
        

        $periodos=DB::table('periodos')
        ->where('periodos.id','=', $agendas->periodo_id)
        ->first();

        $periodo_nombre=$periodos->nombre_periodo; //leido de la base
      
      $puntos_agen=DB::table('puntos')
      ->where('puntos.id','=',$id_punto)
      ->first();
      $propuestas=DB::table('propuestas')
      ->where('propuestas.id','=',$id_propuesta)
      ->first();

       
$PHPWord = new PHPWord();

$section = $PHPWord->createSection();


$PHPWord->addFontStyle('r2Style', array('bold'=>false, 'italic'=>false, 'size'=>12));
$PHPWord->addParagraphStyle('p2Style', array('align'=>'center'));
$PHPWord->addParagraphStyle('arial12', array('name'=>'Arial', 'size'=>10,'align'=>'both'));



$header = $section->createHeader();
$textrun = $section->addTextRun('p2Style');




$header->addImage('C:\xampp\htdocs\siarcaf\public\images\Logo_UES.jpg', 
array('width'=>75, 'height'=>75, 'align'=>'Left','marginTop' => -1,
'wrappingStyle'=>'square',
       'positioning' => 'absolute',     
       'posVerticalRel' => 'line'));//margen izquierdo


$header->addImage('C:\xampp\htdocs\siarcaf\public\images\agu_web.jpg', 
array('width' => 120,
'height' => 120,
'align'=>'right',
'wrappingStyle' => 'square',
'positioning' => 'relative',
'marginTop' => 0

       ));  //margen derecho



$wrappingStyles = array('inline', 'behind', 'infront', 'square', 'tight');

$header->addText('UNIVERSIDAD DE EL SALVADOR','r2Style', 'p2Style');

$header->addText('ASAMBLEA GENERAL UNIVERSITARIA','r2Style', 'p2Style');



$textrun = $section->addTextRun('arial12');

$textrun->addText('El Infrascrito Secretario de la Junta Directiva de la Asamblea General Universitaria
, de la Universidad de El Salvador (Periodo '.$periodo_nombre.' ) Certifica: ', 
array('name'=>'Arial', 'size'=>10, 'bold'=>true,'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun2 = $section->addTextRun('arial12');

$textrun2->addText('Que en Acta de Sesión Ordinaria de Junta Directiva de la Asamblea General Universitaria ', 
array('name'=>'Arial', 'size'=>10, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun2->addText('Numero ##/JD-AGU'.$periodo_nombre.'.', 
array('name'=>'Arial', 'size'=>10, 'bold'=>true,'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun2->addText('Celebrada el dia '.$agendas->fecha.' Se encuentra el punto '.$puntos_agen->romano.': '.$puntos_agen->descripcion.' En el que consta el Acuerdo numero '.$puntos_agen->numero.': que literalmente dice: ', 
array('name'=>'Arial', 'size'=>10, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun23 = $section->addTextRun('arial12');

$textrun23->addText('Punto '.$puntos_agen->romano.': '.$puntos_agen->descripcion.' numero '.$puntos_agen->numero.' que literalmente dice: ', 
array('name'=>'Arial', 'size'=>10, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun24 = $section->addTextRun('arial12');

$textrun24->addText( $propuestas->nombre_propuesta, 
array('name'=>'Arial', 'size'=>10,'bold'=>true, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun25 = $section->addTextRun('arial12');

$textrun25->addText('La Junta Directiva con base en el Articulo 20 literales b) y s) del Reglamento interno de la Asamblea General Universitaria de la Universidad de El Salvador por'.$propuestas->favor.' Acuerda: ', 
array('name'=>'Arial', 'size'=>10, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));

$textrun26 = $section->addTextRun('arial12');

$textrun26->addText( $propuestas->nombre_propuesta, 
array('name'=>'Arial', 'size'=>10,'bold'=>true, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));


$section->addText('Y para su conocimiento y efectos legales consiguientes, transcribo el presente Acuerdo en la 
    Ciudad Universitaria, San Salvador, ');


$section->addText('Lic. César Alfredo Arias Hernández');
$section->addText('Secretario de la Junta Directiva');
$section->addText('Asamblea General Universitaria');


$footer = $section->createFooter();
//$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'right')); //Saca el numero de paginas del documento y lo agrega en el footer

$footer->addPreserveText('FINAL AVENIDA "Mártires Estudiantes del 30 de julio", Ciudad Universitaria
    Tel. Presidencia 2226-95950, Registro de Asociaciones Estudiantiles 2511-2057, Secretaria de la AGU 2225-7076,
    Unidad Financiera 2511-2022', array('align'=>'center'));


try {
      $objWriter =  \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007'); 
      $objWriter->save('Acuerdo_.docx'); // guarda los archivo en la carpeta public del proyecto

    } catch (Exception $e) {

    }


return response()->download('C:\xampp\htdocs\siarcaf\public\Acuerdo_.docx');


    }









     public function desc_Plantilla_dictamenes($tipo) //https://stackoverflow.com/questions/46202824/how-to-fix-warning-illegal-string-offset-in-laravel-5-4
    {
        
        $parametros = explode('.', $tipo);
        $id_agenda=$parametros[0];
        $id_periodo=$parametros[1];
        $codigo_agenda=$parametros[2];
        $fecha_agenda=$parametros[3];
        $lugar_agenda=$parametros[4];
        
        $periodos=DB::table('periodos')
        ->where('periodos.id','=', $id_periodo)
        ->first();

        $periodo_nombre=$periodos->nombre_periodo; //leido de la base
      

       
$PHPWord = new PHPWord();

$section = $PHPWord->createSection();


$PHPWord->addFontStyle('r2Style', array('bold'=>false, 'italic'=>false, 'size'=>12));
$PHPWord->addParagraphStyle('p2Style', array('align'=>'center'));
$PHPWord->addParagraphStyle('arial12', array('name'=>'Arial', 'size'=>10,'align'=>'both'));



$header = $section->createHeader();
$textrun = $section->addTextRun('p2Style');




$header->addImage('C:\xampp\htdocs\siarcaf\public\images\Logo_UES.jpg', 
array('width'=>75, 'height'=>75, 'align'=>'Left','marginTop' => -1,
'wrappingStyle'=>'square',
       'positioning' => 'absolute',     
       'posVerticalRel' => 'line'));//margen izquierdo


$header->addImage('C:\xampp\htdocs\siarcaf\public\images\agu_web.jpg', 
array('width' => 120,
'height' => 120,
'align'=>'right',
'wrappingStyle' => 'square',
'positioning' => 'relative',
'marginTop' => 0

       ));  //margen derecho



$wrappingStyles = array('inline', 'behind', 'infront', 'square', 'tight');

$header->addText('UNIVERSIDAD DE EL SALVADOR','r2Style', 'p2Style');

$header->addText('ASAMBLEA GENERAL UNIVERSITARIA','r2Style', 'p2Style');





$textrun = $section->addTextRun('arial12');



$textrun1 = $section->addTextRun('p2Style');

$facultad='';






$PHPWord->addNumberingStyle(
    'multilevel',
    array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'upperLetter', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
            array('format' => 'decimal', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720)
        )
    )
);


$textrun3 = $section->addTextRun('arial12');


//dd($id_agenda);
 $puntos=DB::table('puntos')
        ->where('puntos.agenda_id','=',$id_agenda)
        ->where('puntos.retirado','=',0)
         ->orderBy('puntos.romano','asc')
        ->get();
//dd($puntos);

foreach ($puntos as $punto) {
    $section->addListItem($punto->romano.' '.$punto->descripcion, 0, null, 'multilevel');

    $propuestas=DB::table('propuestas')
    ->where('propuestas.punto_id','=',$punto->id)
    ->get();
    foreach ($propuestas as $propuesta) {
    $section->addListItem($propuesta->nombre_propuesta, 1, null, 'multilevel');

    }
    
}


$section->addText('Y para su conocimiento y efectos legales consiguientes, transcribo el presente Acuerdo en la 
    Ciudad Universitaria, San Salvador, '.$fecha_agenda);


$section->addText('Lic. César Alfredo Arias Hernández');
$section->addText('Secretario de la Junta Directiva');
$section->addText('Asamblea General Universitaria');


$footer = $section->createFooter();
//$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'right')); //Saca el numero de paginas del documento y lo agrega en el footer

$footer->addPreserveText('FINAL AVENIDA "Mártires Estudiantes del 30 de julio", Ciudad Universitaria
    Tel. Presidencia 2226-95950, Registro de Asociaciones Estudiantiles 2511-2057, Secretaria de la AGU 2225-7076,
    Unidad Financiera 2511-2022', array('align'=>'center'));




try {
      $objWriter =  \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007'); 
      $objWriter->save('Dictamen_'.$fecha_agenda.'_'. $codigo_agenda.'.docx'); // guarda los archivo en la carpeta public del proyecto

    } catch (Exception $e) {

    }


return response()->download('C:\xampp\htdocs\siarcaf\public\Dictamen_'.$fecha_agenda.'_'. $codigo_agenda.'.docx');


    }


     public function convertirfecha($fecha){

$fecha1conver= explode('/', $fecha);
$fechatrans=$fecha1conver[2].'-'.$fecha1conver[1].'-'.$fecha1conver[0];
$fechainicial = date('Y-m-d', strtotime($fechatrans));

        return $fechainicial;
    }

    public function index()
    {

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
