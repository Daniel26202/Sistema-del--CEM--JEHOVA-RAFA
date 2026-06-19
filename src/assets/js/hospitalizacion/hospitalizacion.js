import {
    executePetition,
    alertConfirm,
    alertError,
    alertSuccess,
    clearStyleVInputs,
    initDataTable,
    hasPermision,
} from "../generic/funtionGeneric.js";
import { traerSerevicio } from "./reutilizableHospitalizacion.js";
import { inicializarValidacionFormulario, chulitoYX } from "../generic/expresionesModulares.js";

const selector = ".exampleTable";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";
let dataH = [];

// envío de datos de la edición
const readHosp = async () => {
    let metodo = "";
    let urlActual = window.location.href;

    if (urlActual.includes("hospitalizacionesRealizadas")) {
        metodo = "traerHospR";
    } else if (urlActual.includes("hospitalizacion") && !urlActual.includes("hospitalizacionesRealizadas")) {
        metodo = "traerHospP";
    }

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
    }

    const columnsHosp = [
        {
            data: "cedula",
            render: (data, type, row) => `${row.nacionalidad}-${data}`,
        },
        { data: "nombre" },
        { data: "apellido" },
        { data: "diagnostico" },
        { data: "nombredoc", render: (data, type, row) => `${data} ${row.apellidodoc}` },
        {
            data: null,
            orderable: false,
            render: function (data, type, row) {
                return `
                        <div class="d-flex flex-wrap col-12 tdTBtn">
                            <div class="col-12 col-md-6 col-lg-3">
                                <button class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 me-1 informacionH"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvas-mostrarH"
                                    data-id-hospitalizacion="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="bi bi-card-text" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">

                                <!-- btn modal editar hospitalización -->
                                <button class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 editarH me-1" data-bs-toggle="modal"
                                    data-bs-target="#modal-editar-hospitalizacion"
                                    data-extra="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <button class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 me-1 btn-eliminar" data-index="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <a href="#" class="${urlActual.includes("hospitalizacionesRealizadas") ? "d-none" : ""} btn btn-tabla mb-1 me-1 text-white btnFH" data-bs-toggle="modal" data-bs-target="#modalEnvioFacturaHospitalizacion"  id="" title=""
                                    data-id-hospitalizacion="${row.id_hospitalizacion}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                    </svg>
                                </a>
                            </div>
                            <div>
                                <input type="hidden" name="" class="fechaInicio" value="${row.fecha_hora_inicio}">
                                <input class="precioHo" type="hidden" name="" value="${row.precio_horas}">
                                <input class="idC" type="hidden" name="" value="${row.id_control}">
                                <input class="idHpt" type="hidden" name="" value="${row.id_hospitalizacion}">
                                <input class="hME" type="hidden" name="" value="${row.historiaclinica}">
                                <input class="diagnosticoClass" type="hidden" name="" value="${row.diagnostico}">
                            </div>
                        </div>`;
            },
        },
    ];

    const columsHospRealizadas = [
        {
            data: "cedula",
            render: (data, type, row) => `${row.nacionalidad}-${data}`,
        },
        { data: "nombre" },
        { data: "apellido" },
        { data: "telefono" },
        { data: "diagnostico" },
        { data: "nombredoc", render: (data, type, row) => `${data} ${row.apellidodoc}` },
        { data: "total" },
    ];

    let resultad = await executePetition(url + "/traerIdURSesion/", "GET");
    console.log(resultad["id_rol"]);

    const asignarEventos = () => {
        console.log(dataH);
        
        //llamar las funcion de eliminar
        document.querySelectorAll(".btn-eliminar").forEach((btn) => {
            btn.addEventListener("click", function () {
                const data = [this.getAttribute("data-index")];
                alertConfirm("Esta seguro de eliminar la hospitalización?", deleteHosp, data);
            });
        });

        // let aFacH = document.querySelectorAll(".btnFH");
        // // aFacH
        // for (const factH of aFacH) {
        //     factH.addEventListener("click", async function () {
        //         // para traer el valor del data index
        //         let index = this.getAttribute("data-index");
        //         editar(parseInt(index));
        //         let idHospit = this.getAttribute("data-id-hospitalizacion");
        //         console.log(idHospit + " id hospitalizacion");

        //         let datos = await mostrarInf(parseInt(index), parseInt(idHospit));
        //         document.querySelector("#idH").value = idHospit;
        //         document.querySelector("#monto").value = datos[0];
        //         document.querySelector("#montoME").value = datos[1];
        //         document.querySelector("#total").value = datos[2];
        //         document.querySelector("#totalME").value = datos[3];
        //         clearStyleVInputs();
        //     });
        // }
        // const btnEditar = document.querySelectorAll(".editarH");
        // // recorremos los btn editar
        // for (const editH of btnEditar) {
        //     editH.addEventListener("click", async function () {
        //         document.querySelectorAll(".input-validar").forEach((input) => {
        //             let campoCustom = input.closest(".campo-custom");
        //             let check = input.nextElementSibling.children[0];
        //             let error = input.nextElementSibling.children[1];
        //             input.parentElement.classList.remove("invalido");
        //             input.parentElement.classList.add("valido");

        //             campoCustom.querySelector("p").classList.add("d-none");

        //             if (check && error) chulitoYX(check, error, "valido");
        //         });
        //         objServiciosBD = await traerSerevicio("editar");
        //         // id de la hospitalización
        //         let extra = editH.getAttribute("data-extra");
        //         await traerSerevicioH(parseInt(extra));
        //         // para traer el valor del data index
        //         let index = editH.getAttribute("data-index");
        //         editar(parseInt(index));

        //         // para traer el valor del data extra
        //         // es el id de la hospitalizacion
        //         mostrarIE(parseInt(extra));
        //         // este evento es para buscar el insumo
        //         document.querySelector("#btn-buscarInsumoE").addEventListener("click", function () {
        //             traerInsumosE();
        //         });
        //     });
        // }

        document.querySelectorAll(".informacionH").forEach((inforH) => {
            inforH.addEventListener("click", function () {
                const idHospit = this.getAttribute("data-id-hospitalizacion");
                const registro = dataH.find((d) => d.id_hospitalizacion == idHospit);

                if (!registro) return;

                document.getElementById("nombreApellidoM").innerHTML = `${registro.nombre} ${registro.apellido}`;
                document.getElementById("cedulaM").innerHTML = `${registro.nacionalidad}-${registro.cedula}`;
                document.getElementById("diagnosticoM").innerHTML = registro.diagnostico;
                document.getElementById("doctorM").innerHTML = `${registro.nombredoc} ${registro.apellidodoc}`;
                document.getElementById("historiaM").innerHTML = registro.historiaclinica;

                mostrarInf(idHospit, registro);
            });
        });

        //llamar las funcion de ed
        // document.querySelectorAll(".botonesEdi").forEach((btn) => {
        //     btn.addEventListener("click", function () {
        //         let paciente = searchObectPattiens(btn.getAttribute("data-index"));

        //         //objetos con todos los parametros de la funcion
        //         const parametros = {
        //             labelModal: exampleModalLabel,
        //             textLabelModal: "Modificar Paciente",
        //             form: modalAgregar,
        //             modal: modalAgregar.parentElement.parentElement.parentElement,
        //             btnModal: botonModal,
        //             btnTextModal: "Modificar",
        //             data: {
        //                 nacionalidad: paciente.nacionalidad,
        //                 cedula: paciente.cedula,
        //                 nombre: paciente.nombre,
        //                 apellido: paciente.apellido,
        //                 telefono: paciente.telefono,
        //                 direccion: paciente.direccion,
        //                 fn: paciente.fn,
        //                 genero: paciente.genero,
        //                 id: paciente.id_paciente,
        //             },
        //             inputs: inputs,
        //             cedulaOculta: cedulaRegistrada,
        //             idOculto: id_paciente,
        //         };
        //         showDataModal(parametros);
        //     });
        // });

        // //mostrar mas info
        // document.querySelectorAll(".botonesInfo").forEach((btn) => {
        //     btn.addEventListener("click", function () {
        //         let id = btn.getAttribute("data-index");
        //         modalInfo.show();
        //         infoPatients(id);
        //     });
        // });

        // //////gestionar persmisos
        hasPermision(resultad["id_rol"], "Hospitalizacion", "guardar", ".btn-agregar-pacientes"); //guardar
        hasPermision(resultad["id_rol"], "Hospitalizacion", "guardar", ".btnFH"); //guardar
        hasPermision(resultad["id_rol"], "Hospitalizacion", "eliminar", ".btn-eliminar"); //eliminar
        hasPermision(resultad["id_rol"], "Hospitalizacion", "consultar", ".informacionH"); //restablecer
        hasPermision(resultad["id_rol"], "Hospitalizacion", "editar", ".editarH"); //editar
        console.log(dataH);
        console.log(metodo);

    };

    initDataTable(
        selector,
        url + "/" + metodo,
        !urlActual.includes("hospitalizacionesRealizadas") ? columnsHosp : columsHospRealizadas,
        (datosServer) => {
            dataH = [];
            dataH.push(...datosServer);
        },
        asignarEventos,
    );

    // llamo la función
    // let resultad = await executePetition(url + "/" + metodo + "/", "GET");

    // console.log(resultad);

    // let html = "";
    // console.log("resultad completo:", resultad);
    // console.log("datos hospitalizaciones:", resultad[1]);
    // console.log("semaforo:", resultad[0][2]);
    // if (resultad.length == 0) {
    //     console.log("algo salio mal");
    // } else {
    //     await traerHoraCosto();
    //     if (!resultad[1] || resultad[1].length === 0) {
    //         html = `<tr>
    //                             <td colspan="8" class="text-center">NO HAY REGISTROS
    //                             </td>
    //                         </tr>`;
    //         document.querySelector("#tbody").innerHTML = html;
    //     } else {
    //         let html = ``;
    //         let htmlModales = ``;

    //         // console.log(resultad[1]);
    //         // recorro los datos de hospitalización
    //         console.log(resultad);

    //         resultad[1].forEach((res, index) => {
    //             horaInicioHosp = res.fecha_hora_inicio;

    //             // contenido de la tabla.
    //             html += `<tr>
    //                                 <td>
    //                                     ${res["cedula"]}
    //                                 </td>
    //                                 <td>
    //                                     ${res["nombre"]}
    //                                 </td>
    //                                 <td>
    //                                     ${res["apellido"]}
    //                                 </td>
    //                                 <td class="col-11 tdHS">

    //                                     ${res["diagnostico"]}

    //                                 </td>
    //                                 <td>
    //                                     ${res["nombredoc"]} ${res["apellidodoc"]}
    //                                 </td>`;

    //             // verifico si es administrador o doctor
    //             // uno es doctor
    //             if (resultad[0][1] == 1) {
    //                 html += `<!--no hay-->`;
    //             }

    //             html += `   <td>
    //                                     <div class="d-flex flex-wrap col-12 tdTBtn">
    //                                         <div class="col-12 col-md-6 col-lg-3">
    //                                             <button class="btn btn-tabla mb-1 me-1 informacionH"
    //                                                 data-bs-toggle="offcanvas"
    //                                                 data-bs-target="#offcanvas-mostrarH"
    //                                                 data-id-hospitalizacion="${res["id_hospitalizacion"]}"
    //                                                 data-index="${index}">
    //                                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
    //                                                     class="bi bi-card-text" viewBox="0 0 16 16">
    //                                                     <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
    //                                                     <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
    //                                                 </svg>
    //                                             </button>
    //                                         </div>
    //                                         <div class="col-12 col-md-6 col-lg-3">

    //                                             <!-- btn modal editar hospitalización -->
    //                                             <button class="btn btn-tabla mb-1 editarH me-1" data-bs-toggle="modal"
    //                                                 data-bs-target="#modal-editar-hospitalizacion" data-index="${index}"
    //                                                 data-extra="${res["id_hospitalizacion"]}">
    //                                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
    //                                                     class="bi bi-pencil-fill" viewBox="0 0 16 16">
    //                                                     <path
    //                                                         d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
    //                                                 </svg>
    //                                             </button>
    //                                         </div>`;

    //             // verifico si es administrador o usuario
    //             // uno es doctor
    //             if (resultad[0][1] == 1) {
    //                 html += `<!--no hay-->`;
    //             }
    //             // verifico si es administrador o usuario
    //             // cero es administrador mas no doctor
    //             if (resultad[0][1] == 0) {
    //                 html += `
    //                                         <div class="col-12 col-md-6 col-lg-3">
    //                                             <button class="btn btn-tabla mb-1 me-1 btn-eliminar" data-index="${res.id_hospitalizacion}">
    //                                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
    //                                                     class="bi bi-trash3-fill" viewBox="0 0 16 16">
    //                                                     <path
    //                                                         d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
    //                                                 </svg>
    //                                             </button>
    //                                         </div>`;
    //             }
    //             // verifico si es administrador o usuario
    //             // cero es administrador mas no doctor
    //             if (resultad[0][1] == 0) {
    //                 html += `
    //                                         <div class="col-12 col-md-6 col-lg-3">
    //                                             <a href="#" class="btn btn-tabla mb-1 me-1 text-white btnFH" data-bs-toggle="modal" data-bs-target="#modalEnvioFacturaHospitalizacion"  id="" title=""
    //                                                 data-id-hospitalizacion="${res["id_hospitalizacion"]}" data-index="${index}">
    //                                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
    //                                                 <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
    //                                                 <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
    //                                                 </svg>
    //                                             </a>
    //                                         </div>`;
    //             }

    //             htmlModales += `
    //                                     <div>
    //                                         <input type="hidden" name="" class="fechaInicio" value="${res["fecha_hora_inicio"]}">
    //                                         <input class="precioHo" type="hidden" name="" value="${res.precio_horas}">
    //                                         <input class="idC" type="hidden" name="" value="${res.id_control}">
    //                                         <input class="idHpt" type="hidden" name="" value="${res.id_hospitalizacion}">
    //                                         <input class="hME" type="hidden" name="" value="${res.historiaclinica}">
    //                                         <input class="diagnosticoClass" type="hidden" name="" value="${res.diagnostico}">
    //                                     </div>`;

    //             // contenido del modal de eliminar
    //         });

    //         document.querySelector("#semaforo").value = resultad[0][2];
    //         console.log(resultad[0][2], "semaforo");

    //         document.querySelector("#tbody").innerHTML = html;
    //         document.querySelector("#div-oculto").innerHTML = htmlModales;

    //         let aFacH = document.querySelectorAll(".btnFH");
    //         // aFacH
    //         for (const factH of aFacH) {
    //             factH.addEventListener("click", async function () {
    //                 // para traer el valor del data index
    //                 let index = this.getAttribute("data-index");
    //                 editar(parseInt(index));
    //                 let idHospit = this.getAttribute("data-id-hospitalizacion");
    //                 console.log(idHospit + " id hospitalizacion");

    //                 let datos = await mostrarInf(parseInt(index), parseInt(idHospit));
    //                 document.querySelector("#idH").value = idHospit;
    //                 document.querySelector("#monto").value = datos[0];
    //                 document.querySelector("#montoME").value = datos[1];
    //                 document.querySelector("#total").value = datos[2];
    //                 document.querySelector("#totalME").value = datos[3];
    //                 clearStyleVInputs();
    //             });
    //         }
    //         const btnEditar = document.querySelectorAll(".editarH");
    //         // recorremos los btn editar
    //         for (const editH of btnEditar) {
    //             editH.addEventListener("click", async function () {
    //                 document.querySelectorAll(".input-validar").forEach((input) => {
    //                     let campoCustom = input.closest(".campo-custom");
    //                     let check = input.nextElementSibling.children[0];
    //                     let error = input.nextElementSibling.children[1];
    //                     input.parentElement.classList.remove("invalido");
    //                     input.parentElement.classList.add("valido");

    //                     campoCustom.querySelector("p").classList.add("d-none");

    //                     if (check && error) chulitoYX(check, error, "valido");
    //                 });
    //                 objServiciosBD = await traerSerevicio("editar");
    //                 // id de la hospitalización
    //                 let extra = editH.getAttribute("data-extra");
    //                 await traerSerevicioH(parseInt(extra));
    //                 // para traer el valor del data index
    //                 let index = editH.getAttribute("data-index");
    //                 editar(parseInt(index));

    //                 // para traer el valor del data extra
    //                 // es el id de la hospitalizacion
    //                 mostrarIE(parseInt(extra));
    //                 // este evento es para buscar el insumo
    //                 document.querySelector("#btn-buscarInsumoE").addEventListener("click", function () {
    //                     traerInsumosE();
    //                 });
    //             });
    //         }

    //         // recorremos los btn informacion
    //         document.querySelectorAll(".informacionH").forEach((inforH) => {
    //             inforH.addEventListener("click", function () {
    //                 let tr = inforH.closest("tr");
    //                 let columnas = tr.children;

    //                 let nombreAp = document.getElementById("nombreApellidoM");
    //                 let cedula = document.getElementById("cedulaM");
    //                 let diagnostico = document.getElementById("diagnosticoM");
    //                 let doctor = document.getElementById("doctorM");
    //                 let historia = document.getElementById("historiaM");

    //                 nombreAp.innerHTML = `${columnas[1].innerText} ${columnas[2].innerText}`;
    //                 cedula.innerHTML = columnas[0].innerText;
    //                 diagnostico.innerHTML = columnas[3].innerText;
    //                 doctor.innerHTML = columnas[4].innerText;

    //                 // para traer el valor del data index (la posición)
    //                 let index = inforH.getAttribute("data-index");
    //                 let idHospit = inforH.getAttribute("data-id-hospitalizacion");
    //                 mostrarInf(parseInt(index), parseInt(idHospit));
    //             });
    //         });

    //         // para validar las cantidades de hospitalizaciones agregadas
    //         // obtenemos la cantidad de filas que existen
    //         const filas = document.querySelectorAll("#tbody tr");

    //         if (filas.length >= 2) {
    //             // se oculta el btn y el modal al alcanzar el limite de hospitalizaciones
    //             btnAgregar.classList.add("d-none");
    //             document.querySelector("#divModal").classList.add("d-none");
    //             document.querySelector("#pModalOculto").classList.remove("d-none");
    //         } else {
    //             // se muestra el modal y el btn de agregar
    //             btnAgregar.classList.remove("d-none");
    //             document.querySelector("#divModal").classList.remove("d-none");
    //             document.querySelector("#pModalOculto").classList.add("d-none");
    //         }
    //     }
    // }

    // document.querySelectorAll(".btn-eliminar").forEach((btn) => {
    //     btn.addEventListener("click", function () {
    //         const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
    //         alertConfirm("Esta seguro de eliminar la hospitalizacion?", deleteHospitalizacion, data);
    //     });
    // });
    // } catch (error) {
    //     console.log("lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
    //     alertError("Error", error);
    // }
};

readHosp();

//delete
const deleteHosp = async (data) => {
    try {
        const result = await executePetition(url + `/eliminaL/${data}`, "GET");
        console.log(result);

        if (result.ok) {
            alertSuccess(result.message);
            readHosp();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};
