@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endpush

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-id-card-alt fa-fw"></i> Perfiles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Perfiles</a></li>
                        <li class="breadcrumb-item active">Accesos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('teamgrant.index') }}" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="btn-toolbar" role="toolbar">
                            <div class="input-group">
								<div class="input-group-prepend">
									<a href="#" onclick="location.reload()" class="btn btn-secondary mr-2">
										<i class="fas fa-sync-alt fa-fw"></i>										
									</a>
								</div>
                                <input type="text" name="q" value="{{ $q }}" class="form-control float-right" placeholder="Buscar.." autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search"></i>
										<span class="d-md-inline-block d-none">BUSCAR</span>
                                    </button>
                                    <a href="{{ route('teamgrant.create') }}" class="btn btn-success">
										<i class="far fa-plus-square fa-fw"></i> 
										<span class="d-md-inline-block d-none">NUEVO</span>
									</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 mt-2">
                    <form action="{{ route('teamgrant.store') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select name="store_id" class="form-control select2-store" required>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Agregar ALMACEN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">ALMACEN</th>
                        <th colspan="4" class="bg-success">local</th>
                        <th colspan="4" class="bg-light">import</th>
                        <th colspan="4" class="bg-danger">output</th>
                        <th colspan="4" class="bg-warning">transfer</th>
                        <th colspan="4" class="bg-secondary">confirm</th>
                        <th colspan="4" class="bg-black">Process</th>
                        <th rowspan="2" width="90"></th>
                    </tr>
                    <tr>
                        {{-- compra locales --}}
                        <th class="text-center border-right" width="20" style="padding-left:5px"><i class="fas fa-sign-in-alt"></i></th>
                        <th class="text-center" width="20"><i class="far fa-file"></i></th>
                        <th class="text-center" width="20"><i class="fas fa-edit"></i></th>
                        <th class="text-center" width="20"><i class="far fa-trash-alt"></i></th>
                        {{-- compra importacion --}}
                        <th class="text-center border-right" width="20"><i class="fas fa-sign-in-alt"></i></th>
                        <th class="text-center" width="20"><i class="far fa-file"></i></th>
                        <th class="text-center" width="20"><i class="fas fa-edit"></i></th>
                        <th class="text-center" width="20"><i class="far fa-trash-alt"></i></th>
                        {{-- output --}}
                        <th class="text-center border-right" width="20"><i class="fas fa-sign-in-alt"></i></th>
                        <th class="text-center" width="20"><i class="far fa-file"></i></th>
                        <th class="text-center" width="20"><i class="fas fa-edit"></i></th>
                        <th class="text-center" width="20"><i class="far fa-trash-alt"></i></th>
                        {{-- transfer --}}
                        <th class="text-center border-right" width="20"><i class="fas fa-sign-in-alt"></i></th>
                        <th class="text-center" width="20"><i class="far fa-file"></i></th>
                        <th class="text-center" width="20"><i class="fas fa-edit"></i></th>
                        <th class="text-center" width="20"><i class="far fa-trash-alt"></i></th>
                        {{-- transfer confirm --}}
                        <th class="text-center border-right" width="20"><i class="fas fa-sign-in-alt"></i></th>
                        <th class="text-center" width="20"><i class="far fa-file"></i></th>
                        <th class="text-center" width="20"><i class="fas fa-edit"></i></th>
                        <th class="text-center" width="20"><i class="far fa-trash-alt"></i></th>
                        {{-- procesos --}}
                        <th class="text-center" width="20">ST</th>
                        <th class="text-center" width="20">KU</th>
                        <th class="text-center" width="20">KV</th>
                        <th class="text-center" width="20" style="padding-right:5px">KS</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $on = '<i class="fas fa-check fa-fw text-success"></i>';
                        $off = '<i class="fas fa-times fa-fw text-danger"></i>';	
                    @endphp
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'Y' ? '' : 'tachado'}} text-nowrap">{{ $item->id }}</td>
                            {{-- compra local --}}
                            <td class="border-left">{!! $item->in_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->in_iscreated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->in_isupdated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->in_isdeleted == 'Y' ? $on : $off !!}</td>
                            {{-- compra importada --}}
                            <td class="border-left">{!! $item->ii_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ii_iscreated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ii_isupdated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ii_isdeleted == 'Y' ? $on : $off !!}</td>
                            {{-- compra salida --}}
                            <td class="border-left">{!! $item->ou_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ou_iscreated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ou_isupdated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->ou_isdeleted == 'Y' ? $on : $off !!}</td>
                            {{-- transfer --}}
                            <td class="border-left">{!! $item->tr_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tr_iscreated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tr_isupdated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tr_isdeleted == 'Y' ? $on : $off !!}</td>
                            {{-- transfer confirm --}}
                            <td class="border-left">{!! $item->tc_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tc_iscreated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tc_isupdated == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->tc_isdeleted == 'Y' ? $on : $off !!}</td>
                            {{-- procesos --}}
                            <td class="border-left">{!! $item->stock_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->kardexunit_isgrant == 'Y' ? $on : $off !!}</td>
                            <td>{!! $item->kardexvalue_isgrant == 'Y' ? $on : $off !!}</td>
                            <td class="border-right">{!! $item->kardexsunat_isgrant == 'Y' ? $on : $off !!}</td>
                           
                            
                            <td class="text-right text-nowrap">
                                <a href="{{ route('teamgrant.edit',$item->token) }}">
                                    <i class="far fa-edit"></i>
                                </a> |
                                <a href="#" class="delete-record" data-id="{{ $item->id }}" data-url="{{ route('teamgrant.destroy',$item->token) }}">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pb-3">
        <div class="col-md-5"></div>
        <div class="col-md-7">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
@if(count($header->users))
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-sm table-sm2">
                <thead>
                    <tr>
                        <th colspan="3">Usuarios asignados</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($header->users as $item)
                        <tr>
                            <td class="{{ $item->isactive == 'Y' ? '' : 'tachado'}}">{{ $item->email }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td class="text-right">
                                <a href="{{ route('user.edit',$item->token) }}">
                                    <i class="far fa-edit"></i>
                                </a> 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay usuarios asignados a este perfil</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

@push('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.select2-store').select2({
                ajax: {
                    url: "#",
                    type: 'post',
                    dataType: 'json',
                    delay: 150,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            s: 0,
                            page: params.page
                        };
                    },
                    cache: true
                },
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

        });
    </script>
@endpush
