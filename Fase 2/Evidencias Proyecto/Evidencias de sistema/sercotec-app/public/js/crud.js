document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.mobile-table-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const codigo = row.getAttribute('data-codigo').toLowerCase();
            const rut = row.getAttribute('data-rut').toLowerCase();
            const nombre = row.getAttribute('data-nombre').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const contacto = row.getAttribute('data-contacto').toLowerCase();

            if (codigo.includes(searchTerm) || 
                rut.includes(searchTerm) || 
                nombre.includes(searchTerm) || 
                email.includes(searchTerm) || 
                contacto.includes(searchTerm)) {
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
            const codigo = row.getAttribute('data-codigo').toLowerCase();
            const rut = row.getAttribute('data-rut').toLowerCase();
            const nombre = row.getAttribute('data-nombre').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const contacto = row.getAttribute('data-contacto').toLowerCase();

            return codigo.includes(searchTerm) || 
                   rut.includes(searchTerm) || 
                   nombre.includes(searchTerm) || 
                   email.includes(searchTerm) || 
                   contacto.includes(searchTerm);
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

        // Botón "Primera página"
        appendPaginationItem('&laquo;&laquo;', () => goToPage(1), currentPage > 1, 'Ir a la primera página');

        // Botón "Anterior"
        appendPaginationItem('&laquo;', () => goToPage(currentPage - 1), currentPage > 1, 'Página anterior');

        // Botones de número de página
        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(pageCount, startPage + 2);
        
        if (endPage - startPage < 2) {
            startPage = Math.max(1, endPage - 2);
        }

        for (let i = startPage; i <= endPage; i++) {
            appendPaginationItem(i, () => goToPage(i), true, `Ir a la página ${i}`, i === currentPage);
        }

        // Botón "Siguiente"
        appendPaginationItem('&raquo;', () => goToPage(currentPage + 1), currentPage < pageCount, 'Página siguiente');

        // Botón "Última página"
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

    // Inicialización
    filterRows();
});
