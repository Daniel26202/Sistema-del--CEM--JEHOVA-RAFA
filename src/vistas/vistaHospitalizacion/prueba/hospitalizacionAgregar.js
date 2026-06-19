/**
 * hospitalizacionAgregar.js
 *
 * Maneja el formulario de AGREGAR hospitalización.
 * Los insumos y servicios los gestiona reutilizableHospitalizacion.js
 */

import {
    executePetition,
    alertConfirm,
    alertError,
    alertSuccess,
} from "../../js/generic/funtionGeneric.js";
import { traerSerevicio } from "../../js/hospitalizacion/reutilizableHospitalizacion.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";

// ─── Elementos ────────────────────────────────────────────────────────────────
const btnInformacionPaciente = document.querySelector("#inforPaciente");
const divModal               = document.querySelector("#divModal");
const inputCedula            = document.querySelector("#bt");
const parrafoExP             = document.getElementById("p-paciente");
const parrafoNoP             = document.getElementById("p-no-paciente");
const contenedorForm         = document.getElementById("contenedorFormAgregar");
const nombreApellidoInfor    = document.getElementById("nombreInfor");
const diagnosticoInfor       = document.getElementById("inforDiagnostico");
const btnEnviar              = document.getElementById("btnEnviar");
const historiaclinica        = document.getElementById("historia_clinicaA");
const formularioAgregar      = document.getElementById("formularioAgregarH");

// ─── Buscar paciente ──────────────────────────────────────────────────────────
const traerControlDePaciente = async () => {
    const data           = new FormData(formularioAgregar);
    const resultadoVP    = await executePetition(url + "/validarPaciente", "POST", data);
    const resultadoM     = await executePetition(url + "/mostrarInformacionPCD", "POST", data);

    if (!resultadoVP) {
        parrafoNoP.textContent = "El paciente no está registrado.";
        document.getElementById("input-id-paciente").value = "";
        document.querySelector("#aPaciente")?.classList.remove("d-none");
        document.querySelector("#aPaciente")?.addEventListener("click", () => {
            document.querySelector("#cedula").value = inputCedula.value;
        });
        parrafoNoP.classList.remove("d-none");
        btnInformacionPaciente?.classList.add("d-none");
        contenedorForm?.classList.add("d-none");
        btnEnviar?.classList.add("d-none");
    } else {
        document.querySelector("#aPaciente")?.classList.add("d-none");
        const nombreApellido = `${resultadoVP.nombre} ${resultadoVP.apellido}`;
        parrafoExP.textContent        = nombreApellido;
        nombreApellidoInfor.textContent = nombreApellido;
        diagnosticoInfor.textContent  = "";
        document.getElementById("input-id-paciente").value = resultadoVP.id_paciente;

        parrafoNoP.classList.add("d-none");
        btnInformacionPaciente?.classList.remove("d-none");
        contenedorForm?.classList.remove("d-none");
        btnEnviar?.classList.remove("d-none");

        if (!resultadoM) {
            diagnosticoInfor.textContent = "Aun, no está diagnosticado";
            historiaclinica.value        = "";
        } else {
            diagnosticoInfor.textContent = resultadoM.diagnostico;
            historiaclinica.value        = resultadoM.historiaclinica.trim();
        }
    }
};

inputCedula?.addEventListener("keyup", () => {
    const cedulaValida = inputCedula.parentElement.classList.contains("valido");
    document.querySelector("#aPaciente")?.classList.add("d-none");
    parrafoExP.textContent          = "";
    nombreApellidoInfor.textContent = "";
    diagnosticoInfor.textContent    = "";
    parrafoNoP.classList.add("d-none");

    if (cedulaValida) traerControlDePaciente();
});

// ─── Guardar hospitalización ──────────────────────────────────────────────────
const modalAHospBoots = new bootstrap.Modal(document.getElementById("modal-agregar-hospitalizacion"));

const createHosp = async () => {
    try {
        const data   = new FormData(formularioAgregar);
        const result = await executePetition(url + "/agregarH/", "POST", data);
        if (result.ok) {
            // vistaTabla() es global, definida en hospitalizacionEditar.js
            if (typeof vistaTabla === "function") vistaTabla();
            modalAHospBoots.hide();
            alertSuccess(result.message);
        } else {
            throw new Error(result.error);
        }
    } catch (error) {
        alertError("Error", error);
    }
};

const verificarFormularioA = inicializarValidacionFormulario(formularioAgregar);

formularioAgregar?.addEventListener("submit", async e => {
    e.preventDefault();
    const esValido = verificarFormularioA();
    if (esValido) {
        await createHosp();
        formularioAgregar.reset();
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});

// ─── Botón Agregar → establece fecha y contexto servicios ────────────────────
function obtenerFechaHoraLocal() {
    const f   = new Date();
    const pad = n => String(n).padStart(2, "0");
    return `${f.getFullYear()}-${pad(f.getMonth() + 1)}-${pad(f.getDate())} `
         + `${pad(f.getHours())}:${pad(f.getMinutes())}:${pad(f.getSeconds())}`;
}

document.querySelector("#btnAgregarH")?.addEventListener("click", async () => {
    await traerSerevicio("agregar");
    document.querySelector("#fechaHoy").value = obtenerFechaHoraLocal();
});

// ─── Comentario autooculto ────────────────────────────────────────────────────
const comentario = document.querySelector(".comentario");
if (comentario) {
    comentario.style.display = "block";
    setTimeout(() => { comentario.style.display = "none"; }, 8000);
}
