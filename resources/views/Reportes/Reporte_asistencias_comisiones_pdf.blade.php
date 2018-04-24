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

    #g-table tbody tr > td{
                    border: 1px solid rgb(220,220,220);
                    height: 30px;
                    padding-left: 3px;
                }
                #g-table{
                    padding-left: 40px;
                    margin-top: 20px;

                }
                .espacio{
          height:10px;
        }

</style>
                                         

  <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%"/>


  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" />


 <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    UNIVERSIDAD DE EL SALVADOR<br/>
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    CIUDAD UNIVERSITARIA, SAN SALVADOR, EL SALVADOR, C.A.<br/>
    ASISTENCIAS {{$reuniones->lugar}} CONVOCADO EL {{$reuniones->convocatoria}}<br/>
    {{$comision->nombre}} <br/><br/><br/>
  </div>

</head>
  <body>
 
 <div id="cp1"  >
  <table id="g-table" name="g-table" style="text-align: left; position: center; width: 200px;  padding: 5px;" align="center" border="1" cellpadding="10" cellspacing="0">                 
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                     
                    <th>PROPIETARIO Ó <br/>SUPLENTE</th>                     
                    <th>NOMBRES</th>
                    <th>FACULTAD</th>
                   
                  
                   
                   
                    </tr>
                  </thead>
                    <tbody>  <!-- CUERPO DE LA TABLA-->
                    @php $i=1 @endphp
                     @foreach($resultados as $result)
                       <tr>                                     
                      <td>
                       {{$i}}
                      </td>
                      @if($result->propietario==1)
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
        $pdf->page_text(500,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
