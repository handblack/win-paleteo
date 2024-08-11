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
                <h3 class="card-title"><strong>{{ $row->id }}</strong></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <div class="row mr-0 ml-0">
                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Pedidos',                  'prefix' => 'o1'],
                                ['title' => 'Nota de Venta',            'prefix' => '02'],
                                ['title' => 'Cobranzas/Abonos',         'prefix' => '03'],
                                ['title' => 'Pagos/Egresos',            'prefix' => '04'],
                                ['title' => 'Asignacion de anticipos',  'prefix' => '05'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Proceso de OPERACIONES</th>
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
                                ['title' => 'Reporte EECC R1',           'prefix' => 'r1'],
                                ['title' => 'Reporte EECC R2',           'prefix' => 'r2'],
                                ['title' => 'Reporte EECC R3',           'prefix' => 'r3'],
                                ['title' => 'Reporte EECC R4',           'prefix' => 'r4'],
                                ['title' => 'Reporte EECC R5',           'prefix' => 'r5'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Reportes</th>
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
                                ['title' => 'Socio de Negocio',         'prefix' => 'bp'],
                                ['title' => 'SN - Direcciones',         'prefix' => 'bd'],
                                ['title' => 'SN - Cuenta de Banco',     'prefix' => 'bb'],
                                ['title' => 'SN - Contactos',           'prefix' => 'bc'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Socio de Negocio</th>
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
                                
                                ['title' => 'Productos',                'prefix' => 'pr'],
                                ['title' => 'Producto Linea',           'prefix' => 'pl'],
                                ['title' => 'Producto Sublinea',        'prefix' => 'ps'],
                                ['title' => 'Producto Categoria',       'prefix' => 'pc'],
                                ['title' => 'Producto Familia',         'prefix' => 'pf'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Productos</th>
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
            <div class="card-body table-responsive p-0">
                <div class="row mr-0 ml-0">
                    <div class="col-md-6 pr-0 pl-0">
                        @php
                            $master = [
                                ['title' => 'Tipo de Cambio',           'prefix' => 'ex'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Catalogos</th>
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
                                
                                ['title' => 'Tipos de Documentos',                'prefix' => 'td'],
                            ];
                        @endphp
                        <table class="table table-sm table-sm2 table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th></th>
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
                <a href="{{ route('teamgrant.index') }}" class="btn btn-danger "><i class="fas fa-times fa-fw"></i>
                    CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
            </div>
        </div>
    </form>
@endsection
