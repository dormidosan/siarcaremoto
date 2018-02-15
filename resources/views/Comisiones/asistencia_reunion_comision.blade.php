@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a></li>
            <li><a href="javascript:document.getElementById('listado_reuniones_comision').submit();">Listado de Reuniones</a></li>
            <li><a href="javascript:document.getElementById('iniciar_reunion_comision').submit();">Reunion {{$reunion->codigo}}</a></li>
            <li class="active">Asistencia a Reunion</li>
        </ol>
    </section>
@endsection


@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Asistencia a Reunion de Comision</h3>
        </div>


        <div class="box-body">
            <!-- forms utilizados para retornar a paginas previas con breadcrumbs !-->
            <div class="hidden">
                <form id="trabajo_comision" name="trabajo_comision" method="post"
                      action="{{ route("trabajo_comision") }}">
                    {{ csrf_field() }}
                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                    <button class="btn btn-success btn-xs">Acceder</button>
                </form>

                <form id="listado_reuniones_comision" name="listado_reuniones_comision"
                      method="post" action="{{ route("listado_reuniones_comision") }}" {{-- target="_blank" --}}>
                    {{ csrf_field() }}
                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                    <button type="submit" class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></button>
                </form>

                <form id="iniciar_reunion_comision" name="iniciar_reunion_comision" method="post"
                      action="{{ route("iniciar_reunion_comision") }}" class="text-center">
                    <tr>
                        <td class="hidden">{{ csrf_field() }}</td>
                        <td class="hidden">
                            <input type="hidden" id="id_reunion" name="id_reunion" value="{{ $reunion->id }}">
                        </td>
                        <td class="hidden">
                            <input type="hidden" id="id_comision" name="id_comision" value="{{ $comision->id }}">
                        </td>
                        <button type="submit" class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></button>
                    </tr>
                </form>
                <!-- forms utilizados para retornar a paginas previas con breadcrumbs !-->
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Fecha y Hora de Asistencia</th>
                        <th>Accion</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $contador = 1 @endphp

                    @if($asistencias->isEmpty() == true)
                        @foreach($cargos as $cargo)
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{ $cargo->asambleista->user->persona->primer_nombre . ' ' . $cargo->asambleista->user->persona->segundo_nombre . ' ' . $cargo->asambleista->user->persona->primer_apellido . ' ' .  $cargo->asambleista->user->persona->segundo_apellido}}</td>
                                <td>{{ $cargo->cargo }}</td>
                                <td></td>
                                <td>
                                    <form id="registar_asistencia_comision" name="registrar_asistencia_comision"
                                          action="{{ route("registrar_asistencia_comision") }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="cargo" name="cargo" value="{{ $cargo->id }}">
                                        <input type="hidden" id="comision" name="comision" value="{{ $comision->id }}">
                                        <input type="hidden" id="reunion" name="reunion" value="{{ $reunion->id }}">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i>
                                            Registrar Asistencia
                                        </button>
                                    </form>
                                </td>
                            @php $contador++ @endphp
                        @endforeach
                    @else
                        @foreach($cargos as $cargo)
                            @php $encontrado = false @endphp
                            @php $hora = "" @endphp
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{ $cargo->asambleista->user->persona->primer_nombre . ' ' . $cargo->asambleista->user->persona->segundo_nombre . ' ' . $cargo->asambleista->user->persona->primer_apellido . ' ' .  $cargo->asambleista->user->persona->segundo_apellido}}</td>
                                <td>{{ $cargo->cargo }}</td>
                                @foreach($asistencias as $asistencia)
                                    @if($asistencia->cargo->id == $cargo->id)
                                        @php $encontrado = true @endphp
                                        @php $hora = $asistencia->entrada @endphp
                                    @endif
                                @endforeach

                                @if($encontrado == true)
                                    <td>{{ $hora }}</td>
                                    <td class="text-success"><i class="fa fa-check-square-o"></i> Presente</td>
                                @else
                                    <td></td>
                                    <td>
                                        <form id="registar_asistencia_comision" name="registrar_asistencia_comision"
                                              action="{{ route("registrar_asistencia_comision") }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="cargo" name="cargo" value="{{ $cargo->id }}">
                                            <input type="hidden" id="comision" name="comision"
                                                   value="{{ $comision->id }}">
                                            <input type="hidden" id="reunion" name="reunion"
                                                   value="{{ $reunion->id }}">
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                        class="fa fa-check"></i>
                                                Registrar Asistencia
                                            </button>
                                        </form>
                                    </td>
                                @endif

                            </tr>
                            @php $contador++ @endphp
                        @endforeach
                    @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection

@section("lobibox")
    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
        </script>
    @endif
@endsection
