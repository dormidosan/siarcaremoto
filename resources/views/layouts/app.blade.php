<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & AdminLTE-->
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/adminLTE/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/font-awesome-4.7.0/css/font-awesome.min.css') }}">

@yield("styles")
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIARCA') }}</title>
</head>

@if(Auth::check())
    @php($modulos = Auth::user()->rol->modulos)
    @php($modulos_padre = [])
    @foreach($modulos as $modulo)
        @if(is_null($modulo->modulo_padre))
            @if(in_array($modulo,$modulos_padre) == false)
                @php(array_push($modulos_padre,$modulo))
           @endif
        @endif
    @endforeach
    {{-- dd($modulos_padre) --}}
@endif


<body class="fixed sidebar-mini skin-red-light">

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url("/") }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>AGU</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>SIARCA</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            @if(Auth::guest())
                                <img src="{{ asset('images/default-user.png') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">Usuario Invitado</span>
                            @else
                                <img src="../storage/fotos/{!!Auth::user()->persona->foto!!}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                
                                @if(Auth::guest())
                                    <img src="{{ asset('images/default-user.png') }}" class="img-circle" alt="User Image">
                                    <p>
                                        Usuario Invitado
                                        <!--<small>ROL</small>-->
                                    </p>
                                @else
                                    <img src="../storage/fotos/{!!Auth::user()->persona->foto!!}" class="img-circle" alt="User Image" >
                                    <p>                                    
                                    <!-- <img src="../storage/fotos/{!!Auth::user()->persona->foto!!}" class="img-circle" alt="User Image" width="70%"> -->
                                        {{ Auth::user()->name }}
                                        <small>{{ ucfirst(Auth::user()->rol->nombre_rol) }}</small>
                                    </p>
                                @endif

                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                @if(Auth::guest())
                                    <div class="text-center">
                                        <a href="{{ url('login') }}" class="btn btn-danger btn-block"><i
                                                    class="fa fa-sign-in"></i> Iniciar Sesion</a>
                                    </div>
                                @else
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Datos de Usuario</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url("logout") }}" class="btn btn-default btn-flat">Cerrar Sesion</a>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>

    <!--MENU-->
    @include("layouts.menu")

<!-- MAIN CONTENT-->
    <div class="content-wrapper">

        <section class="content">
            <div class="row" style="margin: 0 0.1px 0 0.1px !important;">
                <div class="panel panel-danger">
                    <div class="panel-body" style="padding: 0 !important;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-12">
                                    <img src="{{ asset("images/agu_web5.jpg")}}" class="img-responsive"
                                         alt="Responsive image" style="text-align: justify; margin: 0 auto;">
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12 text-bold text-center">
                                    <h3 class=" text-red">Asamblea General Universitaria</h3>
                                    <h4 class=" text-red">
                                        Sistema Informático para el Apoyo de Reuniones y Control de Acuerdos de la
                                        Asamblea General Universitaria de la Universidad de El Salvador
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @section("breadcrumb")
                <section class="">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
                        <li class="active">Pagina Principal</li>
                    </ol>
                </section>
            @show

            @yield('content')

        </section>

    </div>

    <footer class="main-footer">
        <strong>Copyright
            © @php $dt = new DateTime();
                echo $dt->format('Y');
            @endphp
            <a href="#">Universidad de El Salvador</a>.</strong> Todos los derechos reservados.
    </footer>

</div>

<script src="{{ asset('libs/bootstrap/js/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('libs/adminLTE/js/app.min.js') }}"></script>

@yield("js")
@yield("scripts")
@yield("lobibox")

</body>

</html>
