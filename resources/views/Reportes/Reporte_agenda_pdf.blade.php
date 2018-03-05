<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Dieta</title>
  <style type="text/css" media="print">  
  #watermark {
    position: fixed;
    top: 45%;
    width: 100%;
    text-align: center;
    opacity: .4;
    transform: rotate(270deg);
    transform-origin: 50% 50%;
    z-index: -1000;
    
  }
  #centrar{

    position: fixed;
    top: 45%;
    width: 100%;
     text-align: center;
  }

  #p {
  font-family: "ARIAL", serif;
  font-size: 12pt;
  font: bold;
  top: 5%;
}

#mp {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  top: 9%;
}

#nt {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  font: bold;
  top: 40%;
}

#cp {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  top: 20%;
}

#cp1 {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  font: bold;
  top: 25%;
}

#cp2{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
 
  top: 30%;
}

#cp3{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  font: bold;
  top: 35%;
}

#cp4{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  
  top: 40%;
}

#cp5{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  
  top: 50%;
}


#footer{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  font: bold;
  top: 85%;
}

#footer1{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  top: 88%;
}

.page-break {
  page-break-before: always;

}

</style>
                                         


 



                    
</head>
  <body>
           



  <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%">
                         

  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
                                                           
                                                          
 <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    UNIVERSIDAD DE EL SALVADOR<br/>
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    CIUDAD UNIVERSITARIA, SAN SALVADOR, EL SALVADOR, C.A.<br/><br/><br/><br/><br/>
  </div>   

 <div id="nt" style="text-align: left;">
 CONVOCATORIA<br/><br/>
 </div>  
 
<div id="cp" style="text-align: left;">
  Fecha: {{$fecha_generado}} <br/>
 </div>  

 <div id="cp2" style="text-align: left;">
  Para: Señores Miembros de la Asamblea General Universitaria (Gestión: {{$periodo->nombre_periodo}})<br/>
  De: Licda. Josefina Sibrián de Rodríguez -Presidenta<br/>
  Asunto: Convocatoria a Sesión Plenaria para el {{$agenda->fecha}}<br/><br/><br/>
 </div>  

<div id="cp3" style="text-align: left;">
De la manera más atenta se les convoca a Sesión Plenaria de la Asamble General Universitaria No. ##/{{$periodo->nombre_periodo}} que se llevara a cabo el dia  {{$agenda->fecha}}
a la hora  {{$primera_convocatoria}} (Primera convocatoria) y a las hora {{$segunda_convocatoria}} (Segunda convocatoria) en el lugar {{$agenda->lugar}}.<br/><br/><br/>
 </div> 


<div id="cp5" style="text-align: left;">
 Agenda Propuesta.<br/><br/>
 </div> 

 <div id="cp5" style="text-align: left;">
 Verificacón de Cuórum.<br/>
 Informes.<br/>
 Lectura discusión y aprobación de la agenda.<br/>
 </div> 

@foreach($puntos as $punto)
<div id="cp5" style="text-align: left;">
 {{$punto->romano}}     Para conocer y resolver: {{$punto->descripcion}}
 </div> 
@endforeach  
<br/><br/><br/>


<div id="footer" style="text-align: center;">
{{$jefe->primer_nombre}} {{$jefe->segundo_nombre}} {{$jefe->primer_apellido}} {{$jefe->segundo_apellido}}
 </div> 


<div id="footer1" style="text-align: center;">
Presidente/a Asamblea General Universitaria
<br/><br/>
 </div> 


<!--<div id="footer" style="text-align: center;">
NOTA: 
1. Para sesionar en primera convacatoria se necesita cuórum de por lo menos 48 Asambleistas en calidad de propietarios, con base en el Art. 77 de la 
ley Orgánica de la Universidad de El Salvador, por lo que se les solicita puntualidad.<br/>
2. Se propone al pleno que cuando se llegue el momento de abordar la sesión No. ##/periodo se suspenda temporalmente la Sesión No. ##/periodo
para continuar conociendo de ésta luego de haber abordado la No. ##/periodo


 </div> -->




  </body>



</html>





