document.addEventListener("DOMContentLoaded", function () {
    const inputsRut = document.querySelectorAll(".rut-vali");
    const inputsPhone = document.querySelectorAll(".phone-vali");
    const forms = document.querySelectorAll(".formcru");

    function validarRut(rut) {
        const rutRegex = /^[0-9]{7,8}-[0-9Kk]{1}$/;
        return rutRegex.test(rut);
    }

    function validarTelefono(telefono) {
        const telefonoRegex = /^\+56\d{9}$/; // Valida +56 seguido de 9 dígitos (sin espacio)
        return telefonoRegex.test(telefono);
    }

    function validarInputRut(input) {
        const rut = input.value.trim();
        if (validarRut(rut)) {
            input.classList.remove("invalid");
            input.classList.add("valid");
        } else {
            input.classList.remove("valid");
            input.classList.add("invalid");
        }
    }

    function validarInputTelefono(input) {
        const telefono = input.value.trim();
        if (validarTelefono(telefono)) {
            input.classList.remove("invalid");
            input.classList.add("valid");
        } else {
            input.classList.remove("valid");
            input.classList.add("invalid");
        }
    }

    function limitarLongitudTelefono(input) {
        let telefono = input.value.replace(/\D/g, "");
        if (telefono.length > 11) {
            telefono = telefono.slice(0, 11);
        }
        return telefono;
    }

    function formatearTelefono(input) {
        let telefono = input.value.replace(/\D/g, ""); // Remover todo lo que no sea dígito
        if (!telefono.startsWith("56")) {
            telefono = "56" + telefono;
        }
        // Guardar el valor sin espacio
        input.value = "+56" + telefono.slice(2); // Asignar valor formateado sin espacio
    }

    inputsPhone.forEach(function (input) {
        input.addEventListener("input", function () {
            input.value = limitarLongitudTelefono(input);
            formatearTelefono(input);
            validarInputTelefono(input);
        });
    });

    function limitarLongitud(input) {
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }

    function formatearRut(input) {
        let rut = input.value.replace(/[^0-9Kk]/g, "");
        if (rut.length > 1) {
            rut = rut.slice(0, -1) + "-" + rut.slice(-1);
        }
        input.value = rut;
    }

    inputsRut.forEach(function (input) {
        input.addEventListener("input", function () {
            limitarLongitud(input);
            formatearRut(input);
            validarInputRut(input);
        });
    });

    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            let formIsValid = true;
    
            const inputsRutInForm = form.querySelectorAll(".rut-vali");
            const inputsPhoneInForm = form.querySelectorAll(".phone-vali");
    
            // Validar RUTs dentro del formulario específico
            inputsRutInForm.forEach(function (input) {
                validarInputRut(input);
                if (input.classList.contains("invalid")) {
                    formIsValid = false;
                }
            });
    
            // Validar teléfonos dentro del formulario específico
            inputsPhoneInForm.forEach(function (input) {
                validarInputTelefono(input);
                if (input.classList.contains("invalid")) {
                    formIsValid = false;
                }
            });
    
            // Mostrar alerta si el formulario no es válido
            if (!formIsValid) {
                event.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo anda mal!",
                });
            }
        });
    });
});


// alerta
window.addEventListener("load", function () {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });

    if (window.success) {
        Toast.fire({
            icon: "success",
            title: window.success,
        });
    }

    if (window.error) {
        Toast.fire({
            icon: "error",
            title: window.error,
        });
    }
});