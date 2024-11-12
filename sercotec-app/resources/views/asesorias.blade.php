@extends('layout.menu')

@section('title', 'Asesorias')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">

<link rel="stylesheet" href="{{ asset('css/asesorias.css') }}">

<script src="{{ asset('js/asesoria.js') }}"></script>

@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Crear Asesoria</h1>
    </div>

    <div class="encuesta">
        <div class="buscador">
            <div class="encuinpu">
                <div class="mb-3 contenebus">
                    <label for="empresa" class="form-label text-light">Empresa:</label>
                    <input type="text" class="form-control bg-dark text-light search-empresa" name="empresa"
                        placeholder="Empresa" required>
                    <input type="hidden" class="input-id-empresa" name="id_empresa">
                </div>
                <div class="mb-3 contenebus">
                    <label for="formulario-select" class="form-label text-light">Formulario:</label>
                    <select id="formulario" class="form-select bg-dark text-light">
                        <option value="">Seleccione un formulario</option>
                        @foreach($formularios as $formulario)
                            <option value="{{ $formulario->id }}">{{ $formulario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 contenebus">
                    <label for="empresa" class="form-label text-light">Responsable:</label>
                    <input type="text" class="form-control bg-dark text-light" name="responsable"
                        placeholder="Responsable" value="{{ Auth::user()->name }}" readonly required>
                </div>
            </div>
            <div class="enviarencu">
                <button class="btn btn-primary">Crear Asesoria</button>
            </div>
        </div>
        <div class="ambitos-container">
            @foreach($formularios as $formulario)
                @foreach($formulario->ambitos as $index => $ambito)
                    <div class="ambito text-light" data-formulario="{{ $formulario->id }}" data-index="{{ $index }}"
                        style="display: none;">
                        <div class="preguntas">
                            <div class="pre-enca">
                                <div class="encabepre">
                                    <h2 class="pre1">Preguntas</h2>
                                    <div class="pre2">
                                        <p class="r1">Cumple</p>
                                        <p class="r2">Cumple Parcialmente</p>
                                        <p class="r3">No Cumple</p>
                                    </div>
                                </div>
                                <div class="pre3">
                                {{ $ambito->title }}
                                </div>
                            </div>
                            @foreach($preguntas->where('id_ambito', $ambito->id) as $pregunta)
                                <div class="pre-item">
                                    <div class="pre1">
                                        {{ $pregunta->title }}
                                    </div>
                                    <div class="pre2">
                                        <div class="r1"><input type="radio" name="respuesta_{{ $pregunta->id }}" value="cumple">
                                        </div>
                                        <div class="r2"><input type="radio" name="respuesta_{{ $pregunta->id }}"
                                                value="parcialmente"></div>
                                        <div class="r3"><input type="radio" name="respuesta_{{ $pregunta->id }}" value="no_cumple">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="navegacion">
                            <button id="prev-btn" class="btn btn-secondary">Anterior</button>
                            <button id="next-btn" class="btn btn-primary">Siguiente</button>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

    </div>



</div>



@endsection