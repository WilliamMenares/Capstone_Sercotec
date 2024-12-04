document.addEventListener("DOMContentLoaded", () => {
    $(document).ready(function () {
        $(".sl_ambito").chosen({
            width: "100%",
            placeholder_text_multiple: "Selecciona opciones",
        });
    });

    // Función para configurar Typeahead
    const setupTypeahead = (data) => {
        const AmbitosTypeHead = new Bloodhound({
            datumTokenizer: function (datum) {
                return Bloodhound.tokenizers.whitespace(datum.title);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: data || [], // Aseguramos que siempre haya un array
        });

        AmbitosTypeHead.initialize();

        $(".search-ambito")
            .typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1,
                },
                {
                    name: "ambitos",
                    source: AmbitosTypeHead.ttAdapter(),
                    display: "title",
                    templates: {
                        suggestion: function (item) {
                            return `<div>${item.title}</div>`;
                        },
                        empty: '<div class="tt-empty">No se encontraron resultados</div>',
                    },
                }
            )
            .on("typeahead:select", function (event, suggestion) {
                $(".input-id-ambito").val(suggestion.id);
            });
    };

    // Columnas para ambitos
    const ambitosColumnDefs = [
        {
            headerName: "Nombre",
            field: "title",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Acciones",
            field: "id",
            width: 250,
            cellRenderer: (params) => `
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal${
                    params.data?.id || ""
                }">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal${
                    params.data?.id || ""
                }">Eliminar</button>
            `,
        },
    ];

    // Columnas para preguntas
    const preguntasColumnDefs = [
        {
            headerName: "Pregunta",
            field: "title",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Puntaje",
            width: 105 ,
            field: "prioridad",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Ambito",
            field: "ambito.title",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Acciones",
            field: "id",
            width: 250,
            cellRenderer: (params) => `
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModalP${
                    params.data?.id || ""
                }">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalP${
                    params.data?.id || ""
                }">Eliminar</button>
            `,
        },
    ];

    const formulariosColumDefs = [
        {
            headerName: "Nombre",
            field: "nombre",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Responsable",
            field: "user.name",
            filter: true,
            floatingFilter: true,
        },
        {
            headerName: "Acciones",
            field: "id",
            width: 250,
            cellRenderer: function (params) {
                return `
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModalF${params.data.id}">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalF${params.data.id}">Eliminar</button>
                        `;
            },
        },
    ];

    // Inicializar grids primero con arrays vacíos
    const ambitosGrid = document.querySelector("#myGrid");
    const preguntasGrid = document.querySelector("#myGrid2");
    const formulariosGrid = document.querySelector("#myGrid3");

    let ambitosGridApi, preguntasGridApi, formulariosGridApi;

    if (formulariosGrid) {
        formulariosGridApi = createDataGrid(
            formulariosGrid,
            [],
            formulariosColumDefs
        );
    }

    if (ambitosGrid) {
        ambitosGridApi = createDataGrid(ambitosGrid, [], ambitosColumnDefs);
    }

    if (preguntasGrid) {
        preguntasGridApi = createDataGrid(
            preguntasGrid,
            [],
            preguntasColumnDefs
        );
    }

    // Luego cargar los datos
    Promise.all([
        fetchData("/api/ambi"),
        fetchData("/api/pregu"),
        fetchData("/api/formu"),
    ])
        .then(([ambitosData, preguntasData, FormulariosData]) => {
            if (formulariosGridApi) {
                formulariosGridApi.setGridOption(
                    "rowData",
                    FormulariosData || []
                );
            }
            // Actualizar grid de ámbitos si existe
            if (ambitosGridApi) {
                ambitosGridApi.setGridOption("rowData", ambitosData || []);
            }
            // Configurar Typeahead con los datos de ámbitos
            setupTypeahead(ambitosData);

            // Actualizar grid de preguntas si existe
            if (preguntasGridApi) {
                preguntasGridApi.setGridOption("rowData", preguntasData || []);
            }
        })
        .catch((error) => {
            console.error("Error general:", error);
        });

        document.querySelectorAll(".select-situ").forEach((select) => {
            select.addEventListener("change", (event) => {
                // Obtenemos el valor seleccionado y nos aseguramos que sea un string
                const selectedValue = event.target.value.toString();
                console.log("Valor seleccionado:", selectedValue);
        
                // Primero ocultamos todos los feedbacks existentes
                document.querySelectorAll("[class*='feedback-']").forEach((feedback) => {
                    feedback.style.visibility = "hidden"; // Los ocultamos
                    feedback.style.height = "0"; // Aseguramos que no ocupen espacio
                    feedback.style.width = "0"; // Aseguramos que no ocupen espacio
                    feedback.style.padding = "0"; // Aseguramos que no ocupen espacio
                    feedback.style.margin = "0"; // Aseguramos que no ocupen espacio
                });
        
                // Solo mostramos los feedbacks si no es la opción por defecto
                if (selectedValue && selectedValue !== "Elige Situacion:") {
                    const feedbacksToShow = document.querySelectorAll(`.feedback-${selectedValue}`);
                    console.log("Feedbacks encontrados para mostrar:", feedbacksToShow.length);
        
                    feedbacksToShow.forEach((feedback) => {
                        feedback.style.visibility = "visible"; // Los hacemos visibles
                        feedback.style.height = "auto"; // Aseguramos que ocupen su espacio adecuado
                        feedback.style.width = "auto"; // Aseguramos que ocupen su espacio adecuado
                        feedback.style.margin = "0 0 15px 0"; // Reestablecemos el margen, si es necesario
                    });
                }
            });
        });
         
});


//paginator

document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 2;
    const tables = ['ambitos', 'preguntas', 'formularios'];

    tables.forEach(table => {
        const rows = document.querySelectorAll(`#${table}-table .table-row`);
        const mobileRows = Array.from(rows).map(row => row.cloneNode(true));
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            const mobileContainer = document.getElementById(`${table}-table-mobile`);
            mobileContainer.innerHTML = '';
            for (let i = start; i < end && i < mobileRows.length; i++) {
                mobileContainer.appendChild(mobileRows[i].cloneNode(true));
            }

            updatePagination(page, totalPages, `${table}-pagination`);
            updatePagination(page, totalPages, `${table}-pagination-mobile`);
        }

        function updatePagination(currentPage, totalPages, paginationId) {
            const pagination = document.getElementById(paginationId);
            pagination.innerHTML = '';

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = '<a class="page-link" href="#" tabindex="-1">Anterior</a>';
            prevLi.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 1) showPage(currentPage - 1);
            });
            pagination.appendChild(prevLi);

            const startPage = Math.max(1, currentPage - 1);
            const endPage = Math.min(totalPages, startPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', (e) => {
                    e.preventDefault();
                    showPage(i);
                });
                pagination.appendChild(li);
            }

            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = '<a class="page-link" href="#">Siguiente</a>';
            nextLi.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage < totalPages) showPage(currentPage + 1);
            });
            pagination.appendChild(nextLi);
        }

        showPage(1);

        const searchInput = document.querySelector(`input[data-table="${table}-table"]`);
        const mobileSearchInput = document.querySelector(`input[data-table="${table}-table-mobile"]`);

        [searchInput, mobileSearchInput].forEach(input => {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredRows = Array.from(rows).filter(row => 
                    row.textContent.toLowerCase().includes(searchTerm)
                );
                const filteredMobileRows = filteredRows.map(row => row.cloneNode(true));

                currentPage = 1;
                const newTotalPages = Math.ceil(filteredRows.length / itemsPerPage);

                function showFilteredPage(page) {
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;

                    rows.forEach(row => row.style.display = 'none');
                    filteredRows.slice(start, end).forEach(row => row.style.display = '');

                    const mobileContainer = document.getElementById(`${table}-table-mobile`);
                    mobileContainer.innerHTML = '';
                    for (let i = start; i < end && i < filteredMobileRows.length; i++) {
                        mobileContainer.appendChild(filteredMobileRows[i].cloneNode(true));
                    }

                    updatePagination(page, newTotalPages, `${table}-pagination`);
                    updatePagination(page, newTotalPages, `${table}-pagination-mobile`);
                }

                showFilteredPage(1);
            });
        });
    });
});