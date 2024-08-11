@extends('layouts.modal')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Hilado</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Gestor Productos</li>
                        <li class="breadcrumb-item active">Hilado</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('hilatura.index') }}" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="btn-toolbar" role="toolbar">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="#" onclick="location.reload()" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt fa-fw"></i>
                                    </a>
                                </div>
                                <input type="text" name="q" value="{{ $q }}"
                                    class="form-control float-right" placeholder="Buscar.." autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                    <a href="{{ route('hilatura.create') }}" class="btn btn-success">
                                        <i class="far fa-plus-square fa-fw"></i>
                                        <span class="d-md-inline-block d-none">NUEVO</span>
                                    </a>
                                    <a href="{{ route('hilatura.show','download') }}" class="btn btn-outline-success">
                                        <i class="fas fa-download fa-fw"></i>
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
					<th width="70%">Identificador</th>
					<th></th>
					<th class="80"></th>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->identity }}</td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->shortname }}</td>
							<td class="text-right text-nowrap">
                                @if($item->id == 1)
                                    <i class="fas fa-lock"></i>
                                    |
                                    <i class="fas fa-lock"></i>
                                @else
                                    <a href="{{ route('familia.edit',$item->token) }}">
                                        <i class="far fa-edit"></i>
                                    </a> |
                                    <a href="#" class="delete-record" data-id="{{ $item->id }}" data-url="{{ route('familia.destroy',$item->token) }}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                @endif
							</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
