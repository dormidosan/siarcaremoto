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
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a href="{{route('listado_agenda_plenaria_jd')}}">Generar Agenda Plenaria</a></li>
            <li class="active">Subir Documento</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Subir Acta Plenaria</h3>
        </div>
        <div class="box-body">


            <form class="form-group" id="guardar_acta_plenaria" name="guardar_acta_plenaria" method="post"
                  action="{{ route('guardar_acta_plenaria') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="documento">Seleccione acta plenaria (1)</label>
                            <div class="file-loading">

                                <input id="documento_jd" name="documento_jd" type="file" required="required"
                                       data-show-preview="false" accept=".doc, .docx, .pdf">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label></label>
                            <input type="submit" class="btn btn-success" name="guardar" id="guardar" value="Aceptar">
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <br>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Listado de Archivos</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre documento</th>
                            <th>Tipo documento</th>
                            <th>Fecha ingreso</th>
                            <th>Opcion</th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoTabla" class="text-center">
                        @php $contador = 1 @endphp
                        @forelse($agenda->documentos as $documento)
                            @if($documento->tipo_documento_id == 5)
                                <tr>
                                    <td>
                                        {!! $contador !!}
                                        @php $contador++ @endphp
                                    </td>
                                    <td>{{$documento->nombre_documento}}</td>
                                    <td>{{$documento->tipo_documento->tipo}}</td>
                                    <td>{{$documento->fecha_ingreso}}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{ asset($disco.''.$documento->path) }}"
                                           role="button" target="_blank ">Ver</a>
                                        <a class="btn btn-success btn-xs"
                                           href="descargar_documento/<?= $documento->id; ?>"
                                           role="button">Descargar</a>
                                    </td>

                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5">No hay informacion que presentar</td>
                            </tr>
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
            $("#documento_jd").fileinput({
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
            }).on('change', function(event) {
                $('#guardar_acta_plenaria').formValidation('revalidateField', 'documento_jd');
            }).on('filecleared', function(event) {
                $('#guardar_acta_plenaria').formValidation('revalidateField', 'documento_jd');
            });

            $('#guardar_acta_plenaria').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    documento_jd: {
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