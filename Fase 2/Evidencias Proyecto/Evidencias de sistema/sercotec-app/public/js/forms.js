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
            width: 98 ,
            field: "puntaje",
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
