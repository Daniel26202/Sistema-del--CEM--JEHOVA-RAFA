document.addEventListener('DOMContentLoaded', function () {
    // formulario de agregar h
    const formAgregar = document.getElementById('formularioAgregarH');
    // formulario de agregar h
    const formEditar = document.getElementById('formularioEditarH');


    const expresiones = {
        cedula: /^([1-9]{1})([0-9]{5,7})$/,
        // ?!asegura que la cadena no acepte algo y el + es mas igual al mismo, $ esto es asta el final
        horas: /^(?!0+$)(?!-)\d+$/
    }

    const campos = {
        cedula: false,
        horas: false,
    }
    // formulario de agregar
    function validarFormulario(e) {
        // selecciono el name del input
        switch (e.target.name) {

            case "cedula":
                // instancia la función con la expresión regular con el nodo(el input) y el name 
                validarCampos(expresiones.cedula, e.target, 'cedula');
                break;
            case "horas":
                // instancia la función con la expresión regular con el nodo(el input) y el name 
                validarCampos(expresiones.horas, e.target, 'horas');
                break;

        }
    }

    // campos de agregar
    const validarCampos = (expresiones, input, campo) => {
        // el método .test devuelve true si la expresión regular concuerda con el contenido del input
        if (expresiones.test(input.value)) {
            campos[campo] = true;
            if (campo == "cedula") {
                // coloco el color verde
                document.querySelector(`.divGrp_${campo}`).classList.remove('grpFormInCorrect');
                document.querySelector(`.divGrp_${campo}`).classList.add('grpFormCorrect');
                // muestro el btn de enviar y oculto el de no enviar
                document.getElementById('btn-buscar').classList.remove('d-none');
                document.getElementById('no-buscar').classList.add('d-none');
            }
        } else {
            campos[campo] = false;
            if (campo == "cedula") {
                // coloco el color rojo 
                document.querySelector(`.divGrp_${campo}`).classList.remove('grpFormCorrect');
                document.querySelector(`.divGrp_${campo}`).classList.add('grpFormInCorrect');
                // muestro el btn de no enviar y oculto el otro
                document.getElementById('btn-buscar').classList.add('d-none');
                document.getElementById('no-buscar').classList.remove('d-none');
            }


        }
    }
    // formulario de agregar
    formAgregar.addEventListener('submit', (e) => {
        e.preventDefault();
        if (campos.cedula && campos.horas) {

            formAgregar.submit();

        } else {
            e.preventDefault();
        }
    });


    const iCedula = document.querySelector('#bt');

    iCedula.addEventListener('keyup', validarFormulario)
    iCedula.addEventListener('input', validarFormulario)
    document.querySelector("#duracionA").addEventListener('keyup', validarFormulario)
    document.querySelector("#duracionA").addEventListener('input', validarFormulario)



});

