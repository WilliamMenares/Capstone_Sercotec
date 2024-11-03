@extends('layout.menu')

<<<<<<< HEAD
@section('title', 'asesorias')

<link rel="stylesheet" href="{{ asset('css/asesorias.css') }}">



@section('buscador', 'asesorias')

@section('content')
<div class="card">
    <div class="card-body">
    <strong class="card-title mb-0">Lista de Asesorías</strong>

        <div class="alert alert-light bg-transparent bg-trans">
            <div class="row align-items-center text-center" style="display: flex; flex-wrap: wrap;">
                <div class="col-md-2">Nombre de empresa diagnosticada</div>
                <div class="col-md-2">Email</div>
                <div class="col-md-2">Rut</div>
                <div class="col-md-2">Id asesoría</div>
                <div class="col-md-2">Apto</div>
                <div class="col-md-2">Fecha creacion</div>
            </div>
        </div>

        <div class="alert alert-light">
            <div class="row align-items-center text-center" style="display: flex; flex-wrap: nowrap;">
                <div class="col-md-2">San Antonio</div>
                <div class="col-md-2">prueba@pruieba.com</div>
                <div class="col-md-2">11.111.111-1</div>
                <div class="col-md-2">1</div>
                <div class="col-md-2">Si</div>
                <div class="col-md-2">25/04/2024</div>
                <div class="col-md-2"></div>
                <div>
                    <button class="btn btn-primary btn-sm" title="Ver informe">
                        <i class="bi bi-eye"></i> Ver
                    </button>
                    <button class="btn btn-danger btn-sm" title="Descargar PDF">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                    <button class="btn btn-success btn-sm" title="Descargar texto plano">
                        <i class="bi bi-file-earmark-text"></i> Texto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
=======
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
>>>>>>> a467c172a4fa836bc5a759ab77b1b18854e754ca
