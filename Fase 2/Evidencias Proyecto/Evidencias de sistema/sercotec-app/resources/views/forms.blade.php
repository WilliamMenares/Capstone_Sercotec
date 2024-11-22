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

    <div class="multitabla">
        <div class="tblmulti">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear un
                Ambito</button>
            <div id="myGrid" class="ag-theme-material-dark "></div>
        </div>

        <div class="tblmulti">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal2">Crear
                una Pregunta</button>
            <div id="myGrid2" class="ag-theme-material-dark "></div>
        </div>
    </div>

    <div class="formulario">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal3">Crear un
            Formulario</button>
        <div id="myGrid3" class="ag-theme-material-dark "></div>
    </div>

</div>


@foreach ($ambitos as $ambi)
    <div class="modal fade" id="deleteModal{{$ambi->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <form action="/forms/ambito/{{$ambi->id}}" method="POST">
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

    <div class="modal fade" id="editModal{{$ambi->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control bg-dark text-light" name="title" value="{{$ambi->title}}"
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
@endforeach

@foreach ($preguntas as $pregu)
    <div class="modal fade" id="deleteModalP{{$pregu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <form id="delete-form-${pregunta.id}" action="/forms/pregunta/{{$pregu->id}}" method="POST">
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

    <div class="modal fade" id="editModalP{{$pregu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
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
                                value="{{$pregu->title}}" placeholder="Nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="puntaje" class="form-label">Puntaje:</label>
                            <input type="number" class="form-control bg-dark text-light" name="puntaje"
                                value="{{$pregu->puntaje}}" placeholder="Nombre" required>
                        </div>

                        <select class="form-select bg-dark text-light areatext1 select-situ" 
                            aria-label="Default select example">
                            <option value="" selected>Elige Situacion:</option>
                            @foreach ($restipo as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->titulo}}</option>
                            @endforeach
                        </select>

                        @foreach ($restipo as $tipo)
                                        @php
                                            $feedback = $pregu->feedback()->where('id_tipo', $tipo->id)->first();
                                        @endphp
                                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                                            <textarea class="form-control bg-dark text-light" name="situacion_{{$tipo->id}}"
                                                style="height: 100px">{{ $feedback ? $feedback->situacion : '' }}</textarea>
                                            <label>Situacion</label>
                                        </div>
                                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                                            <textarea class="form-control bg-dark text-light" name="accion1_{{$tipo->id}}"
                                                style="height: 100px">{{ $feedback ? $feedback->accion1 : '' }}</textarea>
                                            <label>Accion 1:</label>
                                        </div>
                                        <div class="form-floating areatext feedback-{{$tipo->id}}">
                                            <textarea class="form-control bg-dark text-light" name="accion2_{{$tipo->id}}"
                                                style="height: 100px">{{ $feedback ? $feedback->accion2 : '' }}</textarea>
                                            <label>Accion 2:</label>
                                        </div>
                                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                                            <textarea class="form-control bg-dark text-light" name="accion3_{{$tipo->id}}"
                                                style="height: 100px">{{ $feedback ? $feedback->accion3 : '' }}</textarea>
                                            <label>Accion 3:</label>
                                        </div>
                                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                                            <textarea class="form-control bg-dark text-light" name="accion4_{{$tipo->id}}"
                                                style="height: 100px">{{ $feedback ? $feedback->accion4 : '' }}</textarea>
                                            <label>Accion 4:</label>
                                        </div>
                        @endforeach

                        <div class="mb-3">
                            <label for="ambito" class="form-label">Ambito:</label>
                            <input type="text" class="form-control bg-dark text-light search-ambito" name="ambito"
                                value="{{$pregu->ambito->title}}" placeholder="Ambito" required>
                            <input type="hidden" class="input-id-ambito" name="id_ambito" value="{{$pregu->ambito->id}}">
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

@foreach ($formularios as $formu)
    <div class="modal fade" id="deleteModalF{{$formu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <form action="/forms/formu/{{$formu->id}}" method="POST">
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

    <div class="modal fade" id="editModalF{{$formu->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="Nombre"
                                required value="{{$formu->nombre}}">
                        </div>
                        <div class="mb-3">
                            <label for="responsable" class="form-label">Responsable:</label>
                            <input type="text" class="form-control bg-dark text-light" name="responsable"
                                value="{{ $formu->responsable }}" placeholder="Responsable" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ambitos" class="form-label">Ámbitos:</label>
                            <select name="ambitos[]" class="select-ambito sl_ambito" multiple required>
                                @foreach ($ambitos as $ambito)
                                    <option value="{{ $ambito->id }}" @if(in_array($ambito->id, $formu->ambitos->pluck('id')->toArray())) selected @endif>
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
                        <input type="text" class="form-control bg-dark text-light" name="title" placeholder="Nombre"
                            required>
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
                        <input type="text" class="form-control bg-dark text-light" name="title" placeholder="Nombre"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="puntaje" class="form-label">Puntaje:</label>
                        <input type="number" class="form-control bg-dark text-light" name="puntaje" placeholder="Nombre"
                            required>
                    </div>
                    <select class="form-select bg-dark text-light areatext1 select-situ" 
                        aria-label="Default select example">
                        <option value="" selected>Elige Situacion:</option>
                        @foreach ($restipo as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->titulo}}</option>
                        @endforeach
                    </select>

                    @foreach ($restipo as $tipo)
                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                            <textarea class="form-control bg-dark text-light" name="situacion_{{$tipo->id}}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Situacion</label>
                        </div>
                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                            <textarea class="form-control bg-dark text-light" name="accion1_{{$tipo->id}}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 1:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                            <textarea class="form-control bg-dark text-light" name="accion2_{{$tipo->id}}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 2:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                            <textarea class="form-control bg-dark text-light" name="accion3_{{$tipo->id}}"
                                placeholder="Leave a comment here" style="height: 100px"></textarea>
                            <label>Accion 3:</label>
                        </div>
                        <div class="form-floating areatext feedback-{{$tipo->id}}" >
                            <textarea class="form-control bg-dark text-light" name="accion4_{{$tipo->id}}"
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
                        <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="Nombre"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable:</label>
                        <input type="text" readonly class="form-control bg-dark text-light" name="responsable"
                            value="{{ Auth::user()->name }}" placeholder="Responsable" required>
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