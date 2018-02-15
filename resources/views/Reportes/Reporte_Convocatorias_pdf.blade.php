<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Permisos Temporales</title>
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
font-family: "ARIAL", serif;
  font-size: 12pt;
  font: bold;
  top: 10%;
  text-align: right;
  aling-items: right;
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
  top: 15%;
  text-align: left;
  aling-items: left;
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

#cp6{
  position: fixed;
  font-family: "ARIAL", serif;
  font-size: 10pt;
  
  top: 70%;
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
        
<div style="position:fixed;" align="right">
  <IMG SRC="{{ asset('images/agu_web.jpg') }}" width="25%" height="25%" >
</div>

<div style="position:fixed;" align="left">
  <IMG SRC="{{ asset('images/Logo_UES.jpg') }}" width="130" height="130" >
</div>                                   
                                               
 <div id="p" style="position:fixed;text-align: center;">
    Convocatoria<br/>
    <br/>   
  </div>   
  <div id="mp" >
    Fecha: ____________<br/>
    <br/>
     
  </div> 
                   
</head>
  <body>
  <div id="cp" >
    PARA: ________________________________________________<br/>

    DE: _________________________________________________<br/>

    ASUNTO: _______________________________________________
    <hr/>
  </div> 

 <div id="cp1" >
    CUERPO DEL MENSAJE

  </div> 

 <div id="cp2" >
    AGENDA PROPUESTAS:<br/>
    1.<br/>
    2.<br/>
    3.<br/>

  </div> 
<div id="cp6" >
    "HACIA LA LIBERTAD POR LA CULTURA"
  </div>

<div id="footer" >
  ING. AGR. NELSON BERNABÉ GRANADOS ALVARADO<br/>
  PRESIDENTE<br/>
  ASAMBLEA GENERAL UNIVERSITARIA<br/>
  </div>

  </body>
  <script type="text/php">
    if ( isset($pdf) ) {
        $font = $fontMetrics->getFont("arial", "bold");
        $pdf->page_text(510,15, "Pagina: {PAGE_NUM}/{PAGE_COUNT}", $font, 15, array(0,0,0));
    }
</script>
</html>
