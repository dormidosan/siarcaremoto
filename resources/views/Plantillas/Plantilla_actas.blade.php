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
            <h3 class="box-title">Plantilla de Actas</h3>
        </div>
        <div class="box-body">
            <form id="buscarDocs" method="post" action="{{ url("buscar_actas") }}">
                  {{ csrf_field() }}
                <div class="row">
                   
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha inicial</label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha1" name="fecha1" type="text" class="form-control"><span class="input-group-addon"><i
                                            class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha final</label>
                            <div class="input-group date fecha">
                                <input required="true" id="fecha2" name="fecha2" type="text" class="form-control"><span class="input-group-addon"><i
                                            class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button  type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar
                        </button>
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

                <thead>
                <tr>
                    <th>Num</th>

                    <th>Codigo</th>

                    <th>Nombre</th>

                     <th>Trascendental</th>

                    <th>Fecha</th>


                    <th>Descargar</th>
                </tr>
                </thead>
                <tbody>
                @if(!($resultados==NULL))
                
                
                @php $i=1 @endphp

                    @foreach($resultados as $result)
                <tr>
                    <td>
                        {{$i}}
                    </td>

                     <td>
                        {{$result->codigo}}
                    </td>

                    <td>
                        {{$result->lugar}}
                    </td>

                     @if($result->trascendental==0)
                     <td>
                        NO
                    </td>
                    @else
                     <td>
                        SI
                    </td>
                    @endif

                    <td>de {{$result->inicio}} al {{$result->fin}}</td>
                    <td><a href="{{url("/desc_Plantilla_actas/$result->id.$result->periodo_id.$result->codigo.$result->fecha.$result->lugar")}}" class="btn btn-block btn-success btn-xs">DESCARGAR</a>
                    </td>

                </tr>
                @php $i=$i+1 @endphp
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