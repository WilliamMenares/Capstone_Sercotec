<!DOCTYPE html>
<html>

<head>
    <title>Informe de Diagnóstico - {{ $encuesta->empresa->nombre }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        :root {
            --primary-color: #2C3E50;
            --secondary-color: #be1717;
            --accent-color: #2980B9;
            --background-light: #f4f6f7;
            --border-color: #E0E0E0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: var(--primary-color);
            background-color: white;
        }

        .cover-page {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--background-light) 0%, white 100%);
            text-align: center;
            padding: 40px;
        }

        .cover-title {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 700;
        }

        .logo-portada {
            max-width: 300px;
            margin-bottom: 40px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .report-info {
            background-color: var(--background-light);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .report-info table {
            width: 100%;
        }

        .report-info th {
            text-align: left;
            color: #2980B9;
            padding-right: 20px;
            width: 40%;
        }

        .report-info td {
            padding: 10px 0;
        }

        .section {
            margin: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: var(--accent-color);
            border-bottom: 3px solid var(--accent-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .ambito {
            background-color: var(--background-light);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid var(--secondary-color);
        }

        .ambito-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .ambito-name {
            font-weight: 700;
            color: var(--primary-color);
        }

        .ambito-score {
            color: var(--secondary-color);
            font-weight: 700;
        }

        .question {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .question-title {
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .feedback {
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .info-ptjes {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Cover Page -->
    <div class="cover-page">
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo-portada">

        <div class="cover-title">
            <h1>Informe de Diagnóstico</h1>
        </div>

        <div class="report-info">
            <table>
                @foreach ($datos_encu[$encuesta->id]['empresas'] as $emp)
                    <tr>
                        <th>Responsable:</th>
                        <td>{{ $datos_encu[$encuesta->id]['responsable'] }}</td>
                    </tr>
                    <tr>
                        <th>Rut Empresa:</th>
                        <td>{{ $emp['rut'] }}</td>
                    </tr>
                    <tr>
                        <th>Nombre Empresa:</th>
                        <td>{{ $emp['nombre'] }}</td>
                    </tr>
                    <tr>
                        <th>Contacto:</th>
                        <td>{{ $emp['contacto'] }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $emp['email'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- General Information -->
    <div class="section">
        <h2 class="section-title">Información General</h2>
        <div class="info-ptjes">
            <p><strong>Puntaje Total Obtenido:</strong> {{ $datos_encu[$encuesta->id]['obtenido'] }} de
                {{ $datos_encu[$encuesta->id]['resultado'] }}
            </p>
            <p><strong>Porcentaje Total Obtenido:</strong>

                {{ round(($datos_encu[$encuesta->id]['obtenido'] * 100) / $datos_encu[$encuesta->id]['resultado'], 2) }}%
            </p>
        </div>




        <!-- for que recorre los ambitos con sus preguntas y con su respuesta. -->
        @foreach ($datos_encu[$encuesta->id]['ambitos'] as $amb)
            <div class="ambito">
                <div class="ambito-header">
                    <div class="ambito-name">{{ $amb['nombre'] }}
                    </div>
                    <div class="ambito-score">
                        Puntaje: {{ $amb['obtenido'] }} de {{ $amb['resultado'] }}
                        ({{ round(($amb['obtenido'] * 100) / $amb['resultado'], 2) }}%)
                    </div>
                </div>

                @foreach ($amb['preguntas'] as $preg)
                    <div class="question">
                        <h4 class="question-title">{{ $preg['nombre'] }}</h4>
                        <p><strong>Respuesta:</strong> {{ $preg['respuesta'] }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>


    <div class="page-break"></div>

    <!-- Aquí va el gráfico de radar -->
    @if ($chartImageBase64 !== 'ERROR_INSUFICIENTES_DATOS')
        <div class="section">
            <h2 class="section-title">Análisis de Ámbitos</h2>
            <div style="width: 600px; height: 600px; margin: 0 auto;">
                <img src="data:image/png;base64,{{ $chartImageBase64 }}" alt="Gráfico de Radar de Ámbitos">
            </div>
        </div>

        <div class="page-break"></div>
    @endif



    <!-- Ámbitos Section -->
    <div class="section">
        <h2 class="section-title">Plan de trabajo</h2>
        @foreach ($datos_plan as $amb)
                <div class="ambito">
                    <div class="ambito-header">
                        <div class="ambito-name">{{ $amb['nombre'] }}</div>
                        <div class="ambito-score">
                            Puntaje: {{ $amb['obtenido'] }} / {{ $amb['resultado'] }}
                            ({{ round(($amb['obtenido'] * 100) / $amb['resultado'], 2) }}%)
                        </div>
                    </div>

                    @php
                        // Orden de preferencia de respuestas
                        $ordenRespuestas = [
                            'No Cumple' => 1,
                            'Cumple Parcialmente' => 2,
                            'Cumple' => 3
                        ];

                        // Encontrar la pregunta con la prioridad más alta y el estado más crítico
                        $preguntaSeleccionada = null;
                        $prioridadActual = 0;
                        $valorRespuestaActual = PHP_INT_MAX;

                        foreach ($amb['preguntas'] as $preg) {
                            // Verificar si la respuesta está en nuestro orden de preferencia
                            if (isset($ordenRespuestas[$preg['respuesta']])) {
                                $valorRespuesta = $ordenRespuestas[$preg['respuesta']];

                                // Si encontramos una respuesta más crítica (valor menor) O
                                // si es la misma criticidad pero mayor prioridad
                                if (
                                    $valorRespuesta < $valorRespuestaActual ||
                                    ($valorRespuesta == $valorRespuestaActual && $preg['prioridad'] > $prioridadActual)
                                ) {
                                    $preguntaSeleccionada = $preg;
                                    $prioridadActual = $preg['prioridad'];
                                    $valorRespuestaActual = $valorRespuesta;
                                }
                            }
                        }
                    @endphp

                    @if ($preguntaSeleccionada)
                        <div class="question">
                            <h4 class="question-title">{{ $preguntaSeleccionada['nombre'] }}</h4>
                            <p><strong>Respuesta:</strong> {{ $preguntaSeleccionada['respuesta'] }}</p>
                            <p><strong>Prioridad Encontrada:</strong> {{ $preguntaSeleccionada['prioridad'] }}</p>

                            @if (!empty($preguntaSeleccionada['feedback']))
                                <div class="feedback">
                                    <p><strong>Situación:</strong> {{ $preguntaSeleccionada['feedback']['situacion'] }}</p>
                                    <p><strong>Acciones Recomendadas:</strong></p>
                                    <ul>
                                        @foreach (['accion1', 'accion2', 'accion3', 'accion4'] as $accion)
                                            @if (!empty($preguntaSeleccionada['feedback'][$accion]))
                                                <li>{{ $preguntaSeleccionada['feedback'][$accion] }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p><em>Sin feedback disponible</em></p>
                            @endif
                        </div>
                    @endif
                </div>
        @endforeach
    </div>



</body>

</html>