<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">        
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/AdminLTELogo_color.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            <span class="font-weight-light">Flash<span>Account
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
            
             
                <li class="nav-item {{ request()->is('master*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('master*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Maestro
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{--
                        @if(auth()->user()->isgrant('td_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('doctype.index') }}" class="nav-link {{ request()->is('master/doctype*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipo de Documento</p>
                            </a>
                        </li>
                        @endif
                        --}}
                        @if(auth()->user()->isgrant('td_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('reason.index') }}" class="nav-link {{ request()->is('master/reason*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor de Motivos</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('td_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('subreason.index') }}" class="nav-link {{ request()->is('master/subreason*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor de Sub-Motivos</p>
                            </a>
                        </li>
                        @endif
                        
                        
                    </ul>
                </li>

                {{--
                <li class="nav-item {{ request()->is('product*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Productos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                         
                        @if(auth()->user()->isgrant('pr_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link {{ request()->is('product/manager*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor de Productos</p>
                            </a>
                        </li>
                        @endif
                            <li class="nav-item">
                                <a href="{{ route('group.index') }}" class="nav-link {{ request()->is('product/group*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Grupo</p>
                                </a>
                            </li>
                            @if(auth()->user()->isgrant('td_isgrant'))
                            <li class="nav-item">
                                <a href="{{ route('familia.index') }}" class="nav-link {{ request()->is('product/famili*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Familia</p>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('subfamilia.index') }}" class="nav-link {{ request()->is('product/subfamilia*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>SubFamilia</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tejido.index') }}" class="nav-link {{ request()->is('product/tejido*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tejido</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hilatura.index')  }}" class="nav-link {{ request()->is('product/hilatura*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Hilatura</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('titulo.index') }}" class="nav-link {{ request()->is('product/titulo*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Titulo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('gama.index') }}" class="nav-link {{ request()->is('product/gama*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gama</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tenido.index') }}" class="nav-link {{ request()->is('product/tenido*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Teñido</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('acabado.index') }}" class="nav-link {{ request()->is('product/acabado*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Acabado</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('presentacion.index') }}" class="nav-link {{ request()->is('product/presentacion*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Presentacion</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('um.index') }}" class="nav-link {{ request()->is('product/um*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unidad de Medida</p>
                                </a>
                            </li>
                        
                    </ul>
                </li>
                --}}

                {{--
                <li class="nav-item {{ request()->is('bpartner*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('bpartner*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Clientes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->isgrant('bp_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('bpartner.index') }}" class="nav-link {{ request()->is('bpartner/manager*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor Maestro</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('cc_isgrant'))
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('bpartner/account*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cuentas Corriente</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('salesperson.index') }}" class="nav-link {{ request()->is('bpartner/salesperson*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ejecutivo de Venta</p>
                            </a>
                        </li>                        
                    </ul>
                </li>
                --}}
                
                {{--
                <li class="nav-item {{ request()->is('pricelist*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('bpartner*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-list-alt"></i>
                        <p>
                            Lista de Precios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pricelist.index') }}" class="nav-link {{ request()->is('pricelist/manager*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestor Lista Precios</p>
                            </a>
                        </li>
                    </ul>
                </li>
                --}}

                <li class="nav-item {{ request()->is('operation*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('operation*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>
                            Operaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->isgrant('o1_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('paloteo.index') }}" class="nav-link {{ request()->is('operation/paloteo*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paloteo</p>
                            </a>
                        </li>
                        @endif
                        {{--
                        @if(auth()->user()->isgrant('o1_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('order.index') }}" class="nav-link {{ request()->is('operation/order*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pedidos</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('o2_isgrant'))
                        <li class="nav-item">
                            <a href="{{ route('invoice.index') }}" class="nav-link {{ request()->is('operation/invoice*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nota de Venta</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('o3_isgrant'))
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('bpartner/account*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cobranzas/Depositos</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('o4_isgrant'))
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('bpartner/account*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pagos/Extorno</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->isgrant('o5_isgrant'))
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('bpartner/account*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Asignación de Anticipo</p>
                            </a>
                        </li>
                        @endif
                        --}}
                    </ul>
                </li>
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
                                <p>Estado de Cuenta R1</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            

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