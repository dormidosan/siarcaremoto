@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Asambleistas</a></li>
            <li><a class="active">Listado Asambleistas de Junta Directiva</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger ">
        <div class="box-header with-border">
            <h3 class="box-title">Asambleistas de Junta Directiva</h3>
        </div>
        <div class="box-body">
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
                    @php $i = 1 @endphp
                    @if(empty($cargos) != true)
                        @forelse($cargos as $cargo)
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
                                <td style="vertical-align: middle">{{ $cargo->tipo_cargo->nombre_cargo }}</td>
                                <td style="vertical-align: middle">
                                                            @if($cargo->asambleista->hoja_id)
                                                               <a  class="btn btn-success btn-xs"
                                                               href="<?= $disco . $cargo->asambleista->hoja->path; ?>"
                                                               role="button" target="_blank">Ver</a>
                                                            @else
                                                                <a disabled class="btn btn-info btn-xs"
                                                               href="#"
                                                               role="button" data-toggle="tooltip" data-placement="bottom" title="Asambleista no posee hoja de vida">Ver</a>
                                                            @endif
                                                            
                                                            
                                                               
                                                            <!-- <a class="btn btn-success btn-xs"
                                                               href="descargar_documento-/-<-?-= $asambleista->ruta; ?>"
                                                               role="button">Descargar</a> -->
                                </td>
                            </tr>
                            @php $i++ @endphp
                        @empty
                            <tr class="text-center">
                                <td colspan="6">No cuenta con asambleistas</td>
                            </tr>
                        @endforelse
                    @else
                        <tr class="text-center">
                            <td colspan="6">No cuenta con asambleistas</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

