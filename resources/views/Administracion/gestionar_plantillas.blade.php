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
            <li><a>Administracion</a></li>
            <li><a class="active">Plantillas</a></li>
        </ol>
    </section>
@endsection

@section("content")
    @include("Modal.ActualizarPlantillaModal")

    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Plantillas del Sistema</h3>
        </div>
        <div class="box-body">
            <table id="parametros"
                   class="table table-striped table-bordered table-condensed table-hover text-center">
                <thead>
                <tr>
                    <th>Codigo plantilla</th>
                    <th>Nombre plantilla</th>
                    <th>Descargar</th>
                    <th>Actualizar</th>
                </tr>
                </thead>

                <tbody id="cuerpoTabla">
                @forelse($plantillas as $plantilla)
                    <tr>
                        <td>{!! $plantilla->codigo !!}</td>
                        <td>{!! $plantilla->nombre !!}</td>
                        <td>
                            <a class="btn btn-success btn-xs"
                               href="descargar_plantilla/<?= $plantilla->id; ?>" role="button">
                                <i class="fa fa-download"></i> Descargar</a>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-xs" onclick="mostrarModal({{$plantilla->id}})">
                                <i class="fa fa-pencil"></i> Actualizar
                            </button>
                        </td>

                    </tr>
                @empty
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('#actualizar_plantilla').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    plantilla: {
                        validators: {
                            notEmpty: {
                                message: 'Seleccione el documento con la nueva plantilla'
                            }
                        }
                    }
                }
            });

            $("#plantilla").fileinput({
                theme: "explorer",
                uploadAsync: false, //para enviar todos los archivos como uno solo
                language: "es",
                //minFileCount: 1,
                maxFileCount: 1,
                allowedFileExtensions: ['doc', 'docx', 'xls', 'xlsx', 'pdf'],
                fileActionSettings: {
                    //showZoom: false,
                    showRemove: false,
                    //showUpload: false
                    //showDrag: false
                },
                {{-- uploadUrl: "{{ route("agregar_plantillas") }}", uploadExtraData: {_token: "{{ csrf_token() }}"}--}}
                showUpload: false,
                showPreview: false,
                hideThumbnailContent: true,
                maxFileSize: 10000,
            }).on('change', function(event) {
                $('#actualizar_plantilla').formValidation('revalidateField', 'plantilla');
            }).on('filecleared', function(event) {
                $('#actualizar_plantilla').formValidation('revalidateField', 'plantilla');
            });
            // CATCH RESPONSE, usa si se envia por ajax con el boton q este js trae
            {{--$('#plantilla').on('filebatchuploaderror', function (event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;

            });

            $('#plantilla').on('filebatchuploadsuccess', function (event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                    response = data.response, reader = data.reader;
                notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                setTimeout(function () {
                    window.location.href = '{{ route("gestionar_plantillas") }}';
                }, 1000);

            });--}}
        });

        function mostrarModal(id) {
            document.getElementById("actualizar_plantilla").reset();
            $("#plantilla_id").attr('value',id);
            $("#actualizarPlantilla").modal('show');
        }
    </script>

@endsection