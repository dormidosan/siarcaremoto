@extends('layouts.app')

@section("styles")
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
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
            <li><a>Comisiones</a></li>
            <li class="active">Listado Comisiones</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Listado Comisiones</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="listadoComisiones"
                       class="table table-striped table-bordered table-condensed table-hover dataTable text-center">
                    <thead>
                    <tr>
                        <th>Nombre de Comision</th>
                        <th>Numero Integrantes</th>
                        <th>Integrantes</th>
                        <th>Administracion</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($comisiones as $comision)
                        @php $contador = 0 @endphp
                        @foreach($cargos as $cargo)
                            @if($cargo->comision_id == $comision->id && $cargo->activo == 1 && $cargo->asambleista->periodo->activo == 1)
                                @php $contador++ @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td>{{ $comision->nombre }}</td>
                            <td>
                                {{ $contador }}
                            </td>
                            <td>
                                <form id="gestionar_asambleistas_comision" name="gestionar_asambleistas_comision"
                                      method="post" action="{{ route("gestionar_asambleistas_comision") }}">
                                    {{ csrf_field() }}
                                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                                    <button class="btn btn-primary btn-xs">Gestionar</button>
                                </form>
                            </td>
                            <td>
                                <form id="trabajo_comision" name="trabajo_comision" method="post"
                                      action="{{ route("trabajo_comision") }}">
                                    {{ csrf_field() }}
                                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                                    <button class="btn btn-success btn-xs">Acceder</button>
                                </form>
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
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            var oTable = $('#listadoComisiones').DataTable({
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
                }

            });
        });
    </script>
@endsection