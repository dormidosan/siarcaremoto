@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a>Gestionar Usuarios</a></li>
            <li><a class="active">Periodos AGU</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Definir Periodo AGU</h3>
        </div>
        <div class="box-body">
            <form id="periodo_agu" name="periodo_agu" method="post" action="{{ url("guardar_periodo") }}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group {{ $errors->has('nombre_periodo') ? 'has-error' : '' }}">
                            <label for="nombre_periodo">Periodo</label>
                            <input type="text" class="form-control" id="nombre_periodo" name="nombre_periodo"
                                   placeholder="Ingrese un nombre">
                            <span class="text-danger">{{ $errors->first('nombre_periodo') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group {{ $errors->has('inicio') ? 'has-error' : '' }}">
                            <label for="inicio">Fecha</label>
                            <div class="input-group date fecha">
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
                        <button type="submit" class="btn btn-success btn-block">Aceptar</button>
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
                            <td><a href="" class="btn btn-xs btn-info">Descargar</a></td>
                            @if($periodo->activo)
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger"
                                            onclick="finalizar_periodo({{ $periodo->id }})">Finalizar
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {

            $('.input-group.date.fecha').datepicker({
                format: "d-m-yyyy",
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });

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


        });

        function finalizar_periodo(periodo_id) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route("finalizar_periodo") }}",
                data: {"periodo_id": periodo_id},
                success: function (response) {
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                    setTimeout(function () {
                        window.location.href = "{{ route("periodos_agu") }}"
                    }, 900);

                }
            });

        }
    </script>
@endsection


@section("lobibox")
    @if(Session::has('error'))
        <script>
            notificacion("Error", "{{ Session::get('error') }}", "error");
        </script>
    @elseif(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
        </script>
    @endif
@endsection