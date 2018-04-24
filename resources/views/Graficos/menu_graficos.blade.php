@extends('layouts.app')

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title text-bold">Graficos </h3>
        </div>

        <div class="box-body">
            <h4 class="text-center text-bold hidden">Menu de Graficos</h4>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-bar-chart fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">Peticiones por Mes</h3>
                            <a href="{{ route("peticiones_por_mes") }}" class="btn btn-info btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-success">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-pie-chart fa-4x text-success"></i>
                            </div>
                            <h3 class="profile-username text-center">Dictamenes por Comision</h3>
                            <a href="{{ route("dictamenes_por_comision") }}" class="btn btn-success btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection

