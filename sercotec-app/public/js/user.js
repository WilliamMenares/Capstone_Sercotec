// Tabla grid
const empleadosData = window.usuarios.map((em) => ({
    id: em.id,
    rut: em.rut,
    nombre: em.name,
    telefono: em.telefono,
    email: em.email
}));

const columnDefs = [
    { headerName: "Rut", field: "rut",width: 250 },
    {
        headerName: "Nombre",
        field: "nombre",
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
        headerName: "Email",
        field: "email",
        filter: true,
        floatingFilter: true
    },
    {
        headerName: "Acciones",
        width: 250,
        cellRenderer: function (params) {
            return `
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-${params.data.id}">Editar</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-${params.data.id}">Eliminar</button>
                `;
        },
    }
];

const gridOptions = {
    columnDefs: columnDefs,
    rowData: empleadosData,
    pagination: true,
    paginationPageSize: 20,
    domLayout: "autoHeight",
    onFirstDataRendered: (params) => {
        params.api.sizeColumnsToFit();
    }
};



// Inicializar grid
let gridApi;





document.addEventListener("DOMContentLoaded", function () {
    empleadosData.forEach(empleado => {
        createDeleteModal(empleado);
        editModal(empleado); 
    });
    const gridDiv = document.querySelector("#myGrid");
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
});

// Crear un modal para eliminar producto
function createDeleteModal(empleado) {
    const modalHtml = `
        <div class="modal fade" id="deleteModal-${empleado.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Empleado</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este empleado?</p>
                        
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form-${empleado.id}" action="/user/${empleado.id}" method="POST">
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

function editModal(empleado){
    const modalHtml = `<div class="modal fade" id="editModal-${empleado.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light"> <!-- Modo oscuro -->
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Editar Empleado</h1>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botón de cierre -->
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form-${empleado.id}" action="${updateRoute.replace(':id', empleado.id)}" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector("meta[name='csrf-token']").getAttribute("content")}">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control bg-dark text-light" name="name"  placeholder="Nombre del Empleado" value="${empleado.nombre}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control bg-dark text-light" name="email"  placeholder="Email del Empleado" value="${empleado.email}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">telefono</label>
                                    <input type="text" class="form-control bg-dark text-light phone-vali" name="telefono"  placeholder="+56912345678" value="${empleado.telefono}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rut" class="form-label">Rut</label>
                                    <input type="text" class="form-control bg-dark text-light rut-vali" name="rut"  placeholder="12345678-9" value="${empleado.rut}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control bg-dark text-light" name="password"   >
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirme Contraseña</label>
                                    <input type="password" class="form-control bg-dark text-light" name="password_confirmation"   >
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
