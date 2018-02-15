@extends('layouts.app')

@section("styles")
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a>Gestionar Usuarios</a></li>
            <li><a class="active">Gestionar Perfiles</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Gestionar Perfiles</h3>
        </div>
        <div class="box-body">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Agregar Perfil</h3>
                </div>
                <div class="panel-body">
                    <form id="agregar_perfil" name="agregar_perfil" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="perfil" class="col-sm-2 control-label">Nuevo perfil</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="perfil" name="perfil" placeholder="Ingrese nuevo perfil"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="button" id="btn_agregar_perfil" class="btn btn-success" onclick="AgregarPerfil()">Agregar Perfil</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Perfiles del Sistema</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>Perfil</th>
                            <th>Administrar Modulos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($perfiles as $perfil)
                            <tr>
                                <td>{{ucfirst($perfil->nombre_rol)}}</td>
                                <td>
                                    <form id="acceder" name="acceder" class="form" action="{{ route("administrar_acceso_modulos") }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-control hidden">
                                            <label>ID</label>
                                            <input type="text" id="id_rol" name="id_rol" value="{{$perfil->id}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-external-link-square"
                                                                                                aria-hidden="true"></i> Acceder</button>
                                    </form>
                                </td>
                                {{-- <td><a href="#" class="btn btn-primary btn-xs"><i class="fa fa-external-link-square"
                                                                                  aria-hidden="true"></i> Acceder</a>
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">

        $(function () {
            $('#agregar_perfil').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    perfil: {
                        validators: {
                            notEmpty: {
                                message: 'Ingrese un perfil, por favor.'
                            }
                        }
                    }
                }
            });
        });


        function AgregarPerfil() {
            //Valida el form manualmente
            $('#agregar_perfil').formValidation('validate');
            if ($('#agregar_perfil').data('formValidation').isValid()) {
                var form = $('#agregar_perfil').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("agregar_perfiles") }}',
                    data: form
                }).done(function (response) {
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                    setTimeout(function () {
                        window.location.href = '{{ route("gestionar_perfiles") }}';
                    },1000);
                })
            } else {
                notificacion('Error', 'Por favor proporciones la informacion solicitada', 'error');
            }
        }

    </script>
@endsection