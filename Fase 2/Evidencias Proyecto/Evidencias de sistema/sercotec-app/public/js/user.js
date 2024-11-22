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



document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.mobile-table-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const id = row.getAttribute('data-id').toLowerCase();
            const rut = row.getAttribute('data-rut').toLowerCase();
            const name = row.getAttribute('data-name').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const telefono = row.getAttribute('data-telefono').toLowerCase();

            if (id.includes(searchTerm) || 
                rut.includes(searchTerm) || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                telefono.includes(searchTerm)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('mobileTableBody');
    const pagination = document.getElementById('pagination');
    const rowsPerPage = 5;
    let currentPage = 1;
    let filteredRows = [];

    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        filteredRows = Array.from(tableBody.querySelectorAll('.mobile-table-row')).filter(row => {
            const id = row.getAttribute('data-id').toLowerCase();
            const rut = row.getAttribute('data-rut').toLowerCase();
            const name = row.getAttribute('data-name').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const telefono = row.getAttribute('data-telefono').toLowerCase();

            return id.includes(searchTerm) || 
                   rut.includes(searchTerm) || 
                   name.includes(searchTerm) || 
                   email.includes(searchTerm) || 
                   telefono.includes(searchTerm);
        });

        currentPage = 1;
        displayRows();
        setupPagination();
    }

    function displayRows() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const paginatedRows = filteredRows.slice(startIndex, endIndex);

        tableBody.querySelectorAll('.mobile-table-row').forEach(row => row.classList.add('hidden'));
        paginatedRows.forEach(row => row.classList.remove('hidden'));
    }

    function setupPagination() {
        const pageCount = Math.ceil(filteredRows.length / rowsPerPage);
        pagination.innerHTML = '';

        appendPaginationItem('&laquo;&laquo;', () => goToPage(1), currentPage > 1, 'Ir a la primera página');
        appendPaginationItem('&laquo;', () => goToPage(currentPage - 1), currentPage > 1, 'Página anterior');

        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(pageCount, startPage + 2);
        
        if (endPage - startPage < 2) {
            startPage = Math.max(1, endPage - 2);
        }

        for (let i = startPage; i <= endPage; i++) {
            appendPaginationItem(i, () => goToPage(i), true, `Ir a la página ${i}`, i === currentPage);
        }

        appendPaginationItem('&raquo;', () => goToPage(currentPage + 1), currentPage < pageCount, 'Página siguiente');
        appendPaginationItem('&raquo;&raquo;', () => goToPage(pageCount), currentPage < pageCount, 'Ir a la última página');
    }

    function appendPaginationItem(text, onClick, enabled, ariaLabel, isActive = false) {
        const li = document.createElement('li');
        li.className = `page-item ${enabled ? '' : 'disabled'} ${isActive ? 'active' : ''}`;
        const a = document.createElement('a');
        a.className = 'page-link';
        a.innerHTML = text;
        a.href = '#';
        a.setAttribute('aria-label', ariaLabel);
        if (enabled) {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                onClick();
            });
        }
        li.appendChild(a);
        pagination.appendChild(li);
    }

    function goToPage(page) {
        currentPage = page;
        displayRows();
        setupPagination();
    }

    searchInput.addEventListener('input', filterRows);

    filterRows();
});
