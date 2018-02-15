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
            <li><a href="{{ route("trabajo_junta_directiva") }}">Trabajo Junta Directiva</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reunion de Junta Directiva</h3>
        </div>
        <div class="box-body">
            
            <br>
        

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Listado Peticiones</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">

                        <table class="table text-center table-striped table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <!--<th>agendado</th>
                                <th>Peticion</th> -->
                                <th>Descripcion</th>
                                <th>Fecha de creación</th>
                                <!--<th>Fecha actual</th>-->
                                <th>Peticionario</th>
                                <th>Visto anteriormente por</th>
                                <th colspan="4">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $contador=1 @endphp 
                            @forelse($peticiones as $peticion)
                                @if ($peticion->agendado == 1)
                                    <tr class="success">
                                @else
                                    <tr>
                                        @endif
                                        <td>{!! $contador !!} @php $contador++ @endphp</td>
                                        <!-- <td>-{-!-!- -$peticion->agendado -!-!-}-</td> -->
                                        <td>{!! $peticion->descripcion !!}</td>
                                        <td>{!! date("m/d/Y",strtotime($peticion->fecha)) !!}</td>
                                    <!--<td>{!! Carbon\Carbon::now() !!}</td>-->
                                        <td>{!! $peticion->peticionario !!}</td>
                                        <td>
                                            {{-- Visto anteriormente por --}} @php $i = '' @endphp @foreach($peticion->seguimientos as $seguimiento) @if($seguimiento->estado_seguimiento->estado !== 'cr' and $seguimiento->estado_seguimiento->estado !== 'se' and $seguimiento->estado_seguimiento->estado !== 'as') @php $i = $seguimiento->comision->nombre @endphp @endif @endforeach {!! $i !!}
                                        </td>
                                        <td>
                                            {!! Form::open(['route'=>['seguimiento_peticion_jd'],'method'=> 'POST','id'=>$peticion->id.'1']) !!}
                                            <input type="hidden" name="id_peticion" id="id_peticion"
                                                   value="{{$peticion->id}}">
                                            <input type="hidden" name="id_comision" id="id_comision"
                                                   value="{{$comision->id}}">
                                            <input type="hidden" name="id_reunion" id="id_reunion"
                                                   value="{{$reunion->id}}">
                                            <input type="hidden" name="es_reunion"  id="es_reunion"  value="1">
                                            <button type="submit" class="btn btn-info btn-xs">Ver</button>
                                            {!! Form::close() !!}
                                        </td>
                                       

                                 
                                        <td>
                                            {!! Form::open(['route'=>['subir_documento_jd'],'method'=> 'POST','id'=>$peticion->id.'4']) !!}
                                            <input type="hidden" name="id_peticion" id="id_peticion"
                                                   value="{{$peticion->id}}">
                                            <input type="hidden" name="id_comision" id="id_comision"
                                                   value="{{$comision->id}}">
                                            <input type="hidden" name="id_reunion" id="id_reunion"
                                                   value="{{$reunion->id}}">
                                            <button type="submit" class="btn btn-success btn-xs">Subir Atestado</button>
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