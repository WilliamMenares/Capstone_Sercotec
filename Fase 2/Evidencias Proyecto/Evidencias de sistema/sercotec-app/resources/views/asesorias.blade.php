@extends('layout.menu')

@section('title', 'Asesorias')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">



@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesorias</h1>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>




    <div id="mobileGrid" class="mobile-table">
        <div class="mobile-table-header">
            <h2>Lista de Asesorías</h2>
        </div>
        <div class="mobile-search">
            <input type="text" id="searchInput" class="form-control bg-dark text-light"
                placeholder="Buscar por id, responsable, empresa, contacto o email">
        </div>
        <div class="mobile-table-body" id="mobileTableBody">
            <!-- Las filas se generarán dinámicamente aquí -->
        </div>
        <nav aria-label="Paginación de empresas">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Los elementos de paginación se generarán dinámicamente con JavaScript -->
            </ul>
        </nav>
    </div>
    @foreach ($encuestas as $encu)
        @php
            // Array para almacenar los porcentajes de cada ámbito
            $ambitosConPorcentaje = [];

            // Calcular porcentajes para todos los ámbitos
            foreach ($encu->formulario->ambito as $ambito) {
                $cantidadPreguntas = $ambito->pregunta->count();
                $maxPuntajePosible = 5 * $cantidadPreguntas;

                $puntajeActual = 0;
                foreach ($ambito->pregunta as $pregunta) {
                    foreach ($pregunta->respuesta as $respuesta) {
                        $puntajeActual += $respuesta->respuestasTipo->puntaje;
                    }
                }

                $porcentajeSatisfaccion = ($puntajeActual / $maxPuntajePosible) * 100;

                // Guardar el ámbito con su porcentaje
                $ambitosConPorcentaje[] = [
                    'ambito' => $ambito,
                    'porcentaje' => $porcentajeSatisfaccion,
                    'puntajeActual' => $puntajeActual,
                    'maxPuntajePosible' => $maxPuntajePosible
                ];
            }

            // Ordenar ámbitos por porcentaje (menor a mayor)
            usort($ambitosConPorcentaje, function ($a, $b) {
                return $a['porcentaje'] <=> $b['porcentaje'];
            });

            // Tomar los dos con menor porcentaje
            $ambitosMenorPorcentaje = array_slice($ambitosConPorcentaje, 0, 2);

            // Tomar el de mayor porcentaje (último elemento del array ordenado)
            $ambitoMayorPorcentaje = end($ambitosConPorcentaje);
        @endphp

        <div class="prueba">
            <div>
                <p>Responsable: {{$encu->user->name}}</p>
                <p>Nombre Empresa: {{$encu->empresa->nombre}}</p>
                <p>Email Empresa: {{$encu->empresa->email}}</p>
                <p>Contacto Empresa: {{$encu->empresa->contacto}}</p>
            </div>
            <div>
                <p>Formulario: {{ $encu->formulario->nombre }}</p>

                <h3>Ámbitos con menor porcentaje de satisfacción:</h3>
                @foreach ($ambitosMenorPorcentaje as $ambitoData)
                        @php
                            $ambito = $ambitoData['ambito'];
                        @endphp

                        <p><strong>Ámbito: {{ $ambito->title }}</strong></p>
                        <p>Puntaje obtenido: {{ $ambitoData['puntajeActual'] }} de {{ $ambitoData['maxPuntajePosible'] }}</p>
                        <p>Porcentaje de Satisfacción: {{ number_format($ambitoData['porcentaje'], 2) }}%</p>

                        @php
                            // Filtrar preguntas con respuesta "No Cumple" en este ámbito
                            $preguntasNoCumple = $ambito->pregunta->filter(function ($pregunta) {
                                return $pregunta->respuesta->contains(function ($respuesta) {
                                    return $respuesta->respuestasTipo->titulo == 'No Cumple';
                                });
                            });

                            // Si hay más de una pregunta con "No Cumple", seleccionar la de mayor prioridad
                            if ($preguntasNoCumple->count() > 1) {
                                $preguntasNoCumple = $preguntasNoCumple->sortByDesc('prioridad')->take(1);
                            }
                        @endphp

                        @foreach ($preguntasNoCumple as $pregunta)
                            <p>Pregunta: {{ $pregunta->title }}</p>
                            @foreach ($pregunta->respuesta as $respuesta)
                                @if ($respuesta->respuestasTipo->titulo == 'No Cumple')
                                    <p>Situación: {{ $respuesta->respuestasTipo->titulo }}</p>
                                    <p>Puntaje: {{ $respuesta->respuestasTipo->puntaje }}</p>

                                    {{-- Buscar feedbacks relacionados --}}
                                    @php
                                        $feedbackRelacionados = $feedbacks->filter(function ($feedback) use ($pregunta, $respuesta) {
                                            return $feedback->pregunta_id === $pregunta->id &&
                                                $feedback->respuestas_tipo_id === $respuesta->respuestatipo_id;
                                        });
                                    @endphp

                                    @if ($feedbackRelacionados->isNotEmpty())
                                        <div class="feedbacks">
                                            <p><strong>Feedbacks:</strong></p>
                                            @foreach ($feedbackRelacionados as $feedback)
                                                <p>Situación: {{ $feedback->situacion }}</p>
                                                <p>Acción 1: {{ $feedback->accion1 }}</p>
                                                <p>Acción 2: {{ $feedback->accion2 }}</p>
                                                <p>Acción 3: {{ $feedback->accion3 }}</p>
                                                <p>Acción 4: {{ $feedback->accion4 }}</p>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No hay feedbacks relacionados.</p>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                @endforeach

                <h3>Ámbito con mayor porcentaje de satisfacción:</h3>
                @php
                    $mostrarAmbitoMayor = false;
                    $ambitoMayor = $ambitoMayorPorcentaje['ambito'];

                    // Verificar que el porcentaje mayor no sea igual a los menores
                    $porcentajeMayor = $ambitoMayorPorcentaje['porcentaje'];
                    $porcentajesMenores = array_map(function ($ambito) {
                        return $ambito['porcentaje'];
                    }, $ambitosMenorPorcentaje);

                    // Verificar si tiene al menos una pregunta en Cumple
                    $tienePreguntasCumple = $ambitoMayor->pregunta->contains(function ($pregunta) {
                        return $pregunta->respuesta->contains(function ($respuesta) {
                            return $respuesta->respuestasTipo->titulo == 'Cumple';
                        });
                    });

                    // Solo mostrar si el porcentaje es diferente a los menores y tiene preguntas Cumple
                    if (!in_array($porcentajeMayor, $porcentajesMenores) && $tienePreguntasCumple) {
                        $mostrarAmbitoMayor = true;

                        // Filtrar preguntas con respuesta "Cumple"
                        $preguntasCumple = $ambitoMayor->pregunta->filter(function ($pregunta) {
                            return $pregunta->respuesta->contains(function ($respuesta) {
                                return $respuesta->respuestasTipo->titulo == 'Cumple';
                            });
                        });

                        // Si hay más de una pregunta con "Cumple", seleccionar la de mayor prioridad
                        if ($preguntasCumple->count() > 1) {
                            $preguntasCumple = $preguntasCumple->sortByDesc('prioridad')->take(1);
                        }
                    }
                @endphp

                @if($mostrarAmbitoMayor)
                    <p><strong>Ámbito: {{ $ambitoMayor->title }}</strong></p>
                    <p>Puntaje obtenido: {{ $ambitoMayorPorcentaje['puntajeActual'] }} de
                        {{ $ambitoMayorPorcentaje['maxPuntajePosible'] }}
                    </p>
                    <p>Porcentaje de Satisfacción: {{ number_format($ambitoMayorPorcentaje['porcentaje'], 2) }}%</p>

                    @foreach ($preguntasCumple as $pregunta)
                        <p>Pregunta: {{ $pregunta->title }}</p>
                        @foreach ($pregunta->respuesta as $respuesta)
                            @if ($respuesta->respuestasTipo->titulo == 'Cumple')
                                <p>Situación: {{ $respuesta->respuestasTipo->titulo }}</p>
                                <p>Puntaje: {{ $respuesta->respuestasTipo->puntaje }}</p>

                                {{-- Buscar feedbacks relacionados --}}
                                @php
                                    $feedbackRelacionados = $feedbacks->filter(function ($feedback) use ($pregunta, $respuesta) {
                                        return $feedback->pregunta_id === $pregunta->id &&
                                            $feedback->respuestas_tipo_id === $respuesta->respuestatipo_id;
                                    });
                                @endphp

                                @if ($feedbackRelacionados->isNotEmpty())
                                    <div class="feedbacks">
                                        <p><strong>Feedbacks:</strong></p>
                                        @foreach ($feedbackRelacionados as $feedback)
                                            <p>Situación: {{ $feedback->situacion }}</p>
                                            <p>Acción 1: {{ $feedback->accion1 }}</p>
                                            <p>Acción 2: {{ $feedback->accion2 }}</p>
                                            <p>Acción 3: {{ $feedback->accion3 }}</p>
                                            <p>Acción 4: {{ $feedback->accion4 }}</p>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No hay feedbacks relacionados.</p>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <p>No hay ámbito con mayor porcentaje que cumpla los criterios requeridos.</p>
                @endif

            </div>
        </div>
    @endforeach

</div>

<script src="{{ asset('js/asesorias.js') }}"></script>

@endsection

@foreach ($encuestas as $encu)

    <div class="modal fade" id="deleteModal{{$encu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Asesoria</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta asesoria?</p>

                </div>
                <div class="modal-footer">
                    <form action="/asesorias/{{$encu->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>








@endforeach