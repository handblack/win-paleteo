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
                    <h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Mensajeria</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item"><a href="{{ route('paloteo.index') }}">Mensajeria</a></li>
                        <li class="breadcrumb-item active">Formulario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ $url }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="_mode" value="{{ $mode }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}" />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Registro para Supervidor / Coordinador[{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong></h3>
            </div>
            <div class="card-body bg-form">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="mb-0">Origen</label>
                        <span class="input-group-text">{{ $row->source->identity }}</span>
                    </div> 
                    <div class="col-md-9">
                        <label class="mb-0">Asunto</label>
                        <span class="input-group-text">{{ $row->subject }}</span>
                    </div>                    
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <span class="input-group-text">{{ $row->user->name . ' - ' . $row->user->lastname  }}</span>
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <textarea rows="4" class="form-control" disabled>{{ $row->message }}</textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="mb-0" class="mb-0">Voz Cliente</label>
                        <input type="text" name="msg_cliente" value="{{ old('msg_cliente',$row->msg_cliente) }}" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="mb-0" class="mb-0">Oportunidad de Mejora</label>
                        <textarea name="msg_mejora" id="msg_mejora"  rows="4" class="form-control" placeholder="Respuesta" required>{{ old('msg_mejora',$row->msg_mejora) }}</textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="mb-0" class="mb-0">Fortalezas en la llamada</label>
                        <textarea name="msg_fortaleza" id="msg_fortaleza"  rows="4" class="form-control" placeholder="Respuesta" required>{{ old('msg_fortaleza',$row->msg_fortaleza) }}</textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="mb-0" class="mb-0">Acciones correctivas</label>
                        <textarea name="msg_acciones" id="msg_acciones"  rows="4" class="form-control" placeholder="Respuesta" required>{{ old('msg_acciones',$row->msg_acciones) }}</textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="mb-0" class="mb-0">Adjuntar archivo de IMAGEN</label>
                        <input type="file" name="foto" id="file-input" accept="image/png, image/gif, image/jpeg" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="#" onclick="history.back();" class="btn btn-danger"><i class="fas fa-times fa-fw"></i>
                    CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'ENVIAR' }} </button>
            </div>
        </div>
    </form>

  

@endsection


@push('script')
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2-user').select2({
        ajax: {
            url: "{{ route('api_asesor') }}",
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
        placeholder: 'Selecciona un Asesor',
        allowClear: true,
        minimumInputLength: 0,
        theme: 'bootstrap4',
    });
});

</script>

@endpush