 @extends('layouts.app') @section('styles')
<link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
<link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet"> @endsection @section("content")
<div class="box box-danger box-solid">
    <div class="box-header">
        <h3 class="box-title">Puntos de Comision</h3>
    </div>
    <div class="box-body">
       
        <form class="form-group" id="enlazar_comision" name="enlazar_comision" method="post" action="{{ url('enlazar_comision') }}" enctype="multipart/form-data">
            {{ csrf_field() }} 
            <input type="hidden" name="id_peticion" id="id_peticion" value="{{$peticion->id}}">
            <input type="hidden" name="id_reunion" id="id_reunion" value="{{$reunion->id}}">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Seleccione comision</label>
                        {!! Form::select('comisiones',$comisiones,null, ['id'=>'comision>', 'class'=>'form-control', 'required'=>'required', 'placeholder' => 'Seleccione comision...']) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea name="descripcion" type="text" class="form-control" id="descripcion" placeholder="Ingrese una breve descripcion" required></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label></label>
                        <input type="submit" class="btn btn-success" name="Guardar" value="Asignar">
                    </div>
                </div>
            </div>
        </form>
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
    $(function() {
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