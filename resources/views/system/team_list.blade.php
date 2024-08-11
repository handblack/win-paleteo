@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <li class="breadcrumb-item active">Perfiles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('team.index') }}" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="btn-toolbar" role="toolbar">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="#" onclick="location.reload()" class="btn btn-secondary mr-2">
                                        <i class="fas fa-sync-alt fa-fw"></i>
                                    </a>
                                </div>
                                <input type="text" name="q" value="{{ $q }}"
                                    class="form-control float-right" placeholder="Buscar.." autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search"></i>
                                        <span class="d-md-inline-block d-none">BUSCAR</span>
                                    </button>
                                    <a href="{{ route('team.create') }}" class="btn btn-success">
                                        <i class="far fa-plus-square fa-fw"></i>
                                        <span class="d-md-inline-block d-none">NUEVO</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 mt-2">
                    {{ $result->links('layouts.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm table-hover">       
            <tbody>
                @forelse ($result as $item)
                    <tr id="tr-{{ $item->id }}">
                        <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->teamname }}</td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('team.show', $item->token) }}">
                                <i class="fas fa-key fa-fw"></i> Accesos
                            </a> |
                            <a href="{{ route('team.edit', $item->token) }}">
                                <i class="far fa-edit fa-fw"></i>
                            </a> |
                            <a href="#" class="delete-record" data-id="{{ $item->id }}"
                                data-url="{{ route('team.destroy', $item->token) }}">
                                <i class="far fa-trash-alt fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No hay registross!</td>
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
@endsection

@section('content2')
    <div class="card">
        <div class="card-body">
            @forelse ($result as $item)
                <div id="tr-{{ $item->id }}" class="row pb-1 pt-1 div-hover">
                    <div class="col-md-3">
                        {{ $item->teamname }}
                    </div>
                    <div class="col-md-7">
                        @forelse ($item->users as $it)
                            <span class="badge badge-secondary font-weight-light">{{ $it->name }}</span>
                        @empty
                            -
                        @endforelse
                    </div>
                    <div class="col-md-2 text-right">
                        <a href="{{ route('team.show', $item->token) }}">
                            <i class="fas fa-key fa-fw"></i> Accesos
                        </a> |
                        <a href="{{ route('team.edit', $item->token) }}">
                            <i class="far fa-edit fa-fw"></i>
                        </a> |
                        <a href="#" class="delete-record" data-id="{{ $item->id }}"
                            data-url="{{ route('team.destroy', $item->token) }}">
                            <i class="far fa-trash-alt fa-fw"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="row">
                    <div class="col-md-12">
                        No hay registros
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    
@endsection
