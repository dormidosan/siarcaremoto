@extends('layouts.app')

@section("styles")
    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }
    </style>
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Peticiones</a></li>
            <li><a class="active">Monitoreo de Peticion</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Monitoreo de Peticion</h3>
        </div>
        <div class="box-body">

            <form id="monitorearPeticion" name="monitorearPeticion" method="post"
                  action="{{ route('consultar_estado_peticion') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="codigo_peticion">Codigo de Peticion</label>
                            <input type="text" id="codigo_peticion" name="codigo_peticion" class="form-control"
                                   placeholder="Ingrese el codigo de su petición" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="consultarPeticion" name="consultarPeticion" class="btn btn-primary">
                            Consultar Peticion
                        </button>
                    </div>
                </div>
            </form>

            <br><br>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Estado de la Peticion</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="resultado" class="table table-striped table-bordered table-condensed table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre comision</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Descripcion</th>
                                <th>Documento</th>
                                <th>Opcion</th>
                            </tr>
                            </thead>
                            {{-- {{ dump(empty($peticionBuscada)) }}
                            {{ dump(is_null($peticionBuscada)) }}
                            {{ dump($peticion) }}--}}

                            @if(empty($peticionBuscada) != true)

                                <tbody id="cuerpoTabla" class="text-center table-hover">
                                @php $contador = 1 @endphp
                                @foreach($peticionBuscada->seguimientos as $seguimiento)
                                    <tr>
                                        <td>
                                            {!! $contador !!}
                                            @php $contador++ @endphp
                                        </td>
                                        <td>{{ $seguimiento->comision->nombre }}</td>
                                        <td>{{ $seguimiento->inicio }}</td>
                                        <td>{{ $seguimiento->fin }}</td>
                                        <td>{{ $seguimiento->descripcion }}</td>
                                        @if($seguimiento->documento)
                                            <td>{{ $seguimiento->documento->tipo_documento->tipo }}</td>
                                            <td>
                                                <a class="btn btn-info btn-xs"
                                                   href="{{ asset($disco.''.$seguimiento->documento->path) }}"
                                                   role="button"><i class="fa fa-eye"></i> Ver</a>

                                                <a class="btn btn-success btn-xs"
                                                   href="descargar_documento/<?= $seguimiento->documento->id; ?>"
                                                   role="button"><i class="fa fa-download"></i> Descargar</a>

                                            </td>
                                        @else
                                            <td>
                                                Sin documento
                                            </td>
                                            <td>
                                                N/A
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                                </tbody>
                            @else

                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section("js")
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {

            var oTable = $('#resultado').DataTable({
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
                searching: false,
                paging: false,
                columnDefs: [{orderable: false, targets: [0, 6]}],
                order: [[1, 'asc']]
            });

            $('#monitorearPeticion').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    codigo_peticion: {
                        validators: {
                            notEmpty: {
                                message: 'Ingrese el codigo de su peticion'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

@section("lobibox")

    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
        </script>
    @endif

@endsection