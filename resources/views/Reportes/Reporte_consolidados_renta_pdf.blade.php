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
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    CUADRO DE RETENCION DE RENTA <br/>POR EL PAGO DE DIETAS DEL SECTOR PROFESIONAL {{$sector}}<br/>
    REPORTE CORRESPONDIENTE AL MES DE {{$mes}} DEL AÑO {{$anio}}

     
  </div>   
                   
</head>
  <body>
 
<div id="cp">
                <table  border="1" cellpadding="0" cellspacing="0" style="text-align: center;">
                   
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                     
                                 
                    <th>NOMBRES</th>
                    <th>FACULTAD</th>
                    <th>No DE NIT</th>
                    <th>TOTAL DEVENGADO</th>
                    <th>DESCUENTO RENTA</th>
                    <th>LIQUIDO A PAGAR</th>
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
                        {{$result->primer_nombre}} {{$result->segundo_apellido}}
                      </td>
                      <td>{{$result->nom_fact}}</td>
                    
                      <td>{{$result->nit}}</td>
                    
                      <td>$ {{$result->asistencia*$monto_dieta->valor}} </td>
                      <td>$ {{round($result->asistencia*$monto_dieta->valor*$renta->valor,2)}} </td>
                      <td>$ {{round($result->asistencia*$monto_dieta->valor-$result->asistencia*$monto_dieta->valor*$renta->valor,2)}}</td>
                      
                    </tr> 
                 @php $i=$i+1;
                      $total1=$total1+$result->asistencia*$monto_dieta->valor;
                      $total2=$total2+round($result->asistencia*$monto_dieta->valor*$renta->valor,2);

                  @endphp
                @endforeach 
                @php
                $total3=$total1-$total2;
                @endphp  
                    <tr>                                     
                      <td>
                        
                      </td>
                      
                      <td>
                        
                      </td>
                      <td></td>
                    
                     
                      <td>TOTAL </td>
                      <td>$ {{$total1}} </td>
                      <td>$ {{$total2}} </td>
                      <td>$ {{$total3}} </td>
                      
                    </tr>

                   </tbody>

                </table>
 </div>

  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(700,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
