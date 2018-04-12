@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/toogle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">

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

        table {
            width: 100% !important;
        }

        table tbody tr.group td {
            font-weight: bold;
            text-align: left;
            background: #ddd;
        }

    </style>
@endsection

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a> Reporteria</a></li>
            <li><a href="{{url('Menu_reportes')}}">Menu Reportes</a></li>
            <li><a class="active">Permisos Permanentes</a></li>
        </ol>
    </section>
@endsection

@section('content')

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte permisos permanentes</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_permisos_permanentes") }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha inicial</label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha1" name="fecha1" type="text" class="form-control"><span
                                        class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha final</label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha2" name="fecha2" type="text" class="form-control"><span
                                        class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div>
        <div class="box-body">
            <table id="listado" class="table table-striped table-bordered table-hover text-center">

                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                    <th>Descargar</th>
                </tr>
                </thead>
                <tbody>
                @if(!($resultados==NULL))
                    @foreach($resultados as $result)
                        <tr>
                            <td>
                                REPORTE PERMISOS PERMANENTES
                            </td>
                            <td>{{$fechainicial}} al {{$fechafinal}}</td>

                            <td><a href="{{url("/Reporte_permisos_permanentes/1.$fechainicial.$fechafinal")}}"
                                   class="btn btn-block btn-success btn-xs">VER</a></td>
                            <td><a href="{{url("/Reporte_permisos_permanentes/2.$fechainicial.$fechafinal")}}"
                                   class="btn btn-block btn-success btn-xs">DESCARGAR</a></td>

                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/toogle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {

            var table = $('#listado').DataTable({
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
                "columnDefs": [
                    {"orderable": false, "targets": [1, 2, 3]}
                ],
                "searching": true,
                "order": [ [1, 'asc'],[2, 'asc']],
                "displayLength": 25,
                "paging": true,
            });

            $('#fecha1')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                })
                .on('changeDate', function (e) {
                    // Revalidate the start date field
                    $('#buscarDocs').formValidation('revalidateField', 'fecha1');
                });

            $('#fecha2')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                })
                .on('changeDate', function (e) {
                    $('#buscarDocs').formValidation('revalidateField', 'fecha2');
                });

            $('#buscarDocs')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        tipoDocumento: {
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione un tipo de Documento'
                                }
                            }
                        },
                        fecha1: {
                            validators: {
                                notEmpty: {
                                    message: 'Fecha de inicio requerida'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    max: 'fecha2',
                                    message: 'Fecha de inicio no puede ser mayor que fecha fin'
                                }
                            }
                        },
                        fecha2: {
                            validators: {
                                notEmpty: {
                                    message: 'Fecha fin es requerida'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    min: 'fecha1',
                                    message: 'Fecha fin no puede ser menor que fecha inicio'
                                }
                            }
                        }
                    }
                }).on('success.field.fv', function (e, data) {
                if (data.field === 'startDate' && !data.fv.isValidField('endDate')) {
                    // We need to revalidate the end date
                    data.fv.revalidateField('endDate');
                }

                if (data.field === 'endDate' && !data.fv.isValidField('startDate')) {
                    // We need to revalidate the start date
                    data.fv.revalidateField('startDate');
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
    @if(Session::has('warning'))
        <script>
            notificacion("Exito", "{{ Session::get('warning') }}", "warning");
        </script>
    @endif
@endsection