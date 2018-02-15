<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nombre del reporte</title>
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
  top: 9%;
}

#nt {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  font: bold;
  top: 15%;
}

#cp {
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  top: 30%;
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
                                         

<div style="position: absolute;"  align="left">
  <IMG SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%" >
</div>                                  
 <div  align="right">
  <IMG SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
</div>

                            
                          
 <div id="p" style="text-align: center;position: absolute;right: 20%;top: 5%"  >
    UNIVERSIDAD DE EL SALVADOR<br/> 
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
  ASISTENCIAS PARA ASAMBLEISTAS EN SESIONES PLENARIAS PERIODO {{$nombreperiodo}} <br/>
  SECTOR {{$sector}}
  </div>
                            


</head>
  <body>
 
  <table id="cp"  border="1" cellpadding="0" cellspacing="0" style="text-align: center;">                 
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                     
                    <th>PROPIETARIO Ó <br/>SUPLENTE</th>                     
                    <th>NOMBRES</th>
                    <th>FACULTAD</th>
                   
                  
                    <th>Hora entrada</th>
                    <th>ESPACIO RESERVADO PARA SECRETARIO AGU</th>
                    </tr>
                  </thead>
                    <tbody>  <!-- CUERPO DE LA TABLA-->
                    @php $i=1 @endphp
                     @foreach($resultados as $result)
                       <tr>                                     
                      <td>
                       {{$i}}
                      </td>
                      @if($result->propietaria==1)
                      <td>
                         PROPIETARIO
                      </td>
                      @else
                      <td>
                         SUPLENTE
                      </td>                      
                      @endif
                      <td>{{$result->primer_nombre}} {{$result->primer_apellido}}</td>                   
                      <td>{{$result->nombre}}</td>
                     
                           
                      <td> {{$result->entrada}} </td>
                      <td>  </td>                 
                    </tr>                 
                       @php $i=$i+1 @endphp
   @endforeach          
 
                   </tbody>

                </table>       
 





  
  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(700,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
