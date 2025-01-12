addEventListener("DOMContentLoaded", () => {
  console.log("Citas");
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
  const traerPacienteCita = async (event) => {
    try {
      const datosFormulario = new FormData(modalAgregarCita);
      const contenido = {
        method: "POST",
        body: datosFormulario,
      };
      let peticion = await fetch(
        "?c=ControladorCitas/mostrarPacienteCita",
        contenido
      );
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
          }
        });
      } else {
        formCitas.classList.add("d-none");
        document.getElementById("iconoCedulaCita").classList.add("d-none");
        document.getElementById("imgCita").classList.remove("d-none");

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
    } catch (error) {
      console.log(
        "Lamentablemente, algo salió mal. Por favor, intente más tarde..."
      );
    }
  };
  const traerDoctoresCita = async () => {
    try {
      let id = especialidad.value;
      console.log(id);
      let peticion = await fetch("?c=ControladorCitas/mostrarDoctoresCita&id=" + id);
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
                document
                  .getElementById("btnAgregarCita")
                  .classList.remove("d-none");
                console.log("si");
              }
            });
          }
        });
        diaNumero = [];
        document.getElementById("fecha").value = "";
        document.getElementById("divAcordion").remove();
      } else {
        document.getElementById("listaDoctores").innerHTML = "";
        document.getElementById("btnAgregarCita").classList.add("d-none");
      }
    } catch (error) {
      console.log(
        "lamentablemete Algo Salio Mal Por favor Intente Mas Tarde..."
      );
    }
  };

  const traerHorario = async (idD) => {
    try {
      let peticion = await fetch(
        "?c=controladorCitas/mostrarHorario&idD=" + idD
      );
      let resultado = await peticion.json();
      document.querySelector(".horario-insertar").innerHTML = "";
      let div = document.createElement("div");
      let horarioId = [];
      console.log(resultado);
      let contador = 0;
      let arrayyyy = [];
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

        const diasSemanaNumeros = {
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

        diasLaborablesArray.forEach((dia) => {
          if (diasSemanaNumeros[dia]) {
            diaNumero.push(...diasSemanaNumeros[dia]);
            // Agregamos los números al arreglo
          }
        });

        // Verificar si el día es válido y mostrar el resultado
        console.log(
          `El día ${res.diaslaborables} corresponde al número ${diaNumero}.`
        );
        console.log(diaNumero);

        div.innerHTML += `
                 <div class="mb-2" id="divAcordion">
                <div class="d-flex ">Dias Laborables: <h6 class="fw-bold"> ${res.diaslaborables}</h6></div>
              
                <div class="d-flex">Hora de Entrada: <h6 class="fw-bold"> ${horaEntrada}</h6></div>
                <div class="d-flex ">Hora de Salida: <h6 class="fw-bold"> ${horaSalida}</h6></div></div>  `;

        validarHora.push(
          res.diaslaborables,
          res.horaDeEntrada,
          res.horaDeSalida
        );
        console.log(validarHora);
        laborables = res.diaslaborables;

        horaarray = [

          diaNumero[contador],
          res.diaslaborables,
          res.horaDeEntrada,
          res.horaDeSalida,
        ];
        const persona = {
          numero: diaNumero[contador],
          dia: res.diaslaborables,
          entrada: res.horaDeEntrada,
          salida: res.horaDeSalida,
        };


        arrayyyy.push(persona);


        console.log(horaarray);
        console.log(persona);
        console.log(arrayyyy);

        //id del ervicio medico
        document.getElementById("id_servicioMedico").value = res.id_servicioMedico;

        horarioId.push(res.id_horario);


        contador++;
      });

      document.querySelector(".horario-insertar").appendChild(div);

      //fecha
      horarioId.forEach((rec) => {
        document.getElementById("fecha").addEventListener("blur", function () {
          let fechaIngresada = this.value;
          if (fechaIngresada) {
            let partesFecha = fechaIngresada.split("-");
            let fecha = new Date(
              partesFecha[0],
              partesFecha[1] - 1,
              partesFecha[2]
            );
            let diaSemana = fecha.getDay(); // 0 para domingo, 1 para lunes, etc.

            console.log(diaSemana);

            let alertaCita = document.getElementById("alertahorarioCita");

            if (diaNumero.includes(diaSemana)) {
              document
                .getElementById("btnAgregarCita")
                .classList.remove("d-none");
              alertaCita.classList.add("d-none");
              arrayyyy.forEach((entrada) => {
                console.log(entrada);
                if (entrada.numero === diaSemana) {
                  document.getElementById("horaCita").setAttribute("min", `${entrada.entrada}`);
                  document.getElementById("horaCita").setAttribute("max", `${entrada.salida}`);
                }
                // if(entrada[0] == diaNumero && entrada[1] == diaSemana){

                // }
              });
              // document.getElementById("horaCita").setAttribute("min",`${res.horaDeEntrada}`)
            } else {
              document.getElementById("btnAgregarCita").classList.add("d-none");
              alertaCita.classList.remove("d-none");
              setTimeout(function () {
                alertaCita.classList.add("d-none");
              }, 10000);
            }
          } else {
            e.preventDefault();
            document.getElementById("btnAgregarCita").classList.add("d-none");
          }
        });
      });

      //const formularioAgregarCita = document.getElementById('modalAgregarCita');
      // Objeto que mapea los días de la semana a sus números

      // Variable que contiene el día de la seman; // Ejemplo de variable

      // Convertir el día a número
    } catch (error) {
      console.log(error);
    }
  };

  // cedulaCita.addEventListener("keyup", function () {
  //   traerPacienteCita();
  // });
  btnBuscarCita.addEventListener("click", function (event) {
    formCitas.classList.remove("d-none");
    document.getElementById("iconoCedulaCita").classList.remove("d-none");
    document.getElementById("imgCita").classList.add("d-none");
    traerPacienteCita(event);
  });

  especialidad.addEventListener("change", function () {
    traerDoctoresCita();
  });

  //editar
  const traerDoctoresCitaEdi = async (
    id,
    listaDEdi,
    horarios,
    id_servicioMedicoEdi,
    doctorTabla = undefined,
    inputFecha
  ) => {
    try {
      let peticion = await fetch(
        "?c=ControladorCitas/mostrarDoctoresCita&id=" + id
      );
      let resultado = await peticion.json();
      console.log(resultado);
      let html = ``;

      if (resultado.length > 0) {
        resultado.forEach((res) => {
          html += `<input required class="uk-checkbox checkDes doctoresCitas me-2" type="radio" name="id_doctor" value="${res.id_personal}" id="doctorEditarID">  ${res.nombre_doctor} ${res.apellido_doctor}<br>`;
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
              traerHorarioEdi(
                idD,
                horarios,
                id_servicioMedicoEdi,
                doctorTabla,
                inputFecha
              );
            }

            doctor.addEventListener("change", function () {
              traerHorarioEdi(
                idD,
                horarios,
                id_servicioMedicoEdi,
                doctorTabla,
                inputFecha
              );
            });
          }
        });
      }
    } catch (error) {
      console.log(
        "lamentablemete Algo Salio Mal Por favor Intente Mas Tarde..."
      );
    }
  };

  const traerHorarioEdi = async (
    idD,
    horarios,
    id_servicioMedicoEdi,
    doctorTabla,
    inputFecha
  ) => {
    try {
      let peticion = await fetch(
        "?c=controladorCitas/mostrarHorario&idD=" + idD
      );
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

        let diasLaborablesArrayEdi = res.diaslaborables
          .toLowerCase()
          .split(" ");

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
        console.log(
          `El día ${res.diaslaborables} corresponde al número ${diaNumeroEdi}.`
        );
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
            let fecha = new Date(
              partesFecha[0],
              partesFecha[1] - 1,
              partesFecha[2]
            );
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
      let listaDEdi = document.querySelector(
        `#${this.parentElement.parentElement.getAttribute("id")} .listaDoctores`
      );
      let horarios = document.querySelector(
        `#${this.parentElement.parentElement.getAttribute(
          "id"
        )} .uk-accordion-content`
      );
      console.log(horarios);
      let id_servicioMedicoEdi = document.querySelector(
        `#${this.parentElement.parentElement.getAttribute(
          "id"
        )} .id_servicioMedico`
      );

      let fechaFormulario2 = document.querySelector(
        `#${this.parentElement.parentElement.getAttribute("id")} .fecha`
      );
      console.log("fecha cambio" + fechaFormulario2.value);

      traerDoctoresCitaEdi(
        ele.value,
        listaDEdi,
        horarios,
        id_servicioMedicoEdi,
        fechaFormulario2
      );
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
      let listDocEi = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .listaDoctores`
      );

      //parametro 3
      let divHorarioEdi = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .uk-accordion-content`
      );

      console.log(divHorarioEdi);
      //parametro 4
      let id_serMedEdi = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .id_servicioMedico`
      );
      let doctorT =
        this.parentElement.parentElement.parentElement.parentElement.children[3]
          .innerText;
      console.log(doctorT);

      //parametro 5
      fechaFormulario = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .fecha`
      );
      console.log("fecha click " + fechaFormulario.value);

      alertaEditar = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .alertaClassEditar`
      );
      btnEditar = document.querySelector(
        `#${nombreDeID} .uk-modal-dialog .btnEditarCita`
      );

      Modalll = nombreDeID;

      console.log(Modalll);
      diaNumeroEdi = [];
      horarioIdEdi = [];

      // Modalll.addEventListener("hidden", function(){
      //     // Execute your function here
      //     console.log('Modal has been closed!')
      //   })

      traerDoctoresCitaEdi(
        esp.value,
        listDocEi,
        divHorarioEdi,
        id_serMedEdi,
        doctorT,
        fechaFormulario
      );
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
      celda.textContent = horatablita; // Asignar el valor convertido a la celda
      console.log(horatablita);
    });
  }

  // console.log(horadelaTablaC);
  //console.log(horasT);

  //este es el comentario
  const comentario = document.querySelector(".comentario");
  //si existe el comentario lo muestra y después de 8sg lo oculta
  if (comentario) {
    comentario.style.display = "block";
    setTimeout(function () {
      comentario.style.display = "none";
    }, 8000);
  }

  // validarHora
});
