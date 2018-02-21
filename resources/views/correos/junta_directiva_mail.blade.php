<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
<body>
<pre style="font-family: Arial, Verdana; font-size: 16px;">
Respetables miembros  de la <strong>{!!$comision!!} </strong>

Se les convoca para reunion de <strong>{!!$comision!!} </strong>  el  <strong>{!!$fecha!!} </strong> a las <strong>{!!$hora!!} </strong> en <strong>{!!$lugar!!}</strong>

Se les recuerda que pueden revisar las peticiones actuales  de la Junta Directiva con sus anexos (documentos escaneados)
en el sitio  <a href="http://138.197.73.192/">Enlace a Siarcaf</a>  ingresando con su usuario y clave personal

Observaciones: {!!$mensaje!!}

Atentamente 

{!!$usuario!!}
Mienbro de Asamblea General Universitaria
Mienbro de {!!$comision!!} 
	
</pre>
<img src="{!! $message->embed(public_path().'/images/logo_agu.jpg') !!}" />
</body>
</html>


