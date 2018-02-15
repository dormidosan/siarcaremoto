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
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a class="active">Administrar Integrantes</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Administrar Integrantes de {{ ucwords($comision->nombre) }}</h3>
        </div>
        <div class="box-body">
            <form id="AgregarAsambleista" name="AgregarAsambleista" class="AgregarAsambleista" method="post"
                  action="{{ route("agregar_asambleistas_comision") }}">
                {{ csrf_field() }}
                <div class="row hidden">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="nombre">Comision</label>
                            <input type="text" id="comision_id" name="comision_id" class="form-control"
                                   value="{{ $comision->id }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="asambleistas">Asambleista</label>
                            <select id="asambleistas" name="asambleistas[]" class="form-control" multiple="multiple">
                                @foreach($asambleistas as $asambleista)
                                    <option value="{{ $asambleista->id }}">{{ $asambleista->user->persona->primer_nombre . " " . $asambleista->user->persona->segundo_nombre . " " . $asambleista->user->persona->primer_apellido . " " . $asambleista->user->persona->segundo_apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="crearComision" name="crearComision" class="btn btn-primary">Agregar
                            Asambleista
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table id="listado"
                       class="table table-striped table-bordered table-condensed table-hover dataTable text-center">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Sector</th>
                        <th>Facultad</th>
                        <th>Cargo</th>
                        <th>Opcion</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($integrantes as $integrante)
                        <tr>
                            <td>{{ $integrante->asambleista->user->persona->primer_nombre . " " . $integrante->asambleista->user->persona->segundo_nombre . " " . $integrante->asambleista->user->persona->primer_apellido . " " . $integrante->asambleista->user->persona->segundo_apellido }}</td>
                            <td>{{ $integrante->asambleista->sector->nombre }}</td>
                            <td>{{ $integrante->asambleista->facultad->nombre }}</td>
                            <td>{{ $integrante->cargo }}</td>
                            <td>
                                <form id="retirar_asambleista" name="retirar_asambleista" method="post"
                                      action="{{ route("retirar_asambleista_comision") }}">
                                    {{ csrf_field() }}
                                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                                    <input class="hidden" id="asambleista_id" name="asambleista_id"
                                           value="{{$integrante->asambleista_id}}">
                                    <button class="btn btn-danger btn-xs">Retirar</button>
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

            var oTable = $('#listado').DataTable({
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
                responsive: true

            });

            $('#asambleistas').select2({
                placeholder: 'Seleccione un asambleista',
                language: "es",
                width: '100%'
            });

            /*$('#AgregarAsambleista').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    "asambleistas[]": {
                        validators: {
                            notEmpty: {
                                message: 'Ingrese un asambleista.'
                            }
                        }
                    }
                }
            });*/

            $('#AgregarAsambleista')
                .find('[name="asambleistas[]"]')
                .select2()
                // Revalidate the color when it is changed
                .change(function (e) {
                    $('#AgregarAsambleista').formValidation('revalidateField', 'asambleistas[]');
                })
                .end()
                .formValidation({
                    framework: 'bootstrap',
                    excluded: ':disabled',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        "asambleistas[]": {
                            validators: {
                                callback: {
                                    message: 'Seleccione al menos un asambleista',
                                    callback: function (value, validator, $field) {
                                        // Get the selected options
                                        var options = validator.getFieldElements('asambleistas[]').val();
                                        return (options != null && options.length >= 1);
                                    }
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