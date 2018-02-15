@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/formvalidation/css/formValidation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">

    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }

        table.dataTable thead > tr > th {
            padding-right: 0 !important;
        }

        #registro_permisos_temporales .dateContainer .form-control-feedback {
            top: 0;
            right: -15px;
        }

    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li class="active">Permisos Temporales</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Registro Permisos Temporales</h3>
        </div>
        <div class="box-body">
            <form id="registro_permisos_temporales" name="registro_permisos_temporales" class="form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="asambleista">Asambleista</label>
                            <select id="asambleista" name="asambleista" class="form-control"
                                    onchange="mostrar_delegados(this.value)">
                                <option value="">-- Seleccione un asambleista --</option>
                                @foreach($asambleistas as $asambleista)
                                    <option value="{{$asambleista->id}}">{{ $asambleista->user->persona->primer_nombre . ' ' .$asambleista->user->persona->segundo_nombre . ' ' . $asambleista->user->persona->primer_apellido . ' ' . $asambleista->user->persona->segundo_apellido }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 hidden" id="delegados">
                        <div class="form-group">
                            <label for="delegado">Delegado</label>
                            <select id="delegado" name="delegado" class="form-control">
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Inicio</label>
                            <div class="input-group input-append date" id="startDatePicker">
                                <input type="text" class="form-control" name="startDate" placeholder="d-m-yyyy"/>
                                <span class="input-group-addon add-on"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Fin</label>
                            <div class="input-group input-append date" id="endDatePicker">
                                <input type="text" class="form-control" name="endDate" placeholder="d-m-yyyy"/>
                                <span class="input-group-addon add-on"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="motivo">Razon del Permiso</label>
                            <textarea type="text" class="form-control" id="motivo" name="motivo" rows="4"
                                      maxlength="50"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-lg-12">
                        <button type="submit" id="aceptar" name="aceptar" class="btn btn-primary" onclick="enviar()">
                            Aceptar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Permisos Temporales</h3>
        </div>
        <div class="box-body table-responsive">
            <table id="permisos_tabla" class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nombre Asambleista</th>
                    <th>Delegado</th>
                    <th>Fecha Solicitud Permiso</th>
                    <th>Razon</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                </tr>
                </thead>

                <tbody id="cuerpoTabla">
                @php $i = 1 @endphp

                @foreach($permisos as $permiso)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $permiso->asambleista->user->persona->primer_nombre . ' ' . $permiso->asambleista->user->persona->segundo_apellido }}</td>
                        @if($permiso->delegado)
                            <td>{{ $permiso->delegado->user->persona->primer_nombre  . ' ' . $permiso->delegado->user->persona->segundo_apellido }}</td>
                        @else
                            <td>-----</td>
                        @endif
                        <td>{{ date("d/m/Y h:i A",strtotime($permiso->created_at)) }}</td>
                        <td>{{ $permiso->motivo }}</td>
                        <td>{{ date("d/m/Y",strtotime($permiso->inicio))}}</td>
                        <td>{{ date("d/m/Y",strtotime($permiso->fin)) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection

@section("js")
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/formValidation.min.js') }}"></script>
    <script src="{{ asset('libs/formvalidation/js/framework/bootstrap.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {

            $('#startDatePicker')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                })
                .on('changeDate', function (e) {
                    // Revalidate the start date field
                    $('#registro_permisos_temporales').formValidation('revalidateField', 'startDate');
                });

            $('#endDatePicker')
                .datepicker({
                    format: 'dd-mm-yyyy',
                    clearBtn: true,
                    language: "es",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                })
                .on('changeDate', function (e) {
                    $('#registro_permisos_temporales').formValidation('revalidateField', 'endDate');
                });

            $('#registro_permisos_temporales')
                .find('[name="asambleista"]')
                .select2()
                // Revalidate the color when it is changed
                .change(function (e) {
                    $('#registro_permisos_temporales').formValidation('revalidateField', 'asambleista');
                })
                .end()
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        asambleista: {
                            /*validators: {
                                notEmpty: {
                                    enabled: false,
                                    message: 'Seleccione un asambleista'
                                }
                            }*/
                            validators: {
                                callback: {
                                    message: 'Seleccione un asambleista',
                                    callback: function (value, validator, $field) {
                                        // Get the selected options
                                        var options = validator.getFieldElements('asambleista').val();
                                        return (options != null && options.length >= 1);
                                    }
                                }
                            }
                        },
                        delegado: {
                            validators: {
                                notEmpty: {
                                    enabled: false,
                                    message: 'Seleccione un delegado'
                                }
                            }
                        },
                        motivo: {
                            validators: {
                                stringLength: {
                                    max: 50,
                                    message: 'La razon del permiso no debe de exceder los 50 caracteres'
                                },
                                notEmpty: {
                                    message: 'La razon del permiso es requerida'
                                }
                            }
                        },
                        startDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Fecha de inicio requerida'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    max: 'endDate',
                                    message: 'Fecha de inicio no puede ser mayor que fecha fin'
                                }
                            }
                        },
                        endDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Fecha fin es requerida'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    min: 'startDate',
                                    message: 'Fecha fin no puede ser mayor que fecha inicio'
                                }
                            }
                        }
                    }
                }).on('success.field.fv', function (e, data) {
                if (data.field === 'startDate' && !data.fv.isValidField('endDate')) {
                    // We need to revalidate the end date
                    data.fv.revalidateField('endDate');
                }

                if (data.field === 'endDate' && !data.fv.isValidField('startDate')) {
                    // We need to revalidate the start date
                    data.fv.revalidateField('startDate');
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();
                var $form = $(e.target), fv = $form.data('formValidation');
                // Using ajax to submit form data
                $.ajax({
                    url: "{{ route("guardar_permiso")}}",
                    type: 'POST',
                    data: $form.serialize(),
                    success: function (response) {
                        notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                        setTimeout(function () {
                            window.location.href = '{{ route("registro_permisos_temporales") }}';
                        }, 1000);
                    }
                });
            });

            var oTable = $('#permisos_tabla').DataTable({
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

        $('#asambleista').select2({
            placeholder: 'Seleccione un asambleista',
            language: "es",
            width: '100%'
        }).on();

        function mostrar_delegados(id_asambleista) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('mostrar_delegados') }}",
                data: {
                    "id": id_asambleista
                },
                success: function (response) {
                    if (response.esPropietario != 1) {
                        $("#delegado").empty();
                        $('#registro_permisos_temporales').formValidation('enableFieldValidators', 'delegado', true);
                        //$('#registro_permisos_temporales').formValidation('revalidateField', 'delegado');

                        $("#delegado").append(response.dropdown);
                        $('#delegado').select2({
                            placeholder: 'Seleccione un asambleista',
                            language: "es",
                            width: '100%'
                        });
                        $("#delegados").removeClass("hidden");
                    } else {
                        $('#registro_permisos_temporales').formValidation('revalidateField', 'delegado');
                        $('#registro_permisos_temporales').formValidation('enableFieldValidators', 'delegado', false);
                        $("#delegados").addClass("hidden");
                    }
                }
            });

        }

    </script>
@endsection