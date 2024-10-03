<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script> window.statusMessage = @json(session('status'));</script>
</head>

<body>

    <div class="main">
        <div class="box-left">
            Menu
        </div>

        <div class="box-rigth" id="@yield('buscador', 'default-id')">
            <div class="buscador">
                Buscador
            </div>
            <div class="contenido">
                @yield('content')
            </div>

        </div>
    </div>

</body>

</html>