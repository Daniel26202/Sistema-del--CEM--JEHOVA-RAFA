// document.addEventListener('DOMContentLoaded', function () {
//     // formulario de agregar h
//     const formRecuperarC = document.getElementById('formRecPassword');

//     const expresiones = {
//         usuario: /^[a-zA-Z0-9._-]{3,16}$/,
//         preguntaDeSeguridad: /^([A-Za-z0-9\s\.,#-]+)$/,
//         respuestaDeSeguridad: /^([A-Za-z0-9\s\.,#-]+)$/,
//         password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/
//     }

//     const campos = {
//         usuario: false,
//         preguntaDeSeguridad: false,
//         respuestaDeSeguridad: false,
//         password: false
//     }
//     // formulario de agregar
//     function validarFormulario(e) {
//         // selecciono el name del input
//         switch (e.target.name) {

//             case "usuario":
//                 // instancia la función con la expresión regular con el nodo(el input) y el name 
//                 validarCampos(expresiones.usuario, e.target, 'usuario');
//                 break;
//             case "ps":
//                 // instancia la función con la expresión regular con el nodo(el input) y el name 
//                 validarCampos(expresiones.preguntaDeSeguridad, e.target, 'preguntaDeSeguridad');
//                 break;
//             case "rs":
//                 // instancia la función con la expresión regular con el nodo(el input) y el name 
//                 validarCampos(expresiones.respuestaDeSeguridad, e.target, 'respuestaDeSeguridad');
//                 break;
//             case "password":
//                 // instancia la función con la expresión regular con el nodo(el input) y el name 
//                 validarCampos(expresiones.password, e.target, 'password');
//                 break;

//         }
//     }

//     // campos de agregar
//     const validarCampos = (expresiones, input, campo) => {

//         // el método .test devuelve true si la expresión regular concuerda con el contenido del input
//         if (expresiones.test(input.value)) {
//             // previousElementSibling es para seleccionar el elemento anterior(su hermano)
//             let icono = input.previousElementSibling;
//             if (icono.tagName === "IMG") {
//                 // le cambia la tonalidad(color) a la img
//                 icono.classList.remove('imgError');
//                 icono.classList.add('imgCorrecto');
//             } else {
//                 // cambia el color del icono
//                 icono.classList.remove('iconoError');
//                 icono.classList.add('iconoCorrecto');
//             }

//             input.classList.remove('inputError');
//             input.classList.add('inputCorrecto');
//             campos[campo] = true;

//             if (campo === "password") {
//                 document.querySelector("#leyendaC").classList.add("d-none");
//             }

//         } else {
//             // previousElementSibling es para seleccionar el elemento anterior(su hermano)
//             let icono = input.previousElementSibling;
//             if (icono.tagName === "IMG") {
//                 // le cambia la tonalidad(color) a la img
//                 icono.classList.add('imgError');
//                 icono.classList.remove('imgCorrecto');
//             } else {
//                 // cambia el color del icono
//                 icono.classList.add('iconoError');
//                 icono.classList.remove('iconoCorrecto');
//             }

//             input.classList.add('inputError');
//             input.classList.remove('inputCorrecto');
//             campos[campo] = false;

//             if (campo === "password") {
//                 document.querySelector("#leyendaC").classList.remove("d-none");
//             }

//         }
//     }
//     // formulario de agregar
//     formRecuperarC.addEventListener('submit', (e) => {
//         e.preventDefault();
//         if (campos.usuario && campos.preguntaDeSeguridad && campos.respuestaDeSeguridad && campos.password) {

//             document.querySelector(".msjE").classList.add("d-none");
//             formRecuperarC.submit();

//         } else {
//             e.preventDefault();
//             document.querySelector(".msjE").classList.remove("d-none");
//         }
//     });


//     document.querySelector("#inputUno").addEventListener('keyup', validarFormulario);
//     document.querySelector("#inputUno").addEventListener('input', validarFormulario);

//     document.querySelector("#inputDos").addEventListener('keyup', validarFormulario);
//     document.querySelector("#inputDos").addEventListener('input', validarFormulario);

//     document.querySelector("#inputTres").addEventListener('keyup', validarFormulario);
//     document.querySelector("#inputTres").addEventListener('input', validarFormulario);

//     document.querySelector("#inputCuatro").addEventListener('keyup', validarFormulario);
//     document.querySelector("#inputCuatro").addEventListener('input', validarFormulario);



// });

