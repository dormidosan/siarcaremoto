@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">

    <style>
        #myProgress {
            width: 100%;
            background-color: grey;
        }

        #progressBar {
            width: 1%;
            height: 30px;
            background-color: green;
        }
    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li class="active">Periodo AGU</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Definir Periodo AGU</h3>
        </div>
        <div class="box-body">
            <form id="periodo_agu" name="periodo_agu" method="post" action="{{ route("guardar_periodo") }}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group {{ $errors->has('nombre_periodo') ? 'has-error' : '' }}">
                            <label for="nombre_periodo">Periodo <span class="text-red">*</span></label>
                            <input type="text" class="form-control" id="nombre_periodo" name="nombre_periodo"
                                   placeholder="Ingrese un nombre">
                            <span class="text-danger">{{ $errors->first('nombre_periodo') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group {{ $errors->has('inicio') ? 'has-error' : '' }}">
                            <label for="inicio">Fecha <span class="text-red">*</span></label>
                            <div class="input-group date fecha" id="fecha_inicio">
                                <input id="inicio" name="inicio" type="text" class="form-control"
                                       placeholder="dd-mm-yyyy"><span
                                        class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                            <span class="text-danger">{{ $errors->first('inicio') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="excel">Subir Excel</label>
                            <input id="excel" name="excel" type="file" placeholder="Subir archivo"
                                   accept=".xls,.xlsx">
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-6 col-lg-offset-3">
                        @if($periodo_activo != 1)
                            <button type="button" class="btn btn-success btn-block" onclick="mostar_progeso(event)">
                                Aceptar
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-block disabled" data-toggle="tooltip" data-placement="bottom" title="Finalice periodo actual para habilitar esta opcion" onclick="error()">Aceptar</button>
                        @endif
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

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Listado Periodos AGU</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="text-center table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Periodo</th>
                        <th>Asambleistas</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->nombre_periodo }}</td>
                            <td>{{ substr($periodo->inicio,0,4) ." - ". substr($periodo->fin,0,4)}}</td>
                            <td><a href="{{url("/Reporte_Asambleista_Periodo/2.$periodo->id")}}"
                                   class="btn btn-xs btn-info">Descargar</a></td>
                            @if($periodo->activo)
                                <td>
                                    <form id="finalizar_periodo" method="post"
                                          action="{{ route("finalizar_periodo") }}">
                                        {{ csrf_field() }}
                                        <input type="text" id="periodo_id" name="periodo_id" class="hidden"
                                               value="{{$periodo->id}}">
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="finalizar_periodo_modal()">Finalizar
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal_progress" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" id="progressBar" role="progressbar"
                             aria-valuenow="0"
                             aria-valuemin="100" aria-valuemax="100" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="modal_fin_periodo" class="modal fade" tabindex="-1" role="dialog" data-keyboard="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Finalizar Periodo</h4>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <p class="text-bold">¿Desea finalizar el periodo seleccionado?</p>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" id="fin_periodo" class="btn btn-primary" onclick="finalizar_periodo()">Aceptar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>

                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            var nowDate = new Date();
            var today = nowDate.getDate()+'-'+(nowDate.getMonth()+1)+'-'+nowDate.getFullYear();


            $("#excel").fileinput({
                browseClass: "btn btn-primary btn-block",
                previewFileType: ".xls,.xlsx",
                theme: "explorer",
                //uploadUrl: "/file-upload-batch/2",
                language: "es",
                //minFileCount: 1,
                maxFileCount: 1,
                allowedFileExtensions: ['xls', 'xlsx'],
                showUpload: false,
                showCaption: false,
                showRemove: false,
                fileActionSettings: {
                    showRemove: false,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true
            });

            $('#fecha_inicio')
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
                    $('#periodo_agu').formValidation('revalidateField', 'inicio');
                });


            $('#periodo_agu').formValidation({
                //initially validation for the fields with the option enabled as false is off, when the user type is
                //Asambleista their status is gonna change to true and furthermore their validation will start working
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nombre_periodo: {
                        validators: {
                            notEmpty: {
                                message: 'El nombre del periodo es requerido'
                            }
                        }
                    },
                    inicio: {
                        validators: {
                            notEmpty: {
                                message: 'Fecha de inicio requerida'
                            },
                            date: {
                                format: 'DD-MM-YYYY',
                                min: today,
                                message: 'Fecha de inicio no puede ser menor que hoy'
                            }
                        }
                    }
                }
            });
        });


        function error(){
            notificacion("Informacion","Debe finalizar el periodo actual para agregar uno nuevo","info");
        }

        function mostar_progeso(event) {
            var form = $("#periodo_agu").data('formValidation').validate();

            if (form.isValid()) {
                document.getElementById("periodo_agu").submit();
                Lobibox.progress({
                    title: 'Por favor, espere',
                    label: 'Creando Periodo...',
                    closeButton: false,
                    closeOnEsc: false,
                    showProgressLabel: false,
                    onShow: function ($this) {
                        var i = 0;
                        var inter = setInterval(function () {
                            if (i > 100) {
                                inter = clearInterval(inter);
                            }
                            i = i + 0.1;
                            $this.setProgress(i);
                        }, 10);
                    }
                });
            }

        }

        /*function finalizar_periodo_modal() {
            Lobibox.progress({
                title: 'Por favor, espere',
                label: 'Finalizando Periodo ...',
                closeButton: false,
                closeOnEsc: false,
                showProgressLabel: false,
                onShow: function ($this) {
                    var i = 0;
                    var inter = setInterval(function () {
                        if (i >= 100) {
                            inter = clearInterval(inter);
                        }
                        i = i + 0.1;
                        $this.setProgress(i);
                    }, 10);
                },
                progressCompleted: function () {
                    exito = true;
                    lobibox = $('.lobibox-progress').data('lobibox');
                }
            });
        }*/

        function finalizar_periodo_modal() {
            //$("#nombre_periodo_span").html($("#nombre_periodo_cell").html());
            $("#modal_fin_periodo").modal('show');
        }

        function finalizar_periodo() {
            document.getElementById("finalizar_periodo").submit();
            Lobibox.progress({
                title: 'Por favor, espere',
                label: 'Finalizando Periodo ...',
                closeButton: false,
                closeOnEsc: false,
                showProgressLabel: false,
                onShow: function ($this) {
                    var i = 0;
                    var inter = setInterval(function () {
                        if (i >= 100) {
                            inter = clearInterval(inter);
                        }
                        i = i + 0.1;
                        $this.setProgress(i);
                    }, 10);
                },
                progressCompleted: function () {
                    exito = true;
                    lobibox = $('.lobibox-progress').data('lobibox');
                }
            });
        }
    </script>
@endsection


@section("lobibox")
    @if(Session::has('error'))
        <script>
            notificacion("Error", "{{ Session::get('error') }}", "error");
            {{ Session::forget('error') }}
        </script>
    @elseif(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
@endsection