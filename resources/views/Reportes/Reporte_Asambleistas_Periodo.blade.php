@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/icheck/skins/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/plugins/toogle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">
@endsection

@section('content')

             




<div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte Asambleistas por periodo</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_asambleistas_periodo") }}">
              {{ csrf_field() }}
                <div class="row">
                       <div class="col-lg-3 col-sm-12 col-md-3">
                        <label>Periodo AGU</label>
                        {!! Form::select('periodo',$periodos,$periodo,['id'=>'periodo','class'=>'form-control','requiered'=>'required','placeholder'=>'seleccione periodo']) !!}
                    </div>
                   
                   
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>




 <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div>
        <div class="box-body">
                  <table class="table table-hover">
                   
                    <thead><tr>
                      
                      <th>Nombre</th>
                      
                      <th>Nombre Periodo</th>
                      
                      <th>Ver</th>
                      <th>Descargar</th>
                    </tr></thead>
                    <tbody>
@if(!($resultados==NULL))
@foreach($resultados as $result)
                    <tr>                                     
                      <td>
                        ASAMBLEISTAS DEL PERIO {{$result->nombre_periodo}}
                      </td>
                      <td>{{$result->nombre_periodo}}</td>
                    
                      <td><a href="{{url("/Reporte_Asambleista_Periodo/1.$periodo")}}" class="btn btn-block btn-success btn-xs" >VER</a></td>
                      <td><a href="{{url("/Reporte_Asambleista_Periodo/2.$periodo")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a></td>
                    
                    </tr>
                    
                 <!--    <tr>                                     
                      <td>
                        Inasistencias a Sesiones plenarias
                      </td>
                      <td>fecha</td>
                    
                      <td><a href="{{url("/Reporte_inasistencias_sesion_plenaria_pdf/1")}}" class="btn btn-block btn-success btn-xs" >VER</a></td>
                      <td><a href="{{url("/Reporte_inasistencias_sesion_plenaria_pdf/2")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a></td>
                    
                    </tr>

                    -->
                 
@endforeach 
@endif
                  </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
  
   <script>
$('#fecha').datepicker({
              format: "dd/mm/yyyy",
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true
            });


  </script>
        
@endsection

 
 @section("js")
    <script src="{{ asset('libs/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/toogle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {
            $('.input-group.date.fecha').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                language: "es",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });

            $('#hora').datetimepicker({
                format: 'LT',
            });
        });
    </script>
@endsection
@section("lobibox")
 @if(Session::has('success'))
    <script>
        notificacion("Exito", "{{ Session::get('success') }}", "success");
    </script>
@endif 
@if(Session::has('warning'))
    <script>
        notificacion("Exito", "{{ Session::get('warning') }}", "warning");
    </script>
@endif 
@endsection