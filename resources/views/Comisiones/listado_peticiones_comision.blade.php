@extends('layouts.app')

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
                <table class="table text-center table-bordered hover">
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
                        <th colspan="2">Acción</th>
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
                            {{-- <td>{{ \Carbon\Carbon::now() }}</td>--}}
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
                            @php $contador++ @endphp
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
