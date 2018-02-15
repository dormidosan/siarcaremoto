@extends('layouts.Modal')
@section("styles")
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section("idModal","iniciarSesionPlenaria")
@section("EncabezadoModal","Sesiones Activas")
@section("size","modal-lg")

@section("bodyModal")

  
        <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">Sesiones</div>
            <div class="box-body table-responsive">
                <table id="sesionesPlenarias"
                       class="table table-striped table-bordered table-condensed table-hover dataTable text-center">
                    <thead class="text-bold">
                    <tr>
                        <th>No.</th>
                        <th>Codigo Plenaria</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Trascendental</th>
                        <th>Vigente</th>
                        <th>Activa</th>
                        <th>Opción</th>
                    </tr>
                    </thead>

                    <!--Valores quemados para efectos de presentación 
                    <tbody id="cuerpoTabla">
                    @-forelse(-$-agendas as $agenda)
                    <tr>
                        <td>{-!-! $agenda->id !!}</td>
                        <td>{-!-! $agenda->codigo !!}</td>
                        <td>{-!-! $agenda->fecha !!}</td>
                        <td>{-!-! $agenda->lugar !!}</td>
                        <td>{-!-! $agenda->trascendental !!}</td>
                        <td>{-!-! $agenda->vigente !!}</td>
                        <td>{-!-! $agenda->activa !!}</td>
                        <td>
                        -{-!-! F-orm::open(['route'=>['iniciar_sesion_plenaria'],'method'=> 'POST']) !!}
                        <input type="hidden" name="id_agenda"   id="id_agenda"   value="{{$agenda->id}}">
                        <button type="submit" class="btn btn-success">Comenzar</button>
                        {-!-! Form::close() !!}
                        </td>
                    </tr>
                    @-empty
                        <p style="color: red ;">No hay criterios de busqueda</p>
                    @-endforelse

            
                    </tbody>
                    -->
                </table>

            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <h4>Período 2017-2017</h4>
        </div>

@endsection

@section("footerModal")

@endsection


