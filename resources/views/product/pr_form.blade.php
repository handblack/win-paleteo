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
				<h1 class="m-0"><i class="fas fa-cubes fa-fw"></i> Productos</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Maestro</li>
					<li class="breadcrumb-item"><a href="{{ route('product.index') }}">Gestor Productos</a></li>
					<li class="breadcrumb-item active">Producto</li>
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
        <div class="card pb-0">
            
            <div class="card-body border-bottom bg-form pt-1 pb-1">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="mb-0">Codigo/Grupo 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('group.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="group_id" class="form-control select2-group" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->group_id }}" selected>{{ $row->group->identity }}</option>
                            @else
                                
                            @endif
                        </select>
                    </div>
                    <div class="col-md-9">
                        <label class="mb-0">Nombre del Producto</label>
                        <input type="text" class="form-control" name="productname" id="productname"
                            value="{{ old('productname', $row->productname) }}" required />
                    </div>

                </div>
            </div>
            <div class="card-body border-bottom bg-light">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="mb-0">Familia 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('familia.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="familia_id" class="form-control select2-family" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->familia_id }}" selected>{{ $row->familia->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">SubFamilia 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('subfamilia.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="subfamilia_id" class="form-control select2-subfamilia" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->subfamilia_id }}" selected>{{ $row->subfamilia->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>  
                    <div class="col-md-4">
                        <label class="mb-0">Tejido 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('tejido.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="tejido_id" class="form-control select2-tejido" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->tejido_id }}" selected>{{ $row->tejido->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="mb-0">Hilatura 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('hilatura.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="hilatura_id" class="form-control select2-hilatura" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->hilatura_id }}" selected>{{ $row->hilatura->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="mb-0">Titulo 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('titulo.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="titulo_id" class="form-control select2-titulo" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->titulo_id }}" selected>{{ $row->titulo->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                     
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="mb-0">Gama 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('gama.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="gama_id" class="form-control select2-gama" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->gama_id }}" selected>{{ $row->gama->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">Teñido 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('tenido.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="tenido_id" class="form-control select2-tenido" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->tenido_id }}" selected>{{ $row->tenido->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0">Acabado 
                            <a href="#" onclick="loadIframe(this);" data-url="{{ route('acabado.index') }}" data-toggle="modal" data-target="#exampleModal">[+]</a>
                        </label>
                        <select name="acabado_id" class="form-control select2-acabado" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->acabado_id }}" selected>{{ $row->acabado->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>                    
                </div>
            </div>
            <div class="card-body bg-form  pt-1 pb-3" style="display:none">
                <div class="row">
                    <div class="col-md-4">
                        <label class="mb-0">Presentación</label>
                        <select name="presentacion_id" class="form-control select2-presentacion" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->presentacion_id }}" selected>{{ $row->presentacion->identity }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>    
                    <div class="col-md-4">
                        <label class="mb-0">Unidad de Medida</label>
                        <select name="um_id" class="form-control select2-um" required>
                            @if ($mode == 'edit')
                                <option value="{{ $row->um_id }}" selected>{{ $row->um->umname }}</option>
                            @else
                                <option value="1" selected>--</option>
                            @endif
                        </select>
                    </div>    
                    <div class="col-md-2">
                        <label class="mb-0"></label>
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
    <!-- Modal -->
    <div class="modal hide fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style='max-width: 1110px;height: 620px;'>
             
            <div class="modal-content">
                
                
                <div class="modal-body p-1 bg-secondary">
                    <iframe id="iframeload" src="" frameborder="0" style='width: 1100px;height: 634px;position: relative;' scrolling="no" allowfullscreen>

                    </iframe>
                </div>
                <!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                -->
            </div>
        </div>
    </div>
@endsection

@push('style2')
<style>
.modal-dialog {
  width: 98%;
  height: 92%;
  padding: 0;
}

.modal-content {
  height: 99%;
}
</style>
@endpush


@push('script')
    <script>
function loadIframe(t){
    let url = $(t).data('url');
    $('#iframeload').attr('src',url);
    $('#iframeload').trigger('onload');
    //this.style.height=(this.contentWindow.document.body.scrollHeight+5)+'px';
}
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.select2-family').select2({
                ajax: {
                    url: "{{ route('api_product_family') }}",
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
                placeholder: 'Selecciona una Familia',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-tejido').select2({
                ajax: {
                    url: "{{ route('api_product_tejido') }}",
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

            $('.select2-subfamilia').select2({
                ajax: {
                    url: "{{ route('api_product_subfamilia') }}",
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
                placeholder: 'Selecciona un sub-familia',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-hilatura').select2({
                ajax: {
                    url: "{{ route('api_product_hilatura') }}",
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
                placeholder: 'Selecciona una Hilatura',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-titulo').select2({
                ajax: {
                    url: "{{ route('api_product_titulo') }}",
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
                placeholder: 'Selecciona el titulo',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-gama').select2({
                ajax: {
                    url: "{{ route('api_product_gama') }}",
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
                placeholder: 'Selecciona la gama',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-tenido').select2({
                ajax: {
                    url: "{{ route('api_product_tenido') }}",
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
                placeholder: 'Seleccione el teñido',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-acabado').select2({
                ajax: {
                    url: "{{ route('api_product_acabado') }}",
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
                placeholder: 'Selecciona el acabado',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-presentacion').select2({
                ajax: {
                    url: "{{ route('api_product_presentacion') }}",
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
                placeholder: 'Selecciona el acabado',
                allowClear: true,
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-um').select2({
                ajax: {
                    url: "{{ route('api_product_um') }}",
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
                placeholder: 'Selecciona Grupo',                
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

            $('.select2-group').select2({
                ajax: {
                    url: "{{ route('api_product_group') }}",
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
                placeholder: 'Selecciona Grupo',                
                minimumInputLength: 0,
                theme: 'bootstrap4',
            });

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

 