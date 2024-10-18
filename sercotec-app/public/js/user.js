document.addEventListener("DOMContentLoaded", function () {
    // Modal de "Agregar Usuario"
    var modalAgregar = document.getElementById("modalAgregar");
    modalAgregar.addEventListener("hidden.bs.modal", function () {
        // Restablecer el formulario de agregar cuando se cierra el modal
        document.getElementById("userForm").reset();
        document.getElementById("passwordError").style.display = "none"; // Ocultar el mensaje de error
    });

    // Modal de "Editar Usuario" - para cada usuario
    document
        .querySelectorAll('[id^="modalEditar"]')
        .forEach(function (modalEditar) {
            // Guardar valores originales cuando se abre el modal
            modalEditar.addEventListener("shown.bs.modal", function () {
                var form = modalEditar.querySelector("form");
                form.dataset.originalName = form.name.value;
                form.dataset.originalEmail = form.email.value;
                form.dataset.originalPassword = ""; // Contraseña no debe persistir
            });

            // Restaurar los valores originales cuando se cierra el modal
            modalEditar.addEventListener("hidden.bs.modal", function () {
                var form = modalEditar.querySelector("form");
                form.name.value = form.dataset.originalName;
                form.email.value = form.dataset.originalEmail;
                form.password.value = ""; // Mantener el campo vacío
            });
        });

    // Validación de correo electrónico al agregar usuario
    const emailAgregarInput = document.getElementById("email");
    if (emailAgregarInput) {
        emailAgregarInput.addEventListener("input", function () {
            if (!validateEmail(emailAgregarInput.value)) {
                emailAgregarInput.setCustomValidity(
                    "Por favor, ingrese un correo válido."
                );
            } else {
                emailAgregarInput.setCustomValidity("");
            }
        });
    }

    // Validación de correo electrónico al editar usuario
    document
        .querySelectorAll('[id^="modalEditar"] input[name="email"]')
        .forEach(function (emailEditarInput) {
            emailEditarInput.addEventListener("input", function () {
                if (!validateEmail(emailEditarInput.value)) {
                    emailEditarInput.setCustomValidity(
                        "Por favor, ingrese un correo válido."
                    );
                } else {
                    emailEditarInput.setCustomValidity("");
                }
            });
        });

    // Función de validación del formato del correo
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Validación de contraseñas coincidentes en el formulario de agregar usuario
    window.validatePasswords = function () {
        const password = document.getElementById("password").value;
        const passwordConfirmation = document.getElementById("password_confirmation").value;
        const passwordError = document.getElementById("passwordError");

        // Limpiar mensaje de error previo
        passwordError.style.display = "none";

        // Validar que las contraseñas tengan al menos 8 caracteres
        if (password.length < 8) {
            alert("La contraseña debe tener un mínimo de 8 caracteres.");
            return false; // Detener el envío del formulario
        }

        // Validar que las contraseñas coincidan
        if (password !== passwordConfirmation) {
            passwordError.style.display = "block"; // Mostrar el mensaje de error
            return false; // Detener el envío del formulario
        }

        return true; // Todo es válido, el formulario se enviará
    };

    // Manejo del evento submit para el formulario de agregar usuario
    document
        .getElementById("userForm")
        .addEventListener("submit", function (event) {
            if (!validatePasswords()) {
                event.preventDefault(); // Detener el envío del formulario si las contraseñas no son válidas
            }
        });

    // Código para gestionar las alertas de éxito o error
    var successAlert = document.querySelector(".alert-success");
    var errorAlert = document.querySelector(".alert-danger");

    // Duración de la alerta en milisegundos (por ejemplo, 5000 ms = 5 segundos)
    var alertDuration = 10000;

    if (successAlert) {
        setTimeout(function () {
            successAlert.classList.add("fade");
            successAlert.classList.remove("show");
        }, alertDuration);
    }

    if (errorAlert) {
        setTimeout(function () {
            errorAlert.classList.add("fade");
            errorAlert.classList.remove("show");
        }, alertDuration);
    }
});

