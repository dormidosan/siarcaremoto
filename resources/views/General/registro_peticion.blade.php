@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Peticiones</a></li>
            <li><a class="active">Registrar Peticiones</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Registrar Peticion</h3>
        </div>
        <div class="box-body">

            @if(!$peticion )
                <form id="registrar_peticion" name="registrar_peticion" method="post"
                      action="{{ route('registrar_peticion_post') }}" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input name="correo" type="email" class="form-control" id="correo"
                                       placeholder="Ingrese correo electronico" required>

                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="tel">Telefono</label>

                                <input name="telefono" type="tel" class="form-control" id="telefono"
                                       placeholder="Ingrese telefono" required>

                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="mail">Peticionario</label>

                                <input name="peticionario" type="text" class="form-control" id="peticionario"
                                       placeholder="Ingrese el peticionario" required>

                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="direccion">Direccion</label>
                                <textarea name="direccion" type="text" class="form-control" id="direccion"
                                          placeholder="Ingrese la direccion" required></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>

                                <textarea name="descripcion" type="text" class="form-control" id="descripcion"
                                          placeholder="Ingrese una breve descripcion" required></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group">
                                <label for="documento">Seleccione peticion (1)</label>
                                <div class="file-loading">

                                    <input id="documento_peticion" name="documento_peticion" type="file"
                                           required="required" accept=".doc, .docx, .pdf, .xls, .xlsx">

                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">


                            <div class="form-group">
                                <label for="documento">Seleccione atestados (1-3)</label>
                                <div class="file-loading">

                                    <input id="documento_atestado" name="documento_atestado[]" type="file" multiple
                                           required="required" accept=".doc, .docx, .pdf, .xls, .xlsx">

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->

                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-primary">Registrar Peticion</button>
                    </div>
                </form>

            @else

                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <a class="btn btn-danger" href="{{ route('registrar_peticion') }}" role="button" id="btn">Crear
                            nueva peticion</a>
                    </div>
                </div>
                <br>
                <div class="panel panel-danger">
                    <!-- Default panel contents -->
                    <div class="panel-body">
                        <form id="registrar_peticion_response" name="registrar_peticion_response" method="post"
                              action="#" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="codigo">Codigo de seguimiento</label>
                                        <input name="codigo" type="text" class="form-control" id="codigo"
                                               value="{{ $peticion->codigo }}" readonly
                                               style="color: #000000; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #95C9A3;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="mail">Correo</label>
                                        <input name="correo" type="email" class="form-control" id="mail"
                                               value="{{ $peticion->correo }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tel">Telefono</label>
                                        <input name="telefono" type="tel" class="form-control" id="telefono"
                                               value="{{ $peticion->telefono }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="mail">Peticionario</label>
                                        <input name="peticionario" type="text" class="form-control" id="peticionario"
                                               value="{{ $peticion->peticionario }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <textarea name="direccion" type="text" class="form-control" id="direccion"
                                                  readonly>{{ $peticion->direccion }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea name="descripcion" type="text" class="form-control" id="descripcion"
                                                  readonly>{{ $peticion->descripcion }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="resultadoDocs"
                               class="table table-striped table-bordered table-condensed table-hover dataTable text-center">
                            <thead>
                            <tr>
                                <th>Nombre Documento</th>
                                <th>Tipo de Documento</th>
                                <th>Fecha Creacion</th>
                                <th>Visualizar</th>
                                <th>Descargar</th>
                            </tr>
                            </thead>

                            <tbody id="cuerpoTabla">
                            @forelse($peticion->documentos as $documento)
                                <tr>
                                    <td>
                                        {!! $documento->nombre_documento !!}
                                    </td>
                                    <td>
                                        {!! $documento->tipo_documento->tipo !!}
                                    </td>
                                    <td>
                                        {!! $documento->fecha_ingreso !!}
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs btn-block"
                                           href="{{ asset($disco.''.$documento->path) }}"
                                           role="button"><i class="fa fa-eye"></i> Ver</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-xs btn-block"
                                           href="descargar_documento/<?= $documento->id; ?>"
                                           role="button"><i class="fa fa-download"></i> Descargar</a>
                                    </td>
                                </tr>
                            @empty
                                <p style="color: red ;">No hay criterios de busqueda</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            @endif
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
@endsection


@section("scripts")

    <script type="text/javascript">
        $(function () {
            $("#documento_peticion").fileinput({
                theme: "explorer",
                previewFileType: "pdf, xls, xlsx, doc, docx",
                language: "es",
                //minFileCount: 1,
                maxFileCount: 3,
                allowedFileExtensions: ['docx', 'doc', 'pdf', 'xls', 'xlsx'],
                showUpload: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true
            }).on('change', function (event) {
                $('#registrar_peticion').formValidation('revalidateField', 'documento_peticion');
            }).on('filecleared', function (event) {
                $('#registrar_peticion').formValidation('revalidateField', 'documento_peticion');
            });

            $("#documento_atestado").fileinput({
                theme: "explorer",
                previewFileType: "pdf, xls, xlsx, doc, docx",
                language: "es",
                //minFileCount: 1,
                maxFileCount: 3,
                allowedFileExtensions: ['docx', 'doc', 'pdf', 'xls', 'xlsx'],
                showUpload: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true
            }).on('change', function (event) {
                $('#registrar_peticion').formValidation('revalidateField', 'documento_atestado[]');
            }).on('filecleared', function (event) {
                $('#registrar_peticion').formValidation('revalidateField', 'documento_atestado[]');
            });

            $('#registrar_peticion').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
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
                    telefono: {
                        validators: {
                            notEmpty: {
                                message: 'El telefono es requerido'
                            },
                            regexp: {
                                message: 'El telefono solo puede contener numeros y -',
                                regexp: /^[0-9\s\-]+$/
                            }
                        }
                    },
                    peticionario: {
                        validators: {
                            notEmpty: {
                                message: 'El peticionario es requerido'
                            }
                        }
                    },
                    direccion: {
                        validators: {
                            notEmpty: {
                                message: 'La direccion del peticionario es requerida'
                            }
                        }
                    },
                    descripcion: {
                        validators: {
                            notEmpty: {
                                message: 'La descripcion de la peticion es requerida'
                            }
                        }
                    },
                    documento_peticion: {
                        validators: {
                            notEmpty: {
                                message: 'El documento de peticion es requerido'
                            }
                        }
                    },
                    "documento_atestado[]": {
                        validators: {
                            notEmpty: {
                                message: 'Documento(s) de atestado es(son) requerido(s)'
                            }
                        }
                    }
                }
            });

            $('#telefono').mask("0000-0000", {placeholder: "9999-9999"});
            $('#correo').mask('A', {
                'translation': {
                    A: {pattern: /[\w@\-.+]/, recursive: true}
                },
                placeholder: "ejemplo@gmail.com"
            });

        });

    </script>

@endsection