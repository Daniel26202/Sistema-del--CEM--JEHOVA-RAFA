import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Doctores";

const form = document.getElementById("modalAgregarDoctores");
const inputs = document.querySelectorAll("#modalAgregarDoctores .inputA");

const urlActual = window.location.href;

const expresiones = {
  cedula: /^([1-9]{1})([0-9]{5,7})$/,
  nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
  apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
  telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
  email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
  usuario: /^[a-zA-Z0-9._-]{3,16}$/,
  password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/,
};
const campos = {
  cedula: false,
  nombre: false,
  apellido: false,
  telefono: false,
  usuario: false,
  password: false,
  dia: false,
  horas: false,
};
let mens = document.querySelector("#leyendaHoraA");
let horaEntrada;
let horaSalida;
function validarFormulario(e) {
  console.log(e.target.name);

  switch (e.target.name) {
    case "cedula":
      validarCampos(expresiones.cedula, e.target, "cedula");
      break;

    case "nombre":
      validarCampos(expresiones.nombre, e.target, "nombre");

      break;
    case "apellido":
      validarCampos(expresiones.apellido, e.target, "apellido");

      break;

    case "telefono":
      validarCampos(expresiones.telefono, e.target, "telefono");

      break;
    case "email":
      validarCampos(expresiones.email, e.target, "email");

      break;
    case "usuario":
      validarCampos(expresiones.usuario, e.target, "usuario");
      break;
    case "password":
      validarCampos(expresiones.password, e.target, "password");
      break;

    case "dias[]":
      // recolecto los inputs
      let inputCheD = document.querySelectorAll(`.diasInA`);

      // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
      let seleccionadoD = Array.from(inputCheD).some((checkbox) => checkbox.checked);
      if (seleccionadoD) {
        campos["dia"] = true;
      } else {
        campos["dia"] = false;
      }

      break;
    case "horaEntrada[]":
      horaEntrada = e.target.value;
      console.log(e.target.value);

      break;
    case "horaSalida[]":
      horaSalida = e.target.value;
      // console.log(horaSalida);

      break;
  }

  // si deselecciona un dia
  if (horaEntrada === undefined && horaSalida === undefined) {
    mens.classList.add("d-none");
    campos.horas = true;
  } else {
    if (e.target.name === "horaEntrada[]") {
      // map(Number) es para transformar el string en numero, cuando le pertenece a un array
      let [hora, minutos] = horaEntrada.split(":").map(Number);
      hora = hora + 1;
      if (hora >= 24) hora = 0;
      // padStart : se asegura que la cadena tenga al menos 2 caracteres, si no los tiene agrega un 0 ejemplo : 9 a 09
      horaEntrada = `${hora.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}`;
    }

    if (horaEntrada < horaSalida) {
      mens.classList.add("d-none");
      campos.horas = true;
    } else {
      campos.horas = false;
      mens.classList.remove("d-none");
    }
  }
}

const validarCampos = (expresiones, input, campo) => {
  if (expresiones.test(input.value)) {
    input.parentElement.classList.remove("grpFormInCorrect");
    input.parentElement.classList.add("grpFormCorrect");
    campos[campo] = true;
  } else {
    input.parentElement.classList.remove("grpFormCorrect");
    input.parentElement.classList.add("grpFormInCorrect");
    campos[campo] = false;
  }
};

// function ajax
const listDateFragment = (data) => {
  let html = "";

  data.forEach((element) => {
    html += `<div class="d-flex w-50 justify-content-between mb-3">






                                                    <div class="form-check form-switch d-flex align-items-center">
                                                        <div>
                                                            <input class="form-check-input diaslaborables diasIn input" type="checkbox"
                                                                role="switch" id="flexSwitchCheckDefault" name="dias[]"
                                                                value="${element.id_horario}">
                                                        </div>
                                                        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                ${element.diaslaborables}
                                                            </label></div>

                                                    </div>
                                                    <div style="width: 60%;">


                                                        <div>
                                                            <input type="time"
                                                                class="input-dias hora-entrada inputHorario d-none form-control input-modal input-disabled input inputA"
                                                                title="Hora De Entrada ${element.diaslaborables}" name="horaEntradaNoChecked[]">
                                                            <input type="time"
                                                                class="input-dias hora-salida inputHorario mt-2 d-none form-control input-modal input-disabled input inputA"
                                                                title="Hora De Salida ${element.diaslaborables}>" name="horaSalidaNoChecked[]">
                                                        </div>

                                                    </div>

                                                </div>`;
  });

  return html;
};

//read
const readDoctor = async () => {
  try {
    let metodo = "";

    if (!urlActual.includes("papelera")) metodo = "DoctoresAjax";
    else metodo = "papeleraDoctoresAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    // construir html de filas
    let html = "";
    let html2 = "";

    let id_usuario = 0;
    console.log(result);

    if (!urlActual.includes("papelera")) {
      result[0].forEach((element) => {
        html += ` <tr>
                            <td class=" text-center">
                                ${element.nacionalidad}-${element.cedula}
                            </td>
                            <td class="text-center">
                                ${element.nombre_d}
                            </td>
                            <td class="text-center">
                                ${element.apellido}
                            </td>
                            <td class="text-center">
                                ${element.telefono}
                            </td>
                            <td class="text-center" colspan="2">
                                ${element.correo}
                            </td>
                            <td class="text-center">
                                ${element.nombre}
                            </td>


                            <td class="text-center">
                                <!-- editar -->

                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi btn-dt-tabla"
                                        uk-toggle="target: #modal-editar-doctores${
                                          element.id_usuario
                                        }" data-id-tabla="modal-editar-doctoresmodal-editar-doctores${element.id_usuario}"
                                        id="btneditarDoctor" data-index="${element.id_personal}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer ${
                                      !urlActual.includes("paplera") ? "d-none" : ""
                                    }" data-index=${element.id_usuario}>


                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>


                                    </button>

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar ${
                                      urlActual.includes("papelera") ? "d-none" : ""
                                    }" data-index=${element.id_usuario}>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>

                                    </button>

                             
                                <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla" title="Horarios Del Doctor"
                                    uk-toggle="target: #modal-info-doctores" data-id-tabla="modal-info-doctores${
                                      element.id_usuario
                                    }"
                                    data-index="${element.id_usuario}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
                            </td>
                            
                            <td>

                            <!-- modal editar sddsf-->
                            <div id="modal-editar-doctores${element.id_usuario}" uk-modal class="">
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <!-- Boton que cierra el modal -->
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </a>

            <div class="d-flex align-items-center mb-3">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                    </svg>
                </div>
                <div class="">
                    <p class="uk-modal-title fs-5 ">
                        Editar Doctor
                    </p>
                </div>

            </div>
            <div class="alert alert-danger d-none alertaFormulario" role="alert">
                <div class="">
                    <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
                </div>
            </div>


            <form class="me-2 ms-2 formulario_editar">

                <div class="col w-auto mt-2 mb-4 pb-1">
                    <div class="d-flex flex-column w-auto ">


                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                </svg>
                            </span>
                            <span class="">
                                <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                                    <option value="V" selected>V</option>
                                    <option value="E">E</option>
                                </select>
                            </span>
                            <input type="number" name="cedula" id="inputUno" class="form-control input-modal input-disabled inputA" placeholder="Cédula" value="${
                              element.cedula
                            }">

                        </div>
                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="nombre" id="inputDos" class="form-control input-modal input-disabled input inputA mayuscula" placeholder="Nombre" value="${
                              element.nombre_d
                            }">

                        </div>
                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="apellido" id="inputTres" class="form-control input-modal input-disabled input inputA mayuscula" placeholder="Apellido"
                                value="${element.apellido}">

                        </div>
                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-cuatro" class="icono-telefono" width="20"
                                height="20" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>

                            <input type="text" name="telefono" id="inputCuatro" class="form-control input-modal input-disabled input inputA mayuscula" placeholder="Teléfono"
                                value="${element.telefono}">

                        </div>
                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="" width="19" height="19" fill="currentColor"
                                class="bi bi-envelope-at-fill icono" viewBox="0 0 16 16">
                                <path
                                    d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z" />
                                <path
                                    d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z" />
                            </svg>

                            <input type="email" name="email" class="form-control input-modal input-disabled input inputA mayuscula" placeholder="E_mail"
                                value="${element.correo}">

                        </div>

                        <!-- Nueva Especialidad -->

                        <div class="input-group flex-nowrap margin-inputs grpFormCorrect caja_select_especialidad">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-cinco" class="icono" width="20" height="20"
                                fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                                <path
                                    d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                            </svg>


                            <select name="selectEspecialidad" class="form-control input-modal input-disabled input inputA selectEspecialidad " placeholder="Especialidad">
                                <option selected value="${element.id_especialidad}">
                                     ${element.nombre}
                                </option>

                                <?php foreach ($datosEspecialidades as $e): ?>
                                    <option value="${element.id_especialidad}">
                                        ${element.nombre}
                                    </option>
                                <?php endforeach ?>

                            </select>

                        </div>




                        <!-- caja de los dias -->

                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true">
                                <li>
                                    <a class="uk-accordion-title text-decoration-none" href="#">

                                        <h6 class="acordion-paciente fw-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                            </svg>
                                            Modificar El Horario Al Doctor
                                        </h6>
                                    </a>

                                    <div class="uk-accordion-content">
                                    
                                        <div class="d-flex justify-content-between flex-wrap" >
                                            <?php foreach ($datosDias as $dia): ?>

                                                
                                            <?php endforeach ?>

                                            ${listDateFragment(result[1])}


                                        </div>
                                    </div>
                                </li>
                            </ul>



                        </div>
                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none leyendaDiaE" id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                </path>
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                </path>
                            </svg>
                            <i class="text-danger">Debe seleccionar al menos un dia laborable</i>
                        </div>
                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none msj" id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                </path>
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                </path>
                            </svg>
                            <i class="text-danger">El formato de la hora es incorrecto. La hora de salida tiene que ser más tarde que la hora de entrada.
                            </i>
                        </div>


                    </div>
                </div>



                <!-- inputs ocultos -->
                <div>
                    <input type="" name="id_usuario" value=" ${element.id_usuario}" hidden>
                    <input type="" name="id_especialidad" value=" ${element.id_especialidad}" hidden>

                    <input type="" name="id_personalyespecialidad" value=""
                        hidden>
                </div>

                <p class="uk-text-right mt-4">
                    <button class="uk-button uk-button-default uk-modal-close  btn-cerrar-modal"
                        type="button">Cancelar</button>
                    <input class="uk-button btn-agregarcita-modal" name="actualizar" type="submit" value="Editar">
                </p>

            </form>

        </div>
    </div>

                            </td>
                        </tr>

        
                        `;
      });
    } else {
      result.forEach((element) => {
        html += ` <tr>
                            <td class=" text-center">
                                ${element.nacionalidad}-${element.cedula}
                            </td>
                            <td class="text-center">
                                ${element.nombre_d}
                            </td>
                            <td class="text-center">
                                ${element.apellido}
                            </td>
                            <td class="text-center">
                                ${element.telefono}
                            </td>
                            <td class="text-center" colspan="2">
                                ${element.correo}
                            </td>
                            <td class="text-center">
                                ${element.nombre}
                            </td>


                            <td class="text-center">
                                <!-- editar -->

                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi btn-dt-tabla ${
                                      !urlActual.includes("paplera") ? "d-none" : ""
                                    }"
                                        uk-toggle="target: #modal-editar-doctores${
                                          element.id_usuario
                                        }" data-id-tabla="modal-editar-doctoresmodal-editar-doctores${element.id_usuario}"
                                        id="btneditarDoctor" data-index="${element.id_personal}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer ${
                                      urlActual.includes("paplera") ? "d-none" : ""
                                    }" data-index=${element.id_usuario}>


                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>


                                    </button>

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar ${
                                      urlActual.includes("papelera") ? "d-none" : ""
                                    }" data-index=${element.id_usuario}>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>

                                    </button>

                             
                                <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla ${
                                  !urlActual.includes("paplera") ? "d-none" : ""
                                }" title="Horarios Del Doctor"
                                    uk-toggle="target: #modal-info-doctores" data-id-tabla="modal-info-doctores${
                                      element.id_usuario
                                    }"
                                    data-index="${element.id_usuario}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
                            </td>
                            <td></td>
                            
                        </tr>

        
                        `;
      });
    }

    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    // vuelca el html en el tbody
    document.querySelector(selector + " tbody").innerHTML = html;

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //llamar las funcion de eliminar
    if (document.querySelectorAll(".btn-eliminar")) {
      document.querySelectorAll(".btn-eliminar").forEach((btn) => {
        console.log(btn);
        btn.addEventListener("click", function () {
          const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
          alertConfirm("Esta seguro de eliminar el doctor?", deleteDoctor, data);
        });
      });
    }

    if (document.querySelectorAll(".btnRestablecer")) {
      document.querySelectorAll(".btnRestablecer").forEach((btn) => {
        btn.addEventListener("click", function () {
        console.log(btn);

          const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
          alertConfirm("Esta seguro de restablecer el doctor?", restablecerDoctor, data);
        });
      });
    }

    //llamar las funciones de editar
    document.querySelectorAll(".forms-editar").forEach((formEditar) => {
      formEditar.addEventListener("submit", function (e) {
        e.preventDefault();
        let inputsBuenos = [];

        this.querySelectorAll(".input-validar").forEach((input) => {
          if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
        });

        if (
          inputsBuenos.length == 5 &&
          document.querySelector(".p-error-fn" + formEditar.getAttribute("data-index")).classList.contains("d-none")
        ) {
          updatePatients(this, inputsBuenos);
        } else {
          alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
        }
      });
    });

    //llamar a la uncion de restablecer
    //llamar las funcion de eliminar
    document.querySelectorAll(".btnRestablecer").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        alertConfirm("Esta seguro de restablecer el paciente?", restablecerPattients, data);
      });
    });

    // re-inicializa
    $(selector).DataTable({
      language: {
        language: {
          decimal: ",",
          thousands: ".",
          lengthMenu: "Mostrar por página _MENU_ ",
          zeroRecords: "No se encontraron resultados",
          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros en total)",
          search: "Buscar:",
        },
      },
    });
    console.log("cargada...");
  } catch (error) {
    alertError("Error", error);
    console.log(error);
  }
};

//read
const readEspecialidad = async () => {
  try {
    const result = await executePetition("/Sistema-del--CEM--JEHOVA-RAFA/Doctores/selectEspcAjax", "GET");

    // construir html de filas
    let html = "";

    result.forEach((element, index) => {
      html += ` 
       <tr>
                <td class="text-center fw-bold">
                 ${index + 1}
                </td>

                <td class="text-center border-start">
                  ${element.nombre}
                </td>


                <td class="border-start text-center">
                  <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar-epe" data-index="${element.id_especialidad}" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                  </button>

                  
  

                </td>
              </tr>
      
        
                        `;
    });

    const selector = ".exampleTable2";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    // vuelca el html en el tbody
    if (!urlActual.includes("papelera")) {
      document.querySelector(selector + " tbody").innerHTML = html;
    }

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar-epe").forEach((btn) => {
      console.log(btn);
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        alertConfirm("Esta seguro de eliminar la especialidad?", deleteEspecialidad, data);
      });
    });

    // re-inicializa
    $(selector).DataTable({
      language: {
        language: {
          decimal: ",",
          thousands: ".",
          lengthMenu: "Mostrar por página _MENU_ ",
          zeroRecords: "No se encontraron resultados",
          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros en total)",
          search: "Buscar:",
        },
      },
    });
    console.log("cargada...");
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createDoctor = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/agregarDoctor", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-agregar-doctores").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteDoctor = async (data) => {
  try {
    const result = await executePetition(url + `/borrarDoctor/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteEspecialidad = async (data) => {
  try {
    const result = await executePetition(`/Sistema-del--CEM--JEHOVA-RAFA/Doctores/eliminarEspecialidad/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};


//restablecer
const restablecerDoctor = async (data) => {
  try {
    const result = await executePetition(url + `/restablecer/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message)

      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error",error)
  }
};
readDoctor();

readEspecialidad();

inputs.forEach((input) => {
  input.addEventListener("input", validarFormulario);
});

form.addEventListener("submit", (e) => {
  e.preventDefault();
  if (
    campos.cedula &&
    campos.nombre &&
    campos.horas &&
    campos.dia &&
    campos.apellido &&
    campos.telefono &&
    campos.usuario &&
    campos.password &&
    campos.email
  ) {
    console.log("Se envio");
    createDoctor(form, inputs);
  } else {
    alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
  }
});
