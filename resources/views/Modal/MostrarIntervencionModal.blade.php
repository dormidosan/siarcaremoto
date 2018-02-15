@extends('layouts.Modal')
@section("styles")
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section("idModal","mostrarIntervencion")
@section("EncabezadoModal","Detalles Intervencion")
@section("size","modal-lg")

@section("bodyModal")
    <form id="datos_intervencion">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Contenido de la Intervencion</label>
                    <textarea id="contenido" class="form-control" rows="15" readonly></textarea>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("footerModal")
    <div class="modal-footer text-center">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
@endsection



