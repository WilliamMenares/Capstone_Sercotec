document.addEventListener("DOMContentLoaded", async () => {
    // Definición de columnas
    const columnDefs = [
        {
            headerName: "Codigo",
            field: "codigo",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Rut",
            field: "rut",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Nombre",
            field: "nombre",
            filter: true,
            floatingFilter: true,
        },

        {
            headerName: "Email",
            field: "email",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Contacto primario",
            field: "contacto",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Acciones",
            width: 250,
            cellRenderer: (params) => `
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal${params.data.id}">Editar</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal${params.data.id}">Eliminar</button>
        `,
        },
    ];

    // Inicializar grids primero con arrays vacíos
    const Grid = document.querySelector("#myGrid");

    let GridApi;

    if (Grid) {
        GridApi = createDataGrid(Grid, [], columnDefs);
    }

    // Luego cargar los datos
    Promise.all([fetchData("/api/emp")])
        .then(([Data]) => {
            if (GridApi) {
                GridApi.setGridOption("rowData", Data || []);
            }
        })
        .catch((error) => {
            console.error("Error general:", error);
        });
});

function startImport() {
    const fileInput = document.getElementById("excel-file");
    if (!fileInput.files[0]) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Por favor selecciona un archivo Excel",
        });
        return;
    }

    Swal.fire({
        icon:"info",
        title: "Importando...",
        text: 'Por favor espera, los registros se están importando.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    const formData = new FormData(document.getElementById("import-form"));

    $.ajax({
        url: "/import",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Éxito",
                text: `Importación completada. ${response.insertedRows} registros procesados.`,
            });

            // Recargar la página después de 5 segundos
            setTimeout(function () {
                location.reload(); // Recarga la página
            }, 5000);
        },
        error: function (xhr) {
            let errorMessage = "Error al procesar el archivo.";

            if (xhr.responseJSON) {
                errorMessage = xhr.responseJSON.message;

                // Si hay errores específicos, mostrarlos
                if (xhr.responseJSON.errors) {
                    errorMessage += "\n\n" + xhr.responseJSON.errors;
                }
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                html: errorMessage.replace(/\n/g, "<br>"),
            });
        },
    });
}
