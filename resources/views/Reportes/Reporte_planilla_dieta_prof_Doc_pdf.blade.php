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

     <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%">
                         

  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
                                                                        
                                               
  <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    MANDAMIENTO DE PAGOS DE DIETAS SECTOR DOCENTE<br/>
    CORRESPONDIENTE AL MES DE {{$mes}} {{$anio}}<br/><br/><br/><br/>
     
  </div>   
    
                   
</head>
  <body>
              
               
               
 <table style="text-align: center; position: center;" align="center" border="1" cellpadding="0" cellspacing="0" >              
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                     
                    <th>SECTOR</th>                     
                    <th>NOMBRES</th>
                    <th>FACULTAD</th>
                    
                    <th>TOTAL</th>
                    </tr>
                  </thead>
                    <tbody>  <!-- CUERPO DE LA TABLA-->
                    @php $i=1;$total=0 @endphp
                    
                     @foreach($resultados as $result)
                       
                       <tr>                                     
                      <td>
                       {{$i}}
                      </td>
                      <td>
                         PROF. DOCENTE
                      </td>
                      <td>{{$result->primer_nombre}} {{$result->segundo_apellido}}</td>                   
                      <td>{{$result->nom_fact}} </td>
                      
                      <td>$ {{$result->asistencia*$monto_dieta->valor}}</td>                      
                    </tr>                 
                       @php $i=$i+1;
                       $total=$total+$result->asistencia*$monto_dieta->valor
                       @endphp
   @endforeach          
    <tr>                                     
                      <td>                       
                      </td>
                      <td>                      
                      </td>
                      <td></td>                  
                      <td>TOTAL:</td>
                         
                      <td>$ {{$total}} </td>                
                    </tr>

                   </tbody>

                 </table>
   

  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(510,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
