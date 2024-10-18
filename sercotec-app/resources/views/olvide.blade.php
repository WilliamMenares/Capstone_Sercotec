<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="{{asset("css/login.css")}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="login">
        <div class="titulo">
            <span class="line"></span>
            <h1>Sercotec</h1>
        </div>
        <div class="encabezado">
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu correo para recuperar acceso</p>
        </div>
        <form class="form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required autofocus value="{{old('email')}}">
                @error('email')@enderror
            </div>
            <button type="submit" class="btn btn-primary">Enviar correo</button>
        </form>
    </div>
</body>

</html>
