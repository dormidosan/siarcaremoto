@extends('layouts.app')

@section("styles")
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">

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
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Busqueda de Documentos</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Busqueda de Documentos</h3>
        </div>
        <div class="box-body">

            <form id="buscarDocs" action="{{ url('buscar_documentos')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="form-group ">
                            <label>Nombre Documento</label>
                            <input type="text" class="form-control" placeholder="Ingrese nombre" id="nombre_documento"
                                   name="nombre_documento" value="{!! $nombre_documento !!}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-3">
                        <label>Tipo de Documento</label>
                            {!! Form::select('tipo_documento',$tipo_documentos,$tipo_documento,['id'=>'tipo_documento','class'=>'form-control','requiered'=>'requiered','placeholder'=>'seleccione tipo documento']) !!}
                    </div>

                    <div class="col-lg-3 col-sm-12 col-md-3">
                        <label>Periodo AGU</label>
                        {!! Form::select('periodo',$periodos,$periodo,['id'=>'periodo','class'=>'form-control','requiered'=>'requiered','placeholder'=>'seleccione periodo']) !!}
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea type="text" class="form-control" placeholder="Ingrese palabras clave"
                                      id="descripcion" name="descripcion" >{!! $descripcion !!}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div>
        <div class="box-body table-responsive">
            <table id="resultadoDocs"
                   class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nombre Documento</th>
                    <th>Tipo de Documento</th>
                    <th>Fecha Creacion</th>
                    <th>Accion</th>
                </tr>
                </thead>

                <tbody id="cuerpoTabla">

                @if(empty($documentos) != true)
                    @php $i=1 @endphp
                    @foreach($documentos as $documento)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $documento->nombre_documento }}</td>
                            <td>{{ $documento->tipo_documento->tipo }}</td>
                            <td>{{ $documento->fecha_ingreso }}</td>
                            <td>
                                <a class="btn btn-primary btn-xs "
                                   href="{{ asset($disco.''.$documento->path) }}"
                                   role="button" target="_blank"><i class="fa fa-eye"></i> Ver</a>
                                <a class="btn btn-success btn-xs"
                                   href="descargar_documento/<?= $documento->id; ?>" role="button">
                                    <i class="fa fa-download"></i> Descargar</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>


@endsection


@section("js")
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {
            var oTable = $('#resultadoDocs').DataTable({
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
        });
    </script>

@endsection