@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Asambleistas</a></li>
            <li><a class="active">Listado Asambleistas por Comision</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger ">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de Asambleistas por Comision</h3>
        </div>
        <div class="box-body">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($comisiones as $comision)
                    @php $i = 1 @endphp

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="comision{{$comision->id}}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{$comision->id}}" aria-expanded="false"
                                   aria-controls="collapse{{$comision->id}}" class="text-capitalize">
                                    {{ $comision->nombre }}
                                </a>
                            </h4>
                        </div>

                        <div id="collapse{{$comision->id}}" class="panel-collapse collapse " role="tabpanel"
                             aria-labelledby="comision{{$comision->id}}">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th style="padding-left: 35px">Imagen</th>
                                            <th>Asambleista</th>
                                            <th>Sector</th>
                                            <th>Cargo</th>
                                            <th>Hoja de vida</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($comision->cargos()->count() > 0)
                                            @php $integrantes = false @endphp
                                            @foreach($cargos as $cargo)
                                                @if($comision->id == $cargo->comision->id && $cargo->activo == 1)
                                                    <tr>
                                                        <td style="vertical-align: middle">{{ $i }}</td>
                                                        <td>
                                                            <div class="center-block">
                                                                <img src="{!!$fotos!!}{!!$cargo->asambleista->user->persona->foto!!}"
                                                                     class="img-responsives" width="70px"
                                                                     style="margin-left: 25px !important; "
                                                                     alt="User Image">
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle">{{ $cargo->asambleista->user->persona->primer_nombre . " " . $cargo->asambleista->user->persona->segundo_nombre . " " . $cargo->asambleista->user->persona->primer_apellido . " " . $cargo->asambleista->user->persona->segundo_apellido }}</td>
                                                        <td style="vertical-align: middle">{{ $cargo->asambleista->sector->nombre }}</td>
                                                        <td style="vertical-align: middle">{{ $cargo->cargo }}</td>
                                                        <td style="vertical-align: middle">
                                         <a class="btn btn-info btn-xs"
                                            href="<?= $disco . $cargo->asambleista->ruta; ?>"
                                            role="button">Ver</a>
                                         <!-- <a class="btn btn-success btn-xs"
                                                       href="descargar_documento-/-<-?-= $asambleista->ruta; ?>"
                                                       role="button">Descargar</a> -->
                                      </td>
                                                    </tr>
                                                    @php $i++ @endphp
                                                    @php $integrantes = true @endphp
                                                @endif
                                            @endforeach
                                            @if($integrantes == false)
                                                <tr>
                                                    <td colspan="5" class="">Esta comision no cuenta con asambleistas
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td colspan="6" class="">Esta comision no cuenta con asambleistas
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

