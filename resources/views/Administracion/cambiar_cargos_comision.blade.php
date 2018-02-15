@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset("libs/pretty-checkbox/pretty-checkbox.min.css") }}">
    <link href="{{ asset("libs/MaterialDesign/css/materialdesignicons.css") }}" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">

    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }

        table.dataTable thead > tr > th {
            padding-right: 0 !important;
        }

    </style>
@endsection


@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a>Gestionar Usuarios</a></li>
            <li><a href="{{ route("administracion_usuario") }}">Administracion Usuarios</a></li>
            <li><a class="active">Cargos Comision</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Cambiar Cargos Comision</h3>
        </div>
        <div class="box-body">
            <!-- form que se mostrara oculto y es para almacenar el id de la comision-->
            <form class="form hidden" id="comision">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12 col-lg-12 text-center">
                        <div class="form-group">
                            <label for="idComision">Comision</label>
                            <input type="text" class="form-control" id="idComision">
                        </div>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-sm-12 text-center">
                        <label>Seleccione la comision a la que desea actualizar</label><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-sm-12">
                        <select class="form-control col-sm-12" id="listadoComisiones"
                                name="listadoComisiones"
                                onchange="mostrar_asambleistas(this.value)">
                            <option value="" selected>-- Seleccione una opcion --</option>
                            @foreach($comisiones as $comision)
                                <option value="{{$comision->id}}">{{ $comision->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <div id="tabla"></div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">

        function mostrar_asambleistas(idComision) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('mostrar_asambleistas_comision_post') }}",
                data: {
                    "idComision": idComision
                }
            }).done(function (response) {
                $("#idComision").val(response.comision);
                $("#tabla").html(response.tabla);
                inicializar_dataTable();
            });
        }

        function inicializar_dataTable() {
            var oTable = $('#tabla_miembros').DataTable({
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
                columnDefs: [{orderable: false, targets: [2, 3]}],
                order: [[0, 'asc']]


            });
        }

        function actualizar_coordinador(idAsambleista) {
            var idComision = $("#idComision").val();
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_coordinador') }}",
                data: {
                    "idComision": idComision,
                    "idAsambleista":idAsambleista
                }
            }).done(function (response) {
                notificacion(response.mensaje.titulo,response.mensaje.contenido,response.mensaje.tipo);
                $("#tabla").html(response.tabla);
                inicializar_dataTable();
            });
        }

        function actualizar_secretario(idAsambleista) {
            var idComision = $("#idComision").val();
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_secretario') }}",
                data: {
                    "idComision": idComision,
                    "idAsambleista":idAsambleista
                }
            }).done(function (response) {
                notificacion(response.mensaje.titulo,response.mensaje.contenido,response.mensaje.tipo);
                $("#tabla").html(response.tabla);
                inicializar_dataTable();
            });
        }

    </script>
@endsection