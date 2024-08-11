<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="notranslate" translate="no">
    <head>
        <meta charset="UTF-8">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @if(env('APP_ENV') == 'local')
            <!-- Favicon -->
            <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
            <link rel="shortcut icon" href="{{ asset('images/favicon-32x32.png') }}">
        @else
            <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
        <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        
        <title>FlashAccount</title>
        @stack('header')
        @stack('css')
        @stack('style')
        <link rel="stylesheet" href="{{ asset('adminlte/css/layouts-app.css') }}">
        <style>
            .table-borderless > tbody > tr > td,
            .table-borderless > tbody > tr > th,
            .table-borderless > tfoot > tr > td,
            .table-borderless > tfoot > tr > th,
            .table-borderless > thead > tr > td,
            .table-borderless > thead > tr > th {
                border: none;
            }
            .div-hover {background: #fff;}
            .div-hover:hover {background: #f5f5f5;}
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        @include('layouts._navbar')
        @include('layouts._sidebar')

        <div class="content-wrapper">
            @yield('breadcrumb')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
        <script>
            $(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#modalQuerySTOCKForm").submit(function (e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    var formData = {
                        q:$("#modalQuerySTOCKInput").val(),
                        {!! auth()->user()->isadmin == 'Y' ? "u:'".auth()->user()->token."'" : '' !!}
                    };
                    /*
                    $.ajax({
                        type: "POST",
                        url: "{-- route('api_product_fast_stock') --}",
                        //data: $('#modalQuerySTOCKForm').serialize(),
                        data: formData,
                        success: function(data){
                            $('#modalQuerySTOCKResult').html(data);
                        },
                        error: function(){
                            toastr.danger("error petición ajax");
                        }
                    });        
                    */             
                });
        
                $('.delete-record').click(function(e){
                    e.preventDefault()
                    if (confirm('Estas seguro en eliminar?')) {
                        let id = $(this).data('id');
                        let url = $(this).data('url');
                        $.post(url,{_method:'delete'})
                        .done(function(data){
                            if(data.status == 100){
                                $('#tr-'+id).remove();
                                toastr.success('Elemento eliminado');
                            }else{
                                toastr.error(data.message);
                            }
                        })
                        .fail(function(xhr, textStatus, errorThrown) {
                            let data = JSON.parse(xhr.responseText);
                            toastr.error(data.message);
                        });
                    }
                });
                
                toastr.options = {
                    progressBar: true,
                };

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error('{!! $error !!}');
                    @endforeach
                @endif
                @if(\Session::has('danger'))
                    toastr.error('{{ session('danger') }}');
                @endif
                @if(\Session::has('error'))
                    toastr.error('{!! session('error') !!}');
                @endif
                @if(\Session::has('message'))
                    toastr.success('{{ session('message') }}');
                @endif
                @if(\Session::has('warning'))
                    toastr.warning('{{ session('warning') }}');
                @endif
                @if(\Session::has('info'))
                    toastr.info('{{ session('info') }}');
                @endif
                 
            });
            $('#modalQuerySTOCK').on('shown.bs.modal', function () {
                $('#modalQuerySTOCKInput').focus()
            })
        </script>
        @stack('script')
    </body>
</html>