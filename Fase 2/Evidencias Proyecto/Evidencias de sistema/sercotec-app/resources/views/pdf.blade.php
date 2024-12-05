<!DOCTYPE html>
<html>
<head>
    <title>Asesoria - {{ $encuesta->empresa->nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .section { margin-bottom: 20px; }
        .header { background-color: #f4f4f4; padding: 10px; }
        .content { padding: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Asesoría</h1>
    </div>
    
    <div class="content">
        <div class="section">
            <h2>Información General</h2>
            <p><strong>Responsable:</strong> {{ $encuesta->user->name }}</p>
            <p><strong>Empresa:</strong> {{ $encuesta->empresa->nombre }}</p>
            <p><strong>Contacto:</strong> {{ $encuesta->empresa->contacto }}</p>
            <p><strong>Email:</strong> {{ $encuesta->empresa->email }}</p>
        </div>

        @php
            // Lógica similar a la del blade original para cálculo de porcentajes
            $ambitosConPorcentaje = [];
            foreach ($encuesta->formulario->ambito as $ambito) {
                $cantidadPreguntas = $ambito->pregunta->count();
                $maxPuntajePosible = 5 * $cantidadPreguntas;

                $puntajeActual = 0;
                foreach ($ambito->pregunta as $pregunta) {
                    foreach ($pregunta->respuesta as $respuesta) {
                        $puntajeActual += $respuesta->respuestasTipo->puntaje;
                    }
                }

                $porcentajeSatisfaccion = ($puntajeActual / $maxPuntajePosible) * 100;

                $ambitosConPorcentaje[] = [
                    'ambito' => $ambito,
                    'porcentaje' => $porcentajeSatisfaccion,
                    'puntajeActual' => $puntajeActual,
                    'maxPuntajePosible' => $maxPuntajePosible
                ];
            }

            usort($ambitosConPorcentaje, function ($a, $b) {
                return $a['porcentaje'] <=> $b['porcentaje'];
            });

            $ambitosMenorPorcentaje = array_slice($ambitosConPorcentaje, 0, 2);
            $ambitoMayorPorcentaje = end($ambitosConPorcentaje);
        @endphp

        <!-- Secciones de ámbitos y feedbacks similar al blade original -->
    </div>
</body>
</html>