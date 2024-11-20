document.addEventListener("DOMContentLoaded", () => {

    $(document).ready(function () {
        $('.sl_ambito').chosen({
            width: "100%",
            placeholder_text_multiple: "Selecciona opciones"
        });
    });



    // Función para configurar Typeahead
    const setupTypeahead = (data) => {
        const AmbitosTypeHead = new Bloodhound({
            datumTokenizer: function (datum) {
                return Bloodhound.tokenizers.whitespace(datum.title);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: data || [] // Aseguramos que siempre haya un array
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
                        empty: '<div class="tt-empty">No se encontraron resultados</div>'
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
            cellRenderer: params => `
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal${params.data?.id || ''}">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal${params.data?.id || ''}">Eliminar</button>
            `,
        },
    ];

    // Columnas para preguntas
    const preguntasColumnDefs = [
        {
            headerName: "Nombre",
            field: "title",
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
            cellRenderer: params => `
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModalP${params.data?.id || ''}">Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalP${params.data?.id || ''}">Eliminar</button>
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
            field: "responsable",
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

    if(formulariosGrid){
        formulariosGridApi = createDataGrid(formulariosGrid, [], formulariosColumDefs);
    }

    if (ambitosGrid) {
        ambitosGridApi = createDataGrid(ambitosGrid, [], ambitosColumnDefs);
    }

    if (preguntasGrid) {
        preguntasGridApi = createDataGrid(preguntasGrid, [], preguntasColumnDefs);
    }

    // Luego cargar los datos
    Promise.all([
        fetchData("/api/ambi"),
        fetchData("/api/pregu"),
        fetchData("/api/formu"),
    ])
    .then(([ambitosData, preguntasData, FormulariosData]) => {

        if (formulariosGridApi) {
            formulariosGridApi.setGridOption('rowData', FormulariosData || []);
        }
        // Actualizar grid de ámbitos si existe
        if (ambitosGridApi) {
            ambitosGridApi.setGridOption('rowData', ambitosData || []);
        }
        // Configurar Typeahead con los datos de ámbitos
        setupTypeahead(ambitosData);

        // Actualizar grid de preguntas si existe
        if (preguntasGridApi) {
            preguntasGridApi.setGridOption('rowData', preguntasData || []);
        }
    })
    .catch(error => {
        console.error("Error general:", error);
    });
});



















