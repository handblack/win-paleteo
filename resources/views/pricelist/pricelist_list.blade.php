@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('script')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Lista de Precios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Lista de Precio</li>
                        <li class="breadcrumb-item active">Gestor</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5 mt-2">
                    <form action="{{ route('pricelist.index') }}" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="btn-toolbar" role="toolbar">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="#" onclick="location.reload()" class="btn btn-secondary mr-0">
                                        <i class="fas fa-sync-alt fa-fw"></i>
                                    </a>
                                </div>
                                <input type="text" name="q" value="{{ $q }}"
                                    class="form-control float-right" placeholder="Buscar.." autofocus>
                                <div class="input-group-append">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-secondary rounded-0">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                        <a href="#" class="btn btn-secondary" data-toggle="modal"
                                            data-target="#filtroSearch"><i class="fas fa-filter fa-fw"></i></a>
                                    </div>


                                    <div class="btn-group pl-1">
                                        <a href="{{ route('pricelist.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </a>
                                        <button type="button" class="btn btn-success dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item"
                                                href="{{ route('download_pricelist', [0, md5('download' . date('Ymd'))]) }}"><i
                                                    class="far fa-file-excel fa-fw"></i>
                                                Descargar todas las listas</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#exampleModal"><i class="fas fa-upload fa-fw"></i>
                                                Subir archivo</a>


                                            <!--
               
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
                    <th>Identificador</th>
                    <th class="w-25"><i class="fas fa-tags fa-fw"></i></th>
                    <th width="70" class="text-center"><i class="fas fa-dollar-sign fa-fw"></i></th>
                    <th width="70" class="text-center"><i class="far fa-list-alt fa-fw"></i></th>
                    <th width="80"></th>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }}">
                                {{ $item->identity }}
                            </td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }} w-30">{{ $item->shortname }}</td>
                            <td class="{{ $item->isactive == 'N' ? 'tachado' : '' }} text-center">
                                {{ $item->currency_id ? $item->currency->currencycode : '' }}</td>
                            <td class="text-center">{{ count($item->lines) }}</td>
                            <td class="text-right text-nowrap">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="{{ route('pricelist.edit', $item->token) }}"><i
                                            class="far fa-edit fa-fw"></i> Modificar</a>
                                    @if ($item->id == 1)
                                        <span class="dropdown-item disabled">
                                            <i class="fas fa-lock fa-fw"></i> Eliminar
                                        </span>
                                    @else
                                        <a class="dropdown-item" href="#" class="delete-record"
                                            data-id="{{ $item->id }}"
                                            data-url="{{ route('pricelist.destroy', $item->token) }}">
                                            <i class="far fa-trash-alt fa-fw"></i> Eliminar
                                        </a>
                                    @endif
                                    <a class="dropdown-item"
                                        href="{{ route('download_pricelist', [$item->id, md5('download' . date('Ymd'))]) }}"><i
                                            class="fas fa-download fa-fw"></i> Descargar {{ $item->shortname }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('pricelist.show', $item->token) }}">
                                        <i class="fas fa-cubes fa-fw"></i> Productos
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>




    <!-- Modal PRICELIST - UPLOAD -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <form action="{{ route('pricelist_upload_excel') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />                
                <div class="modal-content">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Subir archivo</strong></h3>
                        </div>
                        <div class="card-body bg-form">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx">
                                    <label class="custom-file-label" for="exampleInputFile">Selecciona el archivo</label>
                                    @error('file')
                                        <small class="text-danger">Verifique la Imagen</small>
                                    @enderror
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success ml-1">
                                        <i class="fas fa-cloud-upload-alt fa-fw"></i>
                                        Subir Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
@endpush