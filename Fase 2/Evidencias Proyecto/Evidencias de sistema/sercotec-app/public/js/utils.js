var Fn = {
    // Valida el rut con su cadena completa "XXXXXXXX-X"
    validaRut : function (rutCompleto) {
    rutCompleto = rutCompleto.replace("‐","-");
    if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
    return false;
    var tmp = rutCompleto.split('-');
    var digv= tmp[1]; 
    var rut = tmp[0];
    if ( digv == 'K' ) digv = 'k' ;
    
    return (Fn.dv(rut) == digv );
    },
    dv : function(T){
    var M=0,S=1;
    for(;T;T=Math.floor(T/10))
    S=(S+T%10*(9-M++%6))%11;
    return S?S-1:'k';
    }
    }


document.addEventListener("DOMContentLoaded", function () {
    const inputsRut = document.querySelectorAll(".rut-vali");
    const inputsPhone = document.querySelectorAll(".phone-vali");
    const forms = document.querySelectorAll(".formcru");

    function validarRut(rut) {
        return Fn.validaRut(rut);
    }

    function validarTelefono(telefono) {
        // Modificada para exigir exactamente 12 caracteres (incluido el +56)
        const telefonoRegex = /^\+56\d{9}$/;
        return telefonoRegex.test(telefono) && telefono.length === 12;
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
        // Guardar el valor sin espacio y asegurar que tenga 9 dígitos después del +56
        input.value = "+56" + telefono.slice(2);

        // Validar la longitud después de formatear
        if (input.value.length < 12) {
            input.classList.remove("valid");
            input.classList.add("invalid");
        }
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
                    text: "Por favor, verifica que el RUT y el teléfono estén correctamente ingresados",
                    color: "#ffffff",
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

    if (window.messages) {
        window.messages.forEach(function (message) {
            Toast.fire({
                icon: "warning",
                title: message,
            });
        });
    }
});

//crear tablas
// Función para crear grid
const createDataGrid = (gridDiv, data, columnDefs) => {
    const gridOptions = {
        columnDefs,
        // Inicializamos con array vacío si no hay datos
        rowData: data || [],
        pagination: true,
        paginationPageSizeSelector: [5, 10, 20, 50, 100],
        paginationPageSize: 5,
        domLayout: "autoHeight",
        onFirstDataRendered: (params) => {
            params.api.sizeColumnsToFit();
        },
        // Mensaje cuando no hay datos
        noRowsOverlayComponent: "agNoRowsOverlay",
        noRowsOverlayComponentParams: {
            message: "No hay datos disponibles",
        },
    };
    return agGrid.createGrid(gridDiv, gridOptions);
};

//Buscar Datos

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
