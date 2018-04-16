@extends('layouts.Modal')

@section("idModal","imagenModal")
@section("EncabezadoModal","Imagen de Usuario")
@section("size","modal-lg")

@section("bodyModal")
    <div class="text-black text-center">
        <p class="text-capitalize text-bold">Imagen de Perfil</p>
        <img src="{{ asset("images/default-user.png") }}" id="image" class="img-responsive center-block">
    </div>

    <br>

    <form id="actualizar_imagen" name="actualizar_imagen" method="post"
          action="{{ route("actualizar_imagen") }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="img">Seleccione la nueva imagen</label>
                    <div class="file-loading">
                        <input id="img" name="img" type="file" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer text-center">
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success">Actualizar Imagen</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("footerModal")
    <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
@endsection

