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
                    <h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Paloteo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item"><a href="{{ route('paloteo.index') }}">Paloteo</a></li>
                        <li class="breadcrumb-item active">Formulario</li>
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
            <div class="card-header">
                <h3 class="card-title"><strong>Registro [{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong></h3>
            </div>
            <div class="card-body bg-form">
                <div class="row mb-2">
                    <div class="col-md-7">
                        <label class="mb-0">NODO</label>
                        <input type="text" class="form-control" name="nodo" id="identity"
                            value="{{ old('nodo', $row->nodo) }}" required />
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">DNI Cliente</label>
                        <input type="text" class="form-control" name="documentno" id="shortname"
                            value="{{ old('documentno', $row->documentno) }}" />
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Número Entrante</label>
                        <input type="text" name="did" value="{{ old('did',$row->did) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-2">

                    <div class="col-md-3">
                        <label class="mb-0">Contamos con Incidencia</label>
                        <select name="isincidencia" id="" class="form-control" required>
                            @if($mode == 'new')
                                <option value="" selected disabled>--</option>
                            @endif
                            <option value="Y" {{ ($row->isincidencia == 'Y' ? 'selected' : '') }}>SI</option>
                            <option value="N" {{ ($row->isincidencia == 'N' ? 'selected' : '') }}>NO</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">Tipo de Incidencia</label>
                        <select name="incidencia_id" id="" class="form-control">
                            @if($mode == 'new')
                                <option value="">--</option>
                            @endif
                            <option value="1" {{ ($row->incidencia_id = 1 ? 'selected' : '') }}>Emisión Incorrecta de recibos</option>
                            <option value="2" {{ ($row->incidencia_id = 2 ? 'selected' : '') }}>Suspensión por error de sistema</option>
                            <option value="3" {{ ($row->incidencia_id = 3 ? 'selected' : '') }}>Masivo declarado caída de nodo</option>
                            <option value="4" {{ ($row->incidencia_id = 4 ? 'selected' : '') }}>Masivo declarado caída de SLA</option>
                            <option value="5" {{ ($row->incidencia_id = 5 ? 'selected' : '') }}>Caída de CRM Experiencia</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Mes que Afecta</label>
                        <select name="month" id="" class="form-control" required>
                            @foreach ($mes as $k => $v)
                                <option value="{{ str_pad($k+1,2,'0',STR_PAD_LEFT) }}">{{ $v }}</option>                                
                            @endforeach                            
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">Comentario</label>
                        <input type="text" name="comment" value="{{ old('comment',$row->comment) }}" class="form-control">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="mb-0">Motivo</label>
                        <select name="subreason_id" id="" class="select2 select2-motivos form-control" required>
                        </select>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="#" onclick="history.back();" class="btn btn-danger"><i class="fas fa-times fa-fw"></i>
                    CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
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

@endsection


@push('script')
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2-motivos').select2({
        ajax: {
            url: "{{ route('api_reason') }}",
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
        placeholder: 'Selecciona un motivo',
        allowClear: true,
        minimumInputLength: 0,
        theme: 'bootstrap4',
    });
});

</script>

@endpush