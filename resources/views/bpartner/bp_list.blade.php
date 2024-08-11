@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users fa-fw"></i> Socio de Negocio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item active">Gestor Maestro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('bpartner.index') }}" method="GET">
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
                                        <a href="{{ route('bpartner.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item" href="{{ route('bpartner.show',md5('download'.date('Ymd'))) }}"><i class="far fa-file-excel fa-fw"></i>
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
						<!-- MODAL - Filtro -->
						<div class="modal fade" id="filtroSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog model-lg" role="document">
								<div class="modal-content">
									<div class="card mb-0">
										<div class="card-header">
											<h3 class="card-title"><strong>Opciones de Filtro</strong></h3>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<label for="inputEmail3" class="col-sm-4 col-form-label">Ubigeo</label>
												<div class="col-sm-8">
													<input type="text" name="find_ubigeo" class="form-control" id="inputEmail3" placeholder="6 digitos">
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="float-right">
												<button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
												<button type="button" class="btn btn-outline-success"><i class="fas fa-search fa-fw"></i> Buscar</button>
											</div>
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
                    <tr>
                        <th width="140">CODIGO</th>
                        <th>CLIENTE</th>
                        <th width="80">PL</th>
                        <th width="70"><i class="fas fa-user-tie fa-fw"></i></th>
                        <th width="30" class="text-center"><i class="fas fa-tachometer-alt fa-fw"></i></th>
                        <th width="80" class="text-center"><i class="fas fa-map-marked-alt fa-fw"></i> UBI</th>
                        <th width="80"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td class="{{ $item->isactive == 'Y' ? '' : 'tachado' }}">
                                {{ $item->bpartnercode }}
                            </td>
                            <td class="{{ $item->isactive == 'Y' ? '' : 'tachado' }} text-nowrap">
                                {{ $item->bpartnername }}
                                @if ($item->shortname)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-tags fa-fw"></i>
                                        <span class="font-weight-light">{{ $item->shortname }}</span>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $item->pricelist->shortname }}</td>
                            <td>{{ $item->salesperson->shortname }}</td>
                            <td class="text-center">{{ $item->clasifica_id ? $item->clasifica->value : '' }}</td>
                            <td class="text-center">{{ $item->ubigeo_id ? $item->ubigeo->ubigeo : '' }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('bpartner.edit', $item->token) }}">
                                    <i class="far fa-edit"></i>
                                </a> |
                                <a href="#" class="delete-record" data-id="{{ $item->user_id }}"
                                    data-url="{{ route('bpartner.destroy', $item->token) }}">
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

    
@endsection
