@extends('layouts.app')

@section('styles')
    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
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
                <table class="table text-center table-bordered table-hover table-striped table-condensed" id="tabla">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Correo</th>
                        <th>Fecha de creación</th>
                        {{-- <th>Fecha actual</th> --}}
                        <th>Peticionario</th>
                        <th>Ultima asignacion</th>
                        <th>Visto anteriormente por</th>
                        <th>Resuelto</th>
                        <th>Agendado</th>
                        <th>Comision</th>


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
                            <td>
                                {!! $peticion->correo !!}
                            </td>
                            <td>{{ date("m/d/Y h:i A",strtotime($peticion->fecha)) }}</td>
                            {{-- <td>{{ \Carbon\Carbon::now() }}</td>--}}
                            <td>
                                {!! $peticion->peticionario !!}
                            </td>
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
                                {{-- Visto anteriormente por  --}}
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
                                <td class="danger">
                                    No Resuelto
                                </td>
                            @endif
                            @if($peticion->asignado_agenda == 1)
                                <td class="success">
                                    Agendado
                                </td>
                            @else
                                <td class="danger">
                                    No Agendado
                                </td>
                            @endif
                            @if($peticion->comision == 1)
                                <td class="success">
                                    En comision
                                </td>
                            @else
                                <td >
                                    En JD
                                </td>
                            @endif




                            
                        </tr>
                        
                    @empty
                        <p style="color: red ;">No hay criterios de busqueda</p>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("js")
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
                responsive: true,
                /*searching: false,
                paging: false,*/
                columnDefs: [{orderable: false, targets: [0, 6]}],
                order: [[1, 'asc']]
            });
        });
    </script>
@endsection

