@extends('layouts.app')

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="far fa-copy"></i> Tipo de Documento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Maestro</li>
                        <li class="breadcrumb-item active">Tipo de Documento</li>
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
            <div class="card-header">
                <h3 class="card-title"><strong>Información</strong></h3>
            </div>
            <div class="card-body bg-form">
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="mb-0">Codigo</label>
                        <input type="text" class="form-control" name="doctypecode" value="{{ old('doctypecode',$row->doctypecode) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-0">Tipo Documento</label>
                        <input type="text" class="form-control" name="doctypename" value="{{ old('doctypename',$row->doctypename) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">Abreviado</label>
                        <input type="text" class="form-control" name="shortname" value="{{ old('shortname',$row->shortname) }}">
                    </div>
                  
                </div>
                <div class="row">
                   
                    <div class="col-md-6">
                        <label class="mb-0">Grupo</label>
                        <select name="doctype_group_id" class="form-control" required>
                            @if ($mode == 'new')
                                <option value="" selected disabled>-- SELECCIONE --</option>
                            @endif
                            @foreach ($group as $item)
                                <option value="{{ $item->id }}" {{ $row->doctype_group_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->doctypegroupname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Estado</label>
                        <select name="isactive" class="form-control" required>
                            @if ($mode == 'new')
                                <option value="" selected disabled>-- SELECCIONE --</option>
                            @endif
                            <option value="Y" {{ $row->isactive == 'Y' ? 'selected' : '' }}>ACTIVO</option>
                            <option value="N" {{ $row->isactive == 'N' ? 'selected' : '' }}>DESACTIVADO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="#" onclick="history.back();" class="btn btn-danger "><i class="fas fa-times fa-fw"></i> CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
            </div>
        </div>
    </form>
@endsection
