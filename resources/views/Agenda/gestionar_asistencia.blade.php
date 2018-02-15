@extends('layouts.app')

@section("styles")
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }

        table.dataTable thead > tr > th {
            padding-right: 0 !important;
        }

        table {
            width: 100% !important;
        }

        table tbody tr.group td {
            font-weight: bold;
            text-align: left;
            background: #ddd;
        }

    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Agenda</a></li>
            <li><a href="{{ route("consultar_agenda_vigentes") }}">Consultar Agendas Vigentes</a></li>
            <li><a href="javascript:document.getElementById('sala_sesion_plenaria').submit();">Sesion Plenaria de
                    Agenda {{ $agenda->codigo }}</a></li>
            <li class="active">Control de Asistencias</li>
        </ol>
    </section>
@endsection

@section('content')

    <div class="row hidden">
        <div class="col-lg-4 col-sm-12">
            {!! Form::open(['id'=>'sala_sesion_plenaria','route'=>['sala_sesion_plenaria'],'method'=> 'POST']) !!}
            <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
            <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block"> Regresar a -
                Asistencia plenaria
            </button>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel panel-danger">
        <div class="panel-heading">Control de Asistencias</div>
        <div class="panel-body">
            <h4 class="text-center text-bold">{{ $facultad->nombre}}</h4>
        </div>
        <div class="table-responsive">
            <table id="asistencia" class="table text-center">
                <thead>
                <tr>
                    <th>Asambleista</th>
                    <th>Cargo</th>
                    <th>Sector</th>
                    <th>Hora de entrada</th>
                    <th>Rol en plenaria</th>
                    <th>Cambiar a</th>
                    <th>Retiro</th>
                </tr>
                </thead>
                <tbody id="cuerpoTabla" class="text-center">

                @forelse($asambleistas as $asambleista)
                    <tr>
                        <td id="nombre{{$asambleista->id}}">{{$asambleista->user->persona->primer_nombre." ".$asambleista->user->persona->primer_apellido}}</td>
                        <td>
                            @if($asambleista->propietario == 1)
                                Propietario oficial
                            @else
                                Suplente oficial
                            @endif
                        </td>
                        <td>{{$asambleista->sector->nombre}}</td>
                        @php $presente_plenaria = 0 @endphp
                        @forelse($asistentes as $asistente)
                            @if($asistente->asambleista_id == $asambleista->id)
                                @php $presente_plenaria = 1 @endphp
                                <td>{{\Carbon\Carbon::parse($asistente->entrada)->format('h:i A')}}</td>
                                @if($asistente->propietaria == 1)
                                    <td class="success">Propietario en plenaria</td>
                                    {!! Form::open(['route'=>['cambiar_propietaria'],'method'=> 'POST','id'=>$asistente->id.'1']) !!}
                                    <input type="hidden" name="id_asistente" id="id_asistente"
                                           value="{{$asistente->id}}">
                                    <input type="hidden" name="id_facultad" id="id_facultad" value="{{$facultad->id}}">
                                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-block btn-sm">Suplente</button>
                                    </td>
                                    {!! Form::close() !!}
                                @else
                                    <td>Suplente en plenaria</td>
                                    @if($asambleista->sector_id == 1)
                                        @if($sector1 < 2)
                                            {!! Form::open(['route'=>['cambiar_propietaria'],'method'=> 'POST','id'=>$asistente->id.'2']) !!}
                                            <input type="hidden" name="id_asistente" id="id_asistente"
                                                   value="{{$asistente->id}}">
                                            <input type="hidden" name="id_facultad" id="id_facultad"
                                                   value="{{$facultad->id}}">
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                    Propietario
                                                </button>
                                            </td>
                                            {!! Form::close() !!}
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block btn-sm"
                                                        disabled="disabled">Propietario
                                                </button>
                                            </td>
                                        @endif
                                    @endif

                                    @if($asambleista->sector_id == 2)
                                        @if($sector2 < 2)
                                            {!! Form::open(['route'=>['cambiar_propietaria'],'method'=> 'POST','id'=>$asistente->id.'3']) !!}
                                            <input type="hidden" name="id_asistente" id="id_asistente"
                                                   value="{{$asistente->id}}">
                                            <input type="hidden" name="id_facultad" id="id_facultad"
                                                   value="{{$facultad->id}}">
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                    Propietario
                                                </button>
                                            </td>
                                            {!! Form::close() !!}
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block"
                                                        disabled="disabled">Propietario
                                                </button>
                                            </td>
                                        @endif
                                    @endif

                                    @if($asambleista->sector_id == 3)
                                        @if($sector3 < 2)
                                            {!! Form::open(['route'=>['cambiar_propietaria'],'method'=> 'POST','id'=>$asistente->id.'4']) !!}
                                            <input type="hidden" name="id_asistente" id="id_asistente"
                                                   value="{{$asistente->id}}">
                                            <input type="hidden" name="id_facultad" id="id_facultad"
                                                   value="{{$facultad->id}}">
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block">Propietario
                                                </button>
                                            </td>
                                            {!! Form::close() !!}
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-block btn-sm"
                                                        disabled="disabled">Propietario
                                                </button>
                                            </td>
                                        @endif
                                    @endif

                                @endif

                                <td class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                                        @if($asistente->propietaria == 1)
                                            <button type="button" class="btn btn-warning btn-sm btn-block disabled"
                                                    disabled="disabled">Temporal
                                            </button>
                                        @else
                                            @if($asistente->temporal == 1)
                                                @if($asistente->temporal != 2)
                                                    <button class="btn btn-success btn-sm btn-block"
                                                            onclick="modal_reincorporar({{$asambleista->id}})">
                                                        Reincorporar
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-sm btn-block disabled"
                                                            disabled="disabled">Reincorporar
                                                    </button>
                                                @endif
                                            @else
                                                @if($asistente->temporal != 2)
                                                    <button class="btn btn-warning btn-sm btn-block"
                                                            onclick="modal_retiro_temporal({{$asambleista->id}})">
                                                        Temporal
                                                    </button>
                                                @else
                                                    <button class="btn btn-warning btn-sm btn-block disabled"
                                                            disabled="disabled">
                                                        Temporal
                                                    </button>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                                        @if($asistente->propietaria == 1)
                                            <button type="button" class="btn btn-danger btn-sm btn-block disabled"
                                                    disabled="disabled">Permanente
                                            </button>
                                        @else
                                            @if($asistente->temporal != 2)
                                                <button class="btn btn-danger btn-sm btn-block"
                                                        onclick="modal_retiro_permanente({{$asambleista->id}})">
                                                    Permanente
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-sm btn-block disabled"
                                                        disabled="disabled">Permanente
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                            @endif
                        @empty

                        @endforelse
                        @if($presente_plenaria == 0)
                            <td class="danger">No presente</td>
                            <td class="danger">-</td>
                            <td class="danger">-</td>
                            <td class="danger">-</td>
                        @endif
                    </tr>
                @empty

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @include("Modal.RetiroTemporaModal")

    <div class="modal fade" id="retiro_permanente_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Retiro Permanente</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">¿Desea retirar permanentemente al asambleista: <span
                                id="nombre_asambleista_permanente"
                                class="text-bold"></span>?
                    </p>
                    <form id="retiro_permanente" name="retiro_permanente" action="{{route("retiro_temporal")}}"
                          method="post">
                        {{ csrf_field() }}
                        <div class="row hidden">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Agenda</label>
                                    <input type="text" id="agenda_permanente" name="agenda">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Asambleisa</label>
                                    <input type="text" id="asambleista_permanente" name="asambleista_permanente">
                                </div>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tipo Retiro</label>
                                    <input type="text" id="tipo" name="tipo" value="2">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Facultad</label>
                                    <input type="text" id="facultad_modal_permanente" name="facultad_modal">
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-6 col-lg-push-1">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-lg-6 col-lg-pull-1">
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reincorporar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Reincorporar Asambleista</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">¿Desea reincorporar al asambleista: <span
                                id="nombre_asambleista_reincorporar"
                                class="text-bold"></span>?
                    </p>
                    <form id="reincorporar" name="reincorporar" action="{{route("retiro_temporal")}}"
                          method="post">
                        {{ csrf_field() }}
                        <div class="row hidden">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Agenda</label>
                                    <input type="text" id="agenda_reincorporar" name="agenda">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Asambleisa</label>
                                    <input type="text" id="asambleista_reincorporar" name="asambleista_reincorporar">
                                </div>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tipo Retiro</label>
                                    <input type="text" id="tipo" name="tipo" value="3">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Facultad</label>
                                    <input type="text" id="facultad_modal_reincorporar" name="facultad_modal">
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-6 col-lg-push-1">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-lg-6 col-lg-pull-1">
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section("js")
    <!-- Datatables -->
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {
            var table = $('#asistencia').DataTable({
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
                "columnDefs": [
                    {"visible": false, "targets": 2},
                    {"orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6]}
                ],
                "searching": false,
                "order": [[2, 'asc']],
                //"displayLength": 25,
                "paging": false,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;

                    api.column(2, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="6">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });

            // Order by the grouping
            $('#asistencia tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                }
                else {
                    table.order([2, 'asc']).draw();
                }
            });
        });

        function modal_retiro_temporal(id) {
            var nombre = $("#nombre" + id).text();
            $("#nombre_asambleista").text(nombre);
            $("#agenda").attr('value', $("#id_agenda").val());
            $("#facultad_modal").attr('value', $("#id_facultad").val());
            $("#asambleista").attr('value', id);
            $("#retiroTemporal").modal('show');
        }

        function modal_retiro_permanente(id) {
            var nombre = $("#nombre" + id).text();
            $("#nombre_asambleista_permanente").text(nombre);
            $("#agenda_permanente").attr('value', $("#id_agenda").val());
            $("#facultad_modal_permanente").attr('value', $("#id_facultad").val());
            $("#asambleista_permanente").attr('value', id);
            $("#retiro_permanente_modal").modal('show');
        }

        function modal_reincorporar(id) {
            var nombre = $("#nombre" + id).text();
            $("#nombre_asambleista_reincorporar").text(nombre);
            $("#agenda_reincorporar").attr('value', $("#id_agenda").val());
            $("#facultad_modal_reincorporar").attr('value', $("#id_facultad").val());
            $("#asambleista_reincorporar").attr('value', id);
            $("#reincorporar_modal").modal('show');
        }

    </script>

@endsection


@section("lobibox")

    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
            {{ Session::forget('success') }}
        </script>
    @endif
    @if(Session::has('warning'))
        <script>
            notificacion("Error", "{{ Session::get('warning') }}", "warning");
            {{ Session::forget('success') }}
        </script>
    @endif

@endsection
