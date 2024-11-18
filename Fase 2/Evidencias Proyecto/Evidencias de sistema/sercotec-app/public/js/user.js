document.addEventListener("DOMContentLoaded", async () => {
    // Primero verificamos si tenemos datos
    try {
        const response = await fetch("/api/user", {
            method: "GET",
            credentials: "same-origin",
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Definición de columnas
        const columnDefs = [
            { headerName: "Rut", field: "rut", width: 250 },
            {
                headerName: "Nombre",
                field: "name",
                filter: true,
                floatingFilter: true,
            },
            {
                headerName: "Telefono",
                field: "telefono",
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
                headerName: "Acciones",
                width: 250,
                cellRenderer: (params) => `
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal${params.data.id}">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal${params.data.id}">Eliminar</button>
            `,
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
