<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>


    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <h3> Error 405</h3>
                    <h5>Error en la pagina a la que trata de acceder </h5>
                    <h5>Intente ingresando desde la pagina anterior, o desde el menu lateral de opciones</h5>
                    <h5>Para mayor informacion, contactar al Administrador del sistema</h5>
                    <a href="{{ route('inicio') }}"> Volver a la pagina principal</a>
                    <br>
                    <img src="{{asset('images/404-vector.jpg')}}">
                </div>
            </div>
        </div>
    </body>
</html>
