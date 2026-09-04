import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "./generic/funtionGeneric.js";
import Paginator from "./generic/Paginator.js";
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes";

addEventListener("DOMContentLoaded", function () {
  console.log("factura.:)");
  // Creamos la variable donde van a estar los datos, y de una vez le ponemos una fila para probar
  console.log(window.location.href.includes("facturaCita"));
  let data = [];
  let dataInsumo = [];
  let listaModalServicio = [];
  let listaModalInsumo = [];
  // console.log(data)

  let valorDelDolar = localStorage.getItem("valorDelDolar")
    ? parseFloat(localStorage.getItem("valorDelDolar"))
    : 0;

  const modalPaciente = new bootstrap.Modal(
    document.getElementById("exampleModalagregarPaciente"),
  );

  const modalAgregarPaciente = document.getElementById("modalAgregar");

  // // Creamos las variables html que usaremos
  const tabla = document.getElementById("tbody");

  const tbodyInsumos = document.getElementById("tbody-insumos");

  const inputCedulaPaciente = document.getElementById("input-cedula-paciente");
  const cedulaPaciente = document.getElementById("cedulaPaciente");

  const pacienteClienteCheck = document.querySelector(
    ".paciente-cliente-check",
  );
  const cajaBuscadorCliente = document.getElementById("caja-buscar-cliente");
  const buscadorCliente = document.getElementById("form-buscador-cliente");
  const formBuscadorOtroCliente = document.getElementById(
    "form-buscador-otro-cliente",
  );
  const dataCliente = document.getElementById("data-cliente");

  const divClienteNoEncontrado = document.getElementById(
    "div-cliente-no-encontrado",
  );

  //botones de acciones en la factura
  const btnAddPac = document.getElementById("btnAddPac");
  const btnAddCli = document.getElementById("btnAddCli");
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
  const bodyModalPago = document.getElementById("body-modal-pago");
  const inputPaciente = document.getElementById("inputPaciente");
  const inputHospitalizacion = document.getElementById("inputHospitalizacion");
  const btnTipoDePago = document.querySelector("#btnTipoDePago");
  //input de la referencia
  const inputRefencia = document.getElementById("inputRefencia");
  const inputReferenciaConfir = document.getElementById("referencia_confirmar");
  const pReferencia = document.getElementById("p-referencia");
  const divReferencia = document.getElementById("divReferencia");
  const inputIdCita = document.getElementById("inputIdCita");
  const botonPC = document.getElementById("botonPC");
  //boton del modal de validacion
  const btnValidacion = document.getElementById("btnValidacion");
  const divModalValidacion = document.getElementById("divModalValidacion");
  const divInputValidation = document.getElementById("divInputValidation");
  const divTypePagoCofirm = document.getElementById("divTypePagoCofirm");
  let listTypePago = [];

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
        btnAddCli.classList.add("d-none");
      } else {
        [addClass, removeClass] = ["d-none", "c"];

        dataCliente.innerText = ``;

        divClienteNoEncontrado.classList.remove("d-none");
        document.getElementById("inputCliente").value = "";
        document.getElementById("botonPC").classList.add("d-none");

        btnAddCli.classList.remove("d-none");
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

  //buscador paciente cuando no tiene cita
  const buscarPaciente = async (formularioPaciente) => {
    // try {
    let [addClass, removeClass] = ["", ""];
    const datos = new FormData(formularioPaciente);
    let resultado = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPaciente",
      "POST",
      datos,
    );
    console.log("paciente", resultado);
    if (resultado.length > 0) {
      resultado.forEach((res) => {
        console.log(res);
        // calcula la edad
        const fechaNac = new Date(res.fn);
        const edadDif = Date.now() - fechaNac.getTime();
        const edadFecha = new Date(edadDif);
        const edad = Math.abs(edadFecha.getUTCFullYear() - 1970);
        dataCliente.innerText = `PACIENTE: ${res.nombre} ${res.apellido} Edad: ${edad}`;

        if (edad >= 18) {
          [addClass, removeClass] = ["c", "d-none"];

          document.getElementById("botonPC").classList.remove("d-none");
        } else {
          [addClass, removeClass] = ["d-none", "c"];
          document.getElementById("botonPC").classList.add("d-none");
        }
        console.log(inputPaciente);

        inputPaciente.value = res.id_paciente;
      });

      divClienteNoEncontrado.classList.add("d-none");
      //desaparecer el btn de agregar un paciente
      btnAddPac.classList.add("d-none");
    } else {
      [addClass, removeClass] = ["d-none", "c"];

      dataCliente.innerText = ``;

      divClienteNoEncontrado.classList.remove("d-none");
      document.getElementById("inputCliente").value = "";
      document.getElementById("botonPC").classList.add("d-none");
      inputPaciente.value = 0;
      //aparecer el btn de agregar paciente
      dataCliente.innerText = `El paciente no fue encontrado  debe registrarlo por favor.`;
      btnAddPac.classList.remove("d-none");
    }

    btnServicio.classList.add(addClass);
    btnInsumos.classList.add(addClass);
    btnServicio.classList.remove(removeClass);
    btnInsumos.classList.remove(removeClass);
    // } catch (error) {
    //   console.log(error);
    // }
  };

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
        inputCedulaPaciente.value = cedulaPaciente.value;
        inputCedulaPaciente.dispatchEvent(
          new Event("keyup", { bubbles: true }),
        );

        form.reset();
        modalPaciente.hide();

        // buscarPacienteConCita(formularioPaciente);
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //buscar cuando el paciente una tiene cita
  const buscarPacienteConCita = async (formularioPaciente) => {
    try {
      const datos = new FormData(formularioPaciente);

      let resultado = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPacienteConCita",
        "POST",
        datos,
      );
      console.log(resultado[0]);
      if (resultado.length > 0) {
        // Cita encontrada, actualizar UI con datos de la cita
        const cita = resultado[0];

        // 1. Actualizar datos del paciente
        const fechaNac = new Date(cita.fecha_de_nacimiento);
        const edadDif = Date.now() - fechaNac.getTime();
        const edadFecha = new Date(edadDif);
        const edad = Math.abs(edadFecha.getUTCFullYear() - 1970);
        dataCliente.innerText = `PACIENTE: ${cita.nombre_p} ${cita.apellido_p} Edad: ${edad} años`;
        inputPaciente.value = cita.id_paciente;

        if (edad >= 18) {
          document.getElementById("botonPC").classList.remove("d-none");
        } else {
          document.getElementById("botonPC").classList.add("d-none");
        }

        divClienteNoEncontrado.classList.add("d-none");
        btnAddPac.classList.add("d-none");

        // 2. Limpiar datos previos y agregar servicio de la cita
        data = []; // Limpiar servicios anteriores

        insertarServicio(
          cita.id_servicioMedico,
          cita.categoria,
          `DR: ${cita.nombre_d} ${cita.apellido_d}`,
          parseFloat(cita.precio),
          cita.id_doctor_c,
        );

        //agregar el id cita para enviarlo
        inputIdCita.value = cita.id_cita;

        // 3. Habilitar botones de acción
        btnServicio.classList.remove("d-none");
        btnInsumos.classList.remove("d-none");
      } else {
        // No se encontró cita, buscar solo paciente
        buscarPaciente(formularioPaciente);
      }
    } catch (error) {
      alertError("Error", "Ocurrió un error al buscar la cita del paciente.");
      console.error(error);
    }
  };

  //buscar Paciente con hispitalizacion
  const buscarPacienteConHospit = async (id) => {
    try {
      let resultado = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/datosHospitalizacion/" + id,
        "GET",
      );

      if (!resultado.length > 0) {
        alertError(
          "Error",
          "Lamentablememte no hay hospitalizaciones con ese numero",
        );
        return;
      }

      // hospitalizacion encontrada, actualizar UI con datos de la hospitalizacion
      const hospit = resultado[0];

      // 1. Actualizar datos del paciente
      const fechaNac = new Date(hospit.fecha_de_nacimiento);
      const edadDif = Date.now() - fechaNac.getTime();
      const edadFecha = new Date(edadDif);
      const edad = Math.abs(edadFecha.getUTCFullYear() - 1970);
      dataCliente.innerText = `PACIENTE: ${hospit.nombre_p} ${hospit.apellido_p} Edad: ${edad} años`;
      inputPaciente.value = hospit.id_paciente;
      inputHospitalizacion.value = hospit.id_hospitalizacion;
      console.log(inputPaciente);

      if (edad >= 18) {
        document.getElementById("botonPC").classList.remove("d-none");
      } else {
        document.getElementById("botonPC").classList.add("d-none");
      }

      divClienteNoEncontrado.classList.add("d-none");
      btnAddPac.classList.add("d-none");

      // 2. Limpiar datos previos y agregar servicio de la cita
      data = []; // Limpiar servicios anteriores
      dataInsumo = []; //Limpiar insumos anteriores

      hospit.servicios.forEach((servicio) => {
        insertarServicio(
          servicio.id_servicioMedico,
          servicio.categoria,
          `${servicio.nombre_d} ${servicio.apellido_d}`,
          parseFloat(servicio.precios_servicio),
          servicio.id_doctor,
        );
      });

      hospit.insumos.forEach((insumo) => {
        insertarInsumoSeleccionado(
          insumo.id_entradaDeInsumo,
          insumo.cantidad,
          insumo.nombre,
          insumo.precio,
          insumo.iva,
          insumo.medida,
        );
      });

      botonPC.classList.remove("d-none");
      calcularTotal();
    } catch (error) {
      alertError("Error", error);
    }
  };

  const returnFragmentHtmlSer = (res) => {
    return `<div class="card card-servicio p-4" style="cursor: pointer;" data-index=${res.id_servicioMedico + "" + res.id_personal} data-id-servicio="${res.id_servicioMedico}" data-doctor="${res.id_personal}">
        <!-- nombre del insumo (podemos cambiarlo dinámicamente) -->
        <div class="text-center nombre-card-factura">
            <span>${res.categoria}</span>
        </div>
        <span class="text-center mb-2">DR: ${res.nombre_d} ${res.apellido_d}</span>

        <span class="text-center mb-2">Precio $: ${res.precio.toFixed(2)} $</span>
        <span class="text-center mb-2">Precio Bs: ${(valorDelDolar * res.precio.toFixed(2)).toFixed(2)} BS</span>
        
        <input type="hidden" value=${res.precio.toFixed(2)} class="precio-servicio">

        <!-- pequeños detalles decorativos al estilo bootstrap pero con personalidad -->
        
                 <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                   res.id_servicioMedico + "" + res.id_personal
                 }">Agregar</button>
    </div>`;
  };

  const addServicioTable = (id) => {
    let cardServicios = document.querySelector(`.card[data-index="${id}"]`);
    console.log(cardServicios);

    let filterService = data.find(
      (d) =>
        d.id_servicio == cardServicios.getAttribute("data-id-servicio") &&
        d.id_doctor == cardServicios.getAttribute("data-doctor"),
    );
    if (filterService) {
      console.log("no");

      alertError(
        "Error",
        "No puede agregar el mismo servicio con el mismo doctor.",
      );
      return;
    }

    insertarServicio(
      cardServicios.getAttribute("data-id-servicio"),
      cardServicios.children[0].children[0].innerText,
      cardServicios.children[1].innerText,
      cardServicios.children[4].value,
      cardServicios.getAttribute("data-doctor"),
    );
    alertSuccess("Se agrego correctamente el servicio medico");
  };

  const traerServiciosMedicos = async () => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarServicios`,
        "GET",
      );
      console.log(result);

      const paginator = new Paginator(
        result,
        1,
        "div-modal-servicio",
        "paginationSer",
        "searchInputSer",
        returnFragmentHtmlSer,
        "id",
        addServicioTable,
      );

      paginator.displayItems();
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

  const addInsumoTable = (id_insumo) => {
    //insertar insumos

    console.log(id_insumo);

    const card = document.querySelector(
      `.card-insumo[data-index="${id_insumo}"]`,
    );

    const cantidadSpan = parseInt(card.querySelector(".cantidadDisplay").value);
    const id = card.getAttribute("data-index");
    const nombre = card.querySelector(".title-insumo").innerText;
    const precio = card.getAttribute("data-precio");
    const iva = card.getAttribute("iva");
    const medida = card.getAttribute("data-medida");
    const stockDisponible = parseInt(card.getAttribute("data-cantidad"));

    if (cantidadSpan > 0 && cantidadSpan <= stockDisponible) {
      insertarInsumoSeleccionado(id, cantidadSpan, nombre, precio, iva, medida);
      return;
    }
    alertError("Error", "No hay stock suficiente de " + nombre);
  };

  const returnFragmentHtml = (res) => {
    return `<div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
        <div 
          data-index="${res.id_insumo}" 
          data-medida="${res.medida}" 
          iva="${res.iva}" 
          data-precio="${res.precio}" 
          data-cantidad="${res.disponible}" 
          class="card card-insumo ">

          <!-- Sección superior: ícono + nombre -->
          <div class="seccion-superior-custom text-center p-3">
            <div class="icono-medicamento-grande mb-2">
              <i class="bi bi-capsule-pill"></i>
            </div>
            <h6 class=" mb-1 nombre-search title-insumo">${res.nombre}</h6>
            <span class="" style="font-size: 0.82rem;">${res.medida}</span>
          </div>

          <!-- Sección inferior: detalles + precio + input -->
          <div class="p-3 d-flex flex-column gap-2">

            <ul class="lista-detalles ps-0 mb-0">
              <li class=""><strong>Medida:</strong> ${res.medida}</li>
              <li class=""><strong>IVA:</strong> ${res.iva ? "Sí" : "No"}</li>
              <li class=""><strong>Stock:</strong> ${res.disponible} unidades</li>
            </ul>

            <div>
              <div class="precio-principal">${res.precio.toFixed(2)} $ ${(valorDelDolar * res.precio.toFixed(2)).toFixed(2)} BS</div>
            </div>

            <!-- Input estilo nuevo diseño -->
            <div class="campo-custom">
                        <div class="input-custom ">
                            <span class="icono-izq">
                                

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z"></path>
                    </svg>
                            </span>

                            <input class="form-control txt-custom input-validar inputs cantidadDisplay" type="number"
              min="1"
              max="${res.disponible}"
              value="1"
              data-index="${res.id_insumo}"
              data-medida="${res.medida}"
              data-iva="${res.iva}"
              data-precio="${res.precio.toFixed(2)}"
              data-stock="${res.disponible}">

                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                        </div>

                        
</div>

            <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
              res.id_insumo
            }" style="border-radius: 10px;">Agregar</button>
          </div>
        </div>
      </div>`;
  };

  const renderizarInsumos = () => {
    listaModalInsumo = listaModalInsumo.filter((list) => list.disponible > 0);
    const paginator = new Paginator(
      listaModalInsumo,
      1,
      "div-modal-insumo",
      "pagination",
      "searchInput",
      returnFragmentHtml,
      "id_insumo",
      addInsumoTable,
    );

    paginator.displayItems();

    document.querySelectorAll(".input-cantidad-custom").forEach((input) => {
      const card = input.closest(".card-insumo");
      const MAX = parseInt(input.getAttribute("max")) || 99;
      const MIN = 0;

      function actualizarEstado(valor) {
        if (valor < MIN) valor = MIN;
        if (valor > MAX) valor = MAX;
        input.value = valor;
        card.classList.toggle("seleccionada", valor > 0);
      }

      input.addEventListener("input", function () {
        actualizarEstado(parseInt(this.value) || 0);
      });

      input.addEventListener("keydown", function (e) {
        if (e.key === "-" || e.key === "e") e.preventDefault();
      });

      actualizarEstado(0);
    });
  };
  const insertarServicio = (id, servicio, doctor, precio, id_doctor) => {
    const obj = {
      id_servicio: parseInt(id),
      servicio: servicio,
      doctor: doctor,
      precio: precio,
      id_doctor: parseInt(id_doctor),
    };

    data.push(obj);
    console.log(data);
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

    insumosARestar ? (insumosARestar.disponible -= cantidad) : 0;

    insumoSeleccionado
      ? (insumosRegistrados.cantidad += cantidad)
      : dataInsumo.push(obj);

    renderizarInsumos();
    mostrarInsumo();

    alertSuccess("Se agrego correctamente el insumo.");
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
    // inputValidacionPago.value = montoBS;
  }

  // // Funcion para actualizar la tabla  servicios

  function mostrarServicios() {
    calcularTotal();
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    console.log(data);

    data.forEach((element, index) => {
      let storedDolar = parseFloat(localStorage.getItem("valorDelDolar"));
      let montoBS = parseFloat(element["precio"]) * storedDolar;
      montoBS = montoBS.toFixed(2);
      console.log(element["precio"], storedDolar, montoBS);

      html += `
          <tr class="border-top">
          <td class="border-top"><div class="fw-bolder">SERVICIO :</div> ${element["servicio"]}</td>
          <td class="border-top"><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
          <td class="border-top">
            <div class="fw-bolder">PRECIO:</div>
            <p class="mb-1">${montoBS} dfBS</p>
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

    insumosARestar ? (insumosARestar.disponible += cantidad) : 0;

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

  //funcion para realizar las debidas validaciones de los tipos de pago
  const checkearTiposDePago = (tiposDePago) => {
    listTypePago = [];
    let htmlPAgo = "";

    tiposDePago.forEach((tipo) => {
      if (tipo.checked) {
        let name = tipo
          .closest(".form-check")
          .querySelector(".form-check-label").innerText;
        let obj = {
          id: tipo.value,
          name: name,
        };
        listTypePago.push(obj);
      }
    });

    const objP = listTypePago.find((list) => list.name == "Pago Movil");
    const objT = listTypePago.find((list) => list.name == "Transferencia");
    const objD = listTypePago.find((list) => list.name == "Divisas");
    const objE = listTypePago.find((list) => list.name == "Efectivo");

    if (listTypePago.length == 0) {
      btnTipoDePago.classList.add("d-none");
      return;
    }

    if ((objP != undefined && objT != undefined) || objP > 3) {
      btnTipoDePago.classList.add("d-none");
      return;
    }

    if (
      listTypePago.length >= 2 &&
      listTypePago.length <= 3 &&
      (objP != undefined || objT != undefined)
    ) {
      divReferencia.classList.remove("d-none");
      btnTipoDePago.classList.remove("d-none");
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      return;
    }

    if (objD != undefined && objE != undefined) {
      divReferencia.classList.add("d-none");
      inputRefencia.parentElement.classList.add("valido");
      inputRefencia.parentElement.classList.remove("invalido");
      btnTipoDePago.classList.remove("d-none");
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      return;
    }

    if (objP != undefined || objT != undefined) {
      inputRefencia.parentElement.classList.remove("invalido", "valido");
      divReferencia.classList.remove("d-none");
      listTypePago[0].monto = parseFloat(inputTotalFactura.value);
      btnTipoDePago.classList.remove("d-none");
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      return;
    }
    //esto es por si elige un solo metodo de pago
    listTypePago.forEach((type) => {
      htmlPAgo += `
        <input type="hidden" name="formasDePago[]" value="${type.id}">
        <input type="hidden" name="montosDePago[]" value="${inputTotalFactura.value}">

        <p>${type.name} monto: ${inputTotalFactura.value} Bs</p>
        `;
    });
    divTypePagoCofirm.innerHTML = htmlPAgo;

    divReferencia.classList.add("d-none");
    listTypePago[0].monto = parseFloat(inputTotalFactura.value);
    btnTipoDePago.classList.remove("d-none");
    btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
  };

  //funcion para llenar el el modal de validacion
  const validarTypeDePago = () => {
    let htmlTypePago = "";
    listTypePago.forEach((list) => {
      htmlTypePago += `
        <label class="label-custom">${list.name}</label>
        <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"></path>
                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"></path>
                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"></path>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path>
                                </svg>
                            </span>
                            <input data-name="${list.name}"   class="form-control txt-custom input-validar input-modal-valida  input-modal-monto inputs precioBolivares" name="precio" type="text" placeholder="Monto en ${list.name}">
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none p-error-validaciones"></p>
                    </div>
        `;
    });

    divInputValidation.innerHTML = htmlTypePago;

    //inicializar validacion de los input
    let validarForm = inicializarValidacionFormulario(divModalValidacion);

    //validar que la cantidd del monto se la correcta
    const inputs = document.querySelectorAll(".input-modal-valida");
    let longitud = inputs.length;
    let totalIngresado = 0;

    inputs.forEach((input) => {
      input.addEventListener("keyup", function () {
        console.log(validarForm());

        if (
          longitud == 2 &&
          parseFloat(inputTotalFactura.value) == parseFloat(inputs[0].value) &&
          inputs[0].classList.contains("valido") &&
          inputs[1].classList.contains("valido")
        ) {
          btnValidacion.classList.remove("d-none");
          return;
        }
        
        if (!validarForm()) {
          // console.log("validacion mala");
          btnValidacion.classList.add("d-none");
          return;
        }

        totalIngresado = 0;
        document.querySelectorAll(".input-modal-monto").forEach((inp) => {
          totalIngresado += !isNaN(parseFloat(inp.value))
            ? parseFloat(inp.value)
            : 1;
        });

        if (totalIngresado == parseFloat(inputTotalFactura.value)) {
          console.log("total ingredado buno");
          btnValidacion.classList.remove("d-none");
          return;
        }
        btnValidacion.classList.add("d-none");
      });
    });
  };

  const showTypePagoCofirm = () => {
    inputReferenciaConfir.value = inputRefencia.value;
    pReferencia.innerText = `Numero de Referencia: ${inputRefencia.value}`;

    const inputs = document.querySelectorAll(".input-modal-valida");
    let htmlPAgo = "";
    console.log(listTypePago);

    inputs.forEach((inp, index) => {
      if (listTypePago[index]) {
        listTypePago[index].monto = parseFloat(inp.value);
      }
    });
    listTypePago.forEach((type) => {
      htmlPAgo += `
        <input type="hidden" name="formasDePago[]" value="${type.id}">
        <input type="hidden" name="montosDePago[]" value="${type.monto}">

        <p>${type.name} monto: ${type.monto} Bs</p>
        `;
    });

    divTypePagoCofirm.innerHTML = htmlPAgo;
  };

  btnTipoDePago.addEventListener("click", function () {
    validarTypeDePago();
  });

  btnValidacion.addEventListener("click", function () {
    showTypePagoCofirm();
  });

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
      console.log("confirmaciopn", element["id_servicio"]);
      html += `
        <tr>
        <td><input type="hidden" name="servicios[]" value="${element["id_servicio"]}">
        <div class="fw-bolder">S/E:</div>${element["servicio"]}</td>
        <td><input type="hidden" name="doctores[]" value="${element["id_doctor"]}"><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
        <td><input type="hidden" name="precioServicio[]" value="${element["precio"]}"><div class="fw-bolder">PRECIO:</div> ${element["precio"]} BS</td>
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
        <div class="fw-bolder">INSUMO:</div>${element["nombre"]}</td>

        <td><div class="fw-bolder">MEDIDA:</div>${element["medida"]}</td>

        <td><input type="hidden" name="cantidad[]" value="${element["cantidad"]}"><div class="fw-bolder">CANTIDAD</div> ${
          element["cantidad"]
        }</td>
        <td><input type="hidden" name="precioInsumo[]" value="${montoBS}"><div class="fw-bolder">PRECIO:</div> ${montoBS} BS</td>
        <td class="border-top"><div class="fw-bolder">SUB-TOTAL:</div>${(montoBS * storedDolar).toFixed(2)} BS</td>
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
  //llamar la uncion de buscar el paciente
  pacienteClienteCheck.addEventListener("change", function () {
    if (this.checked) {
      cajaBuscadorCliente.classList.remove("d-none");
      document.getElementById("botonPC").classList.add("d-none");
      console.log(document.getElementById("botonPC"));
    } else {
      cajaBuscadorCliente.classList.add("d-none");
      document.getElementById("inputCliente").value = "";
      document.getElementById("botonPC").classList.remove("d-none");
    }
  });

  //buscar otro cliente
  formBuscadorOtroCliente.addEventListener("submit", function (e) {
    e.preventDefault();
    buscarCliente(formBuscadorOtroCliente);
  });

  //metodo para que cuando le de click al boton de abrir el modal de agregar pacientw ase le de el valor a la cediula de manera automatica

  btnAddPac.addEventListener("click", function () {
    cedulaPaciente.value = inputCedulaPaciente.value;
    cedulaPaciente.dispatchEvent(new Event("keyup", { bubbles: true }));
  });

  //llamar a la validacion para los fformularios tanto de guardar paciente como cliente
  let verificarFormularioPaciente =
    inicializarValidacionFormulario(modalAgregarPaciente);

  //enviar firmulario de paciente
  modalAgregarPaciente.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("valido"))
        inputsBuenos.push(true);
    });

    let esValido = verificarFormularioPaciente();

    if (esValido) {
      createPatients(this, inputsBuenos);
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  let url_factura = window.location.href.split("/")[6];
  console.log(url_factura);
  if (url_factura != undefined) {
    let idH = parseInt(url_factura.slice(1));
    buscarPacienteConHospit(idH);
  } else {
    console.log("factura normal");
    const formularioPaciente = document.getElementById("form-buscador-factura");
    if (formularioPaciente) {
      formularioPaciente.addEventListener("submit", function (e) {
        e.preventDefault();
        //buscarPaciente(formularioPaciente);
        buscarPacienteConCita(formularioPaciente);
      });
    }
  }

  //rendirizar los insumos
  setTimeout(() => {
    renderizarInsumos();
  }, 600);
});
