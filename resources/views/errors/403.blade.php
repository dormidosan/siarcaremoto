@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h3> NO TIENE PERMISOS NECESARIOS PARA ESTA PAGINA</h3>
                    <h5>Para mayor informacion, contactar al Administrador del sistema</h5>
                    <a href="{{ route('inicio') }}"> Volver a la pagina principal</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
