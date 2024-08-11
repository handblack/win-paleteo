@extends('layouts.app')

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
					<li class="breadcrumb-item active">SysAdmin</li>
				</ol>
			</div>
		</div>
	</div>
</div>
@endsection


@section('content')
<form action="{{ $url }}" method="POST" autocomplete="off">
	<input type="hidden" name="_mode" value="{{ $mode }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}" />
    <div class="card">
        <div class="card-body bg-form">
            <div class="row mb-2">
                <div class="col-md-2">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" name="name" value="{{ $row->name }}">
                </div>
                <div class="col-md-3">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $row->lastname }}">
                </div>
                <div class="col-md-4">
                    <label for="">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $row->email }}">
                </div>
                <div class="col-md-3">
                    <label for="">Contraseña</label>
                    <input type="password" class="form-control" name="password" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="mb-0">Telefono</label>
                    <input type="text" class="form-control" name="phone" value="{{ $row->phone }}" maxlength="9">
                </div>
                <div class="col-md-6">
                    <label class="mb-0">Perfil</label>
                    <select name="team_id" class="form-control" required>
                        @if($mode == 'new')
                            <option value="" selected disabled>-- SELECCIONE --</option>
                        @endif
                        @foreach ($teams as $item)
                            <option value="{{ $item->id }}" {{ $row->team_id == $item->id ? 'selected' : '' }}>{{ $item->teamname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-0">Estado</label>
                    <select name="isactive" class="form-control" required>
                        @if($mode == 'new')
                            <option value="" selected disabled>-- SELECCIONE --</option>
                        @endif
                        <option value="Y" {{ $row->isactive == 'Y' ? 'selected' : '' }}>ACTIVO</option>
                        <option value="N" {{ $row->isactive == 'N' ? 'selected' : '' }}>DESACTIVADO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.index') }}" class="btn btn-danger "><i class="fas fa-times fa-fw"></i> CANCELAR</a>
            <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i> {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
        </div>
    </div>
</form>
@endsection