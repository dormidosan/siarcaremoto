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
            <li><a class="active">Peticiones por Mes</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <div class="box-header text-center">
                <h4>Peticiones recibidas por mes del Año {{ $year }}</h4>
            </div>
            <div class="box-body">
                <form id="form_anio" method="post" action="{{ route("peticiones_por_post")}}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-md-12 col-lg-offset-4">
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
                @if(empty($peticiones))
                    <div class="alert alert-warning text-center" role="alert">Seleccione un año para generar el grafico</div>
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

            $('#anio').datepicker({
                format: "yyyy",
                startView: 2,
                minViewMode: 2,
                maxViewMode: 3,
                autoclose: true
            }).on('changeDate', function (e) {
                $('#form_anio').formValidation('revalidateField', 'anio');
            });

            $('#form_anio')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        anio: {
                            validators: {
                                notEmpty: {
                                    message: 'Seleccione año'
                                }
                            }
                        }
                    }
                });

            var ctx = $("#myChart");
            @if(empty($peticiones) == false)
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                        datasets: [{
                            label: '# de Peticiones Recibidas',
                            data: [{{ $peticiones[0] }}, {{ $peticiones[1]  }}, {{ $peticiones[2]  }}, {{ $peticiones[3]  }}, {{ $peticiones[4]  }}, {{ $peticiones[5]  }}, {{ $peticiones[6]  }}, {{ $peticiones[7]  }}, {{ $peticiones[8]  }}, {{ $peticiones[9]  }}, {{ $peticiones[10]  }}, {{ $peticiones[11]  }}, {{ $peticiones[5]  }}, {{ $peticiones[5]  }},],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)', //enero
                                'rgba(54, 162, 235, 0.2)', //febrero
                                'rgba(255, 206, 86, 0.2)', //marzo
                                'rgba(75, 192, 192, 0.2)', //abril
                                'rgba(153, 102, 255, 0.2)',//mayo
                                'rgba(255, 159, 64, 0.2)', //junio

                                'rgba(256, 99, 132, 0.2)', //julio
                                'rgba(54, 162, 235, 0.2)', //agosto
                                'rgba(255, 206, 86, 0.2)', //sept
                                'rgba(75, 192, 192, 0.2)', //oct
                                'rgba(153, 102, 255, 0.2)', //nob
                                'rgba(255, 159, 64, 0.2)' //dic
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',

                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }],

                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
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