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
            <li><a class="active">Planilla de Dieta</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte planilla de dietas</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_planilla_dieta") }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Tipo <span class="text-red">*</span></label>

                            <select required="true" class="form-control" id="tipoDocumento" name="tipoDocumento"
                                    onchange="mostrar(this.value)">
                                <option value="{{old("tipoDocumento")}}">Seleccione una opcion</option>
                                <option value="A">Por Asambleista</option>
                                <option value="E">Consolidados Estudiantil</option>
                                <option value="D">Consolidados Profesional Docente</option>
                                <option value="ND">Consolidados Profesional no Docente</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-4" id="mes_input">
                        <div class="form-group">
                            <label for="mes">Mes <span class="text-red">*</span></label>

                            <!-- <div class="input-group date fecha">
                                  <input required="true" id="fecha1" name="fecha1" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                              </div>-->

                            <select required="true" class="form-control" id="mes" name="mes">
                                <option value="">Seleccione un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="anio">Año <span class="text-red">*</span></label>
                            <div class="input-group date anio">
                                <input required="true" id="anio" name="anio" type="text" class="form-control"><span
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
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <span class="text-muted"><em><span
                                            class="text-red">*</span> Indica campo obligatorio</em></span>
                        </div>
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
                                @if($tipo=="A")
                                    REPORTE ANUAL DE DIETAS POR ASAMBLEISTA
                                @endif

                                @if($tipo=="E")

                                    CONSOLIDADO DE DIETAS SECTOR ESTUDIANTIL
                                @endif


                                @if($tipo=="D")

                                    CONSOLIDADO DE DIETAS SECTOR docente
                                @endif
                                @if($tipo=="ND")

                                    CONSOLIDADO DE DIETAS SECTOR no docente
                                @endif
                            </td>
                            @if($tipo=="A")
                                <td>{{$result->anio}}</td>
                            @else
                                <td>{{$result->mes}} {{$result->anio}}</td>
                            @endif

                            <td>
                                @if($tipo=="A")
                                    <a href="{{url("/Reporte_planilla_dieta/1.$result->asambleista_id.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a>


                                @endif


                                @if($tipo=="E")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_Est_pdf/1.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a>

                                @endif


                                @if($tipo=="D")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_Doc_pdf/1.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a>

                                @endif

                                @if($tipo=="ND")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_noDocpdf/1.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a>

                                @endif
                            </td>

                            <td>
                                @if($tipo=="A")
                                    <a href="{{url("/Reporte_planilla_dieta/2.$result->asambleista_id.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a>
                                @endif

                                @if($tipo=="E")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_Est_pdf/2.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a>

                                @endif

                                @if($tipo=="D")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_Doc_pdf/2.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a>

                                @endif

                                @if($tipo=="ND")
                                    <a href="{{url("/Reporte_planilla_dieta_prof_noDocpdf/2.$result->mes.$result->anio.$mesnum")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a>

                                @endif

                            </td>

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
                "order": [[1, 'asc'], [2, 'asc']],
                "displayLength": 25,
                "paging": true,
            });

            $('#anio').datepicker({
                format: "yyyy",
                startView: 2,
                minViewMode: 2,
                maxViewMode: 3,
                autoclose: true
            }).on('changeDate', function (e) {
                $('#buscarDocs').formValidation('revalidateField', 'anio');
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
                        mes: {
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione mes'
                                }
                            }
                        },
                        anio: {
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione año'
                                }
                            }
                        }


                    }
                });
        });

        function mostrar(idComision) {
            if (idComision == 'A') {
                $("#mes_input").hide();
            }
            else {
                $("#mes_input").show();
            }
        }
    </script>
@endsection

@section("lobibox")
    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
    @if(Session::has('warning'))
        <script>
            notificacion("Error", "{{ Session::get('warning') }}", "warning");
            {{ Session::forget('warning') }}
        </script>
    @endif
@endsection