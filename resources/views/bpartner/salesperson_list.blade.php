@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user-tie fa-fw"></i> Ejecutivo de Ventas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item active">Ejecutivo de Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('salesperson.index') }}" method="GET">
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
                                    <a href="{{ route('salesperson.create') }}" class="btn btn-success">
                                        <i class="far fa-plus-square fa-fw"></i>
                                        <span class="d-md-inline-block d-none">NUEVO</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-7 mt-2">
                    {{ $result->links('layouts.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
					<th>Ejecutivo</th>
					<th><i class="far fa-envelope fa-fw"></i> E-Mail</th>
					<th width="100"><i class="fas fa-mobile-alt fa-fw"></i> Movil</th>
					<th width="150"></th>
					<th width="80"></th>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->identity }} 
                                @if($item->shortname)
                                    <span class="badge bg-info">
                                        <i class="fas fa-tags fa-fw"></i>
                                        {{ $item->shortname }}
                                    </span>
                                @endif
                            </td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->email }}</td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->phone }}</td>
                            <td class="text-right text-nowrap">{{ $item->updated_by ? $item->updatedby->name : $item->createdby->name }}</td>
							<td class="text-right text-nowrap">
                                <a href="{{ route('salesperson.edit',$item->token) }}">
                                    <i class="far fa-edit"></i>
                                </a> |
                                <a href="#" class="delete-record" data-id="{{ $item->id }}" data-url="{{ route('salesperson.destroy',$item->token) }}">
                                    <i class="far fa-trash-alt"></i>
                                </a>
							</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
