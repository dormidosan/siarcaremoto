@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('') }}">
@endsection

@section("content")
   <div class="box box-danger box-solid">
       <div class="box-header">
           <h3 class="box-title">Puntos de Comision</h3>
       </div>
       <div class="box-body">
           <div class="table-responsive">
               <table class="table text-center table-bordered hover">
                   <thead>
                   <tr>
                       <th>Punto</th>
                       <th>Fecha de creación</th>
                       <th>Visto anteriormente por</th>
                       <th>Acción</th>
                   </tr>
                   </thead>
                   <tbody>
                   <tr>
                       <td>Punto 1</td>
                       <td>01/02/03</td>
                       <td>Junta Directiva</td>
                       <td><a class="btn btn-success btn-xs" href="{{route("/discutir/comisionName/1")}}">Discutir</a></td>
                   </tr>
                   <tr>
                       <td>Punto 1</td>
                       <td>01/02/03</td>
                       <td>Comision de Arte y Cultura</td>

                       <!-- ALBERTO OJO -->
                       <!-- enlace para discutir punto, parametros: la comision y el id del punto -->
                       <td><a class="btn btn-success btn-xs" href="{{route("/discutir/comisionName/2")}}">Discutir</a></td>
                   </tr>
                   <tr>
                       <td>Punto 1</td>
                       <td>01/02/03</td>
                       <td>-</td>
                       <td><a class="btn btn-success btn-xs" href="{{route("/discutir/comisionName/3")}}">Discutir</a></td>
                   </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
@endsection

@section("js")
    <script src="{{ asset('') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        $(function () {});
    </script>
@endsection