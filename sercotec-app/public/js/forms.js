// Tabla grid
const AmbitosData = window.ambitos.map((pro) => ({
    id: pro.id,
    title: pro.title
}));

const preguntasData = window.preguntas.map((pro) => ({
    id: pro.id,
    title: pro.title,
    nombre: pro.ambito.title,
    id_am : pro.ambito.id
}));

const formulariosData = window.formularios.map((pro) => ({
    id: pro.id,
    nombre: pro.nombre,
    responsable : pro.responsable
}));

const columnDefs = [
    {
        headerName: "Nombre",
        field: "title",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Acciones",
        field: "id",
        width: 250,
        cellRenderer: function (params) {
            return `
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-${params.data.id}">Editar</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-${params.data.id}">Eliminar</button>
                `;
        },
    },
];

const columnDefs2 = [
    {
        headerName: "Nombre",
        field: "title",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Ambito",
        field: "nombre",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Acciones",
        field: "id",
        width: 250,
        cellRenderer: function (params) {
            return `
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModalP-${params.data.id}">Editar</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalP-${params.data.id}">Eliminar</button>
                `;
        },
    },
];

const columnDefs3 = [
    {
        headerName: "Nombre",
        field: "nombre",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Responsable",
        field: "responsable",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Acciones",
        field: "id",
        width: 250,
        cellRenderer: function (params) {
            return `
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal3-${params.data.id}">Editar</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal3-${params.data.id}">Eliminar</button>
                    `;
        },
    },
];

const gridOptions = {
    columnDefs: columnDefs,
    rowData: AmbitosData,
    pagination: true,
    paginationPageSizeSelector: [10, 20, 50, 100],
    paginationPageSize: 10,
    domLayout: "autoHeight",
    onFirstDataRendered: (params) => {
        params.api.sizeColumnsToFit();
    }
};

const gridOptions2 = {
    columnDefs: columnDefs2,
    rowData: preguntasData,
    pagination: true,
    paginationPageSizeSelector: [10, 20, 50, 100],
    paginationPageSize: 10,
    domLayout: "autoHeight",
    onFirstDataRendered: (params) => {
        params.api.sizeColumnsToFit();
    }
};

const gridOptions3 = {
    columnDefs: columnDefs3,
    rowData: formulariosData,
    pagination: true,
    paginationPageSizeSelector: [10, 20, 50, 100],
    paginationPageSize: 10,
    domLayout: "autoHeight",
    onFirstDataRendered: (params) => {
        params.api.sizeColumnsToFit();
    }
};

// Inicializar grid
let gridApi;

document.addEventListener("DOMContentLoaded", function () {
    
    AmbitosData.forEach(ambito => {
        createDeleteModalA(ambito);
        editModalA(ambito); // Crear el modal de edición
    });

    preguntasData.forEach(pregunta => {
        createDeleteModalP(pregunta);
        editModalP(pregunta); // Crear el modal de edición
    });
    
    formulariosData.forEach(formulario =>{
        createDeleteModalF(formulario);
        editModalF(formulario);
    });
    
    
    const gridDiv = document.querySelector("#myGrid");
    const gridDiv2 = document.querySelector("#myGrid2");
    const gridDiv3 = document.querySelector("#myGrid3");
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
    gridApi = agGrid.createGrid(gridDiv2, gridOptions2);
    gridApi = agGrid.createGrid(gridDiv3, gridOptions3);
    // Generar modales dinámicamente
    

    function initializeTypeahead(selector, engine, displayKey) {
        const input = document.querySelector(selector);
        if (input) {
            $(input)
                .typeahead(
                    {
                        hint: true,
                        highlight: true,
                        minLength: 1,
                    },
                    {
                        name: displayKey,
                        display: displayKey,
                        source: engine,
                        limit: 3,
                    }
                ).bind("typeahead:select", function (ev, suggestion) {
                    // Rellenar el párrafo con el precio del producto seleccionado
                    if (selector === ".search-ambito") {
                        const id = suggestion.id;
                        document.getElementById("id_ambito").value = id;
                    }
                });
        }
    }

    const AmbitoEngine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("title"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: window.ambitos,
    });

    initializeTypeahead(".search-ambito", AmbitoEngine, "title");



});

// Crear un modal para eliminar producto
function createDeleteModalA(ambito) {
    const modalHtml = `
        <div class="modal fade" id="deleteModal-${ambito.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar ambito</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este ambito?</p>
                        
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${ambito.id}" action="${deleteRouteA.replace(':id', ambito.id)}" method="POST">
                                <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">
                                    Eliminar
                                </button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml); // Añadir el modal al final del body
}

function createDeleteModalP(pregunta) {
    const modalHtml = `
        <div class="modal fade" id="deleteModalP-${pregunta.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar pregunta</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar esta pregunta?</p>
                        
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${pregunta.id}" action="${deleteRouteP.replace(':id', pregunta.id)}" method="POST">
                                <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">
                                    Eliminar
                                </button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml); // Añadir el modal al final del body
}

function editModalA(ambito){
    const modalHtml = `<div class="modal fade" id="editModal-${ambito.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Ambito</h1>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botón de cierre -->
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form-${ambito.id}" class="formcru" action="${updateRouteA.replace(':id', ambito.id)}" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Nombre Ambito:</label>
                                            <input type="text" class="form-control bg-dark text-light" name="title" value="${ambito.title}" placeholder="Nombre"
                                                required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml); // Añadir el modal al final del body

}

function editModalP(pregunta){
    const modalHtml = `<div class="modal fade" id="editModalP-${pregunta.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Pregunta</h1>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botón de cierre -->
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form-${pregunta.id}" class="formcru" action="${updateRouteP.replace(':id', pregunta.id)}" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                        <div class="mb-3">
                                            <label for="nombrep" class="form-label">Pregunta:</label>
                                            <input type="text" class="form-control bg-dark text-light" name="nombrep" value="${pregunta.title}" placeholder="Nombre" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ambito" class="form-label">Ambito:</label>
                                            <input type="text" class="form-control bg-dark text-light" name="ambito" id="edit_ambito_${pregunta.id}" value="${pregunta.nombre}" placeholder="Ambito" required>
                                            <input type="hidden" id="id_ambito_${pregunta.id}" name="id_ambito" value="${pregunta.id_am}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml); // Añadir el modal al final del body

    const AmbitoEngine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("title"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: window.ambitos,
    });

    // Llamar a la función para inicializar typeahead
    initializeTypeahead2(`#edit_ambito_${pregunta.id}`, AmbitoEngine, "title", `${pregunta.id}`);


}

function initializeTypeahead2(selector, engine, displayKey, id_pregunta) {
    const input = document.querySelector(selector);
    if (input) {
        $(input)
            .typeahead(
                {
                    hint: true,
                    highlight: true,
                    minLength: 1,
                },
                {
                    name: displayKey,
                    display: displayKey,
                    source: engine,
                    limit: 3,
                }
            ).bind("typeahead:select", function (ev, suggestion) {
                // Rellenar el campo oculto con el id del ámbito seleccionado
                document.getElementById(`id_ambito_${id_pregunta}`).value = suggestion.id;
            });
    }
}

function createDeleteModalF(formulario) {
    const modalHtml = `
        <div class="modal fade" id="deleteModal3-${formulario.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar formulario</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este formulario?</p>
                        
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${formulario.id}" action="${deleteRouteF.replace(':id', formulario.id)}" method="POST">
                                <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">
                                    Eliminar
                                </button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </div>
            </div>
        </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml); // Añadir el modal al final del body
}

function editModalF(formulario){

    const ambitosOptions = window.ambitos.map(ambito => 
        `<option value="${ambito.id}">${ambito.title}</option>`
    ).join('');


    const modalHtml = `<div class="modal fade" id="editModal3-${formulario.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="editModal3Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editModal3Label">Crear un Formulario</h1>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-form" action="/forms.storeFormulario" method="POST">
                                            <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Formulario:</label>
                                                <input type="text" class="form-control bg-dark text-light" name="nombre" placeholder="Nombre" value="${formulario.nombre}"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="responsable" class="form-label">Responsable:</label>
                                                <input type="text" class="form-control bg-dark text-light" name="responsable"
                                                    placeholder="Responsable" value="${formulario.responsable}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ambitos" class="form-label">Ámbitos:</label>
                                                <select name="ambitos[]" id="chosen-example" class="select-ambito"
                                                    multiple="multiple" required>
                                                    ${ambitosOptions}
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}