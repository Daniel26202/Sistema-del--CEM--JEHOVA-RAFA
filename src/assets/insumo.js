import { executePetition, alertConfirm, alertError, alertSuccess } from "./../assets/ajax/funtionExecutePetition.js";
// grpFormInCorrect malo
// grpFormCorrect bueno
console.log("DOMContentLoaded Insumos");
const archivo = document.getElementById("imagen");
const cantidades = document.querySelectorAll(".cantidad");
const formBuscadorInsumo = document.getElementById("form-buscador-insumo");
const input = document.querySelector("#form-buscador-insumo input");
const eliminarInsumo = document.getElementById("eliminarInsumo");
const inputEditar = document.querySelectorAll(".input-editar");
const inputEditarImagen = document.querySelector(".input-editar-imagen");
//href="?c=controladorInsumos/insumos"
const modalAgregarInsumos = document.getElementById("modalAgregarInsumos");
const inputs = document.querySelectorAll("#modalAgregarInsumos .input-disabled");

//editar
const modalEditarInsumos = document.getElementById("modalEditarInsumos");
const inputsEditar = document.querySelectorAll("#modalEditarInsumos .input");

//tarjetas
const tarjetas = document.querySelectorAll(".tarjet");
const divPapelera = document.getElementById("div-papelera");
const urlBase = document.getElementById("urlBase").value;

const selector = ".exampleTable";


let url = "/Sistema-del--CEM--JEHOVA-RAFA/Insumos";
let urlActual = window.location.href;

const expresionesInsumos = {
  imagen: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
  nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
  descripcion: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
  cantidad: /^([1-9]{1})([0-9]{1,4})?$/,
  precio: /^(\d{1,3}\.\d{3}.\d{2}|\d{1,3}.\d{2})$/,
  fechaDeVencimiento: /^\d{4}\-\d{2}\-\d{2}$/,
  stockMinimo: /^([1-9]{1})([0-9]{1})?$/,
  lote: /^[0-9-_]{4,10}$/,
  marca: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ\s\d]{4,16}$/,
  medida: /^\d+\s?(ml|L|g|kg|m|cm|mm)$/,
  //^([0-9]+)$
};

const camposInsumos = {
  imagen: true,
  nombre: false,
  descripcion: false,
  cantidad: false,
  precio: false,
  precioD: false,
  fechaDeVencimiento: false,
  stockMinimo: false,
  lote: false,
  marca: false,
  medida: false,
};

const camposEditarInsumos = {
  imagen: true,
  nombre: true,
  descripcion: true,
  cantidad: true,
  precio: true,
  precioD: true,
  fechaDeVencimiento: true,
  stockMinimo: true,
  lote: true,
  marca: true,
  medida: true,
};

//funcion para traer los datos de las entradas de los inusmos que ya se vallan a vencer

//gestionar insumos vencidos

const traerInsumoCasiVencidos = async () => {
  let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Insumos/retornarLasEntradas");
  let resultado = await peticion.json();
  console.log(resultado);

  const botones = document.querySelectorAll(".botones-mostrar");
  const alertasVencidos = document.querySelectorAll(".alertas-vencidos");

  botones.forEach((ele, index) => {
    const dataIndex = ele.getAttribute("data-index");
    const insumoEncontrado = resultado.find((res) => res && res.id_insumo_e == dataIndex);
    console.log(alertasVencidos[index].children[1]);
    if (insumoEncontrado) {
      alertasVencidos[index].classList.remove("d-none");
      alertasVencidos[index].classList.add("uk-alert-danger");
      alertasVencidos[index].children[1].classList.add("p-error-validaciones");
      alertasVencidos[
        index
      ].children[1].innerText = `El insumo ${insumoEncontrado.nombre} del lote ${insumoEncontrado.numero_de_lote} vence el ${insumoEncontrado.fechaDeVencimiento}.`;
      document.getElementById("id_entradaDeInsumo").value = insumoEncontrado.id_entradaDeInsumo;
      document.getElementById("id_insumo").value = insumoEncontrado.id_insumo_e;
    } else {
      let tarjeta = alertasVencidos[index].parentElement.parentElement.parentElement;
      tarjeta.children[0].style.height = "56%";
    }
  });
};

traerInsumoCasiVencidos();

//evento para que si le da a la x de la alerta la tarjeta se haga mas pequeña
document.querySelectorAll(".uk-alert-close").forEach((ele) => {
  ele.addEventListener("click", function () {
    let tarjeta = this.parentElement.parentElement.parentElement.parentElement;
    tarjeta.children[0].style.height = "56%";
  });
});

const readInsumos = async (contenedor) => {
  try {
    let metodo = "";

    if (!urlActual.includes("papelera")) metodo = "insumosAjax";
    else metodo = "papeleraInsumosAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    // construir html de filas
    let html = "";
    console.log(result);

    result.forEach((element) => {
      if (!urlActual.includes("papelera")) {
        html += `<div class="contenido card   ms-3 tarjet mt-2 tarjetas_iniciales " style="width: 15rem;">
                                <img src="${urlBase}../src/assets/img_ingresadas_por_usuarios/insumos/${
          element.imagen
        }" class="card-img-top" style="height: 35%;">
                                <div class="card-body mt-4 tarjeta-ajax">
                                    <!-- <div class="alert  text-center alertas-vencidos d-none p-0">  -->
                                    <!-- aqui es la alerta de los vencidos -->
                                    <!-- </div> -->

                                    <div class="w-100 ">
                                        <div class="fw-bolder alertas-vencidos d-none" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p class="pe-2"></p>
                                        </div>
                                    </div>


                                    <h5 class="card-title titulo">${element.nombre}</h5>
                                    <p class="mt-3">Medida: ${element.medida}</p>
                                    <p class="mt-3">Stock-Min: ${element.stockMinimo}</p>

                                        <p class="${element.cantidad_inventario <= 0 ? "text-danger" : ""}">Cantidad: ${
          element.cantidad_inventario
        }</p>                                   

                                    <a href="#" class="btn btn-agregarcita-modal text-decoration-none botones-mostrar" data-index="${
                                      element.id_insumo
                                    }"
                                        uk-toggle="target: #modal-exampleMostrar">Mostrar</a>
                                </div>
                            </div>
            `;
      } else {
        //html para la papelera
        html += `<tr>
              <td class="text-center">${element.nombre}</td>
              <td class="text-center">${element.descripcion}</td>
              <td class="text-center">${element.precio} BS</td>
              <td class="text-center">${element.cantidad_inventario}</td>
              <td class="text-center">${element.stockMinimo}</td>

              <td class="d-flex justify-content-center">


                <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer" data-index="${element.id_insumo}" title="Restablecer" >
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                  </svg></button>
              </td>

            </tr> `;
      }
    });

    //resetear datatable si esta en papelera
    if (urlActual.includes("papelera")) {

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }
    }

    // vuelca el html en el tbody
    contenedor.innerHTML = html;


    if (urlActual.includes("papelera")) {
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
    }

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //info
    if (!urlActual.includes("papelera")) {
      document.querySelectorAll(".botones-mostrar").forEach((ele) => {
        ele.addEventListener("click", function () {
          infoInsumos(this.getAttribute("data-index"));
        });
      });
    }

    //llamar las funcion de eliminar
    if (!urlActual.includes("papelera")) {
      document.querySelector(".btn-eliminar").addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_bitacora").value];
        alertConfirm("Esta seguro de eliminar el insumo?", deleteInsumo, data);
      });
    }
    //llamar a la uncion de restablecer
    //llamar las funcion de eliminar
    if (urlActual.includes("papelera")) {

      document.querySelectorAll(".btnRestablecer").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
          alertConfirm("Esta seguro de restablecer el insumo?", restablecerInsumos, data);
        });
      });
    }



  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

if (!urlActual.includes("papelera")) {
  readInsumos(document.getElementById("div-tarjets"));
} else {
  readInsumos(divPapelera);
}

//delete
const deleteInsumo = async (data) => {
  try {
    const result = await executePetition(url + `/eliminar/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readInsumos(document.getElementById("div-tarjets"));

      UIkit.modal("#modal-exampleMostrar").hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updateInsumos = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/editar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal(`#modal-exampleEditarInsumos`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readInsumos(document.getElementById("div-tarjets"));
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//restablecer
const restablecerInsumos = async (data) => {
  try {
    const result = await executePetition(url + `/restablecerInsumo/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message)

      readInsumos(divPapelera);
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error",error)
  }
};

//create
const createInsumos = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/guardarInsumo", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-exampleInsumos").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readInsumos(document.getElementById("div-tarjets"));
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//ajax
async function infoInsumos(id_insumo) {
  let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Insumos/info/" + id_insumo);
  let resultado = await peticion.json();
  let parrafos = document.querySelectorAll(".parrafo");
  console.log(resultado);
  resultado["insumo"].forEach((res) => {
    console.log(res.nombre);
    parrafos[0].innerText = `${res.nombre}`;
    parrafos[1].innerText = `${res.descripcion}`;
    parrafos[2].innerText = `${res.marca}`;
    parrafos[3].innerText = `${res.precio * parseFloat(resultado["dolar"])} BS`;
    parrafos[4].innerText = `${parseFloat(res.precio)} $`;
    parrafos[5].innerText = `${res.iva ? "Contiene IVA" : "Excento de IVA"}`;
    parrafos[6].innerText = `${resultado["vencimiento"][0][0]}`;

    inputEditar[0].value = res.id_insumo;
    inputEditar[1].value = res.nombre;
    inputEditar[2].value = res.descripcion;
    inputEditar[3].value = res.marca;
    inputEditar[4].value = res.medida;
    inputEditar[5].value = res.stockMinimo;
    //inputEditar[4].value = res.fechaDeVencimiento

    document.querySelector(".img-editar").setAttribute("src", `../src/assets/img_ingresadas_por_usuarios/insumos/${res.imagen}`);

    document.querySelector(".value-img").value = res.imagen;

    document.querySelector(".btn-eliminar").setAttribute("data-index", res.id_insumo);
  });
}

//funcion para buscar insumos
function buscarInsumos(input) {
  console.log(input);
  document.querySelectorAll(".titulo").forEach((ele, index) => {
    let nombre = ele.innerText.toLowerCase();
    let codigo = tarjetas[index].innerText;

    if (input.value != "") {
      if (nombre.includes(input.value.toLowerCase()) || codigo.includes(input.value)) {
        tarjetas[index].classList.remove("d-none");
      } else {
        tarjetas[index].classList.add("d-none");
      }
    } else {
      tarjetas[index].classList.remove("d-none");
    }
  });
}

//formulario para buscar insumo
formBuscadorInsumo.children[0].addEventListener("keyup", function () {
  buscarInsumos(this);
});

//imagenes de los insumos
archivo.addEventListener("change", function (e) {
  leerArchivo(archivo.files);
});

function leerArchivo(ar) {
  for (var i = 0; i < ar.length; i++) {
    const reader = new FileReader();
    reader.readAsDataURL(ar[i]);
    reader.addEventListener("load", function (e) {
      let newImg = `<img  style="height: 200px;width: 100%;" src=${e.currentTarget.result}>`;
      document.querySelector("#contenedor-img").innerHTML = newImg;
    });
  }
}

inputEditarImagen.addEventListener("change", function (e) {
  leerArchivoEditar(inputEditarImagen.files);
});

//editar img
function leerArchivoEditar(ar) {
  for (var i = 0; i < ar.length; i++) {
    const reader = new FileReader();
    reader.readAsDataURL(ar[i]);
    reader.addEventListener("load", function (e) {
      document.querySelector(".img-editar").setAttribute("src", `${e.currentTarget.result}`);
      console.log(e.currentTarget.result);
    });
  }
}

// Nueva función para validar fechas no futuras ni pasadas
function validarFecha(input, pError, campo, campos) {
  const valorFecha = new Date(input.value);
  const fechaHoy = new Date();
  fechaHoy.setHours(0, 0, 0, 0); // Establece el tiempo a la medianoche para comparación

  pError.classList.add("fw-bold");
  pError.style.color = "rgb(224, 3, 3)";

  if (campo == "fechaDeVencimiento") {
    if (!expresionesInsumos.fechaDeVencimiento.test(input.value)) {
      // Validamos con la expresión regular
      pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
      pError.classList.remove("d-none");
      return false;
    } else if (valorFecha <= fechaHoy) {
      // Validamos que no sea una fecha del pasado
      pError.textContent = "La fecha no puede ser del pasado.";
      pError.classList.remove("d-none");
      return false;
    }
  }

  // Si pasa todas las validaciones
  pError.classList.add("d-none");
  // actualizarEstadoInput(input, "incorrecto", formulario);

  camposInsumos[campo] = true;
}

//validaciones de guardar

const validarCamposInsumos = (expresiones, input, campo, camposInsumos) => {
  const pErrorGuardar = document.querySelector(".p-error-" + input.name);
  console.log(pErrorGuardar);
  pErrorGuardar.classList.add("fw-bold");
  pErrorGuardar.classList.add("p-error-validaciones");
  console.log(pErrorGuardar);
  if (input.name == "fecha_de_vencimiento") {
    console.log("2trabaje con la echa");
    validarFecha(input, pErrorGuardar, campo, camposInsumos);
  } else {
    if (expresiones.test(input.value)) {
      input.parentElement.classList.remove("grpFormInCorrect");
      input.parentElement.classList.add("grpFormCorrect");
      pErrorGuardar.classList.add("d-none");
      camposInsumos[campo] = true;
    } else {
      input.parentElement.classList.remove("grpFormCorrect");
      input.parentElement.classList.add("grpFormInCorrect");
      pErrorGuardar.classList.remove("d-none");
      camposInsumos[campo] = false;
    }
  }
};

function validarFormularioInsumo(e) {
  switch (e.target.name) {
    case "imagen":
      const pErrorGuardarImagen = document.querySelector(".p-error-imagen");
      console.log(pErrorGuardarImagen);
      pErrorGuardarImagen.classList.add("fw-bold");
      pErrorGuardarImagen.classList.add("p-error-validaciones");
      let imagenSeparada = e.target.value.split("\\");
      let nombreImagen = imagenSeparada.pop();
      if (expresionesInsumos.imagen.test(nombreImagen)) {
        e.target.parentElement.classList.remove("grpFormInCorrect");
        e.target.parentElement.classList.add("grpFormCorrect");
        pErrorGuardarImagen.classList.add("d-none");
        camposInsumos["imagen"] = true;
      } else {
        e.target.parentElement.classList.remove("grpFormCorrect");
        e.target.parentElement.classList.add("grpFormInCorrect");
        pErrorGuardarImagen.classList.remove("d-none");
        camposInsumos["imagen"] = false;
      }

      break;

    case "nombre":
      validarCamposInsumos(expresionesInsumos.nombre, e.target, "nombre", camposInsumos);

      break;
    case "descripcion":
      validarCamposInsumos(expresionesInsumos.descripcion, e.target, "descripcion", camposInsumos);

      break;

    case "cantidad":
      validarCamposInsumos(expresionesInsumos.cantidad, e.target, "cantidad", camposInsumos);

      break;
    case "precio":
      validarCamposInsumos(expresionesInsumos.precio, e.target, "precio", camposInsumos);
      break;
    case "precioD":
      validarCamposInsumos(expresionesInsumos.precio, e.target, "precioD", camposInsumos);
      break;
    case "fecha_de_vencimiento":
      validarCamposInsumos(expresionesInsumos.fechaDeVencimiento, e.target, "fechaDeVencimiento", camposInsumos);
      break;
    case "stockMinimo":
      validarCamposInsumos(expresionesInsumos.stockMinimo, e.target, "stockMinimo", camposInsumos);
      break;
    case "lote":
      validarCamposInsumos(expresionesInsumos.lote, e.target, "lote", camposInsumos);
      break;

    case "marca":
      validarCamposInsumos(expresionesInsumos.marca, e.target, "marca", camposEditarInsumos);
      break;
    case "medida":
      validarCamposInsumos(expresionesInsumos.medida, e.target, "medida", camposEditarInsumos);
      break;
  }
}

function validarFormularioInsumoEditar(e) {
  switch (e.target.name) {
    case "imagen":
      let imagenSeparada = e.target.value.split("\\");
      let nombreImagen = imagenSeparada.pop();
      if (expresionesInsumos.imagen.test(nombreImagen)) {
        e.target.parentElement.classList.remove("grpFormInCorrect");
        e.target.parentElement.classList.add("grpFormCorrect");
        camposEditarInsumos["imagen"] = true;
      } else {
        e.target.parentElement.classList.remove("grpFormCorrect");
        e.target.parentElement.classList.add("grpFormInCorrect");
        camposEditarInsumos["imagen"] = false;
      }

      break;

    case "nombre":
      validarCamposInsumos(expresionesInsumos.nombre, e.target, "nombre", camposEditarInsumos);

      break;
    case "descripcion":
      validarCamposInsumos(expresionesInsumos.descripcion, e.target, "descripcion", camposEditarInsumos);

      break;

    case "cantidad":
      validarCamposInsumos(expresionesInsumos.cantidad, e.target, "cantidad", camposEditarInsumos);

      break;
    case "fecha_de_vencimiento":
      validarCamposInsumos(expresionesInsumos.fechaDeVencimiento, e.target, "fechaDeVencimiento", camposEditarInsumos);
      break;
    case "stockMinimo":
      validarCamposInsumos(expresionesInsumos.stockMinimo, e.target, "stockMinimo", camposEditarInsumos);
      break;
    case "lote":
      validarCamposInsumos(expresionesInsumos.lote, e.target, "lote", camposEditarInsumos);
      break;
    case "marca":
      validarCamposInsumos(expresionesInsumos.marca, e.target, "marca", camposEditarInsumos);
      break;
    case "medida":
      validarCamposInsumos(expresionesInsumos.medida, e.target, "medida", camposEditarInsumos);
      break;
  }
}

inputs.forEach((input) => {
  input.addEventListener("input", validarFormularioInsumo);
});

inputs.forEach((input) => {
  input.addEventListener("keyup", validarFormularioInsumo);
});

inputs.forEach((input) => {
  input.addEventListener("blur", validarFormularioInsumo);
});

inputEditar.forEach((input) => {
  input.addEventListener("input", validarFormularioInsumoEditar);
});

modalAgregarInsumos.addEventListener("submit", function (e) {
  e.preventDefault();

  if (
    camposInsumos.imagen &&
    camposInsumos.nombre &&
    camposInsumos.descripcion &&
    camposInsumos.cantidad &&
    camposInsumos.precio &&
    camposInsumos.fechaDeVencimiento &&
    camposInsumos.stockMinimo &&
    camposInsumos.lote
  ) {
    console.log("si se envia");

    createInsumos(modalAgregarInsumos, inputs);
  } else {
    document.getElementById("alerta-guardar").classList.remove("d-none");
    setTimeout(function () {
      document.getElementById("alerta-guardar").classList.add("d-none");
    }, 8000);
  }
});

inputsEditar.forEach((input) => {
  input.addEventListener("input", validarFormularioInsumoEditar);
});

modalEditarInsumos.addEventListener("submit", function (e) {
  e.preventDefault();
  if (
    camposEditarInsumos.imagen &&
    camposEditarInsumos.nombre &&
    camposEditarInsumos.descripcion &&
    camposEditarInsumos.stockMinimo
  ) {
    console.log("si se envia");
    updateInsumos(modalEditarInsumos, inputsEditar);
  } else {
    alertError("Error", "Por favor verifique que todos los datos esten correctos.");
  }
});

//funcion para manejar el checkbox del iva
document.querySelector(".checkboxIva").addEventListener("change", function () {
  if (this.checked) {
    this.value = 1;
  } else {
    this.value = 0;
  }
});
