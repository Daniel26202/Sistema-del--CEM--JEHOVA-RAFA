import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "./generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";

/**
 * Escapa los datos que llegan del servidor antes de insertarlos con innerHTML.
 * Los nombres, cédulas y conceptos son datos de usuario y no deben ejecutarse
 * como HTML en el modal de facturas.
 */
const escapeHtml = (valor) =>
  String(valor ?? "").replace(/[&<>"']/g, (caracter) => {
    const mapa = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
    };
    return mapa[caracter];
  });

addEventListener("DOMContentLoaded", function () {
  console.log("Reportes...");

  //constante de entradas de insumos

  const checkboxEntradas = document.getElementById("checkboxEntradas");
  const cajaModalEntradas = document.getElementById("cajaModalEntradas");
  const botonDeImprimirEntradas = document.getElementById(
    "botonDeImprimirEntradas",
  );
  const selectInsumoEntradas = document.getElementById("selectInsumoEntradas");
  const formularioEntradas = document.getElementById("formularioEntradas");
  const cajaCheckboxEntrada = document.getElementById("cajaCheckboxEntrada");

  const cardFactura = document.getElementById("cardFactura");
  const dataCardFactura = document.getElementById("data-card-factura");
  const dataCardServicio = document.getElementById("data-card-servicio");
  const dataCardInsumos = document.getElementById("data-card-insumos");
  const dataCardPagos = document.getElementById("data-card-pagos");

  const btnImprimirFactura = document.getElementById("btn-imprimir-factura");
  const btnModalFactura = document.getElementById("btn-modal-factura");
  const titleModalFactura = document.getElementById("titleModalFactura");

  const formularioCita = document.getElementById("formularioCita");

  const selector = ".exampleTableFactura";

  let dataFactura = [];

  //funcion para llenar el array con todos los datos de la factura
  const loadDataFactura = async () => {
    const result = await executePetition(
      `/Sistema-del--CEM--JEHOVA-RAFA/Reportes/returnDataFactura`,
      "GET",
    );

    if (!Array.isArray(result)) {
      throw new Error(result?.error || "No se pudieron cargar las facturas.");
    }

    dataFactura = result;
  };

  //functions for factura
  const readFacturas = async (estado = "ACT") => {
    try {
      // Se recarga en cada apertura/cambio de vista para que una factura
      // recién anulada aparezca de inmediato en la lista correcta.
      await loadDataFactura();

      let html = "";
      const dataFiltrada = dataFactura.filter((data) => data.estado == estado);

      dataFiltrada.forEach((res) => {
        const idFactura = escapeHtml(res.id_factura);
        // El hash sigue siendo la clave de los botones y de las URL; el
        // número legible es solo el texto que ve el usuario.
        const numeroFactura = escapeHtml(
          res.numero_factura || res.id_factura,
        );
        const cedula = escapeHtml(`${res.nacionalidad}-${res.cedula_p}`);
        const paciente = escapeHtml(`${res.nombre_p}-${res.apellido_p}`);
        const fecha = escapeHtml(res.fecha);
        const total = escapeHtml(res.total);
        const botonAnular =
          estado === "ACT"
            ? `<button class="btn btn-tabla mb-1 btn-dt-tabla btn-anular" data-index="${idFactura}" title="Anular factura">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                  </svg>
                </button>`
            : "";

        html += `<tr>
                            <td class="text-center">${numeroFactura}</td>
                            <td class="text-center">${cedula}</td>
                            <td class="text-center">${paciente}</td>
                            <td class="text-center">${fecha}</td>
                            <td class="text-center">${total} Bs</td>

                            <td class="text-center">

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-info"
                                        data-index="${idFactura}" data-bs-toggle="modal" data-bs-target="#modal-info-factura"
                                        title="Ver información de la factura">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                    </svg>
                                    </button>

                                    ${botonAnular}

                            </td>

                        </tr>`;
      });

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
      }
      // vuelca el html en el tbody
      document.querySelector(selector + " tbody").innerHTML = html;

      //llamar las funcion de ver informacion
      document.querySelectorAll(".btn-info").forEach((btn) => {
        btn.addEventListener("click", function () {
          let id = this.getAttribute("data-index");
          readInfoFactura(id);
        });
      });

      //llamar las funcion de anular factura
      document.querySelectorAll(".btn-anular").forEach((btn) => {
        btn.addEventListener("click", function () {
          const idFactura = this.getAttribute("data-index");
          alertConfirm(
            "Esta seguro de anular la factura?",
            anularFactura,
            idFactura,
          );
        });
      });

      // La tabla se arma en el cliente: el endpoint devuelve un arreglo plano,
      // no el formato server-side de DataTables. Si se inicializaba con
      // serverSide:true la tabla quedaba en "Cargando Registros..." y no
      // mostraba ni las facturas activas ni las anuladas.
      $(selector).DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [],
        columnDefs: [{ targets: -1, className: "all" }],
        language: {
          decimal: ",",
          thousands: ".",
          lengthMenu: "Mostrar por página _MENU_",
          zeroRecords: "No se encontraron facturas",
          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros en total)",
          search: "Buscar:",
          processing: "Cargando Registros...",
          emptyTable: "No hay facturas para mostrar",
        },
      });
    } catch (error) {
      alertError("Error", error.message || "No se pudieron cargar las facturas.");
    }
  };

  const readInfoFactura = (id) => {
    let html = "";
    let htmlServicio = "";
    let htmlInsumos = "";
    let htmlPagos = "";
    let factura = dataFactura.find((data) => data.id_factura == id);

    if (!factura) {
      alertError("Error", "No se encontró la factura seleccionada.");
      return;
    }

    const servicios = Array.isArray(factura.servicios) ? factura.servicios : [];
    const insumos = Array.isArray(factura.insumos) ? factura.insumos : [];
    const pagos = Array.isArray(factura.pagos) ? factura.pagos : [];

    html += `
       <div class="div-total p-3 mb-4 text-center rounded shadow-sm" style="background-color: #3b82f6; color: white;">
                                        <h3 class="fw-bold mb-0">${escapeHtml(factura.total)}</h3>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Código:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${escapeHtml(factura.numero_factura || factura.id_factura)}</span></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold">Fecha:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${escapeHtml(factura.fecha)}</span></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cédula Cliente:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>
                                        ${escapeHtml(factura.nacionalidad)}-${escapeHtml(factura.cedula_p)}</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cliente:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${escapeHtml(factura.nombre_p)} ${escapeHtml(factura.apellido_p)}</span></div>
                                    </div>
      `;

    servicios.forEach((servicio) => {
      htmlServicio += `
      <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">

                                        <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                            <span class="fw-semibold text-comprobante">${escapeHtml(servicio.categoria)}</span>
                                            <span class=" text-comprobante">
                                                DR: ${escapeHtml(servicio.nombre_d)} ${escapeHtml(servicio.apellido_d)}  |   ${escapeHtml(servicio.precio)}  BS 
                                            </span>
                                        </div>
                                    </div>

      `;
    });

    insumos.forEach((insumo) => {
      htmlInsumos += `
       <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-comprobante">${escapeHtml(insumo.nombre_insumo)}</span>
                                            <span class="text-comprobante">Cant: ${escapeHtml(insumo.cantidad_insumo)}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small ">
                                            <span class="text-comprobante">Base: ${insumo.iva ? escapeHtml(insumo.precio_insumo - insumo.precio_insumo * 0.3) : escapeHtml(insumo.precio_insumo)} BS </span>
                                            <span class="text-comprobante">IVA:  ${insumo.iva ? escapeHtml(insumo.precio_insumo * 0.3) : 0} Bs </span>
                                        </div>
                                    </div>

      `;
    });

    pagos.forEach((pago) => {
      htmlPagos += `
       <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                        <span class="text-comprobante">${escapeHtml(pago.nombre)}</span>
                                        <span class="fw-bold text-comprobante">${escapeHtml(pago.monto)} Bs</span>
                                    </div>

      `;
    });

    dataCardFactura.innerHTML = html;
    dataCardServicio.innerHTML = htmlServicio;
    dataCardInsumos.innerHTML = htmlInsumos;
    dataCardPagos.innerHTML = htmlPagos;

    //darle la direccion del pdf al boton
    btnImprimirFactura.setAttribute(
      "href",
      `/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPDF/${factura.id_factura}`,
    );
  };

  //delete
  const anularFactura = async (idFactura) => {
    try {
      // El id de usuario ya no viaja en la URL: el controlador lo toma de la
      // sesión. Enviar el arreglo [idFactura, idUsuario] generaba la ruta
      // ".../hash,1", que unhashId() rechazaba y la factura nunca se anulaba.
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Reportes/anularFactura/${encodeURIComponent(idFactura)}`,
        "POST",
      );

      if (result.ok) {
        alertSuccess(result.message);
        await readFacturas("ACT");
      } else throw new Error(result.error || "No se pudo anular la factura.");
    } catch (error) {
      alertError("Error", error.message || error);
    }
  };

  //este boton es para gestionar si trae facturas anuladas o normales
  btnModalFactura.addEventListener("click", async function () {
    const mostrarAnuladas = !btnModalFactura.classList.contains("anulada");
    btnModalFactura.classList.toggle("anulada", mostrarAnuladas);

    if (mostrarAnuladas) {
      this.innerText = "Facturas Activas";
      titleModalFactura.innerText = "Gestionar Factura Anuladas";
      await readFacturas("Anulada");
      return;
    }

    this.innerText = "Facturas Anuladas";
    titleModalFactura.innerText = "Gestionar Factura Activas";
    await readFacturas("ACT");
  });

  // Al abrir el modal se muestra siempre la vista de facturas activas y se
  // recargan los datos, para reflejar anulaciones hechas en otra pestaña.
  document
    .getElementById("reporteFactura")
    .addEventListener("shown.bs.modal", async function () {
      btnModalFactura.classList.remove("anulada");
      btnModalFactura.innerText = "Facturas Anuladas";
      titleModalFactura.innerText = "Gestionar Factura Activas";
      await readFacturas("ACT");
    });

  //funcionamiento de entradas de insumos

  //checkear si quiere filtar por fecha o no
  checkboxEntradas.addEventListener("change", function () {
    if (this.checked) {
      cajaModalEntradas.classList.remove("d-none");
    } else {
      cajaModalEntradas.classList.add("d-none");
    }
  });

  //ver que insumo selecciona para el reporte
  selectInsumoEntradas.addEventListener("change", function () {
    botonDeImprimirEntradas.classList.remove("d-none");
    cajaCheckboxEntrada.classList.remove("d-none");
  });

  //enviar fechas para buscar entradas de insumos
  let verificarFormEntradas =
    inicializarValidacionFormulario(formularioEntradas);

  let verificarFormCitas = inicializarValidacionFormulario(formularioCita);

  //
  formularioEntradas.addEventListener("submit", function (e) {
    e.preventDefault();
    let esValido = verificarFormEntradas();

    if (cajaModalEntradas.classList.contains("d-none")) {
      formularioEntradas.submit();
      return;
    }
    if (esValido) {
      console.log("se envio");
      formularioEntradas.submit();
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  formularioCita.addEventListener("submit", function (e) {
    e.preventDefault();
    let esValido = verificarFormCitas();
    let inputs = formularioCita.querySelectorAll(".input-validar");

    if (!esValido) {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
      return
    }

    if (inputs[0].value >= inputs[1].value) {
      alertError(
        "Error",
        "La fecha de inicio no puede ser mayor a la fecha final.",
      );
      return;
    }

    inputs[0].setAttribute("name", "desdeFecha");
    inputs[1].setAttribute("name", "fechaHasta");

    console.log("se envio");
    formularioCita.submit();
    return;
  });
});
