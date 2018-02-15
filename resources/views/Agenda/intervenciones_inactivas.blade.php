<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Intervenciones</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                <tr>
                    <th>Numero</th>
                    <th>Asambleista</th>
                    <th>Intervencion</th>

                </tr>
                </thead>
                <tbody id="cuerpoTabla" class="text-center">
                @php $contador = 1 @endphp
                @if($punto->intervenciones->isEmpty())
                    <tr class="text-center">
                        <td colspan="3">No existen intervenciones actualmente registradas</td>
                    </tr>
                @else
                    @foreach($punto->intervenciones as $intervencion)
                        <tr>
                            <td>
                                {{ $contador++ }}
                            </td>
                            <td>
                                {{ $intervencion->asambleista->user->persona->primer_nombre }} {{ $intervencion->asambleista->user->persona->primer_apellido }}
                            </td>
                            <td>
                                <a onclick="mostrarIntervencion({{$intervencion->id}},event)" class="btn btn-primary"><i
                                            class="fa fa-external-link-square"></i> Mostrar Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
