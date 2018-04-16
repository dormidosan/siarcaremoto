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
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a class="active">Listado de Peticiones JD</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Listado de Peticiones JD</h3>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="tabla" class="table text-center table-striped table-bordered table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Fecha de creación</th>
                        {{-- <th>Fecha actual</th> --}}
                        <th>Peticionario</th>
                        <th>Ultima asignacion</th>
                        <th>Visto anteriormente por</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody id="cuerpoTabla" class="table-hover">
                    @php $contador =1 @endphp
                    @forelse($peticiones as $peticion)
                        <tr>
                            <td>
                                {!! $contador !!}
                                @php $contador++ @endphp
                            </td>
                            <td>
                                {!! $peticion->codigo !!}
                            </td>
                            <td>
                                {!! $peticion->descripcion !!}
                            </td>
                            <td>{{ date("m-d-Y h:i A",strtotime($peticion->fecha)) }}</td>
                            <td>
                                {!! $peticion->peticionario !!}
                            </td>
                            <td>
                                @php
                                    $i = ''
                                @endphp
                                @foreach($peticion->seguimientos as $seguimiento)
                                    @if($seguimiento->estado_seguimiento->estado == 'as')
                                        @php
                                            $i = $seguimiento->comision->nombre
                                        @endphp
                                    @endif
                                @endforeach
                                {!! $i !!}
                            </td>
                            <td>
                                @php
                                    $i = ''
                                @endphp
                                @foreach($peticion->seguimientos as $seguimiento)
                                    @if($seguimiento->estado_seguimiento->estado !== 'cr' and $seguimiento->estado_seguimiento->estado !== 'se' and $seguimiento->estado_seguimiento->estado !== 'as')
                                        @php
                                            $i = $seguimiento->comision->nombre
                                        @endphp
                                    @endif
                                @endforeach
                                {!! $i !!}
                            </td>
                                @if($peticion->resuelto == 1)
                                    <td class="success">
                                        Resuelto
                                    </td>
                                @else
                                    @if($peticion->comision == 1)
                                        <td class="warning">
                                        En comision
                                        </td>
                                    @else
                                        @if($peticion->asignado_agenda == 1)
                                            <td class="info">
                                            Agendado
                                            </td>
                                        @else
                                            <td class="danger">
                                            No revisado
                                            </td>
                                        @endif
                                    @endif
                                    
                                @endif
                                

                                
                            
                            <td class="row">
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    {!! Form::open(['route'=>['seguimiento_peticion_jd'],'method'=> 'POST','id'=>$peticion->id.'1']) !!}
                                    <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
                                    <input type="hidden" name="es_reunion" id="es_reunion" value="0">
                                    <button type="submit" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> Ver
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    {!! Form::open(['route'=>['subir_documento_jd'],'method'=> 'POST','id'=>$peticion->id.'2']) !!}
                                    <input type="hidden" name="id_comision" id="id_comision" value="1">
                                    <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
                                    <button type="submit" class="btn btn-info btn-xs">
                                        <i class="fa fa-upload"></i> Subir documentacion
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>

                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
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
                'rowsGroup': [7],
                responsive: true,
                /*searching: false,
                paging: false,*/
                columnDefs: [{orderable: false, targets: [1, 2, 3, 4, 5, 6, 7]}],
                order: [[0, 'asc']]
            });
        });
    </script>
@endsection

