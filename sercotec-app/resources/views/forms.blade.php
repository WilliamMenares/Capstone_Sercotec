@extends('layout.menu')

@section('title', 'Ambitos y Preguntas')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">

@section("scripts")
<script>
    $(document).ready(function() {
    $('#chosen-example').chosen({
        width: "100%",
        placeholder_text_multiple: "Selecciona opciones"
    });
});
</script>

@endsection

<script>
    window.ambitos = @json($ambitos);
    window.preguntas = @json($preguntas);
    window.formularios = @json($formularios);
    const updateRouteA = "{{ route('forms.updateAmbito', ':id') }}";
    const deleteRouteA = "{{ route('forms.destroyAmbito', ':id') }}";
    const updateRouteP = "{{ route('forms.updatePregunta', ':id') }}";
    const deleteRouteP = "{{ route('forms.destroyPregunta', ':id') }}";
    const deleteRouteF = "{{ route('forms.destroyFormulario', ':id') }}";
</script>
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
                <form id="create-form" action="{{ route('forms.storeFormulario') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Formulario:</label>
                        <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="Nombre"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable:</label>
                        <input type="text" class="form-control bg-dark text-light" name="responsable"
                            placeholder="Responsable" required>
                    </div>
                    <div class="mb-3">
                        <label for="ambitos" class="form-label">Ámbitos:</label>
                        <select name="ambitos[]" id="chosen-example" class="select-ambito"
                            multiple="multiple" required>
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

