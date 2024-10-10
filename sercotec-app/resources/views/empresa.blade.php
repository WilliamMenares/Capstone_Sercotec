@extends('layout.menu')

@section('title', 'Empresa')

<link rel="stylesheet" href="{{ asset('css/empresa.css') }}">

@section('buscador', 'empresa')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Lista de Empresas</h5>

                <!-- Botón para abrir el modal -->
                <button data-bs-toggle="modal" data-bs-target="#modalAgregar" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nueva empresa
                </button>


                <!-- Modal para agregar nueva empresa -->
                <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Nueva Empresa</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para agregar empresa -->
                                <form id="formAgregarEmpresa" action="{{ route('empresa.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rut" class="form-label">RUT de la empresa</label>
                                        <input type="text" class="form-control @error('rut') is-invalid @enderror"
                                            id="rut" name="rut" value="{{ old('rut') }}">
                                        @error('rut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre de la empresa</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" name="nombre" value="{{ old('nombre') }}">
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email de la empresa</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono de la empresa</label>
                                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                            id="telefono" name="telefono" value="{{ old('telefono') }}">
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Agregar Empresa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="alert alert-light bg-transparent bg-trans">
                <div class="row align-items-center text-center" style="display: flex; flex-wrap: wrap;">
                    <div class="col-md-2">Nombre</div>
                    <div class="col-md-2">Email</div>
                    <div class="col-md-2">Teléfono</div>
                    <div class="col-md-2">Rut</div>
                    <div class="col-md-2">Fecha Creación</div>
                    <div class="col-md-2">Acciones</div>
                </div>
            </div>
            @foreach ($datos_empresa as $empresa)
                <div class="alert alert-light">
                    <div class="row align-items-center text-center" style="display: flex; flex-wrap: nowrap;">
                        <div class="col-md-2">{{ $empresa->nombre }}</div>
                        <div class="col-md-2">{{ $empresa->email }}</div>
                        <div class="col-md-2">{{ $empresa->telefono }}</div>
                        <div class="col-md-2">{{ $empresa->rut }}</div>
                        @if ($empresa->created_at)
                            <div class="col-md-2">{{ $empresa->created_at->format('d/m/Y') }}</div>
                        @else
                            <div class="col-md-2">Fecha no disponible</div>
                        @endif
                        <div class="col-md-2 action-icons">
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $empresa->id }}"
                                class="btn btn-primary btn-sm" aria-label="Editar usuario"><i class="bi bi-pencil"
                                    style="color: #ffffff;"></i></a>

                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $empresa->id }}"
                                class="btn btn-danger btn-sm" aria-label="Eliminar usuario"><i class="bi bi-x-lg"
                                    style="color: #ffffff;"></i></a>
                        </div>
                    </div>

                    <!-- Modal editar datos-->
                    <div class="modal fade" id="modalEditar{{ $empresa->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('empresa.update', $empresa->id) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre de la empresa</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                value="{{ old('nombre', $empresa->nombre) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email de la empresa</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ old('email', $empresa->email) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono de la empresa</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                value="{{ old('telefono', $empresa->telefono) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="rut" class="form-label">RUT de la empresa</label>
                                            <input type="text" class="form-control" id="rut" name="rut"
                                                value="{{ old('rut', $empresa->rut) }}">
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
                    <div class="modal fade" id="modalEliminar{{ $empresa->id }}" tabindex="-1"
                        aria-labelledby="modalEliminarLabel{{ $empresa->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel{{ $empresa->id }}">Confirmar
                                        Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar esta empresa?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">Cancelar</button>

                                    <!-- Formulario para eliminar la empresa -->
                                    <form action="{{ route('empresa.destroy', $empresa->id) }}" method="POST"
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
            <div class="d-flex justify-content-center mt-4 pagination-container">
                {{ $datos_empresa->links('pagination::tailwind') }}
            </div>
        </div>
    </div>



@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar el modal automáticamente si hay errores
        @if ($errors->any())
            var modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregar'));
            modalAgregar.show();
        @endif

        // Limpiar el formulario y errores al cerrar el modal
        document.getElementById('modalAgregar').addEventListener('hidden.bs.modal', function() {
            // Limpiar campos del formulario
            document.getElementById('formAgregarEmpresa').reset();

            // Remover clases de error
            document.querySelectorAll('.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });

            // Remover mensajes de error
            document.querySelectorAll('.invalid-feedback').forEach(function(element) {
                element.remove();
            });
        });
    });
</script>
