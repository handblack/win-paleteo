@extends('layouts.app')

@push('script')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@section('breadcrumb')
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user-tie fa-fw"></i> Ejecutivo de Ventas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item"><a href="{{ route('salesperson.index') }}">Ejecutivo de Venta</a></li>
                        <li class="breadcrumb-item active">Formulario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form id="formulario" action="{{ $url }}" method="POST">
        <input type="hidden" name="_mode" value="{{ $mode }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}" />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Registro [{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong></h3>
            </div>
            <div class="card-body bg-form">
                <div class="row mb-2">
                    <div class="col-md-9">
                        <label class="mb-0">Apellidos y Nombres</label>
                        <input type="text" class="form-control" name="identity" id="identity"
                            value="{{ old('identity', $row->identity) }}" required />
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">Abreviado</label>
                        <input type="text" class="form-control" name="shortname" id="shortname"
                            value="{{ old('shortname', $row->shortname) }}" />
                    </div>
                </div>
                <div class="row mb-2">

                    <div class="col-md-5">
                        <label class="mb-0">E-mail</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="far fa-envelope fa-fw"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email', $row->email) }}" required/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">Movil</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="fas fa-mobile-alt fa-fw"></i></span>
                            </div>
                            <input type="text" class="form-control" name="phone" id="phone" maxlength="9"
                            value="{{ old('phone', $row->phone) }}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-left">
                    <a href="#" onclick="history.back();" class="btn btn-outline-danger"><i class="fas fa-times fa-fw"></i>
                        CANCELAR</a>
                    <button type="submit" class="btn btn-info ml-1"><i class="fas fa-save fa-fw"></i>
                        {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
                </div>
                <div class="float-right">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-heartbeat fa-fw"></i></span>
                        </div>
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
    $(function(){
        $('#formulario').validate({
            rules:{
                isactive:{
                    required:true
                }
            },
            messages:{
                isactive:{
                    required:"Selecciona el estado"
                }
            },
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush