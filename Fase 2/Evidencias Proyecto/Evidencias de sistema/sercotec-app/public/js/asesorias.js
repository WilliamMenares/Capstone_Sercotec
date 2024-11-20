document.addEventListener("DOMContentLoaded", async () => {
    // Definición de columnas
    const columnDefs = [
        { headerName: "id", field: "id" },
        {
            headerName: "Responsable",
            field: "responsable",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Empresa",
            field: "empresa.nombre",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Contacto Empresa",
            field: "empresa.contacto",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Email Empresa",
            field: "empresa.email",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Acciones",
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
    Promise.all([fetchData("/api/ase")])
        .then(([Data]) => {
            if (GridApi) {
                GridApi.setGridOption("rowData", Data || []);
            }
        })
        .catch((error) => {
            console.error("Error general:", error);
        });
});
