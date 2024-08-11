@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
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
                                <select class="form-control">

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
                        <table class="table table-sm">
                            <thead class="bg-secondary">
                                <th>SKU</th>
                                <th>CODIGO</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>PU</th>
                            </thead>
                            <tbody>

                            </tbody>
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

    @if (count($log))
        <div class="row">
            <div class="col-md-12">
                <table width="100%" class="table-hover table-borderless" style="line-height:1;font-size:0.8rem;">
                    <tbody>
                        @foreach ($log as $item)
                            <tr>
                                <td width="150" style="vertical-align: top;">
                                    <strong>{{ $item->datelog }}</strong>
                                </td>
                                <td style="vertical-align: top;">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($item->data_before as $k => $v)
                                            @if ($item->data_before->$k != $item->data_after->$k && $k != 'updated_at')
                                                <li>{{ $k }} <i class="fas fa-angle-double-right fa-fw"></i>
                                                    {{ is_array($v) ? implode(',', $v) : $v }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-right" style="vertical-align: top;">
                                    {{ $item->createdby->name }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal -->

    <div class="modal fade modal-ProductItem" tabindex="-1" role="dialog" aria-labelledby="ProductItem"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Producto/Servicio</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="mb-0">Producto/Servicio</label>
                                <select class="form-control">
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
                            <a href="#" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <a href="#" class="btn btn-primary">
                                Agreagar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
