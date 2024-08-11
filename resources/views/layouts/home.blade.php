<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
        @if(env('APP_ENV') == 'local')
            <!-- Favicon -->
            <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
            <link rel="shortcut icon" href="{{ asset('images/favicon-32x32.png') }}">
        @else
            <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
        @endif
         

        <title>Login</title>
    </head>
    <body>
        @yield('content')
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
        <script>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.success('{{ $error }}');
                @endforeach
            @endif
            @if (\Session::has('error'))
                toastr.error('{{ session('error') }}');
            @endif
            @if (\Session::has('success'))
                toastr.success('{{ session('success') }}');
            @endif
        </script>
    </body>
</html>