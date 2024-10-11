document.addEventListener("DOMContentLoaded", function () {
    // Modal de "Agregar Empresa"
    var modalAgregar = document.getElementById("modalAgregar");
    modalAgregar.addEventListener("hidden.bs.modal", function () {
        // Restablecer el formulario de agregar cuando se cierra el modal
        document.getElementById("formAgregarEmpresa").reset();
    });

    // Modal de "Editar Empresa" - para cada empresa
    document
        .querySelectorAll('[id^="modalEditar"]')
        .forEach(function (modalEditar) {
            // Guardar valores originales cuando se abre el modal
            modalEditar.addEventListener("shown.bs.modal", function () {
                var form = modalEditar.querySelector("form");
                form.dataset.originalRut = form.rut_editar.value;
                form.dataset.originalNombre = form.nombre_editar.value;
                form.dataset.originalEmail = form.email_editar.value;
                form.dataset.originalTelefono = form.telefono_editar.value;
            });

            // Restaurar los valores originales cuando se cierra el modal
            modalEditar.addEventListener("hidden.bs.modal", function () {
                var form = modalEditar.querySelector("form");
                form.rut_editar.value = form.dataset.originalRut;
                form.nombre_editar.value = form.dataset.originalNombre;
                form.email_editar.value = form.dataset.originalEmail;
                form.telefono_editar.value = form.dataset.originalTelefono;
            });
        });
});

document.addEventListener("DOMContentLoaded", function () {
    // Función para formatear el RUT
    function formatRUT(rut) {
        // Eliminar puntos y guiones si están presentes
        rut = rut.replace(/\./g, "").replace(/-/g, "");

        // Limitar el RUT a un máximo de 9 caracteres
        if (rut.length > 9) {
            rut = rut.slice(0, 9);
        }

        // Agregar guion antes del último dígito
        const cuerpo = rut.slice(0, -1);
        const dv = rut.slice(-1);
        const cuerpoConPuntos = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return `${cuerpoConPuntos}-${dv}`;
    }

    // Validación y formateo automático para el RUT agregar
    const rutAgregarInput = document.getElementById("rut_agregar");
    if (rutAgregarInput) {
        rutAgregarInput.addEventListener("input", function (e) {
            e.target.value = formatRUT(e.target.value);
        });
    }

    // Validación y formateo automático para el RUT editar
    const rutEditarInput = document.getElementById("rut_editar");
    if (rutEditarInput) {
        rutEditarInput.addEventListener("input", function (e) {
            e.target.value = formatRUT(e.target.value);
        });
    }

    // Función para validar y agregar automáticamente +56 al número de teléfono
    function formatTelefono(telefono) {
        // Eliminar cualquier carácter no numérico
        telefono = telefono.replace(/\D/g, "");

        // Si el número no empieza con +56, agregarlo
        if (!telefono.startsWith("56")) {
            telefono = "56" + telefono;
        }

        // Formatear el número para que sea +56 9 XXX XXXX
        if (telefono.length > 4) {
            return `+${telefono.slice(0, 2)} ${telefono.slice(
                2,
                3
            )} ${telefono.slice(3, 7)} ${telefono.slice(7, 11)}`;
        }

        return `+${telefono}`; // Si aún no tiene suficientes dígitos
    }

    // Validación y formateo automático para el teléfono agregar
    const telefonoAgregarInput = document.getElementById("telefono_agregar");
    if (telefonoAgregarInput) {
        telefonoAgregarInput.addEventListener("input", function (e) {
            e.target.value = formatTelefono(e.target.value);
        });
    }

    // Validación y formateo automático para el teléfono editar
    const telefonoEditarInput = document.getElementById("telefono_editar");
    if (telefonoEditarInput) {
        telefonoEditarInput.addEventListener("input", function (e) {
            e.target.value = formatTelefono(e.target.value);
        });
    }
});
