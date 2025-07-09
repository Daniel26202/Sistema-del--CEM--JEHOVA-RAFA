// esto es para los iconos y los input
addEventListener("DOMContentLoaded", function () {
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

    const bajarBdsNube = async () => {
        try {
            let peticionBBdN = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/bajarBdsNube");
            let resultadoBBdN = await peticionBBdN.text();
            console.log(resultadoBBdN);

            let peticionConsulBd = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/consultarBd");
            let resultadoConsulBd = await peticionConsulBd.json();
            console.log(resultadoConsulBd);

            console.log(" traer bd: ");
            console.log(" consulta: ");

            if (resultadoBBdN.length > 0) {
                console.log("trae datos corectamente");
            } else {
                console.log("no trae datos");
            }

            if (resultadoConsulBd[0].length > 0) {
                console.log("consulta datos corectamente");
                let html = ``;
                let contadorDb = 0;
                resultadoConsulBd[0].forEach((res) => {
                    html += `   <tr>
                                    <td>${res}</td>
                                    <td>
                                        <a href="#" class="p-2 uk-button-primary rounded-5 fw-bold text-decoration-none text-white" type="button" id="btnEnviar" data-bs-dismiss="modal"
                                            uk-toggle="target: #restablecer${contadorDb}">Seleccionar</a>
                                    </td>

                                </tr>

                                <!-- modales -->
                                <div>
                                    <div id="restablecer${contadorDb}" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                            <!-- Boton que cierra el modal -->
                                            <div class="d-flex justify-content-between mb-5">

                                                <div class="d-flex align-items-center ajustar" id="">
                                                    <div class="svgPapeleraPatologia">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                            class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h5>
                                                            ¿Desea restaurar la base de datos?
                                                        </h5>
                                                    </div>
                                                </div>
                                                <!-- Ayuda Interactiva -->
                                                <a href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                    </svg>
                                                </a>
                                            </div>


                                            <div class="mt-5 uk-text-right btn_modal_patologias">
                                                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalBaseDatos">Cancelar</button>

                                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo/${res}/${resultadoConsulBd[0]}" class="seleccionar">
                                                    <button class="btn col-4 btn-agregarcita-modal btnrestablecer"
                                                        id="">Restaurar</button>
                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>`;
                    contadorDb++;
                });
                document.querySelector("#datosTable").innerHTML = html;
            } else {
                console.log("no consulta datos");
                document.querySelector("#datosTable").innerHTML = "no existen bases de datos descargadas";
            }
        } catch (error) {
            console.log("error intente Mas Tarde...");
            console.log(error);
        }
    };

    const formularioVU = document.querySelector("#fVerificacionU");
    const mensajeP = document.querySelector(".mensajeP");

    mensajeP.classList.add("d-none");
    const VerificacionUsuario = async (tipoBtn) => {
        // try {
        const datosFormulario = new FormData(formularioVU);

        const contenidoForm = {
            method: "POST",
            body: datosFormulario,
        };

        let peticionValidarU = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/verificacionU", contenidoForm);
        let resultadoVU = await peticionValidarU.json();

        if (resultadoVU == false) {
            console.log("El usuario no esta activo o no es super administrador.");
            mensajeP.classList.remove("d-none");
        } else {
            mensajeP.classList.add("d-none");
            if (tipoBtn === "modalDescargarBD") {
                // abre el modal de iukit
                UIkit.modal("#descargarBd").show();
            } else if (tipoBtn === "modalRestablecerBD") {
                await bajarBdsNube();
                // abre el modal de Bootstrap
                var modal = new bootstrap.Modal(document.getElementById("modalBaseDatos"));
                modal.show();
            }
        }
        // } catch (error) {
        // console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...  " + error);
        // }
    };

    document.querySelector("#descarBd").addEventListener("click", function () {
        formularioVU.reset();
        document.querySelector("#btnVerifi").addEventListener("click", function () {
            VerificacionUsuario("modalDescargarBD");
        });
    });

    document.querySelector("#btnRD").addEventListener("click", function () {
        formularioVU.reset();
        document.querySelector("#btnVerifi").addEventListener("click", function () {
            VerificacionUsuario("modalRestablecerBD");
        });
    });
});
