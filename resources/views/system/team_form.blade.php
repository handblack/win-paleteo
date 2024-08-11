@extends('layouts.app')

@section('breadcrumb')
<div class="content-header pb-0">
	<div class="container-fluid">
		<div class="row mb-2">
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
@endsection

@section('content')
<form action="{{ $url }}" method="POST">
	<input type="hidden" name="_mode" value="{{ $mode }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}" />
    <div class="card">
        <div class="card-body bg-form">
            <div class="row">
                <div class="col-md-12">
                    <label for="">Nombre perfil</label>
                    <input type="text" class="form-control" name="teamname" value="{{ $row->teamname }}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('team.index') }}" class="btn btn-danger "><i class="fas fa-times fa-fw"></i> CANCELAR</a>
            <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i> {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
        </div>
    </div>
</form>
@endsection