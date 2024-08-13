<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-{{ env('APP_ENV', 'local') ? 'mia' : 'white' }} navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{--
            
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                <i class="fas fa-home fa-fw"></i>
                <span class="d-md-inline-block d-none">Home</span>
            </a>
        </li>
        --}}

        @if (auth()->user()->isadmin == 'Y')
            <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle">
                    <i class="fab fa-windows fa-fw"></i> <span class="d-md-inline-block d-none">Sistema</span>
                </a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                    style="left: 0px; right: inherit;">
                    <li><a href="{{ route('user.index') }}" class="dropdown-item"><i class="fas fa-users fa-fw"></i>
                            Usuarios </a></li>
                    <li><a href="{{ route('team.index') }}" class="dropdown-item"><i
                                class="fas fa-id-card-alt fa-fw"></i> Perfiles </a></li>
                    <li class="dropdown-divider"></li>
                    <li><a href="{{ route('sequence.index') }}" class="dropdown-item"><i
                                class="fas fa-list-ol fa-fw"></i> Secuenciador </a></li>
                    <li><a href="{{ route('parameter.index') }}" class="dropdown-item"><i
                                class="fas fa-tools fa-fw"></i> Parametros </a></li>

                    {{--
                    <li class="dropdown-divider"></li>
                    <li><a href="#" class="dropdown-item"><i class="fab fa-windows fa-fw"></i> Sistema </a></li>
                --}}
                    {{--
                --}}
                </ul>
            </li>
        @endif
    </ul>

    {{--
        
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    --}}
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{--
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-warehouse fa-fw"></i>
                <span class="d-md-inline-block d-none">
                    {{ auth()->user()->store_id ? auth()->user()->store->shortname : 'SELECCIONA ALMACEN' }}
                </span>
            </a>
        </li>
        --}}
        @if(
            count(auth()->user()::get_message_asesor()) +
            count(auth()->user()::get_message_supervisor()) 
            )
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#showAlert">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ count(auth()->user()::get_message_asesor()) + count(auth()->user()::get_message_supervisor())  }}</span>
            </a>
           
        </li>
        @endif
         
        <li class="nav-item">
            <span class="nav-link navbar-text d-md-inline-block d-none">{{ auth()->user()->lastname }}</span>
        </li>
        <li class="nav-item">
            &nbsp;
            &nbsp;
            &nbsp;
        </li>


    </ul>
</nav>
<!-- /.navbar -->

<!-- Modal -->
<div class="modal fade" id="modalQuerySTOCK" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <form id="modalQuerySTOCKForm" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="card mb-0">
                    <div class="card-header bg-form">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark" id="inputGroup-sizing-sm"><i
                                        class="fab fa-searchengin fa-fw"></i></span>
                            </div>
                            <input type="text" class="form-control" id="modalQuerySTOCKInput"
                                placeholder="Ingresa DNI/Email/Nombres/Etc" aria-label="Recipient's username"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" id="modalQuerySTOCKResult">

                    </div>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- Modal MESSAGE ASESOR -->
 
<div class="modal fade" id="showAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                @if(count(auth()->user()->get_message_asesor()))
                <div class="card-body">
                    @foreach (auth()->user()->get_message_asesor() as $item)
                        <dl class="row  mb-0 border-bottom" style="line-height: 1">
                            <dt class="col-sm-2">Fecha</dt>
                            <dd class="col-sm-10">{{ $item->created_at }}</dd>
                            <dt class="col-sm-2">Asunto</dt>
                            <dd class="col-sm-10">{{ $item->subject }}</dd>
                            <dt class="col-sm-2">Mensaje</dt>
                            <dd class="col-sm-10">{{ $item->message }}</dd>
                            </dd>
                        </dl>
                    @endforeach                
                </div>
                @endif
                @foreach (auth()->user()->get_message_supervisor() as $item)
                    <div class="card-body">
                        <dl class="row mb-0" style="line-height: 1">
                            <dt class="col-sm-2">Fecha</dt>
                            <dd class="col-sm-10">{{ $item->created_at }}</dd>
                            <dt class="col-sm-2">Asunto</dt>
                            <dd class="col-sm-10">{{ $item->subject }}</dd>
                            <dt class="col-sm-2">Mensaje</dt>
                            <dd class="col-sm-10">{{ $item->message }}</dd>
                            </dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ route('alertline.edit',$item->token) }}" class="btn btn-success">Responder</a>
                        </div>
                    </div>
                @endforeach
            </div>            
        </div>
    </div>
</div>
 


