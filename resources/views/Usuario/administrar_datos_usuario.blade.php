@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/animate/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
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
                <form class="form" id="agregar_usuario">
                    {{ csrf_field() }}
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
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="primer_nombre">Primer Nombre</label>
                                        <input type="text" class="form-control" id="primer_nombre"
                                               name="primer_nombre" value="{{ $usuario->persona->primer_nombre }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="segundo_nombre">Segundo Nombre</label>
                                        <input type="text" class="form-control" id="segundo_nombre"
                                               name="segundo_nombre" value="{{ $usuario->persona->segundo_nombre }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="primer_apellido">Primer Apellido</label>
                                        <input type="text" class="form-control" id="primer_apellido"
                                               name="primer_apellido" value="{{ $usuario->persona->primer_apellido }}"
                                               readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="segundo_apellido">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="segundo_apellido"
                                               name="segundo_apellido" value="{{ $usuario->persona->segundo_apellido }}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="correo">Correo Electronico</label>
                                        <input type="email" class="form-control" id="correo" name="correo"
                                               value="{{ $usuario->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="dui">DUI</label>
                                        <input type="text" class="form-control" id="dui" name="dui"
                                               value="{{ $usuario->persona->dui }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="nit">NIT</label>
                                        <input type="text" class="form-control" id="nit" name="nit"
                                               value="{{ $usuario->persona->nit }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="fecha1">Fecha Nacimiento</label>
                                        <input name="fecha1" id="fecha1" type="text" class="form-control"
                                               value="{{ date("d-m-Y",strtotime($usuario->persona->nacimiento)) }}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="afp">AFP</label>
                                        <input type="text" class="form-control" id="afp" name="afp"
                                               value="{{ $usuario->persona->afp }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="cuenta">Cuenta Bancaria</label>
                                        <input type="text" class="form-control" id="cuenta" name="cuenta"
                                               value="{{ $usuario->persona->cuenta }}" readonly>
                                    </div>
                                </div>
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

    </script>
@endsection