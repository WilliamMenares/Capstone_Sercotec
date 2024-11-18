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

        
});

document.addEventListener("DOMContentLoaded", function () {
    const formularioSelect = document.getElementById("formulario");
    const ambitos = document.querySelectorAll(".ambito");
    let currentAmbitoIndex = -1; // Índice actual del ámbito visible

    // Cambiar visibilidad según formulario seleccionado
    formularioSelect.addEventListener("change", function () {
        const selectedFormulario = this.value;
        currentAmbitoIndex = 0; // Reinicia al primer ámbito

        // Oculta todos los ámbitos
        ambitos.forEach(ambito => ambito.style.display = "none");

        // Muestra el primer ámbito del formulario seleccionado
        const filteredAmbitos = Array.from(ambitos).filter(
            ambito => ambito.getAttribute("data-formulario") === selectedFormulario
        );

        if (filteredAmbitos.length > 0) {
            filteredAmbitos[currentAmbitoIndex].style.display = "block";
        }
    });

    // Botones de navegación
    document.addEventListener("click", function (event) {
        if (event.target.id === "next-btn" || event.target.id === "prev-btn") {
            const selectedFormulario = formularioSelect.value;
            if (!selectedFormulario) return; // Si no hay formulario seleccionado, no hace nada

            const filteredAmbitos = Array.from(ambitos).filter(
                ambito => ambito.getAttribute("data-formulario") === selectedFormulario
            );

            // Oculta el ámbito actual
            filteredAmbitos[currentAmbitoIndex].style.display = "none";

            // Cambia el índice según el botón
            if (event.target.id === "next-btn" && currentAmbitoIndex < filteredAmbitos.length - 1) {
                currentAmbitoIndex++;
            } else if (event.target.id === "prev-btn" && currentAmbitoIndex > 0) {
                currentAmbitoIndex--;
            }

            // Muestra el nuevo ámbito
            filteredAmbitos[currentAmbitoIndex].style.display = "block";
        }
    });
});
