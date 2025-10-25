addEventListener("DOMContentLoaded", function () {
    //............... animación de los dos modales ...................

    const btnInformacionPaciente = document.querySelector("#inforPaciente");
    const divModal = document.querySelector("#divModal");
    const closeModal = document.querySelector("#closeModal");

    //............... animación de los dos modales ...................

    // Agregamos clases al modal al presionar el botón de la información del
    // paciente.
    btnInformacionPaciente.addEventListener("click", () => {
        divModal.classList.add("uk-offcanvas-container", "uk-offcanvas-flip", "uk-offcanvas-container-animation");
        divModal.setAttribute("style", "touch-action: pan-y pinch-zoom; transition: all 0.3s ease-out ;");
    });

    // quitamos clases al modal al presionar en la x
    closeModal.addEventListener("click", () => {
        divModal.classList.remove("uk-offcanvas-flip", "uk-offcanvas-container-animation");
    });

    // quitamos clases al modal AL presionar en el body
    UIkit.util.on("#offcanvas-reveal", "hide", function () {
        if (divModal.classList.contains("uk-offcanvas-flip")) {
            divModal.classList.remove("uk-offcanvas-flip", "uk-offcanvas-container-animation");
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    // Ajax //////
    //function genérica para ejecutar la petición ajax
    const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";
    const executePetition = async (url, method, data = null) => {
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

    // aquí selecciono los elementos que utilizare en la búsqueda de los insumos para seleccionarlo
    let inputI = document.querySelector("#btbt");

    let parrafoNoI = document.getElementById("p-no-insumos");
    let insumos = document.getElementById("insumos");
    let insumoExiste = document.getElementById("insumoExiste");

    function traerIdI() {
        // id del insumos para poder agregarlo
        let idI = -1;

        document.querySelectorAll(".divInsumos").forEach((insumo) => {
            //es para traer el id
            if (insumo) {
                insumo.addEventListener("click", function () {
                    idI = parseInt(this.dataset["index"]);

                    traerUnInsumos(idI);
                });
            }
        });
    }

    // es para traer el id del insumo sin necesidad de una búsqueda
    let divInsumos = document.querySelectorAll(".divInsumos");
    if (divInsumos) {
        traerIdI();
    }

    // función async
    const traerInsumos = async () => {
        try {
            let valorI = inputI.value;

            // llamo la función buscar Insumos
            let peticionInsumos = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarInsumos/" + valorI);

            let resultadoInsu = await peticionInsumos.json();

            //si se trae algo
            if (resultadoInsu.length > 0) {
                parrafoNoI.innerText = "";

                insumoExiste.classList.toggle("d-none", false);
                insumos.classList.toggle("d-none", true);

                let html = ``;

                resultadoInsu.forEach((res) => {
                    html += `<div class="col-6 divInsumos" data-index=${res.id_insumo}>
                    <a href="#" class="text-center text-decoration-none m-0" data-bs-toggle="modal"
                        data-bs-target="#modal-agregar-hospitalizacion">
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

                insumoExiste.innerHTML = html;

                // para traer el id del insumo de la base de datos, ademas para que la recolecte la otra función async
                traerIdI();

                // si no se trae nada
            } else {
                parrafoNoI.innerText = "";
                parrafoNoI.innerText = "El insumo no esta registrado";

                insumoExiste.classList.toggle("d-none", true);
                insumos.classList.toggle("d-none", true);
            }
        } catch (error) {
            console.log("insumos lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    };

    //............... animación del input number de la cantidad de los insumos ..............

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

    // estos son los elementos que se utilizaran para agregar los insumos

    let btnAInsumoNoExiste = document.getElementById("btnAInsumoNoExiste");
    let btnAInsumoExiste = document.getElementById("btnAInsumoExiste");
    let divInsumosA = document.getElementById("div-insumosA");
    const noHayServicio = document.querySelector("#noHayServicio");
    let objServiciosBD = {};
    let nIA = 0;
    const serviciosA = document.querySelector("#div-serviciosA");
    const noPAservicio = document.querySelector("#NoPAservicio");

    // sumar el precio de insumos
    let totalPI = 0;

    const sumarTotal = () => {
        // contador del precio de cada insumo
        let PrecioI = 0;

        totalPI = 0;
        document.querySelectorAll(".precioInsum").forEach((pI) => {
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
            PrecioI = parseInt(pI.value);

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

    const traerSerevicio = async () => {
        let resultado = await executePetition(url + "/selectServiciosD", "GET");
        console.log(resultado);

        // si no se trae nada
        if (resultado.length < 1) {
            console.log("hay un problema, el servicio seleccionado no existe");
            noHayServicio.classList.remove("d-none");

            //si se trae algo
        } else {
            noHayServicio.classList.add("d-none");
            let html = ``;

            for (const datoS of resultado) {
                objServiciosBD[datoS["id_servicioMedico"]] = datoS;
                html += `<div class="col-12 col-sm-6 col-md-4 col-lg-4 divServicio"
                                data-index="${datoS["id_servicioMedico"]}">
                                <a href="#" class="card text-center text-decoration-none h-100"
                                    data-bs-toggle="modal" data-bs-target="#modal-agregar-hospitalizacion">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-plus-circle mb-2 fs-3"></i>
                                        <p class="fw-bolder mb-1">${datoS["categoria"]}</p>
                                        <p class="mb-0 small">${datoS["nombre"] + " " + datoS["apellido"]}</p>
                                    </div>
                                </a>
                            </div>`;
            }

            console.log(objServiciosBD);

            document.querySelector("#sevicios").innerHTML = html;
            let htmlL = ``;
            let divServicios = document.querySelectorAll(".divServicio");
            if (divServicios) {
                for (const div of divServicios) {
                    div.addEventListener("click", function () {
                        let idS = parseInt(this.getAttribute("data-index"));
                        console.log("idS");
                        console.log(idS);

                        htmlL = `<div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative servicioA" data-index="${idS}">
                                    <!-- Botón eliminar -->
                                    <button type="button"
                                        class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarServ"
                                        data-index="${idS}"
                                        style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
                                        ×
                                    </button>

                                    <!-- Tarjeta -->
                                    <a href="#"
                                        class="card text-decoration-none h-100 shadow-sm border-0 rounded-4"
                                        style="background: #f4f9ff61; transition: all 0.2s ease;">

                                        <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">
                                            <div class="fw-semibold text-dark mb-2 m-auto d-flex ">
                                                <p class="me-1 text-center cantidadServicio" style="font-size:1rem;">
                                                    1
                                                </p>
                                                <p class="" style="font-size:1rem;">
                                                    ${objServiciosBD[idS]["categoria"]}
                                                </p>
                                            </div>
                                            <p class="text-muted mb-1" style="font-size:0.9rem;">
                                                ${objServiciosBD[idS]["nombre"]} ${objServiciosBD[idS]["apellido"]}
                                            </p>
                                            <p class="fw-bold text-primary mb-0 precioS" style="font-size:0.95rem;">
                                                ${objServiciosBD[idS]["precio"]} Bs
                                            </p>
                                            <div>
                                                <input type="hidden" name="id_servicio[]" class="" value="${idS}">
                                                <input type="hidden" name="cantidadS[]" class="cantidadServicioInput" value="1">
                                            </div>                         
                                        </div>
                                    </a>
                                </div>`;

                        if (objServiciosBD[idS]["tipo"] == "Examenes") {
                            // buscar si el servicio ya está agregado en el contenedor
                            const servicioExistente = serviciosA.querySelector(`.servicioA[data-index="${idS}"]`);

                            if (servicioExistente) {
                                // aumentar la cantidad Serv
                                const pCantidad = servicioExistente.querySelector(".cantidadServicio");
                                const inputCantidad = servicioExistente.querySelector(".cantidadServicioInput");
                                if (pCantidad) {
                                    let newCantidad = parseInt(pCantidad.textContent.trim()) || 1;
                                    newCantidad = newCantidad + 1;
                                    pCantidad.textContent = newCantidad;
                                    inputCantidad = newCantidad;
                                    // Actualizar el precio
                                    let precioS = newCantidad * objServiciosBD[idS]["precio"];
                                    let pMoneyS = servicioExistente.querySelector(".precioS");
                                    if (pMoneyS) {
                                        pMoneyS.textContent = precioS + " Bs";
                                    }
                                }
                            } else {
                                // si no existe, agrega el servicio tipo examen
                                serviciosA.innerHTML += htmlL;
                                document.querySelector("#btnAS").classList.add("d-none");
                                document.querySelector("#btnAServiciosExiste").classList.remove("d-none");
                            }
                        } else {
                            const servicioExistente = serviciosA.querySelector(`.servicioA[data-index="${idS}"]`);

                            if (servicioExistente) {
                                noPAservicio.classList.remove("d-none");
                                setTimeout(() => {
                                    noPAservicio.classList.add("d-none");
                                }, 8000);
                            } else {
                                serviciosA.innerHTML += htmlL;
                                document.querySelector("#btnAS").classList.add("d-none");
                                document.querySelector("#btnAServiciosExiste").classList.remove("d-none");
                            }
                        }
                    });
                }
            }
            if (serviciosA) {
                serviciosA.addEventListener("click", function (e) {
                    console.log(e);

                    const servicioElem = e.target.closest(".servicioA");
                    servicioElem.remove();
                });
            }
        }
    };

    // función async
    const traerUnInsumos = async (id) => {
        // try {

        // llamo la función buscar un Insumo
        let peticionUnInsumo = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarUnInsumo/" + id);

        let resultadoUnInsu = await peticionUnInsumo.json();

        // si no se trae nada
        if (resultadoUnInsu == false) {
            console.log("hay un problema, el insumo seleccionado no existe");

            btnAInsumoNoExiste.classList.toggle("d-none", false);
            btnAInsumoExiste.classList.toggle("d-none", true);

            //si se trae algo
        } else {
            btnAInsumoNoExiste.classList.toggle("d-none", true);
            btnAInsumoExiste.classList.toggle("d-none", false);

            let existeIn = true;

            let objIL = await limiteI(id);

            // esto recorre todos los input number de cantidad
            let div = document.querySelectorAll(".divInsumosAgregadosA");
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
                let idInputI = divI.querySelector(".inputIdInsu");
                // esto selecciona al p que muestra un mensaje
                let p = divI.previousElementSibling;

                // para la cantidad
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

                    if (objIL[id]) {
                        p.classList.remove("d-none");
                    } else {
                        p.classList.add("d-none");
                        // llamo a la función que hace el calculo (aumentar y disminuir) en este caso aumenta y luego hace el calculo matemático
                        // aquí selecciono el div que tiene un ( + ) y el input
                        botonInputNumber(divPadreIN[2], divPadreIN[1]);
                    }

                    sumarTotal();
                } else {
                    // el insumo no existe
                }
            }

            let html = ``;

            if (existeIn) {
                //nIA es el contador sirve para eliminar según el numero
                nIA++;

                html = `<p class="text-danger text-center m-0 p-0 d-none">
                                    Límite de cantidad alcanzado
                                </p>

                                <div class="col-12 divInsumosAgregadosA border-top border-bottom pt-2 pb-2 mb-3 position-relative" data-index=${nIA}>

                                    <!-- Fila superior con la X -->
                                    <div class="d-flex justify-content-end me-4">
                                        <a href="#" class="eliminarIns" data-index=${nIA}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" class="bi bi-x-circle color-icono"
                                                viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </a>
                                    </div>

                                    <!-- Nombre y precio en el centro -->
                                    <div class="text-center mb-3">
                                        <div class="borde-input-agregar d-inline-block px-3 pb-2">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <p class="color-letras fw-bold margen-dos-puntos mb-0">
                                                        ${resultadoUnInsu.nombre}
                                                    </p>
                                                </div>
                                                <div class="col-2">
                                                    <p class="fw-bold margen-dos-puntos mb-0">:</p>
                                                </div>
                                                <div class="col-4">
                                                    <p class="precio-medicina-agregar mb-0">
                                                        ${resultadoUnInsu.precio}bs
                                                    </p>
                                                    <input type="hidden" class="precioInsum" value="${resultadoUnInsu.precio}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input class="inputIdInsu" type="hidden" name="id_insumo[]"
                                        data-limite-cantidad="${resultadoUnInsu.limite_insumo}"
                                        value="${resultadoUnInsu.id_insumo}">

                                    <!-- Cantidad abajo centrada -->
                                    <div class="cantidadIns mt-3 text-center">
                                        <div class="posicion-input-number d-inline-block ms-5">
                                            <div class="contenedorNumber d-flex justify-content-center align-items-center">
                                                <div class="btn-max-min btn-min-lugar tamano-btn-min fw-bold disminuir masMenos" data-index="disminuir"> - </div>
                                                <input class="input-number fw-bold text-center mx-2" name="cantidad[]" type="number" min="1" max="100" step="1" value="1" readonly>
                                                <div class="btn-max-min btn-max-lugar fw-bold aumentar masMenos" data-index="aumentar"> + </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>`;

                divInsumosA.innerHTML += html;

                let div = document.querySelectorAll(".divInsumosAgregadosA");
                // esto recorre todos los input number de cantidad
                for (const divI of div) {
                    let inputN = divI.querySelector(".input-number");
                    let idI = parseInt(divI.querySelector(".inputIdInsu").value);
                    // esto selecciona al p que muestra un mensaje
                    let p = divI.previousElementSibling;

                    // esto selecciona al div que muestra un -
                    let menos = inputN.previousElementSibling;
                    // esto selecciona al div que muestra un +
                    let mas = inputN.nextElementSibling;

                    menos.addEventListener("click", async function () {
                        // llamo a la función que hace el calculo (aumentar y disminuir) en este caso disminuye y luego hace el calculo matemático
                        botonInputNumber(menos, inputN);
                        sumarTotal();

                        let objIL = await limiteI(idI);
                        // si no encuentro el id
                        if (!objIL[idI]) {
                            p.classList.add("d-none");
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
                        sumarTotal();
                    });
                }
            }

            document.querySelectorAll(".eliminarIns").forEach((elim) => {
                elim.addEventListener("click", function () {
                    // esto es para traerme el numero del data-index del <a> (btn)
                    idI = parseInt(this.dataset["index"]);

                    //es para eliminar con el numero del data-index del div, como es el mismo numero el de la <a> y del <div>
                    let EliminarI = document.querySelector(`.divInsumosAgregadosA[data-index="${idI}"]`);
                    let p = EliminarI.previousElementSibling;
                    EliminarI.remove();
                    p.remove();

                    //para que reste el insumo que se a eliminado del total
                    sumarTotal();
                });
            });

            // suma la cantidad al aumentarla o disminuirla
            document.querySelectorAll(".masMenos").forEach((masMen) => {
                masMen.addEventListener("click", function () {
                    sumarTotal();
                });
            });

            //para la suma total
            sumarTotal();
        }

        // } catch (error) {
        //     console.log("insumos lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        // }
    };

    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    // aquí se utiliza los siguientes elementos para traerse los datos de paciente y también buscarlo
    let formularioAgregar = document.getElementById("formularioAgregarH");
    let parrafoExP = document.getElementById("p-paciente");
    let parrafoNoP = document.getElementById("p-no-paciente");
    let contenedorForm = document.getElementById("contenedorFormAgregar");

    let nombreApellidoInfor = document.getElementById("nombreInfor");
    let diagnosticoInfor = document.getElementById("inforDiagnostico");

    let btnEnviar = document.getElementById("btnEnviar");
    let historiaclinica = document.getElementById("historia_clinicaA");

    const traerControlDePaciente = async () => {
        // try {
        const datosFormulario = new FormData(formularioAgregar);

        const contenidoForm = {
            method: "POST",
            body: datosFormulario,
        };

        // llamo la función validar paciente
        let peticionValidarP = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/validarPaciente", contenidoForm);
        let resultadoVP = await peticionValidarP.json();

        // llamo la función mostrar
        let peticionMostrar = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarInformacionPCD", contenidoForm);
        let resultadoM = await peticionMostrar.json();
        console.log(resultadoM);

        if (resultadoVP == false) {
            console.log("El paciente no esta registrado.");
            parrafoNoP.innerText = "";
            parrafoNoP.innerText = "El paciente no esta registrado.";
            document.getElementById("input-id-paciente").value = "";

            document.querySelector("#aPaciente").classList.remove("d-none");

            document.querySelector("#aPaciente").addEventListener("click", function () {
                document.querySelector("#cedula").value = document.querySelector("#bt").value;
            });

            parrafoNoP.classList.toggle("d-none", false);
            btnInformacionPaciente.classList.toggle("d-none", true);
            contenedorForm.classList.toggle("d-none", true);
            btnEnviar.classList.toggle("d-none", true);
        } else {
            document.querySelector("#aPaciente").classList.add("d-none");
            let nombreApellido = `${resultadoVP.nombre} ${resultadoVP.apellido}`;
            parrafoExP.innerText = "";
            parrafoExP.innerText = nombreApellido;
            nombreApellidoInfor.innerText = "";
            nombreApellidoInfor.innerText = nombreApellido;
            diagnosticoInfor.innerText = "";
            // recolecto el id del paciente
            document.getElementById("input-id-paciente").value = resultadoVP.id_paciente;
            parrafoNoP.classList.toggle("d-none", true);
            btnInformacionPaciente.classList.toggle("d-none", false);
            contenedorForm.classList.toggle("d-none", false);
            btnEnviar.classList.toggle("d-none", false);

            if (resultadoM == false) {
                console.log("no hay datos del paciente.");
                diagnosticoInfor.innerText = `Aun, no esta diagnosticado`;
                historiaclinica.value = "";
            } else {
                diagnosticoInfor.innerText = `${resultadoM.diagnostico}`;

                let historia = resultadoM.historiaclinica;
                // trim() quita los espacios en el principio y al final
                historiaclinica.value = historia.trim();
            }
        }
        // } catch (error) {
        // console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...  " + error);
        // }
    };

    // este evento es para buscar al paciente
    document.querySelector("#btn-buscar").addEventListener("click", function () {
        // if (document.getElementById('existeInput')) {
        //     // no se agrega
        // } else{
        let html = '<input type="hidden" name="verificarH" value="existe" id="existeInput">';
        document.getElementById("divAPacienteMP").innerHTML = html;
        // }
        // Selecciona el div (puedes usar un id o una clase única)
        const divCedula = document.querySelector(".divGrp_cedula");

        // Verifica si tiene la clase 'grpFormCorrect'
        if (divCedula.classList.contains("grpFormCorrect")) {
            // Si tiene la clase grpFormCorrect
            console.log("El div tiene la clase grpFormCorrect");
            // Aquí haces lo que necesites
        } else if (divCedula.classList.contains("grpFormIncorrect")) {
            // Si tiene la clase grpFormIncorrect
            console.log("El div tiene la clase grpFormIncorrect");
            // Aquí haces otra cosa
        }
        traerControlDePaciente();
    });

    // este evento es para buscar el insumo
    document.querySelector("#btn-buscarInsumo").addEventListener("click", function () {
        traerInsumos();
    });

    //inputI.addEventListener("keyup", function () {
    //    traerInsumos();
    //})

    //este es el comentario
    const comentario = document.querySelector(".comentario");
    //si existe el comentario lo muestra y después de 8sg lo oculta
    if (comentario) {
        comentario.style.display = "block";

        setTimeout(function () {
            comentario.style.display = "none";
        }, 8000);
    }

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
            document.querySelectorAll(".divInsumosAgregadosA").forEach((divI) => {
                // id del insumo
                let idI = divI.querySelector(".inputIdInsu");
                let limiteI = idI.getAttribute("data-limite-cantidad");
                let cantidad = parseInt(divI.querySelector(".input-number").value);
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

    function obtenerFechaHoraLocal() {
        const fecha = new Date();
        const año = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, "0");
        const dia = String(fecha.getDate()).padStart(2, "0");
        const horas = String(fecha.getHours()).padStart(2, "0");
        const minutos = String(fecha.getMinutes()).padStart(2, "0");
        const segundos = String(fecha.getSeconds()).padStart(2, "0");
        return `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
    }

    document.querySelector("#btnAgregarH").addEventListener("click", () => {
        traerSerevicio();
        // tomo la fecha de hoy
        let fechaHoy = obtenerFechaHoraLocal();

        document.querySelector("#fechaHoy").value = fechaHoy;
    });
    formularioAgregar.addEventListener("submit", function (e) {
        e.preventDefault();
    });
    // ...existing code...
    document.querySelector("#btnAgregarH").addEventListener("click", () => {
        traerSerevicio();
        // tomo la fecha de hoy
        let fechaHoy = obtenerFechaHoraLocal();

        document.querySelector("#fechaHoy").value = fechaHoy;
    });

});
