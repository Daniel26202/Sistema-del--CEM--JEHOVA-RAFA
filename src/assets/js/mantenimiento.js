// esto es para los iconos y los input
import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  clearStyleVInputs,
} from "../js/generic/funtionGeneric.js";
import {
  inicializarValidacionFormulario,
  chulitoYX,
} from "./generic/expresionesModulares.js";

addEventListener("DOMContentLoaded", function () {
  const url = "/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento";
  const modalBaseDatos = new bootstrap.Modal(
    document.getElementById("modalBaseDatos"),
  );
  const modalVerif = new bootstrap.Modal(document.getElementById("Verificar"));
  const modalDescarga = new bootstrap.Modal(
    document.getElementById("descargarBd"),
  );

  // buscar en la tabla
  document.getElementById("buscarBD").addEventListener("input", function () {
    const textMayuscl = this.value.toUpperCase();
    const trs = document.querySelectorAll("#datosTable tr");

    trs.forEach((tr) => {
      // nombre de la celda
      const valor = tr.cells[0].textContent.toUpperCase();
      tr.style.display = valor.includes(textMayuscl) ? "" : "none";
    });
  });

  // para el loader
  document.querySelectorAll(".seleccionar").forEach((selec) => {
    selec.addEventListener("click", function () {
      document.querySelector(".loader-wrapper").style.display = "block";
    });
  });

  //2. TU FUNCIÓN MODIFICADA QUIRÚRGICAMENTE PARA ADAPTARSE A LOS PREFIJOS
  const bajarBdsNube = async () => {
    try {
      let resultadoConsulBd = await executePetition(
        url + "/bajarBdsNube/",
        "GET",
      );
      console.log(url + "/bajarBdsNube/", resultadoConsulBd);

      if (resultadoConsulBd.length > 0) {
        console.log("consulta datos correctamente");
        let html = ``;

        resultadoConsulBd.forEach((res) => {
          // LIMPIEZA VISUAL: Reemplazamos los prefijos internos por algo entendible para el usuario
          let nombreAmigable = res
            .replace("full_", "")
            .replace("diff_", "")
            .replace("inc_", "")
            .replace("bd-", "Copia del ");
          console.log(nombreAmigable);

          html += `   <tr>
                                <td><strong>${nombreAmigable}</strong></td>
                                <td>
                                    <button data-base-datos="${res}" class="restaurarBDatos seleccionar rounded-5 p-2 btn btn-modals btnrestablecer" type="button" id="btnEnviarS">Seleccionar</button>
                                </td>
                            </tr>`;
        });
        document.querySelector("#datosTable").innerHTML = html;

        let bd = "";
        document.querySelectorAll(".restaurarBDatos").forEach((BD) => {
          BD.addEventListener("click", function () {
            bd = this.getAttribute("data-base-datos"); // Viaja con prefijo completo de forma transparente
            alertConfirm(
              "¿Desea restaurar la base de datos?",
              restaurarRespaldo,
              bd,
            );
          });
        });

        document
          .getElementById("btnRestaurar")
          .addEventListener("click", function () {
            alertConfirm(
              "¿Desea restaurar la base de datos?",
              restaurarRespaldo,
              "nohay",
            );
          });
      } else {
        console.log("no consulta datos");
        document.querySelector("#datosTable").innerHTML =
          "<tr><td colspan='2' class='text-center text-muted'>No existen bases de datos descargadas</td></tr>";
      }
    } catch (error) {
      alertError("Error", error);
    }
  };

  const formularioVU = document.querySelector("#fVerificacionU");
  let semaforo = 0;

  const VerificacionUsuario = async (tipoBtn) => {
    try {
      console.log(semaforo);

      if (semaforo === 1) return;
      document.querySelector("#loaderModal").classList.add("desvanecimiento");
      semaforo = 1;

      // llamo la función
      const data = new FormData(formularioVU);
      let resultadoVU = await executePetition(
        url + "/verificacionU/",
        "POST",
        data,
      );
      console.log(resultadoVU);

      if (resultadoVU == false) {
        console.log("El usuario no esta activo o no es super administrador.");
        alertError(
          "Error",
          "Contraseña incorrecta, o el usuario no tiene el permiso.",
        );
      } else {
        if (tipoBtn === "modalDescargarBD") {
          document
            .querySelector("#loaderModal")
            .classList.remove("desvanecimiento");
          modalVerif.hide();
          alertConfirm("¿Desea descargar la base de datos?", generarResp);
        } else if (tipoBtn === "modalRestablecerBD") {
          await bajarBdsNube();
          // abre el modal de Bootstrap
          modalBaseDatos.show();
          modalVerif.hide();
        }
      }
      semaforo = 0;
      document
        .querySelector("#loaderModal")
        .classList.remove("desvanecimiento");
      return resultadoVU;
    } catch (error) {
      document
        .querySelector("#loaderModal")
        .classList.remove("desvanecimiento");
      alertError("Error", error);
    }
  };

  const idU = document.getElementById("idU").value;

  let semaforoDos = 0;
  const generarResp = async () => {
    try {
      if (semaforoDos === 1) return;
      document.querySelector("#loaderModal").classList.add("desvanecimiento");

      let resp = await executePetition(url + "/generarRespaldo/" + idU, "GET");
      console.log(resp);
      console.log(resp.ok);

      document
        .querySelector("#loaderModal")
        .classList.remove("desvanecimiento");
      semaforoDos = 0;
      if (resp.ok) {
        alertSuccess(resp.message);
      } else {
        throw new Error(resp.error);
      }
    } catch (error) {
      document
        .querySelector("#loaderModal")
        .classList.remove("desvanecimiento");
      alertError("Error", error);
    }
  };

  let semaforoTres = 0;
  async function restaurarRespaldo(DB) {
    try {
      if (semaforoTres === 1) return;
      document.querySelector("#loaderModal").classList.add("desvanecimiento");

      let resp = await executePetition(url + "/restaurarRespaldo/" + DB, "GET");

      document
        .querySelector("#loaderModal")
        .classList.remove("desvanecimiento");
      semaforoTres = 0;
      console.log(resp);
      if (resp.ok) {
        alertSuccess(resp.message);
      } else {
        throw new Error(resp.error);
      }
    } catch (error) {
      alertError("Error", error);
    }
  }

  document.querySelectorAll(".btnVerificarV").forEach((btn) => {
    btn.addEventListener("click", function () {
      clearStyleVInputs();
      formularioVU.reset();
    });
  });

  // llamar la funcion para evitar repetir evento
  function manejadorDescargarBD() {}
  function manejadorRestablecerBD() {}
  const modalV = document.querySelector("#Verificar");

  document.querySelector("#descarBd").addEventListener("click", function () {
    modalV.setAttribute("data-verific", "descargar");
  });
  document.querySelector("#btnRD").addEventListener("click", function () {
    modalV.setAttribute("data-verific", "restaurar");
  });

  let verificarFormularioV = inicializarValidacionFormulario(formularioVU);

  formularioVU.addEventListener("submit", async function (e) {
    e.preventDefault();

    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("valido"))
        inputsBuenos.push(true);
    });

    let esValido = verificarFormularioV();

    if (esValido) {
      let verificar = modalV.getAttribute("data-verific");
      let resltado = false;
      if (verificar === "descargar") {
        await VerificacionUsuario("modalDescargarBD");
      }
      if (verificar === "restaurar") {
        await VerificacionUsuario("modalRestablecerBD");
      }
      if (resltado) {
        formularioVU.reset();
      }
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  document.querySelectorAll(".toggle-password").forEach(function (toggle) {
    toggle.addEventListener("click", function () {
      const input = document.getElementById(this.getAttribute("data-target"));
      const ojoVer = this.querySelector(".ojo-ver");
      const ojoOcultar = this.querySelector(".ojo-ocultar");

      if (input.type === "password") {
        input.type = "text";
        ojoVer.classList.add("d-none");
        ojoOcultar.classList.remove("d-none");
      } else {
        input.type = "password";
        ojoVer.classList.remove("d-none");
        ojoOcultar.classList.add("d-none");
      }
    });
  });
});
