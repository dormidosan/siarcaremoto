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
                                         
     <div style="position: absolute;"  align="left">
  <IMG SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%" >
</div>                                  
 <div  align="right">
  <IMG SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
</div>                                                                
                                                          
 <div id="p" style="text-align: center;position: absolute;right: 25%;top: 3%; text-transform: uppercase;">
    UNIVERSIDAD DE EL SALVADOR<br/>
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    ASAMBLEISTAS  QUE PARTICIPARON EN EL PERIODO {{$nombre_periodos->nombre_periodo}}<br/>
    

     
  </div>   
                   
</head>
  <body>
 

                <table style="text-align: center; position: center;" align="center"  border="1" cellpadding="0" cellspacing="0" style="text-align: center;">
                   
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                     
                                 
                    <th>NOMBRES</th>
                    <th>FACULTAD</th>
                    <th>NIT</th>
                    <th>DUI</th>
                    <th>PROPIETARIO</th>
                    <th>CORREO</th>
                    </tr>
                  </thead>

                    <tbody>  <!-- CUERPO DE LA TABLA-->

                    @php $i=1;$total1=0;$total2=0;$total3=0 @endphp
                     @foreach($resultados as $result)

                    <tr>                                     
                      <td>
                        {{$i}}
                      </td>
                      
                      <td>
                        {{$result->primer_nombre}} {{$result->segundo_nombre}} {{$result->primer_apellido}} {{$result->segundo_apellido}}
                      </td>
                      <td>{{$result->NomFac}}</td>
                    
                      <td>{{$result->nit}}</td>
                    
                      <td>{{$result->dui}}</td>

                       @if($result->propietario==1)
                      <td>
                         PROPIETARIO
                      </td>
                      @else
                      <td>
                         SUPLENTE
                      </td>                      
                      @endif

                      <td>{{$result->email}}</td>
                      
                    </tr> 
                 @php $i=$i+1;
                  @endphp
                @endforeach 
                
                    

                   </tbody>

                </table>


  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(250,250, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
