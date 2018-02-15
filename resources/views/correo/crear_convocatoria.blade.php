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
                {!!Form::open(['route'=>'mailing_jd','method'=>'POST'])!!}
					 	<div class="col-md-6 contact-left">
					 		{!!Form::text('name',null,['placeholder' => 'Nombre'])!!}
					 		{!!Form::text('email',null,['placeholder' => 'Email'])!!}
						</div>
						<div class="col-md-6 contact-right">
							{!!Form::textarea('mensaje',null,['placeholder' => 'Mensaje'])!!}
						</div>
						{!!Form::submit('SEND')!!}
					 {!!Form::close()!!}
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












