import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
} from "./generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";

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
    dataFactura = result;
  };

  //functions for factura
  const readFacturas = async (estado = "ACT") => {
    try {
      let html = "";
      let dataFiltrada = dataFactura.filter((data) => data.estado == estado);

      console.log(dataFiltrada);
      dataFiltrada.forEach((res) => {
        html += `<tr>
                            <td class="text-center">${res.id_factura}</td>
                            <td class="text-center">${res.nacionalidad}-${res.cedula_p}</td>
                            <td class="text-center">${res.nombre_p}-${res.apellido_p}</td>
                            <td class="text-center">${res.fecha}</td>
                            <td class="text-center">${res.total} Bs</td>

                            <td class="text-center">

                                    <button class="btn btn-tabla mb-1  btn-dt-tabla btn-info"

                                        data-index="${res.id_factura}" data-bs-toggle="modal" data-bs-target="#modal-info-factura">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                    </svg>
                                    </button>


                                    <button class=" btn btn-tabla mb-1  btn-dt-tabla btn-anular" data-index="${res.id_factura}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                            </button>

                            </td>

                        </tr>`;
      });

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }
      // vuelca el html en el tbody
      document.querySelector(selector + " tbody").innerHTML = html;

      //llamar las funcion de eliminar
      document.querySelectorAll(".btn-info").forEach((btn) => {
        btn.addEventListener("click", function () {
          let id = this.getAttribute("data-index");
          readInfoFactura(id);
        });
      });

      //llamar las funcion de anular factura
      document.querySelectorAll(".btn-anular").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            document.getElementById("id_usuario_session").value,
          ];
          console.log(data);
          alertConfirm(
            "Esta seguro de anular la factura?",
            anularFactura,
            data,
          );
        });
      });

      // re-inicializa
      initDataTable(selector);
    } catch (error) {
      alertError("Error", error);
    }
  };

  const readInfoFactura = (id) => {
    let html = "";
    let htmlServicio = "";
    let htmlInsumos = "";
    let htmlPagos = "";
    let factura = dataFactura.find((data) => data.id_factura == id);
    html += `
       <div class="div-total p-3 mb-4 text-center rounded shadow-sm" style="background-color: #3b82f6; color: white;">
                                        <h3 class="fw-bold mb-0">${factura.total}</h3>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Código:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${factura.id_factura}</span></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold">Fecha:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${factura.fecha}</span></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cédula Cliente:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>
                                        ${factura.nacionalidad}-${factura.cedula_p}</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cliente:</span></div>
                                        <div class="col-6 text-end text-comprobante"><span>${factura.nombre_p} ${factura.apellido_p}</span></div>
                                    </div>
      `;

    factura.servicios.forEach((servicio) => {
      htmlServicio += `
      <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">

                                        <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                            <span class="fw-semibold text-comprobante">${servicio.categoria}</span>
                                            <span class=" text-comprobante">
                                                DR: ${servicio.nombre_d} ${servicio.apellido_d}  |   ${servicio.precio}  BS 
                                            </span>
                                        </div>
                                    </div>

      `;
    });

    factura.insumos.forEach((insumo) => {
      htmlInsumos += `
       <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold text-comprobante">${insumo.nombre_insumo}</span>
                                            <span class="text-comprobante">Cant: ${insumo.cantidad_insumo}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small ">
                                            <span class="text-comprobante">Base: ${insumo.iva ? insumo.precio_insumo - insumo.precio_insumo * 0.3 : insumo.precio_insumo} BS </span>
                                            <span class="text-comprobante">IVA:  ${insumo.iva ? insumo.precio_insumo * 0.3 : 0} Bs </span>
                                        </div>
                                    </div>

      `;
    });

    factura.pagos.forEach((pago) => {
      htmlPagos += `
       <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                        <span class="text-comprobante">${pago.nombre}</span>
                                        <span class="fw-bold text-comprobante">${pago.monto} Bs</span>
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
  const anularFactura = async (data) => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Reportes/anularFactura/${data}`,
        "GET",
      );

      if (result.ok) {
        alertSuccess(result.message);
        await loadDataFactura();
        readFacturas();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //llamar los datos de la factura
  loadDataFactura();

  //este boton es para gestionar si trae facturas anuladas o normales
  btnModalFactura.addEventListener("click", async function () {
    btnModalFactura.classList.toggle("anulada");
    console.log(dataFactura);
    if (btnModalFactura.classList.contains("anulada")) {
      this.innerText = "Facturas Activas";
      titleModalFactura.innerText = `Gestionar Factura Anuladas`;
      await readFacturas("Anulada");
      document
        .querySelectorAll(".btn-anular")
        .forEach((ele) => ele.classList.add("d-none"));
      return;
    }

    this.innerText = "Facturas Anuladas";
    titleModalFactura.innerText = `Gestionar Factura Activas`;
    await readFacturas();
    document
      .querySelectorAll(".btn-anular")
      .forEach((ele) => ele.classList.remove("d-none"));
  });

  //llamar a la funcion para cargar las facturas
  cardFactura.addEventListener("click", function () {
    readFacturas();
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
