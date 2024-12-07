<!DOCTYPE html>
<html>

<head>
    <title>Informe de Asesoría - {{ $encuesta->empresa->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h2,
        h3 {
            color: #2C3E50;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-portada {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .titulo-portada {
            display: flex;
            text-align: center;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo-portada {
            display: block;
            margin: 20px auto;
            max-width: 200px;
            height: auto;
        }

        .ambito {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .ambito h3 {
            color: #2980B9;
        }

        .ambito p {
            line-height: 1.6;
        }

        h4 {
            font-weight: bold;
            color: #16A085;
        }

        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        .grafico {
            width: 200px;
            height: 200px;
            float: right;
            margin-left: 20px;
        }

        .clear {
            clear: both;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="titulo-portada">
        <h1>Informe de Asesoría</h1>
    </div>

    <img src="{{ storage_path('app/public/img/Logo_Sercotec.png') }}" alt="Logo" class="logo-portada">

    <div class="section-portada">
        <h2>Información sobre la asesoría</h2>
        <table>
            <tr>
                <th>Responsable:</th>
                <td>{{$datos_encu[$encuesta->id]['responsable']}}</td>
            </tr>
            @foreach ($datos_encu[$encuesta->id]['empresas'] as $emp)
                <tr>
                    <th>Rut Empresa:</th>
                    <td>{{$emp['rut']}}</td>
                </tr>
                <tr>
                    <th>Nombre Empresa:</th>
                    <td>{{$emp['nombre']}}</td>
                </tr>
                <tr>
                    <th>Contacto:</th>
                    <td>{{$emp['contacto']}}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{$emp['email']}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="page-break"></div>
    <div class="section">
        <h2>Informacion General</h2>
        <p>Puntaje Total Obtenido: {{$datos_encu[$encuesta->id]['obtenido']}} de
            {{$datos_encu[$encuesta->id]['resultado']}}
        </p>
        <p>Porcentaje Total Obtenido
            {{($datos_encu[$encuesta->id]['obtenido'] * 100) / $datos_encu[$encuesta->id]['resultado'] }}
        </p>
    </div>


    <div class="section">
        <h2>Ámbitos </h2>
        @foreach ($datos_encu[$encuesta->id]['ambitos'] as $amb)
            <p>------------------------------------------</p>
            <p>{{$amb['nombre']}}</p>
            <p>Puntaje Obtenido por Ambito: {{$amb['obtenido']}} de {{$amb['resultado']}}</p>
            <p>Porcentaje Total Obtenido : {{($amb['obtenido'] * 100) / $amb['resultado'] }} </p>
            <p></p>
            @foreach ($amb['preguntas'] as $preg)
                <p>{{$preg['nombre']}}</p>
                <p>{{$preg['respuesta']}}</p>
            @endforeach
            <p>------------------------------------------</p>
        @endforeach
    </div>
</body>

</html>