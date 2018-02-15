<!DOCTYPE html>
<html lang="en">
  <head>
    

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nombre del reporte</title>
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
}

</style>
<?php
     
     echo "
  <table border = 1 cellspacing = 1 cellpadding = 1>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Edad</th>
      <th>$invoice</th>
    </tr>

 $invoice 
    ";



     ?>

<div >
  <IMG SRC="{{ asset('images/agu_web.jpg') }}" width="25%" height="25%" style="position:absolute;">
</div>

                            
                          
 <div id="p" style="position:relative;left: 250px; top:1%">
 
    UNIVERSIDAD DE EL SALVADOR<br/>
  
  
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
  
  PERMISOS TEMPORALES PARA<br/>ASAMBLEISTAS EN SESIONES PLENARIAS


  </div>
                            


</head>
  <body>
  <div id="watermark">
    <h1>
    SOLO PARA FINES INFORMATIVOS
  </h1>
  </div>

<div id="centrar" >



  


                  <table  border="1" cellpadding="0" cellspacing="0">
                   
                    <thead><tr>
                      
                      <th>Nombre </th>
                      
                      <th>Fecha</th>
                      
                      <th>Ver</th>
                      <th>Descargar</th>
                    </tr></thead>
                    <tbody>
                    <tr>                                     
                      <td>
                        Nombre permiso
                      </td>
                      <td>fecha</td>
                    
                      <td><a href="{{url("/Reporte_planilla_dieta/1")}}" class="btn btn-block btn-success btn-xs" >VER</a></td>
                      <td><a href="{{url("/Reporte_planilla_dieta/2")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a></td>
                    
                    </tr>
                   
                  </tbody></table>
                </div><!-- /.box-body -->

  <!--<div id="centrar">
   TEXTO FRENTE A MARCA DE AGUA 
  </div>
    <main>
      <div id="details" class="clearfix">
        <div id="invoice">
          <h1>INVOICE {{ $invoice }}</h1>
          <div class="date">Date of Invoice: {{ $date }}</div>
        </div>
      </div>
      <table id="asd" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">{{ $data['quantity'] }}</td>
            <td class="desc">{{ $data['description'] }}</td>
            <td class="unit">{{ $data['price'] }}</td>
            <td class="total">{{ $data['total'] }} </td>
          </tr>
 
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td >TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table>-->
  </body>
</html>
