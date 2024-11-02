@extends('layout.menu')

@section('title', 'Asesores')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">


<script>
    window.usuarios = @json($usuarios);
    const updateRoute = "{{ route('user.update', ':id') }}";
</script>
<script src="{{ asset('js/user.js') }}"></script>
@section('content')

<div class="crud">
    <div class="titulo">
        <h1>Asesores</h1>
    </div>

    <div class="create-nuevo">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear un
            Asesor</button>
    </div>

    <div id="myGrid" class="ag-theme-material-dark tablita"></div>
</div>



@endsection


<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Crear un Asesor</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control bg-dark text-light" name="name" id="name" placeholder="Nombre del Asesor"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-light" name="email" id="email" placeholder="Email del Asesor" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control bg-dark text-light phone-vali" name="telefono" id="telefono" placeholder="+56912345678" required>
                    </div>
                    <div class="mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" class="form-control bg-dark text-light rut-vali" name="rut" id="rut" placeholder="12345678-9" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control bg-dark text-light" name="password" id="password"  required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirme Contraseña</label>
                        <input type="password" class="form-control bg-dark text-light" name="password_confirmation" id="password_confirmation"  required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>