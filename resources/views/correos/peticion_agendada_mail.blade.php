<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
<body>
<pre style="font-family: Arial, Verdana; font-size: 16px;">
Peticion para Asamblea General Universitaria  con el codigo de peticion : <strong>{!!$peticion->codigo!!} </strong> ha sido agendada para la sesion plenaria <strong>{!!$agenda->codigo!!} </strong> 

Se le informa que la peticion ha sido agendada para el  <strong>{{ \Carbon\Carbon::parse($agenda->inicio)->format('d-m-Y') }} </strong> a las <strong>{{ \Carbon\Carbon::parse($agenda->inicio)->format('h:i A') }} </strong> 

Se les recuerda que pueden revisar las peticion y llevar el seguimiento 
en el sitio  <a href="http://138.197.73.192/peticiones/monitoreo_peticion">Enlace a Siarcaf</a>  utilizando el codigo de la peticion proporcionado


Correo generado automaticamente por SIARCA 
Sistema Informático para el Apoyo de Reuniones y Control de Acuerdos de la Asamblea General Universitaria de la Universidad de El Salvador 
	
	
	
</pre>
<img src="{!! $message->embed(public_path().'/images/logo_agu.jpg') !!}" />
</body>
</html>


