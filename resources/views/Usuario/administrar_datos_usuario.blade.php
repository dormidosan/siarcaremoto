@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/animate/animate.css') }}">
<link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
<link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
<link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
<style>
.password-progress {
    margin-top: 10px;
    margin-bottom: 0;
}
</style>
@endsection


@section('breadcrumb')
<section>
    <ol class="breadcrumb">
        <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Datos de Usuario</li>
    </ol>
</section>
@endsection

@section("content")
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs pull-right">
        @if( (Auth::user()->rol_id == 3) or (Auth::user()->rol_id == 4))
        <li class=""><a href="#tab_3-3" data-toggle="tab" aria-expanded="false">Actualizar hoja de vida</a></li>
        @endif
        <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Actualizar Contraseña</a></li>
        <li class="active"><a href="#tab_2-2" data-toggle="tab" aria-expanded="true">Datos Generales</a></li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab_1-1">

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Atencion</h4>
                Para hacer efectivos los cambios, el sistema cerrara la
                sesion y debe de loguarse en el sistema nuevamente
            </div>

            <form id="passwordForm" method="post" class="form-horizontal">
                <div class="hidden">
                    <label class="col-xs-3 control-label">Contraseña</label>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" name="id_user" value="{{ Auth::user()->id }}"/>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Contraseña</label>
                    <div class="col-xs-6">
                        <input type="password" class="form-control" name="password"/>

                        <div class="progress password-progress">
                            <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-3 control-label">Repetir Contraseña</label>
                    <div class="col-xs-6">
                        <input type="password" class="form-control" name="repeated_password"/>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="col-xs-5 col-xs-offset-3">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="tab-pane active" id="tab_2-2">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @if(Auth::user()->persona->foto == "")
                    <img src="{{ asset('images/default-user.png')  }}" class="img-responsive center-block"
                    style="height: 130px !important;"
                    onclick="mostrarImagen('{{ Auth::user()->persona->foto }}')">
                    @else
                    <img src="{{ asset('../storage/fotos/'.Auth::user()->persona->foto) }}"
                    class="img-responsive img-circle center-block"
                    style="height: 130px !important;"
                    alt="User Image" onclick="mostrarImagen('{{ Auth::user()->persona->foto }}')">
                    @endif
                </div>
            </div>

            <form class="form" id="actualizar_datos" method="post" action="{{ route("actualizar_datos") }}">
                {{ csrf_field() }}
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row hidden">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="user_id_actualizar">User ID</label>
                                    <input type="text" class="form-control"
                                    id="user_id_actualizar"
                                    name="user_id_actualizar" value="{{ $usuario->id }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="primer_nombre_actualizar">Primer Nombre</label>
                                    <input type="text" class="form-control"
                                    id="primer_nombre_actualizar"
                                    name="primer_nombre_actualizar" value="{{ $usuario->persona->primer_nombre }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group {{ $errors->has('segundo_nombre') ? 'has-error' : '' }}">
                                    <label for="segundo_nombre_actualizar">Segundo Nombre</label>
                                    <input type="text" class="form-control"
                                    id="segundo_nombre_actualizar"
                                    name="segundo_nombre_actualizar" value="{{ $usuario->persona->segundo_nombre }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="primer_apellido_actualizar">Primer Apellido</label>
                                    <input type="text" class="form-control"
                                    id="primer_apellido_actualizar"
                                    name="primer_apellido_actualizar" value="{{ $usuario->persona->primer_apellido }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="segundo_apellido_actualizar">Segundo Apellido</label>
                                    <input type="text" class="form-control"
                                    id="segundo_apellido_actualizar"
                                    name="segundo_apellido_actualizar" value="{{ $usuario->persona->segundo_apellido }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="correo_actualizar">Correo Electronico</label>
                                    <input type="email" class="form-control" id="correo_actualizar"
                                    name="correo_actualizar" value=" {{ $usuario->email }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="dui_actualizar">DUI</label>
                                    <input type="text" class="form-control" id="dui_actualizar"
                                    name="dui_actualizar" value="{{ $usuario->persona->dui }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nit_actualizar">NIT</label>
                                    <input type="text" class="form-control" id="nit_actualizar"
                                    name="nit_actualizar" value="{{ $usuario->persona->nit }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="fecha1_actualizar">Fecha Nacimiento</label>
                                    <div class="input-group date fecha" id="fechaNacimiento_actualizar">
                                        <input name="fecha1_actualizar" id="fecha1_actualizar"
                                        type="text" class="form-control" value="{{ date("d-m-Y",strtotime($usuario->persona->nacimiento)) }}"><span
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
                                    name="afp_actualizar" value="{{ $usuario->persona->afp }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="cuenta_actualizar">Cuenta Bancaria</label>
                                    <input type="text" class="form-control" id="cuenta_actualizar"
                                    name="cuenta_actualizar" value="{{ $usuario->persona->cuenta }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <button type="submit" id="submitButtonUpdate" class="btn btn-primary">Actualizar Datos
                    </button>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tab_3-3">

            <form class="form" id="actualizar_datos" method="post" action="{{ route('actualizar_hoja') }}" enctype="multipart/form-data">
             {{ csrf_field() }}
             <br>
             <input type="hidden" name="id_asambleista" id="id_asambleista" value="{{$asambleista->id}}">
             <div class="row">
                <div class="col-lg-12">
                    <table id="parametros"
                    class="table table-striped table-bordered table-condensed table-hover text-center">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <tr>
                            @if($asambleista->hoja_id)
                                <td width="10%">{{ $asambleista->hoja->nombre }}</td>
                            @else
                                <td width="10%">N/A</td>
                            @endif
                            <td>{{ $asambleista->user->persona->primer_nombre . " " . $asambleista->user->persona->segundo_nombre . " " . $asambleista->user->persona->primer_apellido . " " . $asambleista->user->persona->segundo_apellido }}</td>
                            <td>
                                @if($asambleista->hoja_id)
                                <a  class="btn btn-success btn-xs"
                                href="<?= $disco . $asambleista->hoja->path; ?>"
                                role="button">Ver</a>
                                @else
                                <a disabled class="btn btn-info btn-xs"
                                href="#"
                                role="button">Ver</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-8">    
            <div class="form-group">
                <label for="documento">Seleccione documento (1) PDF</label>
                <div class="file-loading">

                    <input id="hoja_vida" name="hoja_vida" type="file" required="required"
                    data-show-preview="false"  accept=".pdf">
                </div>

            </div>
        </div>
        <div class="col-lg-4">
           <div class="row text-center">
            <button type="submit" id="submitButtonUpdate" class="btn btn-primary">Actualizar documento
            </button>
        </div>
    </div>
</div>

</form>
</div>
</div>
<!-- /.tab-content -->
</div>

@include("Modal.MostrarImagenModal")
@endsection

@section("js")
<script src="{{ asset('libs/utils/utils.js') }}"></script>
<script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
<script src="{{ asset('libs/zxcvbn/zxcvbn.js') }}"></script>
<script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
<script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
<script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
<script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
<script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
<script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
@endsection


@section("scripts")
<script type="text/javascript">

        //es el metodo usado para extender el objeto jquery prototipe o $.fn lo q hace es q se le añade un metodo
        //a este objeto q hace posible q sea accedido de cualquier parte del DOM
        $.fn.extend({
            animateCss: function (animationName) {
                var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                //con one se detecta cuando ha terminado una animacion y al pasar eso se le quitara la clase de animacion, para q en posterior ocasion se le vuelva agregar
                this.addClass('animated ' + animationName).one(animationEnd, function () {
                    $(this).removeClass('animated ' + animationName);
                });
            }
        });

        function traducir_mensajes_contraseñas(mensajeOriginal) {
            var mensajeTraducido = "";
            var mensajes = {
                'Repeats like \"aaa"\ are easy to guess': 'Repeticiones como "aaa" son faciles de adivinar',
                'Repeats like \"abcabcabc"\ are only slightly harder to guess than "abc"': 'Repeticiones como "abcabcabc" son igual de faciles de adivinar que "abc"',
                'Sequences like abc or 6543 are easy to guess': 'Secuencias como abc o 6543 son faciles de adivinar',
                'Recent years are easy to guess': 'Años recientes son faciles de adivinar',
                'Dates are often easy to guess': 'Fechas son faciles de adivinar',
                'This is similar to a commonly used password': 'Contraseña similar a las comunmente usadas',
                'This is a top-10 common password': 'Esta es una de las 10 contraseñas comunente usadas',
                'This is a top-100 common password': 'Esta es una de las 100 contraseñas comunente usadas',
                'This is a very common password': 'Esta es una contraseña comun',
                'A word by itself is easy to guess': 'Una palabra es facil de adivinar',
                'Names and surnames by themselves are easy to guess': 'Nombres y apellidos son faciles de adivinar',
                "Common names and surnames are easy to guess": 'Nombres y apellidos comunes son faciles de adivinar',
                "Reversed words aren't much harder to guess": 'Palabras invertidas son faciles de adivinar',
                "Predictable substitutions like '@' instead of 'a' don't help very much": 'Sustitucion predecible de caracteres como @ por a hacen una contraseña debil'
            };
            return mensajes[mensajeOriginal];
        }

        $(function () {

            var nowDate = new Date();
            var today = nowDate.getDate()+'-'+(nowDate.getMonth()+1)+'-'+nowDate.getFullYear();

            $('#dui').mask("00000000-0", {placeholder: "99999999-9"});
            $('#dui_actualizar').mask("00000000-0", {placeholder: "99999999-9"});
            $('#nit').mask("0000-000000-000-0", {placeholder: "9999-999999-999-9"});
            $('#nit_actualizar').mask("0000-000000-000-0", {placeholder: "9999-999999-999-9"});
            $('#afp').mask("000000000000", {placeholder: "999999999999"});
            $('#afp_actualizar').mask("000000000000", {placeholder: "999999999999"});
            $('#cuenta').mask("0000000000", {placeholder: "9999999999"});
            $('#cuenta_actualizar').mask("0000000000", {placeholder: "9999999999"});
            $('#correo').mask('A', {
                'translation': {
                    A: {pattern: /[\w@\-.+]/, recursive: true}
                },
                placeholder: "ejemplo@gmail.com"
            });
            $('#correo_actualizar').mask('A', {
                'translation': {
                    A: {pattern: /[\w@\-.+]/, recursive: true}
                },
                placeholder: "ejemplo@gmail.com"
            });
            $('#fecha1').mask("99-99-9999", {placeholder: "dd-mm-yyyy"});
            $('#fecha1_actualizar').mask("99-99-9999", {placeholder: "dd-mm-yyyy"});

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
                $('#actualizar_datos').formValidation('revalidateField', 'fecha1_actualizar');
            });

            $('#passwordForm').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'La contraseña es requerida'
                            },
                            stringLength: {
                                min: 10,
                                message: 'La contraseña debe de tener al menos 10 caracteres'
                            },
                            /*identical: {
                                field: 'repeated_password',
                                message: 'La contraseña y su confirmacion no son iguales'
                            },*/
                            callback: {
                                callback: function (value, validator, $field) {
                                    var password = $field.val();
                                    if (password == '') {
                                        return true;
                                    }

                                    var result = zxcvbn(password),
                                    score = result.score,
                                    message = traducir_mensajes_contraseñas(result.feedback.warning) || 'La contraseña es debil';

                                    // Update the progress bar width and add alert class
                                    var $bar = $('#strengthBar');
                                    switch (score) {
                                        case 0:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '1%');
                                        break;
                                        case 1:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '25%');
                                        break;
                                        case 2:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '50%');
                                        break;
                                        case 3:
                                        $bar.attr('class', 'progress-bar progress-bar-warning')
                                        .css('width', '75%');
                                        break;
                                        case 4:
                                        $bar.attr('class', 'progress-bar progress-bar-success')
                                        .css('width', '100%');
                                        break;
                                    }

                                    // We will treat the password as an invalid one if the score is less than 3
                                    if (score < 3) {
                                        return {
                                            valid: false,
                                            message: message
                                        }
                                    }

                                    return true;
                                }
                            }
                        }
                    },
                    repeated_password: {
                        validators: {
                            notEmpty: {
                                message: 'La contraseña de confirmacion es requerida'
                            },
                            identical: {
                                field: 'password',
                                message: 'La contraseña y su confirmacion no son iguales'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                data = $("#passwordForm").serialize();

                $.ajax({
                    //se envia un token, como medida de seguridad ante posibles ataques
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('actualizar_contraseña') }}",
                    data: data,
                    success: function (response) {
                        $("#passwordForm").get(0).reset();
                        $("#passwordForm").data('formValidation').resetForm();
                        $('#strengthBar').attr('class', 'progress-bar progress-bar-danger').css('width', '0%');
                        notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                        setTimeout(function () {
                            window.location.href = '{{ url("logout") }}';
                        }, 500);
                    }
                });
            });

            $('#actualizar_datos').formValidation({
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
                            },
                            date: {
                                format: 'DD-MM-YYYY',
                                max: today,
                                message: 'Fecha de inicio no puede ser mayor que '+today
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
                    }
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                var form = $("#actualizar_datos").serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('actualizar_datos') }}",
                    data: form,
                    success: function (response) {
                        if (response.error == true) {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            $("#submitButtonUpdate").prop("disabled", false);
                            $("#submitButtonUpdate").removeClass("disabled");
                        } else {
                            notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                            setTimeout(function () {
                                window.location.href = '{{ route("mostrar_datos_usuario") }}';
                            }, 500);
                        }
                    }
                });
            });
        });

$('#actualizar_imagen').formValidation({
    framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        img: {
            validators: {
                notEmpty: {
                    message: 'Seleccione la nueva imagen de perfil'
                }
            }
        }
    }
}).on('success.form.fv', function (e) {
            // Prevent form submission
            e.preventDefault();

            //var form = $("#agregar_usuario").serialize();
            var form = new FormData(document.getElementById("actualizar_imagen"));

            $.ajax({
                type: 'POST',
                url: "{{ route('actualizar_imagen') }}",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    $('#imagenModal').modal('hide');
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                    setTimeout(function () {
                        window.location.href = '{{ route("mostrar_datos_usuario") }}';
                    }, 500);

                }
            });
        });

$("#img").fileinput({
    theme: "explorer",
            uploadAsync: false, //para enviar todos los archivos como uno solo
            language: "es",
            //minFileCount: 1,
            maxFileCount: 1,
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            fileActionSettings: {
                //showZoom: false,
                showRemove: true,
                //showUpload: false
                //showDrag: false
            },
            {{-- uploadUrl: "{{ route("agregar_plantillas") }}", uploadExtraData: {_token: "{{ csrf_token() }}"}--}}
            showUpload: false,
            showPreview: false,
            hideThumbnailContent: true,
            maxFileSize: 10000,
        }).on('change', function (event) {
            $('#actualizar_imagen').formValidation('revalidateField', 'img');
        }).on('filecleared', function (event) {
            $('#actualizar_imagen').formValidation('revalidateField', 'img');
        });

        $('.img-circle').mousemove(function () {
            $(this).animateCss('pulse');
        });

        function mostrarImagen(imagen) {
            $("#actualizar_imagen").get(0).reset();
            $("#actualizar_imagen").data('formValidation').resetForm();
            if (imagen != "") {
                $('#image').attr("src", "{{ asset('../storage/fotos/'.Auth::user()->persona->foto) }}");
            }
            $('#imagenModal').modal('show');
        }

        $(function () {
            $("#hoja_vida").fileinput({
                theme: "explorer",
                previewFileType: "pdf, xls, xlsx, doc, docx",
                language: "es",
                //minFileCount: 1,
                maxFileCount: 1,
                allowedFileExtensions: ['docx', 'doc', 'pdf', 'xls', 'xlsx'],
                showUpload: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true
            }).on('change', function(event) {
                $('#guardar_hoja_vida').formValidation('revalidateField', 'hoja_vida');
            }).on('filecleared', function(event) {
                $('#guardar_hoja_vida').formValidation('revalidateField', 'hoja_vida');
            });

            $('#guardar_hoja_vida').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    tipo_documentos: {
                        validators: {
                            notEmpty: {
                                message: 'El tipo de documento es requerido'
                            }
                        }
                    },
                    hoja_vida: {
                        validators: {
                            notEmpty: {
                                message: 'El documento es requerido'
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
        {{Session::forget('success')}}
    </script>
@endif 
@endsection