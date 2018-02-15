@extends('layouts.Modal')

@section("idModal","actualizarPlantilla")
@section("EncabezadoModal","Actualizar Plantilla")
@section("size","modal-lg")

@section("bodyModal")

    <div class="alert alert-warning" role="alert">
        El tamaño maximo del archivo a subir, no debe exceder de 10 MB.
    </div>

    <form id="actualizar_plantilla" name="actualizar_plantilla" method="post"
          action="{{ route("almacenar_plantilla") }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="row hidden">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="plantilla">ID Plantilla</label>
                    <input type="text" id="plantilla_id" name="plantilla_id" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="plantilla">Seleccione nueva plantilla</label>
                    <div class="file-loading">
                        <input id="plantilla" name="plantilla" type="file" accept=".doc, .docx, .pdf, .xls, .xlsx">
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer text-center">
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success">Actualizar Plantilla</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("footerModal")

@endsection


