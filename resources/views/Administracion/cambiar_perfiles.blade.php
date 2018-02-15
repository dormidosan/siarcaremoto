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
            <li><a class="active">Perfiles</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <div class="box-header">
                <h3 class="box-title">Cambiar Perfiles</h3>
            </div>
            <div class="box-body">
                <table class="table text-center" id="tabla_perfiles_usuarios">
                    <thead>
                    <tr>
                        <th>Asambleista</th>
                        <th>Perfil Actual</th>
                        <th>Nuevo Perfil</th>
                    </tr>
                    </thead>
                    <tbody id="body_tabla_perfiles_usuarios">
                    @foreach($asambleistas as $asambleista)
                        <tr>
                            <td>{{ $asambleista->user->persona->primer_nombre . ' ' . $asambleista->user->persona->segundo_nombre . ' ' . $asambleista->user->persona->primer_apellido . ' ' . $asambleista->user->persona->segundo_apellido }}</td>
                            <td>{{ ucfirst($asambleista->user->rol->nombre_rol) }}</td>
                            <td>
                                <select id="perfil" class="form-control" onchange="actualizar_perfil_usuario({{$asambleista->id}},this.value)">
                                    <option> -- Seleccione una opcion --</option>
                                    @foreach($perfiles as $perfil)
                                        <option value="{{ $perfil->id }}">{{ ucfirst($perfil->nombre_rol)}}</option>
                                    @endforeach
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

        function inicializar_dataTable() {
            var tabla = $('#tabla_perfiles_usuarios').DataTable({
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

        function actualizar_perfil_usuario(idAsambleista,idPerfil) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_perfil_usuario') }}",
                data: {
                    "idAsambleista": idAsambleista,
                    "idPerfil": idPerfil
                }
            }).done(function (response) {
                notificacion(response.mensaje.titulo,response.mensaje.contenido,response.mensaje.tipo);
                //$('#tabla_perfiles_usuarios').DataTable().destroy();
                //$("#tabla_perfiles_usuarios").html(response.tabla);
                $('#tabla_perfiles_usuarios').DataTable().destroy();
                $("#body_tabla_perfiles_usuarios").html(response.body_tabla);
               inicializar_dataTable();
            });
        }
    </script>
@endsection