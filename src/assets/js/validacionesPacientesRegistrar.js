document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('modalAgregar');
    const inputs = document.querySelectorAll('#modalAgregar input');


    const expresiones = {
        cedula: /^([1-9]{1})([0-9]{5,7})$/,
        nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
        direccion: /^([A-Za-z0-9\s\.,#-]+)$/,
        fn: /^\d{4}\-\d{2}\-\d{2}$/
    }

    const campos = {
        cedula: false,
        nombre: false,
        apellido: false,
        telefono: false,
        direccion: false,
        fn: false
    }

    function validarFormulario(e) {

        switch (e.target.name) {

            case "cedula":
                validarCampos(expresiones.cedula, e.target, 'cedula');
                break;

            case "nombre":
                validarCampos(expresiones.nombre, e.target, 'nombre');

                break;
            case "apellido":
                validarCampos(expresiones.apellido, e.target, 'apellido');

                break;


            case "telefono":
                validarCampos(expresiones.telefono, e.target, 'telefono');

                break;
            case "direccion":
                validarCampos(expresiones.direccion, e.target, 'direccion');
                break;
            case "fn":
                validarCampos(expresiones.fn, e.target, 'fn');
                break;


        }
    }

    const validarCampos = (expresiones, input, campo) => {
        if (expresiones.test(input.value)) {
            document.getElementById(`grp_${campo}`).classList.remove('grpFormInCorrect');
            document.getElementById(`grp_${campo}`).classList.add('grpFormCorrect');
            campos[campo] = true;


        } else {
            document.getElementById(`grp_${campo}`).classList.remove('grpFormCorrect');
            document.getElementById(`grp_${campo}`).classList.add('grpFormInCorrect');
            campos[campo] = false;

        }

    }



    inputs.forEach((input) => {
        input.addEventListener('keyup', validarFormulario)
    });


    let alerta = document.getElementById('alerta');

    const fechaDeHoy = new Date();

    const año = fechaDeHoy.getFullYear();
    const mes = String(fechaDeHoy.getMonth() + 1).padStart(2, '0');
    const dia = String(fechaDeHoy.getDate()).padStart(2, '0');


    const fechaActual = `${año}-${mes}-${dia}`;
    console.log(fechaActual);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (campos.cedula && campos.nombre && campos.apellido && campos.telefono && campos.direccion && campos.fn) {

            form.submit();

        } else {
            e.preventDefault();
            alerta.classList.remove('d-none');
            setTimeout(function () {
                alerta.classList.add('d-none');
            }, 10000);

        }
    });


    //Funcion para eliminar los mensajes, ya sea de registrar, eliminar o modificar

    if (document.getElementById('alerta-registrar')) {

        setTimeout(function () {
            document.getElementById('alerta-registrar').remove();
        }, 10000);

    }


    if (document.getElementById('alerta-eliminar')) {

        setTimeout(function () {
            document.getElementById('alerta-eliminar').remove();
        }, 10000);

    }

    if (document.getElementById('alerta-editar')) {

        setTimeout(function () {
            document.getElementById('alerta-editar').remove();
        }, 10000);


    }








});

