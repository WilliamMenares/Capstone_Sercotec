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





//movil

document.addEventListener("DOMContentLoaded", async () => {
    const mobileTableBody = document.querySelector("#mobileTableBody");
    const searchInput = document.querySelector("#searchInput");
    const pagination = document.querySelector("#pagination");
    const rowsPerPage = 5; // Número de filas por página
    let currentPage = 1; // Página actual
    let rowData = []; // Datos completos
    let filteredData = []; // Datos filtrados para el buscador

    // Función para crear las filas de la tabla
    const createRow = (data) => {
        const row = document.createElement("div");
        row.classList.add("mobile-table-row");
        row.dataset.id = data.id;
        row.dataset.responsable = data.responsable;
        row.dataset.empresa = data.empresa.nombre;
        row.dataset.contacto = data.empresa.contacto;
        row.dataset.email = data.empresa.email;

        row.innerHTML = `
            <div class="mobile-table-cell"><strong>Id:</strong> ${data.id}</div>
            <div class="mobile-table-cell"><strong>Responsable:</strong> ${data.responsable}</div>
            <div class="mobile-table-cell"><strong>Empresa:</strong> ${data.empresa.nombre}</div>
            <div class="mobile-table-cell"><strong>Contacto Empresa:</strong> ${data.empresa.contacto}</div>
            <div class="mobile-table-cell"><strong>Email Empresa:</strong> ${data.empresa.email}</div>
            <div class="mobile-table-cell mobile-table-actions">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal${data.id}">Editar</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal${data.id}">Eliminar</button>
            </div>
        `;
        return row;
    };

    // Función para filtrar los datos
    const filterRows = (query) => {
        return rowData.filter((item) => {
            return (
                item.id.toString().includes(query) ||
                item.responsable.toLowerCase().includes(query) ||
                item.empresa.nombre.toLowerCase().includes(query) ||
                item.empresa.contacto.toLowerCase().includes(query) ||
                item.empresa.email.toLowerCase().includes(query)
            );
        });
    };

    // Función para mostrar filas paginadas
    const displayRows = () => {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const rowsToDisplay = filteredData.slice(startIndex, endIndex);

        mobileTableBody.innerHTML = ""; // Limpiar tabla
        rowsToDisplay.forEach((item) => {
            const row = createRow(item);
            mobileTableBody.appendChild(row);
        });
    };

    // Configurar paginación
    const setupPagination = () => {
        const pageCount = Math.ceil(filteredData.length / rowsPerPage);
        pagination.innerHTML = "";

        // Botón "Primera página"
        appendPaginationItem("«", () => goToPage(1), currentPage > 1);

        // Botón "Anterior"
        appendPaginationItem("‹", () => goToPage(currentPage - 1), currentPage > 1);

        // Botones de número de página
        for (let i = 1; i <= pageCount; i++) {
            appendPaginationItem(i, () => goToPage(i), true, i === currentPage);
        }

        // Botón "Siguiente"
        appendPaginationItem("›", () => goToPage(currentPage + 1), currentPage < pageCount);

        // Botón "Última página"
        appendPaginationItem("»", () => goToPage(pageCount), currentPage < pageCount);
    };

    // Agregar botón de paginación
    const appendPaginationItem = (text, onClick, enabled, isActive = false) => {
        const li = document.createElement("li");
        li.className = `page-item ${enabled ? "" : "disabled"} ${isActive ? "active" : ""}`;
        const button = document.createElement("button");
        button.className = "page-link";
        button.innerHTML = text;
        button.disabled = !enabled;
        button.addEventListener("click", onClick);
        li.appendChild(button);
        pagination.appendChild(li);
    };

    // Cambiar página
    const goToPage = (page) => {
        currentPage = page;
        displayRows();
        setupPagination();
    };

    // Cargar datos desde la API
    const fetchData = async (url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error("Error al obtener los datos");
            return await response.json();
        } catch (error) {
            console.error("Error al obtener datos:", error);
            return [];
        }
    };

    // Inicialización
    rowData = await fetchData("/api/ase");
    filteredData = rowData;
    displayRows();
    setupPagination();

    // Búsqueda dinámica
    searchInput.addEventListener("input", (event) => {
        const query = event.target.value.toLowerCase();
        filteredData = filterRows(query);
        currentPage = 1; // Reiniciar a la primera página
        displayRows();
        setupPagination();
    });
});

