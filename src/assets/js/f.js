import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "./generic/funtionGeneric.js";
import Paginator from "./generic/Paginator.js";
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";
import { valorDolar, guardarTasaManual, tasaGuardada } from "./generic/coversion.js";
import {
  formatUSD,
  formatBS,
  parseMonto,
  valorEditable,
  montoDualHTML,
} from "./generic/moneda.js";

/** Obtiene un elemento por id devolviendo null en vez de lanzar. */
const byId = (id) => document.getElementById(id);
/** Igual que byId pero lanza un error claro si el elemento no existe. */
const need = (id) => {
  const el = byId(id);
  if (!el) throw new Error(`Elemento obligatorio ausente en el DOM: #${id}`);
  return el;
};
/** Convierte a número devolviendo 0 ante valores no numéricos (evita NaN).
 *  Acepta coma decimal ("10,50"), que es como se escribe en Venezuela. */
const num = (v) => {
  if (typeof v === "number") return Number.isFinite(v) ? v : 0;
  const n = parseFloat(String(v ?? "").trim().replace(",", "."));
  return Number.isFinite(n) ? n : 0;
};
/** Compara dos importes en céntimos enteros (evita los fallos de coma flotante). */
const sameMoney = (a, b) => Math.round(num(a) * 100) === Math.round(num(b) * 100);

// async porque el arranque espera a que carguen servicios, insumos y metodos
// de pago antes de renderizar (antes se usaba un setTimeout(600) fragil).
addEventListener("DOMContentLoaded", async function () {
  let data = [];
  let dataInsumo = [];
  let listaModalInsumo = [];

  // ── Estado del flujo de pago ─────────────────────────────────────────
  // metodosPago: métodos marcados en #modal-pago.
  // lineasPago:  filas de monto renderizadas en #modal-validacion.
  // Se declaran aquí (y no en el bloque de pagos) para que calcularTotal()
  // pueda refrescar los resúmenes sin caer en la zona muerta temporal.
  let metodosPago = [];
  let lineasPago = [];
  let refrescarResumenesPago = () => {};

  // Tasas y tipo de cambio: única fuente de verdad.
  // IVA_TASA llega del meta tag renderizado por PHP con src/config/config.php.
  const IVA_TASA = num(
    document.querySelector('meta[name="iva-tasa"]')?.getAttribute("content"),
  ) || 0.16;

// ── Tasa de cambio ─────────────────────────────────────────────────────
  // Antes se leía localStorage al instante: app.js arranca la petición a la API
  // pero no había terminado, así que la pantalla se pintaba con la tasa del día
  // anterior y se corregía sola recién al recargar.
  //
  // Regla: NUNCA se bloquea el primer pintado esperando a la red. Se aplica la
  // tasa cacheada de inmediato (si existe) y la de la API llega después para
  // repintar. Si la API no responde, la pantalla ya está usable.
  //
  // TIPO_CAMBIO es `let` a propósito: todas las funciones de cálculo leen el
  // mismo binding, así que un cambio manual se refleja en toda la pantalla.
  let TIPO_CAMBIO = 0;

  /** Fija la tasa y repinta los importes de toda la pantalla. */
  const aplicarTasa = (tasa) => {
    TIPO_CAMBIO = num(tasa);

    const caja = byId("cajaTasaCambio");
    const valor = byId("tasaCambioActual");
    const oculto = byId("inputTipoCambio");

    if (valor) {
      valor.innerText =
        TIPO_CAMBIO > 0 ? `1 USD = ${formatBS(TIPO_CAMBIO)}` : "Sin tasa";
    }
    if (caja) caja.classList.toggle("d-none", TIPO_CAMBIO > 0);
    // El formulario viaja con la tasa real usada en pantalla.
    if (oculto) oculto.value = TIPO_CAMBIO > 0 ? TIPO_CAMBIO.toFixed(4) : "";

    // Durante el arranque aún no hay datos que pintar: no se repinta nada.
    if (datosListos) {
      calcularTotal();
      mostrarServicios();
      mostrarInsumo();
    }
    return TIPO_CAMBIO;
  };

  /** Fecha de hoy en formato YYYY-MM-DD (hora local, no UTC). */
  const fechaDeHoy = () => {
    const d = new Date();
    const mes = String(d.getMonth() + 1).padStart(2, "0");
    const dia = String(d.getDate()).padStart(2, "0");
    return `${d.getFullYear()}-${mes}-${dia}`;
  };

  // Marca que los datos base ya cargaron: a partir de aquí los recálculos de
  // la tasa sí repintan la pantalla.
  let datosListos = false;

  /**
   * Pinta lo antes posible y refresca la tasa en segundo plano.
   *
   * No se espera a la red: cualquier fallo de la API deja la pantalla
   * funcionando con la tasa cacheada (o Avisa para que se ajuste a mano).
   */
  const inicializarTasa = () => {
    // 1):Tasa cacheada, de forma síncrona. La pantalla se pinta ya.
    const cache = tasaGuardada();
    if (cache > 0) aplicarTasa(cache);

    // 2) Botón para fijarla a mano (siempre disponible).
    byId("btnGuardarTasa")?.addEventListener("click", () => {
      const entered = prompt(
        "Ingrese la tasa de cambio (BS por dólar):",
        String(TIPO_CAMBIO || cache),
      );
      if (entered === null) return;

      try {
        aplicarTasa(guardarTasaManual(entered));
        alertSuccess("Tasa de cambio actualizada.");
      } catch (error) {
        alertError("Error", error.message);
      }
    });

// 3) Refresco desde la API en segundo plano. No bloquea nada.
    // `actualizada` indica si la API trajo datos de verdad. Antes se ignoraba el
    // resultado, así que una API caída pasaba sin avisar y el cajero facturaba
    // con una tasa vieja sin saberlo.
    valorDolar()
      .then((info) => {
        // a) La API respondió con una tasa válida.
        if (info.actualizada && info.tasa > 0) {
          aplicarTasa(info.tasa);
          datosListos = true;

          // El navegador puede bloquear localStorage (modo incógnito estricto):
          // la tasa funciona en esta pantalla pero se pierde al recargar.
          if (info.persistida === false) {
            alertError(
              "Tasa de cambio",
              "La tasa se obtuvo, pero el navegador no permite guardarla. Se perderá al recargar.",
            );
          }
          return;
        }

        // b) La API falló, pero hay una tasa guardada: se usa y se avisa.
        if (info.tasa > 0) {
          aplicarTasa(info.tasa);

          const motivo = info.error ? ` (${info.error})` : "";
          // alertError(
          //   "Tasa de cambio",
          //   `La API no respondió${motivo}. Se usa la última tasa registrada ` +
          //     `(${info.tasa.toFixed(2)} BS/$ del ${info.fecha || "día anterior"}). ` +
          //     `Verifíquela con el botón "cambiar".`,
          // );
          return;
        }

        // c) No hay tasa en ninguna parte: hay que obtenerla a mano.
        aplicarTasa(0);
        alertError(
          "Error",
          "No se pudo obtener la tasa de cambio. Use el botón 'cambiar' para ingresarla manualmente antes de facturar.",
        );
      })
      .catch((error) => {
        // La API nunca debe romper la pantalla.
        console.warn("Fallo al refrescar la tasa:", error?.message);
      });
  };

  const modalPaciente = bootstrap.Modal.getOrCreateInstance(
    byId("exampleModalagregarPaciente") ?? document.createElement("div"),
  );

  // Modal de "agregar cliente", el mismo que usa el módulo de Clientes.
  const modalCliente = bootstrap.Modal.getOrCreateInstance(
    byId("modalCliente") ?? document.createElement("div"),
  );

  const modalAgregarPaciente = byId("modalAgregar");

  // ── Referencias del DOM ────────────────────────────────────────────────
  const tabla = byId("tbody");
  const tbodyInsumos = byId("tbody-insumos");

  const inputCedulaPaciente = byId("input-cedula-paciente");
  const cedulaPaciente = byId("cedulaPaciente");

  const pacienteClienteCheck = document.querySelector(".paciente-cliente-check");
  const cajaBuscadorCliente = byId("caja-buscar-cliente");
  const formBuscadorOtroCliente = byId("form-buscador-otro-cliente");
  // Nombre del paciente/cliente en la pantalla principal.
  const dataCliente = byId("data-cliente");
  // Nombre del cliente cuando la factura es a nombre de otra persona. Tiene su
  // propio id: si compartiera "data-cliente", getElementById devolvería el de
  // la pantalla y el modal nunca mostraría el nombre.
  const dataClienteModal = byId("data-cliente-modal");
  const divClienteNoEncontrado = byId("div-cliente-no-encontrado");

  //botones de acciones en la factura
  const btnAddPac = byId("btnAddPac");
  const btnAddCli = byId("btnAddCli");
  const btnServicio = byId("botonAgregar");
  const btnInsumos = byId("btnInsumos");
  const btnVaciarTabla = byId("vaciarTabla");
  const btnSiguiente = byId("btnSiguiente");
  const inputTotalCita = byId("inputTotalCita");
  const inputTotalFactura = byId("totalFactura");
  const totalFacturaDivisa = byId("totalFacturaDivisa");
  const totalDeConfirmacion = byId("totalDeConfirmacion");
  const inputTotalDeConfirmacion = byId("inputTotalDeConfirmacion");
  // OJO: antes era document.getAnimations(...) que devuelve un array de
  // Animation; escribir .innerText sobre él no pintaba nada (fallo silencioso).
  // El total del modal de validación lo pinta refrescarResumenesPago().
  const inputPaciente = byId("inputPaciente");
  const inputHospitalizacion = byId("inputHospitalizacion");
  const inputCliente = byId("inputCliente");
  const btnTipoDePago = need("btnTipoDePago");
  //input de la referencia
  const inputRefencia = byId("inputRefencia");
  const inputReferenciaConfir = byId("referencia_confirmar");
  const pReferencia = byId("p-referencia");
  const divReferencia = byId("divReferencia");
  const inputIdCita = byId("inputIdCita");
  const botonPC = byId("botonPC");
  //boton del modal de validacion
  const btnValidacion = byId("btnValidacion");
  const divInputValidation = byId("divInputValidation");
  const divTypePagoCofirm = byId("divTypePagoCofirm");

  

  // Paginadores reutilizables: se crean una vez y se actualizan con setItems(),
  // de lo contrario cada render añadía otro listener al input de búsqueda.
  //
  // Se declaran aquí SIN instanciar y se construyen al final del handler
  // (ver "Creación de los paginadores"), cuando todas las funciones ya existen.
  // Instanciarlos aquí pasaba `addServicioTable` y `addInsumoTable` — declarados
  // más abajo con `const` — y lanzaba en tiempo de ejecución:
  //     ReferenceError: Cannot access 'addServicioTable' before initialization
  // Ese error abortaba TODO el handler: ningún listener quedaba registrado y el
  // buscador recargaba la página en vez de mostrar los datos del paciente.
  let paginadorServicios = null;
  let paginadorInsumos = null;

  /** Construye los paginadores. Debe ejecutarse tras declarar las funciones. */
  const crearPaginadores = () => {
    paginadorServicios = new Paginator(
      [],
      1,
      "div-modal-servicio",
      "paginationSer",
      "searchInputSer",
      (res) => returnFragmentHtmlSer(res),
      "id",
      (id) => addServicioTable(id),
    );

    paginadorInsumos = new Paginator(
      [],
      1,
      "div-modal-insumo",
      "pagination",
      "searchInput",
      (res) => returnFragmentHtml(res),
      "id_insumo",
      (id) => addInsumoTable(id),
    );
  };
  /** Muestra u oculta los botones de servicio/insumo según haya un paciente válido. */
  const setAccionesVisibles = (visibles) => {
    const clase = visibles ? "d-none" : "c";
    [btnServicio, btnInsumos].forEach((b) => {
      if (!b) return;
      b.classList.toggle("d-none", !visibles);
      b.classList.toggle("c", visibles);
    });
    void clase;
  };

  /** Calcula la edad en años a partir de una fecha de nacimiento. */
  const calcularEdad = (fechaNacimiento) => {
    if (!fechaNacimiento) return 0;
    const nac = new Date(fechaNacimiento);
    if (Number.isNaN(nac.getTime())) return 0;
    const hoy = new Date();
    let edad = hoy.getFullYear() - nac.getFullYear();
    const mes = hoy.getMonth() - nac.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < nac.getDate())) edad--;
    return Math.max(0, edad);
  };

  const buscarCliente = async (formulario) => {
    try {
      const datos = new FormData(formulario);
      let resultado = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarCliente",
        "POST",
        datos,
      );

      // executePetition devuelve {ok:false,error} ante HTTP >= 400 (p. ej. cédula
      // inválida). Antes se hacía .length sobre ese objeto y se rompía.
      if (!Array.isArray(resultado)) {
        throw new Error(resultado?.error ?? "Respuesta inválida del servidor.");
      }

      if (resultado.length > 0) {
        const res = resultado[0];
        const edad = calcularEdad(res.fn);

        // Se muestra dentro del modal de "otra persona", no en la pantalla principal.
        if (dataClienteModal) {
          dataClienteModal.innerText = `CLIENTE: ${res.nombre} ${res.apellido} Edad: ${edad}`;
        }
        if (inputCliente) inputCliente.value = res.id_cliente;

        divClienteNoEncontrado?.classList.add("d-none");
        btnAddCli?.classList.add("d-none");

        // El botón "Siguiente" del modal depende de la edad del cliente.
        setAccionesVisibles(true);
        if (botonPC) botonPC.classList.toggle("d-none", edad < 18);
      } else {
        if (dataClienteModal) dataClienteModal.innerText = "";
        if (inputCliente) inputCliente.value = "";
        divClienteNoEncontrado?.classList.remove("d-none");
        botonPC?.classList.add("d-none");
        btnAddCli?.classList.remove("d-none");
        setAccionesVisibles(false);
      }
    } catch (error) {
      alertError("Error", "Lamentablemente ocurrio un error: " + error.message);
      console.error(error);
    }
  };

  //buscador paciente cuando no tiene cita
  const buscarPaciente = async (formularioPaciente) => {
    try {
      const datos = new FormData(formularioPaciente);
      let resultado = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPaciente",
        "POST",
        datos,
      );

      if (!Array.isArray(resultado)) {
        throw new Error(resultado?.error ?? "Respuesta inválida del servidor.");
      }

      if (resultado.length > 0) {
        const res = resultado[0];
        const edad = calcularEdad(res.fn);

        dataCliente.innerText = `PACIENTE: ${res.nombre} ${res.apellido} Edad: ${edad}`;
        if (inputPaciente) inputPaciente.value = res.id_paciente;
        if (inputCliente) inputCliente.value = "";

        divClienteNoEncontrado?.classList.add("d-none");
        btnAddPac?.classList.add("d-none"); // ya existe, no hace falta registrarlo

        setAccionesVisibles(true);
        if (botonPC) botonPC.classList.toggle("d-none", edad < 18);
      } else {
        // Paciente inexistente: se ofrece el registro. Antes el TypeError sobre
        // #inputCliente abortaba aquí y el botón "Agregar Paciente" nunca aparecía.
        dataCliente.innerText = `El paciente no fue encontrado, debe registrarlo por favor.`;
        if (inputCliente) inputCliente.value = "";
        if (inputPaciente) inputPaciente.value = 0;
        if (inputIdCita) inputIdCita.value = "";
        botonPC?.classList.add("d-none");

        divClienteNoEncontrado?.classList.remove("d-none");
        btnAddPac?.classList.remove("d-none");
        setAccionesVisibles(false);
      }
    } catch (error) {
      alertError("Error", "Ocurrió un error al buscar el paciente: " + error.message);
      console.error(error);
    }
  };

  const createPatients = async (form) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar",
        "POST",
        data,
      );

      if (result?.ok) {
        alertSuccess(result.message);
        // Se dispara el flujo de busqueda real en vez de un "keyup" suelto:
        // antes solo copiaba la cedula y no volvia a consultar al servidor.
        if (inputCedulaPaciente && cedulaPaciente) {
          inputCedulaPaciente.value = cedulaPaciente.value;
          form.reset();
          modalPaciente.hide();
          buscarPacienteConCita(byId("form-buscador-factura") ?? form);
        }
      } else {
        throw new Error(`${result?.error ?? "No se pudo registrar el paciente."}`);
      }
    } catch (error) {
      alertError("Error", error.message ?? String(error));
    }
  };

  /**
   * Registra un cliente nuevo y lo asigna a la factura.
   *
   * Mismo comportamiento que el módulo de Clientes:
   *   - valida todos los campos con las expresiones modulares,
   *   - guarda por POST,
   *   - al volver a la factura rellena #inputCliente y muestra "Siguiente".
   */
  const createCliente = async (form, modal) => {
    try {
      const data = new FormData(form);
      const result = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Clientes/guardar",
        "POST",
        data,
      );

      if (result?.ok) {
        // El cliente recién creado se busca por la cédula que se acaba de
        // escribir: así se obtiene su id_cliente sin depender de la respuesta.
        const cedulaGuardada = form.querySelector('[name="cedula"]')?.value;
        modal?.hide();
        form.reset();

        if (cedulaGuardada) {
          const buscador = byId("form-buscador-otro-cliente");
          if (buscador) {
            const input = buscador.querySelector('[name="cedula"]');
            if (input) input.value = cedulaGuardada;
          }
          await buscarCliente(form);
        }

        alertSuccess(result.message ?? "Cliente registrado correctamente.");
      } else {
        throw new Error(result?.error ?? "No se pudo registrar el cliente.");
      }
    } catch (error) {
      alertError("Error", error.message ?? String(error));
    }
  };


  /** Limpia todo el estado de la factura antes de cargar un paciente nuevo. */
  const limpiarFactura = ({ conservarInsumos = false } = {}) => {
    data = [];
    if (!conservarInsumos) dataInsumo = [];
    if (inputIdCita) inputIdCita.value = "";
    if (inputHospitalizacion) inputHospitalizacion.value = "";
    if (inputCliente) inputCliente.value = "";
    if (tabla) tabla.innerHTML = "";
    if (tbodyInsumos) tbodyInsumos.innerHTML = "";
    ocultarBotones();
    calcularTotal();
    mostrarConfirmacion();
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

      if (!Array.isArray(resultado)) {
        throw new Error(resultado?.error ?? "Respuesta inválida del servidor.");
      }

      if (resultado.length > 0) {
        // Cita encontrada, actualizar UI con datos de la cita
        const cita = resultado[0];

        // 1. Limpiar la factura anterior: buscar un segundo paciente arrastraba
        //    los insumos y el id_cita del primero (datos cruzados entre pacientes).
        limpiarFactura();

        // 2. Actualizar datos del paciente
        const edad = calcularEdad(cita.fecha_de_nacimiento);
        dataCliente.innerText = `PACIENTE: ${cita.nombre_p} ${cita.apellido_p} Edad: ${edad} años`;
        if (inputPaciente) inputPaciente.value = cita.id_paciente;
        if (botonPC) botonPC.classList.toggle("d-none", edad < 18);

        divClienteNoEncontrado?.classList.add("d-none");
        btnAddPac?.classList.add("d-none");

        // 3. Agregar el servicio de la cita
        insertarServicio(
          cita.id_servicioMedico,
          cita.categoria,
          `DR: ${cita.nombre_d} ${cita.apellido_d}`,
          num(cita.precio),
          cita.id_doctor_c,
        );

        // 4. Agregar el id cita para enviarlo
        if (inputIdCita) inputIdCita.value = cita.id_cita;

        // 5. Habilitar botones de acción
        setAccionesVisibles(true);
      } else {
        // No se encontró cita, buscar solo paciente
        limpiarFactura();
        await buscarPaciente(formularioPaciente);
      }
    } catch (error) {
      alertError("Error", "Ocurrió un error al buscar la cita del paciente: " + error.message);
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

      if (!Array.isArray(resultado) || resultado.length === 0) {
        alertError(
          "Error",
          "Lamentablemente no hay hospitalizaciones con ese número",
        );
        return;
      }

      // hospitalizacion encontrada, actualizar UI con datos de la hospitalizacion
      const hospit = resultado[0];

      // 1. Actualizar datos del paciente
      const edad = calcularEdad(hospit.fecha_de_nacimiento);
      dataCliente.innerText = `PACIENTE: ${hospit.nombre_p} ${hospit.apellido_p} Edad: ${edad} años`;
      if (inputPaciente) inputPaciente.value = hospit.id_paciente;
      if (inputHospitalizacion) inputHospitalizacion.value = hospit.id_hospitalizacion;

      // En hospitalización el botón de "otra persona" no aplica al flujo actual.
      if (botonPC) botonPC.classList.remove("d-none");

      divClienteNoEncontrado?.classList.add("d-none");
      btnAddPac?.classList.add("d-none");

      // 2. Limpiar datos previos (conservando insumos: se recargan abajo)
      limpiarFactura();

      // 3. Cargar servicios e insumos de la hospitalización
      (hospit.servicios ?? []).forEach((servicio) => {
        insertarServicio(
          servicio.id_servicioMedico,
          servicio.categoria,
          `${servicio.nombre_d} ${servicio.apellido_d}`,
          num(servicio.precios_servicio),
          servicio.id_doctor,
        );
      });

      (hospit.insumos ?? []).forEach((insumo) => {
        // insertarInsumoSeleccionado() avisa con un Swal por cada insumo: en
        // hospitalización son varios y se acumulan. Se inserta en silencio.
        insertarInsumoSeleccionado(
          insumo.id_entradaDeInsumo,
          insumo.cantidad,
          insumo.nombre,
          insumo.precio,
          insumo.iva,
          insumo.medida,
          { silencioso: true },
        );
      });

      calcularTotal();
    } catch (error) {
      alertError("Error", error.message ?? String(error));
      console.error(error);
    }
  };

  const returnFragmentHtmlSer = (res) => {
    const precio = num(res.precio);
    return `<div class="card card-servicio p-4" style="cursor: pointer;" data-index=${res.id_servicioMedico + "" + res.id_personal} data-id-servicio="${res.id_servicioMedico}" data-doctor="${res.id_personal}">
        <!-- nombre del insumo (podemos cambiarlo dinámicamente) -->
        <div class="text-center nombre-card-factura">
            <span>${res.categoria}</span>
        </div>
        <span class="text-center mb-2">DR: ${res.nombre_d} ${res.apellido_d}</span>

        <span class="text-center mb-2">Precio: ${formatUSD(precio)}</span>
        <span class="text-center mb-2 ">${formatBS(precio * TIPO_CAMBIO)}</span>

        <input type="hidden" value=${precio.toFixed(2)} class="precio-servicio">

        <!-- pequeños detalles decorativos al estilo bootstrap pero con personalidad -->

                 <button type="button" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                   res.id_servicioMedico + "" + res.id_personal
                 }">Agregar</button>
    </div>`;
  };

  const addServicioTable = (id) => {
    const cardServicios = document.querySelector(`.card[data-index="${id}"]`);
    if (!cardServicios) return;

    let filterService = data.find(
      (d) =>
        d.id_servicio == cardServicios.getAttribute("data-id-servicio") &&
        d.id_doctor == cardServicios.getAttribute("data-doctor"),
    );
    if (filterService) {
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

      if (!Array.isArray(result)) {
        throw new Error(result?.error ?? "Respuesta inválida del servidor.");
      }

      // Reutiliza el paginador: antes se creaba uno nuevo en cada llamada y
      // cadaPaginator añadía otro listener al input de búsqueda.
      paginadorServicios.setItems(result);
    } catch (error) {
      alertError("Error", `Lamentablemente algo salio mal ${error.message}`);
      console.error(error);
    }
  };

  const traerInsumos = async () => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarInsumos`,
        "GET",
      );

      if (!Array.isArray(result)) {
        throw new Error(result?.error ?? "Respuesta inválida del servidor.");
      }

      // Stock original por insumo. `disponible` se descuenta sobre una copia
      // para que el filtro del modal no destruya el stock real (al borrar un
      // insumo, este debe poder volver a aparecer).
      listaModalInsumo = result.map((i) => ({
        ...i,
        disponible: num(i.disponible),
        disponibleOriginal: num(i.disponible),
        precio: num(i.precio),
      }));
    } catch (error) {
      alertError("Error", `Lamentablemente algo salio mal ${error.message}`);
      console.error(error);
    }
  };

  const addInsumoTable = (id_insumo) => {
    const card = document.querySelector(`.card-insumo[data-index="${id_insumo}"]`);
    if (!card) return;

    const cantidad = parseInt(card.querySelector(".cantidadDisplay").value);
    const id = card.getAttribute("data-index");
    const nombre = card.querySelector(".title-insumo").innerText;
    const precio = card.getAttribute("data-precio");
    const iva = card.getAttribute("iva");
    const medida = card.getAttribute("data-medida");
    const stockDisponible = parseInt(card.getAttribute("data-cantidad"));

    if (cantidad > 0 && cantidad <= stockDisponible) {
      insertarInsumoSeleccionado(id, cantidad, nombre, precio, iva, medida);
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
              <li class=""><strong>IVA:</strong> ${String(res.iva) === "1" ? `Sí (${(IVA_TASA * 100).toFixed(0)}%)` : "No"}</li>
              <li class=""><strong>Stock:</strong> ${res.disponible} unidades</li>
            </ul>

            <div>
              <div class="precio-principal">${formatUSD(num(res.precio))} <span class=" small">(${formatBS(num(res.precio) * TIPO_CAMBIO)})</span></div>
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
    // Filtro NO destructivo: antes `listaModalInsumo = listaModalInsumo.filter(...)`
    // eliminaba del array los insumos agotados, asi que al borrar uno ya nunca
    // volvia a aparecer en el modal.
    const conStock = listaModalInsumo.filter((l) => num(l.disponible) > 0);
    paginadorInsumos.setItems(conStock);

    // Clamp del input de cantidad. Antes se buscaba la clase
    // ".input-cantidad-custom", que no existe en el HTML: todo este bloque era
    // codigo muerto y el usuario podia escribir cualquier cantidad.
    document.querySelectorAll(".cantidadDisplay").forEach((input) => {
      const card = input.closest(".card-insumo");
      if (!card) return;
      const MAX = parseInt(input.getAttribute("max")) || 1;
      const MIN = 1;

      const actualizarEstado = () => {
        let valor = parseInt(input.value);
        if (!Number.isFinite(valor) || valor < MIN) valor = MIN;
        if (valor > MAX) {
          valor = MAX;
          alertError("Error", `Solo hay ${MAX} unidades disponibles de este insumo.`);
        }
        input.value = valor;
        card.classList.toggle("seleccionada", valor > 0);
      };

      input.addEventListener("input", actualizarEstado);
      input.addEventListener("keydown", (e) => {
        if (e.key === "-" || e.key === "e") e.preventDefault();
      });

      actualizarEstado();
    });
  };

  const insertarServicio = (id, servicio, doctor, precio, id_doctor) => {
    const obj = {
      id_servicio: id,
      servicio: servicio,
      doctor: doctor,
      precio: num(precio),
      id_doctor: id_doctor,
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
    { silencioso = false } = {},
  ) => {
    const cant = parseInt(cantidad);
    if (!(cant > 0)) return;

    const insumoBase = listaModalInsumo.find((i) => i.id_insumo == id);

    // Nunca dejar que lo seleccionado supere el stock disponible real.
    if (insumoBase && cant > num(insumoBase.disponible)) {
      alertError(
        "Error",
        `No hay stock suficiente de ${nombre}. Disponibles: ${insumoBase.disponible}.`,
      );
      return;
    }

    const insumoSeleccionado = dataInsumo.find((i) => i.id_insumo == id);

    // Si ya estaba en la factura se acumula la cantidad, si no se agrega.
    if (insumoSeleccionado) {
      insumoSeleccionado.cantidad += cant;
    } else {
      dataInsumo.push({
        id_insumo: id,
        cantidad: cant,
        nombre: nombre,
        precio: num(precio),
        medida: medida,
        iva: iva,
      });
    }

    // El stock restante se descuenta sobre el original, nunca sobre el filtro.
    if (insumoBase) insumoBase.disponible = num(insumoBase.disponible) - cant;

    renderizarInsumos();
    mostrarInsumo();

    if (!silencioso) alertSuccess("Se agrego correctamente el insumo.");
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

  btnSiguiente.addEventListener("click", () => {
    botonPC?.classList.remove("d-none");
  });

  /**
   * Precio unitario final de un insumo en divisa.
   * `insumo.iva` es un booleano (tinyint 0/1), NO un monto: antes se hacía
   * parseFloat(iva) y se sumaba como si fueran dólares.
   */
  const precioUnitarioInsumo = (insumo) => {
    const base = num(insumo.precio);
    if (String(insumo.iva) !== "1") return base;
    // El servidor redondea el precio unitario CON IVA a 2 decimales antes de
    // pasarlo a bolívares. Sin ese redondeo el navegador cobraba unos céntimos
    // de divisa de más (varios bolívares con la tasa actual).
    return Math.round(base * (1 + IVA_TASA) * 100) / 100;
  };

  /** Importe en divisa -> bolívares, con el redondeo por línea del servidor. */
  const divisaABs = (divisa) =>
    Math.round(num(divisa) * TIPO_CAMBIO * 100) / 100;

  /** Subtotal en divisa de todos los insumos de la factura. */
  const subtotalInsumosDivisa = () =>
    dataInsumo.reduce(
      (acc, i) => acc + precioUnitarioInsumo(i) * (parseInt(i.cantidad) || 0),
      0,
    );

  /** Subtotal en divisa de los servicios (incluye el de la cita). */
  const subtotalServiciosDivisa = () =>
    data.reduce((acc, s) => acc + num(s.precio), 0);

  function calcularTotal() {
    // Base de la cita / hospitalizacion (en divisa)
    const baseCita = Math.round(num(inputTotalCita?.value) * 100) / 100;

    // El servidor guarda el detalle redondeando CADA línea a 2 decimales y
    // luego suma (ver ModeloFactura::calcularTotalDesdeDetalle). Redondear una
    // sola vez al final, como se hacía antes, descuadraba la factura en unos
    // céntimos por línea y el backend la rechazaba por "no cubre el total".
    const totalBS = parseFloat(
      (
        divisaABs(baseCita) +
        data.reduce((acc, s) => acc + divisaABs(s.precio), 0) +
        dataInsumo.reduce(
          (acc, insumo) =>
            acc +
            divisaABs(precioUnitarioInsumo(insumo)) *
              (parseInt(insumo.cantidad) || 0),
          0,
        )
      ).toFixed(2),
    );

    if (inputTotalFactura) inputTotalFactura.value = totalBS.toFixed(2);
    if (totalFacturaDivisa) {
      // Equivalente en divisa junto al total (guía: ambas monedas siempre).
      totalFacturaDivisa.innerHTML =
        TIPO_CAMBIO > 0 ? `≈ ${formatUSD(totalBS / TIPO_CAMBIO)}` : "";
    }
    // Total del modal de confirmación: USD resaltado + Bs atenuado.
    if (totalDeConfirmacion) {
      totalDeConfirmacion.innerHTML = montoDualHTML(totalBS, TIPO_CAMBIO);
    }
    if (inputTotalDeConfirmacion) inputTotalDeConfirmacion.value = totalBS.toFixed(2);

    // Mantiene sincronizados los resúmenes de pago (total, pagado, pendiente
    // y vuelto) cuando cambia el contenido de la factura o la tasa.

    refrescarResumenesPago();

    return totalBS;
  }

  // // Funcion para actualizar la tabla  servicios

  function mostrarServicios() {
    calcularTotal();
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;

    data.forEach((element, index) => {
      const precioDivisa = num(element.precio);
      const montoBS = divisaABs(precioDivisa);

      html += `
          <tr class="border-top">
          <td class="border-top"><div class="fw-bolder">SERVICIO :</div> ${element.servicio}</td>
          <td class="border-top"><div class="fw-bolder">DOCTOR:</div> ${element.doctor}</td>
          <td class="border-top">
            <div class="fw-bolder">PRECIO:</div>
            <p class="mb-1">${montoDualHTML(montoBS, TIPO_CAMBIO)}</p>
          </td>
          <td class="border-top"></td>

          <td class="border-top">

          <button type="button" class="eliminar btn btn-tabla mt-1" data-index="${index}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
          </svg></button>
          </td>
          </tr>`;
    });

    if (tabla) tabla.innerHTML = html;

    // Añadimos los eventos a los botones de eliminar
    document.querySelectorAll(".eliminar").forEach((ele) => {
      ele.addEventListener("click", function () {
        alertConfirm("Desea eliminar este servicio medico?", eliminarElement, this);
      });
    });

    ocultarBotones();
    mostrarConfirmacion();
  }

  //mostrar insumos
  function mostrarInsumo() {
    calcularTotal();
    let html = ``;

    dataInsumo.forEach((element, index) => {
      const cantidad = parseInt(element.cantidad) || 0;
      const precioUnitario = precioUnitarioInsumo(element); // ya con IVA aplicado
      const precioUnitarioBs = divisaABs(precioUnitario);
      const precioBaseBs = divisaABs(element.precio);
      const subtotalBs = precioUnitarioBs * cantidad;
      const ivaBs = Math.max(0, precioUnitarioBs - precioBaseBs) * cantidad;

      html += `
          <tr class="border-top tr">
          <th class="id_insumo_escondido d-none">${element.id_insumo}</th>
          <td class="border-top nombre"><div class="fw-bolder">INSUMO:</div> ${element.nombre}</td>
          <td class="border-top nombre"><div class="fw-bolder">Medida:</div> ${element.medida}</td>
          <td class="border-top"><div class="fw-bolder">CANTIDAD:</div> ${cantidad}</td>
          <td class="border-top"><div class="fw-bolder">PRECIO:</div>
          ${montoDualHTML(precioBaseBs, TIPO_CAMBIO)}</td>
          <td class="border-top"><div class="fw-bolder">IVA:</div>${montoDualHTML(ivaBs, TIPO_CAMBIO)}</td>
          <td class="border-top">
            <div class="fw-bolder">SUB-TOTAL:</div>
            <p class="mb-1">${montoDualHTML(subtotalBs, TIPO_CAMBIO)}</p>
          </td>
          <td class="border-top"></td>

          <td class="border-top">

          <button type="button" class="eliminar-insumo btn btn-tabla mt-1" style="margin-right: 7px;" data-cantidad="${cantidad}" data-id-insumo="${element.id_insumo}" data-index="${index}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
          </svg></button>
          </td>
          </tr>`;
    });

    if (tbodyInsumos) tbodyInsumos.innerHTML = html;

    // Añadimos los eventos a los botones de eliminar
    document.querySelectorAll(".eliminar-insumo").forEach((ele) => {
      ele.addEventListener("click", function () {
        alertConfirm("Desea eliminar este insumo?", eliminarInsumo, this);
      });
    });

    ocultarBotones();
    mostrarConfirmacion();
  }

  const eliminarElement = (btn) => {
    data.splice(Number(btn.dataset.index), 1);
    mostrarServicios();
  };

  const eliminarInsumo = (btn) => {
    const id = btn.getAttribute("data-id-insumo");
    const cantidad = parseInt(btn.getAttribute("data-cantidad")) || 0;

    dataInsumo.splice(Number(btn.dataset.index), 1);

    // Devolver el stock al array original para que el insumo vuelva a aparecer
    // en el modal si queda existencias.
    const insumoBase = listaModalInsumo.find((i) => i.id_insumo == id);
    if (insumoBase) insumoBase.disponible = num(insumoBase.disponible) + cantidad;

    renderizarInsumos();
    mostrarInsumo();
    alertSuccess("Se elimino correctamente el insumo.");
  };

  /** Boton VACIAR: limpia servicios, insumos y devuelve todo el stock. */
  const vaciarFactura = () => {
    data = [];
    dataInsumo = [];
    listaModalInsumo.forEach((i) => {
      i.disponible = i.disponibleOriginal ?? i.disponible;
    });
    if (inputIdCita) inputIdCita.value = "";
    if (tabla) tabla.innerHTML = "";
    if (tbodyInsumos) tbodyInsumos.innerHTML = "";
    renderizarInsumos();
    ocultarBotones();
    calcularTotal();
    mostrarConfirmacion();
    alertSuccess("Se vacio la factura.");
  };

  // ══════════════════════════════════════════════════════════════════════
  //  FLUJO DE PAGO (único y mixto)
  // ══════════════════════════════════════════════════════════════════════
  // Estado:
  //   metodosPago -> métodos marcados en #modal-pago.
  //   lineasPago  -> filas de monto de #modal-validacion. El importe SIEMPRE
  //                  se guarda en céntimos de bolívar, sin importar la moneda
  //                  con la que se escriba en pantalla.
  //
  // Secuencia (guía Promp_metodo_pago.md):
  //   1. #modal-pago         elegir uno o varios métodos.
  //   2. #modal-validacion   repartir montos y ver pendiente/vuelto en Bs y USD.
  //   3. #modal-confirmacion revisar el detalle y confirmar.
  //
  // Reglas:
  //   · Todas las combinaciones pasan por la verificación: es la única pantalla
  //     donde se registra lo que recibió el cajero y se calcula el vuelto. Un
  //     único método llega con el total precargado, así que avanzar es un clic.
  //   · Pago Móvil y Transferencia no se combinan: comparten una sola
  //     `referencia` en la factura.
  //   · El vuelto solo puede salir de métodos que lo admiten (efectivo y
  //     divisas) y se descuenta del monto NETO que viaja al servidor, porque
  //     el backend exige que la suma de montos sea exactamente el total.

  const MODAL_PAGO = "modal-pago";
  const MODAL_VALIDACION = "modal-validacion";
  const MODAL_CONFIRMACION = "modal-confirmacion";

  /** Métodos de pago que exigen referencia bancaria. */
  const METODOS_CON_REFERENCIA = ["pago movil", "pago móvil", "transferencia"];

  const normalizarTexto = (v) => String(v ?? "").trim().toLowerCase();

  const requiereReferencia = (nombre) =>
    METODOS_CON_REFERENCIA.includes(normalizarTexto(nombre));

  /** Divisas se capturan en USD; el resto en bolívares. */
  const esDivisa = (nombre) => /divisa|d[oó]lar|zelle|usd/.test(normalizarTexto(nombre));

  /** Solo el efectivo y las divisas pueden devolver vuelto. */
  const admiteVuelto = (nombre) =>
    /efectivo|divisa|d[oó]lar|zelle|usd/.test(normalizarTexto(nombre));

  // ── Importes ──────────────────────────────────────────────────────────
  // Todo el flujo trabaja en céntimos enteros: sumar 0.1 + 0.2 en floats
  // hacía que el total "no cuadrara" por un céntimo y el botón nunca se
  // habilitara.

  const aCentimos = (v) => Math.round(num(v) * 100);
  const deCentimos = (c) => c / 100;

  /** Importe en bolívares: `Bs. 1.949.706,00`. */
  const enBs = (cent) => formatBS(deCentimos(Math.round(num(cent))));

  /** Equivalente en dólares ("" si todavía no hay tasa). */
  const enUsd = (cent) =>
    TIPO_CAMBIO > 0 ? formatUSD(deCentimos(Math.round(num(cent))) / TIPO_CAMBIO) : "";

  /**
   * Bloque estándar de doble moneda de la guía:
   * `$ 50.00` resaltado + `Bs. 44.311,50` atenuado.
   */
  const dual = (cent, principal = "USD") =>
    montoDualHTML(deCentimos(Math.round(num(cent))), TIPO_CAMBIO, principal);

  /** Texto para los avisos: no admite HTML, así que va en una sola línea. */
  const textoDual = (cent) => {
    const bolivares = enBs(cent);
    const dolares = enUsd(cent);
    return dolares ? `${bolivares} (${dolares})` : bolivares;
  };

  const totalFacturaCent = () =>
    Math.max(0, aCentimos(inputTotalFactura?.value));

  const setTexto = (id, texto) => {
    const el = byId(id);
    if (el) el.innerText = texto;
  };

  const setHTML = (id, html) => {
    const el = byId(id);
    if (el) el.innerHTML = html;
  };

  const resaltar = (id, activo, clase) => {
    const el = byId(id);
    if (el) el.classList.toggle(clase, activo);
  };

  /**
   * Convierte lo escrito por el cajero a céntimos de bolívar.
   * Acepta "1.234,56", "1234.56", "Bs. 45.643,25" y "$ 50.00"; en modo divisa
   * multiplica por la tasa. Devuelve null si el texto no es un número.
   */
  const parsearMontoCent = (texto, moneda) => {
    const valor = parseMonto(texto);
    if (valor === null || valor < 0) return null;

    const enBolivares = moneda === "USD" ? valor * TIPO_CAMBIO : valor;
    if (!Number.isFinite(enBolivares)) return null;

    return Math.round(enBolivares * 100);
  };

  /** Importe editable que se pinta en el input según la moneda de la línea. */
  const formatearMontoLinea = (linea) => {
    if (!linea || !linea.montoCent) return "";
    if (linea.moneda === "USD") {
      // 4 decimales: con 2, el ida y vuelta USD -> Bs -> USD movía el importe
      // varios bolívares por el redondeo.
      return TIPO_CAMBIO > 0
        ? valorEditable(deCentimos(linea.montoCent) / TIPO_CAMBIO, 4)
        : "";
    }
    return valorEditable(deCentimos(linea.montoCent), 2);
  };

  /** Equivalencia de la línea, siempre con las dos monedas. */
  const textoEquivalencia = (linea) => {
    if (!linea || !Number.isFinite(linea.montoCent) || linea.montoCent <= 0) return "";
    return `Ingresado: ${dual(linea.montoCent)}`;
  };

  // ── Navegación entre modales ─────────────────────────────────────────
  /**
   * Abre un modal cerrando antes el actual. Bootstrap no soporta dos modales
   * abiertos a la vez: al abrirlos en paralelo el backdrop queda huérfano y
   * el <body> pierde `modal-open` (la página de atrás se puede desplazar).
   */
  const abrirModalSecuencial = (idDestino) => {
    const destino = byId(idDestino);
    if (!destino) return;

    const actual = Array.from(document.querySelectorAll(".modal.show")).find(
      (modal) => modal !== destino,
    );

    let abierto = false;
    const abrir = () => {
      if (abierto) return;
      abierto = true;
      bootstrap.Modal.getOrCreateInstance(destino).show();
    };

    if (!actual) {
      abrir();
      return;
    }

    actual.addEventListener("hidden.bs.modal", abrir, { once: true });
    bootstrap.Modal.getOrCreateInstance(actual).hide();
    // Red de seguridad: si la animación no dispara el evento (modal ya
    // oculto), el destino se abre igualmente.
    window.setTimeout(abrir, 600);
  };

  // ── Selección de métodos ─────────────────────────────────────────────

  const etiquetaMetodo = (check) =>
    (check.closest(".form-check")?.querySelector(".form-check-label")?.innerText ??
      "").trim();

  const leerMetodosSeleccionados = () =>
    Array.from(document.querySelectorAll(".tiposDePago"))
      .filter((check) => check.checked)
      .map((check) => ({ id: String(check.value), nombre: etiquetaMetodo(check) }));

  const mostrarAvisoPago = (texto) => {
    const aviso = byId("avisoPago");
    if (!aviso) return;
    aviso.innerText = texto;
    aviso.classList.toggle("d-none", !texto);
  };

  /** Sincroniza el estado, el aviso y el botón "Siguiente" del modal de pago. */
  const actualizarSeleccionPago = () => {
    let seleccion = leerMetodosSeleccionados();

    // Pago Móvil y Transferencia comparten la única `referencia` de la
    // factura, así que no se pueden combinar. Se conserva el último marcado.
    const conReferencia = seleccion.filter((m) => requiereReferencia(m.nombre));
    if (conReferencia.length > 1) {
      const conservado = conReferencia[conReferencia.length - 1];
      document.querySelectorAll(".tiposDePago").forEach((check) => {
        if (
          check.checked &&
          String(check.value) !== conservado.id &&
          requiereReferencia(etiquetaMetodo(check))
        ) {
          check.checked = false;
        }
      });
      seleccion = leerMetodosSeleccionados();
      mostrarAvisoPago(
        `Solo puede usar un método con referencia a la vez. Se mantuvo ${conservado.nombre}.`,
      );
    } else {
      mostrarAvisoPago("");
    }

    metodosPago = seleccion;
    btnTipoDePago.classList.toggle("d-none", metodosPago.length === 0);
  };

  const mostrarTiposDePago = async () => {
    try {
      const result = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarMetodosDePago",
        "GET",
      );
      if (!Array.isArray(result)) {
        throw new Error(result?.error ?? "Respuesta inválida del servidor.");
      }

      let html = "";
      result.forEach((res, index) => {
        const nombre = String(res.nombre ?? "");
        // La moneda en la que se captura el método se muestra en la propia
        // fila: evita que el cajero escriba dólares en un campo de bolívares.
        const moneda = esDivisa(nombre) ? "USD" : "Bs.";

        html += `
          <div class="form-check form-switch d-flex align-items-center">
            <div>
              <input class="form-check-input tiposDePago" type="checkbox" role="switch"
                id="flexSwitchCheckDefault${index}" value="${res.id_pago}">
            </div>
            <div class="flex-grow-1">
              <label class="form-check-label mt-2" for="flexSwitchCheckDefault${index}">
                ${nombre}
              </label>
            </div>
            <span class="badge bg-light text-dark border" title="Moneda del método">${moneda}</span>
          </div>`;
      });

      // Solo se reemplaza la lista: el resumen del modal se conserva.
      const lista = byId("listaMetodosPago");
      if (lista) lista.innerHTML = html;

      document.querySelectorAll(".tiposDePago").forEach((check) => {
        check.addEventListener("change", actualizarSeleccionPago);
      });

      actualizarSeleccionPago();
    } catch (error) {
      alertError(
        "Error",
        "No se pudieron cargar los métodos de pago: " + (error?.message ?? error),
      );
    }
  };

  // ── Validación del pago ──────────────────────────────────────────────

  const ICONO_DINERO = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"></path>
    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"></path>
    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"></path>
    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path>
  </svg>`;

  const ICONO_CHECK = `<svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
  </svg>`;

  const ICONO_ERROR = `<svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
  </svg>`;

  /**
   * Pinta el estado de un campo (borde, icono y mensaje) sin depender de
   * expresionesModulares: su expresión de "precio" rechaza importes como
   * 0.50 o 1.00, que aquí son perfectamente válidos.
   */
  const marcarCampo = (input, mensajeError) => {
    if (!input) return;
    const campo = input.closest(".campo-custom");
    const contenedor = input.closest(".input-custom");
    const check = campo?.querySelector(".check");
    const error = campo?.querySelector(".error");
    const pError = campo?.querySelector(".error-msg");

    const vacio = String(input.value ?? "").trim() === "";
    const ok = !mensajeError;

    contenedor?.classList.toggle("valido", ok);
    contenedor?.classList.toggle("invalido", !ok && !vacio);
    if (check) check.classList.toggle("d-none", !ok);
    if (error) error.classList.toggle("d-none", ok || vacio);
    if (pError) {
      pError.innerText = ok || vacio ? "" : mensajeError;
      pError.classList.toggle("d-none", ok || vacio);
    }
  };

  const marcarReferencia = () => {
    if (!inputRefencia) return;
    const valor = inputRefencia.value.trim();
    marcarCampo(
      inputRefencia,
      /^\d{4}$/.test(valor) ? "" : "La referencia debe tener los últimos 4 dígitos.",
    );
  };

  /** Reparte el vuelto entre los métodos que pueden devolverlo. */
  const netearPagos = (exceso) => {
    const netas = lineasPago.map((linea) => ({
      ...linea,
      neto: Math.max(0, linea.montoCent || 0),
    }));

    let resto = Math.max(0, exceso);
    const orden = netas
      .map((linea, index) => ({ index, linea }))
      .filter(({ linea }) => admiteVuelto(linea.nombre))
      .sort((a, b) => b.linea.neto - a.linea.neto);

    for (const { index } of orden) {
      if (resto <= 0) break;
      // Cada método debe conservar al menos un céntimo: el backend rechaza
      // cualquier monto en cero.
      const disponible = Math.max(0, netas[index].neto - 1);
      const quitar = Math.min(resto, disponible);
      netas[index].neto -= quitar;
      resto -= quitar;
    }

    return { netas, resto };
  };

  const calcularEstadoPago = () => {
    const total = totalFacturaCent();
    const pagado = lineasPago.reduce(
      (acc, linea) =>
        acc + (Number.isFinite(linea.montoCent) ? Math.max(0, linea.montoCent) : 0),
      0,
    );
    const falta = Math.max(0, total - pagado);
    const vuelto = Math.max(0, pagado - total);
    return { total, pagado, falta, vuelto };
  };

  /** Devuelve el primer problema que impide continuar (o null si todo está bien). */
  const validarPago = () => {
    const estado = calcularEstadoPago();

    if (estado.total <= 0) return "La factura no tiene ningún monto que cobrar.";
    if (lineasPago.length === 0) return "Seleccione al menos un método de pago.";

    // Montos: todos deben existir y ser mayores a cero.
    const sinMonto = lineasPago.find(
      (linea) => !Number.isFinite(linea.montoCent) || linea.montoCent <= 0,
    );
    if (sinMonto) return `Indique el monto de ${sinMonto.nombre}.`;

    if (estado.falta > 0) {
      return `Falta ${textoDual(estado.falta)} por cubrir.`;
    }

    if (estado.vuelto > 0) {
      const { resto } = netearPagos(estado.vuelto);
      if (resto > 0) {
        return `El vuelto de ${textoDual(estado.vuelto)} no puede entregarse con los métodos elegidos. Ajuste los montos o reduzca el efectivo/divisas.`;
      }
    }

    const necesitaReferencia = lineasPago.some((linea) =>
      requiereReferencia(linea.nombre),
    );
    if (necesitaReferencia && !/^\d{4}$/.test((inputRefencia?.value ?? "").trim())) {
      return "La referencia debe tener los últimos 4 dígitos.";
    }

    return null;
  };

  const actualizarBotonValidacion = () => {
    if (!btnValidacion) return;
    const problema = validarPago();
    btnValidacion.disabled = problema !== null;

    const alerta = byId("alertaValidacion");
    if (alerta) {
      alerta.innerText = problema ?? "";
      alerta.classList.toggle("d-none", problema === null);
    }

    if (divReferencia && !divReferencia.classList.contains("d-none")) {
      marcarReferencia();
    }
  };

  /** Construye y pinta las filas de monto del modal de validación. */
  const renderizarLineasPago = () => {
    if (!divInputValidation) return;

    divInputValidation.innerHTML = lineasPago
      .map((linea, index) => {
        const enUsd = linea.moneda === "USD";
        return `
        <div class="linea-pago border rounded p-2 mb-2" data-index="${index}">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="label-custom mb-0" for="monto-pago-${index}">${linea.nombre}</label>
            <button type="button" class="btn btn-link p-0 small cambiar-moneda" data-index="${index}">
              ${enUsd ? "Ver en Bs" : "Ver en USD"}
            </button>
          </div>
          <div class="campo-custom">
            <div class="input-custom">
              <span class="icono-izq">${ICONO_DINERO}</span>
              <input id="monto-pago-${index}" class="form-control txt-custom input-modal-monto"
                data-index="${index}" type="text" inputmode="decimal" autocomplete="off"
                placeholder="Monto en ${enUsd ? "USD" : "Bs"}">
              <span class="icono-der">${ICONO_CHECK}${ICONO_ERROR}</span>
            </div>
            <p class="error-msg d-none p-error-validaciones"></p>
          </div>
          <p class="equivalente-moneda small  mb-0" data-index="${index}"></p>
        </div>`;
      })
      .join("");

    // Valor inicial: si hay un único método se precarga el total; con varios
    // el cajero decide cómo repartirlo.
    divInputValidation.querySelectorAll(".input-modal-monto").forEach((input) => {
      const index = Number(input.dataset.index);
      const linea = lineasPago[index];
      if (!linea) return;
      input.value = formatearMontoLinea(linea);

      input.addEventListener("input", () => {
        linea.montoCent = parsearMontoCent(input.value, linea.moneda);
        refrescarResumenesPago();
      });

      // Al salir del campo se muestra el importe ya normalizado.
      input.addEventListener("blur", () => {
        if (!input.value.trim()) return;
        input.value = formatearMontoLinea(linea);
        refrescarResumenesPago();
      });

      // Enter avanza como el botón "Siguiente" (no recarga la página).
      input.addEventListener("keydown", (e) => {
        if (e.key !== "Enter") return;
        e.preventDefault();
        input.blur();
        if (!btnValidacion.disabled) btnValidacion.click();
      });
    });

    // Conversión bidireccional: el importe canónico (céntimos de bolívar) no
    // cambia, solo la forma de mostrarlo.
    divInputValidation.querySelectorAll(".cambiar-moneda").forEach((boton) => {
      boton.addEventListener("click", () => {
        const index = Number(boton.dataset.index);
        const linea = lineasPago[index];
        if (!linea) return;

        if (linea.moneda !== "USD" && TIPO_CAMBIO <= 0) {
          alertError("Error", "No hay tasa de cambio disponible para mostrar el monto en divisa.");
          return;
        }

        linea.moneda = linea.moneda === "USD" ? "BS" : "USD";
        boton.innerText = linea.moneda === "USD" ? "Ver en Bs" : "Ver en USD";

        const input = divInputValidation.querySelector(
          `.input-modal-monto[data-index="${index}"]`,
        );
        if (input) {
          input.value = formatearMontoLinea(linea);
          input.placeholder = `Monto en ${linea.moneda === "USD" ? "USD" : "Bs"}`;
          input.focus();
        }

        refrescarResumenesPago();
      });
    });

    refrescarResumenesPago();
  };

  /** Prepara el reparto de montos del modal de validación. */
  const prepararValidacion = () => {
    const totalCent = totalFacturaCent();
    if (totalCent <= 0) {
      alertError("Error", "La factura no tiene ningún monto que cobrar.");
      return false;
    }

    metodosPago = leerMetodosSeleccionados();
    if (metodosPago.length === 0) return false;

    if (metodosPago.some((m) => esDivisa(m.nombre)) && TIPO_CAMBIO <= 0) {
      alertError("Error", "No hay tasa de cambio disponible. Actualice la tasa e intente de nuevo.");
      return false;
    }

    const unico = metodosPago.length === 1;
    lineasPago = metodosPago.map((metodo) => ({
      id: metodo.id,
      nombre: metodo.nombre,
      moneda: esDivisa(metodo.nombre) ? "USD" : "BS",
      montoCent: unico ? totalCent : 0,
    }));

    const necesitaReferencia = lineasPago.some((linea) =>
      requiereReferencia(linea.nombre),
    );
    if (divReferencia) divReferencia.classList.toggle("d-none", !necesitaReferencia);
    if (!necesitaReferencia && inputRefencia) {
      inputRefencia.value = "";
      marcarCampo(inputRefencia, "");
    }

    renderizarLineasPago();
    return true;
  };

  /** Lleva los montos al formulario de confirmación, netos de vuelto. */
  const construirConfirmacion = () => {
    const problema = validarPago();
    if (problema) {
      alertError("Error", problema);
      return false;
    }

    const estado = calcularEstadoPago();
    const { netas, resto } = netearPagos(estado.vuelto);
    if (resto > 0) {
      alertError(
        "Error",
        `El vuelto de ${textoDual(estado.vuelto)} no puede entregarse con los métodos elegidos.`,
      );
      return false;
    }

    const usaReferencia = lineasPago.some((linea) =>
      requiereReferencia(linea.nombre),
    );
    const referencia = usaReferencia ? (inputRefencia?.value ?? "").trim() : "";

    if (inputReferenciaConfir) {
      inputReferenciaConfir.value = usaReferencia ? referencia : "0";
    }
    if (pReferencia) {
      pReferencia.innerText = usaReferencia
        ? `Número de referencia: ${referencia}`
        : "";
    }

    let html = "";
    netas.forEach((linea) => {
      const recibido = Math.max(0, linea.montoCent || 0);
      const cambio = Math.max(0, recibido - linea.neto);
      html += `
        <input type="hidden" name="formasDePago[]" value="${linea.id}">
        <input type="hidden" name="montosDePago[]" value="${deCentimos(linea.neto).toFixed(2)}">
        <div class="d-flex justify-content-between align-items-start mb-1">
          <div>
            <p class="mb-0">${linea.nombre}</p>
            ${
              cambio > 0
                ? `<p class=" small mb-0">Recibido ${dual(recibido)} · Vuelto ${dual(cambio)}</p>`
                : ""
            }
          </div>
          <p class="mb-0 text-end">${dual(linea.neto)}</p>
        </div>`;
    });
    if (divTypePagoCofirm) divTypePagoCofirm.innerHTML = html;

    ponerMetricas("confirmacion", {
      pagado: estado.pagado,
      vuelto: estado.vuelto,
      pendiente: 0,
    });

    return true;
  };

  /**
   * Pinta una métrica del cobro con las dos monedas:
   * `#<prefijo>PagadoUSD` (resaltado) y `#<prefijo>Pagado` (atenuado).
   */
  const ponerMetricas = (prefijo, valores) => {
    const pares = [
      ["Pagado", valores.pagado],
      ["Vuelto", valores.vuelto],
      ["Pendiente", valores.pendiente],
    ];

    pares.forEach(([nombre, cent]) => {
      setTexto(`${prefijo}${nombre}USD`, enUsd(cent) || enBs(cent));
      setTexto(`${prefijo}${nombre}`, enUsd(cent) ? enBs(cent) : "");
    });

    // El pendiente y el vuelto no pueden estar resaltados a la vez: si falta
    // dinero, el aviso tiene prioridad sobre un vuelto que ya no aplica.
    resaltar(`${prefijo}PendienteUSD`, valores.pendiente > 0, "text-danger");
    resaltar(`${prefijo}VueltoUSD`, valores.vuelto > 0, "text-success");
  };

  // Refresca todos los resúmenes con el estado actual del reparto.
  refrescarResumenesPago = () => {
    const estado = calcularEstadoPago();
    const hayTasa = TIPO_CAMBIO > 0;
    const totalUsd = enUsd(estado.total);

    setTexto("resumenTotalPagoUSD", totalUsd || enBs(estado.total));
    setTexto("resumenTotalPagoBS", totalUsd ? enBs(estado.total) : "");
    setTexto(
      "resumenTasaPago",
      hayTasa ? `1 USD = ${formatBS(TIPO_CAMBIO)}` : "sin tasa de cambio",
    );

    setTexto("validacionTotalUSD", totalUsd || enBs(estado.total));
    setTexto("validacionTotalBS", totalUsd ? enBs(estado.total) : "");
    ponerMetricas("validacion", {
      pagado: estado.pagado,
      vuelto: estado.vuelto,
      pendiente: estado.falta,
    });

    const oculto = byId("input-validacion-pago");
    if (oculto) oculto.value = deCentimos(estado.total).toFixed(2);

    // Estado visual y equivalencia de cada línea.
    lineasPago.forEach((linea, index) => {
      const input = divInputValidation?.querySelector(
        `.input-modal-monto[data-index="${index}"]`,
      );
      if (input) {
        const invalido =
          linea.montoCent === null ||
          (Number.isFinite(linea.montoCent) && linea.montoCent <= 0);
        marcarCampo(input, invalido ? "Ingrese un monto mayor a cero." : "");
      }

      const equivalencia = divInputValidation?.querySelector(
        `.equivalente-moneda[data-index="${index}"]`,
      );
      if (equivalencia) equivalencia.innerHTML = textoEquivalencia(linea);
    });

    actualizarBotonValidacion();
  };

  // ── Eventos del flujo ────────────────────────────────────────────────

  // El botón "Siguiente" del modal de cliente abre el de pagos. Antes lo hacía
  // con data-bs-toggle y data-bs-dismiss en el mismo botón, y eso dejaba el
  // backdrop descuadrado; ahora la transición la controla este listener.
  botonPC?.addEventListener("click", () => {
    actualizarSeleccionPago();
    refrescarResumenesPago();
    abrirModalSecuencial(MODAL_PAGO);
  });

  btnTipoDePago.addEventListener("click", () => {
    metodosPago = leerMetodosSeleccionados();
    if (metodosPago.length === 0) return;

    // Siempre se pasa por la verificación: allí se registra lo recibido y se
    // muestra el vuelto en las dos monedas (guía de flujo de pago).
    if (!prepararValidacion()) return;
    abrirModalSecuencial(MODAL_VALIDACION);
  });

  btnValidacion.addEventListener("click", () => {
    if (!construirConfirmacion()) return;
    abrirModalSecuencial(MODAL_CONFIRMACION);
  });

  byId("btnAtrasValidacion")?.addEventListener("click", () => {
    abrirModalSecuencial(MODAL_PAGO);
  });

  byId("btnAtrasConfirmacion")?.addEventListener("click", () => {
    // Se vuelve a la pantalla donde el cajero puede corregir los montos.
    abrirModalSecuencial(lineasPago.length > 0 ? MODAL_VALIDACION : MODAL_PAGO);
  });

  // La referencia solo admite 4 dígitos: se filtra al escribir para que el
  // usuario no descubra el límite cuando el botón no se habilita.
  inputRefencia?.addEventListener("input", () => {
    inputRefencia.value = inputRefencia.value.replace(/\D/g, "").slice(0, 4);
    marcarReferencia();
    actualizarBotonValidacion();
  });

  byId(MODAL_PAGO)?.addEventListener("shown.bs.modal", () => {
    actualizarSeleccionPago();
    refrescarResumenesPago();
  });

  byId(MODAL_VALIDACION)?.addEventListener("shown.bs.modal", () => {
    const primero = divInputValidation?.querySelector(".input-modal-monto");
    if (primero) primero.focus();
  });

  byId(MODAL_CONFIRMACION)?.addEventListener("shown.bs.modal", () => {
    refrescarResumenesPago();
  });

  //funcion para llenar el modal de confirmacion
  const mostrarConfirmacion = () => {
    const tbodyDelModal = byId("tbodyDelModal");
    const tbodyInsumosModal = byId("tbodyInsumos");
    let html = "";
    let htmlInsumos = "";

    data.forEach((element) => {
      const precioDivisa = num(element.precio);
      const montoBS = divisaABs(precioDivisa);

      html += `
        <tr>
        <td><input type="hidden" name="servicios[]" value="${element.id_servicio}">
        <div class="fw-bolder">S/E:</div>${element.servicio}</td>
        <td><input type="hidden" name="doctores[]" value="${element.id_doctor ?? ""}"><div class="fw-bolder">DOCTOR:</div> ${element.doctor}</td>
        <td class="text-end"><input type="hidden" name="precioServicio[]" value="${precioDivisa.toFixed(2)}">
        <div class="fw-bolder">PRECIO:</div>${montoDualHTML(montoBS, TIPO_CAMBIO)}</td>
        </tr>`;
    });

    dataInsumo.forEach((element) => {
      const cantidad = parseInt(element.cantidad) || 0;
      const precioDivisa = num(element.precio);
      const aplicaIVA = String(element.iva) === "1";
      // Se envia el precio unitario CON IVA y la tasa, para que el servidor
      // pueda validar y persistir el detalle sin depender del navegador.
      const precioUnitarioFinal = precioUnitarioInsumo(element);
      const precioUnitarioBs = divisaABs(precioUnitarioFinal);
      const precioBaseBs = divisaABs(precioDivisa);
      // Mismo redondeo por línea que el servidor: unitario en Bs * cantidad.
      const subtotalBS = precioUnitarioBs * cantidad;
      const ivaBS = Math.max(0, precioUnitarioBs - precioBaseBs) * cantidad;

      htmlInsumos += `
        <tr>
        <td>
          <input type="hidden" name="insumos[]" value="${element.id_insumo}">
          <input type="hidden" name="cantidad[]" value="${cantidad}">
          <input type="hidden" name="precioInsumo[]" value="${precioUnitarioFinal.toFixed(2)}">
          <div class="fw-bolder">INSUMO:</div>${element.nombre}
          <div class=" small">${element.medida} · ${cantidad} × ${montoDualHTML(precioBaseBs, TIPO_CAMBIO)}</div>
        </td>
        <td><input type="hidden" name="aplicaIVA[]" value="${aplicaIVA ? 1 : 0}">
          <div class="fw-bolder">IVA:</div>${montoDualHTML(ivaBS, TIPO_CAMBIO)}</td>
        <td class="text-end"><div class="fw-bolder">SUB-TOTAL:</div>${montoDualHTML(subtotalBS, TIPO_CAMBIO)}</td>
        </tr>`;
    });

    if (tbodyDelModal) tbodyDelModal.innerHTML = html;
    if (tbodyInsumosModal) tbodyInsumosModal.innerHTML = htmlInsumos;
  };

// ── Arranque ─────────────────────────────────────────────────────────
  // ORDEN CRÍTICO: primero se cablea la interfaz, después se cargan datos.
  //
  // Antes el `await Promise.all([...])` estaba aquí arriba y TODOS los
  // addEventListener de abajo quedaban detrás. Si esa carga fallaba o tardaba,
  // ningún listener se registraba y el formulario de búsqueda hacía submit
  // normal: la página se recargaba en vez de mostrar el paciente.
  //
  // Regla: la interfaz no puede depender de la red para responder.

  // 1) Tasa cacheada al instante (síncrono). La API llega después, sin bloquear.
  inicializarTasa();

  // ── Eventos ─────────────────────────────────────────────────────────
  // Se registran aquí, de forma síncrona, antes de cualquier await.

  /** Evita el submit por defecto: sin esto, Enter recarga la página. */
  const evitarSubmit = (form) =>
    form?.addEventListener("submit", (e) => e.preventDefault());

  //llamar la funcion de buscar el paciente
  pacienteClienteCheck?.addEventListener("change", function () {
    if (this.checked) {
      cajaBuscadorCliente?.classList.remove("d-none");
      // Con el switch activo hay que elegir un cliente antes de continuar.
      botonPC?.classList.add("d-none");
    } else {
      cajaBuscadorCliente?.classList.add("d-none");
      if (inputCliente) inputCliente.value = "";
      botonPC?.classList.remove("d-none");
    }
  });

  //buscar otro cliente
  formBuscadorOtroCliente?.addEventListener("submit", function (e) {
    e.preventDefault();
    buscarCliente(formBuscadorOtroCliente);
  });

  // Boton VACIAR: antes no tenia ningun listener, el boton no hacia nada.
  btnVaciarTabla?.addEventListener("click", function () {
    alertConfirm("Desea vaciar la factura actual?", () => vaciarFactura());
  });

  //metodo para que cuando le de click al boton de abrir el modal de agregar
  //paciente se le de el valor a la cedula de manera automatica
  btnAddPac?.addEventListener("click", function () {
    if (!cedulaPaciente || !inputCedulaPaciente) return;
    cedulaPaciente.value = inputCedulaPaciente.value;
    cedulaPaciente.dispatchEvent(new Event("keyup", { bubbles: true }));
  });

  //llamar a la validacion para los formularios tanto de guardar paciente como cliente
  const verificarFormularioPaciente = modalAgregarPaciente
    ? inicializarValidacionFormulario(modalAgregarPaciente)
    : null;

  //enviar formulario de paciente
  modalAgregarPaciente?.addEventListener("submit", function (e) {
    e.preventDefault();
    if (!verificarFormularioPaciente) return;

    const esValido = verificarFormularioPaciente();
    if (esValido) {
      createPatients(this);
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  // ── Modal de cliente: mismas validaciones que en el módulo de Clientes ──
  // Antes no tenía ni validación ni submit: el modal se abría y no hacía nada.
  const modalAgregarCliente = byId("modalAgregarCliente");
  const verificarFormularioCliente = modalAgregarCliente
    ? inicializarValidacionFormulario(modalAgregarCliente)
    : null;

  modalAgregarCliente?.addEventListener("submit", function (e) {
    e.preventDefault();
    if (!verificarFormularioCliente) return;

    if (verificarFormularioCliente()) {
      createCliente(this, modalCliente);
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  // ── Búsqueda del paciente ───────────────────────────────────────────
  // El id de hospitalizacion lo inyecta PHP en un data-attribute.
  // Antes se sacaba de window.location.href.split("/")[6], que casi nunca
  // existia y, cuando existia, no tenia nada que ver con la hospitalizacion.
  const idHospitalizacion =
    document.querySelector("[data-id-hospitalizacion]")?.dataset
      ?.idHospitalizacion;
  const formularioPaciente = byId("form-buscador-factura");

  if (formularioPaciente) {
    // submit cubre tanto el Enter como el clic en el botón de búsqueda.
    formularioPaciente.addEventListener("submit", function (e) {
      e.preventDefault();

      const cedula = (inputCedulaPaciente?.value ?? "").trim();
      if (!/^[1-9]\d{6,7}$/.test(cedula)) {
        alertError(
          "Error",
          "Ingrese una cédula válida de 7 u 8 dígitos.",
        );
        return;
      }

      if (idHospitalizacion) {
        buscarPacienteConHospit(idHospitalizacion);
      } else {
        buscarPacienteConCita(formularioPaciente);
      }
    });

    // Red de seguridad: si por lo que sea el submit se dispara sin pasar por
    // el listener anterior, se cancela igual. Una búsqueda NUNCA recarga.
    evitarSubmit(document);
  }

  if (idHospitalizacion) {
    buscarPacienteConHospit(idHospitalizacion);
  }

  // ── Envío de la factura ──────────────────────────────────────────────
  // El backend responde JSON cuando algo falla (total descuadrado, stock
  // insuficiente, error de validación). Antes el formulario se enviaba a ciegas
  // y el navegador seguía la redirección sin enterarse del fallo.
  const formConfirmar = byId("formConfirmarFactura");

  if (formConfirmar) {
    formConfirmar.addEventListener("submit", async function (e) {
      e.preventDefault();

      const btn = byId("btnConfirmarFactura");
      if (btn) btn.disabled = true;

      try {
        const response = await fetch(this.action, {
          method: "POST",
          body: new FormData(this),
          headers: {
            "X-CSRF-Token":
              document.querySelector('meta[name="csrf-token"]')?.content ?? "",
          },
          redirect: "follow",
        });

        // Si el servidor redirige al comprobante, la factura quedó registrada.
        if (response.redirected && response.url.includes("comprobante")) {
          window.location.href = response.url;
          return;
        }

        let error = "No se pudo registrar la factura.";
        try {
          const cuerpo = await response.json();
          error = cuerpo.error ?? error;
        } catch (_) {
          /* respuesta no-JSON */
        }
        alertError("Error", error);
      } catch (error) {
        alertError("Error", "Error de conexión al guardar la factura.");
        console.error(error);
      } finally {
        if (btn) btn.disabled = false;
      }
    });
  }

  // ── Carga de datos ───────────────────────────────────────────────────
  // Va al final a propósito. Cada petición se aísla: un fallo en servicios,
  // insumos o pagos no puede impedir que la pantalla siga siendo usable.
  // Creación de los paginadores: aquí ya están declaradas todas las funciones
  // que les sirven de callback (si se instanciaran antes, daría ReferenceError).
  crearPaginadores();

  const cargar = (etiqueta, promesa) =>
    Promise.resolve(promesa).catch((error) => {
      console.error(`Error cargando ${etiqueta}:`, error);
    });

  await Promise.all([
    cargar("servicios", traerServiciosMedicos()),
    cargar("insumos", traerInsumos()),
    cargar("métodos de pago", mostrarTiposDePago()),
  ]);

  datosListos = true;
  renderizarInsumos();
  calcularTotal();
  mostrarConfirmacion();
});