@extends('layouts.app')

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }
    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a href="{{ route("listado_reuniones_jd") }}">Reuniones</a></li>
            <li><a href="javascript:document.getElementById('continuar').submit();">Reunion {{ $reunion->codigo }}</a></li>
            <li class="active">Asignar a Comision - Peticion {{ $peticion->codigo }}</li>
        </ol>
    </section>
@endsection

@section("content")

    <div class="hidden">
        {!! Form::open(['route'=>['iniciar_reunion_jd'],'method'=> 'POST','id'=>'continuar']) !!}
        <input type="hidden" name="id_comision" id="id_comision"
               value="{{$reunion->comision_id}}">
        <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
        @if($reunion->activa == 0)
            <td>
                <button type="submit" class="btn btn-success btn-xs btn-block"><i
                            class="fa fa-arrow-right"></i> Iniciar
                </button>
            </td>
        @else
            <td>
                <button type="submit" class="btn btn-success btn-xs btn-block"><i
                            class="fa fa-arrow-right"></i> Continuar
                </button>
            </td>
        @endif
        {!! Form::close() !!}
    </div>
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Asignar a Comision</h3>
        </div>
        <div class="box-body">

            <form class="form-group" id="enlazar_comision" name="enlazar_comision" method="post"
                  action="{{ route('enlazar_comision') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
                <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Seleccione comision <span class="text-red">*</span></label>
                            {!! Form::select('comisiones',$comisiones,null, ['id'=>'comision>', 'class'=>'form-control', 'required'=>'required', 'placeholder' => 'Seleccione comision...']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="descripcion">Descripcion <span class="text-red">*</span></label>
                            <textarea name="descripcion" type="text" class="form-control" id="descripcion"
                                      placeholder="Ingrese una breve descripcion" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="Guardar" value="Asignar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <span class="text-muted"><em><span
                                            class="text-red">*</span> Indica campo obligatorio</em></span>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Comisiones asignadas</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-bordered table-hover text-center" id="tabla">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre comision</th>
                                <th>Fecha de asignacion</th>
                                <th>Descripcion</th>
                            </tr>
                            </thead>

                            <tbody id="cuerpoTabla">
                            @php $contador =1 @endphp @forelse($seguimientos as $seguimiento)
                                <tr>
                                    <td>
                                        {!! $contador !!} @php $contador++ @endphp
                                    </td>
                                    <td>
                                        <center>
                                            {!! $seguimiento->comision->nombre !!}
                                        </center>
                                    </td>
                                    <td>
                                        {!! $seguimiento->inicio !!}
                                    </td>
                                    <td>
                                        {!! $seguimiento->descripcion !!}
                                    </td>
                                </tr>
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

    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
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

            var table = $('#tabla').DataTable({
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Peticion no asociada a una comision",
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
                "searching": true,
                "order": [[0, 'asc'], [2, 'asc']],
                "displayLength": 25,
                "paging": true
            });

            $('#enlazar_comision').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    comisiones: {
                        validators: {
                            notEmpty: {
                                message: 'La comision es requerida'
                            }
                        }
                    },
                    descripcion: {
                        validators: {
                            notEmpty: {
                                message: 'La descripcion es requerido'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection