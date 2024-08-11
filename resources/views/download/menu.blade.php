@extends('layouts.app')

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-file-invoice fa-fw"></i> Descargar Reporte</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Reportes</li>
                        <li class="breadcrumb-item active">Descargar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')

 

<form action="{{ route('rpt_paloteo_post') }}" method="POST">
    @csrf
<div class="card">
    <div class="card-body">
        <div class="row">
        
            <div class="col-md-6">
                <label class="mb-0">Asesores</label>
                <select name="user_id" class="form-control">
                    <option value="0">-- TODOS --</option>
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="mb-0">Rango Fecha</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id=""><i
                                class="fas fa-calendar-alt fa-fw"></i></span>
                    </div>
                    <input type="datetime-local" class="form-control" name="dateinit" value="{{ old('dateinit', $dateinit) }}" required>
                    <input type="datetime-local" class="form-control" name="dateend" value="{{ date('Y-m-d H:i') }}" required>
    
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Descargar</button>
    </div>
</div>

</form>

@endsection

