@extends('layouts.app')

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
        <div class="box-header">
            <h3 class="box-title">Listado de Reuniones</h3>
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

            </div>
            <div class="table-responsive">
                <table class="table text-center table-bordered hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Lugar</th>
                        <th>Convocatoria</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th colspan="3">Accion</th>
                    </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                    @php $contador =1 @endphp
                    @forelse($reuniones as $reunion)
                        <tr>
                            <td class="hidden">{{ csrf_field() }}</td>
                            <td class="hidden">
                                <input type="hidden" id="id_reunion" name="id_reunion" value="{{ $reunion->id }}">
                            </td>
                            <td class="hidden">
                                <input type="hidden" id="id_comision" name="id_comision" value="{{ $comision->id }}">
                            </td>
                            <td>{{ $contador }} @php $contador++ @endphp</td>
                            <td>{{ $reunion->codigo }}</td>
                            <td>{{ $reunion->lugar }}</td>
                            <td>{{ \Carbon\Carbon::parse($reunion->convocatoria)->format('d-m-Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reunion->inicio)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reunion->fin)->format('d-m-Y') }}</td>
                            @if($reunion->vigente == 1)
                                {!! Form::open(['route'=>['iniciar_reunion_comision'],'method'=> 'POST']) !!}
                                <input type="hidden" name="id_comision" id="id_comision"
                                       value="{{$reunion->comision_id}}">
                                <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                                @if($reunion->activa == 0)
                                    <td>
                                        <button type="submit" class="btn btn-success btn-xs btn-block"><i
                                                    class="fa fa-arrow-right"></i> Iniciar
                                        </button>
                                    </td>
                                @else
                                    <td>
                                        <button type="submit" class="btn btn-success btn-xs btn-block"><i
                                                    class="fa fa-arrow-right"></i> Continuar
                                        </button>
                                    </td>
                                @endif
                                {!! Form::close() !!}

                            @else
                                <td>
                                    <button type="submit" class="btn btn-warning btn-xs btn-block" disabled><i
                                                class="fa fa-arrow-right"></i> Continuar
                                    </button>
                                </td>
                                {!! Form::open(['route'=>['subir_bitacora_comision'],'method'=> 'POST']) !!}
                                <input type="hidden" name="id_comision" id="id_comision"
                                       value="{{$reunion->comision_id}}">
                                <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                                <td>
                                    <button type="submit" class="btn btn-info btn-xs btn-block"><i
                                                class="fa fa-upload"></i> Subir Bitacora
                                    </button>
                                </td>
                                {!! Form::close() !!}

                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay reuniones que mostrar</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
