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
    const avances = document.querySelectorAll(".progreso");
    const general = document.getElementById("progreso-general");
    resetGeneralProgressBar();
    resetAllProgressBars();
    let currentAmbitoIndex = -1;

    function updateGeneralProgressBar(formularioId) {
        const allAmbitos = Array.from(
            document.querySelectorAll(
                `.ambito[data-formulario="${formularioId}"]`
            )
        );

        let totalQuestions = 0;
        let totalAnswered = 0;

        allAmbitos.forEach((ambito) => {
            const questions = ambito.querySelectorAll(".pre-item");
            totalQuestions += questions.length;
            totalAnswered += Array.from(questions).filter((item) =>
                item.querySelector('input[type="radio"]:checked')
            ).length;
        });

        // Calculate general progress percentage
        const percentage = Math.round((totalAnswered / totalQuestions) * 100);

        // Update general progress bar
        const progressBar = document.querySelector(
            "#progreso-general .progress-bar"
        );
        if (progressBar) {
            progressBar.style.width = `${percentage}%`;
            progressBar.setAttribute("aria-valuenow", percentage);
            progressBar.textContent = `${percentage}%`;
        }
    }

    function updateProgressBar(formularioId, ambitoIndex) {
        const currentAmbito = document.querySelector(
            `.ambito[data-formulario="${formularioId}"][data-index="${ambitoIndex}"]`
        );
        if (!currentAmbito) return;

        const progressBars = Array.from(
            document.querySelectorAll(
                `.progreso[data-formulario="${formularioId}"]`
            )
        );
        const progressBar = progressBars.find((pb) => {
            const label = pb.querySelector("label");
            return (
                label &&
                label.textContent.trim() ===
                    currentAmbito.querySelector(".pre3").textContent.trim()
            );
        });

        if (!progressBar) return;

        // Total questions in this ámbito
        const totalQuestions =
            currentAmbito.querySelectorAll(".pre-item").length;

        // Questions answered
        const answeredQuestions = Array.from(
            currentAmbito.querySelectorAll(".pre-item")
        ).filter((item) =>
            item.querySelector('input[type="radio"]:checked')
        ).length;

        // Calculate ámbito progress percentage
        const percentage = Math.round(
            (answeredQuestions / totalQuestions) * 100
        );

        // Update ámbito progress bar
        const progressBarElement = progressBar.querySelector(".progress-bar");
        progressBarElement.style.width = `${percentage}%`;
        progressBarElement.setAttribute("aria-valuenow", percentage);
        progressBarElement.textContent = `${percentage}%`;

        // Update the general progress bar
        updateGeneralProgressBar(formularioId);
    }

    function resetGeneralProgressBar() {
        const progressBar = document.querySelector(
            "#progreso-general .progress-bar"
        );
        if (progressBar) {
            progressBar.style.width = "0%";
            progressBar.setAttribute("aria-valuenow", 0);
            progressBar.textContent = "0%";
        }
    }
    function resetAllProgressBars() {
        // Obtener todas las barras de progreso
        const progressBars = document.querySelectorAll(".progress-bar");
    
        // Iterar sobre cada barra de progreso y resetearla
        progressBars.forEach(progressBar => {
            progressBar.style.width = "0%";
            progressBar.setAttribute("aria-valuenow", 0);
            progressBar.textContent = "0%";
        });
    
        // Resetear el progreso general
        const generalProgressBars = document.querySelectorAll('.progreso');
        generalProgressBars.forEach(progressBar => {
            const progressBarElement = progressBar.querySelector(".progress-bar");
            if (progressBarElement) {
                progressBarElement.style.width = "0%";
                progressBarElement.setAttribute("aria-valuenow", 0);
                progressBarElement.textContent = "0%";
            }
        });
    
        // Si tienes una función para actualizar el progreso general, puedes llamarla aquí
        resetGeneralProgressBar();
    }
    

    // Existing change event for formulario select
    formularioSelect.addEventListener("change", function () {
        if (this.value) {
            general.style.display = "flex";
        } else {
            general.style.display = "none";
        }

        // Reinicia la barra de progreso general
        resetGeneralProgressBar();
        resetAllProgressBars();
        // Desmarcar todos los radios
        const allRadioButtons = document.querySelectorAll(
            'input[type="radio"]'
        );
        allRadioButtons.forEach((radio) => {
            radio.checked = false;
        });

        const selectedFormulario = this.value;
        currentAmbitoIndex = 0;

        ambitos.forEach((ambito) => (ambito.style.display = "none"));
        avances.forEach((avance) => (avance.style.display = "none"));

        const filteredAmbitos = Array.from(ambitos).filter(
            (ambito) =>
                ambito.getAttribute("data-formulario") === selectedFormulario
        );

        if (filteredAmbitos.length > 0) {
            filteredAmbitos[currentAmbitoIndex].style.display = "block";
        }

        const filteredAvances = Array.from(avances).filter(
            (avance) =>
                avance.getAttribute("data-formulario") === selectedFormulario
        );

        filteredAvances.forEach((avance) => (avance.style.display = "flex"));
    });

    // Add event listener for radio button changes
    document.addEventListener("change", function (event) {
        if (event.target.type === "radio") {
            const selectedFormulario = formularioSelect.value;
            if (selectedFormulario) {
                updateProgressBar(selectedFormulario, currentAmbitoIndex);
            }
        }
    });

    // Existing navigation button logic
    document.addEventListener("click", function (event) {
        if (event.target.id === "next-btn" || event.target.id === "prev-btn") {
            const selectedFormulario = formularioSelect.value;
            if (!selectedFormulario) return;

            const filteredAmbitos = Array.from(ambitos).filter(
                (ambito) =>
                    ambito.getAttribute("data-formulario") ===
                    selectedFormulario
            );

            filteredAmbitos[currentAmbitoIndex].style.display = "none";

            if (
                event.target.id === "next-btn" &&
                currentAmbitoIndex < filteredAmbitos.length - 1
            ) {
                currentAmbitoIndex++;
            } else if (
                event.target.id === "prev-btn" &&
                currentAmbitoIndex > 0
            ) {
                currentAmbitoIndex--;
            }

            filteredAmbitos[currentAmbitoIndex].style.display = "block";
        }
    });
});
