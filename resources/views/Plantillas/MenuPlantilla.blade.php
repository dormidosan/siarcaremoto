@extends('layouts.app')

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a class="active">PLANTILLAS</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">PLANTILLAS</h3>
        </div>

        <div class="box-body">
            {{-- <h4 class="text-center text-bold">PLANTILLAS</h4> --}}

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-file-text-o fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">ACUERDOS</h3>
                            <a href="{{url('Plantilla_Acuerdos')}}"
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
                            <h3 class="profile-username text-center">ACTAS</h3>
                            <a href="{{ url('Plantilla_Actas') }}" class="btn btn-danger btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>
            </div>

         

           

        </div>

        
    </div>
@endsection