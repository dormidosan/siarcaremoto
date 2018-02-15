@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
            <li><a href="{{url('listado_peticiones_jd')}}">Listado de Peticiones JD</a></li>
            <li class="active">Peticion {{ $peticion->codigo }}</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Seguimiento</h3>
        </div>

        <div class="box-body">
            @if($es_reunion == 1)
                <div class="row">
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
                                               href="descargar_documento/<?= $seguimiento->documento->id; ?>"
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

