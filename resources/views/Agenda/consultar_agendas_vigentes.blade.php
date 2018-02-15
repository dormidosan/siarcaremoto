@extends('layouts.app')

@section("styles")
    <style>
        .dataTables_wrapper.form-inline.dt-bootstrap.no-footer > .row {
            margin-right: 0;
            margin-left: 0;
        }
    </style>
    <!-- Datatables-->
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/datatables/responsive/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Agenda</a></li>
            <li><a class="active">Consultar Agendas Vigentes</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Agendas Vigentes</h3>
        </div>

        <div class="box-body">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @php $i = 1 @endphp
                @forelse($agendas as $agenda)

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="agenda{{$agenda->id}}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{$agenda->id}}" aria-expanded="false"
                                   aria-controls="collapse{{$agenda->id}}" class="text-capitalize">
                                    Agenda Vigente #{{$i}}
                                    {{ $agenda->codigo}}
                                    @if ($agenda->activa == 1)
                                        <span style="color: green ;">Sesion inconclusa</span>
                                    @endif
                                    @if ($agenda->trascendental == 1)
                                        <span style="color: red ;">Sesion trascendental</span>
                                    @endif
                                </a>
                            </h4>
                        </div>

                        <div id="collapse{{$agenda->id}}" class="panel-collapse collapse " role="tabpanel"
                             aria-labelledby="agenda{{$agenda->id}}">
                            <div class="panel-body">

                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-info"></i>
                                        <h3 class="box-title">Información sobre la Agenda</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <dl class="dl-horizontal">
                                                    <dt>Fecha y Hora de Inicio</dt>
                                                    <dd>{{ date("d/m/Y h:i A",strtotime($agenda->inicio)) }}</dd>
                                                    <dt>Lugar de Reunion</dt>
                                                    <dd>{{ $agenda->lugar    }}</dd>
                                                    <dt>Transcendental</dt>
                                                    <dd>{{ $agenda->trascendental? "Si":"No" }}</dd>
                                                </dl>
                                            </div>
                                            <div class="col-lg-6">
                                                {!! Form::open(['route'=>['sala_sesion_plenaria'],'method'=> 'POST']) !!}
                                                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                                <button type="submit" id="iniciar" name="iniciar"
                                                        class="btn btn-primary btn-block"> Iniciar sesion plenaria
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>

                                <div class="box-header with-border">
                                    <i class="fa fa-list"></i>
                                    <h3 class="box-title">Puntos de la Agenda</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Peticion</th>
                                            <th>Descripcion</th>
                                            <th>Fecha de creación</th>
                                            <th>Peticionario</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @php $j = 1 @endphp
                                        @forelse($agenda->puntos as $punto)
                                            <tr>
                                                <td>{{ $j }}</td>
                                                <td>{{ $punto->peticion->codigo }}</td>
                                                <td>{{ $punto->peticion->descripcion }}</td>
                                                <td>{{ date("d/m/Y h:i A",strtotime($punto->peticion->created_at)) }}</td>
                                                <td>{{ $punto->peticion->peticionario }}</td>
                                                <td>
                                                    {!! Form::open(['route'=>['detalles_punto_agenda'],'method'=> 'POST']) !!}
                                                    {{ Form::hidden('id_peticion', $punto->peticion->id) }}
                                                    <button type="submit" class="btn btn-primary btn-xs btn-block">
                                                        <i class="fa fa-eye"></i> Ver
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>

                                            @php $j++ @endphp
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-danger">No hay puntos asignados a esta agenda</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i++ @endphp
                @empty
                    <div class="panel panel-default text-center">
                        <div class="panel-body text-danger" style="font-weight: bold    ">
                            No se encuentra ninguna agenda vigente por el momento
                        </div>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection

@section("lobibox")

    @if(Session::has('warning_puntos'))
        <script>
            notificacion("Error", "{{ Session::get('warning_puntos') }}", "warning");
        </script>
    @endif

@endsection