import { executePetition } from "./../assets/ajax/funtionExecutePetition.js";

addEventListener("DOMContentLoaded", () => {
  console.log("Citas");
  const url = "/Sistema-del--CEM--JEHOVA-RAFA/Citas";
  

  const cedulaCita = document.getElementById("cedulaCita");
  const modalAgregarCita = document.getElementById("modalAgregarCita");
  const paciente = document.getElementById("paciente");
  const telefono = document.getElementById("telefono");
  const especialidad = document.getElementById("especialidad");
  const formCitas = document.getElementById("contenedorFormCitas");
  const btnBuscarCita = document.getElementById("buscarPacienteCita");
  let diaNumero = [];
  let diaNumeroEdi = [];
  let fechaFormulario;
  let alertaEditar;
  let horarioIdEdi = [];
  let Modalll;
  let btnEditar;
  let laborables;
  let validarHora = [];
  let horaarray = [];

  // ACCIONES DE LA CITA CRUD
  const readCita = async () => {
    try {
      let metodo = "";
      let urlActual = window.location.href;

      if (urlActual.includes("Hoy")) metodo = "citasHoyAjax";
      else if(urlActual.includes("Realizadas")) metodo = "citasRealizadasAjax";
      else metodo = "citasAjax";

      const result = await executePetition(url + "/" + metodo, "GET");

      // construir html de filas
      let html = "";
      result.forEach((element) => {
        html += ` <tr>
                            <td class="text-center">${element.nacionalidad} ${element.cedula}</td>
                            <td class="text-center">${element.nombre_p} ${element.apellido_p}</td>
                            <td class="text-center">${element.telefono_p}</td>
                            <td class="text-center">${element.nombre_d} ${element.apellido_d}</td>
                            <td class="text-center">${element.categoria}</td>
                            <td class="text-center">${element.fecha}</td>
                            <td class="text-center">${element.hora}</td>

                            <td class="text-center">${element.estado}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- editar -->
                                    
                                        <div class="me-2 botonesEdi ${urlActual.includes("Realizadas") ? "d-none" : ""}">
                                            <a href="#" class="btns-accion botonesEditar botonesEdi btn-dt-tabla"
                                                data-id-tabla="modal-examplecitaeditar${
                                                  element.id_cita
                                                }" uk-toggle="target: #modal-examplecitaeditar${element.id_cita}"
                                                data-index="${element.id_cita}" uk-tooltip="Modificar Cita"
                                                id="btnEditarCitaPendiente">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        </div>
                                   
                                        <div class="me-2">
                                            <a href="#" class="btns-accion btn-eliminar btn-dt-tabla" data-index=${
                                              element.id_cita
                                            } 
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </div>
                                  

                                </div>


        </div>

        <!-- modal -->
        <div id="modal-examplecitaeditar${element.id_cita}" uk-modal class="modalEditar">
            <div class="uk-modal-dialog uk-modal-body tamaño-modal" id="modal${element.id_cita}">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-calendar-day-fill azul me-2 mb-3 " viewBox="0 0 16 16">
                            <path
                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16v9zm-4.785-6.145a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43c0 .238.192.425.43.425zm.336.563h-.672v4.105h.672V8.418zm-6.867 4.105v-2.3h2.261v-.61H4.684V7.801h2.464v-.61H4v5.332h.684zm3.296 0h.676V9.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a1.806 1.806 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98v4.105z" />
                        </svg>
                    </div>
                    <div class="">
                        <p class="uk-modal-title fs-5">
                            Editar Cita
                        </p>
                    </div>

                </div>

                <form class="form-modal form-validable${element.id_cita} form-ajax forms-editar" data-index='${element.id_cita}'>
                    <input type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>" name="id_usuario">

                    <form class="form-modal"
                        action="/Sistema-del--CEM--JEHOVA-RAFA/editarCitaHoy/${element.id_cita}"
                        method="POST">

                        <input type="hidden" value="${element.id_paciente}"
                            name="id_paciente">

                        <input type="hidden" name="id_cita" value="${element.id_cita}">

                        <input type="hidden" name="id_usuario" class="id_usuario_bitacora">

                        <input type="hidden" value="${element.serviciomedico_id_servicioMedico}"
                            name="serviciomedico_id_servicioMedico">








                        <div class="input-group flex-nowrap caja">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-clipboard2-check-fill azul"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                </svg>
                            </span>
                            <select class="form-control input-modal especialidad" name="consulta">
                                <option selected disabled value="${element.serviciomedico_id_servicioMedico}">
                                    ${element.categoria}
                                </option>

                            </select>
                        </div>

                        <div class="input-group flex-nowrap">
                            <span class=" mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                    fill="currentColor" class="bi bi-person-fill azul mb-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                                Doctor</span>


                        </div>


                        <div class="mt-2 mb-2 listaDoctores">
                        ${element.nombre_d} ${element.apellido_d}
                        </div>

                        <input type="hidden" class="id_servicioMedico" name="id_servicioMedico">

                        

                        <div class="alert alert-danger d-flex align-items-center justify-content-center alertaClassEditar d-none"
                            role="alert" id="alertahorarioCitaEdi">
                            <div class="text-center">
                                <p style="font-size: 10px; height: 20px;" class="text-center mb-3">VERIFIQUE
                                    QUE LA
                                    FECHA DE LA CONSULTA ESTE COMPRENDIDA EN EL HORARIO DEL DOCTOR</p>
                            </div>
                        </div>


                        <div class="input-group flex-nowrap validar">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-calendar-date-fill azul"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                    <path
                                        d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                                </svg>
                            </span>
                            <input class="form-control input-modal fecha input-validar" id="fechaEditar" type="date"
                                name="fechaDeCita" required pattern="\d{2}\/\d{2}\/\d{4}" placeholder="Fecha"
                                value="${element.fecha}">

                        </div>

                        <p class="p-error-fechaDeCita${element.id_cita}"></p>

                        <div class="input-group flex-nowrap">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-clock-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                </svg>
                            </span>
                            <input class="form-control input-modal" type="time" name="hora"
                                placeholder="Hora" required value="${element.hora}">
                        </div>

                        <div class="mt-3 uk-text-right">
                            <button
                                class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                type="button">Cancelar</button>
                            <button class="btn col-3 btn-agregarcita-modal btnEditarCita" id="btnEditarCita"
                                type="submit">Editar</button>
                        </div>
                    </form>
                </form>
            </div>
            </td>
            </tr>`;
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
          Swal.fire({
            icon: "question",
            title: "Confirmacion",
            text: "Esta seguro de eliminar el paciente?",
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
              deleteCita(data);
              console.log(data);
            }
          });
        });
      });

      //llamar las funciones de editar
      document.querySelectorAll(".forms-editar").forEach((formEditar) => {
        formEditar.addEventListener("submit", function (e) {
          e.preventDefault();

          console.log(
            document.querySelector(".p-error-fechaDeCita" + formEditar.getAttribute("data-index")).classList.contains("d-none")
          );

          if (
            !document.querySelector(".p-error-fechaDeCita" + formEditar.getAttribute("data-index")).classList.contains("d-none")
          ) {
            updateCitas(this);
          } else {
            Swal.fire({
              icon: "error",
              title: "Error al enviar el formulario",
              text: "Por favor verifique que todos los datos esten correctos.",
              customClass: {
                popup: "switAlert",
                confirmButton: "btn-agregarcita-modal",
                cancelButton: "btn-agregarcita-modal-cancelar",
              },
            });
          }
        });
      });

      //llamar a la uncion de restablecer
      //llamar las funcion de eliminar
      document.querySelectorAll(".btnRestablecer").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
          Swal.fire({
            icon: "question",
            title: "Confirmacion",
            text: "Esta seguro de restablecer el paciente?",
            confirmButtonText: "Aceptar",
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
              restablecerPattients(data);
              console.log(data);
            }
          });
        });
      });

      // re-inicializa
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
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: `${error}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
    }
  };

  //create
  const createCita = async (form, inputs) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(url + "/guardarCita", "POST", data);
      console.log(result);
      if (result.ok) {
        Swal.fire({
          icon: "success",
          title: "Exito",
          text: `${result.message}`,
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        });
        UIkit.modal("#modal-examplecita").hide();
        form.reset();
        inputs = [];
        inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
        readCita();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: `${error}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
    }
  };

  
  //delete
  const deleteCita = async (data) => {
    try {
      const result = await executePetition(url + `/eliminarCita/${data}`, "GET");
      if (result.ok) {
        Swal.fire({
          icon: "success",
          title: "Exito",
          text: `${result.message}`,
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        });
        readCita();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: `${error}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
    }
  };
  
  //update
  const updateCitas = async (form) => {
    try {
      const data = new FormData(form);
  
      let result = await executePetition(url + "/editarCita", "POST", data);
      console.log(result);
      if (result.ok) {
        Swal.fire({
          icon: "success",
          title: "Exito",
          text: `${result.message}`,
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        });
        UIkit.modal(`#${form.parentElement.parentElement.getAttribute("id")}`).hide();
        readCita();
        console.log(result.error)
      } else throw new Error(`${result.error}`);
    } catch (error) {
      console.log(error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: `${error}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
    }
  };

  if (modalAgregarCita) {
    modalAgregarCita.addEventListener("submit", function (e) {
      e.preventDefault();
      let inputsBuenos = [];
      this.querySelectorAll(".input-validar").forEach((input) => {
        if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
      });

      if (
        !document.querySelector(".p-error-fn").classList.contains("d-none")
      ) {
        createCita(this, inputsBuenos);
      } else {
        Swal.fire({
          icon: "error",
          title: "Error al enviar el formulario",
          text: "Por favor verifique que todos los datos esten correctos.",
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        });
      }
    });
  }

  readCita()

  const traerPacienteCita = async (event) => {
    // try {
    const datosFormulario = new FormData(modalAgregarCita);
    const contenido = {
      method: "POST",
      body: datosFormulario,
    };

    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarPacienteCita", contenido);

    console.log(peticion);
    let resultado = await peticion.json();
    console.log(resultado);

    if (resultado.length > 0) {
      resultado.forEach((res) => {
        console.log(res);
        paciente.value = res.nombre + " " + res.apellido;
        telefono.value = res.telefono;
        document.getElementById("id_paciente").value = res.id_paciente;

        if (event && event.type === "click") {
          document.getElementById("myToast").classList.add("d-none");
          //formCitas.classList.remove('d-none');
        } else {
          document.getElementById("myToast").classList.add("d-none");
        }
      });
    } else {
      formCitas.classList.add("d-none");
      let valorCedulaPaciente = cedulaCita.value;
      modalAgregarCita.reset();

      cedulaCita.value = valorCedulaPaciente;
      document.getElementById("iconoCedulaCita").classList.add("d-none");

      //se pasa la cedula de el modal de la cita al de registrar al paiente para hacerlo mas amigable

      document.querySelector(".cedula-paciente").value = cedulaCita.value;

      //Esto es para que cuando el se pase la cedula de cita a paciente tambien se pinte verde y cumpla la expresion regular
      document.querySelector(".cedula-paciente").parentElement.classList.add("grpFormCorrect");

      if (event && event.type === "click") {
        document.getElementById("myToast").classList.remove("d-none");
        const toastElement = document.getElementById("myToast");
        const toast = new bootstrap.Toast(toastElement, {
          autohide: false,
        });
        toast.show();
      }

      //desaparecer el boton de enviar el modal si no encuentra al paciente
      document.getElementById("btnAgregarCita").classList.add("d-none");
    }
    // } catch (error) {
    //   console.log(
    //     "Lamentablemente, algo salió mal. Por favor, intente más tarde..."
    //   );
    // }
  };
  const traerDoctoresCita = async () => {
    // try {
    let id = especialidad.value;
    console.log(id);
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDoctoresCita/" + id);
    let resultado = await peticion.json();
    console.log(resultado);
    let html = ``;
    if (resultado.length > 0) {
      html = ``;
      resultado.forEach((res) => {
        html += `<input required class="uk-checkbox doctoresCitas mt-2 mb-2 me-2" type="radio" name="id_doctor" value="${res.id_personal}">  ${res.nombre_doctor} ${res.apellido_doctor}<br>`;
      });
      document.getElementById("listaDoctores").innerHTML = html;

      document.querySelectorAll(".doctoresCitas").forEach((doctor) => {
        if (doctor) {
          doctor.addEventListener("change", function () {
            let idD = doctor.value;
            traerHorario(idD);
            if (doctor.checked) {
              //desaparecer el boton de enviar el modal si no encuentra al paciente
              document.getElementById("btnAgregarCita").classList.remove("d-none");
              console.log("si");
            }
          });
        }
      });
      diaNumero = [];
      document.getElementById("fecha").value = "";
      //document.getElementById("divAcordion").remove();
    } else {
      document.getElementById("listaDoctores").innerHTML = "NO HAY DOCTORES DISPONIBLES PARA ESTE SERVICIO MEDICO";
      document.getElementById("divAcordion").remove();
      document.getElementById("btnAgregarCita").classList.add("d-none");
    }
    // } catch (error) {
    //   console.log(
    //     "lamentablemete Algo Salio Mal Por favor Intente Mas Tarde..."
    //   );
    // }
  };

  //funcion para buscar de una vez al paciente segun la cedula insertada
  const traerPacienteRegistrado = async (nacionalidad, cedula) => {
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarPacienteCitaGet/" + nacionalidad + "/" + cedula);

    console.log(peticion);
    let resultado = await peticion.json();
    console.log(resultado);

    resultado.forEach((res) => {
      console.log(res);
      document.getElementById("contenedorFormCitas").classList.remove("d-none");
      paciente.value = res.nombre + " " + res.apellido;
      telefono.value = res.telefono;
      document.getElementById("id_paciente").value = res.id_paciente;
    });
  };

  //funcion ajax para registrar un paciente que no se encontro

  const insertarPaciente = async (form, event) => {
    try {
      const datosFormulario = new FormData(form);
      const contenido = {
        method: "POST",
        body: datosFormulario,
      };
      let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/insertaPaciente", contenido);
      let resultado = await peticion.json();
      console.log(resultado);

      // si el resultado es un mensaje es que algo salio mal y la cedula ya eiste si no se inserta normalmente
      if (resultado.cedula == "error") {
        console.log(resultado.cedula + " error");

        document.querySelector(".alertaErrorCedula").classList.remove("d-none");
        setTimeout(function () {
          document.querySelector(".alertaErrorCedula").classList.add("d-none");
        }, 7000);
      } else {
        //ocultar modal de paciente
        UIkit.modal("#modal-examplePaciente").hide();

        cedulaCita.value = resultado.cedula;

        //que aparezca modal de cita
        UIkit.modal("#modal-examplecita").show();

        //ocultar el minimodal
        const toastElement = document.getElementById("myToast");
        const toast = new bootstrap.Toast(toastElement, {
          autohide: false,
        });
        toast.hide();

        traerPacienteRegistrado(resultado.nacionalidad, resultado.cedula);

        //limpiar formulario de oaciente

        form.reset();

        document.querySelectorAll(".input-validar").forEach((input) => {
          input.parentElement.classList.remove("grpFormCorrect");
        });
      }
    } catch (error) {
      console.log("algo salio mal" + error);
    }
  };
  //llamar a la funcion para insertar un paciente que no existe

  document.getElementById("modalAgregar").addEventListener("submit", function (e) {
    let inputsBuenos = [];
    //validar si todos los inputs nos estan validados no se puede enviar
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("grpFormCorrect")) {
        inputsBuenos.push(true);
      }
    });
    console.log(inputsBuenos);
    console.log(document.querySelector(".p-error-fechaDeCita").classList.contains("d-none"));

    if (
      (inputsBuenos.length == 5 && document.querySelector(".p-error-fechaDeCita").classList.contains("d-none")) ||
      (inputsBuenos.length == 5 && document.querySelector(".p-error-fn").classList.contains("d-none"))
    ) {
      console.log("si");
      insertarPaciente(this, e);
    }
  });

  let fechaIngresoGlobal;
  let idDGobal;

  const traerHorario = async (idD) => {
    // try {
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarHorario/" + idD);
    let resultado = await peticion.json();
    document.querySelector(".horario-insertar").innerHTML = "";
    let div = document.createElement("div");
    diaNumero = []; // Reiniciar el arreglo para evitar acumulación de datos previos
    let diasLaborablesMap = {}; // Mapa para almacenar los días y sus horarios
    console.log(resultado);
    div.innerHTML = "";
    if (resultado.length > 0) {
      resultado.forEach((res) => {
        function entradaHora() {
          // Separar la hora y los minutos
          let [horas, minutos] = res.horaDeEntrada.split(":").map(Number);

          // verificamos si es AM o PM
          const esPM = horas >= 12;
          const sufijo = esPM ? "PM" : "AM";

          // Convertir horas de 24 a 12
          horas = horas % 12 || 12; // Si es 0, se convierte a 12

          // Se formatear los minutos para que siempre tengan dos dígitos
          minutos = minutos < 10 ? "0" + minutos : minutos;

          // Retornar la hora en formato de 12 horas
          return `${horas}:${minutos} ${sufijo}`;
        }

        function salidaHora() {
          // Separamos la hora y los minutos
          let [horas, minutos] = res.horaDeSalida.split(":").map(Number);

          // verificamos si es AM o PM
          const esPM = horas >= 12;
          const sufijo = esPM ? "PM" : "AM";

          // Convertir horas de 24 a 12
          horas = horas % 12 || 12; // Si es 0, se convierte a 12

          // Formatear los minutos para que siempre tengan dos dígitos
          minutos = minutos < 10 ? "0" + minutos : minutos;

          // Retornar la hora en formato de 12 horas
          return `${horas}:${minutos} ${sufijo}`;
        }

        const horaEntrada = entradaHora(res.horaDeEntrada);
        const horaSalida = salidaHora(res.horaDeSalida);

        let diasLaborablesArray = res.diaslaborables.toLowerCase().split(" ");

        diasLaborablesArray.forEach((dia) => {
          diasLaborablesMap[dia] = {
            entrada: res.horaDeEntrada,
            salida: res.horaDeSalida,
          };
        });

        div.innerHTML += `
                 <div class="mb-2" id="divAcordion">
                <div class="d-flex ">Días Laborables: <h6 class="fw-bold"> ${res.diaslaborables}</h6></div>
              
                <div class="d-flex">Hora de Entrada: <h6 class="fw-bold"> ${horaEntrada}</h6></div>
                <div class="d-flex ">Hora de Salida: <h6 class="fw-bold"> ${horaSalida}</h6></div></div>  `;

        validarHora.push(res.diaslaborables, res.horaDeEntrada, res.horaDeSalida);
        console.log(validarHora);
        laborables = res.diaslaborables;

        horaarray = [res.diaslaborables, res.horaDeEntrada, res.horaDeSalida];
        const persona = {
          dia: res.diaslaborables,
          entrada: res.horaDeEntrada,
          salida: res.horaDeSalida,
        };

        console.log(horaarray);
        console.log(persona);

        //id del ervicio medico
        document.getElementById("id_servicioMedico").value = res.id_servicioMedico;
      });
    } else {
      div.innerHTML = `NO HAY HORARIOS DISPONIBLES PARA ESTE DOCTOR`;
      document.getElementById("btnAgregarCita").classList.add("d-none");
    }

    document.querySelector(".horario-insertar").appendChild(div);

    //fecha
    document.getElementById("fecha").addEventListener("blur", function () {
      let fechaIngresada = this.value;
      if (fechaIngresada) {
        let partesFecha = fechaIngresada.split("-");
        let fecha = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);
        let diaSemanaNombre = fecha.toLocaleDateString("es-ES", { weekday: "long" }).toLowerCase();

        console.log(diaSemanaNombre);

        let alertaCita = document.getElementById("alertahorarioCita");

        if (diasLaborablesMap[diaSemanaNombre]) {
          document.getElementById("btnAgregarCita").classList.remove("d-none");
          alertaCita.classList.add("d-none");

          let horario = diasLaborablesMap[diaSemanaNombre];
          document.getElementById("horaCita").setAttribute("min", horario.entrada);
          document.getElementById("horaCita").setAttribute("max", horario.salida);
        } else {
          document.getElementById("btnAgregarCita").classList.add("d-none");
          alertaCita.classList.remove("d-none");
          setTimeout(() => alertaCita.classList.add("d-none"), 10000);
        }
      } else {
        e.preventDefault();
        document.getElementById("btnAgregarCita").classList.add("d-none");
      }

      /* validacion de las goras disponibles */
      validarHorarioDisponible(fechaIngresada, idD);
      fechaIngresoGlobal = fechaIngresada;
      idDGobal = idD;
    });
  };

  /*  validacionn d e las horas disponibles */
  async function validarHorarioDisponible(fecha, id_personal) {
    let peticion = await fetch(`/Sistema-del--CEM--JEHOVA-RAFA/Citas/validarHorariosDisponlibles/${fecha}/${id_personal}`);
    let resultado = await peticion.json();
    let html = "";
    resultado.forEach((res, index) => {
      html += `
    <div class="mb-2" id="divAcordion">
    <h5 class="mb-2 ">Cita  ${index + 1}</h5>
      <div class="d-flex ">
        Hora de entrada: <h6 class="fw-bold"> ${res.hora}</h6>
      </div>

      <div class="d-flex">
        Hora de salida: <h6 class="fw-bold"> ${res.hora_salida}</h6>
      </div>
    </div>`;

      let citaInicio = res.hora;
      let citaFin = res.hora_salida;
      let nuevaInicio = document.getElementById("horaCita").value;
      let fecha = new Date(`${res.fecha}T$${res.hora}:00`);
      fecha.setMinutes(fecha.getMinutes + 55);
      nuevaFin = fecha.toLocaleDateString("es-ES", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
      if (
        (nuevaInicio >= citaInicio && nuevaInicio < citaFin) ||
        (nuevaFin > citaInicio && nuevaFin <= citaFin) ||
        (nuevaInicio <= citaInicio && nuevaFin >= citaFin)
      ) {
        console.log("Conflicto de horario: La cita se cruza con otra existente.");
        document.getElementById("btnAgregarCita").classList.add("d-none");
      } else {
        console.log("Horario disponible.");
        document.getElementById("btnAgregarCita").classList.remove("d-none");
      }
    });

    document.querySelector(".horario-ocupados").innerHTML = html;
  }

  /* llamar a la funcion de la horaa */

  document.getElementById("horaCita").addEventListener("keyup", function () {
    validarHorarioDisponible(fechaIngresoGlobal, idDGobal);
  });
  //validar que cumpla la validacion para que aparesca el boton

  //buscar al paciente
  console.log(btnBuscarCita);
  btnBuscarCita.addEventListener("click", function (event) {
    if (cedulaCita.value.length >= 6) {
      formCitas.classList.remove("d-none");
      document.getElementById("iconoCedulaCita").classList.remove("d-none");
      traerPacienteCita(event);
    } else {
      document.querySelector(".alerta-cedula-paciente").classList.remove("d-none");
      setTimeout(function () {
        document.querySelector(".alerta-cedula-paciente").classList.add("d-none");
      }, 7000);
    }
  });

  especialidad.addEventListener("change", function () {
    traerDoctoresCita();
  });

  //editar
  const traerDoctoresCitaEdi = async (id, listaDEdi, horarios, id_servicioMedicoEdi, doctorTabla = undefined, inputFecha) => {
    try {
      let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDoctoresCita/" + id);
      let resultado = await peticion.json();
      console.log(resultado);
      let html = ``;

      if (resultado.length > 0) {
        resultado.forEach((res) => {
          html += `<input required class="uk-checkbox checkDes doctoresCitas me-2" type="radio" name="id_doctor" value="${res.id_personal}" id="doctorEditarID" checked=true disabled>  ${res.nombre_doctor} ${res.apellido_doctor}<br>`;
        });
        listaDEdi.innerHTML = html;
        document.querySelectorAll(".doctoresCitas").forEach((doctor) => {
          console.log(doctor);
          if (doctor) {
            let idD = doctor.value;
            console.log(idD);
            console.log(doctorTabla.trim());
            if (doctorTabla == undefined) {
              console.log("valor indefinido");
            } else if (doctorTabla.trim() == doctor.value) {
              doctor.setAttribute("checked", true);
              traerHorarioEdi(idD, horarios, id_servicioMedicoEdi, doctorTabla, inputFecha);
            }

            traerHorarioEdi(idD, horarios, id_servicioMedicoEdi, doctorTabla, inputFecha);

            console.log("hola");

            doctor.addEventListener("change", function () {
              traerHorarioEdi(idD, horarios, id_servicioMedicoEdi, doctorTabla, inputFecha);
            });
          }
        });
      }
    } catch (error) {
      console.log("lamentablemete Algo Salio Mal Por favor Intente Mas Tarde...");
    }
  };

  const traerHorarioEdi = async (idD, horarios, id_servicioMedicoEdi, doctorTabla, inputFecha) => {
    try {
      let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarHorario/" + idD);
      let resultado = await peticion.json();

      horarios.innerHTML = ``;

      let div = document.createElement("div");

      //array

      console.log("RES");
      console.log(resultado);
      resultado.forEach((res) => {
        function entradaHora() {
          // Separar la hora y los minutos
          let [horas, minutos] = res.horaDeEntrada.split(":").map(Number);

          // Determinar si es AM o PM
          const esPM = horas >= 12;
          const sufijo = esPM ? "PM" : "AM";

          // Convertir horas de 24 a 12
          horas = horas % 12 || 12; // Si es 0, se convierte a 12

          // Se formatear los minutos para que siempre tengan dos dígitos
          minutos = minutos < 10 ? "0" + minutos : minutos;

          // Retornar la hora en formato de 12 horas
          return `${horas}:${minutos} ${sufijo}`;
        }

        function salidaHora() {
          // Separar la hora y los minutos
          let [horas, minutos] = res.horaDeSalida.split(":").map(Number);

          // Verificamos si es AM o PM
          const esPM = horas >= 12;
          const sufijo = esPM ? "PM" : "AM";

          // Convertir horas de 24 a 12
          horas = horas % 12 || 12; // Si es 0, se convierte a 12

          // Formatear los minutos para que siempre tengan dos dígitos
          minutos = minutos < 10 ? "0" + minutos : minutos;

          // Retornar la hora en formato de 12 horas
          return `${horas}:${minutos} ${sufijo}`;
        }

        const horaEntrada = entradaHora(res.horaDeEntrada);
        const horaSalida = salidaHora(res.horaDeSalida);

        let diasLaborablesArrayEdi = res.diaslaborables.toLowerCase().split(" ");

        const diasSemanaNumerosEdi = {
          domingo: [0],
          lunes: [1],
          martes: [2],
          miércoles: [3],
          jueves: [4],
          viernes: [5],
          sábado: [6],
        };

        // Variable que contiene el día de la semana
        // Ejemplo de variable

        // Convertir el día a número

        diasLaborablesArrayEdi.forEach((diaEdi) => {
          if (diasSemanaNumerosEdi[diaEdi]) {
            diaNumeroEdi.push(...diasSemanaNumerosEdi[diaEdi]);
            // Agregamos los números al arreglo
          }
        });

        // Verificar si el día es válido y mostrar el resultado
        console.log(`El día ${res.diaslaborables} corresponde al número ${diaNumeroEdi}.`);
        console.log(diaNumeroEdi);

        div.innerHTML += `
                <div class="mb-2" id="divAcordionEdit">
                <div class="d-flex ">Dias Laborables: <h6 class="fw-bold"> ${res.diaslaborables}</h6></div>
              
                <div class="d-flex">Hora de Entrada: <h6 class="fw-bold">  ${horaEntrada}</h6></div>
                <div class="d-flex ">Hora de Salida: <h6 class="fw-bold">  ${horaSalida}</h6></div></div> 
                
                `;
        //     //id del ervicio medico
        id_servicioMedicoEdi.value = res.id_servicioMedico;
        horarioIdEdi.push(diaNumeroEdi);
      });
      horarios.appendChild(div);
      console.log(horarioIdEdi);

      horarioIdEdi.forEach((rec) => {
        fechaFormulario.addEventListener("blur", function () {
          let fechaIngresada = this.value;
          if (fechaIngresada) {
            let partesFecha = fechaIngresada.split("-");
            let fecha = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);
            let diaSemana = fecha.getDay(); // 0 para domingo, 1 para lunes, etc.

            console.log(diaSemana);

            if (diaNumeroEdi.includes(diaSemana)) {
              console.log("Si sirve");

              btnEditar.classList.remove("d-none");
              alertaEditar.classList.add("d-none");
            } else {
              console.log("No sirve");

              btnEditar.classList.add("d-none");
              alertaEditar.classList.remove("d-none");
              setTimeout(function () {
                alertaEditar.classList.add("d-none");
              }, 10000);
            }
          } else {
            e.preventDefault();
            document.getElementById("btnEditarCita").classList.add("d-none");
          }
        });
      });
    } catch (error) {
      console.log(error);
    }
  };

  document.querySelectorAll(".especialidad").forEach((ele) => {
    ele.addEventListener("change", function () {
      let listaDEdi = document.querySelector(`#${this.parentElement.parentElement.getAttribute("id")} .listaDoctores`);
      let horarios = document.querySelector(`#${this.parentElement.parentElement.getAttribute("id")} .uk-accordion-content`);
      console.log(horarios);
      let id_servicioMedicoEdi = document.querySelector(
        `#${this.parentElement.parentElement.getAttribute("id")} .id_servicioMedico`
      );

      let fechaFormulario2 = document.querySelector(`#${this.parentElement.parentElement.getAttribute("id")} .fecha`);
      console.log("fecha cambio" + fechaFormulario2.value);

      traerDoctoresCitaEdi(ele.value, listaDEdi, horarios, id_servicioMedicoEdi, fechaFormulario2);
    });
  });

  //mostrar los datos en el formulario
  document.querySelectorAll(".botonesEditar").forEach((btn) => {
    btn.addEventListener("click", function () {
      let cadena = this.getAttribute("uk-toggle").split(" ");
      //variable padre
      let nombreDeID = cadena[1].substring(1);

      //parametro 1
      let esp = document.querySelector(`#${nombreDeID} .caja .especialidad`);

      //parametro 2
      let listDocEi = document.querySelector(`#${nombreDeID} .uk-modal-dialog .listaDoctores`);

      //parametro 3
      let divHorarioEdi = document.querySelector(`#${nombreDeID} .uk-modal-dialog .uk-accordion-content`);

      console.log(divHorarioEdi);
      //parametro 4
      let id_serMedEdi = document.querySelector(`#${nombreDeID} .uk-modal-dialog .id_servicioMedico`);
      let doctorT = this.parentElement.parentElement.parentElement.parentElement.children[3].innerText;
      console.log(doctorT);

      //parametro 5
      fechaFormulario = document.querySelector(`#${nombreDeID} .uk-modal-dialog .fecha`);
      console.log("fecha click " + fechaFormulario.value);

      alertaEditar = document.querySelector(`#${nombreDeID} .uk-modal-dialog .alertaClassEditar`);
      btnEditar = document.querySelector(`#${nombreDeID} .uk-modal-dialog .btnEditarCita`);

      Modalll = nombreDeID;

      console.log(Modalll);
      diaNumeroEdi = [];
      horarioIdEdi = [];

      // Modalll.addEventListener("hidden", function(){
      //     // Execute your function here
      //     console.log('Modal has been closed!')
      //   })

      traerDoctoresCitaEdi(esp.value, listDocEi, divHorarioEdi, id_serMedEdi, doctorT, fechaFormulario);
    });
  });

  let tabla = document.getElementById("tabla");
  let horasT = [];
  let insertarT = document.getElementById("insertarhora");

  function horaTabla(hora) {
    // Separar la hora y los minutos
    let [horas, minutos] = hora.split(":").map(Number);

    // Determinar si es AM o PM
    const esPM = horas >= 12;
    const sufijo = esPM ? "PM" : "AM";

    // Convertir horas de 24 a 12
    horas = horas % 12 || 12; // Si es 0, se convierte a 12

    //Se formatear los minutos para que siempre tengan dos dígitos
    minutos = minutos < 10 ? "0" + minutos : minutos;

    // Retornar la hora en formato de 12 horas
    //insertarT.textContent = `${horas}:${minutos} ${sufijo}`;
    return `${horas}:${minutos} ${sufijo}`;
  }
  if (tabla.rows[1].cells[7] != undefined) {
    for (let i = 1; i < tabla.rows.length; i++) {
      let hora = tabla.rows[i].cells[7].innerText;
      horasT.push(hora); // Agregar la hora al arreglo
    }

    console.log(tabla);

    horasT.forEach((hora, index) => {
      const horatablita = horaTabla(hora); // Convertir la hora
      let fila = tabla.rows[index + 1];
      let celda = fila.cells[8]; //  (índice 8)
      //celda.textContent = horatablita; // Asignar el valor convertido a la celda
      console.log(horatablita);
    });
  }
});
