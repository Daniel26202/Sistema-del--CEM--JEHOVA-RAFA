import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "./generic/funtionGeneric.js";
import Paginator from "./generic/Paginator.js";
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";
import { valorDolar, guardarTasaManual, tasaGuardada } from "./generic/coversion.js";

/** Obtiene un elemento por id devolviendo null en vez de lanzar. */
const byId = (id) => document.getElementById(id);
/** Igual que byId pero lanza un error claro si el elemento no existe. */
const need = (id) => {
  const el = byId(id);
  if (!el) throw new Error(`Elemento obligatorio ausente en el DOM: #${id}`);
  return el;
};
/** Convierte a número devolviendo 0 ante valores no numéricos (evita NaN). */
const num = (v) => {
  const n = parseFloat(v);
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
  let listTypePago = [];

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
        TIPO_CAMBIO > 0 ? `${TIPO_CAMBIO.toFixed(2)} BS/$` : "Sin tasa";
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
  const totalDeConfirmacion = byId("totalDeConfirmacion");
  const inputTotalDeConfirmacion = byId("inputTotalDeConfirmacion");
  // OJO: antes era document.getAnimations(...) que devuelve un array de
  // Animation; escribir .innerText sobre él no pintaba nada (fallo silencioso).
  const totalModalValidacion = byId("total-modal-validacion");
  const bodyModalPago = byId("body-modal-pago");
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
  const divModalValidacion = byId("divModalValidacion");
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

        <span class="text-center mb-2">Precio $: ${precio.toFixed(2)} $</span>
        <span class="text-center mb-2">Precio Bs: ${(precio * TIPO_CAMBIO).toFixed(2)} BS</span>

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
              <div class="precio-principal">${num(res.precio).toFixed(2)} $ ${(num(res.precio) * TIPO_CAMBIO).toFixed(2)} BS</div>
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
    return String(insumo.iva) === "1" ? base * (1 + IVA_TASA) : base;
  };

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
    const baseCita = num(inputTotalCita?.value);

    const totalDivisa =
      baseCita + subtotalServiciosDivisa() + subtotalInsumosDivisa();

    const totalBS = parseFloat((totalDivisa * TIPO_CAMBIO).toFixed(2));

    if (inputTotalFactura) inputTotalFactura.value = totalBS.toFixed(2);
    if (totalDeConfirmacion) totalDeConfirmacion.innerText = `${totalBS.toFixed(2)} BS`;
    if (inputTotalDeConfirmacion) inputTotalDeConfirmacion.value = totalBS.toFixed(2);

    //validacion de el modal de validacion...
    if (totalModalValidacion) {
      totalModalValidacion.innerText = `Total a pagar ${totalBS.toFixed(2)} BS`;
    }

    return totalBS;
  }

  // // Funcion para actualizar la tabla  servicios

  function mostrarServicios() {
    calcularTotal();
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;

    data.forEach((element, index) => {
      const precioDivisa = num(element.precio);
      const montoBS = (precioDivisa * TIPO_CAMBIO).toFixed(2);

      html += `
          <tr class="border-top">
          <td class="border-top"><div class="fw-bolder">SERVICIO :</div> ${element.servicio}</td>
          <td class="border-top"><div class="fw-bolder">DOCTOR:</div> ${element.doctor}</td>
          <td class="border-top">
            <div class="fw-bolder">PRECIO:</div>
            <p class="mb-1">${montoBS} BS</p>
            <p class="m-0 p-0">o</p>
            <p class="mt-1">${precioDivisa.toFixed(2)} $</p>
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
      const subtotalDivisa = precioUnitario * cantidad;
      const aplicaIVA = String(element.iva) === "1";
      const ivaDivisa = aplicaIVA ? (precioUnitario - num(element.precio)) * cantidad : 0;

      html += `
          <tr class="border-top tr">
          <th class="id_insumo_escondido d-none">${element.id_insumo}</th>
          <td class="border-top nombre"><div class="fw-bolder">INSUMO:</div> ${element.nombre}</td>
          <td class="border-top nombre"><div class="fw-bolder">Medida:</div> ${element.medida}</td>
          <td class="border-top"><div class="fw-bolder">CANTIDAD:</div> ${cantidad}</td>
          <td class="border-top"><div class="fw-bolder">PRECIO:</div>
          ${(num(element.precio) * TIPO_CAMBIO).toFixed(2)} BS</td>
          <td class="border-top"><div class="fw-bolder">IVA:</div>${(ivaDivisa * TIPO_CAMBIO).toFixed(2)} BS</td>
          <td class="border-top">
            <div class="fw-bolder">SUB-TOTAL:</div>
            <p class="mb-1">${(subtotalDivisa * TIPO_CAMBIO).toFixed(2)} BS</p>
            <p class="m-0 p-0">o</p>
            <p class="mt-1">${subtotalDivisa.toFixed(2)} $</p>
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

  /**
   * Metodos de pago que exigen referencia bancaria.
   * Antes la comparacion era por texto ("Pago Movil"/"Transferencia"), lo que
   * hacia que un metodo renombrado en la BD se quedara sin validacion.
   */
  const METODOS_CON_REFERENCIA = ["pago movil", "transferencia", "pago móvil"];

  const requiereReferencia = (nombre) =>
    METODOS_CON_REFERENCIA.includes(String(nombre).trim().toLowerCase());

  //funcion para realizar las debidas validaciones de los tipos de pago
  const checkearTiposDePago = (tiposDePago) => {
    listTypePago = [];

    tiposDePago.forEach((tipo) => {
      if (tipo.checked) {
        const label = tipo.closest(".form-check")?.querySelector(".form-check-label");
        listTypePago.push({
          id: tipo.value,
          name: (label?.innerText ?? "").trim(),
        });
      }
    });

    // Restablecer siempre el estado del boton antes de evaluar.
    btnTipoDePago.classList.add("d-none");

    if (listTypePago.length === 0) {
      if (divTypePagoCofirm) divTypePagoCofirm.innerHTML = "";
      return;
    }

    // Pago Movil y Transferencia son excluyentes entre si (no tiene sentido
    // splits por dos canales que exigen el mismo tipo de referencia).
    const conRef = listTypePago.filter((t) => requiereReferencia(t.name));
    if (conRef.length > 1) {
      alertError(
        "Error",
        "Solo puede elegir un metodo de pago con referencia (Pago Movil o Transferencia).",
      );
      tiposDePago.forEach((t) => {
        if (t.checked && requiereReferencia(t.name)) t.checked = false;
      });
      listTypePago = listTypePago.filter((t) => !requiereReferencia(t.name));
      if (listTypePago.length === 0) return;
    }

    const necesitaInput = listTypePago.some((t) => requiereReferencia(t.name));
    const montoTotal = num(inputTotalFactura?.value);

    // Si hay un metodo con referencia se muestra el campo de referencia.
    if (necesitaInput && divReferencia) {
      divReferencia.classList.remove("d-none");
      // La referencia debe validarse de verdad: se limpia el estado previo
      // para que el usuario no herede el "valido" forzado de otra combinacion.
      inputRefencia.parentElement.classList.remove("valido", "invalido");
    } else if (divReferencia) {
      divReferencia.classList.add("d-none");
      inputRefencia.parentElement.classList.remove("valido", "invalido");
    }

    btnTipoDePago.classList.remove("d-none");

    if (necesitaInput) {
      // Varios metodos -> modal de validacion con el desglose de montos.
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
    } else {
      // Metodos sin referencia: se paga el total de una sola vez.
      let htmlPAgo = "";
      listTypePago.forEach((type) => {
        type.monto = montoTotal;
        htmlPAgo += `
        <input type="hidden" name="formasDePago[]" value="${type.id}">
        <input type="hidden" name="montosDePago[]" value="${montoTotal}">

        <p>${type.name} monto: ${montoTotal} BS</p>
        `;
      });
      if (divTypePagoCofirm) divTypePagoCofirm.innerHTML = htmlPAgo;

      // Limpiar referencia por si venia de una combinacion anterior.
      if (inputReferenciaConfir) inputReferenciaConfir.value = "";
      if (pReferencia) pReferencia.innerText = "";

      btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
    }
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

    if (divInputValidation) divInputValidation.innerHTML = htmlTypePago;

    //inicializar validacion de los input
    const validarForm = inicializarValidacionFormulario(divModalValidacion);

    // Solo los campos de monto se suman; la referencia NO es un monto.
    // Antes se usaba ".input-modal-valida", que también incluía #inputRefencia,
    // y la referencia se sumaba como si fueran bolivares.
    const inputsMonto = () =>
      Array.from(document.querySelectorAll(".input-modal-monto"));

    const totalIngresado = () =>
      inputsMonto().reduce((acc, inp) => acc + num(inp.value), 0);

    const refrescarBoton = () => {
      const camposOk = validarForm();
      const montoOk = sameMoney(totalIngresado(), inputTotalFactura?.value);

      btnValidacion.classList.toggle("d-none", !(camposOk && montoOk));

      // La alerta se muestra solo mientras el formulario está incompleto,
      // para explicar por qué el botón "Siguiente" sigue oculto.
      const alerta = document.querySelector(".alerta-varios-metodos");
      if (alerta) alerta.classList.toggle("d-none", camposOk && montoOk);
    };

    // Se escucha en los eventos de entrada, no solo en "keyup": antes, pegar con
    // el raton no activaba nada y el boton Siguiente quedaba oculto para siempre.
    document.querySelectorAll("#divModalValidacion .input-validar").forEach((input) => {
      ["keyup", "input", "paste", "change"].forEach((evt) =>
        input.addEventListener(evt, refrescarBoton),
      );
    });

    refrescarBoton();
  };

  const showTypePagoCofirm = () => {
    // La referencia solo se copia si el campo esta visible y tiene 4 digitos.
    const referenciaVisible =
      divReferencia && !divReferencia.classList.contains("d-none");
    const referencia = referenciaVisible ? inputRefencia.value.trim() : "";

    if (referencia && !/^\d{4}$/.test(referencia)) {
      alertError("Error", "La referencia debe tener los ultimos 4 digitos.");
      return false;
    }

    if (inputReferenciaConfir) inputReferenciaConfir.value = referencia || "0";
    if (pReferencia) {
      pReferencia.innerText = referencia
        ? `Numero de Referencia: ${referencia}`
        : "";
    }

    // Los montos se toman SOLO de los inputs de monto, en el mismo orden que
    // listTypePago (antes se emparejaban por indice sobre un NodeList que
    // incluía la referencia, corrriendo el importe de los métodos).
    const inputsMonto = Array.from(document.querySelectorAll(".input-modal-monto"));
    listTypePago.forEach((type, index) => {
      type.monto = num(inputsMonto[index]?.value);
    });

    let htmlPAgo = "";
    listTypePago.forEach((type) => {
      htmlPAgo += `
        <input type="hidden" name="formasDePago[]" value="${type.id}">
        <input type="hidden" name="montosDePago[]" value="${type.monto}">

        <p>${type.name} monto: ${type.monto} Bs</p>
        `;
    });

    if (divTypePagoCofirm) divTypePagoCofirm.innerHTML = htmlPAgo;
    return true;
  };

  btnTipoDePago.addEventListener("click", function () {
    validarTypeDePago();
  });

  btnValidacion.addEventListener("click", function () {
    // Si la referencia no es valida no se deja avanzar al modal de confirmacion.
    if (showTypePagoCofirm() === false) return;
  });

  //funcion para llenar el modal de confirmacion
  const mostrarConfirmacion = () => {
    const tbodyDelModal = byId("tbodyDelModal");
    const tbodyInsumosModal = byId("tbodyInsumos");
    let html = "";
    let htmlInsumos = "";

    data.forEach((element) => {
      const precioDivisa = num(element.precio);
      const montoBS = precioDivisa * TIPO_CAMBIO;

      html += `
        <tr>
        <td><input type="hidden" name="servicios[]" value="${element.id_servicio}">
        <div class="fw-bolder">S/E:</div>${element.servicio}</td>
        <td><input type="hidden" name="doctores[]" value="${element.id_doctor ?? ""}"><div class="fw-bolder">DOCTOR:</div> ${element.doctor}</td>
        <td><input type="hidden" name="precioServicio[]" value="${precioDivisa.toFixed(2)}"><div class="fw-bolder">PRECIO:</div> ${montoBS.toFixed(2)} BS</td>
        </tr>`;
    });

    dataInsumo.forEach((element) => {
      const cantidad = parseInt(element.cantidad) || 0;
      const precioDivisa = num(element.precio);
      const aplicaIVA = String(element.iva) === "1";
      // Se envia el precio unitario CON IVA y la tasa, para que el servidor
      // pueda validar y persistir el detalle sin depender del navegador.
      const precioUnitarioFinal = precioUnitarioInsumo(element);
      const subtotalBS = precioUnitarioFinal * cantidad * TIPO_CAMBIO;

      htmlInsumos += `
        <tr>
        <td><input type="hidden" name="insumos[]" value="${element.id_insumo}">
        <div class="fw-bolder">INSUMO:</div>${element.nombre}</td>

        <td><div class="fw-bolder">MEDIDA:</div>${element.medida}</td>

        <td><input type="hidden" name="cantidad[]" value="${cantidad}"><div class="fw-bolder">CANTIDAD</div> ${cantidad}</td>
        <td><input type="hidden" name="precioInsumo[]" value="${precioUnitarioFinal.toFixed(2)}"><div class="fw-bolder">PRECIO:</div> ${(precioDivisa * TIPO_CAMBIO).toFixed(2)} BS</td>
        <td><input type="hidden" name="aplicaIVA[]" value="${aplicaIVA ? 1 : 0}"><div class="fw-bolder">IVA:</div> ${(((precioUnitarioFinal - precioDivisa) * cantidad) * TIPO_CAMBIO).toFixed(2)} BS</td>
        <td><div class="fw-bolder">SUB-TOTAL:</div>${subtotalBS.toFixed(2)} BS</td>
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