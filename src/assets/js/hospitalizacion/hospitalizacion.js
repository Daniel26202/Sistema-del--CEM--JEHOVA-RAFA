import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  clearStyleVInputs,
  initDataTable,
  hasPermision,
  initLoaderButton,
  finallyLoaderButton,
  showDataModal,
} from "../generic/funtionGeneric.js";
import Paginator from "../generic/Paginator.js"; //paginacion
import {
  inicializarValidacionFormulario,
  chulitoYX,
} from "../generic/expresionesModulares.js";

const modalHospitGuardar = new bootstrap.Modal(
  document.getElementById("modal-agregar-hospitalizacion"),
);
const modalHospitEditar = new bootstrap.Modal(
  document.getElementById("modal-editar-hospitalizacion"),
);
const modalAgregarInsumos = new bootstrap.Modal(
  document.getElementById("modal-agregar-insumos"),
);

const modalAgregarServicios = new bootstrap.Modal(
  document.getElementById("modal-agregar-servicios"),
);
const modalAgregarPaciente = new bootstrap.Modal(
  document.getElementById("exampleModalagregarPaciente"),
);
const formularioAgregar = document.getElementById("formularioAgregarH");
const formularioEditar = document.getElementById("formularioEditarH");
const formCostoHoras = document.getElementById("formCostoHora");
const formAgregarPaciente = document.getElementById("modalAgregar");
const cedulaPaciente = document.getElementById("cedulaPaciente");
const parrafoExP = document.getElementById("p-paciente");
const parrafoNoP = document.getElementById("p-no-paciente");
const contenedorForm = document.getElementById("contenedorFormAgregar");
const btnInformacionPaciente = document.querySelector("#inforPaciente");
const divModal = document.querySelector("#divModal");
const closeModal = document.querySelector("#closeModal");
const nombreApellidoInfor = document.getElementById("nombreInfor");
const diagnosticoInfor = document.getElementById("inforDiagnostico");
const btnEnviar = document.getElementById("btnEnviar");
const historiaclinica = document.getElementById("historia_clinicaA");
const input_cedula = document.getElementById("input_cedula_paciente");
const btn_open_modal_services = document.querySelectorAll(".cargar-servicios");
const btns_cargar_insumos = document.querySelectorAll(".cargar-insumos");
const div_services = document.getElementById("div-serviciosA");
const div_servicios_edit = document.getElementById("div-serviciosE");
const div_services_modal = document.getElementById("servicios");
const div_insumos_modal = document.getElementById("div-insumos-modal");
const div_insumos = document.getElementById("div-insumosA");
const div_insumos_edit = document.querySelector(".div-insumosAE");
const nom_apell_paciente = document.getElementById("NombreAp");
const historial_editar = document.getElementById("historiaE");
const diagnostico_editar = document.getElementById("diagnostico");
const idHptE = document.getElementById("idHptE");
const btn_add_hosp = document.getElementById("btnAgregarH");
const horas = document.querySelector("#horasS");
const costoHoras = document.querySelector("#costoHS");
const costoHorasMoEx = document.querySelector("#costoHSMoEx");
const btnGuardarCH = document.querySelector("#btnCH");
const alertaNoHayPrecioH = document.getElementById("alertaPrecioHora");
const btnAgregar = document.getElementById("btnAgregarH");
const btn_open_modal_paciente = document.getElementById("aPaciente");
// inputs del costo y las horas del servicio
let iHS = document.getElementById("inpHorasS");
let iCS = document.getElementById("inpCostoHS");
let iHME = document.getElementById("inpHorasMoEx");
let iCME = document.getElementById("inpCostoHMoEx");

const selector = ".exampleTable";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";
let valorDelDolar = localStorage.getItem("valorDelDolar")
  ? parseFloat(localStorage.getItem("valorDelDolar"))
  : 0;
let horaInicioHosp = 0;
let dataH = [];
let dataServices = [];
let dataInsumo = [];
let dataInsumosModal = [];
let dataServicesModal = [];
let objServiciosHosp = {};
let objServiciosBD = {};
let insumosEliminados = [];
let servicesEliminados = [];
let modoInsumoActual = "agregar";
let modoServiciosActual = "agregar";

const returnFragmentServies = (res) => {
  return `
     <div class="col-6 mt-5">

            <div class=" col-sm-6 col-md-6" style="width:90%">
                <div class="contenedor-fondo card card-servicio-v2 border rounded-4 shadow-sm h-100"
                    style="cursor:pointer"
                    data-index="2518" data-id-servicio="25" data-doctor="18" id="card-services${res.id_servicioMedico}">
                    <!-- Cabecera -->
                    <div class="serv-v2-header p-3 border-bottom text-center">
                        <p class="categoria serv-v2-nombre fw-bold mb-1 fs-6" style="color:var(--color-text-card)">
                            ${res.categoria}
                        </p>
                        <span class="badge" style="background:var(--color-primary); font-size:0.68rem">
                            Servicio médico
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="card-body d-flex flex-column gap-2">

                        <!-- Doctor -->
                        <p class="data-doctor text-center mb-0 fw-semibold" style="font-size:0.85rem; color:var(--color-text-card)">
                            DR: ${res.nombre} ${res.apellido}
                        </p>

                        <hr class="my-1 opacity-25">

                        <!-- Precios centrados -->
                        <div class="text-center">
                            <div class="serv-label">Precio</div>
                            <div class="serv-usd" data-precio=${res.precio.toFixed(2)}>$ ${res.precio.toFixed(2)}</div>
                            <div class="serv-bs">${(res.precio * valorDelDolar).toFixed(2)} Bs</div>
                        </div>

                        <!-- Botón al fondo -->
                        <div class="mt-auto pt-1">
                            <input type="hidden" value="1000.00" class="precio-servicio">
                            <button class="btn btn-v2 botones-mostrar w-100 d-flex align-items-center justify-content-center gap-2"
                                data-index="${res.id_servicioMedico}">
                                <i class="bi bi-plus-circle-fill"></i> Agregar
                            </button>
                        </div>

                    </div>
                </div>
            </div>


    </div>
  `;
};

const returnFragmentInsumos = (res) => {
  return `
   <div class="col-6 mt-5">
            <div class="col-sm-6 col-md-6" style="width:90%">
                <div id="card-insumos${res.id_insumo}" class="contenedor-fondo  card card-insumo-v2 border rounded-4 shadow-sm h-100"
                    data-index="${res.id_insumo}" data-medida="${res.medida}" data-precio="${res.precio}" data-cantidad="${res.cantidad_disponible}" data-name="${res.nombre}" data-cantidad=${res.cantidad_disponible}  data-iva="${res.iva}">

                    <!-- TOP: nombre + medida -->
                    <div class="card-body pb-2">
                        <p class="fw-bold mb-1 fs-6" style="color:var(--color-text-card)">${res.nombre}</p>
                        <span class="insumo-v2-medida">${res.medida}</span>
                    </div>

                    <hr class="mx-3 my-0 opacity-25">

                    <!-- BODY -->
                    <div class="card-body d-flex flex-column gap-2 pt-2">

                        <!-- Chips -->
                        <div class="d-flex flex-wrap gap-2">
                            <span class="chip d-inline-flex align-items-center gap-1">
                                <i class="bi bi-tag"></i> ${res.iva ? "Con IVA" : "Sin IVA"}
                            </span>
                            <span class="chip d-inline-flex align-items-center gap-1">
                                <i class="bi bi-boxes"></i> Stock: ${res.cantidad_disponible}
                            </span>
                        </div>

                        <!-- Precio -->
                        <div>
                            <div class="precio-usd">$ ${res.precio.toFixed(2)}</div>
                            <div class="precio-bs">${(parseFloat(res.precio) * valorDelDolar).toFixed(2)}</div>
                        </div>

                        <!-- Input cantidad -->
                        <div class="insumo-v2-input-wrap d-flex align-items-center">
                            <span class="d-flex align-items-center px-2 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>
                            </span>
                            <input id='input_card_insumo${res.id_insumo}' class="form-control input-validar inputs cantidadDisplay py-2"
                                type="number" min="1" max="${res.cantidad_disponible}" value="1"
                                data-index="${res.id_insumo}" data-medida="400 ml"
                                data-iva="0" data-precio="80.00" data-stock="2">
                            <span class="d-flex align-items-center px-2">
                                <svg class="check d-none" width="18" height="18" fill="#28a745" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="18" height="18" fill="#dc3545" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>

                        <!-- Botón -->
                        <button class="btn btn-v2 botones-mostrar w-100 d-flex align-items-center justify-content-center gap-2 mt-auto"
                            data-index="${res.id_insumo}">
                            <i class="bi bi-plus-circle-fill"></i> Agregar
                        </button>

                    </div>
                </div>
            </div>

        </div>

  `;
};


  const resetForm = (form) => {
    form.reset();
    //quitar clase a los inputs
    document.querySelectorAll(".input-validar").forEach((input) => {
      input.parentElement.classList.remove("valido");
      input.parentElement.classList.remove("invalido");
      let span = input.nextElementSibling;
      span.children[0].classList.add("d-none");
      span.children[1].classList.add("d-none");
    });
    contenedorForm.classList.add('d-none')
    btnInformacionPaciente.classList.add("d-none");
    btnEnviar.classList.add('d-none')
  };

const traerSerevicio = async (direccionM) => {
  let resultado = await executePetition(url + "/selectServiciosD", "GET");
  console.log(resultado);
  let text;
  let modal;
  if (direccionM === "agregar") {
    text = "A";
    modal = "#modal-agregar-hospitalizacion";
  } else if (direccionM === "editar") {
    text = "E";
    modal = "#modal-editar-hospitalizacion";
  }
  let btnCancelar = document.querySelector("#btnCancelar");
  let noHayServicio = document.querySelector("#noHayServicio");
  let noPAservicio = document.querySelector("#NoPAservicio" + text);
  let serviciosConten = document.querySelector("#div-servicios" + text);

  btnCancelar.setAttribute("data-bs-target", modal);
  // si no se trae nada
  if (resultado.length < 1) {
    console.log("hay un problema, el servicio seleccionado no existe");
    if (noHayServicio) {
      noHayServicio.classList.remove("d-none");
    }

    //si se trae algo
  } else {
    if (noHayServicio) {
      noHayServicio.classList.add("d-none");
    }
    let html = ``;

    for (const datoS of resultado) {
      objServiciosBD[datoS["id_servicioMedico"]] = datoS;
      html += `<div class="col-12 col-sm-6 col-md-4 col-lg-4 divServicio"
                                data-index="${datoS["id_servicioMedico"]}">
                                <a href="#" class="card text-center text-decoration-none h-100"
                                    data-bs-toggle="modal" data-bs-target="${modal}">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-plus-circle mb-2 fs-3"></i>
                                        <p class="fw-bolder mb-1">${datoS["categoria"]}</p>
                                        <p class="mb-0 small">${datoS["nombre"] + " " + datoS["apellido"]}</p>
                                    </div>
                                </a>
                            </div>`;
    }

    console.log(objServiciosBD);

    document.querySelector("#servicios").innerHTML = html;
    let htmlL = ``;
    let divServicios = document.querySelectorAll(".divServicio");
    if (divServicios) {
      for (const div of divServicios) {
        div.addEventListener("click", function () {
          let idS = parseInt(this.getAttribute("data-index"));
          console.log(idS);

          htmlL = `<div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative servicioA" data-index="${idS}">
                                    <!-- Botón eliminar -->
                                    <button type="button"
                                        class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarServ"
                                        data-index="${idS}"
                                        style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
                                        ×
                                    </button>

                                    <!-- Tarjeta -->
                                    <a href="#"
                                        class="card text-decoration-none h-100 shadow-sm border-0 rounded-4"
                                        style="background: #f4f9ff61; transition: all 0.2s ease;">

                                        <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">
                                            <div class="fw-semibold text-dark mb-2 m-auto d-flex ">
                                                <p class="me-1 text-center cantidadServicio" style="font-size:1rem;">
                                                    1
                                                </p>
                                                <p class="" style="font-size:1rem;">
                                                    ${objServiciosBD[idS]["categoria"]}
                                                </p>
                                            </div>
                                            <p class="text-muted mb-1" style="font-size:0.9rem;">
                                                ${objServiciosBD[idS]["nombre"]} ${objServiciosBD[idS]["apellido"]}
                                            </p>
                                            <p class="fw-bold text-primary mb-0 precioS" style="font-size:0.95rem;">
                                                ${objServiciosBD[idS]["precio"]} Bs
                                            </p>
                                            <div>
                                                <input type="hidden" name="id_servicio[]" class="" value="${idS}">
                                                <input type="hidden" name="cantidadS[]" class="cantidadServicioInput" value="1">
                                            </div>                         
                                        </div>
                                    </a>
                                </div>`;

          if (objServiciosBD[idS]["tipo"] == "Examenes") {
            // buscar si el servicio ya está agregado en el contenedor
            const servicioExistente = serviciosConten.querySelector(
              `.servicioA[data-index="${idS}"]`,
            );

            if (servicioExistente) {
              // aumentar la cantidad Serv
              const pCantidad =
                servicioExistente.querySelector(".cantidadServicio");
              const inputCantidad = servicioExistente.querySelector(
                ".cantidadServicioInput",
              );
              if (pCantidad) {
                let newCantidad = parseInt(pCantidad.textContent.trim()) || 1;
                newCantidad = newCantidad + 1;
                pCantidad.textContent = newCantidad;
                inputCantidad.value = newCantidad;
                // Actualizar el precio
                let precioS = newCantidad * objServiciosBD[idS]["precio"];
                let pMoneyS = servicioExistente.querySelector(".precioS");
                if (pMoneyS) {
                  pMoneyS.textContent = precioS + " Bs";
                }
              }
            } else {
              // si no existe, agrega el servicio tipo examen
              serviciosConten.innerHTML += htmlL;
              document.querySelector("#btnAS" + text).classList.add("d-none");
              document
                .querySelector("#btnAServiciosExiste" + text)
                .classList.remove("d-none");
            }
          } else {
            const servicioExistente = serviciosConten.querySelector(
              `.servicioA[data-index="${idS}"]`,
            );

            if (servicioExistente) {
              noPAservicio.classList.remove("d-none");
              setTimeout(() => {
                noPAservicio.classList.add("d-none");
              }, 8000);
            } else {
              serviciosConten.innerHTML += htmlL;
              document.querySelector("#btnAS" + text).classList.add("d-none");
              document
                .querySelector("#btnAServiciosExiste" + text)
                .classList.remove("d-none");
            }
          }
        });
      }
    }
    if (serviciosConten) {
      serviciosConten.addEventListener("click", function (e) {
        console.log(e);

        const servicioElem = e.target.closest(".servicioA");
        servicioElem.remove();
      });
    }
  }
  return objServiciosBD;
};

//aquí se utiliza los siguientes elementos para traerse los datos de paciente y también buscarlo
const search_paciente = async (cedula) => {
  try {
    let resultado = await executePetition(
      url + "/validarPaciente/" + cedula,
      "GET",
    );

    if (resultado) {
      let resultado_info = await executePetition(
        url + "/mostrarInformacionPCD/" + cedula,
        "GET",
      );

      btn_open_modal_paciente.classList.add("d-none");
      let nombreApellido = `${resultado.nombre} ${resultado.apellido}`;
      parrafoExP.innerText = "";
      parrafoExP.innerText = nombreApellido;
      nombreApellidoInfor.innerText = "";
      nombreApellidoInfor.innerText = nombreApellido;
      diagnosticoInfor.innerText = "";
      // recolecto el id del paciente
      document.getElementById("input-id-paciente").value =
        resultado.id_paciente;
      parrafoNoP.classList.toggle("d-none", true);
      btnInformacionPaciente.classList.toggle("d-none", false);
      contenedorForm.classList.toggle("d-none", false);
      btnEnviar.classList.toggle("d-none", false);

      if (resultado_info) {
        diagnosticoInfor.innerText = `${resultado_info.diagnostico}`;
        let historia = resultado_info.historiaclinica;
        // trim() quita los espacios en el principio y al final
        historiaclinica.value = historia.trim();
        return;
      }
      diagnosticoInfor.innerText = `Aun, no esta diagnosticado`;
      historiaclinica.value = "";
      return;
    }

    parrafoNoP.innerText = "";
    parrafoNoP.innerText = "El paciente no esta registrado.";
    document.getElementById("input-id-paciente").value = "";

    btn_open_modal_paciente.classList.remove("d-none");

    btn_open_modal_paciente.addEventListener("click", function () {
      document.querySelector("#cedula").value =
        document.querySelector("#bt").value;
    });
    parrafoNoP.classList.toggle("d-none", false);
    btnInformacionPaciente.classList.toggle("d-none", true);
    contenedorForm.classList.toggle("d-none", true);
    btnEnviar.classList.toggle("d-none", true);
  } catch (error) {
    console.log(error);
  }
};

// calculo del dolar en la infomación de la H
const mostrarInf = async (indice) => {
  let fechaInicioM = document.getElementById(`fechaInicio${indice}`).value;
  let fechaInicio = new Date(fechaInicioM);
  let fechaActual = new Date();
  let diferencia = fechaActual - fechaInicio;
  // el total de horas (con decimales)
  let horasTotales = diferencia / (1000 * 60 * 60);
  let storedHora = localStorage.getItem("hora");
  let storedCosto = localStorage.getItem("costo");
  let storedCostoMoEx = localStorage.getItem("costoMoEx");
  let costoH = parseFloat(storedCosto) / parseInt(storedHora);
  let costoHMoEx = parseFloat(storedCostoMoEx) / parseInt(storedHora);

  // monto de horas y minutos
  let monto = horasTotales * costoH;
  let montoMoEx = horasTotales * costoHMoEx;

  let horas = Math.floor(horasTotales);
  let minutos = Math.floor((horasTotales - horas) * 60);

  let totalMontoI = await sumaPrecioIH(indice);

  if (totalMontoI === undefined) {
    totalMontoI = 0;
  }

  let total = totalMontoI + monto;
  let storedDolar = localStorage.getItem("valorDelDolar");
  let totalMontoIMoEx = totalMontoI / storedDolar;
  let totalME = totalMontoIMoEx + montoMoEx;
  monto = parseFloat(monto) ? parseFloat(monto) : 0;
  montoMoEx = parseFloat(montoMoEx) ? parseFloat(montoMoEx) : 0;
  total = parseFloat(total) ? parseFloat(total) : 0;
  totalME = parseFloat(total) ? parseFloat(total) : 0;

  document.querySelector("#hHosM").innerText = `${horas}h ${minutos}min`;
  document.querySelector("#cMontoHoraM").innerText = monto.toFixed(2);
  document.querySelector("#cMoHoraMoExM").innerText = montoMoEx.toFixed(2);
  document.querySelector("#calculoTotal").innerText = total.toFixed(2);
  document.querySelector("#calculoTotalME").innerText = totalME.toFixed(2);

  let hMM = document.getElementById(`hME${indice}`);
  let historiaM = document.querySelector("#historiaM");
  // trim() quita los espacios en el principio y al final
  historiaM.innerText = hMM.value;
  return [monto, montoMoEx, total, totalME];
};

//es para hacer una suma con el precio de los insumo que la hospitalización tiene registrado
const sumaPrecioIH = async (id) => {
  try {
    // llamo la función traer insumos de h
    let resultadoI = await executePetition(url + "/traerInsuDHEd/" + id, "GET");
    if (resultadoI.length > 0) {
      let precioIns = 0;
      resultadoI.forEach((res) => {
        precioIns += parseFloat(res.precio) * parseInt(res.cantidad);
      });

      // para que muestre solo dos decimales (esto "toFixed" lo convierte en text)
      precioIns = parseFloat(precioIns.toFixed(2));
      return precioIns;
    }
  } catch (error) {
    console.log(
      "lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...:)",
    );
  }
};

// para traerme la hora y su costo
const enviarHoraCosto = async () => {
  let hora = parseInt(iHS.value.trim());
  let costo = parseFloat(iCS.value.trim());
  let costoMoEx = parseFloat(iCME.value.trim());

  hora = hora === "" ? "00" : hora;
  costo = costo === "" ? "00" : costo;
  costoMoEx = costoMoEx === "" ? "00" : costoMoEx;

  localStorage.setItem("hora", hora);
  localStorage.setItem("costo", costo);
  localStorage.setItem("costoMoEx", costoMoEx);
  validarPrecioHora();
  traerHoraCosto();
};

// para traerme la hora y su costo
const traerHoraCosto = async () => {
  let storedHora = localStorage.getItem("hora");
  let storedCosto = localStorage.getItem("costo");
  let storedCostoME = localStorage.getItem("costoMoEx");

  btnGuardarCH.classList.remove("d-none");

  horas.innerText = storedHora;
  costoHoras.innerText = storedCosto;

  costoHorasMoEx.innerText = storedCostoME;
  if (storedHora != null) {
    // agrego el texto del p (en este caso las horas) al valor del input
    iHS.value = storedHora;
    iHME.value = storedHora;
  } else if (storedHora === null) {
    localStorage.setItem("hora", 0);
    horas.innerText = 0;
    iHS.value = 0;
  }

  if (storedCosto != null) {
    // agrego el texto del p (en este caso el costo de las horas) al valor del input
    iCS.value = storedCosto;
  } else if (storedCosto === null) {
    localStorage.setItem("costo", 0);
    costoHoras.innerText = 0;
    iCS.value = 0;
  }

  if (storedCostoME != null) {
    // agrego el texto del p (en este caso el costo de las horas) al valor del input
    iCME.value = storedCostoME;
  } else if (storedCostoME === null) {
    localStorage.setItem("costoMoEx", 0);
    costoHorasMoEx.innerText = 0;
    iCME.value = 0;
  }
};

const validarPrecioHora = () => {
  const precioHora = localStorage.getItem("costo");
  const Hora = localStorage.getItem("hora");

  if (
    !precioHora ||
    precioHora.trim() === "" ||
    precioHora == 0 ||
    !Hora ||
    Hora.trim() === "" ||
    Hora == 0
  ) {
    // No hay precio guardado
    alertaNoHayPrecioH.style.display = "block";
    btnAgregar.style.display = "none";
  } else {
    // Sí hay precio guardado
    alertaNoHayPrecioH.style.display = "none";
    btnAgregar.style.display = "inline-block";
  }
};

const traerSerevicioH = async (idH) => {
  // llamo la función que trae los servicios de h
  let resultado = await executePetition(url + "/serviciosDH/" + idH, "GET");
  let serviciosConten = document.querySelector("#div-serviciosE");

  if (resultado.length > 0) {
    let htmlL = ``;
    for (const res of resultado) {
      objServiciosHosp[res.id_detalle] = res;

      // aumentar la cantidad Serv
      let newCantidad = parseInt(res.cantidad);
      // Actualizar el precio
      let precioS =
        newCantidad * objServiciosBD[res.id_servicioMedico]["precio"];
      if (!objServiciosBD[res.id_servicioMedico]) {
        continue;
      }
      htmlL += `<div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative servicioA" 
                            data-index="${res.id_servicioMedico}">
                                        <!-- Botón eliminar -->
                                        <button type="button"
                                            class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarServ"
                                            data-index="${res.id_servicioMedico}"
                                            style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
                                            ×
                                        </button>
    
                                        <!-- Tarjeta -->
                                        <a href="#"
                                            class="card text-decoration-none h-100 shadow-sm border-0 rounded-4"
                                            style="background: #f4f9ff61; transition: all 0.2s ease;">
    
                                            <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">
                                                <div class="fw-semibold text-dark mb-2 m-auto d-flex ">
                                                    <p class="me-1 text-center cantidadServicio" style="font-size:1rem;">
                                                        ${newCantidad}
                                                    </p>
                                                    <p class="" style="font-size:1rem;">
                                                        ${objServiciosBD[res.id_servicioMedico]["categoria"]}
                                                    </p>
                                                </div>
                                                <p class="text-muted mb-1" style="font-size:0.9rem;">
                                                    ${objServiciosBD[res.id_servicioMedico]["nombre"]} 
                                                    ${objServiciosBD[res.id_servicioMedico]["apellido"]}
                                                </p>
                                                <p class="fw-bold text-primary mb-0 precioS" style="font-size:0.95rem;">
                                                    ${precioS} Bs
                                                </p>
                                                <div>
                                                    <input type="hidden" name="id_servicio[]" class="" 
                                                    value="${res.id_servicioMedico}">
                                                    <input type="hidden" name="cantidadS[]" class="cantidadServicioInput" 
                                                    value="${newCantidad}">
                                                </div>                         
                                            </div>
                                        </a>
                                    </div>`;
    }
    serviciosConten.innerHTML = htmlL;
    document.querySelector("#btnASE").classList.add("d-none");
    document.querySelector("#btnAServiciosExisteE").classList.remove("d-none");
  } else {
    serviciosConten.innerHTML = "";
    document.querySelector("#btnASE").classList.remove("d-none");
    document.querySelector("#btnAServiciosExisteE").classList.add("d-none");
  }
};

// consultar datos hospitalizacion
const readHosp = async () => {
  let metodo = "";
  let urlActual = window.location.href;

  if (urlActual.includes("hospitalizacionesRealizadas")) {
    metodo = "traerHospR";
  } else if (
    urlActual.includes("hospitalizacion") &&
    !urlActual.includes("hospitalizacionesRealizadas")
  ) {
    metodo = "traerHospP";
  }

  // si ya existe DataTable, destrúyela
  if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().clear().destroy();
  }

  const columnsHosp = [
    {
      data: "cedula",
      render: (data, type, row) => `${row.nacionalidad}-${data}`,
    },
    { data: "nombre" },
    { data: "apellido" },
    { data: "diagnostico" },
    {
      data: "nombredoc",
      render: (data, type, row) => `${data} ${row.apellidodoc}`,
    },
    {
      data: null,
      orderable: false,
      render: function (data, type, row) {
        return `
                        <div class="d-flex flex-wrap col-12 tdTBtn">
                            <div class="col-12 col-md-6 col-lg-3">
                                <button class=" btn btn-tabla mb-1 me-1 informacionH"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvas-mostrarH"
                                    data-id-hospitalizacion="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="bi bi-card-text" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">

                                <!-- btn modal editar hospitalización -->
                                <button class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 editarH me-1" data-bs-toggle="modal"
                                    data-bs-target="#modal-editar-hospitalizacion"
                                    data-extra="${row.id_hospitalizacion}" data-index="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <button class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 me-1 btn-eliminar" data-index="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 me-1 text-white btnFH" data-bs-toggle="modal" data-bs-target="#modalEnvioFacturaHospitalizacion"  id="" title=""
                                    data-id-hospitalizacion="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                    </svg>
                                </a>
                            </div>
                            <div>
                                <input type="hidden" name="" id="fechaInicio${row.id_hospitalizacion}" value="${row.fecha_hora_inicio}">
                                <input class="precioHo" type="hidden" name="" value="${row.precio_horas}">
                                <input class="idC" type="hidden" name="" value="${row.id_control}">
                                <input class="idHpt" type="hidden" name="" value="${row.id_hospitalizacion}">
                                <input id="hME${row.id_hospitalizacion}" type="hidden" name="" value="${row.historiaclinica}">
                                <input class="diagnosticoClass" type="hidden" name="" value="${row.diagnostico}">
                            </div>
                        </div>`;
      },
    },
  ];

  let resultad = await executePetition(url + "/traerIdURSesion/", "GET");

  const asignarEventos = () => {
    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index")];
        alertConfirm(
          "Esta seguro de eliminar la hospitalización?",
          deleteHosp,
          data,
        );
      });
    });

    let aFacH = document.querySelectorAll(".btnFH");
    // aFacH
    for (const factH of aFacH) {
      factH.addEventListener("click", async function () {
        // para traer el valor del data index
        let index = this.getAttribute("data-index");
        editar(parseInt(index));
        let idHospit = this.getAttribute("data-id-hospitalizacion");
        let datos = await mostrarInf(parseInt(index));
        document.querySelector("#idH").value = idHospit;
        document.querySelector("#monto").value = datos[0];
        document.querySelector("#montoME").value = datos[1];
        document.querySelector("#total").value = datos[2];
        document.querySelector("#totalME").value = datos[3];
        clearStyleVInputs();
      });
    }

    const btnEditar = document.querySelectorAll(".editarH");
    btnEditar.forEach((btn) => {
      btn.addEventListener("click", function () {
        // Obtener el ID de la hospitalización
        let id = this.getAttribute("data-index");
        let fila = this.closest("tr");

        // Buscar el registro completo en dataH
        let hospit = dataH.find((data) => data.id_hospitalizacion == id);
        if (!hospit) {
          console.error("No se encontró la hospitalización");
          return;
        }

        dataInsumo = [];
        dataServices = [];
        insumosEliminados = [];
        servicesEliminados = [];
        nom_apell_paciente.innerText = `${hospit.nombre} ${hospit.apellido}`;
        idHptE.value = hospit.id_hospitalizacion;

        // Llenar campos del formulario
        historial_editar.value = hospit.historiaclinica || "";
        diagnostico_editar.value = hospit.diagnostico || "";

        //activar validacion del formulario
        const parametros = {
          labelModal: document.getElementById(
            "modalEditarHospitalizacionLabel",
          ),
          textLabelModal: "Editar hospitalización",
          form: formularioEditar,
          modal: formularioEditar.parentElement.parentElement.parentElement,
          btnModal: document.getElementById("btnEH"),
          btnTextModal: "Modificar",
          data: {
            historialE: hospit["historiaclinica"],
            diagnostico: hospit["diagnostico"],
          },
          inputs: document.querySelectorAll(".inputs-editar"),
          cedulaOculta: null,
          idOculto: null,
        };
        showDataModal(parametros);
        console.log(hospit);
        
        if (hospit.servicios && hospit.servicios.length > 0) {
          dataServices = hospit.servicios.map((serv) => ({
            id_servicioMedico: serv.id_servicioMedico,
            categoria: serv.categoria || "",
            doctor: (hospit.nombredoc || "") + " " + (hospit.apellidodoc || ""),
            precio: parseFloat(serv.precio || 0),
            precio_bolivares: parseFloat(serv.precio || 0) * valorDelDolar,
            cantidad: parseInt(serv.cantidad || 1),
          }));
          readServicesHosp(div_servicios_edit);
        } else {
          document.querySelector("#div-serviciosE").innerHTML = "";
        }
        if (hospit.servicios && hospit.servicios.length > 0) {
        }

        if (hospit.insumos && hospit.insumos.length > 0) {
          dataInsumo = hospit.insumos.map((ins) => ({
            ...ins,
            id_insumoDeHospitalizacion:
              ins.id_insumoDeHospitalizacion || ins.id_insumoDeHospitalizacion,
            precio: parseFloat(ins.precio || 0),
            precio_bolivares: parseFloat(ins.precio || 0) * valorDelDolar,
            cantidad: parseInt(ins.cantidad || 1),
            esNuevo: false, // existente
            modificado: false,
          }));
          readInsumosHosp(dataInsumo, div_insumos_edit);
        }
      });
    });

    document.querySelectorAll(".informacionH").forEach((inforH) => {
      inforH.addEventListener("click", function () {
        const idHospit = this.getAttribute("data-id-hospitalizacion");
        const registro = dataH.find((d) => d.id_hospitalizacion == idHospit);

        if (!registro) return;

        document.getElementById("nombreApellidoM").innerHTML =
          `${registro.nombre} ${registro.apellido}`;
        document.getElementById("cedulaM").innerHTML =
          `${registro.nacionalidad}-${registro.cedula}`;
        document.getElementById("diagnosticoM").innerHTML =
          registro.diagnostico;
        document.getElementById("doctorM").innerHTML =
          `${registro.nombredoc} ${registro.apellidodoc}`;
        document.getElementById("historiaM").innerHTML =
          registro.historiaclinica;

        mostrarInf(idHospit);
      });
    });

    // //////gestionar persmisos
    hasPermision(
      resultad["id_rol"],
      "Hospitalizacion",
      "guardar",
      ".btn-agregar-pacientes",
    ); //guardar
    hasPermision(resultad["id_rol"], "Hospitalizacion", "guardar", ".btnFH"); //guardar
    hasPermision(
      resultad["id_rol"],
      "Hospitalizacion",
      "eliminar",
      ".btn-eliminar",
    ); //eliminar
    hasPermision(
      resultad["id_rol"],
      "Hospitalizacion",
      "consultar",
      ".informacionH",
    ); //restablecer
    hasPermision(resultad["id_rol"], "Hospitalizacion", "editar", ".editarH"); //editar
  };
  initDataTable(
    selector,
    url + "/" + metodo,
    columnsHosp,
    (datosServer) => {
      console.log(datosServer);
      dataH = [];
      dataH.push(...datosServer);
    },
    asignarEventos,
  );

  await traerHoraCosto();
};

//agregar sericio al modal de hospitalizacion
const addServicesModal = (id_servicioMedico, modo = "agregar") => {
  const card = document.getElementById(`card-services${id_servicioMedico}`);
  if (!card) {
    console.error("No se encontró la tarjeta del insumo");
    return;
  }
  let categoria = card.querySelector(".categoria").innerText;
  let doctor = card.querySelector(".data-doctor").innerText;
  let precio = card.querySelector(".serv-usd").getAttribute("data-precio");
  const obj = {
    id_servicioMedico: id_servicioMedico,
    categoria: categoria,
    doctor: doctor,
    precio: parseFloat(precio).toFixed(2),
    precio_bolivares: (parseFloat(precio) * valorDelDolar).toFixed(2),
    cantidad: 1,
  };

  let existe = dataServices.find(
    (data) => data.id_servicioMedico == id_servicioMedico,
  );
  if (existe) {
    existe.cantidad++;
  } else {
    dataServices.push(obj);
  }
  modalAgregarServicios.hide();
  console.log(modo);
  let contenedor;
  if (modo === "agregar") {
    modalHospitGuardar.show();
    contenedor = div_services;
  } else {
    modalHospitEditar.show();
    contenedor = div_servicios_edit;
  }
  readServicesHosp(contenedor);
};

const addInsumosModal = (id_insumo, modo = "agregar") => {
  const card = document.getElementById(`card-insumos${id_insumo}`);
  if (!card) {
    console.error("No se encontró la tarjeta del insumo");
    return;
  }

  let nombre = card.getAttribute("data-name");
  let medida = card.getAttribute("data-medida");
  let precio = parseFloat(card.getAttribute("data-precio"));
  let cantidadInput = card.querySelector(`#input_card_insumo${id_insumo}`);
  let iva = parseInt(card.getAttribute("data-iva"));
  let cantidad_disponible = parseInt(card.getAttribute("data-cantidad"));

  if (!cantidadInput) {
    console.error("No se encontró el input de cantidad");
    return;
  }

  let cantidadSeleccionada = parseInt(cantidadInput.value) || 1;

  // Validar que no exceda el stock disponible
  if (cantidadSeleccionada > cantidad_disponible) {
    alertError(
      "Error",
      `Solo hay ${cantidad_disponible} unidades disponibles de ${nombre}`,
    );
    return;
  }

  const obj = {
    id_insumo: id_insumo,
    nombre: nombre,
    medida: medida,
    precio: precio,
    precio_bolivares: precio * valorDelDolar,
    cantidad: cantidadSeleccionada,
    cantidad_disponible: cantidad_disponible - cantidadSeleccionada,
    iva: iva,
    esNuevo: modo === "editar",
    modificado: false,
    id_insumoDeHospitalizacion: null,
  };

  let existente = dataInsumo.find((item) => item.id_insumo == id_insumo);
  if (existente) {
    existente.cantidad += obj.cantidad;
    existente.cantidad_disponible -= obj.cantidad;
    existente.precio_bolivares = existente.precio * valorDelDolar;
    if (modo === "editar") {
      existente.modificado = true;
      existente.esNuevo = true;
    }
  } else {
    if (modo === "editar") {
      obj.indice = dataInsumo.length;
      obj.id_insumoDeHospitalizacion = null;
    }
    dataInsumo.push(obj);
  }

  let insumoEnModal = dataInsumosModal.find(
    (item) => item.id_insumo == id_insumo,
  );
  if (insumoEnModal) {
    insumoEnModal.cantidad_disponible -= obj.cantidad;
  }

  modalAgregarInsumos.hide();

  if (modo === "agregar") {
    modalHospitGuardar.show();
    readInsumosHosp(dataInsumo, div_insumos);
  } else {
    modalHospitEditar.show();
    readInsumosHosp(dataInsumo, div_insumos_edit);
  }
};

//consultar servicios disponibles en el modal de servicios
const readServices = async (modo = "agregar") => {
  try {
    const paginator = new Paginator(
      dataServicesModal,
      1,
      "servicios",
      "pagination-services",
      "searchInputServices",
      returnFragmentServies,
      "id_servicioMedico",
      (id) => addServicesModal(id, modo),
    );

    paginator.displayItems();
  } catch (error) {
    alertError("Error", "error: " + error);
    console.log(error);
  }
};

//consultar insumos disponibles en el modal de insumos
const readInsumos = () => {
  const paginator = new Paginator(
    dataInsumosModal,
    2,
    "div-insumos-modal",
    "pagination-insumos",
    "searchInputInsumos",
    returnFragmentInsumos,
    "id_insumo",
    addInsumosModal,
  );

  paginator.displayItems();
};

//consultar servicios agregados en el modal de hospitalizacion
const readServicesHosp = (contenedor = div_services) => {
  if (!contenedor) {
    console.error("No existe el contenedor");
    return;
  }

  if (!dataServices || dataServices.length === 0) {
    contenedor.innerHTML = `<div class="col-12 text-center py-3">
            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
            No hay servicios agregados
        </div>`;
    return;
  }
  let html = "";
  dataServices.forEach((service, index) => {
    console.log(service.doctor);
    
    html += `
    <div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative servicioA"
    data-index="${service.id_servicioMedico}">
    <!-- Botón eliminar -->
    <button type="button"
        class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarServ"
        data-index="${index}" 
        style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
        ×
    </button>

    <!-- Tarjeta -->
    <a href="#"
        class="card text-decoration-none shadow-sm border-0 rounded-4"
        style="background: #f4f9ff61; transition: all 0.2s ease;">

        <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">
            <div class="fw-semibold text-dark mb-2 m-auto d-flex ">
                <p class="me-1 text-center cantidadServicio" style="font-size:1rem;">
                   ${service.cantidad}
                </p>
                <p class="" style="font-size:1rem;">
                    ${service.categoria}
                </p>
            </div>
            <p class="text-muted mb-1" style="font-size:0.9rem;">
                ${service.doctor}
            </p>
            <p class="fw-bold text-primary mb-0 precioS" style="font-size:0.95rem;">
                ${parseFloat(service.precio_bolivares).toFixed(2)} Bs <span class="text-muted fw-normal" style="font-size:0.8rem;">$ ${parseFloat(service.precio).toFixed(2)}</span>
            </p>

            <div>
                <input type="hidden" name="id_servicio[]" class=""
                    value="${service.id_servicioMedico}">
                <input type="hidden" name="cantidadS[]" class="cantidadServicioInput"
                    value="${service.cantidad}">
            </div>
        </div>
    </a>
</div>
    `;
  });

  contenedor.innerHTML = html;

  document.querySelectorAll(".eliminarServ").forEach((btn) => {
    btn.addEventListener("click", function () {
      let modo = btn.closest(".modal").getAttribute("data-modal");
      let contenedor_card =
        modo == "agregar" ? div_services : div_servicios_edit;
      dataServices.splice(parseInt(btn.getAttribute("data-index")), 1);
      readServicesHosp(contenedor_card);
    });
  });
};

const readInsumosHosp = (array, contenedor) => {
  if (!contenedor) {
    console.error("Contenedor no existe");
    return;
  }
  if (!array || array.length === 0) {
    contenedor.innerHTML = `<div class="col-12 text-center py-3">
            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
            No hay insumos agregados
        </div>`;
    return;
  }

  let html = "";
  array.forEach((insumo, index) => {
    const esExistente = !!insumo.id_insumoDeHospitalizacion;
    const esNuevo = insumo.esNuevo || false;

    html += `
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative insumo-item" data-index="${index}">
            <!-- Botón eliminar -->
            <button type="button"
                class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarInsumo"
                data-index="${index}"
                style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
                ×
            </button>

            <!-- Badge (Nuevo / Existente) -->
            <div class="position-absolute top-0 end-0 mt-2 me-2">
                ${esNuevo ? '<span class="badge bg-success">Nuevo</span>' : ""}
                ${esExistente && !esNuevo ? '<span class="badge bg-primary">Existente</span>' : ""}
            </div>

            <!-- Tarjeta (igual estructura que servicios) -->
            <div class="card text-decoration-none shadow-sm border-0 rounded-4"
                style="background: #f4f9ff61; transition: all 0.2s ease;">

                <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">

                    <!-- Nombre + cantidad -->
                    <div class="fw-semibold text-dark mb-2 m-auto d-flex align-items-center">
                        <p class="me-1 mb-0 text-center cantidadInsumo" style="font-size:1.2rem;">
                            ${insumo.cantidad}
                        </p>
                        <p class="mb-0 " style="font-size:1rem;">
                            ${insumo.nombre}
                        </p>
                    </div>

                    <!-- Medida y tipo IVA -->
                    <p class="text-muted mb-1" style="font-size:0.9rem;">
                        ${insumo.medida || "N/A"} 
                        <span class="badge bg-secondary ms-1">${insumo.iva ? "Con IVA" : "Sin IVA"}</span>
                    </p>

                    <!-- Precio -->
                    <p class="fw-bold text-primary mb-0 precioInsumo" style="font-size:0.95rem;">
                        ${insumo.precio_bolivares.toFixed(2)} Bs 
                        <span class="text-muted fw-normal" style="font-size:0.8rem;">($ ${insumo.precio.toFixed(2)})</span>
                    </p>

                    <!-- Inputs ocultos -->
                    <div>
                        ${
                          esExistente
                            ? `
                            <input type="hidden" name="id_idh[]" value="${insumo.id_insumoDeHospitalizacion}">
                            <input type="hidden" name="cantidad[]" value="${insumo.cantidad}">
                        `
                            : `
                            <input type="hidden" name="id_insumoA[]" value="${insumo.id_insumo}">
                            <input type="hidden" name="cantidadA[]" value="${insumo.cantidad}">
                        `
                        }
                        <input type="hidden" name="precioI[]" value="${insumo.precio}">
                    </div>
                </div>
            </div>
        </div>`;
  });

  contenedor.innerHTML = html;

  // Eventos de eliminación
  document.querySelectorAll(".eliminarInsumo").forEach((btn) => {
    btn.addEventListener("click", function () {
      const index = parseInt(this.getAttribute("data-index"));
      const insumoEliminado = array[index];
      if (!insumoEliminado) return;

      // Si es existente, guardar su ID para eliminarlo en backend
      if (insumoEliminado.id_insumoDeHospitalizacion) {
        insumosEliminados.push(insumoEliminado.id_insumoDeHospitalizacion);
      }

      // Devolver stock al modal de insumos
      const insumoEnModal = dataInsumosModal.find(
        (item) => item.id_insumo == insumoEliminado.id_insumo,
      );
      if (insumoEnModal) {
        insumoEnModal.cantidad_disponible += insumoEliminado.cantidad;
      }

      // Eliminar del array
      array.splice(index, 1);
      // Re-renderizar
      readInsumosHosp(array, contenedor);
    });
  });
};

//funcion para renderizar los insumo y meterlos en un array despues de la peticion para realizar las operaciones de manera mas facil
const renderizarInsumosAndSerivicos = async () => {
  try {
    dataInsumosModal = await executePetition(url + "/selectInsumos",'GET');
    dataServicesModal = await executePetition(url + "/selectServiciosD",'GET');
    console.log('----------------');
    
    console.log(dataServicesModal);
    
  } catch (error) {
    dataInsumosModal = [];
    dataServicesModal = [];
    console.log(error);
  }
};


//delete
const deleteHosp = async (data) => {
  try {
    const result = await executePetition(url + `/eliminaL/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      readHosp();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//create patiente
//create
const createPatients = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar",
      "POST",
      data,
    );
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      input_cedula.value = cedulaPaciente.value;
      input_cedula.dispatchEvent(new Event("keyup", { bubbles: true }));

      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("valido"));
      modalAgregarPaciente.hide();
      modalHospitGuardar.show();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createHosp = async (form) => {
  try {
    initLoaderButton(btnEnviar);
    const data = new FormData(form);
    let result = await executePetition(url + "/agregarH", "POST", data);
    if (result.ok) {
      alertSuccess(result.message);
      readHosp();
      modalHospitGuardar.hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(btnEnviar);
  }
};
//update
const updateHosp = async (form) => {
  try {
    initLoaderButton(btnEnviar);
    const data = new FormData(form);
    if (insumosEliminados && insumosEliminados.length > 0) {
      data.append("id_insumos_eliminados", JSON.stringify(insumosEliminados));
    }
    if (servicesEliminados && servicesEliminados.length > 0) {
      data.append(
        "id_servicios_eliminados",
        JSON.stringify(servicesEliminados),
      );
    }
    let result = await executePetition(url + "/modificarH", "POST", data);
    if (result.ok) {
      alertSuccess(result.message);
      readHosp();
      modalHospitEditar.hide();
      insumosEliminados = [];
      servicesEliminados = [];
    } else {
      throw new Error(result.error || "Error al modificar");
    }
  } catch (error) {
    alertError("Error", error.message || error);
    console.error(error);
  } finally {
    finallyLoaderButton(btnEnviar);
  }
};

renderizarInsumosAndSerivicos();
readHosp();

let verificarFormulario = inicializarValidacionFormulario(formularioAgregar);
let verificarFormularioEdit = inicializarValidacionFormulario(formularioEditar);
let verificarFormularioPaciente =
  inicializarValidacionFormulario(formAgregarPaciente);

//eventos
input_cedula.addEventListener("keyup", function () {
  if (this.value.length == 7 || this.value.length == 8) {
    search_paciente(this.value);
  }
});

//mostrar los servicios en el modal
btn_open_modal_services.forEach((btn) => {
  btn.addEventListener("click", function () {
    
    let modal = btn.closest(".modal");
    let modo = "agregar";

    if (modal) {
      // Detectar si estamos en modo editar
      if (
        modal.id === "modal-editar-hospitalizacion" ||
        modal.getAttribute("data-modal") === "editar"
      ) {
        modo = "editar";
        div_servicios_edit.setAttribute(
          "data-contenedor",
          "div-servicios-edit",
        );
      } else {
        div_servicios_edit.setAttribute("data-contenedor", "div-servicios");
      }
      div_servicios_edit.setAttribute("data-comportamiento", modo);
    }
    modoInsumoActual = modo;
    console.log(modo);

    const paginator = new Paginator(
      dataServicesModal,
      1,
      "servicios",
      "pagination-services",
      "searchInputServices",
      returnFragmentServies,
      "id_servicioMedico",
      (id) => addServicesModal(id, modo),
    );

    readServices(modo);
  });
});

btns_cargar_insumos.forEach((btn) => {
  btn.addEventListener("click", function () {
    let modal = btn.closest(".modal");
    let modo = "agregar";

    if (modal) {
      // Detectar si estamos en modo editar
      if (
        modal.id === "modal-editar-hospitalizacion" ||
        modal.getAttribute("data-modal") === "editar"
      ) {
        modo = "editar";
        div_insumos_modal.setAttribute("data-contenedor", "div-insumos-edit");
      } else {
        div_insumos_modal.setAttribute("data-contenedor", "div-insumos");
      }
      div_insumos_modal.setAttribute("data-comportamiento", modo);
    }

    modoInsumoActual = modo;
    const paginator = new Paginator(
      dataInsumosModal,
      2,
      "div-insumos-modal",
      "pagination-insumos",
      "searchInputInsumos",
      returnFragmentInsumos,
      "id_insumo",
      (id) => addInsumosModal(id, modo),
    );
    paginator.displayItems();
  });
});

btn_add_hosp.addEventListener("click", function () {
  dataInsumo.forEach((data) => {
    const obj = dataInsumosModal.find(
      (insumo) => insumo.id_insumo === data.id_insumo,
    );
    if (obj) {
      obj.cantidad_disponible += data.cantidad;
    }
  });

  dataInsumo = [];
  dataServices = [];
  insumosEliminados = [];
  servicesEliminados = [];
  readServicesHosp(div_services);
  readInsumosHosp(dataInsumo, div_insumos);
  resetForm(formularioAgregar);
});

btn_open_modal_paciente.addEventListener("click", function () {
  cedulaPaciente.value = input_cedula.value;
  cedulaPaciente.dispatchEvent(new Event("keyup", { bubbles: true }));
});

//enviar costo horas
formCostoHoras.addEventListener("submit", function (e) {
  e.preventDefault();
  enviarHoraCosto();
});

//guardar paciente

//enviar firmulario de paciente
formAgregarPaciente.addEventListener("submit", function (e) {
  e.preventDefault();

  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("valido"))
      inputsBuenos.push(true);
  });
  let esValido = verificarFormularioPaciente();
  if (esValido) {
    createPatients(this, inputsBuenos);
    return;
  }
  alertError(
    "Error",
    "Por favor verifique que todos los datos estén correctos.",
  );
});

//guardar
formularioAgregar.addEventListener("submit", function (e) {
  e.preventDefault();

  if (verificarFormulario()) {
    createHosp(this);
    return;
  }

  alertError(
    "Error",
    "Por favor verifique que todos los datos estén correctos.",
  );
});

//editar
formularioEditar.addEventListener("submit", function (e) {
  e.preventDefault();
  if (verificarFormularioEdit()) {
    updateHosp(this);
    return;
  }

  alertError(
    "Error",
    "Por favor verifique que todos los datos estén correctos.",
  );
});
