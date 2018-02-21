<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
<body>
<pre style="font-family: Arial, Verdana; font-size: 16px;">
Peticion para Asamblea General Universitaria creada 
Codigo de peticion : <strong>{!!$peticion->codigo!!} </strong>

Se le informa que la peticion fue creada   el  <strong>{{ \Carbon\Carbon::parse($peticion->fecha)->format('d-m-Y') }} </strong> a las <strong>{{ \Carbon\Carbon::parse($peticion->fecha)->format('h:i A') }} </strong> 

Se les recuerda que pueden revisar las peticion y llevar el seguimiento 
en el sitio  <a href="http://138.197.73.192/peticiones/monitoreo_peticion">Enlace a Siarcaf</a>  utilizando el codigo de la peticion proporcionado


Correo generado automaticamente por SIARCA 
Sistema Informático para el Apoyo de Reuniones y Control de Acuerdos de la Asamblea General Universitaria de la Universidad de El Salvador 
	
</pre>
<img src="{!! $message->embed(public_path().'/images/logo_agu.jpg') !!}" />
</body>
</html>


