@if (auth()->user()->rol == 0)
    @extends('layout.menu')

    @section('title', 'Empresa')

    <link rel="stylesheet" href="{{ asset('css/crud.css') }}">
    <script src="{{ asset('js/crud.js') }}"></script>

    @section('content')

    <div class="crud">
        <div class="titulo">
            <h1>Empresas</h1>
        </div>

        <div class="create-nuevo">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear una
                Empresa</button>
        </div>

        <form id="import-form" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
            @csrf
            <div class="space-y-2">
                <label for="excel-file" class="block text-sm font-medium text-white">
                </label>
                <input type="file" id="excel-file" name="file" accept=".xlsx,.xls" class="btn btn-primary">
            </div>

            <button type="button" onclick="startImport()" class="btn btn-secondary">
                Importar Excel
            </button>
        </form>

        <script>

        </script>

        <div id="myGrid" class="ag-theme-quartz tablita"></div>
        <div id="mobileGrid" class="mobile-table">
            <div class="mobile-table-header">
                <h2>Lista de Empresas</h2>
            </div>
            <div class="mobile-search">
                <input type="text" id="searchInput" class="form-control bg-dark text-light"
                    placeholder="Buscar por código, RUT, nombre, email o contacto">
            </div>
            <div class="mobile-table-body" id="mobileTableBody">
                @foreach ($empresas as $emp)
                    <div class="mobile-table-row" data-codigo="{{$emp->codigo}}" data-rut="{{$emp->rut}}"
                        data-nombre="{{$emp->nombre}}" data-email="{{$emp->email}}" data-contacto="{{$emp->contacto}}">
                        <div class="mobile-table-cell">
                            <strong>Código:</strong> {{$emp->codigo}}
                        </div>
                        <div class="mobile-table-cell">
                            <strong>RUT:</strong> {{$emp->rut}}
                        </div>
                        <div class="mobile-table-cell">
                            <strong>Nombre:</strong> {{$emp->nombre}}
                        </div>
                        <div class="mobile-table-cell">
                            <strong>Email:</strong> {{$emp->email}}
                        </div>
                        <div class="mobile-table-cell">
                            <strong>Contacto:</strong> {{$emp->contacto}}
                        </div>
                        <div class="mobile-table-cell mobile-table-actions">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{$emp->id}}">Editar</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{$emp->id}}">Eliminar</button>
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

    <script src="{{ asset('js/empresa.js') }}"></script>



    @foreach ($empresas as $emp)

        <div class="modal fade" id="deleteModal{{$emp->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Empresa</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar esta empresa?</p>

                    </div>
                    <div class="modal-footer">
                        <form action="/empresa/{{$emp->id}}" method="POST">
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

        <div class="modal fade" id="editModal{{$emp->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editar Empleado</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button> <!-- Botón de cierre -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('empresa.update', $emp->id) }}" class="formcru" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Codigo:</label>
                                <input type="text" class="form-control bg-dark text-light" placeholder="codigo"
                                    value="{{$emp->codigo}}" autocomplete="off" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="rut" class="form-label">Rut</label>
                                <input type="text" class="form-control bg-dark text-light rut-vali" name="rut"
                                    placeholder="12345678-9" value="{{$emp->rut}}" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="nombre"
                                    value="{{$emp->nombre}}" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control bg-dark text-light" name="email"
                                    placeholder="ejemplo@ejemplo.com" value="{{$emp->email}}" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="contacto" class="form-label">Contacto:</label>
                                <input type="text" class="form-control bg-dark text-light" name="contacto"
                                    placeholder="contacto" value="{{$emp->contacto}}" autocomplete="email" required>
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
            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Crear Empresa</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button> <!-- Botón de cierre -->
                </div>
                <div class="modal-body">
                    <form action="{{ route('empresa.store') }}" class="formcru" method="POST">
                        @csrf
                        <input type="hidden" name="codigo" value="Sin Asignar">
                        <div class="mb-3">
                            <label for="rut" class="form-label">Rut</label>
                            <input type="text" class="form-control bg-dark text-light rut-vali" name="rut"
                                placeholder="12345678-9" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="nombre"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control bg-dark text-light" name="email"
                                placeholder="ejemplo@ejemplo.com" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Contacto:</label>
                            <input type="text" class="form-control bg-dark text-light" name="contacto"
                                placeholder="contacto" autocomplete="email" required>
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