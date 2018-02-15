@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Agenda</a></li>
            <li><a href="{{ route("consultar_agenda_vigentes") }}">Consultar Agendas Vigentes</a></li>
            <li><a href="javascript:document.getElementById('sala_sesion_plenaria').submit();">Sesion Plenaria de Agenda {{ $agenda->codigo }}</a></li>
            <li class="active">Listado de Puntos</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Listado de Puntos</h3>
        </div>
        <div class="box-body">
            <div class="row hidden">
                <div class="col-lg-4 col-sm-12">
                    {!! Form::open(['id'=>'sala_sesion_plenaria','route'=>['sala_sesion_plenaria'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block"> Regresar a -
                        Asistencia plenaria
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    {!! Form::open(['route'=>['finalizar_sesion_plenaria'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">

                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block" >
                    Finalizar plenaria
                    </button>
                    {!! Form::close() !!}
                </div>

                <div class="col-lg-4 col-sm-12">
                    {!! Form::open(['route'=>['fijar_puntos'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    @if($agenda->fijada == 1)
                        <button type="submit" id="iniciar" name="iniciar" class="btn btn-success btn-block"
                                disabled="disabled">Fijar puntos
                        </button>
                    @else
                        <button type="submit" id="iniciar" name="iniciar" class="btn btn-success btn-block">Fijar
                            puntos
                        </button>
                    @endif

                    {!! Form::close() !!}
                </div>
                <div class="col-lg-4 col-sm-12">
                    <!-- {-!-! Form::open(['route'=>['seguimiento_peticion_plenaria'],'method'=> 'POST','target' => '_blank']) !!} -->
                    <!-- Al pausar sesion plenaria , regresara a la pantalla con el listado de todas las sesiones plenarias, 
                    usar la pantalla de jonathan de consultar agenda vigente como ejemplo-->
                    {!! Form::open(['route'=>['pausar_sesion_plenaria'],'method'=> 'POST']) !!}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">

                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-warning btn-block">Pausar
                        plenaria
                    </button>
                {!! Form::close() !!}
                <!-- {-!-! Form::close() !!}    -->
                </div>


            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table text-center table-bordered hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Romano</th>
                        <th>Descripcion</th>
                        <th>Peticionario</th>
                        <th>Fecha peticion</th>
                        <th>Retirado</th>
                        <th colspan="3">Accion</th>
                    </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                    @php
                        $contador =1
                    @endphp
                    @forelse($puntos as $punto)

                        @if ($punto->id == $actualizado)
                            <tr class="success">
                        @else
                            <tr>
                                @endif
                                <td>
                                    {!! $contador !!} @php $contador++ @endphp
                                </td>
                                <td>{!! $punto->romano !!}</td>
                                <td>{!! $punto->descripcion !!}</td>
                                @if($punto->peticion_id)
                                    <td>{!! $punto->peticion->peticionario !!}</td>
                                    <td>{!! $punto->peticion->fecha !!}</td>
                                    <td>{!! $punto->retirado !!}</td>
                                    <td>
                                        {!! Form::open(['route'=>['seguimiento_peticion_plenaria'],'method'=> 'POST']) !!}
                                        <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                        <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                        <input type="hidden" name="regresar" id="regresar" value="l">
                                        <button type="submit" class="btn btn-primary btn-xs btn-block">
                                            <i class="fa fa-eye"></i> Informacion
                                        </button>
                                        {!! Form::close() !!}
                                    </td>

                                    @if($agenda->fijada == 0)
                                        <td>
                                            {!! Form::open(['route'=>['nuevo_orden_plenaria'],'method'=> 'POST','id'=>$punto->id.'2']) !!}
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                            <input type="hidden" name="restar" id="restar" value="1">
                                            <button type="submit" class="btn btn-success btn-xs btn-block"><i class="fa fa-arrow-up"></i> Subir</button>
                                            {!! Form::close() !!}
                                        </td>
                                        <td>
                                            {!! Form::open(['route'=>['nuevo_orden_plenaria'],'method'=> 'POST','id'=>$punto->id.'1']) !!}
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                            <input type="hidden" name="restar" id="restar" value="0">
                                            <button type="submit" class="btn btn-danger btn-xs btn-block"><i class="fa fa-arrow-down"></i> Bajar</button>
                                            {!! Form::close() !!}
                                        </td>
                                    @else
                                        @if($punto->activo == 1)
                                            <td>
                                                {!! Form::open(['route'=>['discutir_punto_plenaria'],'method'=> 'POST']) !!}
                                                <input type="hidden" name="id_punto" id="id_punto"
                                                       value="{{$punto->id}}">
                                                <input type="hidden" name="id_agenda" id="id_agenda"
                                                       value="{{$agenda->id}}">
                                                <button type="submit" class="btn btn-success btn-xs btn-block">
                                                    <i class="fa fa-commenting"></i> Discutir
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                
                                            </td>
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-success btn-xs btn-block"
                                                        disabled="disabled">
                                                    <i class="fa fa-eye"></i> Discutir
                                                </button>
                                            </td>
                                            <td>
                                                {!! Form::open(['route'=>['discutir_punto_plenaria'],'method'=> 'POST']) !!}
                                                <input type="hidden" name="id_punto" id="id_punto"
                                                       value="{{$punto->id}}">
                                                <input type="hidden" name="id_agenda" id="id_agenda"
                                                       value="{{$agenda->id}}">
                                                <button type="submit" class="btn btn-success btn-xs btn-block">
                                                    <i class="fa fa-eye"></i> Revisar
                                                </button>
                                                {!! Form::close() !!}
                                            </td>

                                        @endif
                                    @endif
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                            @empty
                                <p style="color: red ;">No hay criterios de busqueda</p>
                            @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section("js")
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/i18n/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection


@section("lobibox")

    @if(Session::has('warning'))
        <script>
            notificacion("Error", "{{ Session::get('warning') }}", "warning");
        </script>
    @endif

@endsection