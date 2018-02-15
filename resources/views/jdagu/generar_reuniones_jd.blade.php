@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
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
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Listado de Reuniones</h3>

        </div>

        <div class="box-body">

            <form id="convocatoria" method="post" action="{{ url('crear_reunion_jd') }}">
                {{ csrf_field() }}
                {{ Form::hidden('id_comision', '1') }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input name="lugar" type="text" id="lugar" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <div class="input-group date fecha" id="fechaReunion">
                                <input name="fecha" id="fecha" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th" required="required"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-12">
                        <label>Hora</label>
                        <div class="form-group">
                            <div class='input-group date'>

                                <input name="hora" type='text' id="hora" class="form-control" required="required" placeholder="h:i AM">

                                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table text-center table-bordered table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Lugar</th>
                        <th>Convocatoria</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th colspan="3">Accion</th>
                    </tr>
                    </thead>
                    <tbody id="cuerpoTabla" class="table-hover">
                    @php $contador =1 @endphp @forelse($reuniones as $reunion)

                        <tr>

                            <td>
                                {!! $contador !!} @php $contador++ @endphp
                            </td>
                            <td>{!! $reunion->codigo !!}</td>
                            <td>{!! $reunion->lugar !!}</td>
                            <td>{{ date("m-d-Y h:i A",strtotime($reunion->convocatoria)) }}</td>
                            <td>{{ ($reunion->inicio != "")? date("m-d-Y h:i A",strtotime($reunion->inicio)):"" }}</td>
                            <td>{{ ($reunion->fin != "")? date("m-d-Y h:i A",strtotime($reunion->inicio)):"" }}</td>
                            @if($reunion->vigente == 1)
                                <td>
                                    {!! Form::open(['route'=>['enviar_convocatoria_jd'],'method'=> 'POST','id'=>"c".$reunion->id]) !!}
                                    <input type="hidden" name="id_comision" id="id_comision"
                                           value="{{$reunion->comision_id}}">
                                    <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                                    <button type="submit" class="btn btn-info btn-xs btn-block">
                                        <i class="fa fa-eye"></i> Enviar convocatoria
                                    </button>
                                    {!! Form::close() !!}
                                </td>

                                @if($reunion->activa == 0)

                                    <td>
                                        {!! Form::open(['route'=>['eliminar_reunion_jd'],'method'=> 'POST','id'=>"d".$reunion->id]) !!}
                                        <input type="hidden" name="id_comision" id="id_comision"
                                               value="{{$reunion->comision_id}}">
                                        <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                                        <button type="submit" class="btn btn-danger btn-xs btn-block">
                                            <i class="fa fa-eye"></i> Eliminar reunion
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @empty
                        <p style="color: red ;">No hay criterios de busqueda</p>
                    @endforelse
                    </tbody>
                </table>
            </div>
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
                                message: 'La fecha debe ser igual o mayor que '+ "{{ \Carbon\Carbon::now()->format("d-m-Y") }}"
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

@endsection