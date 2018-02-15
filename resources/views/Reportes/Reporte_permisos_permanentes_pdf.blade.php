<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Permisos Temporales</title>
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
  text-align: center;
  aling-items: center;
}

#mp {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  top: 12%;
}

#nt {
  
  font-family: "ARIAL", serif;
  font-size: 10pt;
  
  top: 30%;
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


</style>
  
  <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%">
                         

  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
                                                                        
                                               
  <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    Sesión Plenaria de Asamblea General Universitaria {{$fechainicial}} AL {{$fechafinal}}<br/>
    Solicitudes de PERMISOS DEFINITIVOS<br/><br/><br/><br/>
     
  </div>   
                   
</head>
  <body>
 
 <table style="text-align: center; position: center;" align="center" border="1" cellpadding="0" cellspacing="0" >   
                   
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>Nombre del solicitante</th>                     
                                       
                    <th>Motivo del permiso</th>
                    <th>Fecha de permiso</th>
                    <th>Inicio</th>
                    <th>Finalización</th>
                   
                    </tr>
                  </thead>

                    <tbody>  <!-- CUERPO DE LA TABLA-->
 @foreach($resultados as $result)
                          <tr>                                     
                           <td><pre>
Asambleista: {{$result->primer_nombre}} {{$result->primer_apellido}} <br/>
Delego a: {{$result->delegado}}</pre></td>
                          
                           <td><pre>{{$result->motivo}}</pre></td>
                           <td><pre>{{substr($result->fecha_permiso, 0, 10)}}</pre></td>
                           <td><pre>{{$result->inicio}}</pre></td>
                           <td><pre>{{$result->fin}}</pre></td>      
                          </tr> 
  @endforeach                                                
                   </tbody>

                </table>


  </body>
</html>



  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(510,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
