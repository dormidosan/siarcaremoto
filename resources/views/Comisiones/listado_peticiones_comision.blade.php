@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">

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
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a></li>
            <li class="active">Listado de Peticiones</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Listado de Peticiones de {{ ucwords($comision->nombre) }}</h3>
        </div>
        <div class="box-body">
            <div class="hidden">
                <form id="trabajo_comision" name="trabajo_comision" method="post"
                      action="{{ route("trabajo_comision") }}">
                    {{ csrf_field() }}
                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                    <button class="btn btn-success btn-xs">Acceder</button>
                </form>
            </div>
            <div class="table-responsive">
                <table id="tabla" class="table text-center table-striped table-bordered table-hover table-condensed display" style="width: 100%">
                    <thead>
                    <tr>
                        <th colspan="7"></th>
                        <th colspan="3">Accion</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Fecha de creación</th>
                        <th>Peticionario</th>
                        <th>Ultima asignacion</th>
                        <th>Visto anteriormente por</th>
                        <th>Ver</th>
                        <th>Subir Documento</th>
                        <th>Retirar Peticion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $contador =1 @endphp
                    @foreach($peticiones as $peticion)
                        <tr>
                            <td>{!! $contador !!}</td>
                            <td>{{ $peticion->codigo }}</td>
                            <td>{{ $peticion->descripcion }}</td>
                            <td>{{ \Carbon\Carbon::parse($peticion->fecha)->format('d-m-Y h:i A') }}</td>
                            <td>{{ $peticion->peticionario }}</td>
                            <td>
                                {{-- Ultima asignacion --}}
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
                            <td>
                                <form id="ver_peticion_comision" action="{{ route("seguimiento_peticion_comision") }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="text" id="id_peticion" name="id_peticion" class="hidden" value="{{ $peticion->id }}">
                                    <input type="text" id="id_comision" name="id_comision" class="hidden" value="{{ $comision->id }}">
                                    <button type="submit" class="btn btn-primary btn-xs btn-block">
                                        <i class="fa fa-eye"></i> Ver
                                    </button>
                                </form>
                            </td>

                            {!! Form::open(['route'=>['subir_documento_comision'],'method'=> 'POST','id'=>$peticion->id.'2']) !!}
                            <input type="hidden" name="id_comision" id="id_comision" value="{{ $comision->id }}">
                            <input type="hidden" name="id_peticion" id="id_peticion"  value="{{$peticion->id}}">
                            <td>
                                <button type="submit" class="btn btn-info btn-xs btn-block" >
                                    <i class="fa fa-upload"></i> Subir documentacion
                                </button>
                            </td>
                            {!! Form::close() !!}
                            {!! Form::open(['route'=>['retirar_peticion_comision'],'method'=> 'POST','id'=>$peticion->id.'2']) !!}
                            <input type="hidden" name="id_comision" id="id_comision" value="{{ $comision->id }}">
                            <input type="hidden" name="id_peticion" id="id_peticion"  value="{{$peticion->id}}">
                            <td>
                                <button type="submit" class="btn btn-danger btn-xs btn-block" onclick="return confirm('¿Esta seguro de eliminar peticion de la comision?');">
                                    <i class="fa fa-unlink"></i> Retirar peticion
                                </button>
                            </td>
                            {!! Form::close() !!}
                            @php $contador++ @endphp
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section("lobibox")

    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif

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
                responsive: true,
                columnDefs: [{orderable: false, targets: [1, 2, 3, 4, 5, 6, 7,8,9]}],
                order: [[0, 'asc']]
            });
        });
    </script>

@endsection