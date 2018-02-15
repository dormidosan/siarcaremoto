<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
<body>
<pre style="font-family: Arial, Verdana; font-size: 16px;">
Respetables mienbros de la COMISION



Se les recuerda que pueden revisar la agenda  digital de la COMISION con sus anexos (documentos escaneados)
en el sitio  <a href="http://localhost/phpmyadmin">Enlace a Siarcaf</a>  ingresando con su usuario y clave personal

Datos de la proxima sesion
	<stron>Lugar: </stron>{!!$lugar!!}
	<stron>Fecha: </stron>{!!$fecha!!}
	<stron>Hora: </stron>{!!$hora!!}
	<stron>Mensaje: </stron>{!!$mensaje!!}

Atentamente 

Carlos Alberto Noyola Sanchez
Mienbro de Consejo Superior Universitario
	
</pre>
<img src="{!! $message->embed(public_path() . '/images/logo_agu.jpg') !!}" />
</body>
</html>


