<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">        
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/AdminLTELogo_color.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            <span class="font-weight-light">ContactBicker
        </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
 
 
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            {{--
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-legacy" data-widget="treeview" role="menu">
            --}}
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" style="line-height: 1.2">

                <!-- dashboard -->
                
                <li class="nav-item {{ request()->is('dashboard*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            
                @if(
                    auth()->user()->isgrant('ra_isgrant') || 
                    auth()->user()->isgrant('rs_isgrant')
                )
                <li class="nav-item {{ request()->is('master*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('master*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Maestro
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->isgrant('ra_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('reason.index') }}" class="nav-link {{ request()->is('master/reason*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor de Motivos</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('rs_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('subreason.index') }}" class="nav-link {{ request()->is('master/subreason*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor de Sub-Motivos</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
               
 
          

                <li class="nav-item {{ request()->is('operation*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('operation*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>
                            Operaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->isgrant('al_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('alert.index') }}" class="nav-link {{ request()->is('operation/alert*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sistema de Alerta</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('pa_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('paloteo.index') }}" class="nav-link {{ request()->is('operation/paloteo*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paloteo</p>
                            </a>
                        </li>
                        @endif
                  
                    </ul>
                </li>
                @if(auth()->user()->isgrant('r1_isgrant'))
                <li class="nav-item {{ request()->is('report*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Reporte
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->isgrant('r1_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('rpt_paloteo') }}" class="nav-link {{ request()->is('report/r1*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Descarga Paloteo</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            

                <li class="nav-header"> </li>
                <li class="nav-item">
                    <a href="#" onclick="document.getElementById('FormLogoutSystem').submit(); return false;" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>
                            Salir                            
                        </p>
                    </a>
                </li>
                <form action="{{ route('logout') }}" id="FormLogoutSystem" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>