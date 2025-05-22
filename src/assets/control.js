addEventListener("DOMContentLoaded", function () {
    console.log("Control JS");

    const ulPacientes = document.getElementById("ul-pacientes"); //lista de pacientes
    const fragmento = document.createDocumentFragment(); //fragmento
    const inputBuscador = document.getElementById("input-buscador");
    const btnControl = document.getElementById("btnControl"); //boton de agregar
    const cedulaControl = document.getElementById("cedulaControl"); //input cedula
    const fragmento2 = document.createDocumentFragment(); //fragmento 2
    const modalAgregarControl = document.getElementById("modalAgregarControl"); //modal control
    const comentarioControl = document.querySelector(".comentarioControl"); //comentario
    //Expresiones regulres
    const inputsExpresiones = document.querySelectorAll("#modalAgregarControl .inputExpresiones");

    const id_usuario_bitacora = document.getElementById("id_usuario_bitacora").value; // constante que guarda el id que inicio session de esa manera podemos realizar la bitacora;

    //objeto de las expresiones:
    const expresiones = {
        cedula: /^([1-9]{1})([0-9]{5,7})$/,
        diagnostico: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
        indicaciones: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
        fechaRegreso: /^\d{4}\-\d{2}\-\d{2}$/,
    };

    const campos = {
        cedula: false,
        sintomas: false,
        doctor: false,
        diagnostico: false,
        indicaciones: false,
        fechaRegreso: false,
    };
    let idDU = document.querySelector("#idDExisteU");
    console.log(idDU)
    if (idDU) {
        campos.doctor = true;
    }

    const camposEditar = {
        diagnostico: true,
        indicaciones: true,
        fechaRegreso: true,
    };

    //validar forumlario
    function validarFormularioControl(e) {
        switch (e.target.name) {
            case "cedula":
                if (expresiones.cedula.test(cedulaControl.value)) {
                    cedulaControl.style.borderBottom = "2px solid rgb(13, 240, 13)";
                    campos["cedula"] = true;
                } else {
                    cedulaControl.style.borderBottom = "2px solid rgb(224, 3, 3)";
                    campos["cedula"] = false;
                }
                break;

            case "sintomas[]":
                // recolecto los inputs
                let inputCheS = document.querySelectorAll(`.inpSin`);

                // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
                let seleccionadoS = Array.from(inputCheS).some((checkbox) => checkbox.checked);
                if (seleccionadoS) {
                    campos["sintomas"] = true;
                } else {
                    campos["sintomas"] = false;
                }
                break;
            case "doctor":
                if (e.target.checked) {
                    campos["doctor"] = true;
                } else {
                    campos["doctor"] = false;
                }

                break;
            case "diagnostico":
                validarCamposControl(expresiones.diagnostico, e.target, "diagnostico");

                break;

            case "indicaciones":
                validarCamposControl(expresiones.indicaciones, e.target, "indicaciones");

                break;
            case "fechaRegreso":
                // obtengo la hora de hoy.
                let hoy = new Date();
                // para que la hora minutos s mm este en cero, como no lo voy a usar
                hoy.setHours(0, 0, 0, 0);
                // tomo la fecha del input
                let fechaInput = document.querySelector(`.grp_control_fechaRegreso`).value;
                fechaInput = new Date(fechaInput);

                // obtengo la hora de hoy.
                let fechaMaxima = new Date();
                // actualizamos la fecha de hoy, sumándole la fecha(en este caso el año) de hoy más 50
                fechaMaxima.setFullYear(hoy.getFullYear() + 50);
                // para que la hora minutos s mm este en cero, como no lo voy a usar
                fechaMaxima.setHours(0, 0, 0, 0);

                if (
                    expresiones.fechaRegreso.test(document.querySelector(`.grp_control_fechaRegreso`).value) &&
                    fechaInput >= hoy &&
                    fechaInput <= fechaMaxima
                ) {
                    document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(13, 240, 13)";
                    document.querySelector("#leyendaFec").classList.add("d-none");

                    campos["fechaRegreso"] = true;
                } else {
                    document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(224, 3, 3)";
                    document.querySelector("#leyendaFec").classList.remove("d-none");

                    campos["fechaRegreso"] = false;
                }
                break;
        }
    }

    const validarCamposControl = (expresiones, input, campo) => {
        if (expresiones.test(input.value)) {
            input.parentElement.classList.remove("grpFormInCorrectControl");
            input.parentElement.classList.add("grpFormCorrectControl");

            campos[campo] = true;
        } else {
            input.parentElement.classList.remove("grpFormCorrectControl");
            input.parentElement.classList.add("grpFormInCorrectControl");
            campos[campo] = false;
        }
    };

    inputsExpresiones.forEach((input) => {
        input.addEventListener("input", validarFormularioControl);
    });

    const traerPacientes = async (url) => {
        //funcion para traer le paciente
        try {
            ulPacientes.innerHTML = ``;
            let peticion = await fetch(url);
            let respuesta = await peticion.json();
            let ul = document.createElement("ul");
            ul.classList.add("uk-tab-left", "d-flex", "flex-column-reverse", "mt-3");
            ul.setAttribute("uk-tab", "connect: #component-tab-left; animation: uk-animation-fade");
            for (res of respuesta) {
                ul.innerHTML += `<li class="border-top text-center li-pacientes">
                                        <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                        <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>${res.nombre} ${res.apellido} V-${res.cedula}</a>
                                    </li>`;
                fragmento.appendChild(ul);
            }

            ulPacientes.appendChild(fragmento);

            document.querySelectorAll(".li-pacientes").forEach((liPaciente) => {
                liPaciente.addEventListener("click", async function (e) {
                    let cedula = e.target.innerText.split(" ")[2].substring(2);

                    await traerControl(cedula);
                });
            });
        } catch (error) {
            console.log(error);
        }
    };

    let semaforo = 0;

    //funcion ajax para traer el control
    const traerControl = async (idPaciente) => {
        try {
            // verifico si esta ejecutándose
            if (semaforo === 1) return;
            // comienza a cargar
            semaforo = 1;

            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarControlPacientesJS/" + idPaciente);
            let resultado = await peticion.json();
            console.log(resultado);

            let div = document.getElementById("div");
            div.innerHTML = ``;
            console.log(resultado);
            if (resultado[0].length > 0) {
                for (const res of resultado[0]) {
                    div.innerHTML += `
                                    <div class="m-3 divNS">
                                        <div class="d-flex ">
                                            <b>Síntomas:</b> <p class="m-0 p-0 ms-1 p${res.id_control}" data-id-paciente="${idPaciente}"></p> 
                                        </div>
                                        <div class="d-flex ">
                                            <b>Patología:</b> <p class="m-0 p-0 ms-1 pP${res.id_control}" data-id-paciente="${idPaciente}"></p>  
                                        </div>
                                        <b class="me-1">Diagnostico:</b>${res.diagnostico}<br>
                                        <b class="me-1">Indicaciones:</b>${res.medicamentosRecetados}<br>
                                        <b class="me-1">Fecha de Regreso:</b>${res.fechaRegreso}<br>
                                        <div class=" d-flex align-items-end justify-content-end posicion-botones">
                                            <button class="btn col-3 btn-agregarcita-modal editar btnEditar" type="button"
                                                uk-toggle="target: #modal-examplecontroleditar${res.id_control}" data-id-control="${res.id_control}" data-id-paciente="${res.id_paciente}">Modificar</button>
                                        </div>
                                    </div>
                                    
                                    
                                    <!-- modal editar -->
                                    <div id="modal-examplecontroleditar${res.id_control}" class="divModalE" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                            <!-- Boton que cierra el modal -->
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                    class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            </a>
                                    
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                                                        class="bi bi-person-lines-fill azul me-3 mb-3" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="uk-modal-title fs-5">
                                                        Editar Control
                                                    </p>
                                                </div>
                                    
                                            </div>
                                    
                                            <form class="form-modal modalesEditar">

                                                <input type="hidden" name="id_usuario_bitacora" value="${id_usuario_bitacora}">
                                    
                                                <input type="hidden" name="id_control" value="${res.id_control}">
                                    
                                                <input type="hidden" name="cedula" value="${res.cedula}">

                                                <input type="hidden" name="id_paciente" id="idPac" value="${res.id_paciente}">
                                    
                                                <!-- accordion -->
                                                <div class="input-modal">
                                                    <ul uk-accordion="multiple: true">
                                                        <li class="uk-open">
                                                            <a class="uk-accordion-title text-decoration-none" href="#">
        
                                                                <h6 class="acordion-paciente"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                        height="20" fill="currentColor" class="bi bi-person-fill azul me-2 mb-2"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                                    </svg>Síntomas</h6>
                                                            </a>


                                                            <div class="uk-accordion-content divSE${res.id_control}"></div>
                                                            
                                                        
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="input-modal mt-3">
                                                    <ul uk-accordion="multiple: true">
                                                        <li class="uk-open">
                                                            <a class="uk-accordion-title text-decoration-none" href="#">
                                
                                                                <h6 class="acordion-paciente fw-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                                        class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                                                    </svg>
                                                                    Añadir Patología
                                                                </h6>
                                                            </a>
                                

                                                            <div class="uk-accordion-content ">

                                                                <div class="d-flex justify-content-between flex-wrap divPE${res.id_control}"></div>

                                                            </div>

                                                            
                                                        </li>
                                                    </ul>
                                                    
                            
                                                </div>
                                                <!-- nota -->
                                                <div class="form-floating input-modal mt-2">
                                                    <textarea rows="5" class="form-control border-0 input-modal input-modal-remove"
                                                        placeholder="Leave a comment here" id="floatingTextarea2" style="height: 50px;"
                                                        name="nota_e">${res.nota}</textarea>
                                                    <label for="floatingTextarea2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                            fill="currentColor" class="bi bi-heart-pulse-fill azul me-2"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                                            <path
                                                                d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                                        </svg>Nota</label>
                                                </div>
                                                

                                                <div class="form-floating input-modal caja-editar-input grpFormCorrectControlEditar">
                                                    <textarea class="form-control border-0 input-modal grp_control_editar_indicaciones"
                                                        placeholder="Leave a comment here" id="floatingTextarea2" style="height: 50px;"
                                                        name="indicaciones">${res.medicamentosRecetados}</textarea>
                                                    <label for="floatingTextarea2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                            class="bi bi-receipt-cutoff azul me-1" viewBox="0 0 16 16">
                                                            <path
                                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                                            <path
                                                                d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                                                        </svg>
                                                        </svg>Prescripciones e indicaciones</label>
                                                </div>
        
                                                <div class="mt-4">
                                                    <p class=" p-0 m-0 fw-bolder text-center">Fecha de regreso</p>
                                        
                                                    <div class="input-group flex-nowrap caja-editar-input ">
                                                        <span class="input-modal mt-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                                class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                                                <path
                                                                    d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                                                            </svg>
                                                        </span>
                                                        <input class="form-control input-modal grp_control_editar_fechaRegreso grpFormCorrectControlEditar"
                                                            type="date" name="fechaRegreso" placeholder="Fecha" value="${res.fechaRegreso}"
                                                            uk-tooltip="title: Fecha de regreso; pos: right">
                                                </div>
                                                
        
                                                <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none leyendaFecE" id="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                                        </path>
                                                        <path
                                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                                        </path>
                                                    </svg>
                                                    <i>El formato de la fecha es incorrecto. Debe ser mayor que la fecha actual y no debe exceder los 50 años futuros.
                                                    </i>
                                                </div>

                                                <div class="mt-4 pt-2">
                                                    <h4 class="text-center fw-bold">Historia clínica</h4>

                                                    <div class="uk-margin">
                                                        <textarea name="historialE" class="uk-textarea" rows="5" placeholder="Historial médico"
                                                            aria-label="Textarea" id="historia_clinicaA" required>${res.historiaclinica}</textarea>
                                                    </div>
                                                </div>
                                                

                                                <div class="mt-3 uk-text-right">
                                                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                                        type="button">Cancelar</button>
                                                    <button class="btn col-3 btn-agregarcita-modal" type="submit">Editar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>`;
                }

                for (const res of resultado[0]) {
                    // le quito el contenido
                    document.querySelector(`.divPE${res.id_control}`).innerHTML = "";
                    document.querySelector(`.divSE${res.id_control}`).innerHTML = "";
                }
            } else {
                div.innerHTML = `<div class="m-3" >
                                        <b>El Paciente No Tiene Control Medico Registrado:</b><br>Por favor Añadirlo con el boton.. <br>
                                        <b>Registrar Control médico</b>
        
                                    </div>`;
            }

            let htmlPatologia = ``;
            resultado[4].forEach((resPT) => {
                htmlPatologia += `<div class="form-check form-switch d-flex align-items-center ms-4 mb-1">
                                    <div>
                                        <input class="form-check-input inputExpresiones inputPatologia" type="checkbox"
                                            role="switch" id="flexSwitchCheckDefault" name="patologias[]"
                                            value="${resPT["id_patologia"]}" disabled>
                                    </div>
                                    <div>
                                        <label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                            ${resPT["nombre_patologia"]}
                                        </label>
                                    </div>

                                </div>`;
            });

            for (const res of resultado[0]) {
                let patologiasP = await patologiaCC(res.id_control);

                if (patologiasP != undefined) {
                    if (patologiasP.length > 0) {
                        for (const resPtlg of patologiasP) {
                            // esta parte es para agregar los nombres de las patologías
                            let pP = document.querySelector(`.divNS .pP${res.id_control}`);
                            pP.innerText += `, ${resPtlg.nombre_patologia}`;
                            // recolectamos el texto
                            let textoP = pP.innerText;

                            // startsWith es para ver si empieza con coma si es así devuelve true
                            if (textoP.startsWith(",")) {
                                // slice elimina la primera posición del texto
                                textoP = textoP.slice(1);
                                pP.innerText = textoP;
                            }

                            document.querySelector(
                                `.divPE${res.id_control}`
                            ).innerHTML += `<div class="form-check form-switch d-flex align-items-center ms-4 mb-1">
                                    <div>
                                        <input class="form-check-input inputExpresiones inputPatologia" type="checkbox"
                                            role="switch" id="flexSwitchCheckDefault" name="patologias[]"
                                            value="${resPtlg["id_patologia"]}" disabled>
                                    </div>
                                    <div>
                                        <label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                            ${resPtlg["nombre_patologia"]}
                                        </label>
                                    </div>

                                </div>`;
                        }
                    } else {
                        // esta parte es para agregar los nombres de las patologías
                        let pP = document.querySelector(`.divNS .pP${res.id_control}`);
                        pP.innerText = ` No tiene`;
                    }
                }

                resultado[1].forEach((resS) => {
                    // se le coloca al que tenga el mismo id
                    if (res.id_control == resS.id_control) {
                        // esta parte es para agregar los nombres de los síntomas
                        let p = document.querySelector(`.divNS .p${res.id_control}`);
                        p.innerText += `, ${resS.nombreS}`;
                        // recolectamos el texto
                        let texto = p.innerText;

                        // startsWith es para ver si empieza con coma si es así devuelve true
                        if (texto.startsWith(",")) {
                            // slice elimina la primera posición del texto
                            texto = texto.slice(1);
                            p.innerText = texto;
                        }

                        document.querySelector(
                            `.divSE${res.id_control}`
                        ).innerHTML += `<div class="form-check form-switch d-flex align-items-center ms-4 mb-1">
                        <div>
                            <input class="form-check-input inputExpresiones inputSintomas" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault" name ="sintomas[]"
                                value="${resS["id_sintomas"]}" disabled>
                        </div>
                        <div>
                            <label class="form-check-label mt-1 for=" flexSwitchCheckDefault">
                                ${resS["nombreS"]}
                            </label>
                        </div>
    
                    </div>`;
                    }
                });
            }

            // enviar formulario de editar
            document.querySelectorAll(".modalesEditar").forEach((ele) => {
                ele.addEventListener("submit", async function (f) {
                    f.preventDefault();
                    if (camposEditar.diagnostico && camposEditar.indicaciones && camposEditar.fechaRegreso) {
                        await EnviarFormularioEditar(ele);
                        let id;
                        id = ele.parentElement.parentElement.getAttribute("id");

                        UIkit.modal(`#${id}`).hide();

                        document.querySelectorAll(".divModalE").forEach((div) => {
                            div.classList.remove("uk-open");
                            // Quitar todos los estilos inline
                            div.style.cssText = "";
                        });
                    } else {
                        alert("revise el formulario");
                    }
                });
            });

            //tomar el valor al hacerle click al boton de editar
            document.querySelectorAll(".editar").forEach((ele) => {
                ele.addEventListener("click", function () {
                    let idModalEditar = this.getAttribute("uk-toggle").split(" ")[1].substring(1);
                    console.log(idModalEditar);
                    let inputsEditarControl = document.querySelectorAll(
                        `#${idModalEditar} .uk-modal-dialog .modalesEditar .caja-editar-input .input-modal`
                    );
                    console.log(inputsEditarControl);
                    inputsKeyupEditar(inputsEditarControl);
                });
            });

            // termino de cargar
            semaforo = 0;
        } catch (error) {}
    };

    //función para keyup de los inputs de editar
    function inputsKeyupEditar(arrayControl) {
        arrayControl.forEach((ele) => {
            ele.addEventListener("input", function (e) {
                if (e.target.name == "indicaciones") {
                    if (expresiones.indicaciones.test(e.target.value)) {
                        e.target.parentElement.classList.remove("grpFormInCorrectControlEditar");
                        e.target.parentElement.classList.add("grpFormCorrectControlEditar");
                        camposEditar["indicaciones"] = true;
                    } else {
                        e.target.parentElement.classList.remove("grpFormCorrectControlEditar");
                        e.target.parentElement.classList.add("grpFormInCorrectControlEditar");
                        camposEditar["indicaciones"] = false;
                    }
                } else if (e.target.name == "fechaRegreso") {
                    // obtengo la hora de hoy.
                    let hoy = new Date();
                    // para que la hora minutos s mm este en cero, como no lo voy a usar
                    hoy.setHours(0, 0, 0, 0);
                    // tomo la fecha del input
                    let fechaInput = e.target.value;
                    fechaInput = new Date(fechaInput);

                    // obtengo la hora de hoy.
                    let fechaMaxima = new Date();
                    // actualizamos la fecha de hoy, sumándole la fecha(en este caso el año) de hoy más 50
                    fechaMaxima.setFullYear(hoy.getFullYear() + 50);
                    // para que la hora minutos s mm este en cero, como no lo voy a usar
                    fechaMaxima.setHours(0, 0, 0, 0);

                    if (expresiones.fechaRegreso.test(e.target.value) && fechaInput >= hoy && fechaInput <= fechaMaxima) {
                        let input = e.target;
                        input.classList.remove("grpFormInCorrectControlEditar");
                        input.classList.add("grpFormCorrectControlEditar");

                        // selecciono el padre del input
                        let div = input.parentElement;
                        // selecciono el hermano del div (en donde esta el texto de alerta)
                        let divD = div.nextElementSibling;

                        divD.classList.add("d-none");
                        camposEditar["fechaRegreso"] = true;
                    } else {
                        let input = e.target;
                        input.classList.remove("grpFormCorrectControlEditar");
                        input.classList.add("grpFormInCorrectControlEditar");
                        // selecciono el padre del input
                        let div = input.parentElement;
                        // selecciono el hermano del div (en donde esta el texto de alerta)
                        let divD = div.nextElementSibling;

                        divD.classList.remove("d-none");
                        camposEditar["fechaRegreso"] = false;
                    }
                }
            });
        });
    }

    // evento que oculta y limpia el input del buscador de pacientes cuando se agrega un control
    btnControl.addEventListener("click", () => {
        document.getElementById("mostrarPaciente").classList.add("d-none");
        document.getElementById("btnAC").classList.add("d-none");
        document.getElementById("contenedorF").classList.add("d-none");
        document.getElementById("mandarRegistrarPaciente").classList.add("d-none");

        cedulaControl.value = "";
    });

    //mostrar paciente cedula
    const mostrarPaciente = async (cedula) => {
        // deseleccionar todos los checked de patología
        document.querySelectorAll(`.inputPP`).forEach((input) => {
            input.checked = false;
        });

        // obtengo la hora de hoy.
        let fHoy = new Date();
        // para que la hora minutos s mm este en cero, como no lo voy a usar
        fHoy.setHours(0, 0, 0, 0);
        // transformo la fecha y hora en formato iso(YYYY-MM-DD T HH:MM:SSZ) y divido la fecha de la hora, tomando solo la fecha, que es la posición [0].
        let fechaHoy = fHoy.toISOString().split("T")[0];
        let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPacienteJS/" + cedula + "/" + fechaHoy);
        let resultado = await peticion.json();

        // resultado de la peticion
        console.log(resultado);
        if (resultado.length > 0) {
            resultado.forEach((res) => {
                // calcula la edad
                const fechaNac = new Date(res.fn);
                const edadDif = Date.now() - fechaNac.getTime();
                const edadFecha = new Date(edadDif);
                document.getElementById("edad").innerText = `Edad: ${Math.abs(edadFecha.getUTCFullYear() - 1970)}`;

                document.getElementById("datosPaciente").innerText = `Paciente: ${res.nombre} ${res.apellido}`;
                document.getElementById("idPaciente").value = res.id_paciente;
            });
            console.log(resultado[0].id_paciente);
            // mostrarPIdP es la función...
            let verificar = await patologiaC(resultado[0].id_paciente, "inputPP", "mostrarPIdP");
            // si
            if (verificar != undefined) {
                let inputChe = document.querySelectorAll(`.inputPP`);
            }

            document.getElementById("mostrarPaciente").classList.remove("d-none");
            document.getElementById("btnAC").classList.remove("d-none");
            document.getElementById("contenedorF").classList.remove("d-none");
            document.getElementById("mandarRegistrarPaciente").classList.add("d-none");
        } else {
            document.getElementById("mostrarPaciente").classList.add("d-none");
            document.getElementById("btnAC").classList.add("d-none");
            document.getElementById("contenedorF").classList.add("d-none");
            document.getElementById("mandarRegistrarPaciente").classList.remove("d-none");
            document.getElementById("No_paciente").innerText = `NO SE ENCONTRÓ AL PACIENTE, PRESIONE CLIC AQUÍ PARA REGISTRAR`;
        }
    };
    //enviar formulario
    const EnviarFormulario = async () => {
        try {
            // tomo la fecha de hoy
            let fechaH = new Date();
            // se le coloca el formato a la fecha
            let fechaHo = fechaH.toISOString().slice(0, 19);

            document.querySelector("#fechaHora").value = fechaHo;
            console.log(document.querySelector("#fechaHora").value);

            const datos = new FormData(modalAgregarControl);
            const contenido = { method: "POST", body: datos };
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Control/insertarControl", contenido);
            let resultado = await peticion.json();
            comentariosControl(`Control De CI ${resultado.cedula} Insertado Correctamente`, "primary");
            traerControl(resultado.cedula);

            await traerPacientes("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPacientesJS");
        } catch (error) {
            console.log(error);
        }
    };

    //enviar formulario editar
    const EnviarFormularioEditar = async (formulario) => {
        try {
            const datos = new FormData(formulario);
            const contenido = { method: "POST", body: datos };
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Control/editarControl", contenido);
            let resultado = await peticion.json();
            comentariosControl(`Control De CI ${resultado.cedula} Modificado Correctamente`, "warning");
            await traerControl(resultado.cedula);
        } catch (error) {
            console.log(error);
        }
    };

    //Expresiones regulares

    inputBuscador.addEventListener("keyup", function () {
        if (inputBuscador.value != "") {
            traerPacientes("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarBusquedaPacientesJS/" + inputBuscador.value);
        } else traerPacientes("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPacientesJS");
    });

    traerPacientes("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPacientesJS");

    cedulaControl.addEventListener("keyup", function () {
        mostrarPaciente(cedulaControl.value);
    });

    modalAgregarControl.addEventListener("submit", function (f) {
        f.preventDefault();
        console.log(campos)

        if (
            campos.cedula &&
            campos.sintomas &&
            campos.doctor &&
            campos.diagnostico &&
            campos.indicaciones &&
            campos.fechaRegreso
        ) {
            UIkit.modal("#modal-examplecontrol").hide();
            EnviarFormulario();
            modalAgregarControl.reset();
            document.querySelectorAll(`#modalAgregarControl .input-modal-remove`).forEach((ele) => {
                if (ele.parentElement.classList.contains("grpFormCorrectControl")) {
                    ele.parentElement.classList.remove("grpFormCorrectControl");
                } else {
                    ele.setAttribute("style", "");
                }
            });
        } else {
            alert("Por favor verifique el formulario antes de enviarlo");
        }
    });
    //funcion para mostrar el comentario
    function comentariosControl(texto, clase) {
        comentarioControl.innerText = texto;
        comentarioControl.classList.add(`uk-alert-${clase}`);
        comentarioControl.style.display = "block";
        setTimeout(function () {
            comentarioControl.style.display = "none";
        }, 8000);
    }

    document.addEventListener("click", async function (e) {
        // contains sirve para verificar si la clase existe ...
        if (e.target && e.target.classList.contains("btnEditar")) {
            let btnE = e.target;
            // sintomas
            let idCon = btnE.getAttribute("data-id-control");
            let arrSin = await sintomasC(idCon);
            document.querySelector("#id_control").value = arrSin;

            // patologías
            // let idPac = btnE.getAttribute("data-id-paciente");
            let arrPi = await patologiaC(idCon, "inputPatologia", "mostrarPP");
            // si existe una patología
            if (arrPi != undefined) {
                document.querySelector("#idPac").value = arrPi[0];
                // si no existe una patología
            } else {
                document.querySelector("#idPac").value = "";
            }
        }
    });
    document.querySelector(".btnNin").addEventListener("click", () => {
        // deseleccionar todos los checked de patología
        document.querySelectorAll(`.inputPP`).forEach((input) => {
            input.checked = false;
        });
    });
    /////////////////////////////////// patología ////////////////

    //  del control del paciente
    const patologiaCC = async (idC) => {
        try {
            let peticion = await fetch(`/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPP/` + idC);
            let resultado = await peticion.json();

            // if (resultado.length > 0) {
            // }
            return resultado;
        } catch (error) {
            console.log(error + " . . . algo a sucedido");
        }
    };

    //  del control del paciente
    const patologiaC = async (idCP, inputPatologia, funcion) => {
        try {
            let peticion = await fetch(`/Sistema-del--CEM--JEHOVA-RAFA/Control/${funcion}/` + idCP);
            let resultado = await peticion.json();

            if (resultado.length > 0) {
                // id de patologías del paciente
                let idA = [];
                resultado.forEach((res) => {
                    idA.push(res.id_patologia);
                });

                //
                document.querySelectorAll(`.${inputPatologia}`).forEach((input) => {
                    let id = parseInt(input.value);
                    // si el id del input es igual al registro de las patologias del paciente...
                    if (idA.includes(id)) {
                        input.checked = true;
                        // si el id del input no es igual al registro de las patologias del paciente...
                    } else {
                        input.checked = false;
                    }
                });
                let arrayIdV = [idCP, idA];
                return arrayIdV;
            }
        } catch (error) {
            console.log(error + " . . . algo a sucedido");
        }
    };

    /////////////////////////////////// sintomas ////////////////

    // sintomas del control del paciente
    const sintomasC = async (idControl) => {
        try {
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarSP/" + idControl);
            let resultado = await peticion.json();

            // resultado de la otra peticion
            if (resultado.length > 0) {
                // id de sintomas del control
                let idA = [];
                resultado.forEach((res) => {
                    idA.push(res.id_sintomas);
                });

                //
                document.querySelectorAll(".inputSintomas").forEach((input) => {
                    let id = parseInt(input.value);
                    // si el id del input es igual al registro de los sintomas del control...
                    if (idA.includes(id)) {
                        input.checked = true;
                        // si el id del input no es igual al registro de los sintomas del control...
                    } else {
                        input.checked = false;
                    }
                });
                return idControl;
            }
        } catch (error) {
            console.log(error + " . . . algo a sucedido");
        }
    };

    // para el buscador de Sintomas
    let inputBuscS = document.querySelector("#inputBuscarS");
    const notifi = document.querySelector(".notifi");

    // buscador de sintomas
    function buscarS() {
        let contadorS = 0;
        let contadorSNo = 0;

        // selecciono todos los tr de la tabla
        const filas = document.querySelectorAll(".tbodyS tr");
        // recolecto el nombre del input
        let nombreInS = inputBuscS.value;
        // se convierte en minúscula
        nombreInS = nombreInS.toLowerCase();

        // recorro las filas de la tabla
        filas.forEach((fila) => {
            // cuenta los síntomas que existen.
            contadorS = contadorS + 1;

            let nombre = fila.children[1].innerText;

            // se convierte en minúscula
            nombre = nombre.toLowerCase();
            // verifico si el nombre existe
            if (nombre.includes(nombreInS)) {
                fila.classList.remove("d-none");
                notifi.classList.add("d-none");
            } else {
                fila.classList.add("d-none");
                // cuenta las veces que no encuentra un síntoma
                contadorSNo = contadorSNo + 1;
            }
        });

        // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes
        if (contadorS === contadorSNo) {
            // muestra el texto.
            notifi.classList.remove("d-none");
        }
    }

    inputBuscS.addEventListener("keyup", () => {
        buscarS();
    });
}); //Aqui Termina DOMContentLoaded
