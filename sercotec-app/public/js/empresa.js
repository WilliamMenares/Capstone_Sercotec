// Tabla grid
const EmpresasData = window.empresas.map((pro) => ({
    id: pro.id,
    nombre: pro.nombre,
    rut: pro.rut,
    telefono: pro.telefono,
    email: pro.email
}));

const columnDefs = [
    {
        headerName: "Rut",
        field: "rut",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Nombre",
        field: "nombre",
        filter: true,
        floatingFilter: true
    },
    
    {
        headerName: "Email",
        field: "email",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Telefono",
        field: "telefono",
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

const gridOptions = {
    columnDefs: columnDefs,
    rowData: EmpresasData,
    pagination: true,
    paginationPageSize: 20,
    domLayout: "autoHeight",
    onFirstDataRendered: (params) => {
        params.api.sizeColumnsToFit();
    }
};

EmpresasData.forEach(empresa => {
    createDeleteModal(empresa);
    editModal(empresa); // Crear el modal de edición
});

// Inicializar grid
let gridApi;

document.addEventListener("DOMContentLoaded", function () {
    const gridDiv = document.querySelector("#myGrid");
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
    // Generar modales dinámicamente
    
});

// Crear un modal para eliminar producto
function createDeleteModal(empresa) {
    const modalHtml = `
        <div class="modal fade" id="deleteModal-${empresa.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar empresa</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este empresa?</p>
                        
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${empresa.id}" action="/empresa/${empresa.id}" method="POST">
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

function editModal(empresa){
    const modalHtml = `<div class="modal fade" id="editModal-${empresa.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Producto</h1>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botón de cierre -->
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form-${empresa.id}" class="formcru" action="${updateRoute.replace(':id', empresa.id)}" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre:</label>
                                            <input type="text" class="form-control bg-dark text-light" name="nombre" value="${empresa.nombre}" placeholder="Nombre"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rut" class="form-label">Rut</label>
                                            <input type="text" class="form-control bg-dark text-light rut-vali" value="${empresa.rut}" name="rut"
                                                placeholder="12123321-1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Telefono</label>
                                            <input type="text" class="form-control bg-dark text-light phone-vali" value="${empresa.telefono}" name="telefono"
                                                placeholder="+56912345678" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control bg-dark text-light" name="email" value="${empresa.email}" placeholder="Email"
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
