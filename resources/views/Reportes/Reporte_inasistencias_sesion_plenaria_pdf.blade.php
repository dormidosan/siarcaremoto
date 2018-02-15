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

kk

 <main>
      <div id="details" class="clearfix">

<table>
  <tr>
    <th scope="col">Nombre producto</th>
    <th scope="col">Precio unitario</th>
    <th scope="col">Unidades</th>
    <th scope="col">Subtotal</th>
  </tr>
 
  <tr>
    <td>Reproductor MP3 (80 GB)</td>
    <td>192.02</td>
    <td>1</td>
    <td>192.02</td>
  </tr>
 
  <tr>
    <td>Fundas de colores</td>
    <td>2.50</td>
    <td>5</td>
    <td>12.50</td>
  </tr>
 
  <tr>
    <td>Reproductor de radio &amp; control remoto</td>
    <td>12.99</td>
    <td>1</td>
    <td>12.99</td>
  </tr>
 
  <tr>
    <th scope="row">TOTAL</th>
    <td>-</td>
    <td>7</td>
    <td><strong>207.51</strong></td>
  </tr>
</table>



  </div>





















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
