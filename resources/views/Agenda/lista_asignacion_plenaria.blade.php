@extends('layouts.app') @section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Agenda</a></li>
            <li><a href="{{ route('consultar_agenda_vigentes') }}">Consultar Agendas Vigentes</a></li>
            <li><a href="javascript:document.getElementById('sala_sesion_plenaria').submit();">Sesion Plenaria de Agenda {{ $agenda->codigo }}</a></li>
            <li><a href="javascript:document.getElementById('iniciar_sesion_plenaria').submit();">Listado de Puntos</a></li>
            <li><a  href="javascript:document.getElementById('regresar_discusion_punto').submit();"> Discusion de Punto de Plenaria</a></li>
            <li><a class="active">Asignacion a Comision</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Asignacion comision en plenaria -- {{ $punto->peticion->peticionario }} </h3>
        </div>
        <div class="row">

            <div class=" hidden">
                {!! Form::open(['id'=>'iniciar_sesion_plenaria','route'=>['iniciar_sesion_plenaria'],'method'=> 'POST']) !!}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <input type="hidden" name="retornar" id="retornar" value="retornar">
                <button type="submit" id="iniciar" name="iniciar" class="btn btn-danger btn-block">Regresar a -
                    Sesion plenaria
                </button>
                {!! Form::close() !!}

                {!! Form::open(['id'=>'sala_sesion_plenaria','route'=>['sala_sesion_plenaria'],'method'=> 'POST']) !!}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <button type="submit" id="iniciar" name="iniciar"
                        class="btn btn-primary btn-block"> Iniciar sesion plenaria
                </button>
                {!! Form::close() !!}

                {!! Form::open(['id'=>'regresar_discusion_punto','route'=>['discutir_punto_plenaria'],'method'=> 'POST']) !!}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                <button type="submit" id="iniciar" name="iniciar" class="btn btn-warning btn-block" style="width: 20%">
                    Regresar a - Discucion punto
                </button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                {!! Form::open(['route'=>['asignar_comision_punto'],'method'=> 'POST']) !!}
                <input type="hidden" name="id_agenda" id="id_agenda" value="{{$agenda->id}}">
                <input type="hidden" name="id_punto" id="id_punto" value="{{$punto->id}}">
                <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Seleccione comision</label>
                        {!! Form::select('comisiones',$comisiones,null, ['id'=>'comision>', 'class'=>'form-control', 'required'=>'required', 'placeholder' => 'Seleccione comision...']) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea name="descripcion" type="text" class="form-control" id="descripcion"
                                  placeholder="Ingrese una breve descripcion" required></textarea>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-md-12 text-center">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Guardar" value="Asignar">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>


            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Comisiones asignadas</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre comision</th>
                                <th>Fecha de asignacion</th>
                                <th>Descripcion</th>
                            </tr>
                            </thead>

                            <tbody id="cuerpoTabla">
                            @php $contador =1 @endphp @forelse($seguimientos as $seguimiento)
                                <tr>
                                    <td>
                                        {!! $contador !!} @php $contador++ @endphp
                                    </td>
                                    <td>
                                        <center>
                                            {!! $seguimiento->comision->nombre !!}
                                        </center>
                                    </td>
                                    <td>
                                        {!! $seguimiento->inicio !!}
                                    </td>
                                    <td>
                                        {!! $seguimiento->descripcion !!}
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
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
@endsection @section("scripts")
    <script type="text/javascript">
        $(function () {
            $("#documento").fileinput({
                theme: "explorer",
                uploadUrl: "/file-upload-batch/2",
                language: "es",
                minFileCount: 1,
                maxFileCount: 3,
                allowedFileExtensions: ['docx', 'pdf'],
                showUpload: false,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                },
                hideThumbnailContent: true,
                showPreview: false

            });
        });
    </script>
@endsection