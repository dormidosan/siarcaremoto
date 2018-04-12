@extends('layouts.app')

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Reporteria</a></li>
            <li><a class="active">Menu Reportes</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">REPORTES</h3>
        </div>

        <div class="box-body">
            {{-- <h4 class="text-center text-bold">REPORTES</h4> --}}

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-file-text-o fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">Planilla de Dieta</h3>
                            <a href="{{url('Reporte_planilla_dieta')}}"
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
                            <h3 class="profile-username text-center">Permisos Temporales</h3>
                            <a href="{{ url('Reporte_permisos_temporales') }}"
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
                            <h3 class="profile-username text-center">Permisos Permanentes</h3>
                            <a href="{{ url('Reporte_permisos_permanentes') }}"
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
                            <h3 class="profile-username text-center">Bitacora Correspondencia</h3>

                            <a href="{{ url('Reporte_bitacora_correspondencia') }}"
                               class="btn btn-warning btn-block btn-sm"><b>Acceder</b></a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box" style="border-top-color: #D81B60">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-check fa-4x text-maroon"></i>
                            </div>
                            <h3 class="profile-username text-center">Asistencias</h3>
                            <a href="{{url('Reporte_asistencias_sesion_plenaria')}}"
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
                            <h3 class="profile-username text-center">Consolidados de Renta</h3>

                            <a href="{{url('Reporte_consolidados_renta')}}"
                               class="btn bg-teal btn-block btn-sm"><b>Acceder</b></a>

                        </div>
                    </div>
                </div>
            </div>


             <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box" style="border-top-color: #555299">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-group fa-4x text-purple"></i>
                            </div>
                            <h3 class="profile-username text-center">Asambleistas</h3>
                            <a href="{{url('buscar_periodo')}}"
                               class="btn bg-purple btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-2">
                    <div class="box box-primary" >
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-birthday-cake fa-4x text-primary"></i>
                            </div>
                            <h3 class="profile-username text-center">Cumpleañeros del Mes</h3>

                            <a href="{{url('buscar_cumple')}}"
                               class="btn bg-primary btn-block btn-sm"><b>Acceder</b></a>

                        </div>
                    </div>
                </div>


            </div>


        </div>
@endsection