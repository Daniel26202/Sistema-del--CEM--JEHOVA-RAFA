// esto es para los iconos y los input
addEventListener("DOMContentLoaded", function () {
  const iconoUno = document.querySelector("#icono-uno");
  const inputUno = document.querySelector("#inputUno");

  const iconoDos = document.querySelector("#icono-dos");
  const inputDos = document.querySelector("#inputDos");

  const iconoTres = document.querySelector("#icono-tres");
  const inputTres = document.querySelector("#inputTres");

  const iconoCuatro = document.querySelector("#icono-cuatro");
  const inputCuatro = document.querySelector("#inputCuatro");

  const iconoCinco = document.querySelector("#icono-cinco");
  const inputCinco = document.querySelector("#inputCinco");

  //esto es las Correcciones de Dixon, Creamos constantes para la validacion de la nueva especialidad
  const selectEspecialidad = document.querySelector(".selectEspecialidad");
  const especialidad = document.querySelector(".especialidad");

  //este es el comentario
  const comentario = document.querySelector(".comentarioD");

  // primer input
  inputUno.addEventListener("focus", () => {
    iconoUno.classList.toggle("icono", false);
    iconoUno.classList.toggle("icono-animacion", true);
  });

  inputUno.addEventListener("blur", () => {
    if (inputUno.value == "") {
      iconoUno.classList.toggle("icono", true);
      iconoUno.classList.toggle("icono-animacion", false);
    }
  });

  // segundo input
  inputDos.addEventListener("focus", () => {
    iconoDos.classList.toggle("icono", false);
    iconoDos.classList.toggle("icono-animacion", true);
  });

  inputDos.addEventListener("blur", () => {
    if (inputDos.value == "") {
      iconoDos.classList.toggle("icono", true);
      iconoDos.classList.toggle("icono-animacion", false);
    }
  });

  // tercer input
  inputTres.addEventListener("focus", () => {
    iconoTres.classList.toggle("icono", false);
    iconoTres.classList.toggle("icono-animacion", true);
  });

  inputTres.addEventListener("blur", () => {
    if (inputTres.value == "") {
      iconoTres.classList.toggle("icono", true);
      iconoTres.classList.toggle("icono-animacion", false);
    }
  });

  // cuarto input
  inputCuatro.addEventListener("focus", () => {
    iconoCuatro.classList.toggle("icono-telefono", false);
    iconoCuatro.classList.toggle("icono-telefono-animacion", true);
  });

  inputCuatro.addEventListener("blur", () => {
    if (inputCuatro.value == "") {
      iconoCuatro.classList.toggle("icono-telefono", true);
      iconoCuatro.classList.toggle("icono-telefono-animacion", false);
    }
  });

  // quinto input
  inputCinco.addEventListener("focus", () => {
    iconoCinco.classList.toggle("icono-telefono", false);
    iconoCinco.classList.toggle("icono-telefono-animacion", true);
  });

  inputCinco.addEventListener("blur", () => {
    if (inputCinco.value == "") {
      iconoCinco.classList.toggle("icono-telefono", true);
      iconoCinco.classList.toggle("icono-telefono-animacion", false);
    }
  });

  //lo mismo que el anterior pero para editar
  document.querySelectorAll(".nuevaEspecialidadEditar").forEach((ele) => {
    ele.addEventListener("change", function () {
      //esta variable tiene el modal de edotar en concreto es para usar su id para saber que elemento de que modal en especifico estoy usando
      let modalId =
        this.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute(
          "id"
        );
      //caja del select de la especialidad
      let cajaSelectEspecialidadEditar = document.querySelector(
        `#${modalId} .uk-modal-body .formulario_editar .w-auto .d-flex .caja_select_especialidad`
      );
      //caja del input de la especialidad
      let cajaInputEspecialidadEditar = document.querySelector(
        `#${modalId} .uk-modal-body .formulario_editar .w-auto .d-flex .caja_input_especialidad`
      );

      if (this.checked) {
        cajaSelectEspecialidadEditar.classList.add("d-none");
        cajaInputEspecialidadEditar.classList.remove("d-none");
      } else {
        cajaSelectEspecialidadEditar.classList.remove("d-none");
        cajaInputEspecialidadEditar.classList.add("d-none");
      }
    });
  });

  let horaEntada = document.querySelectorAll(".hora-entrada"); //inputs de la hora de entrada
  let horaSalida = document.querySelectorAll(".hora-salida"); //inputs de la hora de salida

  //esto es para ocultar o mostrar los input del horaripo si el checkbox del dia es true

  //forEach usa 2 parametros el primero es el elemento y el segundo es el indice el indice se uso para acceder al input especifico que deseo usar
  document.querySelectorAll(".diaslaborables").forEach((ele, index) => {
    ele.addEventListener("change", function () {
      //evento

      //si es checkeado muestors los inputs de la hora
      if (this.checked) {
        horaEntada[index].classList.remove("d-none");
        horaSalida[index].classList.remove("d-none");

        //agregar el name
        horaEntada[index].setAttribute("name", "horaEntrada[]");
        horaSalida[index].setAttribute("name", "horaSalida[]");

        //si no los oculto
      } else {
        horaEntada[index].classList.add("d-none");
        horaSalida[index].classList.add("d-none");

        //para quitarle el name al formulario
        horaEntada[index].removeAttribute("name");
        horaSalida[index].removeAttribute("name");
      }
    });
  });

  //ajax para checkear los dias que el doctor registro en guardar
  async function traerDiasCheckeados(
    idDoctor,
    dia,
    inputHoraEntradaEditar,
    inputHoraSalidaEditar
  ) {
    try {
      let peticion = await fetch(
        "?c=controladorDoctores/selectDiasDoctorEditar&id_personal=" + idDoctor
      );
      let resultado = await peticion.json();
      console.log(resultado);
      resultado.forEach((res) => {
        if (res.id_horario == dia.value) {
          dia.setAttribute("checked", true);
          inputHoraEntradaEditar.setAttribute("name", "horaEntrada[]");
          inputHoraEntradaEditar.classList.remove("d-none");
          inputHoraEntradaEditar.classList.add("inputHorario");
          inputHoraEntradaEditar.value = res.horaDeEntrada;

          inputHoraSalidaEditar.setAttribute("name", "horaSalida[]");
          inputHoraSalidaEditar.classList.remove("d-none");
          inputHoraSalidaEditar.classList.add("inputHorario", "mt-2");
          inputHoraSalidaEditar.value = res.horaDeSalida;
        }
      });
    } catch (e) {
      console.log(e);
    }
  }

  //botones de editar
  document.querySelectorAll(".btn-js").forEach((ele) => {
    ele.addEventListener("click", function () {
      //traer el valor de el atributo del  boton  "uk-toggle"
      let atributoBotonEditar = this.getAttribute("uk-toggle").split(" ");

      let idModal = atributoBotonEditar[1].substring(1);

      let idDoctor = atributoBotonEditar[1].substring(22);

      let diasEditar = document.querySelectorAll(
        `#${idModal} .uk-modal-dialog .formulario_editar .input-modal .uk-accordion .li .uk-accordion-content .d-flex .mb-3 .form-check .div-js .diaslaborables`
      );

      let inputHoraEntradaEditar = document.querySelectorAll(
        `#${idModal} .uk-modal-dialog .formulario_editar .input-modal .uk-accordion .li .uk-accordion-content .d-flex .mb-3 .caja-js .caja-tiempo .hora-entrada`
      );

      let inputHoraSalidaEditar = document.querySelectorAll(
        `#${idModal} .uk-modal-dialog .formulario_editar .input-modal .uk-accordion .li .uk-accordion-content .d-flex .mb-3 .caja-js .caja-tiempo .hora-salida`
      );

      diasEditar.forEach((ele, index) => {
        traerDiasCheckeados(
          idDoctor,
          ele,
          inputHoraEntradaEditar[index],
          inputHoraSalidaEditar[index]
        );
      });
    });
  });

  //desd aqui cominza lo de los horarios del dotor
  console.log("horario");
  async function checkearDiasLaborablesDelDoctor(id_personal, checkeboxs) {
    try {
      let peticion = await fetch(
        "http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Doctores/buscarHorario/" +
          id_personal
      );
      let resultado = await peticion.json();
      console.log(resultado);

      let arrayDiasDb = [];
      // Iteramos sobre el array de checkboxes
      checkeboxs.forEach((che, index) => {
        console.log(che.value); // Muestra el valor del checkbox
        const encontrado = resultado.find((res) => res.id_horario == che.value);
        // Verificamos si el valor del checkbox está en el array resultado
        const isEqual = resultado.some((res) => res.id_horario == che.value); // Usamos some para verificar coincidencias
        console.log(isEqual);
        if (isEqual) {
          console.log("es igual"); // El valor está en resultado
          che.setAttribute("checked", true);

          let horaDeEntada =
            che.parentElement.parentElement.nextElementSibling.children[0]
              .children[0];
          let horaDeSalida =
            che.parentElement.parentElement.nextElementSibling.children[0]
              .children[1];
          console.log(encontrado);

          horaDeEntada.setAttribute("value", encontrado.horaDeEntrada);
          horaDeEntada.classList.remove("d-none");
          horaDeEntada.setAttribute("name", "horaEntrada[]");
          horaDeSalida.setAttribute("value", encontrado.horaDeSalida);
          horaDeSalida.classList.remove("d-none");
          horaDeSalida.setAttribute("name", "horaSalida[]");

          //llenamos los dias

          // Crear un nuevo input
          const input = document.createElement("input");
          input.type = "hidden"; // Tipo de input
          input.name = `diaAnterio[]`; // Nombre del input (opcional)
          input.value = encontrado.id_horario;
          // Agregar el input al contenedor
          console.log(
            document.querySelector(
              `.contenedroInputsOcultos${encontrado.id_personal}`
            )
          );

          document
            .querySelector(`.contenedroInputsOcultos${encontrado.id_personal}`)
            .appendChild(input);
        } else {
          console.log("no es igual"); // El valor no está en resultado
        }
      });

      console.log(arrayDiasDb);
    } catch (error) {
      console.log("lamenteblemente algo salio mal");
    }
  }

  //botones de editar
  document.querySelectorAll(".botonesEdi").forEach((ele, index) => {
    ele.addEventListener("click", function () {
      let idModal = ele.getAttribute("uk-toggle").split(" ")[1];
      let checkeboxs = document.querySelectorAll(
        `${idModal} .uk-modal-dialog .formulario_editar .input-modal .uk-accordion li  .uk-accordion-content .justify-content-between .justify-content-between .form-check div input`
      );

      checkearDiasLaborablesDelDoctor(
        ele.getAttribute("data-index"),
        checkeboxs
      );
    });
  });

  function convertirAHoraAMPM(hora) {
    const [horas, minutos] = hora.split(":");
    const horasNumerico = parseInt(horas, 10);
    const sufijo = horasNumerico >= 12 ? "PM" : "AM";
    const horas12 = horasNumerico % 12 || 12; // Convierte 0 a 12
    return `${horas12}:${minutos} ${sufijo}`;
  }

  async function consultarHorario(id_personal) {
    let peticion = await fetch(
      "http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Doctores/buscarHorario/" +
        id_personal
    );
    let resultado = await peticion.json();
    console.log(resultado);
    let html = "";

    resultado.forEach((res) => {
      document.getElementById(
        "titulo"
      ).innerText = ` Dr: ${res.nombre} ${res.apellido}`;
      const horaEntradaAMPM = convertirAHoraAMPM(res.horaDeEntrada);
      const horaSalidaAMPM = convertirAHoraAMPM(res.horaDeSalida);
      html += ` 
      <hr>
      <h5>Horarios</h5>
      <div class="input-group flex-nowrap">
      
                <h6 class="me-2 mb-1"> <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-capsule azul mb-1 me-1"
                        viewBox="0 0 16 16">
                        <path
                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>Dia Laborable:</h6>
                <p>${res.diaslaborables}</p>
            </div>
            <div class="input-group flex-nowrap">
                <h6 class="me-2 mb-1"> <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-capsule azul mb-1 me-1"
                        viewBox="0 0 16 16">
                        <path
                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>Hora De Entrada:</h6>
                <p>${horaEntradaAMPM}</p>
            </div>
            <div class="input-group flex-nowrap">
                <h6 class="me-2 mb-1"> <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-capsule azul mb-1 me-1"
                        viewBox="0 0 16 16">
                        <path
                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>Hora De Salida:</h6>
                <p>${horaSalidaAMPM}</p>
            </div> 
            <hr> `;
    });

    document.getElementById("cajaDeInfo").innerHTML = html;

    consultarServicios(id_personal);
  }

  async function consultarServicios(id_personal) {
    try {
      // Realizamos una petición para obtener los servicios del doctor
      let peticion = await fetch(
        "/Sistema-del--CEM--JEHOVA-RAFA/Doctores/serviciosDoctor/" + id_personal
      );

      let resultado = await peticion.json();
      let servicios = "";
      resultado.forEach((res) => {
        servicios += res.nombre_categoria + ",";
      });

      document.getElementById("servicios").innerText = servicios;
    } catch (error) {
      // Mostramos un mensaje de error en caso de que algo salga mal
      console.log("Lamentablemente algo salió mal: " + error);
    }
  }

  //consultar el horario del doctor
  document.querySelectorAll(".botonesInfo").forEach((btn) => {
    btn.addEventListener("click", function () {
      consultarHorario(this.getAttribute("data-index"));
    });
  });

  //si existe el comentario lo muestra y después de 8sg lo oculta
  if (comentario) {
    comentario.style.display = "block";
    setTimeout(function () {
      comentario.style.display = "none";
    }, 8000);
  }

  let passwordMostrar = document.getElementById("passwordMostrar");

  passwordMostrar.addEventListener("keyup", () => {
    activarMostrarContra.classList.remove("d-none");
    if (passwordMostrar.value == "") {
      activarMostrarContra.classList.add("d-none");
      desMostrarContra.classList.add("d-none");
    }
    if (passwordMostrar.type == "text" && passwordMostrar.value.length > 0) {
      desMostrarContra.classList.remove("d-none");
      activarMostrarContra.classList.add("d-none");
    }
  });

  const activarMostrarContra = document.getElementById("mostrarPassword");
  const desMostrarContra = document.getElementById("ocultarPassword");

  function mostrarContrasena() {
    if (passwordMostrar.type == "password") {
      passwordMostrar.type = "text";
      desMostrarContra.classList.remove("d-none");
      activarMostrarContra.classList.add("d-none");
    } else {
      passwordMostrar.type = "password";
      desMostrarContra.classList.add("d-none");
      activarMostrarContra.classList.remove("d-none");
    }
  }

  activarMostrarContra.addEventListener("click", mostrarContrasena);
  desMostrarContra.addEventListener("click", mostrarContrasena);
}); //fin de DOMContentLoaded
