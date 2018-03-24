@extends('layouts.Modal')

@section("idModal","restaurarContraseñaModal")
@section("EncabezadoModal","Restaurar Contraseña")
@section("size","modal-lg")

@section("bodyModal")
    <div class="row text-center text-bold">
        <div class="col-lg-12">
            <span>¿Desea restaurar la contraseña por defecto para el asambleista seleccionado?</span>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <form id="restaurar_contraseña" name="restaurar_contraseña" method="post">
                {{ csrf_field() }}
                <div class="row hidden">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>id Asambleista</label>
                            <input type="text" name="id_asambleista_modal" id="id_asambleista_modal" value="">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success" onclick="reset_contraseña()">Restaurar Contraseña</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("footerModal") @endsection



