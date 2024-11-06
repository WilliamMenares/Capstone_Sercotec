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

    <!-- <div class="create-nuevo">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Crear un
            empresa</button>
    </div> -->

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
        function startImport() {
            const fileInput = document.getElementById('excel-file');
            if (!fileInput.files[0]) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor selecciona un archivo Excel'
                });
                return;
            }

            Swal.fire({
                title: 'Importando...',
                html: `
            <div class="space-y-4">
                <p>Por favor espera, los registros se están importando.</p>
            </div>
        `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(document.getElementById('import-form'));

            $.ajax({
                url: '/import',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: `Importación completada. ${response.insertedRows} registros procesados.`
                    });

                    // Recargar la página después de 5 segundos
                    setTimeout(function () {
                        location.reload();  // Recarga la página
                    }, 5000);
                },
                error: function (xhr) {
                    let errorMessage = 'Error al procesar el archivo.';

                    if (xhr.responseJSON) {
                        errorMessage = xhr.responseJSON.message;

                        // Si hay errores específicos, mostrarlos
                        if (xhr.responseJSON.errors) {
                            errorMessage += '\n\n' + xhr.responseJSON.errors;
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage.replace(/\n/g, '<br>')
                    });
                }
            });
        }
    </script>

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
                        <label for="rut" class="form-label">Codigo</label>
                        <input type="text" class="form-control bg-dark text-light rut-vali " name="codigo"
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