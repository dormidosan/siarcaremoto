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
            <h3 class="box-title">Reporte planilla de dietas</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_planilla_dieta") }}">
              {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Tipo </label>
                            
                             <select required="true" class="form-control" id="tipoDocumento" name="tipoDocumento">
                                <option value="{{old("tipoDocumento")}}"  >Seleccione una opcion</option>
                                <option value="A" >Por Asambleista</option>
                                <option value="E" >Consolidados Estudiantil</option>
                                <option value="D" >Consolidados Profesional Docente</option>
                                <option value="ND">Consolidados Profesional no Docente</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha1">Mes</label>

                          <!-- <div class="input-group date fecha">
                                <input required="true" id="fecha1" name="fecha1" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>-->

                            <select required="true" class="form-control" id="fecha1" name="fecha1">
                                <option value="{{old("fecha1")}}">Seleccione un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>

                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="anio">Año</label>
                            <input required="true" type="text" class="form-control" placeholder="Año" id="anio"
                                   name="anio" onkeypress="return justNumbers(event);" maxlength="4" size="4" value="{{old("anio")}}">  
                        </div>
                    </div>
                   
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button  type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>




 <div class="box box-solid box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados de Busqueda</h3>
        </div        <div class="box-body">


                  <table class="table table-hover" style="text-transform: uppercase;">
                   
                    <thead><tr>
                      
                      <th>Nombre</th>
                      
                      <th>Fecha</th>
                      
                      <th>Ver</th>
                      <th>Descargar</th>
                    </tr></thead>
                    <tbody>


@if(!($resultados==NULL))




@foreach($resultados as $result)

                    <tr>                                     
                      <td>
                        @if($tipo=="A")
                        REPORTE ANUAL DE DIETAS POR ASAMBLEISTA
                         @endif

                         @if($tipo=="E")
                         
                        CONSOLIDADO DE DIETAS SECTOR ESTUDIANTIL
                             @endif


                         @if($tipo=="D")
                         
                        CONSOLIDADO DE DIETAS SECTOR docente
                             @endif
                         @if($tipo=="ND")
                         
                         CONSOLIDADO DE DIETAS SECTOR no docente
                           @endif
                      </td>
                      @if($tipo=="A")
                      <td>{{$result->anio}}</td>
                      @else
                      <td>{{$result->mes}} {{$result->anio}}</td>
                      @endif
                    
                      <td>
                        @if($tipo=="A")
                        <a  href="{{url("/Reporte_planilla_dieta/1.$result->asambleista_id.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >VER</a>

                      
                        @endif
                        

                          @if($tipo=="E")
                        <a href="{{url("/Reporte_planilla_dieta_prof_Est_pdf/1.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >VER</a>
                     
                        @endif


                        @if($tipo=="D")
                        <a href="{{url("/Reporte_planilla_dieta_prof_Doc_pdf/1.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >VER</a>
                     
                        @endif

                        @if($tipo=="ND")
                         <a href="{{url("/Reporte_planilla_dieta_prof_noDocpdf/1.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >VER</a>
                      
                        @endif
                      </td>
                      
                      <td>
                        @if($tipo=="A")
                        <a href="{{url("/Reporte_planilla_dieta/2.$result->asambleista_id.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a>
                        @endif 

                        @if($tipo=="E")
                        <a href="{{url("/Reporte_planilla_dieta_prof_Est_pdf/2.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a>
                    
                        @endif

                        @if($tipo=="D")
                        <a href="{{url("/Reporte_planilla_dieta_prof_Doc_pdf/2.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a>
                    
                        @endif

                        @if($tipo=="ND")
                        <a href="{{url("/Reporte_planilla_dieta_prof_noDocpdf/2.$result->mes.$result->anio.$mesnum")}}" class="btn btn-block btn-success btn-xs" >DESCARGAR</a>
                   
                        @endif

                      </td>
                    
                    </tr>

@endforeach
@endif
                  </tbody>
                </table>
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
        
        function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
        function cambiar_estado_comision(id) {
        $.ajax({
            //se envia un token, como medida de seguridad ante posibles ataques
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: "{{ route('actualizar_comision') }}",
            data: {
                "id": id
            },
            success: function(response) {
                notificacion(response.mensaje.titulo, response.mensaje.contenido, response.mensaje.tipo);
            }
        });
    }
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