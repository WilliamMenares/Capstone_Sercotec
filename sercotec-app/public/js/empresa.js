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

    const telefonoAgregar = document.getElementById('telefono_agregar');
    const telefonoEditar = document.querySelectorAll('input[name="telefono_editar"]');

        // Función que valida y formatea el número de teléfono
        function formatearTelefono(input) {
            input.addEventListener('input', function () {
                let valor = input.value;
    
                // Si el número no empieza con "+56", lo agregamos
                if (!valor.startsWith('+56')) {
                    valor = '+56' + valor.replace(/^\+56/, '');
                }
    
                // Limitar la longitud a 9 dígitos después del "+56"
                let soloNumeros = valor.replace(/\D/g, ''); // Elimina cualquier cosa que no sea un número
                if (soloNumeros.length > 11) { // +56 (2 dígitos) + 9 dígitos del número
                    soloNumeros = soloNumeros.substring(0, 11);
                }
    
                // Formatear de nuevo el número
                input.value = '+' + soloNumeros;
            });
        }
    
        // Aplicar la función al campo de agregar
        formatearTelefono(telefonoAgregar);
    
        // Aplicar la función a todos los campos de edición
        telefonoEditar.forEach(function (input) {
            formatearTelefono(input);
        });
});
