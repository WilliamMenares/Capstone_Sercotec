@extends('layout.menu')

@section('title', 'Usuarios')

<link rel="stylesheet" href="{{ asset('css/user.css') }}">

@section('buscador', 'usuarios')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Lista de Usuarios</h5>

                <!-- Botón para abrir el modal -->
                <button data-bs-toggle="modal" data-bs-target="#modalAgregar" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nuevo Usuario
                </button>
            </div>

            <!-- Modal para agregar nuevo usuario -->
            <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Nuevo Usuario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="userForm" action="{{ route('user.store') }}" method="post"
                                onsubmit="return validatePasswords()">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del usuario</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        oninvalid="this.setCustomValidity('Este campo es obligatorio')"
                                        oninput="setCustomValidity('')">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email del usuario</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        oninvalid="this.setCustomValidity('Este campo es obligatorio')"
                                        oninput="setCustomValidity('')">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        minlength="8" oninvalid="this.setCustomValidity('Este campo es obligatorio')"
                                        oninput="setCustomValidity('')">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required minlength="8"
                                        oninvalid="this.setCustomValidity('Este campo es obligatorio')"
                                        oninput="setCustomValidity('')">
                                    <div id="passwordError" class="text-danger" style="display: none;">Las contraseñas no
                                        coinciden</div> <!-- Mensaje de error para contraseñas -->
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agregar la validación con JavaScript -->
            <script>
                function validatePasswords() {
                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;
                    const passwordError = document.getElementById('passwordError');

                    // Limpiar mensaje de error previo
                    passwordError.style.display = 'none';

                    // Validar que las contraseñas tengan al menos 8 caracteres
                    if (password.length < 8) {
                        alert('La contraseña debe tener un mínimo de 8 caracteres.');
                        return false;
                    }

                    // Validar que las contraseñas coincidan
                    if (password !== passwordConfirmation) {
                        passwordError.style.display = 'block';
                        return false;
                    }

                    return true; // Todo es válido, el formulario se enviará
                }
            </script>

            <!-- Mensajes de éxito o error -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="alert alert-light bg-transparent bg-trans">
                <div class="row align-items-center text-center" style="display: flex; flex-wrap: wrap;">
                    <div class="col-md-3">Nombre</div>
                    <div class="col-md-3">Email</div>
                    <div class="col-md-3">Fecha Creación</div>
                    <div class="col-md-3">Acciones</div>
                </div>
            </div>
            @foreach ($datos_user as $usuario)
                <div class="alert alert-light">
                    <div class="row align-items-center text-center" style="display: flex; flex-wrap: nowrap;">
                        <div class="col-md-3">{{ $usuario->name }}</div>
                        <div class="col-md-3">{{ $usuario->email }}</div>
                        @if ($usuario->created_at)
                            <div class="col-md-3">{{ $usuario->created_at->format('d/m/Y') }}</div>
                        @else
                            <div class="col-md-3">Fecha no disponible</div>
                        @endif
                        <div class="col-md-3 action-icons">
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $usuario->id }}"
                                class="btn btn-primary btn-sm" aria-label="Editar usuario"><i class="bi bi-pencil"
                                    style="color: #ffffff;"></i></a>

                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $usuario->id }}"
                                class="btn btn-danger btn-sm" aria-label="Eliminar usuario"><i class="bi bi-x-lg"
                                    style="color: #ffffff;"></i></a>
                        </div>
                    </div>



                    <!-- Modal editar datos-->
                    <div class="modal fade" id="modalEditar{{ $usuario->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('user.update', $usuario->id) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre del usuario</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $usuario->name) }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email del usuario</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email', $usuario->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" minlength="8" autocomplete="new-password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de confirmación de eliminación -->
                    <div class="modal fade" id="modalEliminar{{ $usuario->id }}" tabindex="-1"
                        aria-labelledby="modalEliminarLabel{{ $usuario->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel{{ $usuario->id }}">Confirmar
                                        Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar este usuario?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">Cancelar</button>

                                    <!-- Formulario para eliminar el usuario -->
                                    <form action="{{ route('user.destroy', $usuario->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-1">
                {{ $datos_user->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
