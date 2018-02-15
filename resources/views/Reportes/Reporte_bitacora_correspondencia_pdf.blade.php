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
                                               
 <div id="p" style="text-align: center;position: absolute;right: 15%;top: 3%">
    CORRESPONDENCIA RECIBIDA SESIÓN ORDINARIA<br/>DE JUNTA DIRECTIVA DE LA
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    DEL {{$fechainicial}} AL {{$fechafinal}}   
  </div>   
  <hr/>     
</head>
  <body>
 
<div id="nt">
                <table  border="1" cellpadding="0" cellspacing="0" style="text-align: center;">
                   
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No.</th>                     
                    <th>FECHA DE INGRESO</th>                     
                    <th>PROCEDENCIA</th>
                    <th>DESCRIPCION</th>
                    <th>TELEFONO</th>
                    <th>CODIGO</th>
                    <th>RESOLUCION POR J.D</th>
                    <th>RESUELTO</th>
                   
                    </tr>
                  </thead>
                   
                    <tbody>  <!-- CUERPO DE LA TABLA-->
                     @php $i=1 @endphp
                     @foreach($resultados as $result)

                          <tr>                                     
                           <td>{{$i}}</td>
                           <td>{{$result->fecha}}</td>
                           <td>{{$result->peticionario}}</td>
                           <td>{{$result->descripcion}}</td>
                           <td>{{$result->telefono}}</td>   
                           <td>{{$result->codigo}}</td>   
                           <td>{{$result->nombre_estado}}</td>   
                           @if($result->resuelto==1)
                           <td>SI</td> 
                           @ELSE
                           <td>NO</td> 
                           @ENDIF
                         
                          </tr> 
                         
                   @php $i=$i+1 @endphp
                    @endforeach  
                   </tbody>

                </table>
 </div>

  </body>
  <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(650,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
