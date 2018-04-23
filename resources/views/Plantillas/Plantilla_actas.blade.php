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
            <li><a href="{{url('Menu_plantillas')}}">Menu Reportes</a></li>
            <li><a class="active">Actas</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Plantilla de Actas</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_actas") }}">
                  {{ csrf_field() }}
                <div class="row">
                   
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha inicial <span class="text-red">*</span></label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha1" name="fecha1" type="text" class="form-control"><span class="input-group-addon"><i
                                            class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha final <span class="text-red">*</span></label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha2" name="fecha2" type="text" class="form-control"><span class="input-group-addon"><i
                                            class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button  type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar
                        </button>
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
                    <th>Num</th>

                    <th>Codigo</th>

                    <th>Nombre</th>

                     <th>Trascendental</th>

                    <th>Fecha</th>


                    <th>Descargar</th>
                    <th>Acuerdos</th>
                </tr>
                </thead>
                <tbody>
                @if(!($resultados==NULL))
                
                
                @php $i=1 @endphp

                    @foreach($resultados as $result)
                <tr>
                    <td>
                        {{$i}}
                    </td>

                     <td>
                        {{$result->codigo}}
                    </td>

                    <td>
                        {{$result->lugar}}
                    </td>

                     @if($result->trascendental==0)
                     <td>
                        NO
                    </td>
                    @else
                     <td>
                        SI
                    </td>
                    @endif

                    <td>de {{$result->inicio}} al {{$result->fin}}</td>
                    <td><a href="{{url("/desc_Plantilla_actas/$result->id.$result->periodo_id.$result->codigo.$result->fecha.$result->lugar")}}" class="btn btn-block btn-success btn-xs">DESCARGAR</a>
                    </td>

                      <td>
                      
                        <a href="{{url("/buscar_propuesta/$result->id.$result->periodo_id.$result->codigo.$result->fecha.$result->lugar")}}" class="btn btn-block btn-success btn-xs">VER ACUERDOS</a>

                    </td>

                </tr>
                @php $i=$i+1 @endphp
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
@endsection

@section("scripts")
    <script type="text/javascript">
           $(function () {
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