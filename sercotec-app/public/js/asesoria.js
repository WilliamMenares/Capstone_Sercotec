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

    const formularioSelect = document.getElementById("formulario");
    let currentAmbitoIndex = 0;
    let currentAmbitos = [];

    function updateNavigationButtons() {
        document.getElementById("prev-btn").disabled = currentAmbitoIndex === 0;
        document.getElementById("next-btn").disabled =
            currentAmbitoIndex === currentAmbitos.length - 1;
    }

    function showAmbito(index) {
        currentAmbitos.forEach((ambito, i) => {
            ambito.style.display = i === index ? "block" : "none";
        });
        updateNavigationButtons();
    }

    function loadAmbitosForFormulario(formularioId) {
        const allAmbitos = document.querySelectorAll(".ambito");
        currentAmbitos = Array.from(allAmbitos).filter(
            (ambito) => ambito.getAttribute("data-formulario") === formularioId
        );
        currentAmbitoIndex = 0;
        showAmbito(currentAmbitoIndex);
    }

    formularioSelect.addEventListener("change", function () {
        const formularioId = formularioSelect.value;

        if (formularioId) {
            loadAmbitosForFormulario(formularioId);
        } else {
            // Si no hay formulario seleccionado, oculta todos los ámbitos
            document
                .querySelectorAll(".ambito")
                .forEach((ambito) => (ambito.style.display = "none"));
            currentAmbitos = [];
        }
    });

    document.getElementById("next-btn").addEventListener("click", function () {
        if (currentAmbitoIndex < currentAmbitos.length - 1) {
            currentAmbitoIndex++;
            showAmbito(currentAmbitoIndex);
        }
    });

    document.getElementById("prev-btn").addEventListener("click", function () {
        if (currentAmbitoIndex > 0) {
            currentAmbitoIndex--;
            showAmbito(currentAmbitoIndex);
        }
    });

    // Inicialmente oculta todos los ámbitos hasta que se seleccione un formulario
    document
        .querySelectorAll(".ambito")
        .forEach((ambito) => (ambito.style.display = "none"));
});
