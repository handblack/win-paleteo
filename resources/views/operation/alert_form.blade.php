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
    <form action="{{ $url }}" method="POST" autocomplete="off">
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
                        <select name="source_id" id="" class="form-control">
                            @foreach ($sou as $item)
                                <option value="{{ $item->id }}">{{ $item->identity }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-9">
                        <label class="mb-0">AsuntoX</label>
                        <input type="text" class="form-control" name="subject" id="subject"
                            value="{{ old('subject', $row->subject) }}" required />
                    </div>                    
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <select name="user_id" id="user_id" class="form-control select2-user">

                        </select>
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <textarea name="message" id="message"  rows="4" class="form-control" placeholder="Mensaje">{{ $row->message }}</textarea>
                    </div>
                </div>
                {{--
                <div class="row mb-2">
                    <div class="col-md-12">
                        <textarea name="message" id="message"  rows="4" class="form-control" placeholder="Respuesta">{{ $row->response }}</textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="mb-0">Archivo PDF, DOC,y XLS</label>
                        <input type="file" class=form-control>
                    </div>
                </div>
                --}}

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