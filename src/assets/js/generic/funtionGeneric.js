import { chulitoYX, inicializarValidacionFormulario } from "./expresionesModulares.js";

//function generica for execute petiticon ajax
export const executePetition = async (url, method, data = null) => {
    try {
        const options = { method: method };

        if (data instanceof FormData) {
            options.body = data;
        } else if (data && typeof data === "object") {
            options.headers = {
                "Content-Type": "application/json",
            };
            options.body = JSON.stringify(data);
        }

        let response = await fetch(url, options);
        return response.json();
    } catch (error) {
        return error;
    }
};

//mostrar datos a editat

export const showDataModal = (parametros) => {
    parametros.labelModal.textContent = parametros.textLabelModal;
    parametros.btnModal.textContent = parametros.btnTextModal;
    parametros.form.classList.add("editar");

    if (parametros.cedulaOculta) parametros.cedulaOculta.value = parametros.data.cedula;
    if (parametros.idOculto) parametros.idOculto.value = parametros.data.id;

    parametros.inputs.forEach((input) => {
        let campoCustom = input.closest(".campo-custom");
        let spamP = campoCustom.querySelector(".icono-der");
        let check = spamP.children[0];
        let error = spamP.children[1];
        console.log(parametros.data);
        console.log(input.getAttribute("name"));

        input.value = parametros.data[input.getAttribute("name")];
        input.parentElement.classList.remove("invalido");
        input.parentElement.classList.add("valido");

        let pError = campoCustom.querySelector("p");
        pError.classList.add("d-none");

        if (check && error) chulitoYX(check, error, "valido");
    });

    // Inicializar con editar = true
    parametros.verificarFormulario = inicializarValidacionFormulario(parametros.form);
};

export const clearModalEnviar = (parametros) => {
    parametros.labelModal.textContent = parametros.textLabelModal;
    console.log(parametros);

    parametros.btnModal.textContent = parametros.btnTextModal;
    parametros.form.classList.remove("editar");

    parametros.inputs.forEach((input) => {
        let campoCustom = input.closest(".campo-custom");
        let spamP = campoCustom.querySelector(".icono-der");
        let check = spamP.children[0];
        let error = spamP.children[1];

        input.value = "";
        input.parentElement.classList.remove("valido");
        input.parentElement.classList.remove("invalido");
        let pError = campoCustom.querySelector("p");
        pError.classList.add("d-none");

        if (check && error) {
            check.classList.add("d-none");
            error.classList.add("d-none");
        }
    });
};

// obj = {
//     labelModal: document.getElementById("label-modal"),
//     btnModal: document.getElementById("btn-modal"),
//     form: document.getElementById("formulario"),
//     inputs: document.querySelectorAll("#formulario input"),
//     textLabelModal: "Agregar nuevo registro",
//     btnTextModal: "Agregar",
// };

export const alertConfirm = (text, action, param = "") => {
    Swal.fire({
        icon: "question",
        title: "Confirmacion",
        text: text,
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            action(param);
        }
    });
};

export const alertError = (title, text) => {
    Swal.fire({
        icon: "error",
        title: title,
        text: text,
        customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
        },
    });
};

export const alertSuccess = (text) => {
    Swal.fire({
        icon: "success",
        title: "Exito",
        text: text,
        customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
        },
    });
};

export const initDataTable = (selector) => {
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
};

//funcion para convertir la hora militar en cita
export const convertirHora = (horaMilitar) => {
    // Separamos hora y minutos
    let [horaStr, minutoStr] = horaMilitar.split(":");

    let hora = parseInt(horaStr, 10);
    let minutos = parseInt(minutoStr, 10);

    // Validamos rango
    if (isNaN(hora) || isNaN(minutos) || hora < 0 || hora > 23 || minutos < 0 || minutos > 59) {
        return "Hora inválida";
    }

    // Determinamos AM o PM
    let sufijo = hora >= 12 ? "PM" : "AM";

    // Convertimos a formato 12 horas
    let hora12 = hora % 12;
    if (hora12 === 0) {
        hora12 = 12;
    }

    // Aseguramos que los minutos siempre tengan dos dígitos
    let minutosFormateados = minutos.toString().padStart(2, "0");

    return `${hora12}:${minutosFormateados} ${sufijo}`;
};

export const searchElements = (text, className, elements, pMensaje = null, parentSelector = "") => {
    const searchTerm = text.trim().toLowerCase();
    let coincidenciasTotales = 0;

    elements.forEach((ele) => {
        // Definimos el objetivo (el padre o el elemento mismo)
        const target = parentSelector !== "" ? ele.closest(parentSelector) : ele;
        if (!target) return;

        // Caso: Buscador vacío
        if (searchTerm === "") {
            target.classList.remove(className);
            return;
        }

        // Lógica de búsqueda
        const content = (ele.innerText + ele.textContent + (ele.value || "")).toLowerCase();
        const matches = content.includes(searchTerm);

        if (matches) {
            target.classList.remove(className);
            coincidenciasTotales++;
        } else {
            target.classList.add(className);
        }
    });

    // --- Lógica del mensaje de "No resultados" ---
    if (pMensaje) {
        console.log("Total coincidencias:", coincidenciasTotales);
        if (searchTerm !== "" && coincidenciasTotales === 0) {
            console.log(`No se encontraron resultados para "${text}"`);
            pMensaje.innerText = `No se encontraron resultados para "${text}"`;
        } else {
            console.log(`Resultados encontrados para "${text}": ${coincidenciasTotales}`);
            pMensaje.innerText = "";
        }
        console.log("Mensaje actualizado en el DOM:", pMensaje.innerText);
    }
};

//funcion generica para un cardTable
export const initCardData = () => {
    const tableWrappers = document.querySelectorAll('[data-render="card-table"]');

    tableWrappers.forEach((container, idx) => {
        // Evitar que se inicialice dos veces el mismo contenedor
        if (container.dataset.initialized === "true") return;
        container.dataset.initialized = "true";

        const id = `dt-card-${idx || Math.floor(Math.random() * 1000)}`;
        container.setAttribute("id", id);
        container.classList.add("card-table-container");

        // Estructura Superior (Basada en tu diseño de Datatable)
        const topBar = `
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <select class="form-select dt-entries-select w-auto" id="select-${idx}">
                        <option value="6">6</option>
                        <option value="12" selected>12</option>
                        <option value="24">24</option>
                    </select>
                    <small class="text-muted">entries per page</small>
                </div>
                <div class="position-relative" style="width: 250px;">
                    <input type="text" class="search form-control dt-search-input" placeholder="Buscar...">
                    <button type="button" class="btn btn-buscar-dt">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.442 1.398a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"></path>
                        </svg>
                    </button>
                </div>
            </div>`;

        // Estructura Inferior
        const bottomBar = `
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top text-muted small">
                <div>Showing <span class="dt-start">0</span> to <span class="dt-end">0</span> of <span class="dt-total">0</span> entries</div>
                <nav><ul class="pagination pagination-sm mb-0"></ul></nav>
            </div>`;

        container.insertAdjacentHTML("afterbegin", topBar);
        container.insertAdjacentHTML("beforeend", bottomBar);

        const firstItem = container.querySelector(".list > div");
        if (!firstItem) return;

        // Detección automática de campos con clase terminada en '-search'
        const searchFields = Array.from(firstItem.querySelectorAll('[class*="-search"]')).map((el) => el.classList[0]);

        const cardList = new List(id, {
            valueNames: searchFields,
            page: 12,
            pagination: {
                innerWindow: 1,
                left: 1,
                right: 1,
                paginationClass: "pagination",
            },
        });

        const updateMeta = () => {
            const total = cardList.matchingItems.length;
            const visible = cardList.visibleItems.length;
            const currentPos = cardList.i;
            container.querySelector(".dt-total").innerText = total;
            container.querySelector(".dt-start").innerText = total > 0 ? currentPos : 0;
            container.querySelector(".dt-end").innerText = Math.min(currentPos + visible - 1, total);
        };

        const selectEl = document.getElementById(`select-${idx}`);
        if (selectEl) {
            selectEl.addEventListener("change", function () {
                cardList.page = parseInt(this.value);
                cardList.update();
                updateMeta();
            });
        }

        cardList.on("updated", updateMeta);
        updateMeta();
    });
};
