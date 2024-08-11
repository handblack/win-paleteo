@extends('layouts.app')

@push('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('breadcrumb')
<div class="content-header pb-0">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0"><i class="fas fa-users fa-fw"></i> Usuarios</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Sistema</li>
					<li class="breadcrumb-item active">Usuarios</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="content-header pt-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-5 mt-2">
				<form action="{{ route('user.index') }}" method="GET">
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
								<a href="{{ route('user.create') }}" class="btn btn-success">
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
                <tr>
                    <th>Email</th>
                    <th>Perfil</th>
					<th>Nombre</th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result as $item)
                    <tr>
                        <td class="{{ $item->isactive == 'Y' ? '' : 'tachado'}}">
							{{ $item->email }}
							@if($item->isadmin == 'Y')
								<i class="fas fa-crown fa-fw"></i>
							@endif
						</td>
                        <td class="{{ $item->isactive == 'Y' ? '' : 'tachado'}} text-nowrap">
							@if($item->team_id)
								<a href="{{ route('team.show',$item->team->token) }}">
									{{ $item->team_id ? $item->team->teamname : '' }}
								</a>
							@endif
						</td>
                        <td class="{{ $item->isactive == 'Y' ? '' : 'tachado'}} text-nowrap">{{ $item->name }} {{ $item->lastname }}</td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('user.edit',$item->token) }}">
                                <i class="far fa-edit"></i>
                            </a> |
                            <a href="#" class="delete-record" data-id="{{ $item->user_id }}" data-url="{{ route('user.destroy',$item->token) }}">
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