@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Maestro</li>
                        <li class="breadcrumb-item active">Gestor Productos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('product.index') }}" method="GET">
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
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-outline-primary rounded-0">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#filtroSearch"><i class="fas fa-filter fa-fw"></i></a>
                                    </div>
                                    <div class="btn-group pl-1">
                                        <a href="{{ route('product.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item" href="{{ route('product.show',md5('download'.date('Ymd'))) }}"><i class="far fa-file-excel fa-fw"></i>
                                                Descargar Excel</a>
                                            <!--
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#">Separated link</a>
											-->
                                        </div>
                                    </div>

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
					<th width="100">SKU</th>
					<th>PRODUCTO</th>
					<th>GRUPO</th>
					<th class="text-center" width="60"><i class="fas fa-box-open fa-fw"></i></th>
					<th class="text-center" width="60">UM</th>
					<th></th>
					<th width="80"></th>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->productcode }}</td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">{{ $item->productname }}</td>
                            <td>{{ $item->group->identity }}</td>
                            <td class="text-center">{{ $item->presentacion->shortname }}</td>
                            <td class="text-center">{{ $item->um->shortname }}</td>
                            <td class="text-right text-nowrap">{{ $item->updated_by ? $item->updatedby->name : $item->createdby->name }}</td>
							<td class="text-right text-nowrap">
								<a href="{{ route('product.edit',$item->token) }}">
									<i class="far fa-edit"></i>
								</a> |
								<a href="#" class="delete-record" data-id="{{ $item->id }}" data-url="{{ route('product.destroy',$item->token) }}">
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
