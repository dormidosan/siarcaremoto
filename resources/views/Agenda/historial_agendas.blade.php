@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/pretty-checkbox/pretty-checkbox.min.css') }}">
    <link href="{{ asset('libs/MaterialDesign/css/materialdesignicons.css') }}" media="all" rel="stylesheet" type="text/css"/>
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
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Junta Directiva</a></li>
            <li class="active">Generar Agenda Plenaria</li>
        </ol>
    </section>
@endsection


@section("content")
    <div class="box box-danger">
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
                        <th colspan="2">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $contador=1 @endphp
                    @forelse($agendas as $agenda)
                        
                        <tr>
                            <td>{!! $contador !!}</td>
                            <td>{!! $agenda->codigo !!}</td>
                            <td>{{ date("d-m-Y",strtotime($agenda->fecha)) }}</td>
                            <td>{!! $agenda->lugar !!}</td>
                            <td>{!! $agenda->trascendental?'Si':'No' !!}</td>
                            @php $ultimo_documento= null @endphp
                            @forelse($agenda->documentos as $documento)
                                @php $ultimo_documento = $documento @endphp
                            @empty
                            @endforelse

                            @if($ultimo_documento )
                            <td>
                                    <a class="btn btn-primary btn-xs btn-block" href="{{ asset($disco.''.$ultimo_documento->path) }}"
                                       role="button" target="_blank"><i class="fa fa-eye"></i> Ver</a>
                            </td>
                            <td>
                                    <a class="btn btn-success btn-xs btn-block"
                                       href="descargar_documento/<?= $ultimo_documento->id; ?>" role="button">
                                        <i class="fa fa-download"></i> Descargar</a>
                            </td>
                            @else
                            <td></td>
                            <td></td>
                            @endif

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
                    url: "{{ route('generar_agenda_plenaria_jd') }}",
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
                    { "orderable": false, "targets": [0,4,5,6] }
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