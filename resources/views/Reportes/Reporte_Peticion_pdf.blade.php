<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Peticion</title>
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
  text-align: center;
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

</head>
  <body>



  <IMG align="left" SRC="{{ asset('images/Logo_UES.jpg') }}" width="13%" height="10%"/>


  <IMG align="right" SRC="{{ asset('images/agu_web.jpg') }}" width="15%" height="15%" />


 <div id="p" style=" text-align: center;right: 25%;text-transform: uppercase;">
    UNIVERSIDAD DE EL SALVADOR<br/>
    ASAMBLEA GENERAL UNIVERSITARIA<br/>
    CIUDAD UNIVERSITARIA, SAN SALVADOR, EL SALVADOR, C.A.<br/><br/><br/><br/><br/>
  </div>

 <div id="cp1" align="center" >
<table id="g-table" name="g-table" style="text-align: left; position: center; width: 200px;  padding: 5px;" align="center" cellspacing="0" cellpadding="12" border="0" >

 
                    <tr class="espacio">                     
                    <th>CODIGO:</th>  
               
                    <td>
                       {{$peticion->codigo}}
                      </td>
                    </tr>      
                  
                    <tr>         
                    <th>DESCRIPCION:</th>   
                     <td>
                         {{$peticion->descripcion}}
                      </td>
                    </tr>                     

                      <tr>         
                    <th>PETICIONARIO:</th>   
                    
                      <td>{{$peticion->peticionario}}</td>   
                    </tr>    

                       <tr>         
                    <th>FECHA:</th>   
                    
                      <td>{{$peticion->fecha}}</td>   
                    </tr>    

                      <tr>         
                    <th>CORREO:</th>   
                    
                      <td>{{$peticion->correo}}</td>   
                    </tr>    

                     <tr>         
                    <th>TELEFONO:</th>   
                    
                      <td>{{$peticion->telefono}}</td>   
                    </tr>  

                      <tr>         
                    <th>DIRECCION:</th>   
                    
                      <td>{{$peticion->direccion}}</td>   
                    </tr>      

                  
                 </table>
 </div>  


  </body>



</html>





