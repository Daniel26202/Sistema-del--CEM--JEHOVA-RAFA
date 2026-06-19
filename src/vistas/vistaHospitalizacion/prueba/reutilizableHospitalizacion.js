/**
 * reutilizableHospitalizacion.js
 *
 * Módulo unificado que maneja:
 *  - Modal de servicios (#modal-servicios-uni)  → agregar + editar
 *  - Modal de insumos  (#modal-insumos)         → agregar + editar
 *
 * Contexto activo ("agregar" | "editar") se detecta desde el botón
 * que abrió el modal mediante data-contexto="agregar|editar".
 */

import { executePetition } from "../../js/generic/funtionGeneric.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";

// ─── Catálogo de servicios (se llena al inicializar) ───────────────────────
export let objServiciosBD = {};

// ─── Contexto activo: "agregar" | "editar" ─────────────────────────────────
let contextoActivo = "agregar";

// ─── Mapas de IDs para eliminar/restaurar en modo editar ───────────────────
let arrayIdInsEliminados = [];

// ══════════════════════════════════════════════════════════════════════════════
//  HELPERS: generar HTML de cards (nuevo diseño)
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Card de insumo seleccionado con el nuevo diseño v2.
 * @param {object} insumo  - datos del insumo (id_insumo, nombre, precio, limite_insumo)
 * @param {number} cantidad
 * @param {string} contexto  - "agregar" | "editar"
 * @param {string|null} idIDH - id_insumoDeHospitalizacion (solo editar, para insumos ya guardados)
 */
function htmlCardInsumo(insumo, cantidad = 1, contexto = "agregar", idIDH = null) {
    const namePrefix = contexto === "editar" && idIDH ? "cantidad[]" : "cantidad[]";
    const inputIdName = contexto === "editar" && idIDH ? "id_idh[]" : "id_insumo[]";
    const inputIdVal  = contexto === "editar" && idIDH ? idIDH : insumo.id_insumo;

    // Para insumos nuevos en editar usamos id_insumoA[]
    const inputIdNameFinal = contexto === "editar" && !idIDH ? "id_insumoA[]" :
                              contexto === "editar" && idIDH  ? "id_idh[]" : "id_insumo[]";
    const cantNameFinal    = contexto === "editar" && !idIDH ? "cantidadA[]" : "cantidad[]";

    return `
    <div class="col-12 col-sm-6 col-md-4 card-insumo-seleccionado"
         data-id-insumo="${insumo.id_insumo}"
         data-id-idh="${idIDH ?? ''}"
         data-limite="${insumo.limite_insumo}"
         data-contexto="${contexto}">

        <p class="text-danger text-center small mb-1 d-none aviso-limite">Límite de cantidad alcanzado</p>

        <div class="card card-insumo-v2 border rounded-4 shadow-sm h-100 position-relative">

            <!-- Botón eliminar -->
            <button type="button"
                class="btn-eliminar-insumo-sel position-absolute top-0 end-0 m-2"
                style="background:none; border:none; font-size:1.4rem; line-height:1;
                       color:var(--color-primary); cursor:pointer; z-index:5;"
                aria-label="Eliminar insumo">×</button>

            <div class="card-body pb-2">
                <p class="fw-bold mb-1 fs-6" style="color:var(--color-text-card)">${insumo.nombre}</p>
                <div class="precio-usd">$${parseFloat(insumo.precio).toFixed(2)}</div>
            </div>

            <hr class="mx-3 my-0 opacity-25">

            <div class="card-body d-flex flex-column gap-2 pt-2">
                <!-- Input cantidad estilo v2 -->
                <div class="insumo-v2-input-wrap d-flex align-items-center">
                    <button type="button" class="btn-dis px-2 fw-bold fs-5"
                        style="background:none; border:none; color:var(--color-primary); cursor:pointer;">−</button>
                    <input type="number"
                        class="form-control input-cantidad-insumo text-center"
                        name="${cantNameFinal}"
                        min="1" max="${insumo.limite_insumo}"
                        value="${cantidad}"
                        style="border:none; background:transparent; box-shadow:none; width:60px;">
                    <button type="button" class="btn-inc px-2 fw-bold fs-5"
                        style="background:none; border:none; color:var(--color-primary); cursor:pointer;">+</button>
                </div>
                <!-- Precio total del ítem -->
                <div class="precio-total-insumo fw-bold" style="color:var(--color-text-card); font-size:.85rem;">
                    Total: $<span class="val-total">${(parseFloat(insumo.precio) * cantidad).toFixed(2)}</span>
                </div>

                <!-- inputs hidden -->
                <input type="hidden" name="${inputIdNameFinal}" value="${inputIdVal}">
                ${contexto === "editar" && idIDH
                    ? `<input type="hidden" name="id_idh_existe" value="${idIDH}">`
                    : ''
                }
            </div>
        </div>
    </div>`;
}

/**
 * Card de servicio seleccionado con el nuevo diseño v2.
 */
function htmlCardServicio(idS, datos, cantidad = 1, contexto = "agregar") {
    return `
    <div class="col-12 col-sm-6 col-md-4 card-servicio-seleccionado position-relative"
         data-index="${idS}" data-contexto="${contexto}">

        <button type="button"
            class="btn-eliminar-serv-sel position-absolute top-0 start-50 translate-middle-x mt-1"
            style="background:none; border:none; font-size:2rem; font-weight:bold;
                   color:var(--color-primary); cursor:pointer; z-index:10;">×</button>

        <div class="card card-servicio-v2 border rounded-4 shadow-sm h-100">

            <!-- Cabecera -->
            <div class="serv-v2-header p-3 border-bottom text-center">
                <p class="serv-v2-nombre fw-bold mb-1 fs-6" style="color:var(--color-text-card)">
                    ${datos.categoria}
                </p>
                <span class="badge" style="background:var(--color-primary); font-size:.68rem;">
                    Servicio médico
                </span>
            </div>

            <div class="card-body d-flex flex-column gap-2">
                <p class="text-center mb-0 fw-semibold" style="font-size:.85rem; color:var(--color-text-card)">
                    DR: ${datos.nombre} ${datos.apellido}
                </p>
                <hr class="my-1 opacity-25">
                <div class="text-center">
                    <div class="serv-label">Precio</div>
                    <div class="serv-usd">$${parseFloat(datos.precio).toFixed(2)}</div>
                </div>
                <!-- Cantidad (solo examenes pueden ser > 1) -->
                <div class="d-flex align-items-center justify-content-center gap-2 mt-1">
                    <span class="serv-label">Cant:</span>
                    <span class="fw-bold cantidadServicio">${cantidad}</span>
                </div>
                <!-- Precio total -->
                <div class="text-center serv-label">
                    Total: <strong class="val-total-serv">$${(parseFloat(datos.precio) * cantidad).toFixed(2)}</strong>
                </div>

                <!-- inputs hidden -->
                <input type="hidden" name="id_servicio[]" value="${idS}">
                <input type="hidden" name="cantidadS[]" class="cantidadServicioInput" value="${cantidad}">
            </div>
        </div>
    </div>`;
}

// ══════════════════════════════════════════════════════════════════════════════
//  INSUMOS — Lógica unificada
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Obtiene el contenedor destino según el contexto.
 */
function getContenedorInsumos(ctx) {
    return document.querySelector(ctx === "editar" ? "#div-insumosE" : "#div-insumosA");
}
function getContenedorServicios(ctx) {
    return document.querySelector(ctx === "editar" ? "#div-serviciosE" : "#div-serviciosA");
}

/**
 * Devuelve el límite real de un insumo consultando la BD.
 */
async function limiteInsumo(idIn, contexto) {
    try {
        const resultado = await executePetition(url + "/mostrarUnInsumo/" + parseInt(idIn), "GET");
        if (!resultado) return {};

        const insumosLim = {};
        insumosLim[resultado.id_insumo] = {
            id: parseInt(resultado.id_insumo),
            cantidadT: 0,
            limite: parseInt(resultado.limite_insumo),
        };

        const selector = contexto === "editar"
            ? "#div-insumosE .card-insumo-seleccionado"
            : "#div-insumosA .card-insumo-seleccionado";

        document.querySelectorAll(selector).forEach(card => {
            const idI = parseInt(card.dataset.idInsumo);
            const cantidad = parseInt(card.querySelector(".input-cantidad-insumo")?.value ?? 0);
            const limite = parseInt(card.dataset.limite ?? 0);

            if (insumosLim[idI]) {
                insumosLim[idI].cantidadT += cantidad;
            } else {
                insumosLim[idI] = { id: idI, cantidadT: cantidad, limite };
            }
        });

        const objIL = {};
        for (const iLi in insumosLim) {
            if (insumosLim[iLi].cantidadT >= insumosLim[iLi].limite) {
                objIL[iLi] = insumosLim[iLi];
            }
        }
        return objIL;
    } catch {
        return {};
    }
}

/**
 * Agrega listeners de cantidad (+/−) y eliminar a una card de insumo.
 */
function bindCardInsumo(card) {
    const input     = card.querySelector(".input-cantidad-insumo");
    const btnInc    = card.querySelector(".btn-inc");
    const btnDis    = card.querySelector(".btn-dis");
    const valTotal  = card.querySelector(".val-total");
    const avisoLim  = card.querySelector(".aviso-limite");
    const btnElim   = card.querySelector(".btn-eliminar-insumo-sel");
    const idInsumo  = parseInt(card.dataset.idInsumo);
    const limite    = parseInt(card.dataset.limite);
    const precio    = parseFloat(card.querySelector("[name^='id_insumo'], [name^='id_idh'], [name^='id_insumoA']")
                        ?.closest(".card-insumo-seleccionado")?.querySelector(".precio-usd")
                        ?.textContent?.replace("$", "") ?? 0);

    // Precio desde el texto de la card
    const precioEl = card.querySelector(".precio-usd");
    const precioVal = precioEl ? parseFloat(precioEl.textContent.replace("$", "")) : 0;

    function actualizarTotal() {
        const cant = parseInt(input.value) || 1;
        if (valTotal) valTotal.textContent = (precioVal * cant).toFixed(2);
    }

    btnInc?.addEventListener("click", async () => {
        const ctx = card.dataset.contexto;
        const objIL = await limiteInsumo(idInsumo, ctx);
        if (objIL[idInsumo]) {
            avisoLim?.classList.remove("d-none");
        } else {
            avisoLim?.classList.add("d-none");
            const val = parseInt(input.value) || 1;
            if (val < limite) {
                input.value = val + 1;
                actualizarTotal();
            }
        }
    });

    btnDis?.addEventListener("click", async () => {
        const val = parseInt(input.value) || 1;
        if (val > 1) {
            input.value = val - 1;
            avisoLim?.classList.add("d-none");
            actualizarTotal();
        }
    });

    input?.addEventListener("input", actualizarTotal);

    btnElim?.addEventListener("click", () => {
        const idIDH = card.dataset.idIdh;
        if (card.dataset.contexto === "editar" && idIDH) {
            // registrar eliminado
            arrayIdInsEliminados.push(idIDH);
            document.getElementById("idInEli").value = JSON.stringify(arrayIdInsEliminados);
        }
        card.remove();
    });
}

/**
 * Agrega un insumo al contenedor destino.
 * Si ya existe, solo sube la cantidad (si no alcanzó el límite).
 */
async function agregarInsumo(idInsumo, contexto) {
    try {
        const resultado = await executePetition(url + "/mostrarUnInsumo/" + idInsumo, "GET");
        if (!resultado) return alert("El insumo seleccionado no existe.");

        const contenedor = getContenedorInsumos(contexto);
        const cardExistente = contenedor?.querySelector(`.card-insumo-seleccionado[data-id-insumo="${idInsumo}"]`);

        if (cardExistente) {
            // Intenta aumentar cantidad
            const objIL = await limiteInsumo(idInsumo, contexto);
            if (objIL[idInsumo]) {
                cardExistente.querySelector(".aviso-limite")?.classList.remove("d-none");
            } else {
                cardExistente.querySelector(".aviso-limite")?.classList.add("d-none");
                const input = cardExistente.querySelector(".input-cantidad-insumo");
                input.value = parseInt(input.value) + 1;
                input.dispatchEvent(new Event("input", { bubbles: true }));
            }
            return;
        }

        // Insumo nuevo: crear card
        const objIL = await limiteInsumo(idInsumo, contexto);
        if (objIL[idInsumo]) {
            return alert("El insumo alcanzó el límite de su cantidad.");
        }

        contenedor.insertAdjacentHTML("beforeend",
            htmlCardInsumo(resultado, 1, contexto, null));

        const newCard = contenedor.lastElementChild;
        bindCardInsumo(newCard);

        // Mostrar botón "Agregar más"
        const btnMas = contexto === "editar"
            ? document.getElementById("btnAInsumoExisteE")
            : document.getElementById("btnAInsumoExiste");
        btnMas?.classList.remove("d-none");

    } catch (e) {
        console.error("Error al agregar insumo:", e);
    }
}

/**
 * Carga insumos existentes de una hospitalización (modo editar).
 */
export async function cargarInsumosExistentes(idH) {
    try {
        const resultado = await executePetition(url + "/traerInsuDHEd/" + idH, "GET");
        const contenedor = document.getElementById("div-insumosE");
        if (!contenedor) return;
        contenedor.innerHTML = "";
        arrayIdInsEliminados = [];
        document.getElementById("idInEli").value = "";
        document.getElementById("idInEliDos").value = "";

        const btnMas = document.getElementById("btnAInsumoExisteE");

        if (resultado && resultado.length > 0) {
            btnMas?.classList.remove("d-none");
            resultado.forEach(res => {
                contenedor.insertAdjacentHTML("beforeend",
                    htmlCardInsumo(
                        { id_insumo: res.id_insumo, nombre: res.nombre, precio: res.precio, limite_insumo: res.limite_insumo },
                        parseInt(res.cantidad),
                        "editar",
                        res.id_insumoDeHospitalizacion
                    )
                );
                bindCardInsumo(contenedor.lastElementChild);
            });
        } else {
            btnMas?.classList.add("d-none");
        }
    } catch (e) {
        console.error("Error al cargar insumos:", e);
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SERVICIOS — Lógica unificada
// ══════════════════════════════════════════════════════════════════════════════

function bindCardServicio(card, datos) {
    const btnElim = card.querySelector(".btn-eliminar-serv-sel");
    btnElim?.addEventListener("click", () => card.remove());
}

/**
 * Agrega un servicio al contenedor destino.
 */
function agregarServicio(idS, contexto) {
    const datos = objServiciosBD[idS];
    if (!datos) return;

    const contenedor = getContenedorServicios(contexto);
    const existente  = contenedor?.querySelector(`.card-servicio-seleccionado[data-index="${idS}"]`);

    const avisoExiste = contexto === "editar"
        ? document.getElementById("NoPAservicioE")
        : document.getElementById("NoPAservicioA");

    if (datos.tipo === "Examenes") {
        if (existente) {
            // Aumentar cantidad
            const pCant   = existente.querySelector(".cantidadServicio");
            const inpCant = existente.querySelector(".cantidadServicioInput");
            const valTot  = existente.querySelector(".val-total-serv");
            const newCant = parseInt(pCant.textContent.trim()) + 1;
            pCant.textContent  = newCant;
            inpCant.value      = newCant;
            if (valTot) valTot.textContent = "$" + (parseFloat(datos.precio) * newCant).toFixed(2);
        } else {
            contenedor.insertAdjacentHTML("beforeend", htmlCardServicio(idS, datos, 1, contexto));
            bindCardServicio(contenedor.lastElementChild, datos);
        }
    } else {
        if (existente) {
            avisoExiste?.classList.remove("d-none");
            setTimeout(() => avisoExiste?.classList.add("d-none"), 8000);
        } else {
            contenedor.insertAdjacentHTML("beforeend", htmlCardServicio(idS, datos, 1, contexto));
            bindCardServicio(contenedor.lastElementChild, datos);
        }
    }

    // Mostrar botón "Agregar más"
    const btnMasA = contexto === "editar"
        ? document.getElementById("btnAServiciosExisteE")
        : document.getElementById("btnAServiciosExisteA");
    btnMasA?.classList.remove("d-none");

    const btnInicial = contexto === "editar"
        ? document.getElementById("btnASE")
        : document.getElementById("btnASA");
    btnInicial?.classList.add("d-none");
}

/**
 * Carga servicios existentes de una hospitalización (modo editar).
 */
export async function cargarServiciosExistentes(idH) {
    try {
        const resultado = await executePetition(url + "/serviciosDH/" + idH, "GET");
        const contenedor = document.getElementById("div-serviciosE");
        if (!contenedor) return;
        contenedor.innerHTML = "";

        const btnMas = document.getElementById("btnAServiciosExisteE");
        const btnIni = document.getElementById("btnASE");

        if (resultado && resultado.length > 0) {
            btnMas?.classList.remove("d-none");
            btnIni?.classList.add("d-none");
            resultado.forEach(res => {
                const datos = objServiciosBD[res.id_servicioMedico];
                if (!datos) return;
                contenedor.insertAdjacentHTML("beforeend",
                    htmlCardServicio(res.id_servicioMedico, datos, parseInt(res.cantidad), "editar"));
                bindCardServicio(contenedor.lastElementChild, datos);
            });
        } else {
            btnMas?.classList.add("d-none");
            btnIni?.classList.remove("d-none");
        }
    } catch (e) {
        console.error("Error al cargar servicios:", e);
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  INICIALIZACIÓN DEL CATÁLOGO DE SERVICIOS
// ══════════════════════════════════════════════════════════════════════════════

export async function inicializarServicios() {
    try {
        const resultado = await executePetition(url + "/selectServiciosD", "GET");
        objServiciosBD = {};

        const listaUni   = document.getElementById("servicios-uni");
        const noHayUni   = document.getElementById("no-hay-servicio-uni");

        if (!resultado || resultado.length < 1) {
            noHayUni?.classList.remove("d-none");
            return;
        }

        noHayUni?.classList.add("d-none");
        resultado.forEach(dato => {
            objServiciosBD[dato.id_servicioMedico] = dato;
        });

        renderizarCatalogoServicios(listaUni);
    } catch (e) {
        console.error("Error al inicializar servicios:", e);
    }
}

function renderizarCatalogoServicios(contenedor) {
    if (!contenedor) return;
    contenedor.innerHTML = "";

    Object.values(objServiciosBD).forEach(dato => {
        const col = document.createElement("div");
        col.className = "col-12 col-sm-6 col-md-4";
        col.innerHTML = `
            <div class="card card-servicio-v2 border rounded-4 shadow-sm h-100"
                 style="cursor:pointer"
                 data-index="${dato.id_servicioMedico}">
                <div class="serv-v2-header p-3 border-bottom text-center">
                    <p class="serv-v2-nombre fw-bold mb-1 fs-6" style="color:var(--color-text-card)">
                        ${dato.categoria}
                    </p>
                    <span class="badge" style="background:var(--color-primary); font-size:.68rem;">
                        Servicio médico
                    </span>
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <p class="text-center mb-0 fw-semibold" style="font-size:.85rem; color:var(--color-text-card)">
                        DR: ${dato.nombre} ${dato.apellido}
                    </p>
                    <hr class="my-1 opacity-25">
                    <div class="text-center">
                        <div class="serv-label">Precio</div>
                        <div class="serv-usd">$${parseFloat(dato.precio).toFixed(2)}</div>
                    </div>
                    <button type="button"
                        class="btn btn-v2 w-100 d-flex align-items-center justify-content-center gap-2 mt-auto btn-seleccionar-servicio"
                        data-index="${dato.id_servicioMedico}">
                        <i class="bi bi-plus-circle-fill"></i> Agregar
                    </button>
                </div>
            </div>`;
        contenedor.appendChild(col);
    });
}

// ══════════════════════════════════════════════════════════════════════════════
//  INICIALIZACIÓN DEL CATÁLOGO DE INSUMOS (modal unificado)
// ══════════════════════════════════════════════════════════════════════════════

async function buscarInsumos(nombre) {
    try {
        const resultado = await executePetition(url + "/mostrarInsumos/" + nombre, "GET");
        const listaUni  = document.getElementById("insumo-uni-existe");
        const inicial   = document.getElementById("insumos-uni-inicial");
        const pNo       = document.getElementById("p-no-insumos-uni");

        if (!resultado || resultado.length === 0) {
            pNo.textContent = "El insumo no está registrado.";
            listaUni.innerHTML = "";
            inicial?.classList.add("d-none");
            return;
        }

        pNo.textContent = "";
        inicial?.classList.add("d-none");
        listaUni.innerHTML = "";

        resultado.forEach(res => {
            const col = document.createElement("div");
            col.className = "col-12 col-sm-6 col-md-4 divInsumosUni";
            col.dataset.index    = res.id_insumo;
            col.dataset.nombre   = res.nombre;
            col.dataset.precio   = res.precio;
            col.dataset.cantidad = res.cantidad ?? 0;
            col.innerHTML = `
                <div class="card card-insumo-v2 border rounded-4 shadow-sm h-100" style="cursor:pointer">
                    <div class="card-body pb-2">
                        <p class="fw-bold mb-1 fs-6" style="color:var(--color-text-card)">${res.nombre}</p>
                        ${res.medida ? `<span class="insumo-v2-medida">${res.medida}</span>` : ''}
                    </div>
                    <hr class="mx-3 my-0 opacity-25">
                    <div class="card-body d-flex flex-column gap-2 pt-2">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="chip d-inline-flex align-items-center gap-1">
                                <i class="bi bi-boxes"></i> Stock: ${res.cantidad ?? 0}
                            </span>
                        </div>
                        <div class="precio-usd">$${parseFloat(res.precio).toFixed(2)}</div>
                        <button type="button"
                            class="btn btn-v2 w-100 d-flex align-items-center justify-content-center gap-2 mt-auto btn-agregar-insumo-uni"
                            data-index="${res.id_insumo}">
                            <i class="bi bi-plus-circle-fill"></i> Agregar
                        </button>
                    </div>
                </div>`;
            listaUni.appendChild(col);
        });
    } catch (e) {
        console.error("Error buscando insumos:", e);
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SETUP — Conectar eventos de los modales unificados
// ══════════════════════════════════════════════════════════════════════════════

function setupModalInsumos() {
    const modal = document.getElementById("modal-insumos");
    if (!modal) return;

    // Detectar contexto desde el botón que abrió el modal
    modal.addEventListener("show.bs.modal", e => {
        const trigger = e.relatedTarget;
        contextoActivo = trigger?.dataset?.contexto ?? "agregar";

        // Limpiar búsqueda anterior
        const input  = document.getElementById("input-buscar-insumo-uni");
        const listaD = document.getElementById("insumo-uni-existe");
        const ini    = document.getElementById("insumos-uni-inicial");
        const pNo    = document.getElementById("p-no-insumos-uni");
        if (input)  input.value = "";
        if (listaD) listaD.innerHTML = "";
        if (ini)    ini.classList.remove("d-none");
        if (pNo)    pNo.textContent  = "";
    });

    // Botón buscar
    document.getElementById("btn-buscar-insumo-uni")?.addEventListener("click", () => {
        const val = document.getElementById("input-buscar-insumo-uni")?.value.trim();
        if (val) buscarInsumos(val);
    });

    // Enter en input
    document.getElementById("input-buscar-insumo-uni")?.addEventListener("keydown", e => {
        if (e.key === "Enter") {
            e.preventDefault();
            const val = e.target.value.trim();
            if (val) buscarInsumos(val);
        }
    });

    // Click en "Agregar" de cualquier card en el modal (delegación)
    modal.addEventListener("click", async e => {
        const btn = e.target.closest(".btn-agregar-insumo-uni");
        if (!btn) return;
        const idInsumo = parseInt(btn.dataset.index);
        await agregarInsumo(idInsumo, contextoActivo);
    });

    // Botón cancelar → vuelve al modal padre correcto
    document.getElementById("btn-cancelar-insumo-uni")?.addEventListener("click", () => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        bsModal?.hide();
        const target = contextoActivo === "editar"
            ? "#modal-editar-hospitalizacion"
            : "#modal-agregar-hospitalizacion";
        const modalPadre = document.querySelector(target);
        if (modalPadre) new bootstrap.Modal(modalPadre).show();
    });
}

function setupModalServicios() {
    const modal = document.getElementById("modal-servicios-uni");
    if (!modal) return;

    // Detectar contexto
    modal.addEventListener("show.bs.modal", e => {
        const trigger = e.relatedTarget;
        contextoActivo = trigger?.dataset?.contexto ?? "agregar";
    });

    // Click en "Agregar" de cualquier card de servicio (delegación)
    modal.addEventListener("click", e => {
        const btn = e.target.closest(".btn-seleccionar-servicio");
        if (!btn) return;
        const idS = parseInt(btn.dataset.index);
        agregarServicio(idS, contextoActivo);
    });

    // Botón cancelar → vuelve al modal padre correcto
    document.getElementById("btn-cancelar-servicio-uni")?.addEventListener("click", () => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        bsModal?.hide();
        const target = contextoActivo === "editar"
            ? "#modal-editar-hospitalizacion"
            : "#modal-agregar-hospitalizacion";
        const modalPadre = document.querySelector(target);
        if (modalPadre) new bootstrap.Modal(modalPadre).show();
    });
}

// ══════════════════════════════════════════════════════════════════════════════
//  EXPORT PRINCIPAL — equivalente al antiguo traerSerevicio()
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Inicializa todo el sistema de servicios e insumos.
 * Llama esto una sola vez al cargar la página.
 */
export async function inicializarHospitalizacion() {
    await inicializarServicios();
    setupModalInsumos();
    setupModalServicios();
}

/**
 * Compatibilidad con el código anterior que llamaba traerSerevicio("agregar"|"editar").
 * Ahora simplemente re-renderiza el catálogo si ya está cargado,
 * y establece el contexto activo.
 */
export async function traerSerevicio(direccionM) {
    contextoActivo = direccionM;
    if (Object.keys(objServiciosBD).length === 0) {
        await inicializarServicios();
    }
    // Re-renderizar catálogo en el modal unificado
    const listaUni = document.getElementById("servicios-uni");
    if (listaUni) renderizarCatalogoServicios(listaUni);
    return objServiciosBD;
}

// Inicialización automática al importar
inicializarHospitalizacion();
