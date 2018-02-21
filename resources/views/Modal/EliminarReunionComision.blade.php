@extends('layouts.Modal')

@section("idModal","eliminarReunionComision")
@section("EncabezadoModal","Eliminar Reunion Comision")
@section("size","modal-lg")

@section("bodyModal")
    <div class="row text-center text-bold">
        <div class="col-lg-12">
            <span>¿Desea eliminar la reunion selecciona?</span>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <form id="eliminar_reunion" name="eliminar_reunion" method="post">
                {{ csrf_field() }}
                <div class="row hidden">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>id Comision</label>
                            <input type="text" name="id_comision_eliminar" id="id_comision_eliminar" value="">
                        </div>
                    </div>
                </div>
                <div class="row hidden">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>id Reunion</label>
                            <input type="text" name="id_reunion_eliminar" id="id_reunion_eliminar" value="">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success" onclick="eliminar()">Eliminar Reunion</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("footerModal") @endsection



