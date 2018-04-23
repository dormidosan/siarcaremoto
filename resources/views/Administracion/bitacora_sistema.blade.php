@extends('layouts.app')

@section("styles")
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }


    </style>
@endsection


@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li class="active">Bitacora del Sistema</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Consulta Bitacora</h3>
        </div>
        <div class="box-body">

            <form id="consultar_bitacora" action="{{ route('consultar_bitacora')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group ">
                            <label>Usuario</label>
                            <select id="usuario" name="usuario" class="form-control">
                                <option value="">-- Seleccione un usuario --</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{ $usuario->persona->primer_nombre . ' ' .$usuario->persona->segundo_nombre . ' ' . $usuario->persona->primer_apellido . ' ' . $usuario->persona->segundo_apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="fecha">Accion</label>
                            <input type="text" id="accion" name="accion" class="form-control">
                            <span id="helpBlock" class="help-block">Ingrese una palabra de una URL del sistema</span>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <div class="input-group date fecha">
                                <input name="fecha" id="fecha" type="text" class="form-control"><span
                                        class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="buscar" name="buscar" class="btn btn-primary">Consultar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div>
        <div class="box-body table-responsive">
            <table id="tabla"
                   class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>Nº</th>
                    <th>Usuario</th>
                    <th>Accion</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Comentario</th>
                </tr>
                </thead>

                @php $contador = 1 @endphp
                <tbody id="cuerpoTabla">
                @if($bitacora->isEmpty() == false)
                    @foreach($bitacora as $var)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $var->user->persona->primer_nombre . ' '. $var->user->persona->segundo_nombre . ' ' . $var->user->persona->primer_apellido . ' ' . $var->user->persona->segundo_apellido }}</td>
                            <td>{{ $var->accion }}</td>
                            <td>{{ $var->fecha }}</td>
                            <td>{{ $var->hora }}</td>
                            <td>{{ $var->comentario }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>


@endsection

@section("js")
    <!-- Datatables -->
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('#usuario').select2({
                placeholder: 'Seleccione usuario',
                language: "es",
                width: '100%'
            });

            $('.input-group.date.fecha').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });

            $('#hora').datetimepicker({
                format: 'h:mm:ss A',
            });

            var oTable = $('#tabla').DataTable({
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                responsive: true,
                columnDefs: [{orderable: false, targets: [ 1, 2, 3, 4, 5]}],


            });
        });
    </script>

@endsection

@section("lobibox")
    @if(Session::has('error'))
        <script>
            notificacion("Error", "{{ Session::get('error') }}", "error");
            {{ Session::forget('error') }}
        </script>
    @elseif(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
@endsection