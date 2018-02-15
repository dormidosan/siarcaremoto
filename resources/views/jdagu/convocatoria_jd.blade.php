@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a class="active">Generar Reunion</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Generar Reunion</h3>
        </div>

        <div class="box-body">
            <form id="convocatoria" method="post" action="{{ url('mailing_jd') }}">
             {{ csrf_field() }}
              {{ Form::hidden('id_comision', '1') }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input name="lugar" type="text" id="lugar" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <div class="input-group date fecha">
                                <input name="fecha" id="fecha" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <label>Hora</label>
                        <div class="form-group">
                            <div class='input-group date'>
                                <input name="hora" type='text' id="hora" class="form-control" />
                                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                         <label for="mensaje">Cuerpo del Mensaje</label>
                        <textarea  name="mensaje" id="mensaje" class="form-control"></textarea>
                     </div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success">Enviar Convocatoria</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection



@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('.input-group.date.fecha').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });

            $('#hora').datetimepicker({
                format: 'LT',
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