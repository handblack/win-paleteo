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
    <form id="formulario" action="{{ $url }}" method="POST">
        <input type="hidden" name="_mode" value="{{ $mode }}" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}" />
        <input type="hidden" name="bpartnertype" value="{{ $row->bpartnertype }}">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title"><strong>Registro [{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong></h3>
                    </div>
                    <div class="card-body border-bottom bg-form pb-1 pt-1">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label class="mb-0">Tipo Doc</label>
                                <select name="doctype_id" class="form-control" required>
                                    @if ($mode == 'new')
                                        <option value="" selected disabled>-- SELECCIONE --</option>
                                    @endif
                                    @foreach ($doctype as $item)
                                        <option value="{{ $item->id }}" {{ $row->doctype_id == $item->id ? 'selected' : '' }}>{{ $item->shortname }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="col-md-5">
                                <label class="mb-0">Document No 
                                    <span class="font-weight-light text-success">[ <span id="contador">0</span> ]</span>
                                </label>
                                <div class="input-group mb-0">
                                    <input type="text" class="form-control" placeholder="RUC/DNI/CE" id="taxid" name="documentno"
                                        value="{{ old('documentno', $row->documentno) }}" maxlength="15"/>
                                    <div class="input-group-append">
                                        <a href="#" onclick="consultarRUC();" class="btn btn-primary">SUNAT</a>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-4">
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
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <label class="mb-0">Nombre del Cliente</label>
                                <input type="text" class="form-control" name="bpartnername" id="bpartnername" 
                                    value="{{ old('bpartnername', $row->bpartnername) }}" required maxlength="200"/>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Abreviado</label>
                                <input type="text" class="form-control" name="shortname" id="shortname" 
                                    value="{{ old('shortname', $row->shortname) }}" maxlength="30"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="mb-0">Dirección</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marked-alt fa-fw"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="address" maxlength="200"
                                    value="{{ old('address', $row->address) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="mb-0">Ubigeo</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-globe-americas fa-fw"></i></span>
                                    </div>
                                    <select name="ubigeo_id" class="form-control select2-ubigeo">
                                        @if($row->ubigeo_id)
                                            <option value="{{ $row->ubigeo_id }}">{{ $row->ubigeo->identity2 }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
        
                   
                    <div class="card-footer">
                        <a href="#" onclick="history.back();" class="btn btn-outline-danger">
                            <i class="fas fa-times fa-fw"></i>
                            CANCELAR
                        </a>
                        <button type="submit" class="btn btn-primary ml-1"><i class="fas fa-save fa-fw"></i>
                            {{ $mode == 'new' ? 'CREAR' : 'MODIFICAR' }} </button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title"><strong>Opciones</strong></h3>
                    </div>
                    <div class="card-body bg-form pt-1 pb-1">
                        <div class="row mb-2">
                            <label class="mb-0">Lista de Precio</label>
                            <select name="pricelist_id" class="form-control select2-pricelist" required>
                                @if($mode == 'edit')
                                    <option value="{{ $row->pricelist_id }}" selected>{{ $row->pricelist->identity }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="row mb-2">
                            <label class="mb-0">Ejecutivo de Venta</label>
                            <select name="salesperson_id" class="form-control select2-salespeople" required>
                                @if($mode == 'edit')
                                    <option value="{{ $row->salesperson_id }}" selected>{{ $row->salesperson->identity }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="row mb-2">
                            <label class="mb-0">Clasificación</label>
                            <select name="clasifica_id" class="form-control" required>
                                @if($mode == 'new')
                                    <option value="" disabled selected>--</option>
                                @endif
                                @foreach ($clasifica as $item)
                                    <option value="{{ $item->id }}" {{ $row->clasifica_id == $item->id ? 'selected' : '' }}>{{ $item->identity }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
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
                                <td width="150" style="vertical-align: top;"><strong>{{ \Carbon\Carbon::parse($item->datelog)->format('Y-m-d H:i:s') }}</strong>
                                </td>
                                <td style="vertical-align: top;">
                                    
                                        @foreach ($item->data_before as $k => $v)
                                            @if ($item->data_before->$k != $item->data_after->$k && $k != 'updated_at')
                                                    {{ $k }} <i class="fas fa-angle-double-right fa-fw"></i>
                                                    {{ is_array($v) ? implode(',', $v) : $v }} | 
                                            @endif
                                        @endforeach
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
                pricelist_id:{
                    required:true
                }
            },
            messages:{
                pricelist_id:{
                    required:"Selecciona la lista de precio"
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

            $('.select2-ubigeo').select2({
                ajax: {
                    url: "{{ route('api_ubigeo') }}",
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
                placeholder: 'Selecciona UBIGEO',
                allowClear: true,
                minimumInputLength: 1,
                theme: 'bootstrap4',
            });

            $('.select2-pricelist').select2({
                ajax: {
                    url: "{{ route('api_pricelist') }}",
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
                placeholder: 'Selecciona Lista de Precio',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-salespeople').select2({
                ajax: {
                    url: "{{ route('api_salesperson') }}",
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
                placeholder: 'Selecciona Ejecutivo',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

        });

        $('#taxid').bind('keyup', function(e){
            $('#contador').html($(this).val().length);
        });

        function consultarRUC() {
            let ruc = $('#taxid').val();
            if (esrucok(ruc)) {
				// 20101717098
				$.post("{{ route('api_get_ruc') }}", { numeroRUC: ruc} )
				.done(function( data ) {
					$('#bpartnername').val(data.nombrecompleto);
					//$('#address').val(data.direccion);
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
        $('#taxid').trigger('keyup');
    </script>
@endpush