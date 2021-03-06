@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            @if($es_reunion == 1)
                <li><a href="{{ route("listado_reuniones_jd") }}">Reuniones</a></li>
                <li><a href="javascript:document.getElementById('continuar').submit();">Reunion {{ $reunion->codigo }}</a></li>
                <li class="active">Peticion {{ $peticion->codigo }}</li>
            @else
                <li><a href="{{ route("listado_peticiones_jd") }}">Listado de Peticiones JD</a></li>
                <li class="active">Peticion {{ $peticion->codigo }}</li>
            @endif
        </ol>
    </section>

@endsection

@section("content")

    @if($es_reunion == 1)
        <div class="hidden">
            {!! Form::open(['route'=>['iniciar_reunion_jd'],'method'=> 'POST','id'=>'continuar']) !!}
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
        </div>
    @endif


    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Seguimiento</h3>
        </div>

        <div class="box-body">
            @if($es_reunion == 1)
                <div class="row hidden">
                    <div class="col-lg-3 col-sm-12">
                        {!! Form::open(['route'=>['iniciar_reunion_jd'],'method'=> 'POST']) !!}
                        <input type="hidden" name="id_comision" id="id_comision" value="{{$comision->id}}">
                        <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                        <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block">Reunion JD
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Fecha inicio</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" value="{{ $peticion->fecha }}"
                               readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Fecha Actual</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ Carbon\Carbon::now() }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Peticionario</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->peticionario }}" readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Direccion</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->direccion }}" readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Correo</label>
                        <input name="nombre" type="text" class="form-control" id="nombre"
                               value="{{ $peticion->correo }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea class="form-control" readonly>{{ $peticion->descripcion }}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Seguimiento paso a paso</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre comision</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Descripcion</th>
                                <th>Documento</th>
                                <th>Opcion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpoTabla" class="text-center">
                            @php $contador = 1 @endphp
                            @forelse($peticion->seguimientos as $seguimiento)
                                <tr>
                                    <td>
                                        {!! $contador !!}
                                        @php $contador++ @endphp
                                    </td>
                                    <td>{{ $seguimiento->comision->nombre }}</td>
                                    <td>{{ $seguimiento->inicio }}</td>
                                    <td>{{ $seguimiento->fin }}</td>
                                    <td>{{ $seguimiento->descripcion }}</td>
                                    @if($seguimiento->documento)
                                        <td>{{ $seguimiento->documento->tipo_documento->tipo }}</td>
                                        <td>
                                            <a class="btn btn-info btn-xs"
                                               href="{{ asset($disco.''.$seguimiento->documento->path) }}"
                                               role="button" target="_blank ">Ver</a>
                                            <a class="btn btn-success btn-xs"
                                               href="{{ route('descargar_documento',['id' =>  $seguimiento->documento->id] ) }}"
                                               role="button">Descargar</a>
                                        </td>
                                    @else
                                        <td>
                                            N/A
                                        </td>
                                        <td>
                                            Sin documento
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
        </div>
    </div>
@endsection

