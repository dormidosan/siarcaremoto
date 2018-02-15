<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Dieta</title>
  <style type="text/css">  
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
                                                  
                                               
 <div id="p" style="text-align: center;position: absolute;right: 25%;top: 3%">
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    RENTA DE DIETAS DEL SECTOR DOCENTE PERIODO 2015-2017<br/>
    DIETAS DEL MES DE DICIEMBRE DE 2016:V
    <hr  />  
  </div>   
                   
</head>
  <body>
 
<div id="cp">
                <table  border="1" cellpadding="0" cellspacing="0" style="text-align: center;">
                   
                  <thead>  <!-- ENCABEZADO TABLA-->
                    <tr>                     
                    <th>No. </th>                      
                    <th>SECTOR</th>                     
                    <th>NOMBRE</th>
                    <th>AFP-INPEP</th>
                    <th>SUELDO</th>
                    <th>AFP O INPEP</th>
                    <th>RENTA</th>

                    <th>BONO</th>
                    <th>SUELDO + BONO</th>
                    <th>RENTA A BONO</th>
                    <th>DIETAS</th>
                    <th>SALDO + BON EXTAS</th>
                    <th>RENTA DIETAS</th>                      
                    </tr>
                  </thead>

                    <tbody>  <!-- CUERPO DE LA TABLA-->
                    <tr>                                     
                      <td>1</td>
                      <td>DOCENTE</td>
                      <td>JUAN CARLOS CURZ CUBIAS</td>
                    
                      <td>CONFIA </td>
                    
                      <td>1600</td>
                      <td>100</td>
                      <td>176.84</td>
                      
                      <td>0.00</td>
                      <td>1600</td>
                      <td>0.00</td>
                      <td>34.32</td>
                      <td>1634.32</td>
                      <td>6.86</td>
                    </tr> 
                     
                   </tbody>

                </table>
 </div>

  </body>
   <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(510,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
