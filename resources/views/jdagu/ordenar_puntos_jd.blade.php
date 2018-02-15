@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('libs/adminLTE/plugins/toogle/css/bootstrap-toggle.min.css') }}">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Junta Directiva</a></li>
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo JD</a></li>
            <li><a href="{{ route("listado_reuniones_jd") }}">Listado de Reuniones</a></li>
            <li><a href="javascript:document.getElementById('iniciar_reunion_jd').submit();">Reunion {{ $reunion->codigo }}</a></li>
            <li><a href="javascript:document.getElementById('listado_sesion_plenaria').submit();">Listado Sesiones Plenarias</a></li>
            <li><a href="javascript:document.getElementById('agregar_puntos_jd').submit();">Asignacion Puntos</a></li>
            <li class="active">Ordenar Puntos</li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Ordenar Puntos</h3>
        </div>
        <div class="box-body">

            <div class="hidden">

                {!! Form::open(['route'=>['iniciar_reunion_jd'],'method'=> 'POST','id'=>'iniciar_reunion_jd']) !!}
                {{ Form::hidden('id_reunion', $reunion->id) }} {{ Form::hidden('id_comision', $comision->id) }}
                @if($todos_puntos == 1)
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-default btn-block"
                            disabled="disabled">Reunion JD***
                    </button>
                @else
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-default btn-block">Reunion JD
                    </button>
                @endif
                {!! Form::close() !!}

                {!! Form::open(['route'=>['listado_sesion_plenaria'],'method'=> 'POST','id'=>'listado_sesion_plenaria']) !!}
                {{ Form::hidden('id_reunion', $reunion->id) }}
                {{ Form::hidden('id_comision', $comision->id) }}
                <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block">Regresar a -
                    Listado de Sesion Plenaria
                </button>
                {!! Form::close() !!}

                {!! Form::open(['route'=>['agregar_puntos_jd'],'method'=> 'POST','id'=>'agregar_puntos_jd']) !!}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <input type="hidden" name="id_comision" id="id_comision"
                       value="{{$comision->id}}">
                <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
                @if($agenda->vigente == 1 and $agenda->fijada == 0)
                    <button type="submit" class="btn btn-success">Agregar puntos</button>
                @else
                    <button type="submit" class="btn btn-success" disabled="disabled">Agregar
                        puntos
                    </button>
                @endif
                {!! Form::close() !!}


            </div>

            <div class="row">
                <div class="col-lg-4 col-lg-offset-1 col-sm-12">
                    {!! Form::open(['route'=>['agregar_puntos_jd'],'method'=> 'POST']) !!} {{ Form::hidden('id_reunion', $reunion->id) }} {{ Form::hidden('id_comision', $comision->id) }}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-info btn-block">Agregar puntos
                    </button>

                    {!! Form::close() !!}
                </div>

                <div class="col-lg-4 col-lg-offset-2 col-sm-12">
                    {!! Form::open(['route'=>['ordenar_puntos_jd'],'method'=> 'POST']) !!} {{ Form::hidden('id_reunion', $reunion->id) }} {{ Form::hidden('id_comision', $comision->id) }}
                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                    <button type="submit" id="iniciar" name="iniciar" class="btn btn-default btn-block"
                            disabled="disabled">Ordenar puntos
                    </button>

                    {!! Form::close() !!}
                </div>
            </div>
            <br>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Listado Puntos</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">

                        <table class="table text-center table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Romano</th>
                                <th>Peticionario</th>
                                <th>Descripcion</th>
                                <th>Fecha peticion</th>
                                <th>Fecha actual</th>
                                <th>Visto anteriormente por</th>
                                <th colspan="2">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $contador=1; 
                                $ultimo = $puntos->last();
                            @endphp
                            @forelse($puntos as $punto)
                                @if ($punto->id == $actualizado)
                                    <tr class="success">
                                @else
                                    <tr>
                                        @endif

                                        <td>{!! $contador !!} @php $contador++ @endphp</td>
                                        <td>{!! $punto->romano !!} {!! $punto->numero !!}</td>
                                        <td>{!! $punto->peticion->peticionario !!}</td>
                                        <td>{!! $punto->descripcion !!}</td>
                                        <td>{{ \Carbon\Carbon::parse($punto->peticion->fecha)->format('d-m-Y h:i A') }}</td>
                                        <td>{!! Carbon\Carbon::now() !!}</td>
                                        <td>
                                           @php $i = '' @endphp @foreach($punto->peticion->seguimientos as $seguimiento) @if($seguimiento->estado_seguimiento->estado !== 'cr' and $seguimiento->estado_seguimiento->estado !== 'se' and $seguimiento->estado_seguimiento->estado !== 'as') @php $i = $seguimiento->comision->nombre @endphp @endif @endforeach {!! $i !!}
                                        </td>
                                        <td>
                                            {!! Form::open(['route'=>['nuevo_orden'],'method'=> 'POST','id'=>$punto->id.'2']) !!}
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                            <input type="hidden" name="id_comision" id="id_comision"
                                                   value="{{$comision->id}}">
                                            <input type="hidden" name="id_reunion" id="id_reunion"
                                                   value="{{$reunion->id}}">
                                            <input type="hidden" name="restar" id="restar" value="1">
                                            @if($punto->numero == 1)
                                                <button type="submit" class="btn btn-success btn-xs btn-block" disabled="disabled">
                                                    <i class="fa fa-arrow-up"></i> Subir
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-xs btn-block">
                                                    <i class="fa fa-arrow-up"></i> Subir
                                                </button>
                                            @endif
                                            {!! Form::close() !!}
                                        </td>
                                        <td>
                                            {!! Form::open(['route'=>['nuevo_orden'],'method'=> 'POST','id'=>$punto->id.'1']) !!}
                                            <input type="hidden" name="id_agenda" id="id_agenda"
                                                   value="{{$agenda->id}}">
                                            <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                            <input type="hidden" name="id_comision" id="id_comision"
                                                   value="{{$comision->id}}">
                                            <input type="hidden" name="id_reunion" id="id_reunion"
                                                   value="{{$reunion->id}}">
                                            <input type="hidden" name="restar" id="restar" value="0">
                                            @if($ultimo == $punto)
                                                <button type="submit" class="btn btn-danger btn-xs btn-block" disabled="disabled">
                                                    <i class="fa fa-arrow-down"></i> Bajar
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-danger btn-xs btn-block">
                                                    <i class="fa fa-arrow-down"></i> Bajar
                                                </button>
                                            @endif
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @empty
                                        <p style="color: red ;">No hay criterios de busqueda</p>
                                    @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection @section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/toogle/js/bootstrap-toggle.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('.input-group.date.fecha').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });

            $('.toogle').bootstrapToggle({
                on: 'Presente',
                off: 'Ausente'
            });
        });


        function cambiar_estado_peticion(id) {
            $.ajax({
                //se envia un token, como medida de seguridad ante posibles ataques
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: "{{ route('actualizar_comision') }}",
                data: {
                    "id": id
                },
                success: function (response) {
                    notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
                }
            });
        }
    </script>
@endsection