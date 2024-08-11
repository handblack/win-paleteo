@extends('layouts.app')

@push('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
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
                        <li class="breadcrumb-item"><a href="{{ route('pricelist.index') }}">Gestor</a></li>
                        <li class="breadcrumb-item active">Productos</li>
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
                                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalCreate">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </a>
                                        <button type="button" class="btn btn-success dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item"
                                                href="{{ route('download_pricelist', [session('session_pricelist_id'), md5('download' . date('Ymd'))]) }}"><i
                                                    class="far fa-file-excel fa-fw"></i>
                                                Descargar esta lista</a>
                                            <!--
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#exampleModal"><i class="fas fa-upload fa-fw"></i>
                                                Subir archivo</a>
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
        <div class="card-header">
            <h3 class="card-title"><strong>{{ session('session_pricelist_shortname') }} - {{ session('session_pricelist_identity') }}</strong></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-sm" style="font-size: 0.9rem;">
                <thead>
                    <th width="40">SKU</th>
                    <th>PRODUCTO</th>
                    <th width="70">DIVISA</th>
                    <th width="110" class="text-right">PU SIN</th>
                    <th width="110" class="text-right">PU CON</th>
                    <th width="50"></th>
                </thead>
                <tbody>
                    @foreach ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td>{{ $item->product->productcode }}</td>
                            <td>{{ $item->product->productname }}</td>
                            <td>{{ $item->pricelist->currency->currencycode }}</td>
                            <td class="text-right">{{ number_format($item->priceunit,5) }}</td>
                            <td class="text-right">{{ number_format($item->priceunit_wtax,5) }}</td>
                            <td class="text-right">
                                <a href="#" class="delete-record"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('pricelistline.destroy', $item->token) }}">
                                    <i class="far fa-trash-alt fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal New Product -->
    <div class="modal hide fade" id="modalCreate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('pricelistline.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Agregar Producto a lista de precio</strong></h3>
                                </div>
                                <div class="card-body bg-form">
                                    <div class="input-group mb-0">
                                        <select name="product_id" id="product_id" class="form-control select2-product" required>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save fa-fw"></i> Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Filter -->
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.select2-product').select2({
                ajax: {
                    url: "{{ route('api_product') }}",
                    type: 'post',
                    dataType: 'json',
                    delay: 150,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    cache: true
                },
                placeholder: 'Selecciona el producto',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush