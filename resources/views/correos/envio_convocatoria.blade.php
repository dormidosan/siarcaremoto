@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
@endsection

@section('breadcrumb')
    @if($jd === false)
        <section>
            <ol class="breadcrumb">
                <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
                <li><a>Comisiones</a></li>
                <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
                <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a>
                <li><a href="javascript:document.getElementById('convocatoria_comision').submit();">Generar Reunion</a>
                <li class="active">Enviar Convocatora</li>
            </ol>
        </section>
    @else
        @if(isset($agenda) === false)
            <section>
                <ol class="breadcrumb">
                    <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a>Junta Directiva</a></li>
                    <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
                    <li><a href="{{ route("generar_reuniones_jd") }}">Generar Reunion</a>
                    <li><a class="active">Enviar Convocatoria</a></li>
                </ol>
            </section>
        @else
            <section>
                <ol class="breadcrumb">
                    <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li><a href="">Junta Directiva</a></li>
                    <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
                    <li><a href="{{ route('listado_agenda_plenaria_jd') }}">Generar Agenda Plenaria</a></li>
                    <li class="active">Enviar Convocatoria</li>
                </ol>
            </section>
        @endif
    @endif
@endsection

@section("content")
    @if($jd === false)
        <div class="hidden">
            <form id="trabajo_comision" name="trabajo_comision" method="post"
                  action="{{ route("trabajo_comision") }}">
                {{ csrf_field() }}
                <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                <button class="btn btn-success btn-xs">Acceder</button>
            </form>

            <form id="convocatoria_comision" name="convocatoria_comision"
                  method="post" action="{{ route('convocatoria_comision') }}">
                {{ csrf_field() }}
                <div class="text-center">
                    <i class="fa fa-envelope fa-4x text-green"></i>
                </div>
                <h3 class="profile-username text-center">Generar Reuniones Comision</h3>
                <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                <button type="submit" class="btn btn-success btn-block btn-sm"><b>Acceder</b></button>
            </form>
        </div>
    @endif

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Generar Reunion</h3>
        </div>

        <div class="box-body">
            <form id="convocatoria" method="post" action="{{ url('enviar_correo') }}">
                {{ csrf_field() }}
                @if(!empty($reunion))
                    <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                @else
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                @endif
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            @if(!empty($reunion))
                                <input name="lugar" type="text" id="lugar" class="form-control" required="required"
                                       disabled="disabled" value="{!! $reunion->lugar !!}">
                            @else
                                <input name="lugar" type="text" id="alugar" class="form-control" required="required"
                                       disabled="disabled" value="{!! $agenda->lugar !!}">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            @if(!empty($reunion))
                                <div class="input-group date fecha" id="fechaReunion">
                                    <input name="fecha" id="fecha" type="text" class="form-control" disabled="disabled"
                                           value="{{ \Carbon\Carbon::parse($reunion->convocatoria)->format('d-m-Y') }}"><span
                                            class="input-group-addon"><i class="glyphicon glyphicon-th"
                                                                         required="required"></i></span>
                                </div>
                            @else
                                <div class="input-group date fecha" id="fechaReunion">
                                    <input name="fecha" id="afecha" type="text" class="form-control" disabled="disabled"
                                           value="{{ \Carbon\Carbon::parse($agenda->inicio)->format('d-m-Y') }}"><span
                                            class="input-group-addon"><i class="glyphicon glyphicon-th"
                                                                         required="required"></i></span>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <label>Hora</label>
                        <div class="form-group">
                            <div class='input-group date'>
                                @if(!empty($reunion))
                                    <input name="hora" type='text' id="hora" class="form-control" required="required"
                                           disabled="disabled"
                                           value="{{ \Carbon\Carbon::parse($reunion->convocatoria)->format('h:i A') }}"
                                           placeholder="h:m AM">
                                @else
                                    <input name="hora" type='text' id="ahora" class="form-control" required="required"
                                           disabled="disabled"
                                           value="{{ \Carbon\Carbon::parse($agenda->inicio)->format('h:i A') }}"
                                           placeholder="h:m AM">
                                @endif
                                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="mensaje">Cuerpo del Mensaje <span class="text-red">*</span></label>
                            <textarea name="mensaje" id="mensaje" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-success">Enviar Convocatoria</button>
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
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
@endsection




@section("scripts")
    <script type="text/javascript">
        $(function () {

            $('#fecha').mask("99-99-9999", {placeholder: "dd-mm-yyyy"});

            $('#fechaReunion')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                }).on('changeDate', function (e) {
                // Revalidate the start date field
                $('#convocatoria').formValidation('revalidateField', 'fecha');
            });

            $('#hora').datetimepicker({
                format: 'LT'
            }).on('dp.change', function (e) {
                // Revalidate the start date field
                $('#convocatoria').formValidation('revalidateField', 'hora');

            });

            $('#convocatoria').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    lugar: {
                        validators: {
                            notEmpty: {
                                message: 'El lugar de la sesión es requerido'
                            }
                        }
                    },
                    fecha: {
                        validators: {
                            date: {
                                format: 'DD-MM-YYYY',
                                min: "{{ \Carbon\Carbon::now()->format("d-m-Y") }}",
                                message: 'La fecha debe ser igual o mayor que ' + "{{ \Carbon\Carbon::now()->format("d-m-Y") }}"
                            },
                            notEmpty: {
                                message: 'La fecha de la sesion es requerida'
                            }
                        }
                    },
                    hora: {
                        validators: {
                            notEmpty: {
                                message: 'La hora de la sesion es requerida'
                            }
                        }
                    },
                    mensaje: {
                        validators: {
                            notEmpty: {
                                message: 'El contenido de la convocatoria es requerido'
                            }
                        }
                    },
                }
            });
        });
    </script>
@endsection

@section("lobibox")

    @if(Session::has('Exito'))
        <script>
            notificacion("Correos enviados", "{{ Session::get('Exito') }}", "success");
            {{ Session::forget('Exito') }}
        </script>
    @endif

@endsection