import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "./generic/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes";

addEventListener("DOMContentLoaded", function () {
  console.log("factura...");
  // Creamos la variable donde van a estar los datos, y de una vez le ponemos una fila para probar
  console.log(window.location.href.includes("facturaCita"));
  var data = [];
  var dataInsumo = [];
  let listaModalServicio = [];
  let listaModalInsumo = [];
  // console.log(data)

  // // Creamos las variables html que usaremos
  const tabla = document.getElementById("tbody");

  const forms = document.querySelector(".formularios");

  const tbodyInsumos = document.getElementById("tbody-insumos");

  //buscador
  const tablaSevicios = document.getElementById("cuerpoTablaServicios");

  //caja de todos los insumos
  const caja_insumos_a_seleccionar = document.querySelectorAll(
    ".caja_insumos_a_seleccionar div",
  );
  //input para buscar todos los insumos
  const buscadorDeTodosLosInsumos = document.getElementById(
    "buscadorDeTodosLosInsumos",
  );

  const ConteNotificacionServicio = document.getElementById(
    "ConteNotificacionServicio",
  );
  const ConteNotificacionServicioEli = document.getElementById(
    "ConteNotificacionServicioEli",
  );
  const ConteNotificacionInsumo = document.getElementById(
    "ConteNotificacionInsumo",
  );
  const ConteNotificacionInsumoCon = document.getElementById(
    "ConteNotificacionInsumoCon",
  );

  const pacienteClienteCheck = document.querySelector(
    ".paciente-cliente-check",
  );
  const cajaBuscadorCliente = document.getElementById("caja-buscar-cliente");
  const buscadorCliente = document.getElementById("form-buscador-cliente");
  const dataCliente = document.getElementById("data-cliente");

  const btnCancelarInsertServ = document.getElementById(
    "btnCancelarInsertServ",
  );
  const btnCancelarInsumo = document.getElementById("btnCancelarInsumo");
  const btnSiguienteSer = document.getElementById("siguiente");
  const btnSiguienteInsumo = document.getElementById("siguienteInsumo");

  const divClienteNoEncontrado = document.getElementById(
    "div-cliente-no-encontrado",
  );
  const btnOpenModalPaciente = document.getElementById("btnOpenModalPaciente");

  const selectGenero = document.getElementById("selectGenero");

  //botones de acciones en la factura
  const btnServicio = document.getElementById("botonAgregar");
  const btnInsumos = document.getElementById("btnInsumos");
  const btnVaciarTabla = document.getElementById("vaciarTabla");
  const btnSiguiente = document.getElementById("btnSiguiente");
  const inputTotalCita = document.getElementById("inputTotalCita");
  const inputTotalFactura = document.getElementById("totalFactura");
  const totalDeConfirmacion = document.getElementById("totalDeConfirmacion");
  const inputTotalDeConfirmacion = document.getElementById(
    "inputTotalDeConfirmacion",
  );
  const totalModalValidacion = document.getAnimations("total-modal-validacion");
  const inputValidacionPago = document.getElementById("input-validacion-pago");
  const divModalServicio = document.getElementById("div-modal-servicio");
  const divModalInsumo = document.getElementById("div-modal-insumo");
  const btnInsertarServicioModal = document.getElementById(
    "btnInsertarServicioModal",
  );
  const btnInsertarInsumo = document.getElementById("btnInsertarInsumo");

  const bodyModalPago = document.getElementById("body-modal-pago");

  //seccion de pagos
  //Aqui iran los nombres de tipos de pagos
  const pagosDeConfirmacion = document.getElementById("pagosDeConfirmacion");
  const pagosDeConfirmacion2 = document.getElementById("pagosDeConfirmacion2");
  const pagosDeConfirmacion3 = document.getElementById("pagosDeConfirmacion3");
  //inputs De Formas De pago
  const inputsDePago = document.querySelectorAll("#divInputPago input");

  //inputs de montos de los pagos
  const inputsDeMontos = document.querySelectorAll("#divMontosPago input");

  const btnTipoDePago = document.querySelector("#btnTipoDePago");
  //inputs de la validacion
  const inputsDeValidacion = document.querySelectorAll(".inputsDeValidacion");
  //label de los inputs de validacion
  const labelForma1 = document.getElementById("forma1");
  const labelForma2 = document.getElementById("forma2");
  const labelForma3 = document.getElementById("forma3");
  //input de la referencia
  const referencia = document.getElementById("referencia");

  //funcion para comprobar si el paciente es el mismo cliente

  const buscarCliente = async (formulario) => {
    try {
      let [addClass, removeClass] = ["", ""];

      const datos = new FormData(formulario);
      const contenido = { method: "POST", body: datos };
      let peticion = await fetch(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarCliente",
        contenido,
      );
      let resultado = await peticion.json();
      console.log(resultado);
      if (resultado.length > 0) {
        resultado.forEach((res) => {
          console.log(res);
          // calcula la edad
          const fechaNac = new Date(res.fn);
          const edadDif = Date.now() - fechaNac.getTime();
          const edadFecha = new Date(edadDif);
          const edad = Math.abs(edadFecha.getUTCFullYear() - 1970);
          dataCliente.innerText = `CLIENTE: ${res.nombre} ${res.apellido} Edad: ${edad}`;

          if (edad >= 18) {
            [addClass, removeClass] = ["c", "d-none"];

            document.getElementById("botonPC").classList.remove("d-none");
          } else {
            [addClass, removeClass] = ["d-none", "c"];
            document.getElementById("botonPC").classList.add("d-none");
          }

          document.getElementById("inputCliente").value = res.id_cliente;
        });

        divClienteNoEncontrado.classList.add("d-none");
      } else {
        dataCliente.innerText = ``;

        divClienteNoEncontrado.classList.remove("d-none");
        document.getElementById("inputCliente").value = "";
        document.getElementById("botonPC").classList.add("d-none");
      }

      btnServicio.classList.add(addClass);
      btnInsumos.classList.add(addClass);
      btnServicio.classList.remove(removeClass);
      btnInsumos.classList.remove(removeClass);
    } catch (error) {
      alertError("Error", "Lamentablemente ocurrio un error" + error);
      console.log(error);
    }
  };

  const traerServiciosMedicos = async () => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarServicios`,
        "GET",
      );
      let html = "";
      if (result.length > 0) {
        result.forEach((res) => {
          html += `<div class="card card-servicio p-4" style="cursor: pointer;" data-id-servicio="${res.id_servicioMedico}">
        <!-- nombre del insumo (podemos cambiarlo dinámicamente) -->
        <div class="text-center nombre-card-factura">
            <span>${res.categoria}</span>
        </div>
        <span class="text-center">DR: ${res.nombre_d} ${res.apellido}</span>
        <span class="text-center">Precio: ${res.precio} $</span>
        <input type="hidden" value=${res.precio}>

        <!-- pequeños detalles decorativos al estilo bootstrap pero con personalidad -->
        <div class="card-footer-decor">
            <span class="decor-dot"></span>
            <span class="decor-dot"></span>
            <span class="decor-dot"></span>
        </div>
    </div>`;
        });
      } else {
        html = `<h5 class="text-center">No se encontraron servicios medicos</h5>`;
      }

      divModalServicio.innerHTML = html;

      //ffuncionalida para pintan la cata  selecionada
      let cardsServicios = document.querySelectorAll(".card-servicio")
        ? document.querySelectorAll(".card-servicio")
        : [];

      cardsServicios.forEach((card, index) => {
        card.addEventListener("click", function () {
          if (card.classList.contains("selecionado")) {
            card.classList.remove("selecionado");
          } else {
            card.classList.add("selecionado");
          }
        });
      });
    } catch (error) {
      alertError("Error", `Lamentablemente algo salio mal ${error}`);
    }
  };

  const traerInsumos = async () => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarInsumos`,
        "GET",
      );

      //darle el valor a este array para usarlo en la validacion de cantidad de los insumos
      listaModalInsumo = result;
      console.log(listaModalInsumo);
    } catch (error) {
      alertError("Error", `Lamentablemente algo salio mal ${error}`);
    }
  };

  const renderizarInsumos = () => {
    let html = "";
    if (listaModalInsumo.length > 0) {
      listaModalInsumo.forEach((res) => {
        html += `<div data-index=${res.id_insumo} data-medida=${res.medida} iva=${res.iva} data-precio=${res.precio} data-cantidad=${res.cantidad_disponible} class="card card-insumo p-4">

        <div class="text-center nombre-card-factura" >
            <span class="title-insumo">${res.nombre}</span>
        </div>
        <span class="text-center" >Cantidad Disponible: ${res.cantidad_disponible}</span>
        <span class="text-center" >${res.precio} $</span>


        <div class="d-flex justify-content-between align-items-center cantidad-wrapper mt-2">
            <button class="btn btn-cantidad btnRestar" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-dash-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                </svg>
            </button>

            <span class="cantidad-numero px-3 cantidadDisplay">0</span>

            <button class="btn btn-cantidad  btnSumar" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-circle-fill"
                    viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                </svg>
            </button>
        </div>

        <div class="card-footer-decor">
            <span class="decor-dot"></span>
            <span class="decor-dot"></span>
            <span class="decor-dot"></span>
        </div>
    </div>`;
      });
    } else {
      html = `<h5 class="text-center">No se encontraron servicios medicos</h5>`;
    }

    divModalInsumo.innerHTML = html;

    if (document.querySelectorAll(".card-insumo")) {
      document.querySelectorAll(".card-insumo").forEach((contenedor) => {
        console.log(contenedor);
        // Dentro de cada contenedor, buscar sus elementos específicos
        const cantidadSpan = contenedor.querySelector(".cantidadDisplay");
        const btnSumar = contenedor.querySelector(".btnSumar");
        const btnRestar = contenedor.querySelector(".btnRestar");

        // Verificar que existan todos los elementos necesarios
        if (!cantidadSpan || !btnSumar || !btnRestar) return;

        // Configuración de límites
        const MIN = 0;
        const MAX = 99;

        // Obtener valor inicial
        let cantidad = parseInt(cantidadSpan.innerText, 10);
        if (isNaN(cantidad) || cantidad < MIN) {
          cantidad = 6;
        }

        // Función para actualizar cantidad
        function actualizarCantidad(nuevoValor) {
          if (nuevoValor < MIN) nuevoValor = MIN;
          if (nuevoValor > MAX) nuevoValor = MAX;

          cantidad = nuevoValor;
          cantidadSpan.innerText = cantidad;

          btnRestar.disabled = cantidad <= MIN;
          btnSumar.disabled = cantidad >= MAX;

          btnRestar.setAttribute("aria-disabled", btnRestar.disabled);
          btnSumar.setAttribute("aria-disabled", btnSumar.disabled);
        }

        // Inicializar
        actualizarCantidad(cantidad);

        // Eventos
        btnSumar.addEventListener("click", function () {
          if (cantidad < MAX) {
            actualizarCantidad(cantidad + 1);
          } else {
            btnSumar.style.transform = "scale(0.9)";
            setTimeout(() => (btnSumar.style.transform = ""), 150);
          }
        });

        btnRestar.addEventListener("click", function () {
          if (cantidad > MIN) {
            actualizarCantidad(cantidad - 1);
          } else {
            btnRestar.style.transform = "scale(0.9)";
            setTimeout(() => (btnRestar.style.transform = ""), 150);
          }
        });

        // Prevenir selección de texto
        btnSumar.addEventListener("mousedown", (e) => e.preventDefault());
        btnRestar.addEventListener("mousedown", (e) => e.preventDefault());
      });
    }
  };

  const insertarServicio = (id, servicio, doctor, precio) => {
    const obj = {
      id_servicio: id,
      servicio: servicio,
      doctor: doctor,
      precio: precio,
    };

    data.push(obj);
    mostrarServicios();
  };

  const insertarInsumoSeleccionado = (
    id,
    cantidad,
    nombre,
    precio,
    iva,
    medida,
  ) => {
    const obj = {
      id_insumo: id,
      cantidad: cantidad,
      nombre: nombre,
      precio: precio,
      medida: medida,
      iva: iva,
    };

    //insumos selecionados
    const insumoSeleccionado = dataInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    //lista para restar
    const insumosARestar = listaModalInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    const insumosRegistrados = dataInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    insumosARestar ? (insumosARestar.cantidad_disponible -= cantidad) : 0;

    insumoSeleccionado
      ? (insumosRegistrados.cantidad += cantidad)
      : dataInsumo.push(obj);

    renderizarInsumos();
    mostrarInsumo();
  };

  //esto es para ocultar los botones de siguiente y  vaciar
  function ocultarBotones() {
    if (data.length > 0 || dataInsumo.length > 0) {
      btnVaciarTabla.classList.remove("d-none");
      btnSiguiente.classList.remove("d-none");
    } else {
      btnVaciarTabla.classList.add("d-none");
      btnSiguiente.classList.add("d-none");
    }
  }

  function calcularTotal() {
    let totalFactura = parseFloat(inputTotalCita.value);
    let subTotal = 0;
    let insumos = 0;
    for (let i = 0; i < data.length; i++) {
      subTotal += data[i]["precio"];
    }
    for (let i = 0; i < dataInsumo.length; i++) {
      insumos +=
        (dataInsumo[i]["iva"] != "No contiene"
          ? (parseFloat(dataInsumo[i]["precio"]) +
              parseFloat(dataInsumo[i]["iva"])) *
            dataInsumo[i]["cantidad"]
          : parseFloat(dataInsumo[i]["precio"])) * dataInsumo[i]["cantidad"];
    }
    let total =
      parseFloat(totalFactura) + parseFloat(subTotal) + parseFloat(insumos);
    total = parseFloat(total.toFixed(2));

    let storedDolar = localStorage.getItem("valorDelDolar");
    let montoBS = total * storedDolar;
    montoBS = montoBS.toFixed(2);

    inputTotalFactura.value = montoBS;
    totalDeConfirmacion.innerText = `${montoBS} BS`;
    inputTotalDeConfirmacion.value = montoBS;

    //validacion de el modal de validacion...
    totalModalValidacion.innerText = `Total a pagar ${montoBS} BS`;
    inputValidacionPago.value = montoBS;
  }

  // // Funcion para actualizar la tabla  servicios
  function mostrarServicios() {
    calcularTotal();
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    data.forEach((element, index) => {
      let storedDolar = localStorage.getItem("valorDelDolar");
      let montoBS = element["precio"] * storedDolar;
      montoBS = montoBS.toFixed(2);
      html += `
          <tr class="border-top">
          <td class="border-top"><div class="fw-bolder">SERVICIO :</div> ${element["servicio"]}</td>
          <td class="border-top"><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
          <td class="border-top">
            <div class="fw-bolder">PRECIO:</div>
            <p class="mb-1">${montoBS} BS</p>
            <p class="m-0 p-0">o</p>
            <p class="mt-1">${parseFloat(element["precio"]).toFixed(2)} $</p>
          </td>
          <td class="border-top"></td>
  
          <td class="border-top">
  
          <button class="eliminar btn btn-tabla mt-1" data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
          </svg></button>
          <td>
          <tr>`;
    });
    tabla.innerHTML = html;
    // Añadimos los eventos a los botones de eliminar
    document.querySelectorAll(".eliminar").forEach((ele) => {
      ele.addEventListener("click", function () {
        alertConfirm(
          "Desea eliminar este servicio medico?",
          eliminarElement,
          this,
        );
      });
    });

    //funncion para mostrar los botones de vaciar y siguiente
    ocultarBotones();
    mostrarConfirmacion();
  }

  //mostrar insumos
  function mostrarInsumo() {
    calcularTotal();
    let html = ``;
    dataInsumo.forEach((element, index) => {
      let storedDolar = localStorage.getItem("valorDelDolar");
      let montoBSSubTotal =
        (parseFloat(element["precio"]) * parseInt(element["cantidad"]) +
          parseFloat(element["iva"])) *
        storedDolar;
      montoBSSubTotal = montoBSSubTotal.toFixed(2);

      html += `
          <tr class="border-top tr">
          <th class="id_insumo_escondido d-none">${element["id_insumo"]}</th>
          <td class="border-top nombre"><div class="fw-bolder">INSUMO:</div> ${element["nombre"]}</td>
          <td class="border-top nombre"><div class="fw-bolder">Medida:</div> ${element["medida"]}</td>
          <td class="border-top"><div class="fw-bolder">CANTIDAD:</div> ${element["cantidad"]}</td>
          <td class="border-top"><div class="fw-bolder">PRECIO:</div>
          ${(element["precio"] * storedDolar).toFixed(2)} BS</td>
          <td class="border-top"><div class="fw-bolder">IVA:</div>${(parseFloat(element["iva"]) * storedDolar).toFixed(2)} BS</td>
          <td class="border-top">
            <div class="fw-bolder">SUB-TOTAL:</div>
            <p class="mb-1">${montoBSSubTotal} BS</p>
            <p class="m-0 p-0">o</p>
            <p class="mt-1">${(parseFloat(element["precio"]) * parseInt(element["cantidad"]) + parseFloat(element["iva"])).toFixed(2)} $</p>
          </td>
          <td class="border-top"></td>
  
          <td class="border-top">
  
          <button class="eliminar-insumo btn btn-tabla mt-1" style="margin-right: 7px;" data-cantidad=${element["cantidad"]} data-id-insumo=${element["id_insumo"]} data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
          </svg></button>
          <td>
          <tr>`;
    });
    tbodyInsumos.innerHTML = html;
    // Añadimos los eventos a los botones de eliminar

    document.querySelectorAll(".eliminar-insumo").forEach((ele) => {
      ele.addEventListener("click", function () {
        alertConfirm("Desea eliminar este insumo?", eliminarInsumo, this);
      });
    });

    //funncion para mostrar los botones de vaciar y siguiente
    ocultarBotones();
    mostrarConfirmacion();
  }

  const eliminarElement = (btn) => {
    data.splice(parseFloat(btn.dataset["index"]), 1);
    alertSuccess();
    mostrarServicios();
  };

  const eliminarInsumo = (btn) => {
    dataInsumo.splice(parseFloat(btn.dataset["index"]), 1);
    alertSuccess();
    let id = btn.getAttribute("data-id-insumo");
    let cantidad = parseInt(btn.getAttribute("data-cantidad"));
    //actualizar cantidad de insumo
    const insumoSeleccionado = dataInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    //lista para restar
    const insumosARestar = listaModalInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    const insumosRegistrados = dataInsumo.find(
      (insumo) => insumo.id_insumo == id,
    );

    insumosARestar ? (insumosARestar.cantidad_disponible += cantidad) : 0;

    insumoSeleccionado ? (insumosRegistrados.cantidad -= cantidad) : 0;

    renderizarInsumos();
    mostrarInsumo();
  };

  const mostrarTiposDePago = async () => {
    try {
      const result = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarMetodosDePago",
        "GET",
      );
      let html = "";
      console.log(result);
      if (result.length > 0) {
        result.forEach((res, index) => {
          html += `
            <div class="form-check form-switch d-flex align-items-center">
            <div>
              <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault${index}"
                value="${res.id_pago}">
            </div>
            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault${index}">
               ${res.nombre}
              </label></div>

          </div>
          `;
        });
      }
      bodyModalPago.innerHTML = html;

      //aqui se ejecuta el checkeo de los tipos de  llamando a la funcion checkearTiposDePago
      const tiposDePago = document.querySelectorAll(".tiposDePago");

      tiposDePago.forEach((tipoDePago) => {
        tipoDePago.addEventListener("change", function () {
          checkearTiposDePago(tiposDePago);
        });
      });

      //funcionalidad de los checkbox
    } catch (error) {
      alertError("Error", "error: " + error);
    }
  };

  //funcion por si es 2 formas
  const dosFormas = (forma1, forma2) => {
    labelForma1.innerText = forma1;
    labelForma2.innerText = forma2;
    btnTipoDePago.classList.remove("d-none");
    inputsDeValidacion[2].classList.add("d-none");
    labelForma3.innerText = "";
    pagosDeConfirmacion.innerText = forma1;
    pagosDeConfirmacion2.innerText = forma2;
    pagosDeConfirmacion3.innerText = "";
    inputsDePago[1].setAttribute("name", "formasDePago[]");
    inputsDeMontos[1].setAttribute("name", "montosDePago[]");
    if (forma1 == "Efectivo" && forma2 == "Divisas") {
      referencia.classList.add("d-none");
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    } else if (forma1 == "Efectivo" && forma2 == "PagoMovil") {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[1].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Pago Movil";
      pagosDeConfirmacion2.innerText = "Pago Movil";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.add("d-none");
    } else if (forma1 == "Efectivo" && forma2 == "Transferencia") {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[2].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Transferencia";
      pagosDeConfirmacion2.innerText = "Transferencia";
      console.log("deberia decir Transferencia");
      console.log(pagosDeConfirmacion2.innerText);
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.add("d-none");
    } else if (forma1 == "Divisas" && forma2 == "PagoMovil") {
      inputsDePago[0].value = tiposDePago[3].value;
      inputsDePago[1].value = tiposDePago[1].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Pago Movil";
      pagosDeConfirmacion2.innerText = "Pago Movil";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma1.innerText = "Divisas en BS";
    } else if (forma1 == "Divisas" && forma2 == "Transferencia") {
      inputsDePago[0].value = tiposDePago[3].value;
      inputsDePago[1].value = tiposDePago[2].value;
      referencia.classList.remove("d-none");
      console.log(labelForma1.innerText);
      labelForma2.innerText = "Transferencia";
      pagosDeConfirmacion2.innerText = "Transferencial";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma1.innerText = "Divisas en BS";
    }
  };

  //funcion por si son tres formas de pago
  const tresFormas = (forma1, forma2, forma3) => {
    labelForma1.innerText = forma1;
    labelForma2.innerText = forma2;
    labelForma3.innerText = forma3;
    btnTipoDePago.classList.remove("d-none");
    pagosDeConfirmacion.innerText = forma1;
    pagosDeConfirmacion2.innerText = forma2;
    pagosDeConfirmacion3.innerText = forma3;
    inputsDePago[2].setAttribute("name", "formasDePago[]");
    inputsDeMontos[2].setAttribute("name", "montosDePago[]");
    if (
      forma1 == "Efectivo" &&
      forma2 == "Divisas" &&
      forma3 == "Transferencia"
    ) {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      inputsDePago[2].value = tiposDePago[2].value;
      labelForma3.innerText = "Transferencia";
      pagosDeConfirmacion3.innerText = "Transferencia";
      referencia.classList.remove("d-none");
      inputsDeValidacion[2].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    } else {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      inputsDePago[2].value = tiposDePago[1].value;
      labelForma3.innerText = "Pago Movil";
      pagosDeConfirmacion3.innerText = "Pago Movil";
      referencia.classList.remove("d-none");
      inputsDeValidacion[2].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    }
  };

  //funcion para realizar las debidas validaciones de los tipos de pago
  const checkearTiposDePago = (metodosPago) => {
    let efectivo = metodosPago[0];
    let pagoMovil = metodosPago[1];
    let transferencia = metodosPago[2];
    let divisa = metodosPago[3];
    btnTipoDePago.setAttribute("data-bs-toggle", "modal");
    //cuando elige solo efectivo
    if (
      efectivo.checked &&
      pagoMovil.checked == false &&
      transferencia.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
      btnTipoDePago.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Efectivo";
      inputsDePago[0].value = efectivo.value;

      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      console.log(pagosDeConfirmacion);
      //aqui se le da el valor del monto al input

      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");

      document.getElementById("p_referencia").innerText = "";
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
      document
        .getElementById("referencia_confirmar")
        .setAttribute("name", "referencia");
      //cuando elige solo pago movil
    } else if (
      pagoMovil.checked &&
      efectivo.checked == false &&
      transferencia.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      btnTipoDePago.classList.remove("d-none");
      inputsDeValidacion[0].classList.add("d-none");
      inputsDeValidacion[1].classList.add("d-none");
      referencia.classList.remove("d-none");
      btnValidacion.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Pago Movil";
      inputsDePago[0].value = pagoMovil.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");
      //cuando elige solo transferencia
      document
        .querySelector(".suguiente")
        .addEventListener("click", function () {
          document.getElementById("p_referencia").innerText =
            "Ref " + referencia.value;
          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
      console.log(document.getElementById("p_referencia").innerText);
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
    } else if (
      transferencia.checked &&
      efectivo.checked == false &&
      pagoMovil.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      btnTipoDePago.classList.remove("d-none");
      inputsDeValidacion[0].classList.add("d-none");
      inputsDeValidacion[1].classList.add("d-none");
      referencia.classList.remove("d-none");
      btnValidacion.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Transferencia";
      inputsDePago[0].value = transferencia.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");
      document
        .querySelector(".suguiente")
        .addEventListener("click", function () {
          document.getElementById("p_referencia").innerText =
            "Ref " + referencia.value;
          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //cuando elige solo divisas
    } else if (
      divisa.checked &&
      efectivo.checked == false &&
      pagoMovil.checked == false &&
      transferencia.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
      btnTipoDePago.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Divisa";
      inputsDePago[0].value = divisa.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");

      document.getElementById("p_referencia").innerText = "";

      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
      document.getElementById("referencia_confirmar").setAttribute("name", "");
    } else {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      if (
        efectivo.checked &&
        divisa.checked &&
        pagoMovil.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Efectivo", "Divisas");

        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });

        document.getElementById("p_referencia").innerText = "";

        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");

        pagosDeConfirmacion3.innerText = "";

        //referencia
        document
          .getElementById("referencia_confirmar")
          .setAttribute("name", "");
      } else if (
        efectivo.checked &&
        pagoMovil.checked &&
        divisa.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Efectivo", "PagoMovil");

        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Pago Movil: " + inputsDeValidacion[1].value + " BS";
          document.getElementById("p_divisas").innerText = "";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document.getElementById("equivalenteDivisas").classList.add("d-none");

        pagosDeConfirmacion3.innerText = "";
      } else if (
        efectivo.checked &&
        transferencia.checked &&
        divisa.checked == false &&
        pagoMovil.checked == false
      ) {
        dosFormas("Efectivo", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Transferencia: " + inputsDeValidacion[1].value + " BS";
          document.getElementById("p_divisas").innerText = "";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document.getElementById("equivalenteDivisas").classList.add("d-none");

        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        pagoMovil.checked &&
        efectivo.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Divisas", "PagoMovil");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Pago Movil: " + inputsDeValidacion[0].value + " BS";
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        transferencia.checked &&
        efectivo.checked == false &&
        pagoMovil.checked == false
      ) {
        dosFormas("Divisas", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Transferencia: " + inputsDeValidacion[0].value + " BS";
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;

            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        //apartir de aqui empiezan los casos que son 3 formas
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        transferencia.checked &&
        efectivo.checked &&
        pagoMovil.checked == false
      ) {
        tresFormas("Efectivo", "Divisas", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion3.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion3.innerText =
            "Transferencia: " + inputsDeValidacion[2].value + " BS";
          console.log(inputsDeValidacion[2].value);
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
          inputsDeMontos[2].value = inputsDeValidacion[2].value;

          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        pagoMovil.checked &&
        efectivo.checked &&
        transferencia.checked == false
      ) {
        tresFormas("Efectivo", "Divisas", "Pago Movil");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion3.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion3.innerText =
            "Pago Movil: " + inputsDeValidacion[2].value + " BS";
          console.log(inputsDeValidacion[2].value);
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
          inputsDeMontos[2].value = inputsDeValidacion[2].value;

          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
      } else {
        btnTipoDePago.classList.add("d-none");
      }
    }
  };

  //funcion para llenar el modal de confirmacion
  const mostrarConfirmacion = () => {
    const tbodyDelModal = document.getElementById("tbodyDelModal");
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;
    let htmlInsumos = "";
    data.forEach((element, index) => {
      let storedDolar = localStorage.getItem("valorDelDolar");
      let montoBS = element["precio"] * storedDolar;
      montoBS = montoBS.toFixed(2);

      html += `
        <tr>
        <td><input type="hidden" name="servicios[]" value="${element["id_servicioMedico"]}">
        <div class="fw-bolder">S/E:</div>${element["servicio"]}</td>
        <td><input type="hidden" name="doctores[]" value="${element["id_personal"]}"><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
        <td><input type="hidden" name="precioServicio[]" value="${montoBS}"><div class="fw-bolder">PRECIO:</div> ${montoBS} BS</td>
        <td>
        <tr>`;
    });

    dataInsumo.forEach((element, index) => {
      let storedDolar = localStorage.getItem("valorDelDolar");
      let montoBS = element["precio"] * storedDolar;
      montoBS = montoBS.toFixed(2);

      htmlInsumos += `
        <tr>
        <td><input type="hidden" name="insumos[]" value="${element["id_insumo"]}">
        <div class="fw-bolder">INSUMO:</div>${element["nombreInsumo"]}</td>

        <td><div class="fw-bolder">MEDIDA:</div>${element["medidaInsumo"]}</td>

        <td><input type="hidden" name="cantidad[]" value="${element["cantidad"]}"><div class="fw-bolder">CANTIDAD</div> ${
          element["cantidad"]
        }</td>
        <td><input type="hidden" name="precioInsumo[]" value="${montoBS}"><div class="fw-bolder">PRECIO:</div> ${montoBS} BS</td>
        <td class="border-top"><div class="fw-bolder">SUB-TOTAL:</div>${(element["subTotal"] * storedDolar).toFixed(2)} BS</td>
        <td>
        <tr>`;
    });
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    tbodyDelModal.innerHTML = html;
    if (window.location.href.includes("idH")) {
      console.log("si es hospitalizacion");
    } else {
      document.getElementById("tbodyInsumos").innerHTML = htmlInsumos;
    }

    console.log(data);
  };

  traerServiciosMedicos();
  traerInsumos();

  calcularTotal();

  mostrarTiposDePago();

  //////EVEntos

  //insertar servicios
  btnInsertarServicioModal.addEventListener("click", function () {
    let cardsServicios = document.querySelectorAll(".card-servicio")
      ? document.querySelectorAll(".card-servicio")
      : [];

    cardsServicios.forEach((card) => {
      if (card.classList.contains("selecionado")) {
        insertarServicio(
          card.getAttribute("data-id-servicio"),
          card.children[0].children[0].innerText,
          card.children[1].innerText,
          card.children[3].value,
        );
      } else {
        console.log("no fue selecionad0");
      }
    });
  });

  //insertar insumos
  btnInsertarInsumo.addEventListener("click", function () {
    const cardsInsumos = document.querySelectorAll(".card-insumo")
      ? document.querySelectorAll(".card-insumo")
      : [];

    cardsInsumos.forEach((card) => {
      const cantidadSpan = parseInt(
        card.querySelector(".cantidadDisplay").innerText,
      );
      const id = card.getAttribute("data-index");
      const nombre = card.querySelector(".title-insumo").innerText;
      const precio = card.getAttribute("data-precio");
      const iva = card.getAttribute("iva");
      const medida = card.getAttribute("data-medida");

      insertarInsumoSeleccionado(id, cantidadSpan, nombre, precio, iva, medida);
    });
  });

  buscadorCliente.addEventListener("submit", function (e) {
    e.preventDefault();
    buscarCliente(this);
    renderizarInsumos();
  });
});
