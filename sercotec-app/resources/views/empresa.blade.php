@extends('layout.menu')

@section('title', 'Empresa')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">

<script>
    window.empresas = @json($empresas);
    const updateRoute = "{{ route('empresa.update', ':id') }}";
</script>
<script src="{{ asset('js/empresa.js') }}"></script>




@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Empresas</h1>
    </div>

    <div class="create-nuevo">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear un
            empresa</button>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>



@endsection


<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Crear una empresa</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" class="formcru" action="{{ route('empresa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="Nombre"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" class="form-control bg-dark text-light rut-vali " name="rut"
                            placeholder="12123321-1" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control bg-dark text-light phone-vali" name="telefono"
                            placeholder="+56912345678" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-light" name="email" placeholder="Email"
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