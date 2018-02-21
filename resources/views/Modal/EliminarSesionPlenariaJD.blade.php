@extends('layouts.Modal')

@section("idModal","eliminarSesionPlenariaJD")
@section("EncabezadoModal","Eliminar Agenda Plenaria")
@section("size","modal-lg")

@section("bodyModal")
    <div class="row text-center text-bold">
        <div class="col-lg-12">
            <span>¿Desea eliminar la agenda selecciona?</span>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <form id="eliminar_agenda" name="eliminar_agenda" method="post">
                {{ csrf_field() }}
                <div class="row hidden">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>id Agenga</label>
                            <input class="form-control" id="id_agenda_eliminar" name="id_agenda_eliminar" value="">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success" onclick="eliminar()">Eliminar Agenda Plenaria</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("footerModal") @endsection




