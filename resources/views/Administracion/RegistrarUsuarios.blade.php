@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <style>
        .kv-avatar .krajee-default.file-preview-frame, .kv-avatar .krajee-default.file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }

        .kv-avatar {
            display: inline-block;
        }

        .kv-avatar .file-input {
            display: table-cell;
            width: 213px;
        }

        .kv-reqd {
            color: red;
            font-family: monospace;
            font-weight: normal;
        }

        .file-upload-indicator {
            visibility: hidden;
        }
    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a>Gestionar Usuarios</a></li>
            <li><a href="{{route("administracion_usuario")}}">Administrar Usuarios</a></li>
            <li class="active">Usuarios</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Usuarios</h3>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Actualizar Datos</a></li>
                    <li class="active"><a href="#tab_2-2" data-toggle="tab" aria-expanded="true">Agregar Usuario</a>
                    </li>
                    <li class="pull-left header"><i class="fa fa-th"></i> Opciones</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_1-1">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <select id="usuario" name="usuario" class="form-control"
                                            onchange="cargar_datos(this.value)">
                                        <option value="">-- Seleccione un usuario --</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}">{{ $usuario->persona->primer_nombre . " " . $usuario->persona->segundo_nombre . " " . $usuario->persona->primer_apellido . " " . $usuario->persona->segundo_apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="actualizar" class="hidden">
                            <form class="form" id="actualizar_usuario" method="post"
                                  action="{{ route("actualizar_usuario") }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row hidden">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="user_id_actualizar">User ID</label>
                                                    <input type="text" class="form-control"
                                                           id="user_id_actualizar"
                                                           name="user_id_actualizar" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="primer_nombre_actualizar">Primer Nombre</label>
                                                    <input type="text" class="form-control"
                                                           id="primer_nombre_actualizar"
                                                           name="primer_nombre_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group {{ $errors->has('segundo_nombre') ? 'has-error' : '' }}">
                                                    <label for="segundo_nombre_actualizar">Segundo Nombre</label>
                                                    <input type="text" class="form-control"
                                                           id="segundo_nombre_actualizar"
                                                           name="segundo_nombre_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="primer_apellido_actualizar">Primer Apellido</label>
                                                    <input type="text" class="form-control"
                                                           id="primer_apellido_actualizar"
                                                           name="primer_apellido_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="segundo_apellido_actualizar">Segundo Apellido</label>
                                                    <input type="text" class="form-control"
                                                           id="segundo_apellido_actualizar"
                                                           name="segundo_apellido_actualizar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="correo_actualizar">Correo Electronico</label>
                                                    <input type="email" class="form-control" id="correo_actualizar"
                                                           name="correo_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="dui_actualizar">DUI</label>
                                                    <input type="text" class="form-control" id="dui_actualizar"
                                                           name="dui_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="nit_actualizar">NIT</label>
                                                    <input type="text" class="form-control" id="nit_actualizar"
                                                           name="nit_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="fecha1_actualizar">Fecha Nacimiento</label>
                                                    <div class="input-group date fecha" id="fechaNacimiento_actualizar">
                                                        <input name="fecha1_actualizar" id="fecha1_actualizar"
                                                               type="text" class="form-control"><span
                                                                class="input-group-addon"><i
                                                                    class="glyphicon glyphicon-th"
                                                                    required="required"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="afp_actualizar">AFP</label>
                                                    <input type="text" class="form-control" id="afp_actualizar"
                                                           name="afp_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="cuenta_actualizar">Cuenta Bancaria</label>
                                                    <input type="text" class="form-control" id="cuenta_actualizar"
                                                           name="cuenta_actualizar">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="tipo_usuario_actualizar">Tipo Usuario</label>
                                                    <select id="tipo_usuario_actualizar" name="tipo_usuario_actualizar"
                                                            class="form-control"
                                                            onchange="mostrar_campos_asambleistas_actualizar(this.value)">
                                                        <option value="">Seleccione</option>
                                                        @foreach($tipos_usuario as $tipo)
                                                            <option value="{{$tipo->id}}">{{ ucwords($tipo->nombre_rol)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row hidden" id="row_campos_asambleistas_actualizar">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="sector_actualizar">Sector</label>
                                                    <select id="sector_actualizar" name="sector_actualizar"
                                                            class="form-control">
                                                        <option value="">Seleccione</option>
                                                        @foreach($sectores as $sector)
                                                            <option value="{{$sector->id}}">{{ ucwords($sector->nombre)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="facultad_actualizar">Facultad</label>
                                                    <select id="facultad_actualizar" name="facultad_actualizar"
                                                            class="form-control">
                                                        <option value="">Seleccione</option>
                                                        @foreach($facultades as $facultad)
                                                            <option value="{{$facultad->id}}">{{ ucwords($facultad->nombre)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="propietario_actualizar">Propietario</label>
                                                    <select id="propietario_actualizar" name="propietario_actualizar"
                                                            class="form-control" onchange="cambio_propietaria_dd(this.value)">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row hidden">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="cambio_propietaria">Cambio Propietaria</label>
                                                    <input type="text" class="form-control" id="cambio_propietaria"
                                                           name="cambio_propietaria" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <button type="submit" id="submitButtonUpdate" class="btn btn-primary">Aceptar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_2-2">
                        <form class="form" id="agregar_usuario" method="post" action="{{ route("guardar_usuario") }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-2 col-lg-2 text-center">
                                    <div class="form-group">
                                        <div class="kv-avatar">
                                            <div class="file-loading">
                                                <input id="foto" name="foto" type="file" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="primer_nombre">Primer Nombre</label>
                                                <input type="text" class="form-control" id="primer_nombre"
                                                       name="primer_nombre">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="segundo_nombre">Segundo Nombre</label>
                                                <input type="text" class="form-control" id="segundo_nombre"
                                                       name="segundo_nombre">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="primer_apellido">Primer Apellido</label>
                                                <input type="text" class="form-control" id="primer_apellido"
                                                       name="primer_apellido">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="segundo_apellido">Segundo Apellido</label>
                                                <input type="text" class="form-control" id="segundo_apellido"
                                                       name="segundo_apellido">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="correo">Correo Electronico</label>
                                                <input type="email" class="form-control" id="correo" name="correo">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="dui">DUI</label>
                                                <input type="text" class="form-control" id="dui" name="dui">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="nit">NIT</label>
                                                <input type="text" class="form-control" id="nit" name="nit">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="fecha1">Fecha Nacimiento</label>
                                                <div class="input-group date fecha" id="fechaNacimiento">
                                                    <input name="fecha1" id="fecha1" type="text"
                                                           class="form-control"><span
                                                            class="input-group-addon"><i class="glyphicon glyphicon-th"
                                                                                         required="required"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="afp">AFP</label>
                                                <input type="text" class="form-control" id="afp" name="afp">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="cuenta">Cuenta Bancaria</label>
                                                <input type="text" class="form-control" id="cuenta" name="cuenta">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="tipo_usuario">Tipo Usuario</label>
                                                <select id="tipo_usuario" name="tipo_usuario" class="form-control"
                                                        onchange="mostrar_campos_asambleistas(this.value)">
                                                    <option value="">Seleccione</option>
                                                    @foreach($tipos_usuario as $tipo)
                                                        <option value="{{$tipo->id}}">{{ ucwords($tipo->nombre_rol)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hidden" id="row_campos_asambleistas">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="sector">Sector</label>
                                                <select id="sector" name="sector" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    @foreach($sectores as $sector)
                                                        <option value="{{$sector->id}}">{{ ucwords($sector->nombre)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="facultad">Facultad</label>
                                                <select id="facultad" name="facultad" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    @foreach($facultades as $facultad)
                                                        <option value="{{$facultad->id}}">{{ ucwords($facultad->nombre)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="propietario">Propietario</label>
                                                <select id="propietario" name="propietario" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center">
                                <button type="submit" id="submitButton" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection


@section("scripts")

    <script type="text/javascript">

        var propietaria = "";

        $(function () {

            $('#dui').mask("00000000-0", {placeholder: "99999999-9"});
            $('#nit').mask("0000-000000-000-0", {placeholder: "9999-999999-999-9"});
            $('#afp').mask("000000000000", {placeholder: "999999999999"});
            $('#cuenta').mask("0000000000", {placeholder: "9999999999"});
            $('#correo').mask('A', {
                'translation': {
                    A: {pattern: /[\w@\-.+]/, recursive: true}
                },
                placeholder: "ejemplo@gmail.com"
            });
            $('#fecha1').mask("99-99-9999", {placeholder: "dd-mm-yyyy"});

            $('#usuario').select2({
                language: "es",
                width: '100%',
                allowClear: true
            });

            $("#foto").fileinput({
                language: "es",
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'Cancelar',
                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="{{ asset('images/default-user.png') }}" alt="Your Avatar" class="img-responsive">',
                //layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
                layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
                fileActionSettings: {
                    showRemove: false,
                    showUpload: false,
                    showZoom: false,
                    showDrag: false
                },
                "file-upload-indicator": false
            });

            $("#foto_actualizar").fileinput({
                language: "es",
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'Cancelar',
                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="{{ asset('images/default-user.png') }}" alt="Your Avatar" class="img-responsive">',
                //layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
                layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
                fileActionSettings: {
                    showRemove: false,
                    showUpload: false,
                    showZoom: false,
                    showDrag: false
                },
                "file-upload-indicator": false
            });

            $('#fechaNacimiento')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                }).on('changeDate', function (e) {
                // Revalidate the start date field
                $('#agregar_usuario').formValidation('revalidateField', 'fecha1');
            });

            $('#fechaNacimiento_actualizar')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                }).on('changeDate', function (e) {
                // Revalidate the start date field
                $('#actualizar_usuario').formValidation('revalidateField', 'fecha1_actualizar');
            });

            $('#agregar_usuario').formValidation({
                //initially validation for the fields with the option enabled as false is off, when the user type is
                //Asambleista their status is gonna change to true and furthermore their validation will start working
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    primer_nombre: {
                        validators: {
                            notEmpty: {
                                message: 'El primer nombre es requerido'
                            }
                        }
                    },
                    segundo_nombre: {
                        validators: {
                            notEmpty: {
                                message: 'El segundo nombre es requerido'
                            }
                        }
                    },
                    primer_apellido: {
                        validators: {
                            notEmpty: {
                                message: 'El primer apellido es requerido'
                            }
                        }
                    },
                    segundo_apellido: {
                        validators: {
                            notEmpty: {
                                message: 'El segundo apellido es requerido'
                            }
                        }
                    },
                    correo: {
                        validators: {
                            notEmpty: {
                                message: 'El correo electronico es requerido'
                            },
                            emailAddress: {
                                message: 'El valor ingresado no es un correo valido'
                            }
                        }
                    },
                    dui: {
                        validators: {
                            notEmpty: {
                                message: 'El DUI es requerido'
                            },
                            stringLength: {
                                min: 10,
                                message: 'El total de caracteres debe ser 10'
                            }
                        }
                    },
                    nit: {
                        validators: {
                            notEmpty: {
                                message: 'El NIT es requerido'
                            },
                            stringLength: {
                                min: 17,
                                message: 'El total de caracteres debe ser 17'
                            }
                        }
                    },
                    fecha1: {
                        validators: {
                            notEmpty: {
                                message: 'La fecha de nacimiento es requerida'
                            }
                        }
                    },
                    afp: {
                        validators: {
                            notEmpty: {
                                message: 'El AFP es requerido'
                            }
                        }
                    },
                    cuenta: {
                        validators: {
                            notEmpty: {
                                message: 'La cuenta bancaria es requerida'
                            }
                        }
                    },
                    tipo_usuario: {
                        validators: {
                            notEmpty: {
                                message: 'El tipo de usuario es requerido'
                            }
                        }
                    },
                    sector: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'El sector es requerido'
                            }
                        }
                    },
                    facultad: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'La facultad es requerida'
                            }
                        }
                    },
                    propietario: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'Tipo de propetaria es requerida'
                            }
                        }
                    }

                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                //var form = $("#agregar_usuario").serialize();
                var form = new FormData(document.getElementById("agregar_usuario"));

                $.ajax({
                    type: 'POST',
                    url: "{{ route('guardar_usuario') }}",
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.error == true) {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            $("#submitButton").prop("disabled", false);
                            $("#submitButton").removeClass("disabled");
                        } else {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            setTimeout(function () {
                                window.location.href = '{{ route("mostrar_formulario_registrar_usuario") }}';
                            }, 500);
                        }
                    }
                });
            });


            $('#actualizar_usuario').formValidation({
                //initially validation for the fields with the option enabled as false is off, when the user type is
                //Asambleista their status is gonna change to true and furthermore their validation will start working
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    primer_nombre_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El primer nombre es requerido'
                            }
                        }
                    },
                    segundo_nombre_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El segundo nombre es requerido'
                            }
                        }
                    },
                    primer_apellido_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El primer apellido es requerido'
                            }
                        }
                    },
                    segundo_apellido_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El segundo apellido es requerido'
                            }
                        }
                    },
                    correo_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El correo electronico es requerido'
                            },
                            emailAddress: {
                                message: 'El valor ingresado no es un correo valido'
                            }
                        }
                    },
                    dui_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El DUI es requerido'
                            },
                            stringLength: {
                                min: 10,
                                message: 'El total de caracteres debe ser 10'
                            }
                        }
                    },
                    nit_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El NIT es requerido'
                            },
                            stringLength: {
                                min: 17,
                                message: 'El total de caracteres debe ser 17'
                            }
                        }
                    },
                    fecha1_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'La fecha de nacimiento es requerida'
                            }
                        }
                    },
                    afp_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El AFP es requerido'
                            }
                        }
                    },
                    cuenta_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'La cuenta bancaria es requerida'
                            }
                        }
                    },
                    tipo_usuario_actualizar: {
                        validators: {
                            notEmpty: {
                                message: 'El tipo de usuario es requerido'
                            }
                        }
                    },
                    sector_actualizar: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'El sector es requerido'
                            }
                        }
                    },
                    facultad_actualizar: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'La facultad es requerida'
                            }
                        }
                    },
                    propietario_actualizar: {
                        validators: {
                            enabled: false,
                            notEmpty: {
                                message: 'Tipo de propetaria es requerida'
                            }
                        }
                    }

                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                var form = $("#actualizar_usuario").serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('actualizar_usuario') }}",
                    data: form,
                    success: function (response) {
                        if (response.error == true) {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            $("#submitButtonUpdate").prop("disabled", false);
                            $("#submitButtonUpdate").removeClass("disabled");
                        } else {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            setTimeout(function () {
                                window.location.href = '{{ route("mostrar_formulario_registrar_usuario") }}';
                            }, 500);
                        }
                    }
                });
            });

        });

        function cargar_datos(id) {
            $("#actualizar_usuario").data('formValidation').resetForm();
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: '{{ route('obtener_usuario') }}',
                data: {
                    'id': id
                },
                success: function (response) {
                    $("#user_id_actualizar").val(response.user_id);
                    $("#primer_nombre_actualizar").val(response.primer_nombre);
                    $("#segundo_nombre_actualizar").val(response.segundo_nombre);
                    $("#primer_apellido_actualizar").val(response.primer_apellido);
                    $("#segundo_apellido_actualizar").val(response.segundo_apellido);
                    $("#correo_actualizar").val(response.correo);
                    $("#dui_actualizar").val(response.dui);
                    $("#nit_actualizar").val(response.nit);
                    $("#fecha1_actualizar").val(response.fecha);
                    $("#afp_actualizar").val(response.afp);
                    $("#cuenta_actualizar").val(response.cuenta);
                    $("#tipo_usuario_actualizar").val(response.tipo);
                    if (response.tipo == 3) {
                        $("#row_campos_asambleistas_actualizar").removeClass('hidden');
                        $("#sector_actualizar").val(response.sector);
                        $("#facultad_actualizar").val(response.facultad);
                        $("#propietario_actualizar").val(response.propietario);
                        propietaria = response.propietario;
                    }
                    else {
                        $("#row_campos_asambleistas_actualizar").addClass('hidden');
                    }
                    $("#actualizar").removeClass('hidden');
                }
            });
        }

        function mostrar_campos_asambleistas(tipo_usuario) {
            if (tipo_usuario == 3) {
                $("#row_campos_asambleistas").removeClass("hidden");
                $('#agregar_usuario').formValidation('enableFieldValidators', 'sector', true);
                $('#agregar_usuario').formValidation('enableFieldValidators', 'facultad', true);
                $('#agregar_usuario').formValidation('enableFieldValidators', 'propietario', true);
            }
            else {
                $("#row_campos_asambleistas").addClass("hidden");
                $('#agregar_usuario').formValidation('enableFieldValidators', 'sector', false);
                $('#agregar_usuario').formValidation('enableFieldValidators', 'facultad', false);
                $('#agregar_usuario').formValidation('enableFieldValidators', 'propietario', false);
            }
        }

        function mostrar_campos_asambleistas_actualizar(tipo_usuario) {
            if (tipo_usuario == 3) {
                $("#row_campos_asambleistas_actualizar").removeClass("hidden");
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'sector_actualizar', true);
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'facultad_actualizar', true);
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'propietario_actualizar', true);
            }
            else {
                $("#row_campos_asambleistas_actualizar").addClass("hidden");
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'sector_actualizar', false);
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'facultad_actualizar', false);
                $('#actualizar_usuario').formValidation('enableFieldValidators', 'propietario_actualizar', false);
            }
        }

        function cambio_propietaria_dd(value) {
            if(value != propietaria){
                //se cambio el tipo que tenia
                //$("#cambio_propietaria").val("1");
                $('#cambio_propietaria').attr("value", "1");
            }else{
                //no cambio, o se volvio a colocar el mismo que tenia originalmente
                //$("#cambio_propietaria").val("0");
                $('#cambio_propietaria').attr("value", "0");
            }
        }
    </script>

@endsection
