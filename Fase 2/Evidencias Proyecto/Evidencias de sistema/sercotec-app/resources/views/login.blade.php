<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="{{asset("css/login.css")}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="{{ asset('js/utils.js') }}"></script>
    <script> window.success = @json(session('success'));</script>
    <script> window.error = @json(session('error'));</script>
</head>

<body>
    <div class="login">
        <div class="titulo">
            <span class="line"></span>
            <h1>Sercotec</h1>
        </div>
        <div class="encabezado">
            <h2>Iniciar Sesion</h2>
            <p>Ingresa tus credenciales para tener acceso</p>
        </div>
        <form class="form" method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required autofocus autocomplete="email" value="{{old('email')}}">
                @error('email') {{$message}} @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    autocomplete="current-password" required>
                @error('password'){{$message}} @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label" for="exampleCheck1">Recuerdame</label>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
        </form>
        <div class="remember">
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</body>

</html>