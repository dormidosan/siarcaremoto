@extends('layouts.app')

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a class="active">REPORTES</a></li>
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
                            <h3 class="profile-username text-center">PLANILLA DE DIETA</h3>
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
                            <h3 class="profile-username text-center">PERMISOS TEMPORALES</h3>
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
                            <h3 class="profile-username text-center">PERMISOS PERMANENTES</h3>
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
                            <h3 class="profile-username text-center">BITACORA CORRESPONDENCIA</h3>

                            <a href="{{ url('Reporte_bitacora_correspondencia') }}"
                               class="btn btn-success btn-block btn-sm"><b>Acceder</b></a>

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
                            <h3 class="profile-username text-center">ASISTENCIAS</h3>
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
                            <h3 class="profile-username text-center">CONSOLIDADOS DE RENTA</h3>

                            <a href="{{url('Reporte_consolidados_renta')}}"
                               class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></a>

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
                            <h3 class="profile-username text-center">ASAMBLEISTAS</h3>
                            <a href="{{url('buscar_periodo')}}"
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
                            <h3 class="profile-username text-center">CUMPLEAÑEROS DEL MES</h3>

                            <a href="{{url('buscar_cumple')}}"
                               class="btn bg-maroon btn-block btn-sm"><b>Acceder</b></a>

                        </div>
                    </div>
                </div>


            </div>


        </div>
@endsection