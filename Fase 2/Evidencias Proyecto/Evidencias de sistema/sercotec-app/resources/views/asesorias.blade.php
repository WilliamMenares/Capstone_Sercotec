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


    <div style="display: none;">
        @php
            $ambitosPuntajes = []; // Array para almacenar los ámbitos con sus porcentajes, preguntas y respuestas
        @endphp

        @foreach ($encuestas as $encuesta)
            @foreach ($encuesta['formulario']['ambitos'] as $ambito)
                @php
                    $totalPuntajeAmbito = 0;
                    $maxPuntajeAmbito = count($ambito['preguntas']) * 5 ?: 1; // Evitar división por 0

                    // Encontrar la pregunta con el puntaje de respuesta más bajo
                    $preguntaSeleccionada = collect($ambito['preguntas'])->sort(function ($a, $b) {
                        // Encuentra el puntaje mínimo de las respuestas
                        $minPuntajeA = collect($a['respuestas'])->min('tipo.puntaje');
                        $minPuntajeB = collect($b['respuestas'])->min('tipo.puntaje');

                        if ($minPuntajeA === $minPuntajeB) {
                            // Si los puntajes son iguales, compara por el puntaje de la pregunta
                            return $b['puntaje'] <=> $a['puntaje'];
                        }
                        // Comparar por el puntaje mínimo de la respuesta
                        return $minPuntajeA <=> $minPuntajeB;
                    })->first(); // Seleccionar la primera pregunta después de ordenar

                    // Calcular el puntaje total del ámbito
                    foreach ($ambito['preguntas'] as $pregunta) {
                        foreach ($pregunta['respuestas'] as $respuesta) {
                            $totalPuntajeAmbito += $respuesta['tipo']['puntaje'];
                        }
                    }

                    $porcentajeCompletado = ($totalPuntajeAmbito / $maxPuntajeAmbito) * 100;

                    // Agregar ámbito al arreglo con su información completa
                    $ambitosPuntajes[] = [
                        'title' => $ambito['title'],
                        'porcentaje' => $porcentajeCompletado,
                        'preguntas' => [$preguntaSeleccionada], // Solo incluir la pregunta seleccionada
                    ];
                @endphp
            @endforeach
        @endforeach

        @php
            // Ordenar los ámbitos por porcentaje en forma ascendente
            usort($ambitosPuntajes, function ($a, $b) {
                return $a['porcentaje'] <=> $b['porcentaje'];
            });

            // Seleccionar los dos ámbitos con menor porcentaje
            $ambitosMenores = array_slice($ambitosPuntajes, 0, 2);
        @endphp

        <h3>Ámbitos con menor porcentaje de completado:</h3>
        <ul>
            @foreach ($ambitosMenores as $ambito)

                <strong>Ámbito:</strong> {{ $ambito['title'] }}
                <p><strong>Porcentaje Completado:</strong> {{ number_format($ambito['porcentaje'], 2) }}%</p>

                @foreach ($ambito['preguntas'] as $pregunta)

                    <strong>Pregunta:</strong> {{ $pregunta['title'] }}

                    @foreach ($pregunta['respuestas'] as $respuesta)

                    @endforeach

                @endforeach


            @endforeach
        </ul>
    </div>





@endforeach