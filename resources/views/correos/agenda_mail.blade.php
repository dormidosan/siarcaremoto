<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento</title>
</head>
<body>
<pre style="font-family: Arial, Verdana; font-size: 16px;">
Respetables miembros  de la Asamblea General Universitaria

Se les convoca para Sesion plenaria  <strong>{!!$agenda->codigo!!} </strong>  el  <strong>{!!$fecha!!} </strong> a las <strong>{!!$hora!!} </strong> primera convocatoria y <strong>{!!$hora2!!} </strong> segunda convocatoria en <strong>{!!$lugar!!}</strong>

Se les recuerda que pueden revisar las peticiones actuales  de la Junta Directiva con sus anexos (documentos escaneados)
en el sitio  <a href="http://138.197.73.192/">Enlace a Siarcaf</a>  ingresando con su usuario y clave personal

Observaciones: {!!$mensaje!!}

Listado de puntos:
@forelse($agenda->puntos as $punto)
{!!$punto->romano !!} - {!!$punto->descripcion !!}
@empty
@endforelse


Atentamente 

{!!$usuario!!}
Mienbro de Asamblea General Universitaria
	
</pre>
<img src="{!! $message->embed(public_path().'/images/logo_agu.jpg') !!}" />
</body>
</html>


