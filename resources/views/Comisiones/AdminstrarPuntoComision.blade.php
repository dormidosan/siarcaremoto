@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="box box-danger box-solid">
        <div class="box-header">
            <h3 class="box-title">Puntos de Comision</h3>
        </div>
        <div class="box-body">

            <form class="form-group" id="tratarPuntoComision" name="tratarPuntoComision" method="post" action=""
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Tipo documento</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option>Dictamen</option>
                                <option>Atestado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="documento">Seleccione documento</label>
                            <div class="file-loading">
                                <input id="documento" name="documento[]" type="file"
                                       placeholder="Seleccione documento a subir">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <button type="button" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Documentos asociados</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>Nombre Documento</th>
                                <th>Fecha de Subida</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Documento 1</td>
                                <td>01/01/2000</td>
                                <td><a class="btn btn-primary btn-xs">Descargar</a></td>
                            </tr>
                            <tr>
                                <td>Documento 1</td>
                                <td>01/01/2000</td>
                                <td><a class="btn btn-primary btn-xs">Descargar</a></td>
                            </tr>
                            <tr>
                                <td>Documento 1</td>
                                <td>01/01/2000</td>
                                <td><a class="btn btn-primary btn-xs">Descargar</a></td>
                            </tr>
                            <tr>
                                <td>Documento 1</td>
                                <td>01/01/2000</td>
                                <td><a class="btn btn-primary btn-xs">Descargar</a></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {
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
        });
    </script>
@endsection