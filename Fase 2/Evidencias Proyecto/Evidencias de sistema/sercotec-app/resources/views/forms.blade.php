@if (auth()->user()->rol == 0)
@extends('layout.menu')

@section('title', 'Ambitos y Preguntas')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<script src="{{ asset('js/forms.js') }}"></script>


@section('content')

    <div class="crud">
        <div class="titulo">
            <h1>Ambitos y Preguntas</h1>
        </div>
    </div>
    <div class="tables-container ">
        <!-- Ambitos Table -->
        <div class="table-card d-none d-lg-block">
            <h2>Ambitos</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar ambito" class="search-input" data-table="ambitos-table">
            </div>
            <div class="table-content" id="ambitos-table">
                @foreach ($ambitos as $ambito)
                    <div class="table-row" data-id="{{ $ambito->id }}">
                        <div class="field-group">
                            <label>Nombre:</label>
                            <div class="field-value">{{ $ambito->title }}</div>
                        </div>
                        <div class="button-group">
                            <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $ambito->id }}">
                                Editar
                            </button>
                            <button class="btn-delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $ambito->id }}">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav aria-label="Ambitos pagination">
                <ul class="pagination justify-content-center" id="ambitos-pagination">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
                Crear un Ambito
            </button>
        </div>

        <!-- Preguntas Table -->
        <div class="table-card d-none d-lg-block">
            <h2>Preguntas</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar" class="search-input" data-table="preguntas-table">
            </div>
            <div class="table-content" id="preguntas-table">
                @foreach ($preguntas as $pregunta)
                    <div class="table-row" data-id="{{ $pregunta->id }}">
                        <div class="field-group">
                            <label>Pregunta:</label>
                            <div class="field-value">{{ $pregunta->title }}</div>
                        </div>
                        <div class="field-group">
                            <label>Puntaje:</label>
                            <div class="field-value">{{ $pregunta->puntaje }}</div>
                        </div>
                        <div class="field-group">
                            <label>Ambito:</label>
                            <div class="field-value">{{ $pregunta->ambito->title }}</div>
                        </div>
                        <div class="button-group">
                            <button class="btn-edit" data-bs-toggle="modal"
                                data-bs-target="#editModalP{{ $pregunta->id }}">
                                Editar
                            </button>
                            <button class="btn-delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModalP{{ $pregunta->id }}">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav aria-label="Preguntas pagination">
                <ul class="pagination justify-content-center" id="preguntas-pagination">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal2">
                Crear una Pregunta
            </button>
        </div>

        <!-- Formularios Table -->
        <div class="table-card d-none d-lg-block">
            <h2>Formularios</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar" class="search-input" data-table="formularios-table">
            </div>
            <div class="table-content" id="formularios-table">
                @foreach ($formularios as $formulario)
                    <div class="table-row" data-id="{{ $formulario->id }}">
                        <div class="field-group">
                            <label>Nombre:</label>
                            <div class="field-value">{{ $formulario->nombre }}</div>
                        </div>
                        <div class="field-group">
                            <label>Responsable:</label>
                            <div class="field-value">{{ $formulario->responsable }}</div>
                        </div>
                        <div class="button-group">
                            <button class="btn-edit" data-bs-toggle="modal"
                                data-bs-target="#editModalF{{ $formulario->id }}">
                                Editar
                            </button>
                            <button class="btn-delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModalF{{ $formulario->id }}">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav aria-label="Formularios pagination">
                <ul class="pagination justify-content-center" id="formularios-pagination">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal3">
                Crear un Formulario
            </button>
        </div>
    </div>

    <!-- Mobile and Tablet Tables -->
    <div class="d-lg-none ">
        <!-- Ambitos Mobile Table -->
        <div class="table-card">
            <h2>Ambitos</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar ambito" class="search-input" data-table="ambitos-table-mobile">
            </div>
            <div class="table-content" id="ambitos-table-mobile">
                <!-- Content will be inserted here by JavaScript -->
            </div>
            <nav aria-label="Ambitos pagination">
                <ul class="pagination justify-content-center" id="ambitos-pagination-mobile">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
                Crear un Ambito
            </button>
        </div>

        <!-- Preguntas Mobile Table -->
        <div class="table-card">
            <h2>Preguntas</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar" class="search-input" data-table="preguntas-table-mobile">
            </div>
            <div class="table-content" id="preguntas-table-mobile">
                <!-- Content will be inserted here by JavaScript -->
            </div>
            <nav aria-label="Preguntas pagination">
                <ul class="pagination justify-content-center" id="preguntas-pagination-mobile">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal2">
                Crear una Pregunta
            </button>
        </div>

        <!-- Formularios Mobile Table -->
        <div class="table-card">
            <h2>Formularios</h2>
            <div class="search-box">
                <input type="text" placeholder="Buscar" class="search-input" data-table="formularios-table-mobile">
            </div>
            <div class="table-content" id="formularios-table-mobile">
                <!-- Content will be inserted here by JavaScript -->
            </div>
            <nav aria-label="Formularios pagination">
                <ul class="pagination justify-content-center" id="formularios-pagination-mobile">
                    <!-- Pagination will be inserted here by JavaScript -->
                </ul>
            </nav>
            <button class="btn-create" data-bs-toggle="modal" data-bs-target="#createModal3">
                Crear un Formulario
            </button>
        </div>
    </div>

    <div class="tablas-apf">
        <div class="multitabla">
            <div class="tblmulti">
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#createModal">Crear un
                    Ambito</button>
                <div id="myGrid" class="ag-theme-quartz "></div>
            </div>

            <div class="tblmulti">
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#createModal2">Crear
                    una Pregunta</button>
                <div id="myGrid2" class="ag-theme-quartz "></div>
            </div>
        </div>

        <div class="formulario">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal3">Crear
                un
                Formulario</button>
            <div id="myGrid3" class="ag-theme-quartz "></div>
        </div>
    </div>

    @foreach ($ambitos as $ambi)
        <div class="modal fade" id="deleteModal{{ $ambi->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar ambito</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este ambito?</p>

                    </div>
                    <div class="modal-footer">
                        <form action="/forms/ambito/{{ $ambi->id }}" method="POST">
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

        <div class="modal fade" id="editModal{{ $ambi->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editar Ambito</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button> <!-- Botón de cierre -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('forms.updateAmbito', $ambi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Nombre Ambito:</label>
                                <input type="text" class="form-control bg-dark text-light" name="title"
                                    value="{{ $ambi->title }}" placeholder="Nombre" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    @foreach ($preguntas as $pregu)
        <div class="modal fade" id="deleteModalP{{ $pregu->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar pregunta</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar esta pregunta?</p>

                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${pregunta.id}" action="/forms/pregunta/{{ $pregu->id }}"
                            method="POST">
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

        <div class="modal fade" id="editModalP{{ $pregu->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editar Pregunta</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('forms.updatePregunta', $pregu->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombrep" class="form-label">Pregunta:</label>
                                <input type="text" class="form-control bg-dark text-light" name="nombrep"
                                    value="{{ $pregu->title }}" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="puntaje" class="form-label">Prioridad:</label>
                                <input type="number" class="form-control bg-dark text-light" name="puntaje"
                                    value="{{ $pregu->prioridad }}" placeholder="Nombre" required  min="1" max="6">
                            </div>

                            <select class="form-select bg-dark text-light areatext1 select-situ"
                                aria-label="Default select example">
                                <option value="" selected>Elige Situacion:</option>
                                @foreach ($restipo as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->titulo }}</option>
                                @endforeach
                            </select>

                            @foreach ($restipo as $tipo)
                                @php
                                    $feedback = $pregu
                                        ->feedbacks()
                                        ->where('respuestas_tipo_id', $tipo->id)
                                        ->first();
                                @endphp
                                <div class="form-floating areatext feedback-{{ $tipo->id }}">
                                    <textarea class="form-control bg-dark text-light" name="situacion_{{ $tipo->id }}" style="height: 100px">{{ $feedback ? $feedback->situacion : '' }}</textarea>
                                    <label>Situacion</label>
                                </div>
                                <div class="form-floating areatext feedback-{{ $tipo->id }}">
                                    <textarea class="form-control bg-dark text-light" name="accion1_{{ $tipo->id }}" style="height: 100px">{{ $feedback ? $feedback->accion1 : '' }}</textarea>
                                    <label>Accion 1:</label>
                                </div>
                                <div class="form-floating areatext feedback-{{ $tipo->id }}">
                                    <textarea class="form-control bg-dark text-light" name="accion2_{{ $tipo->id }}" style="height: 100px">{{ $feedback ? $feedback->accion2 : '' }}</textarea>
                                    <label>Accion 2:</label>
                                </div>
                                <div class="form-floating areatext feedback-{{ $tipo->id }}">
                                    <textarea class="form-control bg-dark text-light" name="accion3_{{ $tipo->id }}" style="height: 100px">{{ $feedback ? $feedback->accion3 : '' }}</textarea>
                                    <label>Accion 3:</label>
                                </div>
                                <div class="form-floating areatext feedback-{{ $tipo->id }}">
                                    <textarea class="form-control bg-dark text-light" name="accion4_{{ $tipo->id }}" style="height: 100px">{{ $feedback ? $feedback->accion4 : '' }}</textarea>
                                    <label>Accion 4:</label>
                                </div>
                            @endforeach

                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($formularios as $formu)
        <div class="modal fade" id="deleteModalF{{ $formu->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar formulario</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este formulario?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="/forms/formu/{{ $formu->id }}" method="POST">
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

        <div class="modal fade" id="editModalF{{ $formu->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createModalLabel">Crear un Formulario</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="create-form" action="{{ route('forms.updateFormulario', $formu->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Formulario:</label>
                                <input type="text" class="form-control bg-dark text-light" name="nombre"
                                    placeholder="Nombre" required value="{{ $formu->nombre }}">
                            </div>
                            <div class="mb-3">
                                <label for="responsable" class="form-label">Responsable:</label>
                                <input type="text" class="form-control bg-dark text-light"
                                    value="{{ $formu->user->name }}" placeholder="Responsable" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="ambitos" class="form-label">Ámbitos:</label>
                                <select  class="select-ambito sl_ambito" multiple disabled required>
                                    @foreach ($ambitos as $ambito)
                                        <option value="{{ $ambito->id }}"
                                            @if (in_array($ambito->id, $formu->ambito->pluck('id')->toArray())) selected @endif>
                                            {{ $ambito->title }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection

<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Crear un Ambito</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" class="formcru" action="{{ route('forms.storeAmbito') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Nombre Ambito:</label>
                        <input type="text" class="form-control bg-dark text-light" name="title"
                            placeholder="Nombre" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Crear una Pregunta</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('forms.storePregunta') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Pregunta:</label>
                        <input type="text" class="form-control bg-dark text-light" name="title"
                            placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="puntaje" class="form-label">Prioridad:</label>
                        <input type="number" class="form-control bg-dark text-light" name="puntaje" placeholder="Nombre" required
                            min="1" max="6">
                    </div>
                    <select class="form-select bg-dark text-light areatext1 select-situ"
                        aria-label="Default select example">
                        <option value="" selected>Elige Situacion:</option>
                        @foreach ($restipo as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->titulo }}</option>
                        @endforeach
                    </select>

                    @foreach ($restipo as $tipo)
                        <div class="form-floating areatext feedback-{{ $tipo->id }}">
                            <textarea class="form-control bg-dark text-light" name="situacion_{{ $tipo->id }}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Situacion</label>
                        </div>
                        <div class="form-floating areatext feedback-{{ $tipo->id }}">
                            <textarea class="form-control bg-dark text-light" name="accion1_{{ $tipo->id }}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 1:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{ $tipo->id }}">
                            <textarea class="form-control bg-dark text-light" name="accion2_{{ $tipo->id }}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 2:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{ $tipo->id }}">
                            <textarea class="form-control bg-dark text-light" name="accion3_{{ $tipo->id }}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 3:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{ $tipo->id }}">
                            <textarea class="form-control bg-dark text-light" name="accion4_{{ $tipo->id }}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 4:</label>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label for="ambito" class="form-label">Ambito:</label>
                        <input type="text" class="form-control bg-dark text-light search-ambito" name="ambito"
                            placeholder="Nombre" required>
                        <input type="hidden" class="input-id-ambito" name="id_ambito">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Crear un Formulario</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('forms.storeFormulario') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Formulario:</label>
                        <input type="text" class="form-control bg-dark text-light" name="nombre"
                            placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable:</label>
                        <input type="text" readonly class="form-control bg-dark text-light"
                            value="{{ Auth::user()->name }}" placeholder="Responsable" required>
                        <input type="hidden" name="responsable" value="{{ Auth::user()->id }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="ambitos" class="form-label">Ámbitos:</label>
                        <select name="ambitos[]" class="select-ambito sl_ambito" multiple="multiple" required>
                            @foreach ($ambitos as $ambito)
                                <option value="{{ $ambito->id }}">{{ $ambito->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@else
    <script>
        window.location.href = '/welcome'; // Redirige a la página /welcome
    </script>

@endif