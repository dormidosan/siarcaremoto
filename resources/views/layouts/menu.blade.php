<aside class="main-sidebar">
    <div class="slimScrollDiv">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    @if(Auth::guest())
                        <img src="{{ asset('images/default-user.png') }}" class="img-circle" alt="User Image">
                    @else
                        <img src="../storage/fotos/{!!Auth::user()->persona->foto!!}" class="img-circle" alt="User Image" >
                    @endif
                </div>
                <div class="pull-left info">
                    @if(Auth::guest())
                        <p>Usuario Invitado</p>
                        <a href="{{url("login")}}"><i class="fa fa-circle text-success"></i>Iniciar Sesion</a>
                    @else
                        <p>{{ Auth::user()->name }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i>Conectado</a>
                    @endif
                </div>
            </div>
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">Menu de Opciones</li>

                @if(Auth::guest())
                    <li><a href="{{ url('busqueda')}}"><i class="fa fa-book"></i>
                            <span>Buscar documento</span></a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Asambleistas</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url("/listado_asambleistas_facultad")}}"><i class="fa fa-dot-circle-o"></i>Listado
                                    de
                                    asambleistas</a>
                            </li>
                            <li><a href="{{url("/listado_asambleistas_comision")}}"><i class="fa fa-dot-circle-o"></i>Asambleistas
                                    por
                                    comision</a></li>
                            <li><a href="{{url("/listado_asambleistas_junta")}}"><i class="fa fa-dot-circle-o"></i>
                                    Asambleistas de JD</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-files-o"></i><span>Agenda</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url("historial_agendas")}}"><i class="fa fa-dot-circle-o"></i>Historial de
                                    agendas</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-envelope"></i> <span>Peticiones</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url("/monitoreo_peticion") }}"><i class="fa fa-dot-circle-o"></i>Monitorear
                                    Peticion</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{url('login')}}"><i class="fa fa-sign-in"></i>
                            <span>Iniciar Sesion</span></a>
                    </li>
                @else
                    @foreach($modulos_padre as $mp)
                        @if($mp->tiene_hijos)
                            <li class="treeview">
                                <a href="#">
                                    <i class="{{ $mp->icono}}"></i><span>{{ $mp->nombre_modulo }}</span>
                                    <span class="pull-right-container"><i
                                                class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    @foreach($modulos as $mh)
                                        @if(is_null($mh->modulo_padre) != true)
                                            @if($mp->id == $mh->padre->id)
                                                @if($mh->tiene_hijos == false)
                                                    <li id="{{ str_replace(' ','',$mh->nombre_modulo) }}"><a
                                                                href="{{ url("$mh->url") }}"><i
                                                                    class="fa fa-dot-circle-o"></i>{{ $mh->nombre_modulo }}
                                                        </a></li>
                                                @else
                                                    <li class="treeview">
                                                        <a href="#"><i
                                                                    class="fa fa-dot-circle-o"></i> {{ $mh->nombre_modulo }}
                                                            <span class="pull-right-container"><i
                                                                        class="fa fa-angle-left pull-right"></i></span>
                                                        </a>
                                                        <ul class="treeview-menu">
                                                            @foreach($modulos as $mh2)
                                                                @if(is_null($mh2->modulo_padre) != true)
                                                                    @if($mh->id == $mh2->padre->id)

                                                                        <li id="{{ str_replace(' ','',$mh2->nombre_modulo) }}">
                                                                            <a href="{{url("$mh2->url")}}"><i
                                                                                        class="fa fa-dot-circle-o"></i>{{$mh2->nombre_modulo}}
                                                                            </a></li>

                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </ul>

                                                    </li>

                                                @endif
                                                {{-- @if($mh->tiene_jijos)--}}
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li id="{{ str_replace(' ','',$mp->nombre_modulo) }}"><a href="{{ url("$mp->url") }}"><i
                                            class="{{ $mp->icono }}"></i><span>{{ $mp->nombre_modulo }}</span></a></li>
                        @endif
                    @endforeach
                    <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i>
                            <span>Cerrar Sesion</span></a>
                    </li>
                @endif


            </ul>
        </section>
        <!-- /.sidebar -->
        <div class="slimScrollBar"></div>
        <div class="slimScrollRail"></div>
    </div>
</aside>
