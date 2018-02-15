@extends('layouts.app')

@section("styles")
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
            <li><a class="active">Cargos Cargos Junta Directiva</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Cambiar Cargos de Junta Directiva</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id='tabla_miembros_jd' class='table table-striped table-bordered table-condensed table-hover dataTable text-center'>
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cargo Actual</th>
                        <th>Nuevo Cargo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($miembros_jd as $miembro)
                        <tr>
                            <td>{{ $miembro->asambleista->user->persona->primer_nombre . ' ' . $miembro->asambleista->user->persona->segundo_nombre . ' ' . $miembro->asambleista->user->persona->primer_apellido . ' ' . $miembro->asambleista->user->persona->segundo_apellido }}</td>
                            <td>{{ $miembro->cargo }}</td>
                            <td>
                                <select id="cargos_jd" name="cargos_jd" class="form-control" onchange="cambiar_cargo({{$miembro->asambleista->id}},this.value)">
                                    <option>-- Seleccione un cargo --</option>
                                    <option value="Presidente">Presidente</option>
                                    <option value="Vicepresidente">Vicepresidente</option>
                                    <option value="Secretario JD">Secretario</option>
                                    <option value="Vocal">Vocal</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        $(function () {
            inicializar_dataTable();
        });

        function cambiar_cargo(idMiembroJD,nuevo_cargo) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_cargo_miembro_jd') }}",
                data: {
                    "idMiembroJD": idMiembroJD,
                    "nuevo_cargo": nuevo_cargo
                }
            }).done(function (response) {
                notificacion(response.mensaje.titulo,response.mensaje.contenido,response.mensaje.tipo);
                $('#tabla_miembros_jd').DataTable().destroy();
                $("#tabla_miembros_jd").html(response.tabla);
                inicializar_dataTable();
            });
        }

        function inicializar_dataTable() {
            var tabla_miembros_jd = $('#tabla_miembros_jd').DataTable({
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
                columnDefs: [{orderable: false, targets: [0,1,2]}],
                //order: [[1, 'asc']]
            });
        }
    </script>
@endsection