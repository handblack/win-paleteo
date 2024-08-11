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
@endpush

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="far fa-file-alt fa-fw"></i> Pedidos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
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
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title">PEDIDOS</h3>
                    </div>
                    <div class="card-body pt-1 pb-1 border-bottom">
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                <div class="p-2">
                                    <img src="{{ asset('images/order_logo.png') }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-10 d-flex align-items-center " style="line-height: 1.2">
                                <div class="p-2">
                                    <strong>{{ auth()->user()->get_param('SYSTEM.BPARTNER.NAME', 'MIASOFTWARE NETWORK SAC') }}</strong>
                                    <p class="mb-0" style="font-size: 0.9rem">
                                        {{ auth()->user()->get_param('SYSTEM.BPARTNER.ADDRESS', 'DIRECCION ESTABLECIMIENTO') }}
                                        <br>{{ auth()->user()->get_param('SYSTEM.BPARTNER.EMAIL', 'soporte@miasoftware.net') }}
                                        <br>{{ auth()->user()->get_param('SYSTEM.BPARTNER.PHONE', '987 265 551') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-form">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-0">Cliente</label>
                                <select class="form-control select2-bpartner" name="bpartner_id">

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="mb-0">F.Pedido</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="mb-0">F.Vence</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="mb-0">F.Entrega</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Detalle -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-sm table-sm2" style="font-size: 0.85rem;">
                            <thead class="bg-secondary">
                                <th width="80">SKU</th>
                                <th width="100">CODIGO</th>
                                <th>PRODUCTO</th>
                                <th width="80">PACK</th>
                                <th width="80">CANTIDAD</th>
                                <th class="text-right" width="90">PU</th>
                                <th width="50"></th>
                            </thead>
                            <tbody>
                                @forelse ($row->lines as $item)
                                    <tr id="tr-{{ $item->id }}">
                                        <td>{{ $item->product_id }}</td>
                                        <td></td>
                                        <td>{{ $item->product->productname }}</td>
                                        <td></td>
                                        <td>{{ $item->product->um->shortname }}</td>
                                        <td class="text-right">0.00</td>
                                        <td class="text-right">
                                            <a href="#" class="delete-record" data-id="{{ $item->id }}" data-url="{{ route('templine.destroy',$item->token) }}">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">El documento no tiene item</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10"><small><strong><strong>{{ count($row->lines) }} - Item(s)</strong></small></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-body pt-1 pb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".modal-ProductItem">
                                    <i class="fas fa-plus fa-fw"></i> Agregar Producto
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <p class="lead"><strong>TOTAL</strong> S/ 0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="float-right">
                            <a href="#" onclick="history.back();" class="btn btn-outline-secondary">
                                <i class="fas fa-times fa-fw"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn bg-gradient-info ml-1">
                                <i class="fas fa-save fa-fw"></i>
                                Generar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            Aqui ponemos el texto
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

 
    <!-- Modal -->

    <div class="modal fade modal-ProductItem" role="dialog" aria-labelledby="ProductItem"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('templine.store') }}" autocomplete="off" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="temp_id" value="{{ $row->id }}">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">Agregar Producto/Servicio</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="mb-0">Producto/Servicio</label>
                                    <select class="form-control select2-product" name="product_id">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="mb-0">Presentacion</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-0">Cantidad</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-0">Precio Unitario</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-0">Total</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <a href="#" class="btn btn-outline-secondary" data-dismiss="modal">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Agreagar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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

            $('.select2-bpartner').select2({
                ajax: {
                    url: "{{ route('api_bpartner') }}",
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
                placeholder: 'Selecciona un Socio de Negocio',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
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
                placeholder: 'Selecciona un tejido',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

 
 

        });
    </script>
@endpush