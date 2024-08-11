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
				<h1 class="m-0"><i class="fas fa-users fa-fw"></i> Socio de Negocio</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Socio de Negocio</li>
					<li class="breadcrumb-item active">Gestor Maestro</li>
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
            <div class="card-header">
                <h3 class="card-title"><strong>Registro [{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong></h3>
            </div>
            <div class="card-body border-bottom bg-form">
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="mb-0">Tipo</label>
                        <select name="bpartnertype" class="form-control">
                            <option value="C" {{ $row->bpartnertype == 'C' ? 'selected' : '' }}>CLIENTE</option>
                            <option value="P" {{ $row->bpartnertype == 'P' ? 'selected' : '' }}>PROVEEDOR</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Tipo de Documento</label>
                        <select name="doctype_id" class="form-control" required>
                            @if ($mode == 'new')
                                <option value="" selected disabled>-- SELECCIONE --</option>
                            @endif
                            @foreach ($doctype as $item)
                                <option value="{{ $item->id }}" {{ $row->doctype_id == $item->id ? 'selected' : '' }}>{{ $item->shortname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="mb-0">Document No</label>
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" placeholder="RUC/DNI/CE" id="taxid" name="documentno"
                                value="{{ old('documentno', $row->documentno) }}" maxlength="11" />
                            <div class="input-group-append">
                                <a href="#" onclick="consultarRUC();" class="btn btn-primary">SUNAT</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="col-md-7">
                    <label class="mb-0">Nombre del Proveedor</label>
                    <input type="text" class="form-control" name="bpartnername" id="bpartnername" 
                        value="{{ old('bpartnername', $row->bpartnername) }}" required />
                </div>
            </div>
            <div class="card-body border-bottom bg-light">
                <div class="row">
                    <div class="col-md-8">
                        <label class="mb-0">Dirección</label>
                        <input type="text" class="form-control" name="address" id="address" 
                            value="{{ old('address', $row->address) }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">Pais
                            @if ($mode == 'edit' && !$row->country_id)
                                -> {{ $row->country_name }}
                            @endif
                        </label>
                        <select name="country_id" class="form-control select2-country">
                            @if ($mode == 'edit' && $row->country_id)
                                <option value="{{ $row->country_id }}" selected>{{ $row->country->countryname }}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body bg-form">
                <div class="row">
                    <div class="col-md-3">
                        <label class="mb-0">Telefono</label>
                        <input type="text" class="form-control" name="phone1"
                            value="{{ old('phone1', $row->phone1) }}" />
                    </div>
                    <div class="col-md-7">
                        <label class="mb-0">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $row->email }}" />
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Estado</label>
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
            <div class="card-footer">
                {{--
				<a href="{{ route('bpartner.index',['q' => session('session_provider_q_search')]) }}" class="btn btn-danger "><i class="fas fa-times fa-fw"></i> CANCELAR</a>
			--}}
                <a href="#" onclick="history.back();" class="btn btn-danger"><i class="fas fa-times fa-fw"></i>
                    CANCELAR</a>
                <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                    {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
            </div>
        </div>
    </form>

    @if(count($log))
        <div class="row">
            <div class="col-md-12">
                <table width="100%" class="table-hover table-borderless" style="line-height:1;font-size:0.8rem;">
                    <tbody>
                        @foreach ($log as $item)
                            <tr>
                                <td width="150" style="vertical-align: top;"><strong>{{ $item->datelog }}</strong>
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
            $('.select2-country').select2({
                ajax: {
                    url: "#",
                    type: 'post',
                    dataType: 'json',
                    delay: 150,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            s: 0,
                            page: params.page
                        };
                    },
                    cache: true
                },
                allowClear: true,
                minimumInputLength: 1,
                theme: 'bootstrap4',
            });

            

        });

        function consultarRUC() {
            let ruc = $('#taxid').val();
            if (esrucok(ruc)) {
				// 20101717098
				$.post("{{ route('api_get_ruc') }}", { numeroRUC: ruc} )
				.done(function( data ) {
					$('#provider_name').val(data.nombrecompleto);
					$('#address').val(data.direccion);
					toastr.success('RUC ' + ruc + ' confirmado!');
				})
				.fail(function() {
					toastr.error('Error en API consultaRUC')
				});
            } else {
                toastr.error('RUC no válido')
            }
            console.log(ruc);
        }


        function esrucok(dato) {
            return (!(esnulo(dato) || !esnumero(dato) || !eslongrucok(dato) || !valruc(dato)));
        }

        function esnulo(dato) {
            return (dato == null || dato == "");
        }

        function esnumero(dato) {
            return (!(isNaN(dato)));
        }

        function eslongrucok(dato) {
            return (dato.length == 11);
        }

        function trim(dato) {
            var cadena2 = "";
            len = dato.length;
            for (var i = 0; i <= len; i++)
                if (dato.charAt(i) != " ") {
                    cadena2 += dato.charAt(i);
                }
            return cadena2;
        }

        function longitudmayor(campo, len) {
            return (campo != null) ? (campo.length > len) : false;
        }

        function valruc(valor) {
            valor = trim(valor)
            if (esnumero(valor)) {
                if (valor.length == 8) {
                    suma = 0
                    for (i = 0; i < valor.length - 1; i++) {
                        digito = valor.charAt(i) - '0';
                        if (i == 0) suma += (digito * 2)
                        else suma += (digito * (valor.length - i))
                    }
                    resto = suma % 11;
                    if (resto == 1) resto = 11;
                    if (resto + (valor.charAt(valor.length - 1) - '0') == 11) {
                        return true
                    }
                } else if (valor.length == 11) {
                    suma = 0
                    x = 6
                    for (i = 0; i < valor.length - 1; i++) {
                        if (i == 4) x = 8
                        digito = valor.charAt(i) - '0';
                        x--
                        if (i == 0) suma += (digito * x)
                        else suma += (digito * x)
                    }
                    resto = suma % 11;
                    resto = 11 - resto

                    if (resto >= 10) resto = resto - 10;
                    if (resto == valor.charAt(valor.length - 1) - '0') {
                        return true
                    }
                }
            }
            return false;
        }
    </script>
@endpush