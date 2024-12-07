<!DOCTYPE html>
<html>
<head>
    <title>Informe de Asesoría - {{ $encuesta->empresa->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    
        h1, h2, h3 {
            color: #2C3E50;
        }
    
        .section {
            margin-bottom: 40px;
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
    <!-- Primera página -->
    <h1>Informe de Asesoría</h1>
    
    <div class="section">
        <h2>Información General</h2>
        <p>Responsable: {{ $encuesta->user->name }}</p>
        <p>Empresa: {{ $encuesta->empresa->nombre }}</p>
        <p>Contacto: {{ $encuesta->empresa->contacto }}</p>
        <p>Email: {{ $encuesta->empresa->email }}</p>
        <p>Formulario: {{ $encuesta->formulario->nombre }}</p>
    </div>

    <div class="page-break"></div>

    <!-- Segunda página -->
    <div class="section">
        <h2>Ámbitos con Menor Porcentaje de Satisfacción</h2>
        @foreach ($ambitosMenorPorcentaje as $ambitoData)
            <div class="ambito">
                <h3>{{ $ambitoData['ambito']->title }}</h3>
                <p>Puntaje: {{ $ambitoData['puntajeActual'] }} de {{ $ambitoData['maxPuntajePosible'] }}</p>
                <p>Porcentaje de Satisfacción: {{ number_format($ambitoData['porcentaje'], 2) }}%</p>
                
                <img src="{{ public_path('charts/' . $ambitoData['chartFileName']) }}" alt="Gráfico de {{ $ambitoData['ambito']->title }}" class="grafico">

                @php
                    $preguntasNoCumple = $ambitoData['ambito']->pregunta->filter(function ($pregunta) {
                        return $pregunta->respuesta->contains(function ($respuesta) {
                            return $respuesta->respuestasTipo->titulo == 'No Cumple';
                        });
                    });
                @endphp
    
                @if ($preguntasNoCumple->isNotEmpty())
                    <h4>Preguntas Que no cumplen:</h4>
                    <ul style="margin-left: 20px;">
                        @foreach ($preguntasNoCumple as $pregunta)
                            <li>{{ $pregunta->title }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="clear"></div>
            </div>
        @endforeach
    </div>

    <div class="page-break"></div>

    <!-- Tercera página y siguientes -->
    <div class="section">
        <h2>Ámbito con Mayor Porcentaje de Satisfacción</h2>
        <div class="ambito">
            <h3>{{ $ambitoMayorPorcentaje['ambito']->title }}</h3>
            <p>Puntaje: {{ $ambitoMayorPorcentaje['puntajeActual'] }} de {{ $ambitoMayorPorcentaje['maxPuntajePosible'] }}</p>
            <p>Porcentaje de Satisfacción: {{ number_format($ambitoMayorPorcentaje['porcentaje'], 2) }}%</p>
            
            <img src="{{ public_path('charts/' . $ambitoMayorPorcentaje['chartFileName']) }}" alt="Gráfico de {{ $ambitoMayorPorcentaje['ambito']->title }}" class="grafico">

            @php
                $preguntasCumple = $ambitoMayorPorcentaje['ambito']->pregunta->filter(function ($pregunta) {
                    return $pregunta->respuesta->contains(function ($respuesta) {
                        return $respuesta->respuestasTipo->titulo == 'Cumple';
                    });
                });
            @endphp

            @if ($preguntasCumple->isNotEmpty())
                <h4>Preguntas que Cumplen:</h4>
                @foreach ($preguntasCumple as $pregunta)
                    <p>- {{ $pregunta->title }}</p>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>