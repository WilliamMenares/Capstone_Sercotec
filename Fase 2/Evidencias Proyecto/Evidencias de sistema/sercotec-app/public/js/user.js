document.addEventListener("DOMContentLoaded", async () => {
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

        // Inicializar grids primero con arrays vacíos
        const Grid = document.querySelector("#myGrid");

        let GridApi;
    
        if (Grid) {
            GridApi = createDataGrid(Grid, [], columnDefs);
        }
    
        // Luego cargar los datos
        Promise.all([fetchData("/api/user")])
            .then(([Data]) => {
                if (GridApi) {
                    GridApi.setGridOption("rowData", Data || []);
                }
            })
            .catch((error) => {
                console.error("Error general:", error);
            });
});
