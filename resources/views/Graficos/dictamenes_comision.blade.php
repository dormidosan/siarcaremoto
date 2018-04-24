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
@endsection

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a> Reporteria</a></li>
            <li><a href="{{route('menu_graficos')}}">Graficos</a></li>
            <li><a class="active">Dictamenes por Comision</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <div class="box-header text-center">
                <h4>Dictamenes por Comision</h4>
            </div>
            <div class="box-body">
                <form id="form_dictamenes" method="post" action="{{ route("dictamenes_comision_post")}}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-md-12 col-lg-offset-4">
                            <div class="form-group">
                                <label for="anio">Periodo <span class="text-red">*</span></label>
                                <select id="periodo" name="periodo" class="form-control">
                                    <option value="">-- Seleccione un periodo --</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->nombre_periodo }}</option>
                                    @endforeach
                                </select>
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
                @if(empty($dictamenes))
                    <div class="alert alert-warning text-center" role="alert">Seleccione un periodo para generar el
                        grafico
                    </div>
                @else
                    <canvas id="myChart"></canvas>
                @endif
            </div>
        </div>
    </div>

@endsection

@section("js")
    <script src="{{ asset('libs/charts/chart.js') }}"></script>
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

            $('#form_dictamenes')
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
                                    message: 'Seleccione periodo'
                                }
                            }
                        }
                    }
                });

            var ctx = $("#myChart");


            @if(empty($dictamenes) == false)

            var PieData        = [
                    {
                        value    : 700,
                        color    : '#f56954',
                        highlight: '#f56954',
                        label    : 'Chrome'
                    },
                    {
                        value    : 500,
                        color    : '#00a65a',
                        highlight: '#00a65a',
                        label    : 'IE'
                    },
                    {
                        value    : 400,
                        color    : '#f39c12',
                        highlight: '#f39c12',
                        label    : 'FireFox'
                    },
                    {
                        value    : 600,
                        color    : '#00c0ef',
                        highlight: '#00c0ef',
                        label    : 'Safari'
                    },
                    {
                        value    : 300,
                        color    : '#3c8dbc',
                        highlight: '#3c8dbc',
                        label    : 'Opera'
                    },
                    {
                        value    : 100,
                        color    : '#d2d6de',
                        highlight: '#d2d6de',
                        label    : 'Navigator'
                    }
                ];
                var myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: [
                                @foreach($dictamenes as $dictamen)
                                "{{$dictamen[0]}}",
                                @endforeach
                            ],
                            datasets: [{
                                label: '# of Votes',
                                data: [
                                    @foreach($dictamenes as $dictamen)
                                        {{$dictamen[1]}},
                                    @endforeach
                                ],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',

                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',

                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderWidth: 1
                                }]
                            }
                });
            @endif
        });
    </script>
@endsection


@section("lobibox")
    @if(Session::has('error'))
        <script>
            notificacion("No info", "{{ Session::get('error') }}", "error");
            {{ Session::forget('error') }}
        </script>
    @elseif(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
@endsection