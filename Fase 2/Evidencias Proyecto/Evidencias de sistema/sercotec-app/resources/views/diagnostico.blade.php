@extends('layout.menu')

@section('title', 'Diagnostico')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">

<link rel="stylesheet" href="{{ asset('css/diagnostico.css') }}">

<script src="{{ asset('js/diagnostico.js') }}"></script>

@section('content')

    <div class="crud">
        <div class="titulo">
            <h1>Crear Diagnostico</h1>
        </div>
        <div id="progreso-general" style="display:none">
            <label for="" class="text-dark">Progreso General</label>
            <div class="progress bg-light">
                <div class="progress-bar progress-bar-striped" id="progreso-bar" role="progressbar" style="width: 0%;"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
        </div>
        <form action="{{ route('diagnostico.store') }}" method="POST" id="form-diagn" class="encuesta">
            <div class="encuesta">
                <div class="buscador">
                    <div class="encuinpu">
                        <div class="mb-3 contenebus">
                            <label for="empresa" class="form-label text-dark">Empresa:</label>
                            <input type="text" class="form-control bg-light text-dark search-empresa"
                                placeholder="Empresa" required>
                            <input type="hidden" class="input-id-empresa" name="id_empresa" required>
                        </div>
                        <div class="mb-3 contenebus">
                            <label for="formulario-select" class="form-label text-dark">Formulario:</label>
                            <select id="formulario" class="form-select bg-light text-dark" name="id_formulario" required>
                                <option value="">Seleccione un formulario</option>
                                @foreach ($formularios as $formulario)
                                    <option value="{{ $formulario->id }}">{{ $formulario->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 contenebus">
                            <label for="empresa" class="form-label text-dark">Responsable:</label>
                            <input type="text" class="form-control bg-light text-dark" placeholder="Responsable"
                                value="{{ Auth::user()->name }}" readonly required>
                            <input type="hidden" name="responsable" value="{{ Auth::user()->id }}" required>
                        </div>
                    </div>

                    <div class="avance">
                        @foreach ($formularios as $formulario)
                            @foreach ($formulario->ambito as $ambito)
                                <div class="progreso text-dark" data-formulario="{{ $formulario->id }}"
                                    style="display:none">
                                    <label for="">{{ $ambito->title }}</label>
                                    <div class="progress bg-light">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>







                </div>
                <div class="ambitos-container">

                    <div class="encabepre">
                        <h2 class="pre1">Preguntas</h2>
                        <div class="pre2">
                            <p class="r1">Cumple</p>
                            <p class="r2">Cumple Parcialmente</p>
                            <p class="r3">No Cumple</p>
                        </div>
                    </div>

                    @foreach ($formularios as $formulario)
                        @foreach ($formulario->ambito as $index => $ambito)
                            <div class="ambito text-dark" data-formulario="{{ $formulario->id }}"
                                data-index="{{ $index }}" style="display: none;">
                                <div class="preguntas">
                                    <div class="pre-enca">
                                        <div class="pre3">
                                            {{ $ambito->title }}
                                        </div>
                                    </div>
                                    <div>
                                        @foreach ($preguntas->where('ambito_id', $ambito->id) as $pregunta)
                                            <div class="pre-item">
                                                <div class="pre1">
                                                    {{ $pregunta->title }}
                                                </div>
                                                <div class="pre2">
                                                    <div class="r1"><input type="radio"
                                                            name="respuesta[{{ $pregunta->id }}]" value="3">
                                                    </div>
                                                    <div class="r2"><input type="radio"
                                                            name="respuesta[{{ $pregunta->id }}]" value="2">
                                                    </div>
                                                    <div class="r3"><input type="radio"
                                                            name="respuesta[{{ $pregunta->id }}]" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @csrf
                            </div>
                        @endforeach
                        <div class="navegacion d-flex justify-content-between">
                            <button type="button" id="prev-btn" class="btn btn-primary">Anterior</button>
                            <button type="submit" class="btn btn-success">Crear Asesoria</button>
                            <button type="button" id="next-btn" class="btn btn-primary">Siguiente</button>
                        </div>
                    @endforeach
                </div>

            </div>

        </form>

        <script>
            document.getElementById('form-diagn').addEventListener('submit', function(event) {
                const selectedFormulario = document.querySelector('#formulario')
                    .value; // Obtener el formulario seleccionado
                if (!selectedFormulario) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulario no seleccionado',
                        text: 'Por favor, seleccione un formulario antes de enviar.',
                    });
                    event.preventDefault(); // Evitar envío si no hay formulario seleccionado
                    return;
                }

                const progressBar = document.getElementById('progreso-bar');
                const progressValue = parseInt(progressBar.getAttribute('aria-valuenow'),
                    10); // Obtener el valor actual de progreso

                if (progressValue < 100) { // Verifica si el progreso es menor a 100
                    event.preventDefault(); // Evita el envío del formulario
                    Swal.fire({
                        icon: 'warning',
                        title: 'Progreso incompleto',
                        text: 'Por favor, complete el progreso al 100% antes de enviar.',
                    });
                    return; // Salir de la función
                }

                // Selecciona solo las preguntas del formulario que está activo
                const preguntas = document.querySelectorAll(
                    `.ambito[data-formulario="${selectedFormulario}"] .pre-item`);
                let formularioValido = true;

                preguntas.forEach((pregunta) => {
                    const radios = pregunta.querySelectorAll(
                        'input[type="radio"]'); // Radios de la pregunta actual
                    const algunaSeleccionada = Array.from(radios).some(radio => radio
                        .checked); // Comprueba si uno está seleccionado

                    if (!algunaSeleccionada) {
                        formularioValido = false;
                    }
                });

                if (!formularioValido) {
                    event.preventDefault(); // Evita el envío del formulario
                    Swal.fire({
                        icon: 'error',
                        title: 'Preguntas sin responder',
                        text: 'Por favor, responde todas las preguntas antes de enviar.',
                    });
                }
            });
        </script>

    </div>



@endsection
