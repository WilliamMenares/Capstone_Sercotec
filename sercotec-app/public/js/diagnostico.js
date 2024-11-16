document.addEventListener("DOMContentLoaded", () => {
    // Función para configurar Typeahead
    const setupTypeahead = (data) => {
        const EmpresaTypeHead = new Bloodhound({
            datumTokenizer: function (datum) {
                return Bloodhound.tokenizers.whitespace(datum.codigo);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: data || [], // Aseguramos que siempre haya un array
        });

        EmpresaTypeHead.initialize();

        $(".search-empresa")
            .typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1,
                },
                {
                    name: "empresa",
                    source: EmpresaTypeHead.ttAdapter(),
                    display: "nombre",
                    templates: {
                        suggestion: function (item) {
                            return `<div>${item.nombre}</div>`;
                        },
                        empty: '<div class="tt-empty">No se encontraron resultados</div>',
                    },
                }
            )
            .on("typeahead:select", function (event, suggestion) {
                $(".input-id-empresa").val(suggestion.id);
            });
    };

    // Función para hacer fetch con manejo de errores
    const fetchData = async (url) => {
        try {
            const response = await fetch(url, {
                method: "GET",
                credentials: "same-origin",
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`Error fetching data from ${url}:`, error);
            return []; // Retornamos array vacío en caso de error
        }
    };

    // Luego cargar los datos
    Promise.all([fetchData("/api/emp")])
        .then(([empresaData]) => {
            // Configurar Typeahead con los datos de ámbitos
            setupTypeahead(empresaData);
        })
        .catch((error) => {
            console.error("Error general:", error);
        });

    const ambitos = document.querySelectorAll('.ambito');
    const prevButton = document.querySelector('#prev-btn');
    const nextButton = document.querySelector('#next-btn');

    let currentIndex = 0;

    function updatePagination() {
        ambitos.forEach((ambito, index) => {
            ambito.style.display = index === currentIndex ? 'block' : 'none';
        });

        // Actualizar estado de los botones (asegúrate de que currentIndex esté dentro de los límites)
        prevButton.disabled = currentIndex === 0;
        nextButton.disabled = currentIndex === ambitos.length - 1;
    }

    // Manejadores de eventos
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updatePagination();
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < ambitos.length - 1) {
            currentIndex++;
            updatePagination();
        }
    });

    // Inicialización
    updatePagination();
});

