@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }

        table.dataTable thead > tr > th {
            padding-right: 0 !important;
        }

    </style>
@endsection

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a href="{{ url("listado_reuniones_jd") }}">Listado de Reuniones</a></li>
            <li class="active">Subir Bitacora</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Subir Bitacora</h3>
        </div>
        <div class="box-body">
            <form class="form-group" id="guardar_bitacora_jd" name="guardar_bitacora_jd" method="post"
                  action="{{ url('guardar_bitacora_jd') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_comision" id="id_comision" value="{{$comision->id}}">
                <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="documento">Seleccione bitacora (1)</label>
                            <div class="file-loading">

                                <input id="documento_jd" name="documento_jd" type="file" required="required"
                                       data-show-preview="false" accept=".doc, .docx, .pdf, .xls, .xlsx">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 text-center">
                        <div class="form-group">
                            <label></label>
                            <input type="submit" class="btn btn-primary" name="guardar" id="guardar"
                                   value="Aceptar">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Listado de Archivos</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center table-bordered table-stripped" id="tabla">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre documento</th>
                            <th>Tipo documento</th>
                            <th>Fecha ingreso</th>
                            <th>Opcion</th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoTabla" class="text-center table-hover">
                        @php $contador = 1 @endphp
                        @forelse($reunion->documentos as $documento)
                            @if($documento->tipo_documento_id == 7)
                                <tr>
                                    <td>
                                        {!! $contador !!}
                                        @php $contador++ @endphp
                                    </td>
                                    <td>{{$documento->nombre_documento}}</td>
                                    <td>{{$documento->tipo_documento->tipo}}</td>
                                    <td>{{ date("d-m-Y h:i A",strtotime($documento->fecha_ingreso)) }}</td>
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
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
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
                $('#guardar_bitacora_jd').formValidation('revalidateField', 'documento_jd');
            }).on('filecleared', function(event) {
                $('#guardar_bitacora_jd').formValidation('revalidateField', 'documento_jd');
            });

            var oTable = $('#tabla').DataTable({
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                responsive: true,
                columnDefs: [{orderable: false, targets: [0, 4]}],
                order: [[1, 'asc']]

            });

            $('#guardar_bitacora_jd').formValidation({
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

@section("lobibox")

    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif

@endsection