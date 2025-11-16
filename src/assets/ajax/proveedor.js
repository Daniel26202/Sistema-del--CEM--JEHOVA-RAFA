import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Proveedores";

const modalAgregarProveedor = document.getElementById("modalAgregarProveedor");
const inputs = document.querySelectorAll("#modalAgregarProveedor input");

const urlBase = document.getElementById("urlBase").value;

const expresionesProveedor = {
  nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
  telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
  rif: /^[VJEGP]\-[0-9]{8,9}$/,
  email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
  direccion: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
};

const camposProveedor = {
  nombre: false,
  telefono: false,
  rif: false,
  email: false,
  direccion: false,
};

const camposProveedorEdi = {
  nombre: true,
  telefono: true,
  rif: true,
  email: true,
  direccion: true,
};

const validarCamposProveedor = (expresiones, input, campo, camposProveedor, id = "") => {
  const pError = document.querySelector(`.p-error-${campo}${id}`);
  console.log(pError);
  if (expresiones.test(input.value)) {
    input.parentElement.classList.remove("grpFormInCorrect");
    input.parentElement.classList.add("grpFormCorrect");
    pError.classList.add("d-none");
    camposProveedor[campo] = true;
  } else {
    input.parentElement.classList.remove("grpFormCorrect");
    input.parentElement.classList.add("grpFormInCorrect");
    pError.classList.remove("d-none");
    camposProveedor[campo] = false;
  }
};

function validarFormularioProveedor(e) {
  switch (e.target.name) {
    case "nombre":
      validarCamposProveedor(expresionesProveedor.nombre, e.target, "nombre", camposProveedor);

      break;
    case "telefono":
      validarCamposProveedor(expresionesProveedor.telefono, e.target, "telefono", camposProveedor);

      break;
    case "rif":
      validarCamposProveedor(expresionesProveedor.rif, e.target, "rif", camposProveedor);
      break;

    case "email":
      validarCamposProveedor(expresionesProveedor.email, e.target, "email", camposProveedor);
      break;

    case "direccion":
      validarCamposProveedor(expresionesProveedor.direccion, e.target, "direccion", camposProveedor);
      break;
  }
}

function validarFormularioProveedorEdi(e, id) {
  switch (e.target.name) {
    case "nombre":
      validarCamposProveedor(expresionesProveedor.nombre, e.target, "nombre", camposProveedorEdi, id);

      break;
    case "telefono":
      validarCamposProveedor(expresionesProveedor.telefono, e.target, "telefono", camposProveedorEdi, id);

      break;
    case "rif":
      validarCamposProveedor(expresionesProveedor.rif, e.target, "rif", camposProveedorEdi, id);
      break;

    case "email":
      validarCamposProveedor(expresionesProveedor.email, e.target, "email", camposProveedorEdi, id);
      break;

    case "direccion":
      validarCamposProveedor(expresionesProveedor.direccion, e.target, "direccion", camposProveedorEdi, id);
      break;
  }
}

inputs.forEach((i) => {
  i.addEventListener("input", validarFormularioProveedor);
});

if (modalAgregarProveedor) {
  modalAgregarProveedor.addEventListener("submit", function (f) {
    f.preventDefault();
    if (
      camposProveedor.nombre &&
      camposProveedor.rif &&
      camposProveedor.telefono &&
      camposProveedor.email &&
      camposProveedor.direccion
    ) {
      createProveedor(modalAgregarProveedor, inputs);
    } else {
      alertError("Error", "Por favor verifique que todos los datos esten correctos.");
    }
  });
}

//read

const readProveedores = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) metodo = "proveedoresAjax";
    else metodo = "proveedoresPapeleraAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `<tr>

                            <td class="border-start text-center border-start-0">
                                ${element.nombre}
                            </td>
                            <td class="border-start text-center">
                                ${element.rif}
                            </td>
                            <td class="border-start text-center">
                                 ${element.telefono}
                            </td>
                            <td class="border-start text-center">
                                 ${element.email}
                            </td>
                            <td class="border-start text-center">
                                 ${element.direccion}
                            </td>
                            <td class="border-start d-flex justify-content-center">

                                <!-- Editar Proveedor -->
                                <div class="me-2">
                                    <a href="#" class="${
                                      !urlActual.includes("papelera") ? "" : "d-none"
                                    } btn-editar btn btn-tabla mb-1 btnEditarDoctor btn-dt-tabla" uk-toggle="target: #modal-exampleEditarProveedores${
        element.id_proveedor
      }" uk-tooltip="Modificar Proveedores" data-id-tabla="modal-exampleEditarProveedores${element.id_proveedor}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>
                                </div>


                                <!-- Eliminar Proveedores-->

                                <div class="me-2">
                                    <a href="#" class="${
                                      !urlActual.includes("papelera") ? "" : "d-none"
                                    } btn btn-tabla mb-1 btnEliminarDoctor btn-dt-tabla btn-eliminar" data-index="${
        element.id_proveedor
      }">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </a>
                                </div>

                                
                                    <div class="me-2">
                    <a href="#" class=" btn btn-tabla btn-dt-tabla btnRestablecer ${
                      urlActual.includes("papelera") ? "" : "d-none"
                    }" data-index="${
        element.id_proveedor
      }" title="Restablecer Entrada" uk-tooltip=""  aria-describedby="uk-tooltip-27">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                      </svg>
                    </a>
                  </div>







                                <!--MODAL EDITAR-->

                                <div id="modal-exampleEditarProveedores${element.id_proveedor}" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                        <!-- Boton que cierra el modal -->
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </a>

                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="${urlBase}../src/assets/img/proveedor(2).png" width="25" height="25" uk-svg class="me-2 mb-3">
                                            </div>
                                            <div class="">
                                                <p class="uk-modal-title fs-5">
                                                    Editar Proveedor
                                                </p>
                                            </div>

                                        </div>



                                        <form class="form-modal form-ajax" id="modalAgregar" method="POST">

                                            <input type="hidden" name="id_usuario_bitacora">

                                            <input type="hidden" name="rifRegistrado" value="${element.rif}">

                                            <div class="input-group flex-nowrap d-none">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-person-vcard-fill azul"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="hidden"
                                                    name="id_proveedor" value="${element.id_proveedor}"
                                                    placeholder="Id">
                                            </div>

                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="nombre"
                                                    value="${element.nombre}" data-index='${
        element.id_proveedor
      }' placeholder="Nombre">
                                            </div>

                                            <p class="p-error-nombre${
                                              element.id_proveedor
                                            } p-error-validaciones  d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>


                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-credit-card-2-front-fill azul"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="rif"
                                                    value="${element.rif}" data-index='${element.id_proveedor}' placeholder="Rif">
                                            </div>

                                            <p class="p-error-rif${
                                              element.id_proveedor
                                            } p-error-validaciones  d-none">El rif no es correcto</p>


                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="telefono"
                                                    value="${element.telefono}" data-index='${
        element.id_proveedor
      }' placeholder="Telefono">
                                            </div>

                                            <p class="p-error-telefono${
                                              element.id_proveedor
                                            } p-error-validaciones  d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>




                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                        class="bi bi-credit-card-2-front-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="email" placeholder="Email" data-index='${
                                                  element.id_proveedor
                                                }' value="${element.email}" required>
                                            </div>
                                            <p class="p-error-email${
                                              element.id_proveedor
                                            } p-error-validaciones d-none">El correo debe contener letras , numeros y/o caracteres especiales y que contenga el @</p>



                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                        class="bi bi-credit-card-2-front-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="direccion" placeholder="Direccion" data-index='${
                                                  element.id_proveedor
                                                }' value="${element.direccion}" required>
                                            </div>

                                            <p class="p-error-direccion${
                                              element.id_proveedor
                                            } p-error-validaciones  d-none">Debe estar completa y detallada</p>








                                            <div class="mt-3 uk-text-right">
                                                <button
                                                    class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                                    type="button">Cancelar</button>
                                                <button type="submit" class="btn col-3 btn-agregarcita-modal"
                                                    name="editar">Editar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>








                            </td>








                            </td>
                        </tr>`;
    });

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
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        alertConfirm("Esta seguro de eliminar el proveedor?", daleteProveedor, data);
      });
    });

    //llamar las funciones de editar
    document.querySelectorAll(".btn-editar").forEach((ele) => {
      ele.addEventListener("click", function () {
        let idModalEditar = this.getAttribute("uk-toggle").split(" ")[1].substring(1);
        let inputsEdi = document.querySelectorAll(`#${idModalEditar} .uk-modal-dialog .input-group`);
        let modalEdi = document.querySelector(`#${idModalEditar} .uk-modal-dialog .form-modal`);

        console.log(modalEdi);

        inputsEdi.forEach((inp) => {
          inp.addEventListener("input", function (e) {
            let id = this.children[1].getAttribute("data-index");
            validarFormularioProveedorEdi(e, id);
          });
        });
        inputsEdi.forEach((inp) => {
          inp.addEventListener("keyup", function (e) {
            let id = this.children[1].getAttribute("data-index");
            validarFormularioProveedorEdi(e, id);
          });
        });
        inputsEdi.forEach((inp) => {
          inp.addEventListener("blur", function (e) {
            let id = this.children[1].getAttribute("data-index");
            validarFormularioProveedorEdi(e, id);
          });
        });

        modalEdi.addEventListener("submit", function (e) {
          e.preventDefault();

          if (
            camposProveedorEdi.nombre &&
            camposProveedorEdi.rif &&
            camposProveedorEdi.telefono &&
            camposProveedorEdi.email &&
            camposProveedorEdi.direccion
          ) {
            updateProveedor(modalEdi,inputsEdi);
          } else {
            alertError("Error", "Por favor verifique que todos los datos esten correctos.");
          }
        });
      });
    });

    //llamar a la uncion de restablecer
    //llamar las funcion de eliminar
    document.querySelectorAll(".btnRestablecer").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        console.log(data)
        alertConfirm("Esta seguro de restablecer el proveedor?", restablecerProveedor, data);
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
  } catch (error) {
    alertError("Error", error);
  }
};
//create
const createProveedor = async (form, inputs) => {
  console.log(url + "/insertar");
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/insertar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-exampleProveedores").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//update
const updateProveedor = async (form, inputs) => {
  try {
    const data = new FormData(form);
    console.log(form);
    console.log(inputs);

    let result = await executePetition(url + "/editar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal(`#${form.parentElement.parentElement.getAttribute("id")}`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//delete
const daleteProveedor = async (data) => {
  try {
    const result = await executePetition(url + `/update/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//restablecer
const restablecerProveedor = async (data) => {
  try {
    const result = await executePetition(url + `/restablecerProveedor/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readProveedores();
