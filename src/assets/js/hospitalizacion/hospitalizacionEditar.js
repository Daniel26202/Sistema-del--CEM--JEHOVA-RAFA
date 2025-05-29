addEventListener("DOMContentLoaded", function () {
    /////////////////////////////////////////////////////////////////////////////////////
    // Ajax //////

    // horas y costo de servicio
    const horas = document.querySelector("#horasS");
    const costoHoras = document.querySelector("#costoHS");
    const costoHorasMoEx = document.querySelector("#costoHSMoEx");
    const btnGuardarCH = document.querySelector("#btnCH");

    // inputs del costo y las horas del servicio
    let iHS = document.querySelector("#inpHorasS");
    let iCS = document.querySelector("#inpCostoHS");

    let iHME = document.querySelector("#inpHorasMoEx");
    let iCME = document.querySelector("#inpCostoHMoEx");
    iHS.addEventListener("keyup", function () {
        iHME.value = iHS.value;
    });
    iHME.addEventListener("keyup", function () {
        iHS.value = iHME.value;
    });

    iCS.addEventListener("keyup", function () {
        let storedDolar = localStorage.getItem("valorDelDolar");
        let montoDolar = iCS.value / storedDolar;
        iCME.value = montoDolar.toFixed(2);
    });

    iCME.addEventListener("keyup", function () {
        let storedDolar = localStorage.getItem("valorDelDolar");
        let montoBS = iCME.value * storedDolar;
        iCS.value = montoBS.toFixed(2);
    });

    // para traerme la hora y su costo
    const traerHoraCosto = async () => {
        let storedHora = localStorage.getItem("hora");
        let storedCosto = localStorage.getItem("costo");
        let storedCostoME = localStorage.getItem("costoMoEx");

        btnGuardarCH.classList.remove("d-none");

        horas.innerText = storedHora;
        costoHoras.innerText = storedCosto;

        costoHorasMoEx.innerText = storedCostoME;
        if (storedHora != null) {
            // agrego el texto del p (en este caso las horas) al valor del input
            iHS.value = storedHora;
            iHME.value = storedHora;
        } else if (storedHora === null) {
            localStorage.setItem("hora", 0);
            horas.innerText = 0;
            iHS.value = 0;
        }

        if (storedCosto != null) {
            // agrego el texto del p (en este caso el costo de las horas) al valor del input
            iCS.value = storedCosto;
        } else if (storedCosto === null) {
            localStorage.setItem("costo", 0);
            costoHoras.innerText = 0;
            iCS.value = 0;
        }

        if (storedCostoME != null) {
            // agrego el texto del p (en este caso el costo de las horas) al valor del input
            iCME.value = storedCostoME;
        } else if (storedCostoME === null) {
            localStorage.setItem("costoMoEx", 0);
            costoHorasMoEx.innerText = 0;
            iCME.value = 0;
        }
    };

    // para traerme la hora y su costo
    const enviarHoraCosto = async () => {
        let hora = parseInt(iHS.value.trim());
        let costo = parseFloat(iCS.value.trim());
        let costoMoEx = parseFloat(iCME.value.trim());

        hora = hora === "" ? "00" : hora;
        costo = costo === "" ? "00" : costo;
        costoMoEx = costoMoEx === "" ? "00" : costoMoEx;

        localStorage.setItem("hora", hora);
        localStorage.setItem("costo", costo);
        localStorage.setItem("costoMoEx", costoMoEx);

        traerHoraCosto();

        vistaTabla();
    };

    // calculo del dolar en la infomación de la H
    async function mostrarInf(indice, idH) {
        let fechaInicioM = document.querySelectorAll(".fechaInicio")[indice].value;

        let fechaInicio = new Date(fechaInicioM);
        let fechaActual = new Date();
        let diferencia = fechaActual - fechaInicio;

        // el total de horas (con decimales)
        let horasTotales = diferencia / (1000 * 60 * 60);

        let storedHora = localStorage.getItem("hora");
        let storedCosto = localStorage.getItem("costo");
        let storedCostoMoEx = localStorage.getItem("costoMoEx");
        let costoH = parseFloat(storedCosto) / parseInt(storedHora);
        let costoHMoEx = parseFloat(storedCostoMoEx) / parseInt(storedHora);

        // monto de horas y minutos
        let monto = horasTotales * costoH;
        let montoMoEx = horasTotales * costoHMoEx;

        console.log(horasTotales);
        console.log("   ");
        console.log(monto);

        let horas = Math.floor(horasTotales);
        let minutos = Math.floor((horasTotales - horas) * 60);

        let totalMontoI = await sumaPrecioIH(idH);

        if (totalMontoI === undefined) {
            totalMontoI = 0;
        }

        let total = totalMontoI + monto;
        let storedDolar = localStorage.getItem("valorDelDolar");

        let totalMontoIMoEx = totalMontoI / storedDolar;
        let totalME = totalMontoIMoEx + montoMoEx;

        monto = parseFloat(monto);
        montoMoEx = parseFloat(montoMoEx);
        total = parseFloat(total);
        totalME = parseFloat(totalME);

        document.querySelector("#hHosM").innerText = `${horas}h ${minutos}min`;
        document.querySelector("#cMontoHoraM").innerText = monto.toFixed(2);
        document.querySelector("#cMoHoraMoExM").innerText = montoMoEx.toFixed(2);
        document.querySelector("#calculoTotal").innerText = total.toFixed(2);
        document.querySelector("#calculoTotalME").innerText = totalME.toFixed(2);

        let hMM = document.querySelectorAll(".hME")[indice];
        let historiaM = document.querySelector("#historiaM");

        // trim() quita los espacios en el principio y al final
        historiaM.innerText = hMM.value;
        return [monto, montoMoEx, total, totalME];
    }

    // inputs y nombres de editar H
    const nombreApE = document.querySelector("#NombreAp");
    const precioHE = document.querySelector("#precioH");
    const historiaE = document.querySelector("#historiaE");

    async function editar(indice) {
        // obtenemos los datos del elemento seleccionado
        const fila = document.querySelectorAll("#tbody tr")[indice];
        let datos = fila.getElementsByTagName("td");

        // let precHoras = document.querySelectorAll(".precioHo")[indice];
        let hME = document.querySelectorAll(".hME")[indice];

        // colocamos el nombre y apellido.
        nombreApE.innerHTML = "";
        nombreApE.innerHTML = datos[1].innerText + " " + datos[2].innerText;

        // trim() quita los espacios en el principio y al final
        historiaE.value = hME.value;

        let idControl = document.querySelectorAll(".idC")[indice];
        document.querySelector("#idCE").value = parseInt(idControl.value);

        let idHospitalizacion = document.querySelectorAll(".idHpt")[indice];
        document.querySelector("#idHptE").value = parseInt(idHospitalizacion.value);

        console.log(document.querySelectorAll(".fechaInicio")[indice].value);
    }

    function botonInputNumber(btn, inputN) {
        let dataI = btn.getAttribute("data-index");
        let min = inputN.getAttribute("min");
        let max = inputN.getAttribute("max");
        let step = inputN.getAttribute("step");
        let val = inputN.getAttribute("value");
        let calcStep = dataI == "aumentar" ? step * 1 : dataI == "disminuir" ? step * -1 : false;
        let nuevoValor = parseInt(val) + calcStep;

        if (nuevoValor >= min && nuevoValor <= max) {
            inputN.setAttribute("value", nuevoValor);
        }
    }

    // sumar el precio de insumos
    let totalPI = 0;

    const sumarTotalE = () => {
        // contador del precio de cada insumo
        let PrecioI = 0;

        totalPI = 0;
        document.querySelectorAll(".precioInsumE").forEach((pI) => {
            // selecciono al p del precio (hermano anterior del input)
            let pPrecioI = pI.previousElementSibling;

            // selecciono el div del input
            let divPadre = pI.parentElement;
            // selecciono el padre del div del input
            let divPadr = divPadre.parentElement;
            // selecciono el padre del padre del div del input
            let divPad = divPadr.parentElement;
            // selecciono el padre del padre del padre del div del input
            let divPa = divPad.parentElement;
            // selecciono el input hermano del div padre
            let divHermano = divPa.nextElementSibling;
            // selecciono al hermano del input
            let divHer = divHermano.nextElementSibling;
            // selecciono al hijo del div
            let divHijo = divHer.firstElementChild;
            // selecciono al hijo del hijo del div
            let divHi = divHijo.firstElementChild;
            // selecciono a los hijos del div
            let divH = divHi.children;

            // se recolecta el valor del input
            PrecioI = parseFloat(pI.value);

            // traigo la cantidad
            let cantidad = parseInt(divH[1].value);

            // suma el total del precio de cada insumo que se multiplico con la cantidad
            totalPI += PrecioI * cantidad;

            // aquí se recolecta el precio multiplicado con la cantidad (en las dos lineas siguientes, se coloca el precio ya multiplicado en el <p>)
            totalPC = PrecioI * cantidad;
            // para que muestre solo dos decimales (esto "toFixed" lo convierte en text)
            totalPC = parseFloat(totalPC.toFixed(2));

            pPrecioI.innerHTML = totalPC + "bs";
        });
    };

    ////////////////////////////////////////////////////////////////////
    //Ajax//
    let horaInicioHosp = 0;
    // envío de datos de la edición
    const vistaTabla = async () => {
        // try {

        // llamo la función
        peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/traerSesion");
        let resultad = await peticion.json();

        if (resultad.length == 0) {
            console.log("algo salio mal");
        } else {
            await traerHoraCosto();
            mostrarMsj();
            if (resultad[1] == false) {
                html = `<tr>
                                <td colspan="8" class="text-center">NO HAY REGISTROS
                                </td>
                            </tr>`;
                document.querySelector("#tbody").innerHTML = html;
            } else {
                let html = ``;
                let htmlModalElim = ``;

                // console.log(resultad[1]);
                // recorro los datos de hospitalización
                console.log(resultad[1]);

                resultad[1].forEach((res, index) => {
                    horaInicioHosp = res.fecha_hora_inicio;

                    // contenido de la tabla.
                    html += `<tr>
                                    <td>
                                        ${res["cedula"]}
                                    </td>
                                    <td>
                                        ${res["nombre"]}
                                    </td>
                                    <td>
                                        ${res["apellido"]}
                                    </td>
                                    <td class="col-11 tdHS">
                                        
                                        ${res["diagnostico"]}
                                    
                                    </td>
                                    <td>
                                        ${res["nombredoc"]} ${res["apellidodoc"]}
                                    </td>`;

                    // verifico si es administrador o doctor
                    // uno es doctor
                    if (resultad[0][1] == 1) {
                        html += `<!--no hay-->`;
                    }

                    html += `   <td>
                                        <div class="d-flex flex-wrap col-12">
                                            <div class="col-12 col-md-6 col-lg-3">

                                                <!-- btn offcanvas mostrar datos -->
                                                <button class="btn btn-tabla mb-1 me-1 informacionH" uk-toggle="target: #offcanvas-mostrarH" uk-tooltip="información de hospitalización" data-id-hospitalizacion="${res["id_hospitalizacion"]}" data-index="${index}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                                        class="bi bi-card-text" viewBox="0 0 16 16">
                                                        <path
                                                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                                        <path
                                                            d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3">

                                                <!-- btn modal editar hospitalización -->
                                                <button class="btn btn-tabla mb-1 editarH me-1" data-bs-toggle="modal"
                                                    data-bs-target="#modal-editar-hospitalizacion" uk-tooltip="Modificar hospitalización" data-index="${index}"
                                                    data-extra="${res["id_hospitalizacion"]}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                                    </svg>
                                                </button>
                                            </div>`;

                    // verifico si es administrador o usuario
                    // uno es doctor
                    if (resultad[0][1] == 1) {
                        html += `<!--no hay-->`;
                    }
                    // verifico si es administrador o usuario
                    // cero es administrador mas no doctor
                    if (resultad[0][1] == 0) {
                        html += `       
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <button class="btn btn-tabla mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modal-eliminar-hospitalizacion${res["id_hospitalizacion"]}" uk-tooltip="Eliminar hospitalización">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                                        class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                    </svg>
                                                </button>
                                            </div>`;
                    }
                    // verifico si es administrador o usuario
                    // cero es administrador mas no doctor
                    if (resultad[0][1] == 0) {
                        html += `    
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <a href="#" class="btn btn-tabla mb-1 me-1 btnFH" uk-tooltip="Facturar hospitalización" id="" title=""
                                                    aria-describedby="uk-tooltip-25" data-id-hospitalizacion="${res["id_hospitalizacion"]}" data-index="${index}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                                    </svg>
                                                </a>
                                            </div>`;
                    }

                    html += `  
                                        </div>
                                    </td>
                                </tr>`;

                    // contenido del modal de eliminar
                    htmlModalElim += `
                                        <div>
                                            <input type="hidden" name="" class="fechaInicio" value="${res["fecha_hora_inicio"]}">
                                            <input class="precioHo" type="hidden" name="" value="${res.precio_horas}">
                                            <input class="idC" type="hidden" name="" value="${res.id_control}">
                                            <input class="idHpt" type="hidden" name="" value="${res.id_hospitalizacion}">
                                            <input class="hME" type="hidden" name="" value="${res.historiaclinica}">
                                        </div>


                                        <div class="modal fade" id="modal-eliminar-hospitalizacion${res.id_hospitalizacion}"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen-md-down  uk-offcanvas-container">
                                                <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4">


                                                    <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                                                        <div class=" d-flex justify-content-center align-items-center ">

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                                class="bi bi-trash3-fill color-icono me-1 mb-2" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                            </svg>
                                                            <h4 class=" fw-bold ">Desea eliminar la hospitalización</h4>
                                                        </div>

                                                        <!-- btn close -->
                                                        <div>
                                                            <a href="#" class="" data-bs-dismiss="modal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                                                    class="bi bi-x-circle color-icono" viewBox="0 0 16 16">
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                                    <path
                                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                                </svg>
                                                            </a>
                                                        </div>

                                                    </div>

                                                    <form class="" action="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/eliminaL" method="post">

                                                        <input type="hidden" name="idH" class="idHosp" value="${
                                                            res.id_hospitalizacion
                                                        }">

                                                        <input type="hidden" name="id_usuario_bitacora" value="${document
                                                            .querySelector("#modalEli")
                                                            .getAttribute("data-index")}">

                                                        <p class="uk-text-center mt-4 ">
                                                            <button class="uk-button rounded-5 btn-cancelar fw-bold" type="button"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button class="uk-button uk-button-primary rounded-5 ms-2 fw-bold" type="submit"
                                                                data-bs-dismiss="modal">Eliminar</button>
                                                        </p>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>`;
                });

                document.querySelector("#tbody").innerHTML = html;
                document.querySelector("#modalEli").innerHTML = htmlModalElim;

                let aFacH = document.querySelectorAll(".btnFH");
                // aFacH
                for (const factH of aFacH) {
                    factH.addEventListener("click", async function () {
                        // para traer el valor del data index
                        let index = this.getAttribute("data-index");
                        let idHospit = this.getAttribute("data-id-hospitalizacion");
                        console.log(idHospit + " id hospitalizacion");

                        let datos = await mostrarInf(parseInt(index), parseInt(idHospit));
                        let monto = datos[0];
                        let montoME = datos[1];
                        let total = datos[2];
                        let totalME = datos[3];

                        window.location.href = `/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/enviarAFacturar/${idHospit}/${monto}/${montoME}/${total}/${totalME}`;
                        
                    });
                }

                // recorremos los btn editar
                document.querySelectorAll(".editarH").forEach((editH) => {
                    editH.addEventListener("click", function () {
                        // para traer el valor del data index
                        let index = editH.getAttribute("data-index");
                        editar(parseInt(index));

                        // para traer el valor del data extra
                        let extra = editH.getAttribute("data-extra");
                        // es el id de la hospitalizacion
                        mostrarIE(parseInt(extra));
                        // este evento es para buscar el insumo
                        document.querySelector("#btn-buscarInsumoE").addEventListener("click", function () {
                            traerInsumosE();
                        });
                    });
                });
                // recorremos los btn informacion
                document.querySelectorAll(".informacionH").forEach((inforH) => {
                    inforH.addEventListener("click", function () {
                        let tr = inforH.closest("tr");
                        let columnas = tr.children;

                        let nombreAp = document.getElementById("nombreApellidoM");
                        let cedula = document.getElementById("cedulaM");
                        let diagnostico = document.getElementById("diagnosticoM");
                        let doctor = document.getElementById("doctorM");
                        let historia = document.getElementById("historiaM");

                        nombreAp.innerHTML = `${columnas[1].innerText} ${columnas[2].innerText}`;
                        cedula.innerHTML = columnas[0].innerText;
                        diagnostico.innerHTML = columnas[3].innerText;
                        doctor.innerHTML = columnas[4].innerText;

                        // para traer el valor del data index (la posición)
                        let index = inforH.getAttribute("data-index");
                        let idHospit = inforH.getAttribute("data-id-hospitalizacion");
                        mostrarInf(parseInt(index), parseInt(idHospit));
                    });
                });

                // para validar las cantidades de hospitalizaciones agregadas
                // obtenemos la cantidad de filas que existen
                const filas = document.querySelectorAll("#tbody tr");

                if (filas.length === 3) {
                    // se oculta el btn y el modal al alcanzar el limite de hospitalizaciones
                    document.querySelector("#btnAgregarH").classList.add("d-none");
                    document.querySelector("#divModal").classList.add("d-none");
                    document.querySelector("#pModalOculto").classList.remove("d-none");
                } else {
                    // se muestra el modal y el btn de agregar
                    document.querySelector("#btnAgregarH").classList.remove("d-none");
                    document.querySelector("#divModal").classList.remove("d-none");
                    document.querySelector("#pModalOculto").classList.add("d-none");
                }
            }
        }

        // } catch (error) {
        // console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        // }
    };

    vistaTabla();

    let btnAInsumoNoExisteE = document.querySelector("#btnAInsumoNoExisteE");
    let btnAInsumoExisteE = document.querySelector("#btnAInsumoExisteE");
    let divDI = document.querySelector("#divDI");

    //es para hacer una suma con el precio de los insumo que la hospitalización tiene registrado
    const sumaPrecioIH = async (id) => {
        // try {
        // llamo la función traer insumos de h
        let peticionI = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/traerInsuDHEd/" + id);
        let resultadoI = await peticionI.json();

        if (resultadoI.length > 0) {
            let precioIns = 0;
            resultadoI.forEach((res) => {
                precioIns += parseFloat(res.precio) * parseInt(res.cantidad);
            });

            // para que muestre solo dos decimales (esto "toFixed" lo convierte en text)
            precioIns = parseFloat(precioIns.toFixed(2));
            return precioIns;
        } else {
            // if (resultadoDH === false) {
            console.log("no se encontró la hospitalización");
            // }
        }
        // } catch (error) {
        //     console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...:)");
        // }
    };

    //es para mostrar los insumos de la hospitalización seleccionada
    const mostrarIE = async (id) => {
        try {
            // llamo la función buscar Insumos de la hospitalización
            let peticionI = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/traerInsuDHEd/" + id);
            let resultadoI = await peticionI.json();
            let precioIMC = 0;

            if (resultadoI.length > 0) {
                btnAInsumoNoExisteE.classList.toggle("d-none", true);
                btnAInsumoExisteE.classList.toggle("d-none", false);

                let html = ``;
                resultadoI.forEach((res) => {
                    // se multiplica el precio con la cantidad.
                    precioIMC = parseInt(res.precio) * parseInt(res.cantidad);

                    html += `
                    <p class="text-danger text-center m-0 p-0 d-none">Límite de cantidad alcanzado</p>
                    <div class="d-flex mt-4 mb-4 align-items-center col-12 divInsumosAgregados" data-index=>

                        <div class="col-2 ps-4 pb-1">
                            <a href="#" class="ms-2 eliminarInsE eleEli" data-index="${res.id_insumoDeHospitalizacion}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" class="bi bi-x-circle color-icono"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </a>
                        </div>

                        <div class="d-flex justify-content-center align-items-center col-8">

                            <div class="borde-input-agregar m-auto col-12">

                                <div class=" d-flex justify-content-center align-items-center pb-2">

                                    <div class="col-6 ms-2">
                                        <p class="color-letras fw-bold margen-dos-puntos">${res.nombre}</p>
                                    </div>

                                    <div class="col-2 text-center ">
                                        <p class=" fw-bold margen-dos-puntos">:</p>
                                    </div>

                                    <div class="col-4">
                                        <p class="precio-medicina-agregar ">${precioIMC}bs</p>
                                        <input type="hidden" class="precioInsumE" value="${res.precio}">
                                        <input type="hidden" class="" name="id_idh[]" value="${res.id_insumoDeHospitalizacion}">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <input class="inputIdInsuE" type="hidden" name="" data-limite-cantidad="${res.limite_insumo}" value="${res.id_insumo}">

                        <div class="col-2 ms-2 cantidadIns">
                            <div class="posicion-input-number m-auto">
                                <div class="contenedorNumber d-flex justify-content-center align-items-center ">

                                    <div class="btn-max-min btn-min-lugar tamano-btn-min fw-bold disminuir masMenos" id="" data-index="disminuir"> - </div>

                                    <!-- readonly : es para que no puedan modificar el numero-->
                                    <input class="input-number input-numberE fw-bold" name="cantidad[]" type="number" min="1" max="100" step="1" value="${res.cantidad}" id="inputNumber" readonly>

                                    <div class="btn-max-min btn-max-lugar fw-bold aumentar masMenos" id="" data-index="aumentar"> + </div>

                                </div>
                            </div>
                        </div>

                    </div>`;
                });

                divDI.innerHTML = html;

                eliminar();
                cantidadAD();

                // para que sume al traer insumos (al presionar en el btn de editar).
                sumarTotalE();

                // para que el input inicie vacío
                document.getElementById("idInEli").value = "";
                // para que el input inicie vacío
                document.getElementById("idInEliDos").value = "";

                let agregandoI = true;
                // para traerme el id del insumo eliminado, y el [] es para que el array inicie vacío.
                eleEliminado([], agregandoI);
            } else {
                btnAInsumoNoExisteE.classList.toggle("d-none", false);
                btnAInsumoExisteE.classList.toggle("d-none", true);

                divDI.innerHTML = "";
                // para que sume al no traer insumos (al presionar en el btn de editar).
                sumarTotalE();
            }
        } catch (error) {
            console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...:)");
        }
    };

    let inputIE = document.querySelector("#btbtE");
    let parrafoNoIE = document.querySelector("#p-no-insumosE");
    let insumoExisteE = document.querySelector("#insumoExisteE");
    let insumosE = document.querySelector("#insumosE");

    function traerIdIE() {
        // id del insumos para poder agregarlo
        let idI = -1;
        document.querySelectorAll(".divInsumosE").forEach((insumo) => {
            //es para traer el id
            if (insumo) {
                insumo.addEventListener("click", function () {
                    idI = parseInt(this.dataset["index"]);

                    traerUnInsumoE(idI);
                });
            }
        });
    }

    // es para traer el id del insumo sin necesidad de una búsqueda
    let divInsumosE = document.querySelectorAll(".divInsumosE");
    if (divInsumosE) {
        traerIdIE();
    }

    const traerInsumosE = async () => {
        try {
            valorIE = inputIE.value;

            // llamo la función buscar Insumos
            let peticionInsumos = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarInsumos/" + valorIE);

            let resultadoInsu = await peticionInsumos.json();

            //si se trae algo
            if (resultadoInsu.length > 0) {
                parrafoNoIE.innerText = "";

                insumoExisteE.classList.toggle("d-none", false);
                insumosE.classList.toggle("d-none", true);

                let html = ``;

                resultadoInsu.forEach((res) => {
                    html += `<div class="col-6 divInsumosE" data-index=${res.id_insumo}>
                    <a href="#" class="text-center text-decoration-none m-0" data-bs-toggle="modal"
                        data-bs-target="#modal-editar-hospitalizacion">
                        <div class="color-icono d-flex align-items-center justify-content-center p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                class="bi bi-plus-circle me-2 " viewBox="0 0 16 16">
                                <path
                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            <p class="mt-3 ">
                                ${res.nombre}
                            </p>
                        </div>
                    </a>
                    <input type="hidden" name="" class="inputInsumo" value="">
                </div>`;
                });

                insumoExisteE.innerHTML = html;

                // para traer el id del insumo de la base de datos, ademas para que la recolecte la otra función async
                traerIdIE();

                // si no se trae nada
            } else {
                parrafoNoIE.innerText = "";
                parrafoNoIE.innerText = "El insumo no esta registrado";

                insumoExisteE.classList.toggle("d-none", true);
                insumosE.classList.toggle("d-none", true);
            }
        } catch (error) {
            console.log("insumos lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    };

    function cantidadAD() {
        // esto recorre todos los input number de cantidad
        let div = document.querySelectorAll(".divInsumosAgregados");

        for (const divI of div) {
            // id del insumo
            let idI = parseInt(divI.querySelector(".inputIdInsuE").value);
            let inputN = divI.querySelector(".input-numberE");

            // esto selecciona al p que muestra un mensaje
            let p = divI.previousElementSibling;
            // esto selecciona al div que muestra un -
            let menos = inputN.previousElementSibling;
            // esto selecciona al div que muestra un +
            let mas = inputN.nextElementSibling;

            menos.addEventListener("click", async function () {
                // llamo a la función que hace el calculo (aumentar y disminuir) en este caso disminuye y luego hace el calculo matemático
                botonInputNumber(menos, inputN);
                sumarTotalE();

                let objIL = await limiteI(idI);
                // si no encuentro el id
                if (!objIL[idI]) {
                    p.classList.add("d-none");
                } else {
                }
            });

            mas.addEventListener("click", async function () {
                let objIL = await limiteI(idI);
                // si encuentro el id
                if (objIL[idI]) {
                    p.classList.remove("d-none");
                } else {
                    p.classList.add("d-none");
                    // llamo a la función que hace el calculo (aumentar y disminuir) en este caso aumenta y luego hace el calculo matemático
                    botonInputNumber(mas, inputN);
                }

                sumarTotalE();
            });
        }
    }
    // para traerme el id del insumo de la hospitalización
    function eleEliminado(arrayIdIH, agregandoI) {
        document.querySelectorAll(".eleEli").forEach((elim) => {
            elim.addEventListener("click", function () {
                let idIDHR = 0;
                if (agregandoI) {
                    // traemos el id
                    idIDHR = this.dataset["index"];
                    // es un array que no tiene nada y luego se va llenando al ir eliminando
                    arrayIdIH.push(idIDHR);
                    // convertimos el valor (array) en un JSON
                    document.getElementById("idInEli").value = JSON.stringify(arrayIdIH);
                } else if (agregandoI == false) {
                    // traemos el id
                    idIDHR = this.dataset["index"];
                    // es un array que no tiene nada y luego se va llenando al ir eliminando
                    arrayIdIH.push(idIDHR);
                    // convertimos el valor (array) en un JSON
                    document.getElementById("idInEliDos").value += idIDHR + ",";
                    agregandoI = false;
                }
            });
        });
    }

    function eliminar() {
        document.querySelectorAll(".eliminarInsE").forEach((elim) => {
            elim.addEventListener("click", function () {
                // selecciono el padre btn
                let divP = elim.parentElement;
                // selecciono el padre del div del btn
                let eliminarI = divP.parentElement;
                let p = eliminarI.previousElementSibling;

                eliminarI.remove();
                p.remove();

                //para que reste el insumo que se a eliminado del total
                sumarTotalE();
            });
        });
    }

    // función async, es para mostrar un (1) insumo seleccionado
    const traerUnInsumoE = async (id) => {
        try {
            // llamo la función buscar un Insumo
            let peticionUnInsumo = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarUnInsumo/" + id);
            let resultadoUnInsu = await peticionUnInsumo.json();

            // si no se trae nada
            if (resultadoUnInsu == false) {
                console.log("hay un problema, el insumo seleccionado no existe");

                btnAInsumoNoExisteE.classList.toggle("d-none", false);
                btnAInsumoExisteE.classList.toggle("d-none", true);

                //si se trae algo
            } else {
                btnAInsumoNoExisteE.classList.toggle("d-none", true);
                btnAInsumoExisteE.classList.toggle("d-none", false);

                let existeIn = true;

                // esto recorre todos los input number de cantidad
                let div = document.querySelectorAll(".divInsumosAgregados");
                if (div) {
                    let objIL = await limiteI(id);
                    // el insumo no existe
                    if (objIL[id]) {
                        existeIn = false;
                        alert("El insumo alcanzo el limite de su cantidad");
                    }
                }
                for (const divI of div) {
                    // id del insumo
                    let idInputI = divI.querySelector(".inputIdInsuE");
                    // esto selecciona al p que muestra un mensaje
                    let p = divI.previousElementSibling;

                    // para la cantidad
                    // si el insumo existe hace lo siguiente
                    if (id == idInputI.value) {
                        existeIn = false;

                        // selecciono el hermano
                        let divHermano = idInputI.nextElementSibling;
                        // selecciono el primer hijo
                        let divHijo = divHermano.firstElementChild;
                        // selecciono el primer hijo del div hijo
                        let divHDH = divHijo.firstElementChild;
                        // selecciono los hijos del div que es padre del input number.
                        let divPadreIN = divHDH.children;

                        let objIL = await limiteI(id);
                        // si encuentro el id no lo agrega su cantidad esta agotada
                        if (objIL[id]) {
                            p.classList.remove("d-none");
                        } else {
                            p.classList.add("d-none");
                            // llamo a la función que hace el calculo (aumentar y disminuir) en este caso aumenta y luego hace el calculo matemático
                            // aquí selecciono el div que tiene un ( + ) y el input
                            botonInputNumber(divPadreIN[2], divPadreIN[1]);
                        }

                        // para sumar precio, al presionar un insumo ya existente.
                        sumarTotalE();
                    } else {
                    }
                }

                let html = ``;

                if (existeIn) {
                    html = `
                    <p class="text-danger text-center m-0 p-0 d-none">Límite de cantidad alcanzado</p>
                    <div class="d-flex mt-4 mb-4 align-items-center col-12 divInsumosAgregados">
    
                        <div class="col-2 ps-4 pb-1">
                            <a href="#" class="ms-2 eliminarInsE">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" class="bi bi-x-circle color-icono"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </a>
                        </div>

                        <div>
                            <input type="hidden" name="agrega" value="si">
                        </div>
    
                        <div class="d-flex justify-content-center align-items-center col-8">
    
                            <div class="borde-input-agregar m-auto col-12">
    
                                <div class=" d-flex justify-content-center align-items-center pb-2">
    
                                    <div class="col-6 ms-2">
                                        <p class="color-letras fw-bold margen-dos-puntos">${resultadoUnInsu.nombre}</p>
                                    </div>
    
                                    <div class="col-2 text-center ">
                                        <p class=" fw-bold margen-dos-puntos">:</p>
                                    </div>
    
                                    <div class="col-4">
                                        <p class="precio-medicina-agregar ">${resultadoUnInsu.precio}bs</p>
                                        <input type="hidden" class="precioInsumE" value="${resultadoUnInsu.precio}">
                                    </div>
    
                                </div>
    
                            </div>
    
                        </div>
    
                        <input class="inputIdInsuE" type="hidden" name="id_insumoA[]" data-limite-cantidad="${resultadoUnInsu.limite_insumo}" value="${resultadoUnInsu.id_insumo}">
    
                        <div class="col-2 ms-2 cantidadIns">
                            <div class="posicion-input-number m-auto">
                                <div class="contenedorNumber d-flex justify-content-center align-items-center ">
    
                                    <div class="btn-max-min btn-min-lugar tamano-btn-min fw-bold disminuir masMenos" id="" data-index="disminuir"> - </div>
    
                                    <!-- readonly : es para que no puedan modificar el numero-->
                                    <input class="input-number input-numberE fw-bold" name="cantidadA[]" type="number" min="1" max="100" step="1" value="1" id="inputNumber" readonly>
    
                                    <div class="btn-max-min btn-max-lugar fw-bold aumentar masMenos" id="" data-index="aumentar"> + </div>
    
                                </div>
                            </div>
                        </div>
    
                    </div>`;

                    divDI.innerHTML += html;

                    cantidadAD();

                    let agregando = false;
                    eleEliminado([], agregando);
                }

                eliminar();
                //para la suma total
                sumarTotalE();
            }
        } catch (error) {
            console.log("insumos lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    };

    function mostrarMsj() {
        let urlActual = window.location.href;

        if (urlActual.includes("agregado")) {
            // quitar esto (&agregado) de la url
            let nuevaUrl = urlActual.replace("/agregado", "");
            // se agrega la nueva url
            window.history.replaceState(null, null, nuevaUrl);

            // agregamos el comentario
            let html = `<div class="uk-alert-primary comentario me-4 fw-bolder pb-2" style="display: none;" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 pb-1">Se ha agregado correctamente.</p>
                        </div>`;
            document.querySelector("#divComentarios").innerHTML = html;
        } else if (urlActual.includes("eliminado")) {
            // quitar esto (&agregado) de la url
            let nuevaUrl = urlActual.replace("/eliminado", "");
            // se agrega la nueva url
            window.history.replaceState(null, null, nuevaUrl);

            // agregamos el comentario
            let html = `<div class="uk-alert-primary comentario me-4 fw-bolder pb-2" style="display: none;" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 pb-1">Se elimino correctamente.</p>
                        </div>`;
            document.querySelector("#divComentarios").innerHTML = html;
        } else if (urlActual.includes("error")) {
            // quitar esto (&agregado) de la url
            let nuevaUrl = urlActual.replace("/error", "");
            // se agrega la nueva url
            window.history.replaceState(null, null, nuevaUrl);

            // agregamos el comentario
            let html = `<div class="uk-alert-primary comentario me-4 fw-bolder pb-2" style="display: none;" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 pb-1">La hospitalización ya existe.</p>
                        </div>`;
            document.querySelector("#divComentarios").innerHTML = html;
        } else if (urlActual.includes("registroPaciente")) {
            // quitar esto (&agregado) de la url
            let nuevaUrl = urlActual.replace("/registroPaciente", "");
            // se agrega la nueva url
            window.history.replaceState(null, null, nuevaUrl);

            // agregamos el comentario
            let html = `<div class="uk-alert-primary comentario me-4 fw-bolder pb-2" style="display: none;" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 pb-1">El paciente fue registrado exitosamente.</p>
                        </div>`;
            document.querySelector("#divComentarios").innerHTML = html;
        }

        //este es el comentario
        const comentario = document.querySelector(".comentario");
        //si existe el comentario lo muestra y después de 8sg lo oculta
        if (comentario) {
            comentario.style.display = "block";

            setTimeout(function () {
                comentario.style.display = "none";
            }, 8000);
        }
    }

    const formE = document.querySelector("#formularioEditarH");
    const divME = document.querySelector(".divModalE");

    // envío de datos de la edición
    const envioDatE = async () => {
        try {
            const datosFormulario = new FormData(formE);

            const contenidoForm = {
                method: "POST",
                body: datosFormulario,
            };

            // llamo la función
            await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/modificarH", contenidoForm);
            divME.classList.remove("show");
            divModal.setAttribute("style", "touch-action: pan-y pinch-zoom; transition: all 0.3s ease-out ;");

            // vista de la tabla
            vistaTabla();

            // agregamos el comentario
            let html = `<div class="uk-alert-primary comentario me-4 fw-bolder pb-2" style="display: none;" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 pb-1">Se actualizo correctamente.</p>
                        </div>`;
            let div = document.querySelector("#divComentarios");
            div.innerHTML = html;

            //este es el comentario
            const comentario = document.querySelector(".comentario");
            //si existe el comentario lo muestra y después de 8sg lo oculta
            if (comentario) {
                comentario.style.display = "block";

                setTimeout(function () {
                    comentario.style.display = "none";
                }, 8000);
            }
        } catch (error) {
            console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    };

    // para enviar los datos de la edición
    formE.addEventListener("submit", (e) => {
        envioDatE();
        e.preventDefault();
    });

    // para el buscador de hospitalización
    let inputBuscH = document.querySelector("#inputBuscH");
    const btnBuscH = document.querySelector("#btnBuscH");
    const notifi = document.querySelector("#notificacion");

    // buscador de hospitalización
    function buscarH() {
        let contadorH = 0;
        let contadorHNo = 0;

        // selecciono todos los tr de la tabla
        const filas = document.querySelectorAll("#tbody tr");
        // recolecto la cédula del input
        let cdH = inputBuscH.value;

        // recorro las filas de la tabla
        filas.forEach((fila) => {
            // cuenta las hospitalizaciones que existen.
            contadorH = contadorH + 1;

            // verifico si la cédula existe
            if (fila.children[0].innerText.includes(cdH)) {
                fila.classList.remove("d-none");
                notifi.classList.add("d-none");
            } else {
                fila.classList.add("d-none");
                // cuenta las veces que no encuentra una hospitalización
                contadorHNo = contadorHNo + 1;
            }
        });

        // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes
        if (contadorH === contadorHNo) {
            // muestra el texto.
            notifi.classList.remove("d-none");
        }
    }

    // al presionar click realiza la función
    btnBuscH.addEventListener("click", function () {
        buscarH();
    });

    document.querySelector("#formCostoHora").addEventListener("submit", function (e) {
        e.preventDefault();
        enviarHoraCosto();
    });

    ///////////////////////////////////////////////////
    // conteo de insumos

    // operación matemática para saber cual insumo llego a su limite en cantidad
    const limiteI = async (idIn) => {
        try {
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarUnInsumo/" + parseInt(idIn));
            let resultado = await peticion.json();

            console.log(resultado);

            let insumosLim = {};

            // creamos esa posición con ese numero de id, y dentro su contenido
            insumosLim[parseInt(resultado.id_insumo)] = {
                id: parseInt(resultado.id_insumo),
                cantidadT: 0,
                limite: parseInt(resultado.limite_insumo),
            };

            let insumosExL = {};
            document.querySelectorAll(".divInsumosAgregados").forEach((divI) => {
                // id del insumo
                let idI = divI.querySelector(".inputIdInsuE");
                let limiteI = idI.getAttribute("data-limite-cantidad");
                let cantidad = parseInt(divI.querySelector(".input-numberE").value);
                idI = parseInt(idI.value);

                // creamos esa posición con ese numero de id, y dentro su contenido
                insumosExL[idI] = {
                    id: parseInt(idI),
                    cantidadT: cantidad,
                    limite: parseInt(limiteI),
                };
            });

            console.log(insumosExL);
            // recorro el objeto de los insumos totales de la db
            for (const iL in insumosExL) {
                // si existe la posición del objeto (el id del insumo) se suma la cantidad del insumo
                if (insumosLim[iL]) {
                    insumosLim[iL].cantidadT = parseInt(insumosLim[iL].cantidadT) + parseInt(insumosExL[iL].cantidadT);

                    // si no existe se agrega los datos del insumo
                } else {
                    insumosLim[iL] = {
                        id: parseInt(iL),
                        cantidadT: insumosExL[iL].cantidadT,
                        limite: insumosExL[iL].limite,
                    };
                }
            }

            let objIL = {};
            // recorro el objeto de los insumos y solo almaceno los limitados
            for (const iLi in insumosLim) {
                if (insumosLim[iLi].cantidadT >= insumosLim[iLi].limite) {
                    objIL[iLi] = insumosLim[iLi];
                }
            }

            return objIL;
        } catch (error) {
            console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    };
});
