<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script> window.statusMessage = @json(session('status'));</script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>

    <div class="main">
        <div class="box-left">
            <div class="logo">
                <img src="{{asset("img/Logo_Sercotec.png")}}" alt="">
            </div>
            <div class="menu">
                <div class="opciones">
                    <a href="/welcome"><i class="bi bi-house"></i>Inicio</a>
                </div>
                <div class="opciones">
                    <a href="/empresa"><i class="bi bi-building"></i>Empresa</a>
                </div>
                <div class="opciones">
                    <a href="/empleados"><i class="bi bi-person"></i>Empleados</a>
                </div>
            </div>
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