@extends('layouts.app')

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a class="active">Trabajo Junta Directiva</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Trabajo de Junta Directiva</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-file-text-o fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">Peticiones</h3>
                            <a href="{{route('listado_peticiones_jd')}}"
                               class="btn btn-info btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-book fa-4x text-red"></i>
                            </div>
                            <h3 class="profile-username text-center">Generar Agenda Plenaria</h3>
                            <a href="{{route('listado_agenda_plenaria_jd')}}"
                               class="btn btn-danger btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-envelope fa-4x text-green"></i>
                            </div>
                            <h3 class="profile-username text-center">Generar Reuniones JD</h3>
                            <a href="{{ route('generar_reuniones_jd') }}"
                               class="btn btn-success btn-block btn-sm"><b>Acceder</b></a>

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
                            {!! Form::open(['route'=>['historial_bitacoras_jd'],'method'=> 'POST']) !!}
                            <button type="submit" id="finalizar" name="finalizar"
                                    class="btn btn-warning btn-block btn-sm"><b>Acceder</b>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box" style="border-top-color: #D81B60">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-group fa-4x text-maroon"></i>
                            </div>
                            <h3 class="profile-username text-center">Reuniones</h3>
                            <a href="{{ route('listado_reuniones_jd') }}"
                               class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box" style="border-top-color: #39CCCC">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-clone fa-4x text-teal"></i>
                            </div>
                            <h3 class="profile-username text-center">Historial Dictamenes</h3>
                            {!! Form::open(['route'=>['historial_dictamenes_jd'],'method'=> 'POST']) !!}
                            <button type="submit" id="finalizar" name="finalizar" class="btn bg-teal btn-block btn-sm">
                                <b>Acceder</b>
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
                <tbody id="cuerpoTabla">
                <tr>
                    <td>{{$no_resueltos}}</td>
                    <td>{{$resueltos}}</td>
                    <td>{{$dic_reuniones}}</td>
                    <td>{{$no_reuniones}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection