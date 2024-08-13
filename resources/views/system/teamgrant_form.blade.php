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
                        <li class="breadcrumb-item">Perfiles</li>
                        <li class="breadcrumb-item active">Accesos</li>
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
            <div class="card-header bg-dark">
                <h3 class="card-title"><strong>{{ $row->team->teamname }}</strong></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <div class="row mr-0 ml-0">
                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Motivos',                  'prefix' => 'ra'],
                                ['title' => 'SubMotivos',               'prefix' => 'rs'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Maestro</th>
                                    <th class=""><i class="fas fa-sign-in-alt fa-fw"></i></th>
                                    <th class=""><i class="far fa-file fa-fw"></i></th>
                                    <th class=""><i class="fas fa-edit fa-fw"></i></th>
                                    <th class=""><i class="far fa-trash-alt fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($master as $item)
                                    @php
                                        $fieldgrant = "{$item['prefix']}_isgrant";
                                        $fieldcreated = "{$item['prefix']}_iscreated";
                                        $fieldupdated = "{$item['prefix']}_isupdated";
                                        $fielddeleted = "{$item['prefix']}_isdeleted";
                                    @endphp
                                    <tr>
                                        <td>{{ $item['title'] }}</td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldgrant }}" id="{{ $fieldgrant }}"
                                                        {{ $row->$fieldgrant == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldgrant }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldcreated }}" id="{{ $fieldcreated }}"
                                                        {{ $row->$fieldcreated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldcreated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldupdated }}" id="{{ $fieldupdated }}"
                                                        {{ $row->$fieldupdated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldupdated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fielddeleted }}" id="{{ $fielddeleted }}"
                                                        {{ $row->$fielddeleted == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fielddeleted }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Descarga Paloteo',          'prefix' => 'r1'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Reporte</th>
                                    <th class=""><i class="fas fa-sign-in-alt fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($master as $item)
                                    @php
                                        $fieldgrant = "{$item['prefix']}_isgrant";
                                    @endphp
                                    <tr>
                                        <td>{{ $item['title'] }}</td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldgrant }}" id="{{ $fieldgrant }}"
                                                        {{ $row->$fieldgrant == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldgrant }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <div class="row mr-0 ml-0">
                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Paloteo',                  'prefix' => 'pa'],                                
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Operaciones</th>
                                    <th class=""><i class="fas fa-sign-in-alt fa-fw"></i></th>
                                    <th class=""><i class="far fa-file fa-fw"></i></th>
                                    <th class=""><i class="fas fa-edit fa-fw"></i></th>
                                    <th class=""><i class="far fa-trash-alt fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($master as $item)
                                    @php
                                        $fieldgrant = "{$item['prefix']}_isgrant";
                                        $fieldcreated = "{$item['prefix']}_iscreated";
                                        $fieldupdated = "{$item['prefix']}_isupdated";
                                        $fielddeleted = "{$item['prefix']}_isdeleted";
                                    @endphp
                                    <tr>
                                        <td>{{ $item['title'] }}</td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldgrant }}" id="{{ $fieldgrant }}"
                                                        {{ $row->$fieldgrant == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldgrant }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldcreated }}" id="{{ $fieldcreated }}"
                                                        {{ $row->$fieldcreated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldcreated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldupdated }}" id="{{ $fieldupdated }}"
                                                        {{ $row->$fieldupdated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldupdated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fielddeleted }}" id="{{ $fielddeleted }}"
                                                        {{ $row->$fielddeleted == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fielddeleted }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Gestor de Mensajes',      'prefix' => 'al'],
                                ['title' => 'Respuesta de Mensajes',   'prefix' => 'ar'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Mensajeria</th>
                                    <th class=""><i class="fas fa-sign-in-alt fa-fw"></i></th>
                                    <th class=""><i class="far fa-file fa-fw"></i></th>
                                    <th class=""><i class="fas fa-edit fa-fw"></i></th>
                                    <th class=""><i class="far fa-trash-alt fa-fw"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($master as $item)
                                    @php
                                        $fieldgrant = "{$item['prefix']}_isgrant";
                                        $fieldcreated = "{$item['prefix']}_iscreated";
                                        $fieldupdated = "{$item['prefix']}_isupdated";
                                        $fielddeleted = "{$item['prefix']}_isdeleted";
                                    @endphp
                                    <tr>
                                        <td>{{ $item['title'] }}</td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldgrant }}" id="{{ $fieldgrant }}"
                                                        {{ $row->$fieldgrant == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldgrant }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldcreated }}" id="{{ $fieldcreated }}"
                                                        {{ $row->$fieldcreated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldcreated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fieldupdated }}" id="{{ $fieldupdated }}"
                                                        {{ $row->$fieldupdated == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fieldupdated }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50" class="text-left">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="{{ $fielddeleted }}" id="{{ $fielddeleted }}"
                                                        {{ $row->$fielddeleted == 'Y' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="{{ $fielddeleted }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
      
            
 
            <div class="card-footer">
                <a href="{{ route('team.index') }}" class="btn btn-danger "><i class="fas fa-times fa-fw"></i>
                    CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
            </div>
        </div>
    </form>
@endsection
