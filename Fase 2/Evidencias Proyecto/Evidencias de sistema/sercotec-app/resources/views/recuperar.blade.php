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
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu nueva contraseña</p>
        </div>

        <form method="POST" class="form" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required placeholder="Correo electrónico">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Nueva contraseña"
                    id="exampleInputEmail1" aria-describedby="passwordHelp" required>
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1"
                    aria-describedby="passwordHelp" required placeholder="Confirmar contraseña">
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
        </form>
    </div>
</body>





</html>