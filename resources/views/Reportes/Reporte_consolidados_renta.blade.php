@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/toogle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
@endsection
@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a> Reporteria</a></li>
            <li><a href="{{url('Menu_reportes')}}">Menu Reportes</a></li>
            <li><a class="active">Consolidados de Renta</a></li>
        </ol>
    </section>
@endsection
@section('content')






    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte consolidados de renta</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_consolidados_renta") }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Tipo </label>

                            <select required="true" class="form-control" id="tipoDocumento" name="tipoDocumento">
                                <option value="">Seleccione una opcion</option>
                                <option value="E">Consolidados Sector Estudiantil</option>
                                <option value="D">Consolidados Profesional Docente</option>
                                <option value="ND">Consolidados Profesional no Docente</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="mes">Mes</label>

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
                            <label for="anio">Año</label>
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
            </form>
        </div>
        <!-- /.box-body -->
    </div>




    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div>
        <div class="box-body">
            <table class="table table-hover">

                <thead>
                <tr>

                    <th>Nombre</th>

                    <th>Fecha</th>

                    <th>Ver</th>
                    <th>Descargar</th>
                    <th>Descargar Excel</th>

                </tr>
                </thead>
                <tbody>
                @if(!($resultados==NULL))
                    @foreach($resultados as $result)
                        @if($tipo=='E')
                            <tr>
                                <td>
                                    SECTOR ESTUDIANTIL
                                </td>
                                <td>{{$mes}} {{$result->anio}}</td>

                                <td><a href="{{url("/Reporte_consolidados_renta/1.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/2.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/3.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR EXCEL</a></td>
                            </tr>
                        @endif
                        @if($tipo=='ND')
                            <tr>
                                <td>
                                    SECTOR PROFESIONAL NO DOCENTE
                                </td>
                                <td>{{$mes}} {{$result->anio}}</td>

                                <td><a href="{{url("/Reporte_consolidados_renta/1.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/2.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/3.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR EXCEL</a></td>
                            </tr>
                        @endif
                        @if($tipo=='D')
                            <tr>
                                <td>
                                    SECTOR DOCENTE
                                </td>
                                <td>{{$mes}} {{$result->anio}}</td>

                                <td><a href="{{url("/Reporte_consolidados_renta/1.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">VER</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/2.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR</a></td>
                                <td><a href="{{url("/Reporte_consolidados_renta/3.$tipo.$result->mes.$result->anio")}}"
                                       class="btn btn-block btn-success btn-xs">DESCARGAR EXCEL</a></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <script>
        $('#anio').datepicker({
            format: "yyyy",
            startView: 2,
            minViewMode: 2,
            maxViewMode: 3,
            autoclose: true
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
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('#anio').datepicker({
               format: "yyyy",
    startView: 2,
    minViewMode: 2,
    maxViewMode: 3,
    autoclose: true
            }).on('changeDate',function(e){
              $('#buscarDocs').formValidation('revalidateField','anio');
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