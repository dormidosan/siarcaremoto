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
           

@foreach($busqueda as $busque)

  <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%">
                         

  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" >
                                                           
                                                          
 <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    UNIVERSIDAD DE EL SALVADOR<br/>
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    CIUDAD UNIVERSITARIA, SAN SALVADOR, EL SALVADOR, C.A.<br/><br/><br/><br/><br/>
  </div>   

 <div id="nt" style="text-align: left;">
 NIT INSTITUCIONAL: 0614-110121-001-3<br/><br/>
 </div>  
 
<div id="cp" style="text-align: left;">
El infrascrito agente de retención, hace constar  que los  ingresos devengados por el Sr(a): <br/><br/><br/>
 </div>  

<div id="cp1" style="text-align: left;">
NIT No. {{$busque->nit}}<br/>
NOMBRE:    {{$busque->primer_nombre}}
           {{$busque->segundo_nombre}}
           {{$busque->primer_apellido}}
           {{$busque->segundo_apellido}}<br/><br/>
 </div>  

 <div id="cp2" style="text-align: left;">
Por el pago de dietas de Junta Directiva de la AGU. del año {{$anio}}. son los que se desglosan de la siguiente manera.<br/><br/><br/><br/>
 </div>  

<div id="cp3" style="text-align: left;">
  TOTAL DEVENGADO:
 </div> 

<div id="cp4" style="text-align: left;">
  <pre style=" font-family: "ARIAL", serif;  font-size: 10pt;">Ingresos Grabados                                 $        {{$busque->dieta}}<pre/> <br/>
  <pre style=" font-family: "ARIAL", serif;  font-size: 10pt;">Impuestos sobre la renta retenido          $        {{$busque->renta}}<pre/><br/><br/><br/><br/><br/><br/><br/><br/>
 </div> 

<div id="cp5" style="text-align: left;">
 Y para los efectos de su declaración de impuestos sobre la Renta, se extiende la presente a los veintiséis días del mes de mayo de dos mil diecisiete.
 </div> 

<div id="footer" style="text-align: center;">
Licda. Josefina Sibrián de Rodríguez
 </div> 

<div id="footer1" style="text-align: center;">
Presidenta Asamblea General Universitaria
 </div> 




<div style="page-break-before: always;"></div>
@endforeach   
  

  </body>



</html>





