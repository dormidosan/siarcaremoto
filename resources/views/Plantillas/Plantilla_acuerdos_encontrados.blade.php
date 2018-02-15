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
            <h3 class="box-title">Plantilla de Acuerdos</h3>
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

                    <th>Nombre Propuestas</th>

                   


        


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
                        {{$result->nombre_propuesta}}
                    </td>

                  

                  

                    <td>
                  
                    <a href="{{url("/desc_Plantilla_acuerdos/$result->pro_id.$result->age_id.$result->pun_id")}}" class="btn btn-block btn-success btn-xs">DESCARGAR</a>
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