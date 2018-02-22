<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>


    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <h3> Pagina no encontrada</h3>
                    <h5>La pagina solicitada no existe </h5>
                    <h5>Verifique que la URL sea correcta o se haya ingresado desde el menu correspondiente</h5>
                    <h5>Para mayor informacion, contactar al Administrador del sistema</h5>
                    <a href="{{ route('inicio') }}"> Volver a la pagina principal</a>
                    <br>
                    <img src="{{asset('images/404-vector.jpg')}}">
                </div>
            </div>
        </div>
    </body>
</html>
