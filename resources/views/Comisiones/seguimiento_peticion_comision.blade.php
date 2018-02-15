@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li><a href="javascript:document.getElementById('trabajo_comision').submit();">Trabajo de Comision</a></li>
            @if(!empty($reunion))
                <li><a href="javascript:document.getElementById('listado_reuniones_comision').submit();">Listado de
                        Reuniones</a></li>
                <li>
                    <a href="javascript:document.getElementById('iniciar_reunion_comision').submit();">Reunion {{$reunion->codigo}}</a>
                </li>
                <li class="active">Punto de Reunion</li>
            @else
                <li><a href="javascript:document.getElementById('listado_peticiones_comision').submit();">Listado de
                        Peticiones</a></li>
                <li class="active">Peticion {{ $peticion->codigo }}</li>
            @endif
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Detalles Peticion</h3>
        </div>
        <div class="box-body">

            <div class="hidden">
                <form id="trabajo_comision" name="trabajo_comision" method="post"
                      action="{{ route("trabajo_comision") }}">
                    {{ csrf_field() }}
                    <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                    <button class="btn btn-success btn-xs">Acceder</button>
                </form>


                @if(!empty($reunion))
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
                @else
                    <form id="listado_peticiones_comision" name="listado_peticiones_comision"
                          method="post" action="{{ route("listado_peticiones_comision") }}">
                        {{ csrf_field() }}
                        <div class="text-center">
                            <i class="fa fa-file-text-o fa-4x text-info"></i>
                        </div>
                        <h3 class="profile-username text-center">Peticiones</h3>
                        <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                        <button type="submit" class="btn btn-info btn-block btn-sm"><b>Acceder</b></button>
                    </form>
            @endif
            <!-- forms utilizados para retornar a paginas previas con breadcrumbs !-->
            </div>

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

