document.addEventListener("DOMContentLoaded", async () => {
    // Primero verificamos si tenemos datos
    try {
        const response = await fetch("/api/emp", {
            method: "GET",
            credentials: "same-origin",
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Definición de columnas
        const columnDefs = [
            {
                headerName: "Codigo",
                field: "codigo",
                filter: true,
                floatingFilter: true,
            },{
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
        ];

        // Configuración del grid
        const gridOptions = {
            columnDefs,
            rowData: data,
            pagination: true,
            paginationPageSizeSelector: [10, 20, 50, 100],
            paginationPageSize: 10,
            domLayout: "autoHeight",
            onFirstDataRendered: (params) => {
                params.api.sizeColumnsToFit();
            },
        };

        // Inicializar el grid usando createGrid
        const gridDiv = document.querySelector("#myGrid");
        if (!gridDiv) {
            throw new Error("No se encontró el elemento #myGrid");
        }

        // Usar createGrid en lugar de new Grid
        const gridApi = agGrid.createGrid(gridDiv, gridOptions);
    } catch (error) {
        console.error("Error:", error);
    }
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
        title: "Importando...",
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
