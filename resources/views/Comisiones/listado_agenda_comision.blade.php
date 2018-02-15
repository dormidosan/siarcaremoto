@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset("libs/pretty-checkbox/pretty-checkbox.min.css") }}">
    <link href="{{ asset("libs/MaterialDesign/css/materialdesignicons.css") }}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">

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
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a></li>
            <li class="active">Listado de Reuniones</li>
        </ol>
    </section>
@endsection


@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Generar Agenda Plenaria</h3>
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
            <form id="convocatoria" method="post" action="{{ route('generar_agenda_plenaria_jd') }}">
                {{ csrf_field() }}
                {{ Form::hidden('id_comision', '1') }}
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Codigo</label>
                            <input name="codigo" type="text" class="form-control" id="codigo"
                                   placeholder="Ingrese un codigo" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input name="lugar" type="text" id="lugar" class="form-control"
                                   placeholder="Ingrese el lugar de reunion">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="control-label">Fecha</label>
                            <div class="input-group input-append date" id="fechaSesion">
                                <input type="text" class="form-control" id="fecha" name="fecha" placeholder="dd-mm-yyyy"/>
                                <span class="input-group-addon add-on"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <span class="help-block">La fecha debe ser mayor o igual {{ \Carbon\Carbon::now()->format("d-m-Y") }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <label>Hora</label>
                        <div class="form-group">
                            <div class='input-group date'>
                                <input name="hora" type='text' id="hora" class="form-control" placeholder="h:i AM"/>
                                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="pretty p-icon p-smooth">
                            <input type="checkbox" name="trascendental"/>
                            <div class="state p-success">
                                <i class="icon mdi mdi-check"></i>
                                <label style="font-weight: bold">¿Es trascendental?</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Listado Sesiones Plenarias</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="agendas" class="table text-center table-striped table-bordered table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Trascendental</th>
                        <th>Vigente</th>
                        <th>Activa</th>
                        <th>Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $contador=1 @endphp
                    @forelse($agendas as $agenda)
                        
                        <tr>
                            <td>{!! $contador !!}</td>
                            <td>{!! $agenda->codigo !!}</td>
                            <td>{!! $agenda->fecha !!}</td>
                            <td>{!! $agenda->lugar !!}</td>
                            <td>{!! $agenda->trascendental?'Si':'No' !!}</td>
                            <td>{!!  $agenda->vigente?'Si':'No' !!}</td>
                            <td>{!! $agenda->activa?'Si':'No' !!}</td>
                            <td>
                            {!! Form::open(['route'=>['eliminar_agenda_creada_jd'],'method'=> 'POST','id'=>'eliminar_agenda_creada_jd'.$contador]) !!}
                            <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                @php $puntos=0 @endphp
                                @forelse($agenda->puntos as $punto)
                                    @php $puntos++ @endphp
                                @empty
                                @endforelse
                                @if($puntos == 0)
                                <!--                                                        USA EL ID DE LA AGENDA, NO EL CONTADOR       -->
                                <!--                                                        USA EL ID DE LA AGENDA, NO EL CONTADOR       -->
                                <!--                                                        USA EL ID DE LA AGENDA, NO EL CONTADOR       -->
                                <!--                                                        USA EL ID DE LA AGENDA, NO EL CONTADOR       -->                                
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminar({{$contador}})"><i class="fa fa-trash-o"></i>
                                        Eliminar
                                    </button>
                                @endif
                            {!! Form::close() !!}
                            </td>
                            <td>
                                @if($agenda->vigente ==0 )
                                    {!! Form::open(['route'=>['subir_acta_plenaria'],'method'=> 'POST']) !!}
                                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                        <button type="submit" class="btn btn-info btn-xs btn-block" ><i
                                                    class="fa fa-eye"></i>Subir Acta Plenaria
                                        </button>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                        
                        @php $contador++ @endphp
                    @empty
                        <p style="color: red ;">No hay criterios de busqueda</p>
                    @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection @section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {

            $('#fecha').mask("99-99-9999", {placeholder: "dd-mm-yyyy"});

            $('#fechaSesion')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                }).on('changeDate', function (e) {
                // Revalidate the start date field
                $('#convocatoria').formValidation('revalidateField', 'fecha');
            });

            $('#hora').datetimepicker({
                format: 'LT'
            }).on('dp.change', function (e) {
                // Revalidate the start date field
                $('#convocatoria').formValidation('revalidateField', 'hora');

            });

            $('#convocatoria').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    codigo: {
                        validators: {
                            notEmpty: {
                                message: 'El codigo de la sesión es requerido'
                            }
                        }
                    },
                    lugar: {
                        validators: {
                            notEmpty: {
                                message: 'El lugar de la sesión es requerido'
                            }
                        }
                    },
                    fecha: {
                        validators: {
                            date: {
                                format: 'DD-MM-YYYY',
                                min: "{{ \Carbon\Carbon::now()->format("d-m-Y") }}",
                                message: 'La fecha no es una fecha valida'
                            },
                            notEmpty: {
                                message: 'La fecha de la sesion es requerida'
                            }
                        }
                    },
                    hora: {
                        validators: {
                            notEmpty: {
                                message: 'La hora de la sesion es requerida'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function(e) {
                // Prevent form submission
                e.preventDefault();

                var form = $("#convocatoria").serialize();
                $.ajax({
                    type: 'POST',
                    route: "{{ route('generar_agenda_plenaria_jd') }}",
                    data: form,
                    success: function (response) {
                        notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                        setTimeout(function () {
                            window.location.href = '{{ route("listado_agenda_plenaria_jd") }}';
                        }, 500);
                    }
                });
            });

            var oTable = $('#agendas').DataTable({
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
                "order": [[0, 'asc']],
                "columnDefs": [
                    { "orderable": false, "targets": [0,5,6,7] }
                ]
            });
        });

        function eliminar(i) {
            var form = $("#eliminar_agenda_creada_jd"+i).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('eliminar_agenda_creada_jd') }}",
                data: form,
                success: function (response) {
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                    setTimeout(function () {
                        window.location.href = '{{ route("listado_agenda_plenaria_jd") }}';
                    }, 400);
                }
            });

        }
    </script>
@endsection