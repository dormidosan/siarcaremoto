<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="panel_propuestas">
        <h4 class="panel-title">Propuestas</h4>
    </div>
    <div class="panel-body">
        {!! Form::open(['route'=>['agregar_propuesta'],'method'=> 'POST','id'=>'agregarPropuesta','class'=>'agregarPropuesta']) !!}
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('asambleista_id', 'Asambleista'); !!}
                    {!! Form::select('asambleista_id',$asambleistas_plenaria,null,['id'=>'asambleista_id','class'=>'form-control','placeholder' => 'Seleccione asambleista...']) !!}
                </div>
            </div>

            <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
            <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">

            <div class="col-lg-8">
                <div class="form-group">
                    {!! Form::label('nueva_propuesta','Propuesta') !!}
                    {!! Form::textarea('nueva_propuesta', null, ['id'=>'nueva_propuesta','class' => 'form-control','size' => '30x4','maxlength'=>'254','required'=>'required','placeholder'=>'Ingrese la nueva propuesta']) !!}
                    <div class="pull-right text-green" id="caja">
                        <span id="chars">254</span> caracteres restantes
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                <button type="submit" id="iniciar" name="iniciar" class="btn btn-primary btn-sm">Agregar Propuesta
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- Table -->
    <div class="table-responsive">
        <table id="propuestas_tabla" class="table table-hover text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre propuesta</th>
                <th>Asambleista</th>
                <th>Favor</th>
                <th>Contra</th>
                <th>Abstencion</th>
                <th>Nulos</th>
                <th>Ronda</th>
                <!--<th>Activa</th>-->
                <th colspan="2">Accion</th>
            </tr>
            </thead>
            <tbody id="cuerpoTabla" class="text-center">
            @php $contador = 1 @endphp
            @if($propuestas->isEmpty())
                <tr>
                    <td colspan="10">No existen propuestas actualmente registradas</td>
                </tr>
            @else
                @foreach($propuestas as $propuesta)
                    @if($propuesta->votado == 1)
                        <tr class="text-center">
                            <td>
                                {{ $contador++ }}
                            </td>
                            <td>
                                {{ $propuesta->nombre_propuesta }}
                            </td>
                            <td>
                                {{ $propuesta->asambleista->user->persona->primer_nombre }} {{ $propuesta->asambleista->user->persona->primer_apellido }}
                            </td>
                            <td>
                                {{ $propuesta->favor }}
                            </td>
                            <td>
                                {{ $propuesta->contra }}
                            </td>
                            <td>
                                {{ $propuesta->abstencion }}
                            </td>
                            <td>
                                {{ $propuesta->nulo }}
                            </td>
                            @if($propuesta->ronda == 1)
                                <td class="success text-bold">{{ $propuesta->ronda }}</td>
                            @else
                                <td class="info text-bold">{{ $propuesta->ronda }}</td>
                            @endif
                            <td>
                                @if($propuesta->ronda == 1 and $propuesta->activa == 1)
                                    {!! Form::open(['route'=>['modificar_propuesta'],'method'=> 'POST']) !!}
                                    <input type="hidden" name="id_propuesta" id="id_propuesta"
                                           value="{{$propuesta->id}}">
                                    <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                    <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                    <input type="hidden" name="opcion" id="opcion" value="1">
                                    <button type="submit" id="iniciar" name="iniciar"
                                            class="btn btn-warning btn-xs text-center btn-block">
                                        Ronda 2
                                    </button>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                            <td>

                            </td>
                        </tr>
                    @else
                        <tr>
                            {!! Form::open(['route'=>['guardar_votacion'],'method'=> 'POST']) !!}
                            <td>
                                {{ $contador++ }}
                            </td>
                            <td>
                                {{ $propuesta->nombre_propuesta }}
                            </td>
                            <td>
                                {{ $propuesta->asambleista->user->persona->primer_nombre }} {{ $propuesta->asambleista->user->persona->primer_apellido }}
                            </td>
                            <td width="7%">
                                <input type="number" class="form-control input-sm" id="favor" name="favor" value="0">
                            </td>
                            <td width="7%">
                                <input type="number" class="form-control input-sm" id="contra" name="contra" value="0">
                            </td>
                            <td width="7%">
                                <input type="number" class="form-control input-sm" id="abstencion" name="abstencion"
                                       value="0">
                            </td>
                            <td width="7%">
                                <input type="number" class="form-control input-sm" id="nulo" name="nulo" value="0">
                            </td>
                            <td>{{ $propuesta->ronda }}</td>
                            <td>
                                <input type="hidden" name="id_propuesta" id="id_propuesta" value="{{$propuesta->id}}">
                                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                <button type="submit" id="iniciar" name="iniciar"
                                        class="btn btn-success btn-block btn-xs">
                                    Guardar
                                </button>
                            </td>
                            {!! Form::close() !!}
                            <td>
                                {!! Form::open(['route'=>['modificar_propuesta'],'method'=> 'POST']) !!}
                                <input type="hidden" name="id_propuesta" id="id_propuesta" value="{{$propuesta->id}}">
                                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                                <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                                <input type="hidden" name="opcion" id="opcion" value="2">
                                <button type="submit" id="iniciar" name="iniciar"
                                        class="btn btn-danger btn-block btn-xs">
                                    Retirar
                                </button>
                                {!! Form::close() !!}
                            </td>

                        </tr>

                    @endif
                    {{--@empty
                    <p style="color: red ;">No hay criterios de busqueda</p>--}}
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
