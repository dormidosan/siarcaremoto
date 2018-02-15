@extends('layouts.app')

@php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
@endphp

@section('styles')
    <link href="{{ asset('libs/file/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/file/themes/explorer/theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/lolibox/css/Lobibox.min.css') }}">

    <style>
        .kv-avatar .krajee-default.file-preview-frame, .kv-avatar .krajee-default.file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }

        .kv-avatar {
            display: inline-block;
        }

        .kv-avatar .file-input {
            display: table-cell;
            width: 213px;
        }

        .kv-reqd {
            color: red;
            font-family: monospace;
            font-weight: normal;
        }

        .file-upload-indicator {
            visibility: hidden;
        }
    </style>
@endsection

@section('breadcrumb')
    <section>
        <ol class="breadcrumb">
            <li><a href="{{ route("inicio") }}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a>Administracion</a></li>
            <li><a class="active">Parametros del Sistema</a></li>
        </ol>
    </section>
@endsection

@section("content")
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Parametros del Sistema</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="parametros"
                       class="table table-striped table-bordered table-condensed table-hover text-center">
                    <thead>
                    <tr>
                        <th>Parametro</th>
                        <th>Valor</th>
                        <th>Nuevo Valor</th>
                        <th>Acción</th>
                    </tr>
                    </thead>

                    <tbody id="cuerpoTabla">
                    @forelse($parametros as $parametro)
                        {!! Form::open(['route'=>['almacenar_parametro'],'method'=> 'POST','id'=>$parametro->id]) !!}
                        <tr>
                            <input type="hidden" name="id_parametro" id="id_parametro" value="{{$parametro->id}}">
                            <td>{!! $parametro->nombre_parametro !!}</td>
                            <td>{!! $parametro->valor !!}</td>
                            <td>
                                <input class="text-center" type="number" id="nuevo_valor" name="nuevo_valor"
                                       onchange="setTwoNumberDecimal" min="0" max="100" step="0.01"
                                       value="{{$parametro->valor}}">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-block btn-xs"><i class="fa fa-pencil"></i> Actualizar</button>
                            </td>
                        </tr>
                        {!! Form::close() !!}
                    @empty

                    @endforelse

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection


@section("js")
    <script src="{{ asset('libs/file/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('libs/file/themes/explorer/theme.min.js') }}"></script>
    <script src="{{ asset('libs/file/js/locales/es.js') }}"></script>
    <script src="{{ asset('libs/utils/utils.js') }}"></script>
    <script src="{{ asset('libs/lolibox/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('libs/adminLTE/plugins/mask/jquery.mask.min.js') }}"></script>
@endsection


@section("scripts")
    <script type="text/javascript">
        function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    </script>
@endsection

{{---@section("lobibox")
    @if(Session::has('success'))
        <script>
            var popUpId = "{{ uniqid() }}";

            if(sessionStorage) {
                // prevent from showing if it exists in a storage (shown);
                if(!sessionStorage.getItem('shown-' + popupId)) {
                    notificacion("Exito", "{{ Session::get('success') }}", "success");
                }
                sessionStorage.setItem('shown-' + popupId, '1');
            }
        </script>
    @endif
@endsection
--}}

@section("lobibox")
    @if(Session::has('success'))
        <script>
            notificacion("Exito", "{{ Session::get('success') }}", "success");
        </script>
    @endif
@endsection
