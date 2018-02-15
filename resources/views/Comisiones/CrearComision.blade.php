@extends('layouts.app')

@section("styles")
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/toogle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Comisiones</a></li>
            <li><a class="active">Crear Comision</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Crear Comision</h3>
        </div>
        <div class="box-body">

            <form id="crearComision" action="{{ route("crear_comision") }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
                            <label>Nombre Comision <span class="text-red text-bold">*</span></label>
                            <input type="text" class="form-control" placeholder="Ingrese un nombre" id="nombre"
                                   name="nombre" value="{{old(" nombre ")}}" required>
                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-lg-6">
                        <div class="form-group ">
                            <label>codigo Comision <span class="text-red text-bold">*</span></label>
                            <input type="text" class="form-control" placeholder="Ingrese un codigo" id="codigo"
                                   name="codigo" required>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="crear" name="crear" class="btn btn-primary">
                            Crear Comision
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Listado Comisiones</h3>
        </div>
        <div class="box-body table-responsive">
            <table id="listadoComisiones"
                   class="table table-striped table-bordered table-condensed table-hover dataTable text-center">
                <thead class="text-bold">
                <tr>
                    <th>Codigo</th>
                    <th>Nombre de Comisión</th>
                    <th>Permanente</th>
                    <th>Integrantes</th>
                    <th>Estado</th>
                    <th>Fecha Creacion</th>
                    <th>Fecha Ultimo Acceso</th>
                </tr>
                </thead>

                <tbody id="cuerpoTabla">
                @foreach($comisiones as $comision)
                    <tr>
                        <td>{{ $comision->codigo }}</td>
                        <td>{{ $comision->nombre }}</td>

                        <td>
                            @if($comision->permanente == 1)
                                <i class="fa fa-check text-success text-bold" aria-hidden="true"></i> @endif
                        </td>

                        @php $contador = 0 @endphp
                        @foreach($cargos as $cargo)
                            {{-- obtener total de asambleistas en el periodo activo--}}
                            @if($cargo->comision_id == $comision->id && $cargo->activo == 1 && $cargo->asambleista->periodo->activo == 1)
                                @php $contador++ @endphp
                            @endif
                        @endforeach
                        <td>
                            {{ $contador }}
                        </td>
                        <td>
                            @if($comision->permanente == 0) @if($comision->activa == 1)
                                <input type="checkbox" name="estado" class="toogle" data-size="mini"
                                       onchange="cambiar_estado_comision({{ $comision->id }})" checked>
                                </i>
                            @else
                                <input type="checkbox" name="estado" class="toogle" data-size="mini"
                                       onchange="cambiar_estado_comision({{ $comision->id }})">
                                </i>
                            @endif @endif
                        </td>
                        @if($comision->created_at)
                            <td>{{ date_format($comision->created_at,"d/m/Y h:i A") }}</td>
                        @endif @if($comision->updated_at)
                            <td>{{ date_format($comision->updated_at,"d/m/Y h:i A") }}</td>
                        @endif

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/toogle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {

            $('.toogle').bootstrapToggle({
                on: 'Activa',
                off: 'Inactiva',
                onstyle: 'success',
                offstyle: 'danger'
            });

            $('#crearComision').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nombre: {
                        validators: {
                            notEmpty: {
                                message: 'Ingrese un nombre para la comision.'
                            }
                        }
                    },
                    codigo: {
                        validators: {
                            notEmpty: {
                                message: 'Ingrese un codigo para la comision'
                            }
                        }
                    }
                }
            });
        });

        function cambiar_estado_comision(id) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_comision') }}",
                data: {
                    "id": id
                },
                success: function (response) {
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                }
            });
        }
    </script>

@endsection @section("lobibox") @if(Session::has('success'))
    <script>
        notificacion("Exito", "{{ Session::get('success') }}", "success");
    </script>
@endif @endsection