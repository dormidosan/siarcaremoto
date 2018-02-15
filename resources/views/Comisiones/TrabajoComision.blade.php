@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Comisiones</a></li>
            <li><a href="{{ route("administrar_comisiones") }}">Listado de Comisiones</a></li>
            <li class="active">Trabajo de Comision</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">Trabajo de  {{ucwords($comision->nombre)}}</h3>
        </div>

        <div class="box-body">
            <h4 class="text-center text-bold hidden">Administrar trabajo de {{ $comision->nombre }}</h4>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-info">
                        <div class="box-body">
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
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-success">
                        <div class="box-body">
                            <form id="convocatoria" name="convocatoria"
                                  method="post" action="{{ route('convocatoria_comision') }}">
                                {{ csrf_field() }}
                                <div class="text-center">
                                    <i class="fa fa-envelope fa-4x text-green"></i>
                                </div>
                                <h3 class="profile-username text-center">Generar Reuniones Comision</h3>
                                <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                                <button type="submit" class="btn btn-success btn-block btn-sm"><b>Acceder</b></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box" style="border-top-color: #D81B60">
                        <div class="box-body">
                            <form id="listado_reunione_comision" name="listado_reuniones_comision"
                                  method="post" action="{{ route("listado_reuniones_comision") }}" {{-- --}}>
                                {{ csrf_field() }}
                                <div class="text-center">
                                    <i class="fa fa-group fa-4x text-maroon"></i>
                                </div>
                                <h3 class="profile-username text-center">Reuniones</h3>
                                <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">
                                <button type="submit" class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-folder-open-o fa-4x text-warning"></i>
                            </div>                            
                            <h3 class="profile-username text-center">Historial Bitacoras</h3>
                            {!! Form::open(['route'=>['historial_bitacoras'],'method'=> 'POST']) !!}  
                            <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">                          
                            <button type="submit" id="finalizar" name="finalizar" class="btn btn-warning btn-block btn-sm"><b>Acceder</b>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-4">
                    <div class="box" style="border-top-color: #39CCCC">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-clone fa-4x text-teal"></i>
                            </div>
                            <h3 class="profile-username text-center">Historial Dictamenes</h3>
                            {!! Form::open(['route'=>['historial_dictamenes'],'method'=> 'POST']) !!}     
                            <input class="hidden" id="comision_id" name="comision_id" value="{{$comision->id}}">                       
                            <button type="submit" id="finalizar" name="finalizar" class="btn bg-teal btn-block btn-sm"><b>Acceder</b>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body table-responsive">
            <table id="trabajoComision" class="table table-bordered table-hover text-center">

                <thead class="text-bold">
                <tr>
                    <th>Puntos Pendientes</th>
                    <th>Puntos Resueltos</th>
                    <th>Dictamenes Creados</th>
                    <th>Sesiones Realizadas</th>
                </tr>
                </thead>

                <tbody id="cuerpoTabla" class="text-red text-bold">
                <tr>
                    <td>4</td>
                    <td>50</td>
                    <td>30</td>
                    <td>45</td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>

@endsection

@section('js')

@endsection

@section('scripts')

@endsection