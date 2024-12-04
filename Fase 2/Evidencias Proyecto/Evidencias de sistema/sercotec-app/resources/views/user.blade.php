@extends('layout.menu')

@section('title', 'Asesores')

<link rel="stylesheet" href="{{ asset('css/crud.css') }}">



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
    <div id="mobileGrid" class="mobile-table">
        <div class="mobile-table-header">
            <h2>Lista de Asesores</h2>
        </div>
        <div class="mobile-search">
            <input type="text" id="searchInput" class="form-control bg-dark text-light" placeholder="Buscar por id, rut, nombre, email o telefono">
        </div>
        <div class="mobile-table-body" id="mobileTableBody">
            @foreach ($usuarios as $user)
            <div class="mobile-table-row" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-telefono="{{$user->telefono}}" data-rut="{{$user->rut}}">
                <div class="mobile-table-cell">
                    <strong>Id:</strong> {{$user->id}}
                </div>
                <div class="mobile-table-cell">
                    <strong>RUT:</strong> {{$user->rut}}
                </div>
                <div class="mobile-table-cell">
                    <strong>Nombre:</strong> {{$user->name}}
                </div>
                <div class="mobile-table-cell">
                    <strong>Email:</strong> {{$user->email}}
                </div>
                <div class="mobile-table-cell">
                    <strong>Telefono:</strong> {{$user->telefono}}
                </div>
                <div class="mobile-table-cell mobile-table-actions">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">Editar</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">Eliminar</button>
                </div>
            </div>
            @endforeach
        </div>
        <nav aria-label="Paginación de empresas">
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Los elementos de paginación se generarán dinámicamente con JavaScript -->
            </ul>
        </nav>
    </div>
</div>

<script src="{{ asset('js/user.js') }}"></script>
@endsection


@foreach ($usuarios as $user)

    <div class="modal fade" id="deleteModal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Empleado</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este Asesor?</p>

                </div>
                <div class="modal-footer">
                    <form action="/user/{{$user->id}}" method="POST">
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

    <div class="modal fade" id="editModal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Empleado</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button> <!-- Botón de cierre -->
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update', $user->id) }}" class="formcru" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control bg-dark text-light" name="name"
                                placeholder="Nombre del Empleado" value="{{$user->name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control bg-dark text-light" name="email"
                                placeholder="Email del Empleado" value="{{$user->email}}" autocomplete="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">telefono</label>
                            <input type="text" class="form-control bg-dark text-light phone-vali" name="telefono"
                                placeholder="+56912345678" value="{{$user->telefono}}" autocomplete="tel" required>
                        </div>
                        <div class="mb-3">
                            <label for="rut" class="form-label">Rut</label>
                            <input type="text" class="form-control bg-dark text-light rut-vali" name="rut"
                                placeholder="12345678-9" value="{{$user->rut}}" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control bg-dark text-light" name="password"
                                autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirme Contraseña</label>
                            <input type="password" class="form-control bg-dark text-light" name="password_confirmation"
                                autocomplete="new-password">
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
                <form id="create-form" action="{{ route('user.store') }}" class="formcru" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control bg-dark text-light" name="name" id="name"
                            placeholder="Nombre del Asesor" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-light" name="email" id="email"
                            placeholder="Email del Asesor" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control bg-dark text-light phone-vali" name="telefono"
                            id="telefono" placeholder="+56912345678" required>
                    </div>
                    <div class="mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" class="form-control bg-dark text-light rut-vali" name="rut" id="rut"
                            placeholder="12345678-9" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control bg-dark text-light" name="password"
                            autocomplete="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirme Contraseña</label>
                        <input type="password" class="form-control bg-dark text-light" name="password_confirmation"
                            autocomplete="new-password" required>
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