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
            <li><a class="active">Asambleista por Periodo</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte Asambleistas por periodo</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_asambleistas_periodo") }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Periodo AGU <span class="text-red">*</span></label>
                            {!! Form::select('periodo',$periodos,$periodo,['id'=>'periodo','name'=>'periodo','class'=>'form-control','requiered'=>'required','placeholder'=>'seleccione periodo']) !!}
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

                    <th>Nombre Periodo</th>

                    <th>Ver</th>
                    <th>Descargar</th>
                </tr>
                </thead>
                <tbody>
                @if(!($resultados==NULL))
                    @foreach($resultados as $result)
                        <tr>
                            <td>
                                ASAMBLEISTAS DEL PERIODO {{$result->nombre_periodo}}
                            </td>
                            <td>{{$result->nombre_periodo}}</td>

                            <td><a href="{{url("/Reporte_Asambleista_Periodo/1.$periodo")}}"
                                   class="btn btn-block btn-success btn-xs">VER</a></td>
                            <td><a href="{{url("/Reporte_Asambleista_Periodo/2.$periodo")}}"
                                   class="btn btn-block btn-success btn-xs">DESCARGAR</a></td>

                        </tr>

                        <!--    <tr>
                      <td>
                        Inasistencias a Sesiones plenarias
                      </td>
                      <td>fecha</td>
                    
                      <td><a href="{{url("/Reporte_inasistencias_sesion_plenaria_pdf/1")}}" class="btn btn-block btn-success btn-xs" >VER</a></td>
                      <td><a href="{{url("/Reporte_inasistencias_sesion_plenaria_pdf/2")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a></td>
                    
                    </tr>

                    -->

                    @endforeach
                @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <script>
        $('#fecha').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            language: "es",
            autoclose: true,
            todayHighlight: true
        });


    </script>

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

            $('#buscarDocs')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {

                        periodo: {
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione el periodo'
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