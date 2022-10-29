@php
    $permisosUsuario = Auth::user()->listarPermisos()->toArray();
@endphp

<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <!-- INICIO BARRA USUARIO -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="{{asset('img\images\avatar')}}" alt="" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        {{auth()->user()->nombre}}
                        <small>{{auth()->user()->Rol->nombre}}</small>
                    </div>
                </a>
            </li>
            <li>
                <form action="{{ruta('cerrarSesion')}}" method="POST">
                    @csrf
                    <ul class="nav nav-profile"> 
                        
                        <li>
                            <a href="javascript:;" onclick="cambiarPassModal()"><i class="fas fa-key"></i> Cambiar Contraseña</a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-question-circle"></i> Ayuda</a>
                        </li>
                        <li>
                            <a onclick="$(this).closest('form').submit();" href="javascript:;"><i class="fas fa-sign-out-alt"></i> Cerrar Sesion</a>
                        </li>                       
                    </ul>
                </form>
            </li>
        </ul>
        <!-- Fin Barra usuario -->

        <ul class="nav"><li class="nav-header">Panel de Administración</li>
            <li class="@yield('menu-dashboard')">
                <a href="{{ruta('dashboard')}}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (poseePermiso(['abm_empleados', 'alta_empleado', 'listado_clientes'], $permisosUsuario))
                <li class="has-sub @yield('menu-usuarios')">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                    <ul class="sub-menu">
                            @if(in_array('abm_empleados', $permisosUsuario))
                                <li class="@yield('link-usuarios-generar')"><a href="{{ruta('agregarEmpleado')}}">Alta Empleado</a></li>  
                            @endif
                            @if(in_array('abm_empleados', $permisosUsuario))
                                <li class="@yield('link-usuarios-equipo')"><a href="{{ruta('listadoEmpleados')}}">Listado Equipo</a></li>  
                            @endif
                            @if(in_array('listado_clientes', $permisosUsuario))
                                <li class="@yield('link-usuarios-clientes')"><a href="{{ruta('clientes')}}">Listado Clientes</a></li> 
                            @endif
                    </ul>
                </li>
            @endif

            @if (poseePermiso(['abm_servicios', 'listado_servicios'], $permisosUsuario))
                <li class="has-sub @yield('menu-servicios')">
                    <a href="{{ruta('listadoServicios')}}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Servicios</span>
                    </a>
                </li>
            @endif

            @if (poseePermiso(['abm_productos', 'listado_productos'], $permisosUsuario))
                <li class="has-sub @yield('menu-catalogo')">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-book"></i>
                        <span>Productos Catalogo</span>
                    </a>
                    <ul class="sub-menu">
                        @if(in_array('abm_productos', $permisosUsuario))
                            <li class="@yield('link-catalogo-generar')"><a href="{{ruta('producto')}}">Nuevo Producto Catalogo</a></li>    
                        @endif
                        
                        @if(in_array('listado_productos', $permisosUsuario))
                            <li class="@yield('link-catalogo-listado')"><a href="{{ruta('productos')}}">Listado Catalogo</a></li>     
                        @endif
                    </ul>
                </li>
            @endif
                {{-- 
                <li class="@yield('menu-mediosDePago')">
                    <a href="">
                        <i class="fas fa-credit-card"></i>
                        <span>Medios de pago</span>
                    </a>
                </li> --}}

                {{-- <li class="@yield('menu-monedas')">
                    <a href="">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Monedas</span>
                    </a>
                </li> --}}

                @if (poseePermiso(['listado_pagos', 'abm_pagos'], $permisosUsuario))
                <li class="@yield('menu-pagos')">
                    <a href="{{ruta('listadoPagos')}}">
                        <i class="fas fa-handshake"></i>
                        <span>Pagos realizados</span>
                    </a>
                </li>
                @endif

                @if (poseePermiso(['abm_publicidades', 'listado_publicidades'], $permisosUsuario))
                <li class="@yield('menu-publicidad')">
                    <a href="{{ruta('publicidades')}}">
                        <i class="fas fa-bullhorn"></i>
                        <span>Publicidad </span>
                    </a>
                </li>
                @endif

                @if (poseePermiso(['configuracion', 'listado_roles', 'abm_roles'], $permisosUsuario))
                <li class="@yield('menu-configuracion')">
                    <a href="{{ruta('roles')}}">
                        <i class="fas fa-cogs"></i>
                        <span>Configuracion</span>
                    </a>
                </li>
                @endif
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>

<div class="sidebar-bg"></div>

<!-- end #sidebar -->