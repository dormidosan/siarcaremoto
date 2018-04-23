@extends('layouts.app')

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Asambleistas</a></li>
            <li><a class="active">Listado Asambleistas por Facultad</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger ">
        <div class="box-header with-border">
            <h3 class="box-title">Listado de Asambleistas por Facultad</h3>
        </div>
        <div class="box-body">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($facultades as $facultad)
                    @php $i = 1 @endphp

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="facultad{{$facultad->id}}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{$facultad->id}}" aria-expanded="false"
                                   aria-controls="collapse{{$facultad->id}}" class="text-capitalize">
                                    {{ $facultad->nombre }}
                                </a>
                            </h4>
                        </div>

                        <div id="collapse{{$facultad->id}}" class="panel-collapse collapse " role="tabpanel"
                             aria-labelledby="facultad{{$facultad->id}}">
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
                                        @if($facultad->asambleistas()->count() > 0)
                                            @forelse($asambleistas as $asambleista)
                                                @if($facultad->id == $asambleista->facultad->id)
                                                    <tr>
                                                        <td style="vertical-align: middle">{{ $i }}</td>
                                                        <td>
                                                            <div class="center-block">
                                                                <img src="{!!$fotos!!}{!!$asambleista->user->persona->foto!!}"
                                                                     class="img-responsives" width="70px"
                                                                     style="margin-left: 25px !important; "
                                                                     alt="User Image">
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: middle">{{ $asambleista->user->persona->primer_nombre . " " . $asambleista->user->persona->segundo_nombre . " " . $asambleista->user->persona->primer_apellido . " " . $asambleista->user->persona->segundo_apellido }}</td>
                                                        <td style="vertical-align: middle">{{ $asambleista->sector->nombre }}</td>
                                                        @if($asambleista->propietario == 1)
                                                            <td style="vertical-align: middle">Propetario</td>
                                                        @else
                                                            <td style="vertical-align: middle">Suplente</td>
                                                        @endif
                                                        <td style="vertical-align: middle">
                                                            @if($asambleista->hoja_id)
                                                                <a class="btn btn-success btn-xs"
                                                                   href="<?= $disco . $asambleista->hoja->path; ?>"
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
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="">Esta comision no cuenta con asambleistas
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="6" class="">Esta comision no cuenta con asambleistas</td>
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


@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection