@extends('layouts.app')

@section('breadcrumb')
    <section class="">
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Reporteria</a></li>
            <li><a class="active">Plantillas</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">PLANTILLAS</h3>
        </div>

        <div class="box-body" style=" align-content: center;">
            {{-- <h4 class="text-center text-bold">PLANTILLAS</h4> --}}

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="text-center">
                                <i class="fa fa-file-text-o fa-4x text-info"></i>
                            </div>
                            <h3 class="profile-username text-center">ACTAS</h3>
                            <a href="{{url('Plantilla_Actas')}}"
                               class="btn btn-info btn-block btn-sm"><b>Acceder</b></a>
                        </div>
                    </div>
                </div>

                @forelse($plantillas as $plantilla)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="text-center">
                                    <i class="fa fa-file-text-o fa-4x text-info"></i>
                                </div>
                                <h3 class="profile-username text-center"> {{$plantilla->nombre}}</h3>
                                <a href="descargar_plantilla2/{{ $plantilla->id}}"
                                   class="btn btn-info btn-block btn-sm"><b>Descargar</b></a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse


            </div>


        </div>


    </div>
@endsection