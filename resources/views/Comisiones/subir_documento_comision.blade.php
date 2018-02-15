@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a></li>
            <li><a href="javascript:document.getElementById('listado_peticiones_comision').submit();">Listado de Peticiones</a></li>
            <li class="active">Subir Documento</li>
        </ol>
    </section>
@endsection

@section("content")

    <div class="hidden">
        <form id="trabajo_comision" name="trabajo_comision" method="post"
              action="{{ route("trabajo_comision") }}">
            {{ csrf_field() }}
            <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
            <button class="btn btn-success btn-xs">Acceder</button>
        </form>

        <form id="listado_peticiones_comision" name="listado_peticiones_comision"
              method="post" action="{{ route("listado_peticiones_comision") }}">
            {{ csrf_field() }}
            <div class="text-center">
                <i class="fa fa-file-text-o fa-4x text-info"></i>
            </div>
            <h3 class="profile-username text-center">Peticiones</h3>
            <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
            <button type="submit" class="btn btn-info btn-block btn-sm"><b>Acceder</b></button>
        </form>
    </div>

    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Subir documento</h3>
        </div>
        <div class="box-body">
            <form class="form-group" id="guardar_documento_comision" name="guardar_documento_comision" method="post"
                  action="{{ route('guardar_documento_comision') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
                <input type="hidden" name="id_comision" id="id_comision" value="{{$comision->id}}">
                @if($is_reunion == 0)
                    <input type="hidden" name="id_reunion" id="id_reunion" value="0">
                @else
                    <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                @endif
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Seleccione Tipo Documento</label>
                            {!! Form::select('tipo_documentos',$tipo_documentos,null,['id'=>'tipo_documentos', 'class'=>'form-control', 'required'=>'required', 'placeholder' => 'Seleccione tipo...']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="documento">Seleccione documento (1)</label>
                            <div class="file-loading">

                                <input id="documento_comision" name="documento_comision" type="file" required="required"
                                       data-show-preview="false" accept=".doc, .docx, .pdf, .xls, .xlsx">
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" name="Guardar" id="Guardar" value="Guardar">
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Fecha inicio</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" value="{{ $peticion->fecha }}"
                               readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Fecha Actual</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ Carbon\Carbon::now() }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Peticionario</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->peticionario }}" readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Direccion</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->direccion }}" readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Correo</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->correo }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea class="form-control" readonly>{{ $peticion->descripcion }}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Seguimiento paso a paso</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre comision</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Descripcion</th>
                                <th>Documento</th>
                                <th>Opcion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpoTabla" class="text-center">
                            @php $contador = 1 @endphp
                            @forelse($peticion->seguimientos as $seguimiento)
                                <tr>
                                    <td>
                                        {!! $contador !!}
                                        @php $contador++ @endphp
                                    </td>
                                    <td>{{ $seguimiento->comision->nombre }}</td>
                                    <td>{{ $seguimiento->inicio }}</td>
                                    <td>{{ $seguimiento->fin }}</td>
                                    <td>{{ $seguimiento->descripcion }}</td>
                                    @if($seguimiento->documento)
                                        <td>{{ $seguimiento->documento->tipo_documento->tipo }}</td>
                                        <td>
                                            <a class="btn btn-info btn-xs"
                                               href="{{ asset($disco.''.$seguimiento->documento->path) }}"
                                               role="button" target="_blank ">Ver</a>
                                            <a class="btn btn-success btn-xs"
                                               href="descargar_documento/<?= $seguimiento->documento->id; ?>"
                                               role="button">Descargar</a>
                                        </td>
                                    @else
                                        <td>
                                            N/A
                                        </td>
                                        <td>
                                            Sin documento
                                        </td>
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
@endsection

@section("scripts")

    <script type="text/javascript">
        $(function () {
            $("#documento_comision").fileinput({
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
                $('#guardar_documento_comision').formValidation('revalidateField', 'documento_comision');
            }).on('filecleared', function(event) {
                $('#guardar_documento_comision').formValidation('revalidateField', 'documento_comision');
            });

            $('#guardar_documento_comision').formValidation({
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
                    documento_comision: {
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
    @if(Session::has('error'))
        <script>
            notificacion("Error", "{{ Session::get('error') }}", "error");
            {{ Session::forget('Error') }}
        </script>
    @elseif(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
@endsection