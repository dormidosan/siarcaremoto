@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">

    <style>
        table tbody tr td {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a>Gestionar Usuarios</a></li>
            <li class="active">Administrar Usuarios</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Administracion Usuarios</h3>
        </div>
        <div class="box-body">
            <h4 class="text-center text-bold"><span><i class="fa fa-info-circle"></i></span> Seleccione una opcion para
                continuar</h4>
            <br>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="box" style="border-top-color: rgb(57, 204, 204) !important;">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-user-plus fa-4x text-teal"></i>
                            </div>
                            <h3 class="profile-username text-center">Registrar Usuarios</h3>
                            <a class="btn bg-teal btn-block btn-sm"
                               href="{{route("mostrar_formulario_registrar_usuario")}}"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-file fa-4x text-danger"></i>
                            </div>
                            <h3 class="profile-username text-center">Estados Asambleistas</h3>
                            <a class="btn btn-danger btn-block btn-sm"
                               href="{{route("baja_asambleista")}}"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-key fa-4x text-warning"></i>
                            </div>
                            <h3 class="profile-username text-center">Administrar Perfiles</h3>
                            <a class="btn btn-warning btn-block btn-sm"
                               href="{{route("cambiar_perfiles")}}"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-user fa-4x text-success"></i>
                            </div>
                            <h3 class="profile-username text-center">Administrar Cargos de Comision</h3>
                            <a class="btn btn-success btn-block btn-sm" href="{{route("cambiar_cargos_comision")}}"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-users fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">Administracion Cargos de Junta Directiva</h3>
                            <a class="btn btn-info btn-block btn-sm" href="{{route("cambiar_cargos_junta_directiva")}}"><b>Acceder</b></a>
                        </div>
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

            $("#excel").fileinput({
                browseClass: "btn btn-primary btn-block",
                previewFileType: ".xls,.xlsx",
                theme: "explorer",
                //uploadUrl: "/file-upload-batch/2",
                language: "es",
                minFileCount: 1,
                maxFileCount: 1,
                allowedFileExtensions: ['xls', 'xlsx'],
                showUpload: false,
                showPreview: false,
                showCaption: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true
            });

        });
    </script>
@endsection