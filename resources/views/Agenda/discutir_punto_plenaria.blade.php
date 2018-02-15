@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">

@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Agenda</a></li>
            <li><a href="{{ route('consultar_agenda_vigentes') }}">Consultar Agendas Vigentes</a></li>
            <li><a href="javascript:document.getElementById('sala_sesion_plenaria').submit();">Sesion Plenaria de
                    Agenda {{ $agenda->codigo }}</a></li>
            <li><a href="javascript:document.getElementById('iniciar_sesion_plenaria').submit();">Listado de Puntos</a>
            </li>
            <li class="active">Discusion de Punto de Plenaria</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Discusión de Punto</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class=" hidden">
                    {!! Form::open(['id'=>'iniciar_sesion_plenaria','route'=>['iniciar_sesion_plenaria'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    <input type="hidden" name="retornar" id="retornar" value="retornar">
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block">Regresar a -
                        Sesion plenaria
                    </button>
                    {!! Form::close() !!}

                    {!! Form::open(['id'=>'sala_sesion_plenaria','route'=>['sala_sesion_plenaria'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    <button type="submit" id="iniciar" name="iniciar"
                            class="btn btn-primary btn-block"> Iniciar sesion plenaria
                    </button>
                    {!! Form::close() !!}
                </div>

                @if($punto->activo == 1)
                    <div class="col-lg-3 col-sm-12">
                        {!! Form::open(['route'=>['retirar_punto_plenaria'],'method'=> 'POST']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-red-gradient btn-block">Retirar
                            punto
                        </button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        {!! Form::open(['route'=>['resolver_punto_plenaria'],'method'=> 'POST']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-green-gradient btn-block">Resolver
                            punto
                        </button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        {!! Form::open(['route'=>['comision_punto_plenaria'],'method'=> 'POST','target' => '_blank']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-teal-gradient btn-block">Enviar a
                            comision
                        </button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        {!! Form::open(['route'=>['seguimiento_peticion_plenaria'],'method'=> 'POST','target' => '_blank']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <input type="hidden" name="regresar" id="regresar" value="d">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-yellow-gradient btn-block">Historial
                            seguimiento
                        </button>
                        {!! Form::close() !!}
                    </div>
                @else
                    <div class="col-lg-6 col-sm-12">
                        {!! Form::open(['route'=>['comision_punto_plenaria'],'method'=> 'POST','target' => '_blank']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-teal-gradient btn-block">Enviar a comision
                        </button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {!! Form::open(['route'=>['seguimiento_peticion_plenaria'],'method'=> 'POST','target' => '_blank']) !!}
                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                        <input type="hidden" name="regresar" id="regresar" value="d">
                        <button type="submit" id="iniciar" name="iniciar" class="btn bg-yellow-gradient btn-block">Historial
                            seguimiento
                        </button>
                        {!! Form::close() !!}
                    </div>
                @endif


            </div>
            <br>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="info_peticion">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#info_peticion_contenido" aria-expanded="true"
                               aria-controls="info_peticion_contenido" class="text-capitalize">
                                Informacion de Peticion
                            </a>
                        </h4>
                    </div>
                    <div id="info_peticion_contenido" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="info_peticion_contenido">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Peticionario</label>
                                        <input name="nombre" type="text" class="form-control" id="nombre"
                                               value="{{ $punto->peticion->peticionario }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Fecha inicio</label>
                                        <input name="nombre" type="text" class="form-control" id="nombre"
                                               value="{{ Carbon\Carbon::parse($punto->peticion->fecha)->format('d-m-Y h:m:i a') }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Fecha Actual</label>
                                        <input name="nombre" type="text" class="form-control" id="nombre"
                                               value="{{ date_format(Carbon\Carbon::now(),"d-m-Y h:m:i a") }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Descripcion</label>
                                        <textarea class="form-control"
                                                  readonly>{{ $punto->peticion->descripcion }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @if($punto->activo == 1)
                @include('Agenda.propuestas')
                @include('Agenda.intervenciones')
            @endif
            @if($punto->activo == 0)
                @include('Agenda.propuestas_inactivas')
                @include('Agenda.intervenciones_inactivas')
            @endif


        </div>
    </div>
    @include("Modal.MostrarIntervencionModal")

@endsection

@section("js")
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>

@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            var maxChar = 254;
            var maxCharIntevencion = 1000;
            $("#caja").removeClass("text-danger");
            $("#caja").addClass("text-green");
            $("#caja2").removeClass("text-danger");
            $("#caja2").addClass("text-green");

            $("#nueva_propuesta").keyup(function () {
               var length = $(this).val().length;
               total = maxChar - length;
               $("#chars").text(total);
               if(total == 0){
                   $("#caja").removeClass("text-green");
                   $("#caja").addClass("text-danger");
               }
            });

            $("#nueva_intervencion").keyup(function () {
               var length = $(this).val().length;
               total = maxCharIntevencion - length;
               $("#chars2").text(total);
               if(total == 0){
                   $("#caja2").removeClass("text-green");
                   $("#caja2").addClass("text-danger");
               }
            });

            $('#agregarPropuesta')
                .find('[name="asambleista_id"]')
                .select2()
                // Revalidate the color when it is changed
                .change(function (e) {
                    $('#agregarPropuesta').formValidation('revalidateField', 'asambleista_id');
                })
                .end()
                .formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nueva_propuesta: {
                        validators: {
                            stringLength: {
                                max: 254,
                                message: 'La propuesta no debe de exceder los 254 caracteres'
                            },
                            notEmpty: {
                                message: 'La propuesta es requerida'
                            }
                        }
                    },
                    asambleista_id: {
                        validators: {
                            callback: {
                                message: 'Seleccione un asambleista',
                                callback: function (value, validator, $field) {
                                    // Get the selected options
                                    var options = validator.getFieldElements('asambleista_id').val();
                                    return (options != null && options.length >= 1);
                                }
                            }
                        }
                    }
                }
            });

            $('#agregarIntervencion')
                .find('[name="asambleista_id_intervencion"]')
                .select2()
                // Revalidate the color when it is changed
                .change(function (e) {
                    $('#agregarIntervencion').formValidation('revalidateField', 'asambleista_id_intervencion');
                })
                .end()
                .formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nueva_intervencion: {
                        validators: {
                            stringLength: {
                                max: 1000,
                                message: 'La intervencion no debe de exceder los 1000 caracteres'
                            },
                            notEmpty: {
                                message: 'La intervencion es requerida'
                            }
                        }
                    },
                    asambleista_id_intervencion: {
                        validators: {
                            callback: {
                                message: 'Seleccione un asambleista',
                                callback: function (value, validator, $field) {
                                    // Get the selected options
                                    var options = validator.getFieldElements('asambleista_id_intervencion').val();
                                    return (options != null && options.length >= 1);
                                }
                            }
                        }
                    }
                }
            });

            $("#documento").fileinput({
                theme: "explorer",
                uploadUrl: "/file-upload-batch/2",
                language: "es",
                minFileCount: 1,
                maxFileCount: 3,
                allowedFileExtensions: ['docx', 'pdf'],
                showUpload: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true,
                showPreview: false

            });
            clearForms();
        });

        $('#asambleista_id').select2({
            placeholder: 'Seleccione un asambleista',
            language: "es",
            width: '100%'
        });

        $('#asambleista_id_intervencion').select2({
            placeholder: 'Seleccione un asambleista',
            language: "es",
            width: '100%'
        });

        function mostrarIntervencion(idIntervencion, event) {
            event.preventDefault();
            $("#asambleista_nombre").val("");
            $("#contenido").val("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('obtener_datos_intervencion') }}",
                data: {
                    "idIntervencion": idIntervencion,
                }
            }).done(function (response) {
                $("#myModalLabel").text("Intervencion de " + response.asambleista); //remplazar el contenido del header
                $("#contenido").val(response.contenido);
                $("#mostrarIntervencion").modal('show')
            });
        }

        function clearForms() {
            document.getElementById("nueva_propuesta").value = ""; //don't forget to set the textbox ID
            document.getElementById("nueva_intervencion").value = ""; //don't forget to set the textbox ID
        }
    </script>
@endsection



