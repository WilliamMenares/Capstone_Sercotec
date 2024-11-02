<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="{{ asset('js/utils.js') }}"></script>
</head>

<body>

    <div class="main">
        <div class="box-left">
            <ul class="menu">
                <img src="{{ asset('img/Logo_Sercotec.png') }}" alt="">
                <ul class="nav flex-column d-flex align-items-center">
                    <li class="nav-item mb-3">
                        <a class="nav-link" aria-current="page" href="/welcome">Inicio</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="/empresa">Empresas</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="/user">Asesores</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="/asesorias">Asesorías</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="/forms">Formulario</a>
                    </li>
                </ul>
                <li class="cerrar">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesion
                    </a>
                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>


        </div>

        <div class="box-rigth">
            <div class="contenido">
                @yield('content')
            </div>

        </div>
    </div>
    <!-- jQuery (necesario para Typeahead) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Typeahead.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js"></script>
    <!-- Luego carga Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script> window.success = @json(session('success'));</script>
    <script> window.error = @json(session('error'));</script>
    @yield('scripts')
</body>

</html>