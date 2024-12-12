<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <title>Informe de Asesoría - {{ $encuesta->empresa->nombre }}</title>
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
        <p><strong>Puntaje Total Obtenido:</strong> {{ $datos_encu[$encuesta->id]['obtenido'] }} de
            {{ $datos_encu[$encuesta->id]['resultado'] }}</p>
        <p><strong>Porcentaje Total Obtenido:</strong>
            {{ ($datos_encu[$encuesta->id]['obtenido'] * 100) / $datos_encu[$encuesta->id]['resultado'] }}%</p>

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


    <!-- Ámbitos Section -->
    <div class="section">
        <h2 class="section-title">Plan de trabajo</h2>
        @foreach ($datos_encu[$encuesta->id]['ambitos'] as $amb)
            <div class="ambito">
                <div class="ambito-header">
                    <div class="ambito-name">{{ $amb['nombre'] }}</div>
                    <div class="ambito-score">
                        Puntaje: {{ $amb['obtenido'] }} / {{ $amb['resultado'] }}
                        ({{ round(($amb['obtenido'] * 100) / $amb['resultado'], 2) }}%)
                    </div>
                </div>

                @foreach ($amb['preguntas'] as $preg)
                    <div class="question">
                        <h4 class="question-title">{{ $preg['nombre'] }}</h4>
                        <p><strong>Respuesta:</strong> {{ $preg['respuesta'] }}</p>

                        @if (!empty($preg['feedback']))
                            <div class="feedback">
                                <p><strong>Situación:</strong> {{ $preg['feedback']['situacion'] }}</p>
                                <p><strong>Acciones Recomendadas:</strong></p>
                                <ul>
                                    <li>{{ $preg['feedback']['accion1'] }}</li>
                                    <li>{{ $preg['feedback']['accion2'] }}</li>
                                    <li>{{ $preg['feedback']['accion3'] }}</li>
                                    <li>{{ $preg['feedback']['accion4'] }}</li>
                                </ul>
                            </div>
                        @else
                            <p><em>Sin feedback disponible</em></p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="page-break"></div>

    <!-- Aqui va el grafico de radar. -->


 
</body>

</html>
