import {
  executePetition,
  alertConfirm,
  alertError,
  alertInfo,
  alertSuccess,
  initDataTable,
  cargarImg,
  showDataModal,
  hasPermision,
  initLoaderButton,
  finallyLoaderButton,
  clearModalEnviar,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Doctores";

let dataDoctor;
let tablaDoctores;
let especialidadesFiltro = [];
let paginaEspecialidades = 0;
const especialidadesPorPagina = 5;
const especialidadesSeleccionadas = new Set();

const modalGestionarEspecialidad = new bootstrap.Modal(
  document.getElementById("exampleModalConsultarEspecialidad"),
);
const modaAgregarEspecialidad = new bootstrap.Modal(
  document.getElementById("exampleModalAgregarEspecialidad"),
);

const openBtnModalEspecialidad = document.getElementById(
  "openBtnModalEspecialidad",
);

const exampleModalEspecialidad = document.getElementById(
  "exampleModalLabelEspec",
);
const btnModalEspecialidad = document.getElementById("btnModalEspecialidad");
const formDoctor = document.getElementById("modalAgregarDoctores");
const imagenDoctor = document.getElementById("imagenDoctor");
const contenedorImg = document.getElementById("contenedor-img");
const contenedorImgEditar = document.getElementById("contenedor-img-editar");
const cedulaRegistrada = document.getElementById("cedulaRegistrada");
const id_doctor = document.getElementById("id_doctor");
const inputs = formDoctor.querySelectorAll(".campo-editar");

const labelModal = document.getElementById("exampleModalLabelDoctores");
const btnModal = document.getElementById("botonModal");
const formEspecialidad = document.getElementById("formEspecialidad");

const selectDoctor = document.querySelector("#select-doctor");
const selectService = document.querySelector("#select-servicio");
const formAsignarServicio = document.getElementById("formAsignarServicio");
const modalAsignarServicio = new bootstrap.Modal(
  document.getElementById("modal-designar-servicio"),
);
const modalADoctor = new bootstrap.Modal(
  document.getElementById("exampleModalagregarDocotor"),
);

const divHorarios = document.getElementById("div-horarios");
const cajaDeInfo = document.getElementById("cajaDeInfo");
const pServicios = document.getElementById("p-servicios");
const btnagregarDoctor = document.getElementById("btnagregarDoctor");
const id_rol_global = document.getElementById("id_rol_global").value;
const inputsEspecialidad = formEspecialidad.querySelectorAll(".campo-editar");
const btnEspecialidades = document.getElementById("btnEspecialidades");

const urlActual = window.location.href;
console.log(urlActual);

//funcion para mostrar mas informacion del doctor
const info = (id_personal) => {
  let htmlHorario = "";
  let textServicios = "";

  const doctor = dataDoctor.find((item) => item.id_personal == id_personal);

  if (doctor) {
    if (Array.isArray(doctor.datosHorarios) && doctor.datosHorarios.length > 0) {
      doctor.datosHorarios.forEach((item) => {
        htmlHorario += `
    <!-- Nombre -->
                <div class="info-group mb-3">
                    <p class="fw-bold mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule azul mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                        </svg>
                        Dia:
                        <span class="parrafo ms-4 h6">${item.diaslaborables}</span>

                    </p>

                    <p class="fw-bold mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-capsule azul mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zm2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527z" />
                        </svg>
                        Horario:
                        <span class="parrafo ms-4 h6">${item.horaDeEntrada} a ${item.horaDeSalida}</span>

                    </p>
                </div>
    `;
      });
    } else {
      htmlHorario =
        '<h5 class="text-center">El doctor no tiene un horario disponible</h5>';
    }

    if (Array.isArray(doctor.servicios) && doctor.servicios.length > 0) {
      textServicios = doctor.servicios.map((item) => item.nombre).join(" ,  ");
    } else {
      textServicios = "De momento el doctor no ofrece ningun servicio";
    }
  } else {
    htmlHorario =
      '<h5 class="text-center">El doctor no tiene un horario disponible</h5>';
    textServicios = "De momento el doctor no ofrece ningun servicio";
  }
  cajaDeInfo.innerHTML = htmlHorario;
  pServicios.innerText = textServicios;
};

//funcion para mostrar los dias de la semana
const mostrarDiasSemana = async () => {
  try {
    const result = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Doctores/mostrarDiasSemana",
      "GET",
    );
    let html = "";
    if (result.length > 0) {
      result.forEach((element) => {
        html += ` <div class="col-md-6 mb-3" >
    <div class="card card-schedule p-3 h-100 shadow-sm border-0" style="background-color: var(--color-bg-card); border: 1px solid var(--color-primary);">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold text-dark">${element.diaslaborables}</span>
            <div class="form-check form-switch p-0 m-0">
                <input class="form-check-input day-toggle m-0" value="${element.id_horario}" type="checkbox"  style="width: 2.4em; height: 1.2em; cursor:pointer;">
            </div>
        </div>

        <div class="time-container mt-3">
            <div class="row g-2">
                <div class="col-6">
                    <label class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">ENTRADA</label>
                    <input type="time" class="form-control form-control-sm border-0 bg-light py-2 px-1 hora-entrada" step="60"
                           style="font-size: 0.8rem; min-height: auto;" value="">
                </div>
                <div class="col-6">
                    <label class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">SALIDA</label>
                    <input type="time" class="form-control form-control-sm border-0 bg-light py-2 px-1 hora-salida" step="60"
                           style="font-size: 0.8rem; min-height: auto;" value="">
                </div>
            </div>
        </div>

        <div class="rest-badge mt-2 text-center py-2 rounded-3 bg-light text-muted small" style="display: none;">
            <i class="bi bi-moon-stars me-1"></i> Día de descanso
        </div>
    </div>
</div>`;
      });
    } else {
      html = `<div class="col-12">
        <div class="alert alert-warning text-center">
          No hay días laborables registrados.
        </div>
      </div>`;
    }
    divHorarios.innerHTML = html;
  } catch (error) {
    alertError("Error", error);
    console.log(error);
  }
};

/**
 * Aplica el estado visual y los name de un día según esté marcado o no.
 * Solo los días marcados envían sus datos al servidor, por eso el name del
 * checkbox y de las horas se agrega/quita aquí en un único lugar.
 */
const sincronizarDia = (checkbox) => {
  const card = checkbox.closest(".card-schedule");
  if (!card) return;

  const timeContainer = card.querySelector(".time-container");
  const restBadge = card.querySelector(".rest-badge");
  const inputEntrada = card.querySelector(".hora-entrada");
  const inputSalida = card.querySelector(".hora-salida");

  if (checkbox.checked) {
    checkbox.setAttribute("name", "dias[]");
    inputEntrada.setAttribute("name", "horaEntrada[]");
    inputSalida.setAttribute("name", "horaSalida[]");

    timeContainer.style.display = "block";
    restBadge.style.display = "none";
    card.style.opacity = "1";
  } else {
    checkbox.removeAttribute("name");
    inputEntrada.removeAttribute("name");
    inputSalida.removeAttribute("name");

    timeContainer.style.display = "none";
    restBadge.style.display = "block";
    card.style.opacity = "0.8";
  }
};

/** Marca o desmarca todos los días y deja el bloque de horario en su estado inicial */
const resetearHorarios = () => {
  divHorarios.querySelectorAll(".day-toggle").forEach((checkbox) => {
    checkbox.checked = false;
    const card = checkbox.closest(".card-schedule");
    card.querySelector(".hora-entrada").value = "";
    card.querySelector(".hora-salida").value = "";
    sincronizarDia(checkbox);
  });
};

//read
const readDoctor = async () => {
  try {
    let metodo = "";

    if (!urlActual.includes("papelera")) metodo = "DoctoresAjax";
    else metodo = "papeleraDoctoresAjax";

    const esPapelera = urlActual.includes("papelera");
    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    const columnsDoctores = [
      {
        data: "cedula",
        render: (data, type, row) => `${row.nacionalidad}-${data}`,
      },
      { data: "nombre_d" },
      { data: "apellido" },
      { data: "telefono" },
      { data: "correo" },
      { data: "nombre" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return `
            <!-- editar -->

                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi btn-dt-tabla ${
                                      urlActual.includes("papelera")
                                        ? "d-none"
                                        : ""
                                    }"
                                       data-bs-toggle="modal" data-bs-target="#exampleModalagregarDocotor"
                                        data-especialidad=${row.id_especialidad} data-index-usuario=${row.id_usuario} data-index="${row.id_personal}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer ${
                                      !urlActual.includes("papelera")
                                        ? "d-none"
                                        : ""
                                    }" data-index=${row.id_usuario}>


                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>


                                    </button>

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar ${
                                      urlActual.includes("papelera")
                                        ? "d-none"
                                        : ""
                                    }" data-index=${row.id_usuario}>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>

                                    </button>

                             
                                <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla" title="Horarios Del Doctor"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalInfoDoctor"
                                    data-index="${row.id_personal}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
      `;
        },
      },
    ];

    const asignarEventos = () => {
      //llamar las funcion de eliminar
      if (document.querySelectorAll(".btn-eliminar")) {
        document.querySelectorAll(".btn-eliminar").forEach((btn) => {
          btn.addEventListener("click", function () {
            const data = [this.getAttribute("data-index"),0];
            alertConfirm(
              "Esta seguro de eliminar el doctor?",
              deleteDoctor,
              data,
            );
          });
        });
      }

      if (document.querySelectorAll(".btnRestablecer")) {
        document.querySelectorAll(".btnRestablecer").forEach((btn) => {
          btn.addEventListener("click", function () {
            console.log(btn);

            const data = [this.getAttribute("data-index"),1];
            console.log(data);

            alertConfirm(
              "Esta seguro de restablecer el doctor?",
              deleteDoctor,
              data,
            );
          });
        });
      }

      ///informacion del doctro
      document.querySelectorAll(".botonesInfo").forEach((btn) => {
        btn.addEventListener("click", function () {
          info(this.getAttribute("data-index"));
        });
      });

      let srcImg = "";

      //llamar a la uncion de editar
      document.querySelectorAll(".botonesEdi").forEach((btn) => {
        btn.addEventListener("click", async function () {
          let tr = btn.closest("tr");

          //los días laborables se cargan de forma asíncrona: esperamos a que
          //estén en el DOM para poder marcar los que el doctor ya tiene
          await promesaDiasCargados;

          inputs[1].value = parseInt(tr.children[0].innerText.slice(2));
          inputs[2].value = tr.children[1].innerText;
          inputs[3].value = tr.children[2].innerText;
          inputs[4].value = tr.children[3].innerText;
          inputs[5].value = tr.children[4].innerText;
          inputs[6].value = btn.getAttribute("data-especialidad");

          cedulaRegistrada.value = parseInt(tr.children[0].innerText.slice(2));
          id_doctor.value = btn.getAttribute("data-index-usuario");

          formDoctor.querySelectorAll(".input-validar").forEach((inp) => {
            let divParent = inp.closest(".campo-custom");
            // se activa la validacion con todos excepto con el inputt de la imagen

            if (!inp.classList.contains("campo-editar")) {
              divParent.classList.add("d-none");

              //le coloco d-none a los label tambien
              divParent.previousElementSibling.classList.add("d-none");
              inp.parentElement.classList.add("valido");
            } else {
              if (inp.getAttribute("type") == "file") {
                inp.parentElement.classList.add("valido");
                // divParent.classList.add("valido");
              } else {
                inp.dispatchEvent(new Event("keyup", { bubbles: true }));
              }
            }
          });

          contenedorImg.classList.add("d-none");
          //ahora gestionar la imagen del insumo es decir mostrar un previsualizacion en el modal de editar
          contenedorImgEditar.classList.remove("d-none");
          imgEditar.setAttribute(
            "src",
            `../src/assets/images/img_ingresadas_por_usuarios/insumos/${srcImg}`,
          );

          //el id_personal viene hasheado, por eso se compara como texto
          //(parseInt sobre un hash daría NaN y no encontraría al doctor)
          const id_personal = btn.getAttribute("data-index");

          const doctor = dataDoctor.find(
            (doc) => String(doc.id_personal) === String(id_personal),
          );

          //id_horario viene hasheado, por eso se compara como texto (Number() daría NaN)
          const horariosActuales = {};
          if (doctor && Array.isArray(doctor.datosHorarios)) {
            doctor.datosHorarios.forEach((horario) => {
              horariosActuales[String(horario.id_horario)] = horario;
            });
          }

          //marcamos solo los días que el doctor ya tiene asignados y cargamos sus horas
          formDoctor.querySelectorAll(".day-toggle").forEach((checkbox) => {
            const horarioGuardado = horariosActuales[String(checkbox.value)];
            const card = checkbox.closest(".card-schedule");
            const inputEntrada = card.querySelector(".hora-entrada");
            const inputSalida = card.querySelector(".hora-salida");

            if (horarioGuardado) {
              checkbox.checked = true;
              inputEntrada.value = horarioGuardado.horaDeEntrada;
              inputSalida.value = horarioGuardado.horaDeSalida;
            } else {
              checkbox.checked = false;
              inputEntrada.value = "";
              inputSalida.value = "";
            }

            //igual que al crear: los días marcados envían sus horas, los demás no
            sincronizarDia(checkbox);
          });

          labelModal.innerText = "Modificar Doctor";
          btnModal.innerText = "Modificar";
          contenedorImgEditar.classList.add("d-none");
          formDoctor.classList.add("editar");
        });
      });

      //////gestionar persmisos
      hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModal"); //guardar doctor
      hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModalSer"); //guardar servicio
      hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModalEsp"); //guardar especialidad

      hasPermision(id_rol_global, "Doctores", "eliminar", ".btn-eliminar"); //eliminar
      hasPermision(id_rol_global, "Doctores", "eliminar", ".btnRestablecer"); //restablecer
      hasPermision(id_rol_global, "Doctores", "editar", ".botonesEdi"); //editar
    };

    const doctores = esPapelera
      ? null
      : await cargarTodosLosDoctores(`${url}/${metodo}`);
    if (!esPapelera) dataDoctor = doctores;

    // La ruta existente pagina en el servidor; se recorren sus páginas una vez
    // para que el filtro de especialidad pueda aplicarse sobre todo el directorio.
    tablaDoctores = initDataTable(
      selector,
      `${url}/${metodo}`,
      columnsDoctores,
      (datosServer) => {
        if (esPapelera) dataDoctor = datosServer;
      },
      asignarEventos,
      esPapelera
        ? {}
        : {
            dataTable: {
              serverSide: false,
              ajax: null,
              data: doctores,
              deferRender: true,
            },
          },
    );

    if (!esPapelera) {
      inicializarFiltroEspecialidades();
      await actualizarFiltroEspecialidades();
    }

    console.log("cargada...");
  } catch (error) {
    alertError("Error", error);
    console.log(error);
  }
};

const cargarTodosLosDoctores = async (endpoint) => {
  const tamanoPagina = 100;

  const solicitarPagina = async (inicio) => {
    const parametros = new URLSearchParams({
      draw: "1",
      start: String(inicio),
      length: String(tamanoPagina),
      "search[value]": "",
    });
    const response = await fetch(`${endpoint}?${parametros.toString()}`, {
      headers: { Accept: "application/json" },
    });

    if (!response.ok) {
      throw new Error(`No se pudo cargar el directorio (HTTP ${response.status}).`);
    }

    const resultado = await response.json();
    if (
      !Array.isArray(resultado.data) ||
      !Number.isFinite(Number(resultado.recordsTotal))
    ) {
      throw new Error("La respuesta del directorio tiene un formato inválido.");
    }

    return resultado;
  };

  const primeraPagina = await solicitarPagina(0);
  const doctores = [...primeraPagina.data];
  const totalDoctores = Number(primeraPagina.recordsTotal);

  for (
    let inicio = doctores.length;
    inicio < totalDoctores;
    inicio += tamanoPagina
  ) {
    const pagina = await solicitarPagina(inicio);
    if (pagina.data.length === 0) {
      throw new Error("No se pudieron cargar todos los doctores del directorio.");
    }
    doctores.push(...pagina.data);
  }

  if (doctores.length !== totalDoctores) {
    throw new Error(
      "El directorio recibido está incompleto. Intenta actualizar la página.",
    );
  }

  return doctores;
};

const inicializarFiltroEspecialidades = () => {
  const seccion = document.querySelector(".filtro-especialidades");
  if (!seccion || seccion.dataset.inicializado === "true") return;

  seccion.dataset.inicializado = "true";
  const toggle = seccion.querySelector(".filtro-especialidades__toggle");
  const contenido = seccion.querySelector(".filtro-especialidades__contenido");
  const botones = seccion.querySelector(".filtro-especialidades__botones");

  toggle.addEventListener("click", () => {
    const expandido = toggle.getAttribute("aria-expanded") === "true";
    toggle.setAttribute("aria-expanded", String(!expandido));
    toggle.textContent = expandido ? "Mostrar filtros" : "Ocultar filtros";
    contenido.hidden = expandido;
  });

  botones.addEventListener("click", (event) => {
    const boton = event.target.closest(".filtro-especialidad");
    if (!boton || !botones.contains(boton)) return;

    const idEspecialidad = boton.dataset.especialidad;
    if (!idEspecialidad) {
      especialidadesSeleccionadas.clear();
    } else if (especialidadesSeleccionadas.has(idEspecialidad)) {
      especialidadesSeleccionadas.delete(idEspecialidad);
    } else {
      especialidadesSeleccionadas.add(idEspecialidad);
    }

    renderizarBotonesEspecialidades();
    aplicarFiltroEspecialidad();
  });

  seccion.querySelectorAll(".filtro-pagina").forEach((boton) => {
    boton.addEventListener("click", () => {
      paginaEspecialidades += Number(boton.dataset.direccion);
      renderizarBotonesEspecialidades();
    });
  });
};

const actualizarFiltroEspecialidades = async () => {
  const endpoint = `${url}/selectEspcAjax`;
  const tamanoPagina = 100;

  try {
    const solicitarPagina = async (inicio) => {
      const parametros = new URLSearchParams({
        draw: "1",
        start: String(inicio),
        length: String(tamanoPagina),
        "search[value]": "",
      });
      const response = await fetch(`${endpoint}?${parametros.toString()}`, {
        headers: { Accept: "application/json" },
      });

      if (!response.ok) {
        throw new Error(`No se pudieron actualizar las especialidades (HTTP ${response.status}).`);
      }

      const resultado = await response.json();
      if (
        !Array.isArray(resultado.data) ||
        !Number.isFinite(Number(resultado.recordsTotal))
      ) {
        throw new Error("La respuesta de especialidades tiene un formato inválido.");
      }

      return resultado;
    };

    const primeraPagina = await solicitarPagina(0);
    const especialidades = [...primeraPagina.data];
    const totalEspecialidades = Number(primeraPagina.recordsTotal);

    for (
      let inicio = especialidades.length;
      inicio < totalEspecialidades;
      inicio += tamanoPagina
    ) {
      const pagina = await solicitarPagina(inicio);
      if (pagina.data.length === 0) {
        throw new Error("La lista de especialidades recibida está incompleta.");
      }
      especialidades.push(...pagina.data);
    }

    if (especialidades.length !== totalEspecialidades) {
      throw new Error("La lista de especialidades recibida está incompleta.");
    }

    especialidadesFiltro = especialidades;
    const idsDisponibles = new Set(
      especialidades.map((especialidad) => String(especialidad.id_especialidad)),
    );
    especialidadesSeleccionadas.forEach((id) => {
      if (!idsDisponibles.has(id)) especialidadesSeleccionadas.delete(id);
    });

    const paginas = Math.max(
      1,
      Math.ceil(especialidadesFiltro.length / especialidadesPorPagina),
    );
    paginaEspecialidades = Math.min(paginaEspecialidades, paginas - 1);
    renderizarBotonesEspecialidades();
    aplicarFiltroEspecialidad();
  } catch (error) {
    alertError("Error", error.message);
    console.error(error);
  }
};

const renderizarBotonesEspecialidades = () => {
  const seccion = document.querySelector(".filtro-especialidades");
  if (!seccion) return;

  const contenedor = seccion.querySelector(".filtro-especialidades__botones");
  const inicio = paginaEspecialidades * especialidadesPorPagina;
  const visibles = especialidadesFiltro.slice(
    inicio,
    inicio + especialidadesPorPagina,
  );
  const fragmento = document.createDocumentFragment();
  const botonTodas = document.createElement("button");
  botonTodas.className = "filtro-especialidad";
  botonTodas.type = "button";
  botonTodas.dataset.especialidad = "";
  botonTodas.setAttribute(
    "aria-pressed",
    String(especialidadesSeleccionadas.size === 0),
  );
  botonTodas.classList.toggle("is-active", especialidadesSeleccionadas.size === 0);
  botonTodas.textContent = "Todas";
  fragmento.appendChild(botonTodas);

  visibles.forEach((especialidad) => {
    const boton = document.createElement("button");
    const id = String(especialidad.id_especialidad);
    const seleccionado = especialidadesSeleccionadas.has(id);
    boton.className = "filtro-especialidad";
    boton.type = "button";
    boton.dataset.especialidad = id;
    boton.setAttribute("aria-pressed", String(seleccionado));
    boton.classList.toggle("is-active", seleccionado);
    boton.textContent = especialidad.nombre;
    fragmento.appendChild(boton);
  });

  contenedor.replaceChildren(fragmento);

  const paginas = Math.max(
    1,
    Math.ceil(especialidadesFiltro.length / especialidadesPorPagina),
  );
  const controles = seccion.querySelector(".filtro-especialidades__controles");
  controles.classList.toggle("d-none", paginas <= 1);
  seccion.querySelector(".filtro-especialidades__pagina").textContent =
    `Página ${paginaEspecialidades + 1} de ${paginas}`;
  seccion.querySelector(".filtro-especialidades__estado").textContent =
    especialidadesSeleccionadas.size === 0
      ? `${especialidadesFiltro.length} especialidades disponibles`
      : `${especialidadesSeleccionadas.size} especialidad(es) seleccionada(s)`;
  seccion.querySelectorAll(".filtro-pagina").forEach((boton) => {
    boton.disabled =
      boton.dataset.direccion === "-1"
        ? paginaEspecialidades === 0
        : paginaEspecialidades >= paginas - 1;
  });
};

const aplicarFiltroEspecialidad = () => {
  if (!tablaDoctores || !Array.isArray(dataDoctor)) return;

  const doctoresFiltrados = especialidadesSeleccionadas.size
    ? dataDoctor.filter((doctor) =>
        especialidadesSeleccionadas.has(String(doctor.id_especialidad)),
      )
    : dataDoctor;

  tablaDoctores.clear().rows.add(doctoresFiltrados).draw();
};

//read
const readEspecialidad = async () => {
  try {
    const selector = ".exampleTable2";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }
    const columsEspecialidades = [
      {
        data: null,
        render: function (data, type, row, meta) {
          // Genera el número de fila real tomando en cuenta la paginación actual
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      { data: "nombre" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return `
           <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar-epe" data-index="${row.id_especialidad}" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                  </button>
      `;
        },
      },
    ];

    const asignarEventosEspecialidad = () => {
      //llamar las funcion de eliminar
      document.querySelectorAll(".btn-eliminar-epe").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            0,
          ];
          alertConfirm(
            "Esta seguro de eliminar la especialidad?",
            deleteEspecialidad,
            data,
          );
        });
      });
    };

    // re-inicializa
    initDataTable(
      selector,
      `${url}/selectEspcAjax`,
      columsEspecialidades,
      (datosServer) => {
        console.log(datosServer);
      },
      asignarEventosEspecialidad,
    );
    console.log("cargada...");
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createDoctor = async (form) => {
  try {
    initLoaderButton(btnModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/agregarDoctor", "POST", data);
    if (result.ok) {
      alertSuccess(result.message);
      modalADoctor.hide();
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(btnModal);
  }
};

//delete
const deleteDoctor = async (data) => {
  try {
    const payload = { id: data[0], estado: data[1] };
        const result = await executePetition(
          url + `/borrarDoctor`,
          "POST",
          payload,
        );
    if (result.ok) {
      alertSuccess(result.message);
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updateDoctor = async (form) => {
  try {
    initLoaderButton(btnModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/editarDoctor", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalADoctor.hide();
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  } finally {
    finallyLoaderButton(btnModal);
  }
};

//delete
const deleteEspecialidad = async (data) => {
  try {
    const payload = { id: data[0], estado: data[1] };
    const result = await executePetition(
      `/Sistema-del--CEM--JEHOVA-RAFA/Doctores/eliminarEspecialidad`,
      "POST",
      payload
    );
    if (result.ok) {
      alertSuccess(result.message);
      readEspecialidad();
      await actualizarFiltroEspecialidades();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//create especialida
const createEspecialidad = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      url + "/registrarEspecialidad",
      "POST",
      data,
    );
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modaAgregarEspecialidad.hide();
      modalGestionarEspecialidad.show();
      readEspecialidad();
      await actualizarFiltroEspecialidades();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};


//asignar servicio
const asignarServicio = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      url + "/asignarServicioDoctor",
      "POST",
      data,
    );
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalAsignarServicio.hide();
      readDoctor();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//funcion para llenar los selects de doctor y servicio
const traerServicioAndDoctor = async () => {
  try {
    const result = await executePetition(`${url}/serviciosDoctor`, "GET");
    console.log(result);

    let htmlDoc = `<option class="option-select-background" selected="" value="">Seleccionar Doctor</option>`;
    let htmlSer = `<option class="option-select-background" selected="" value="">Seleccionar Servicio  Medico</option>`;

    //doctores
    for (const res of result[0]) {
      console.log(res);
      htmlDoc += `<option class="option-select-background" name="id_doctor" value="${res.id_personal}">Dr: ${res.nombre_d} ${res.apellido}</option>`;
    }

    //servicio
    for (const res of result[1]) {
      console.log(res);
      htmlSer += `<option class="option-select-background" name='id_categoria' value="${res.id_categoria}">${res.nombre}</option>`;
    }

    selectDoctor.innerHTML = htmlDoc;
    selectService.innerHTML = htmlSer;
  } catch (error) {
    console.log(error);
  }
};

traerServicioAndDoctor();
readDoctor();

btnEspecialidades.addEventListener("click", function () {
  readEspecialidad();
});

openBtnModalEspecialidad.addEventListener("click", function () {
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalEspecialidad,
    textLabelModal: "Registrar Patologia",
    form: formEspecialidad,
    modal: formEspecialidad.parentElement.parentElement.parentElement,
    btnModal: btnModalEspecialidad,
    btnTextModal: "Registrar",
    inputs: inputsEspecialidad,
  };
  clearModalEnviar(parametros);
});

//cargamos los días y los dejamos todos en estado "descanso" hasta que se marque
//alguno. Guardamos la promesa para que el modal de editar la reutilice: así no
//se dispara una segunda petición que borraría los checks ya precargados
var promesaDiasCargados = mostrarDiasSemana().then(() => resetearHorarios());

divHorarios.addEventListener("change", (e) => {
  const objetivo = e.target;

  // 1) se marcó/desmarcó un día
  if (objetivo.classList.contains("day-toggle")) {
    const card = objetivo.closest(".card-schedule");

    // 2) VALIDACIÓN: AL MENOS UN DÍA ACTIVO
    const diasActivos = divHorarios.querySelectorAll(".day-toggle:checked");
    if (!objetivo.checked && diasActivos.length === 0) {
      alertInfo(
        "Información",
        "Debe mantener al menos un día de trabajo seleccionado.",
      );
      objetivo.checked = true;
    }

    //el estado visual y los name se aplican siempre, tras validar
    sincronizarDia(objetivo);

    if (objetivo.checked) {
      validarBloquesCompletos(card);
    }
    return;
  }

  // 3) se modificaron las horas manualmente
  if (objetivo.type === "time") {
    validarBloquesCompletos(objetivo.closest(".card-schedule"));
  }
});

/**
 * Convierte "HH:MM" a minutos totales del día.
 * Devuelve null si el valor no tiene un formato válido.
 */
const horaEnMinutos = (hora) => {
  if (!/^([01][0-9]|2[0-3]):[0-5][0-9]$/.test(hora)) return null;
  const [h, m] = hora.split(":").map(Number);
  return h * 60 + m;
};

/** Convierte minutos totales del día a "HH:MM" (recortado a 23:59) */
const minutosEnHora = (minutos) => {
  const tope = Math.min(Math.max(minutos, 0), 23 * 60 + 59);
  const h = Math.floor(tope / 60);
  const m = tope % 60;
  return `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
};

function validarBloquesCompletos(card) {
  if (!card) return;

  const inputEntrada = card.querySelector(".hora-entrada");
  const inputSalida = card.querySelector(".hora-salida");

  if (!inputEntrada.value || !inputSalida.value) return; //aún falta completar

  const entrada = horaEnMinutos(inputEntrada.value);
  const salida = horaEnMinutos(inputSalida.value);

  if (entrada === null || salida === null) return;

  //REGLA: la salida debe ser al menos 1 hora después de la entrada.
  //Se compara en minutos (no en horas) para que también funcione con
  //horas que llevan minutos, por ejemplo 13:20 -> 14:10 son 50 minutos.
  if (salida - entrada < 60) {
    alertInfo(
      "Información",
      "El horario de salida debe ser al menos 1 hora después de la entrada.",
    );
    //se corrige sumando 60 minutos exactos a la hora de entrada
    inputSalida.value = minutosEnHora(entrada + 60);
  }
}

/**
 * Valida que todos los días marcados tengan su par de horas completo.
 * Devuelve true si el bloque de horario está listo para enviarse.
 */
const validarHorariosCompletos = () => {
  const marcados = divHorarios.querySelectorAll(".day-toggle:checked");

  if (marcados.length === 0) {
    alertError("Horario", "Debe seleccionar al menos un día laborable.");
    return false;
  }

  for (const checkbox of marcados) {
    const card = checkbox.closest(".card-schedule");
    const nombreDia = card.querySelector(".fw-bold").innerText.trim();
    const inputEntrada = card.querySelector(".hora-entrada");
    const inputSalida = card.querySelector(".hora-salida");

    //se reafirma el estado para garantizar que solo lo marcado se envía
    sincronizarDia(checkbox);

    if (!inputEntrada.value || !inputSalida.value) {
      alertError(
        "Horario",
        `Complete la hora de entrada y de salida del día ${nombreDia}.`,
      );
      return false;
    }

    //refuerzo de la regla de duración justo antes de enviar
    const entrada = horaEnMinutos(inputEntrada.value);
    const salida = horaEnMinutos(inputSalida.value);

    if (entrada === null || salida === null) {
      alertError(
        "Horario",
        `La hora del día ${nombreDia} no es válida.`,
      );
      return false;
    }

    if (salida - entrada < 60) {
      alertError(
        "Horario",
        `En el día ${nombreDia} la salida debe ser al menos 1 hora después de la entrada.`,
      );
      return false;
    }
  }

  return true;
};

//funcion para limpiar el formulario
btnagregarDoctor.addEventListener("click", function () {
  formDoctor.querySelectorAll(".input-validar").forEach((ele) => {
    let divParent = ele.closest(".campo-custom");
    divParent
      .querySelector(".input-custom")
      .classList.remove("valido", "invalido");
    divParent.querySelector(".check").classList.add("d-none");
    divParent.querySelector(".error").classList.add("d-none");
    divParent.querySelector(".error-msg").classList.add("d-none");

    ele.value = "";
  });
  labelModal.innerText = "Registrar Doctor";
  btnModal.innerText = "Registrar";
  contenedorImgEditar.classList.add("d-none");
  contenedorImg.classList.remove("d-none");
  formDoctor.classList.remove("editar");

  //los horarios del doctor anterior no deben arrastrarse al registrar uno nuevo
  resetearHorarios();
});

imagenDoctor.addEventListener("change", function (e) {
  let newImg = `<img  style="height: 200px;width: 100%;" src=''>`;

  contenedorImg.classList.remove("d-none");
  contenedorImgEditar.classList.add("d-none");
  cargarImg(this.files, newImg, contenedorImg);
});

let verificarFormulario = inicializarValidacionFormulario(formDoctor);
let verificarFormularioEsp = inicializarValidacionFormulario(formEspecialidad);
let verifcarFormAsignar = inicializarValidacionFormulario(formAsignarServicio);

formDoctor.addEventListener("submit", function (e) {
  e.preventDefault();

  //el horario se valida primero: es lo más común que falte y evita un envío inútil
  if (!validarHorariosCompletos()) return;

  let esValido = verificarFormulario();
  console.log(esValido);
  

  if (esValido) {
    if (formDoctor.classList.contains("editar")) {
      updateDoctor(this);
    } else {
      createDoctor(this);
    }
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});

formEspecialidad.addEventListener("submit", function (e) {
  e.preventDefault();

  let esValido = verificarFormularioEsp();

  if (esValido) {
    console.log("guardar");
    createEspecialidad(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});

formAsignarServicio.addEventListener("submit", function (e) {
  e.preventDefault();

  let esValido = verifcarFormAsignar();

  if (esValido) {
    console.log("guardar");
    asignarServicio(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
