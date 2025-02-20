<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
        <style>
            .logo-login {
                width: 80px;
                height: 80px;
            }
        </style>
    </head>
    <body class="hold-transition login-page" style=" background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ asset('dist/images/sidebar/bg.jpg') }});background-size: cover; background-position: center;background-repeat: no-repeat; ">
    
    <h1 style="color: white;">Bem Vindo!!</h1>    
    
    @yield('content')
    </body>

    <!-- jQuery 
    <script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>-->
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>    
</html>
