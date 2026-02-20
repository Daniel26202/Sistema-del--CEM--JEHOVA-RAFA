import {
    executePetition,
    alertConfirm,
    alertError,
    alertSuccess,
    clearModalEnviar,
    initDataTable,
    showDataModal,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Servicios";

const dolar = parseFloat(document.getElementById("dolar").value);

//read

let formularioA = document.getElementById("modalAgregar");
if (formularioA) {
    let verificarFormulario = inicializarValidacionFormulario(formularioA);

    formularioA.addEventListener("submit", function (e) {
        e.preventDefault();

        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
        });

        let esValido = verificarFormulario();

        if (esValido) {
            if (formularioA.classList.contains("editar")) {
                updateService(this, inputsBuenos);
            } else {
                createService(this, inputsBuenos);
            }
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });
}
//create
const createService = async (form, inputs) => {
    try {
        const data = new FormData(form);
        console.log(url + "/guardar");
        let result = await executePetition(url + "/guardar", "POST", data);
        if (result.ok) {
            alertSuccess(result.message);

            form.reset();
            readServices();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//update
const updateService = async (form, inputs) => {
    try {
        const data = new FormData(form);

        let result = await executePetition(url + "/editar", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            readServices();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        console.log(error);
        alertError("Error", error);
    }
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

let selectCategoria = document.querySelector("#selectCategoria");
let objCServiciosSelect = {};
let objDoctoresSelect = {};
const readDatosDS = async () => {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) {
        metodo = "datosServicios";
    } else {
        metodo = "datosServiciosPapelera";
    }

    const resultSelect = await executePetition(url + "/" + metodo, "GET");
    console.log(resultSelect);

    resultSelect["categorias"].forEach((res) => {
        console.log(res);

        objCServiciosSelect[res.id_categoria] = res;
        objDoctoresSelect[res.id_personal] = res;
        selectCategoria.innerHTML += `<option class='option-select-background' value="${res["id_categoria"]}">${res["nombre"]}</option>`;
    });
};

const readServices = async () => {
    try {
        let metodo = "";
        let urlActual = window.location.href;

        if (!urlActual.includes("papelera")) metodo = "serviciosAjax";
        else metodo = "papeleraAjax";

        const result = await executePetition(url + "/" + metodo, "GET");
        console.log(result);

        // construir html de filas
        let html = "";
        result.forEach((element) => {
            let precioD = element.precio.toFixed(2);
            let precioB = (element.precio * dolar).toFixed(2);

            html += `<tr>
                            <td class="text-center">
                                ${element.categoria}
                            </td>
                            <td class="text-center">
                                ${precioB}  BS
                            </td>
                            <td class="text-center">
                                ${precioD} $
                            </td>
                            <td class="text-center">
                                ${element.tipo}
                            </td>
                            <td class="border-start">

                                <!-- Horario Del Doctor -->
                                <div class="d-flex justify-content-center">

                                        <a href="#" class="${urlActual.includes("papelera") ? "d-none" : ""}
                                        btn btns-accion btn-tabla me-2 btnEditarCita botonesEditarSM btnPreciosEditar btn-dt-tabla"
                                            data-id-categoria="${element.id_categoria}"
                                            data-id-tabla="modal-exampleEditar${element.id_servicioMedico}" data-bs-toggle="modal" data-bs-target="#modalAgregarServicios" 
                                            id="btnEditarServicioMedico" data-index=${element.id_servicioMedico}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>


                                    <!-- Eliminar servicio-->


                                        <a href="#" class="${
                                            urlActual.includes("papelera") ? "d-none" : ""
                                        }  btn btns-accion btn-tabla me-2 btn-dt-tabla btn-eliminar" data-index=${
                                            element.id_servicioMedico
                                        }>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </a>

                                        <a href="#" class="${!urlActual.includes("papelera") ? "d-none" : ""} btn btn-tabla btn-dt-tabla btnRestablecer"
                                        data-index=${element.id_servicioMedico} title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                            </svg>
                                        </a>
                                        
                                </div>
                                
                        
                            </td>
                            
                        </tr>

`;
        });

        const selector = ".exampleTable";

        // si ya existe DataTable, destrúyela
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().clear().destroy();
        }

        // vuelca el html en el tbody
        document.querySelector(selector + " tbody").innerHTML = html;

        document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
            ele.value = document.getElementById("id_usuario_session").value;
        });

        //llamar las funcion de eliminar
        document.querySelectorAll(".btn-eliminar").forEach((btn) => {
            btn.addEventListener("click", function () {
                const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
                alertConfirm("Esta seguro de eliminar el servicio medico?", deleteService, data);
            });
        });

        //llamar a la uncion de restablecer
        //llamar las funcion de eliminar
        document.querySelectorAll(".btnRestablecer").forEach((btn) => {
            btn.addEventListener("click", function () {
                const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];

                alertConfirm("Esta seguro de restablecer el servicio medico?", restablecerService, data);
            });
        });

        document.querySelectorAll(".botonesEditarSM").forEach((btn) => {
            btn.addEventListener("click", function () {
                //objetos con todos los parametros de la funcion
                let idC = btn.getAttribute("data-id-categoria");
                let idServicio = btn.getAttribute("data-index");

                const parametros = {
                    labelModal: divTitle,
                    textLabelModal: "Modificar Servicio",
                    form: formularioA,
                    modal: document.querySelector("#modalAgregarServicios"),
                    btnModal: document.querySelector("#botonModalServicio"),
                    btnTextModal: "Modificar",
                    data: {
                        id_categoria: idC,
                        precioBs: parseFloat(btn.closest("tr").children[1].innerText),
                        precioD: parseFloat(btn.closest("tr").children[2].innerText),
                        tipo: btn.closest("tr").children[3].innerText,
                        id: idServicio,
                    },
                    inputs: document.querySelectorAll(".inputs"),
                    cedulaOculta: false,
                    idOculto: document.getElementById("id_servicio"),
                };
                console.log(parametros.data.id_categoria);
                showDataModal(parametros);
            });
        });

        // re-inicializa
        initDataTable(selector);
    } catch (error) {
        alertError("Error", error);
    }
};

//delete
const deleteService = async (data) => {
    try {
        const result = await executePetition(url + `/eliminar/${data}`, "GET");
        if (result.ok) {
            alertSuccess(result.message);

            readServices();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

// //restablecer
const restablecerService = async (data) => {
    try {
        const result = await executePetition(url + `/restablecer/${data}`, "GET");
        if (result.ok) {
            alertSuccess(result.message);
            readServices();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};
const divTitle = document.querySelector("#modalLabelServicios");
const btnOpenModalA = document.querySelector("#btnAgregarServicioMedico");

btnOpenModalA?.addEventListener("click", function () {
    //objetos con todos los parametros de la funcion
    const parametros = {
        labelModal: divTitle,
        textLabelModal: "Registrar Servicio",
        form: formularioA,
        modal: document.querySelector("#modalAgregarServicios"),
        btnModal: document.querySelector("#botonModalServicio"),
        btnTextModal: "Registrar",
        inputs: document.querySelectorAll(".inputs"),
    };
    clearModalEnviar(parametros);
});

readServices();
readDatosDS();
