addEventListener("DOMContentLoaded", () => {
  console.log("DOMContentLoaded De Factura Dios :( :)");
  // Creamos la variable donde van a estar los datos, y de una vez le ponemos una fila para probar
  console.log(window.location.href.includes("id_cita"));
  var data = [];
  var dataInsumo = [];
  let listaModalServicio = [];
  let listaModalInsumo = [];
  // console.log(data)

  var objInsumos = {
    id_insumo: "",
    nombreInsumo: "",
    cantidad: "",
    precio: "",
    subTotal: "",
  };
  // // Creamos las variables html que usaremos
  const tabla = document.getElementById("tbody");

  const forms = document.querySelector(".formularios");

  //insumos
  const inputInsumo = document.getElementById("inputInsumo");
  const insumosDisponibles = document.getElementById("insumosDisponibles");
  const precioInsumo = document.getElementById("precioInsumo");
  const cantidadInsumosIngresada = document.getElementById(
    "cantidadInsumosIngresada"
  );

  const tbodyInsumos = document.getElementById("tbody-insumos");

  //buscador
  const tablaSevicios = document.getElementById("cuerpoTablaServicios");


  //caja de todos los insumos
  const caja_insumos_a_seleccionar = document.querySelectorAll(".caja_insumos_a_seleccionar div")
  //input para buscar todos los insumos
  const buscadorDeTodosLosInsumos = document.getElementById("buscadorDeTodosLosInsumos")

  if (window.location.href.includes("id_cita")) {
    console.log("id_cita");
  } else {
    document
      .querySelectorAll(".btn-escondidos")
      .forEach((ele) => ele.classList.add("d-none"));
  }



  //buscador paciente cuando no tiene cita
  const buscarPaciente = async (formularioPaciente) => {
    try {
      const datos = new FormData(formularioPaciente);
      const contenido = { method: "POST", body: datos };
      let peticion = await fetch(
        "?c=controladorFactura/mostrarPaciente",
        contenido
      );
      let resultado = await peticion.json();
      console.log(resultado);
      if (resultado[0] != false) {
        resultado.forEach((res) => {
          document.getElementById(
            "datosPaciente"
          ).innerText = `PACIENTE: ${res.nombre} ${res.apellido}`;

          document.getElementById("myToastfactura").classList.add("d-none");
          //formCitas.classList.remove('d-none');

          if (window.location.href.includes("id_cita")) {
            console.log("id_cita");
          } else {
            let noCita = document.querySelectorAll(".no-cita");
            noCita[0].innerHTML = `<div class="fw-bolder ">CI: ${res.cedula}</div>`;
            noCita[1].innerHTML = `<div class="fw-bolder">PACIENTE: ${res.nombre} ${res.apellido}</div>`;
            document.getElementById("inputPaciente").value = res.id_paciente;
          }
        });
        document
          .getElementById("cajaBotones")
          .classList.remove("justify-content-end");
        document
          .getElementById("cajaBotones")
          .classList.add("justify-content-around");
        document.querySelectorAll(".btn-factura")[0].classList.remove("d-none");
        document.querySelectorAll(".btn-factura")[1].classList.remove("d-none");
      } else {
        document
          .getElementById("cajaBotones")
          .classList.remove("justify-content-around");
        document
          .getElementById("cajaBotones")
          .classList.add("justify-content-end");
        document.getElementById(
          "datosPaciente"
        ).innerText = `PACIENTE NO ENCONTRADO`;
        document.querySelectorAll(".btn-factura")[0].classList.add("d-none");
        document.querySelectorAll(".btn-factura")[1].classList.add("d-none");

        document.getElementById("myToastfactura").classList.remove("d-none");
        const toastElement = document.getElementById("myToastfactura");
        const toast = new bootstrap.Toast(toastElement, {
          autohide: false,
        });
        toast.show();
        document
          .querySelectorAll(".btn-escondidos")
          .forEach((ele) => ele.classList.add("d-none"));
      }
    } catch (error) {
      console.log(error);
    }
  };

  //buscar cuando el paciente una tiene cita
  const buscarPacienteConCita = async (formularioPaciente) => {
    const datos = new FormData(formularioPaciente);
    const contenido = { method: "POST", body: datos };
    console.log(contenido);

    let peticion = await fetch(
      "?c=controladorFactura/mostrarPacienteConCita",
      contenido
    );
    let resultado = await peticion.json();
    console.log(resultado);
    if (resultado.length > 0) {
      console.log("2");
      let url = window.location.href;

      let id_cita = "";
      resultado.forEach((res) => {
        id_cita = `&id_cita=${res.id_cita}`;
      });
      window.location.href = url.concat(id_cita);
    } else {
      buscarPaciente(formularioPaciente);
    }
  };




  if (window.location.href.includes("id_cita")) {
    console.log("si");
  } else if (window.location.href.includes("idH")) {
    console.log("hospitalizacion");
  } else {
    const formularioPaciente = document.getElementById("form-buscador-factura");
    formularioPaciente.addEventListener("submit", function (e) {
      e.preventDefault();
      //buscarPaciente(formularioPaciente);
      buscarPacienteConCita(formularioPaciente);
    });
  }

  //buscar servicio por categoria
  selectBuscarCategoria.addEventListener("keyup", function () {
    const valorBusqueda = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();


    tablaSevicios.querySelectorAll(".tr").forEach(ele => {



      if (ele.children[1].innerText.includes(valorBusqueda)) {
        ele.classList.remove("d-none");

      } else {
        ele.classList.add("d-none");

      }


    })


  })






  // // impedimos que los formularios recarguen la pagina y hacemos las cosas que queremos
  calcularTotal();

  const mostrarVariosServicios = () => {
    let html = ``;
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    listaModalServicio.forEach((element, index) => {
      html += `
        <tr class="border-top ">
        <td class="border-top text-center"> ${index + 1}</td>
        <td class="border-top border-start text-center"> ${element["servicio"]}</td>
        <td class="border-top border-start text-center"> ${element["doctor"]}</td>
        <td class="border-top border-start text-center">${element["precio"]} BS</td>

        <td class="border-top border-start text-center">

        <button class="eliminar btn btn-tabla mt-1" data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></button>
        <td>
        <tr>`;
    });
    document.getElementById("tbody_servicios").innerHTML = html;

    document.querySelectorAll(".eliminar").forEach((ele) => {
      ele.addEventListener("click", function () {
        let idBoton =
          listaModalServicio[parseInt(this.getAttribute("data-index"))]
            .id_servicioMedico;

        const botonId = document.getElementById(`${idBoton}`);
        botonId.parentElement.parentElement.classList.remove("d-none");

        listaModalServicio.splice(parseFloat(this.dataset["index"]), 1);
        mostrarVariosServicios();

        console.log(listaModalServicio.length);

        if (listaModalServicio.length > 0) {
          document.getElementById("siguiente").classList.remove("d-none");
        } else {
          document.getElementById("siguiente").classList.add("d-none");
          document.getElementById("insertarServicio").classList.add("d-none");
        }
      });
    });
  };

  //funcion para pasar de la lista de servicio para el modal de confirmacion
  const insertarVariosServicios = (
    id_servicioMedico,
    servicio,
    doctor,
    precio
  ) => {
    const nuevoObj = {
      id_servicioMedico: id_servicioMedico,
      servicio: servicio,
      doctor: doctor,
      precio: parseFloat(precio),
    };
    console.log("nuevoObj");
    console.log(nuevoObj);
    listaModalServicio.push(nuevoObj);
    console.log(listaModalServicio);
    mostrarVariosServicios();
  };

  document.querySelectorAll(".insertar_servicio").forEach((ele, index) => {
    ele.setAttribute("data-index", index);
    ele.addEventListener("click", function () {
      // Obtener la fila padre del checkbox
      const fila = this.closest("tr");
      console.log(fila);
      const id_servicioMedico = this.getAttribute("id");
      console.log(id_servicioMedico);
      const servicio = fila.children[1].innerText; // Columna Servicio
      const doctor = fila.children[2].innerText; // Columna Doctor
      const precio = fila.children[3].innerText; // Columna Precio

      insertarVariosServicios(id_servicioMedico, servicio, doctor, precio);

      fila.classList.add("d-none");

      if (listaModalServicio.length > 0) {
        document.getElementById("siguiente").classList.remove("d-none");
        document.getElementById("insertarServicio").classList.remove("d-none");
      } else {
        document.getElementById("siguiente").classList.add("d-none");
      }
    });
  });

  forms.addEventListener("submit", function (f) {
    f.preventDefault();
    console.log("manejador de formulario");

    console.log(listaModalServicio);

    listaModalServicio.forEach((lista) => {
      console.log(lista);
      data.push(lista);
    });

    console.log(data);
    listaModalServicio = [];
    mostrarVariosServicios();
    // actualizamos la tabla
    mostrarCosas();
    //actualizamos el modal de confirmacion
    mostrarConfirmacion();

    document.querySelectorAll(".tr-desparecer").forEach((ele) => {
      ele.classList.remove("d-none");
      console.log(ele);
    });
  });

  // // Funcion para actualizar la tabla
  function mostrarCosas() {
    calcularTotal();
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    data.forEach((element, index) => {
      html += `
        <tr class="border-top">
        <td class="border-top"><div class="fw-bolder">SERVICIO :</div> ${element["servicio"]}</td>
        <td class="border-top"><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
        <td class="border-top"><div class="fw-bolder">PRECIO:</div>${element["precio"]} BS</td>
        <td class="border-top"></td>

        <td class="border-top">

        <button class="eliminar btn btn-tabla mt-1" data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></button>
        <td>
        <tr>`;
    });
    tabla.innerHTML = html;
    // Añadimos los eventos a los botones de eliminar
    document.querySelectorAll(".eliminar").forEach((ele) => {
      ele.addEventListener("click", function () {
        console.log(this);
        data.splice(parseFloat(this.dataset["index"]), 1);
        mostrarCosas();
        mostrarConfirmacion();
      });
    });

    //funncion para mostrar los botones de vaciar y siguiente
    ocultarBotones();
  }


    const tbodyinsertarInsumo = document.getElementById("cuerpoTablaInsumos")
    //codigo para manejar las cajas de insumos en el modal



    caja_insumos_a_seleccionar.forEach(ele=>{
      
      ele.addEventListener("click",function(){

        if(ele.classList.contains("insumo_no_seleccionado")){
          ele.classList.remove("insumo_no_seleccionado")
          ele.classList.add("insumo_seleccionado")
        }else{
          ele.classList.remove("insumo_seleccionado")
          ele.classList.add("insumo_no_seleccionado")
        }
        //si ha uno o mas cuadros con la clase insumo_seleccionado es por que al menos un insumo fue selecciona 
        if (document.querySelectorAll(".insumo_seleccionado").length > 0) {
          //Aparece el boton
          document.getElementById("btnModalInsumos1").classList.remove("d-none")
        } else {
          //Si no desaparece el boton
          document.getElementById("btnModalInsumos1").classList.add("d-none")
        }
      })
    })


    //codigo para buscar todos los insumos
    buscadorDeTodosLosInsumos.addEventListener("keyup", function(){
      caja_insumos_a_seleccionar.forEach(ele=>{
        if(ele.innerHTML.split("  ")[0].toLowerCase().includes(this.value.toLowerCase())){
          ele.classList.remove("d-none");
        }else{
          ele.classList.add("d-none");
        }
      })

    })

    //funcion al darle clic al boton siguiente de le modal de insumos 1
    document.getElementById("btnModalInsumos1").addEventListener("click", function() {
      
      let cajas_seleccionadas = document.querySelectorAll(".insumo_seleccionado");
      let trModalInsums = document.querySelectorAll("#cuerpoTablaInsumos tr");

      trModalInsums.forEach(tr => {
        //La variable incia en falso por que cuando incia el bucle no hay coincidencias
          let insumoEncontrado = false;
          //se hace otro bucle de todas las cajas de insumos
          cajas_seleccionadas.forEach(caja => {
              //Si es texto de la caja coincide con alguna fila de la tabla se cambia el valor a true
              if (caja.innerText.split(" ")[0] === tr.children[1].innerText.trim()) {
                  insumoEncontrado = true;
              }
          });

          //Dependiendo si la variable es true o false se oculta o muestra la tabla
          if (insumoEncontrado) {
              //console.log(`Coincidencia encontrada para ${tr.children[1].innerText.trim()}`);
              tr.classList.remove("d-none")
          } else {
              //console.log(`No se encontró coincidencia para ${tr.children[1].innerText.trim()}`);
              tr.classList.add("d-none")
          }
      });
    });








  document
    .querySelector(".formularios-insumos")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      console.log("manejador de formulario insumo");

      console.log(listaModalInsumo);

      let nuevaCantidad = 0;

      listaModalInsumo.forEach((lista, index) => {
        console.log("e")
        console.log(lista);
        dataInsumo.push(lista);

        // let insumo = dataInsumo.find(i => i.nombreInsumo === lista.nombreInsumo);
        // console.log(insumo

        //insumo.cantidad -=
      });

      // actualizamos la tabla
      mostrarInsumo();

      console.log(dataInsumo);
      listaModalInsumo = [];
      mostrarVariosInusmos();

      //actualizamos el modal de confirmacion
      mostrarConfirmacion();

      document.querySelectorAll(".tr-desparecer-insumo").forEach((ele) => {
        ele.classList.remove("d-none");
        console.log(ele);
      });

      document
        .querySelectorAll(".inputs-cantidad-insumos")
        .forEach((ele) => (ele.value = ""));
      document
        .querySelectorAll(".insertar_insumo")
        .forEach((ele) => ele.classList.add("d-none"));

      let valorDeIdInsumo = document.querySelectorAll(`#tbody-insumos tr th`);
      let valorDeNombreInsumo = document.querySelectorAll(
        `#tbody-insumos tr .nombre`
      );

      // let canti = 0;
      // dataInsumo.forEach((ele, index)=>{
      //     console.log(dataInsumo[index])
      //     console.log(ele.id_insumo)
      //     console.log(valorDeIdInsumo[index].innerText)

      //     let nombreInsumo = valorDeNombreInsumo[index].innerText.replace("INSUMO:", "").trim()

      //    if(ele.id_insumo == valorDeIdInsumo[index].innerText && nombreInsumo == dataInsumo[index].nombreInsumo){
      //     console.log(nombreInsumo)
      //     console.log(dataInsumo[index].nombreInsumo)
      //     canti += parseFloat(ele.cantidad)
      //     console.log(canti)
      //     console.log(nombreInsumo.length)
      //     console.log(dataInsumo[index].nombreInsumo.length)

      //     let button = document.querySelectorAll(`#cuerpoTablaInsumos tr td `)[5].children[0];

      //     const insumo = dataInsumo.find(insumo => insumo.id_insumo == parseInt(button.getAttribute("id")));
      //     console.log(insumo)
      //    }
      // })
    });

  //evento para que cada vez tecle al input de la cantidad se actualiza los insumos disponibles
  document.querySelectorAll(".inputs-cantidad-insumos").forEach((ele) => {
    ele.addEventListener("keyup", function () {
      let cantidadDisponible = parseInt(
        this.parentElement.parentElement.children[2].innerText
      );
      let botonDeAnadir =
        this.parentElement.parentElement.children[6].children[0];

      if (
        this.value <= cantidadDisponible &&
        this.value != "" &&
        this.value > 0
      ) {
        botonDeAnadir.classList.remove("d-none");
      } else {
        botonDeAnadir.classList.add("d-none");
      }
    });
  });








  //mostrar los insumos en el modal
  const mostrarVariosInusmos = () => {
    let html = ``;
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    listaModalInsumo.forEach((element, index) => {
      html += `
        <tr class="border-top ">
        <td class="border-top"> ${index + 1}</td>
        <td class="border-top border-start text-center"> ${element["nombreInsumo"]}</td>
        <td class="border-top border-start text-center"> ${element["cantidad"]}</td>
        <td class="border-top border-start text-center">${element["precio"]} BS</td>
        <td class="border-top border-start text-center">${element["numero_de_lote"]}</td>
        <td class="border-top border-start text-center">${element["subTotal"]} BS</td>

        <td class="border-top border-start">

        <button class="eliminar btn btn-tabla mt-1" data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></button>
        <td>
        <tr>`;
    });
    document.getElementById("tbody_insumos").innerHTML = html;

    document.querySelectorAll(".eliminar").forEach((ele) => {
      ele.addEventListener("click", function () {
        let idBoton =
          listaModalInsumo[parseInt(this.getAttribute("data-index"))].id_insumo;

        const botonId = document.getElementById(`${idBoton}`);
        botonId.parentElement.parentElement.classList.remove("d-none");

        listaModalInsumo.splice(parseFloat(this.dataset["index"]), 1);
        mostrarVariosInusmos();

        if (listaModalInsumo.length > 0) {
          document.getElementById("siguienteInsumo").classList.remove("d-none");
        } else {
          document.getElementById("siguienteInsumo").classList.add("d-none");
          document.getElementById("insertarInsumo").classList.add("d-none");
        }
      });
    });
  };

  //funcion para insertar varios insumos a la vez
  const insertarVariosInsumos = (id_insumo, nombreInsumo, cantidad, precio,numero_de_lote) => {
    let subTotalRedondeado = (parseFloat(cantidad) * parseFloat(precio)).toFixed(2);
    const nuevoObjInsumo = {
      id_insumo: id_insumo,
      nombreInsumo: nombreInsumo,
      cantidad: cantidad,
      numero_de_lote:numero_de_lote,
      precio: parseFloat(precio),
      subTotal: subTotalRedondeado,
    };

    listaModalInsumo.push(nuevoObjInsumo);
    console.log(listaModalInsumo);
    mostrarVariosInusmos();

    if (listaModalInsumo.length > 0) {
      document.getElementById("siguienteInsumo").classList.remove("d-none");
      document.getElementById("insertarInsumo").classList.remove("d-none");
    } else {
      document.getElementById("siguienteInsumo").classList.add("d-none");
      document.getElementById("insertarInsumo").classList.add("d-none");
    }
  };

  //boton para añadir los insumos
  document.querySelectorAll(".insertar_insumo").forEach((ele) => {
    ele.addEventListener("click", function () {
      const fila = this.closest("tr");
      console.log(fila);
      const id_insumo = this.getAttribute("id");
      const nombreInsumo = fila.children[1].innerText; // Columna Insumo
      const precio = fila.children[3].innerText; // Columna precio
      const numero_de_lote = fila.children[4].innerText; // Columna numero_de_lote
      const cantidad = fila.children[5].children[0].value; // Columna cantidad

      insertarVariosInsumos(id_insumo, nombreInsumo, cantidad, precio,numero_de_lote);
      fila.classList.add("d-none");
    });
  });

  function mostrarInsumo() {
    calcularTotal();
    let html = ``;
    dataInsumo.forEach((element, index) => {
      html += `
        <tr class="border-top tr">
        <th class="id_insumo_escondido d-none">${element["id_insumo"]}</th>
        <td class="border-top nombre"><div class="fw-bolder">INSUMO:</div> ${element["nombreInsumo"]}</td>
        <td class="border-top"><div class="fw-bolder">CANTIDAD:</div> ${element["cantidad"]}</td>
        <td class="border-top"><div class="fw-bolder">PRECIO:</div>${element["precio"]} BS</td>
        <td class="border-top"><div class="fw-bolder">LOTE:</div>${element["numero_de_lote"]}</td>
        <td class="border-top"><div class="fw-bolder">SUB-TOTAL:</div>${element["subTotal"]} BS</td>
        <td class="border-top"></td>

        <td class="border-top">

        <button class="eliminar-insumo btn btn-tabla mt-1" style="margin-right: 7px;" data-index=${index}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></button>
        <td>
        <tr>`;
    });
    tbodyInsumos.innerHTML = html;
    // Añadimos los eventos a los botones de eliminar
    document.querySelectorAll(".eliminar-insumo").forEach((ele) => {
      ele.addEventListener("click", function () {
        console.log(this);
        dataInsumo.splice(parseFloat(this.dataset["index"]), 1);
        mostrarInsumo();
        mostrarConfirmacion();
      });
    });

    //funncion para mostrar los botones de vaciar y siguiente
    ocultarBotones();
    document.querySelector(".formularios-insumos").reset();
    mostrarConfirmacion();
  }





  

  function cantidadesDeInsumos() {
    console.log("funcion");
    if (dataInsumo.length == 0) {
      console.log("vacio");
    } else {
      let total = 0;
      const totales = {};
      dataInsumo.forEach((ele, index) => {
        let boton = document.querySelector(
          `#cuerpoTablaInsumos tr .caja-boton .btn${ele.id_insumo}`
        );

        let cantidad = parseInt(
          boton.parentElement.parentElement.children[2].innerText
        );
        let nombre = boton.parentElement.parentElement.children[1].innerText;

        if (!totales[ele.nombreInsumo]) {
          totales[ele.nombreInsumo] = 0;
        }

        totales[ele.nombreInsumo] += parseInt(ele.cantidad);
        //console.log(boton[index])
        //que de aqui
        console.log(totales["Vitamina C"]);
      });

      return totales;
    }
  }

  //evento para vaciar la tabla
  document.getElementById("vaciarTabla").addEventListener("click", function () {
    data = [];
    dataInsumo = [];
    mostrarCosas();
    mostrarInsumo();
    // document.getElementById('tablaBODYDB').innerHTML = ``;
    document.getElementById("totalFactura").value = "";
  });

  //funcion para calcular el total
  function calcularTotal() {
    let totalFactura = parseFloat(
      document.getElementById("inputTotalCita").value
    );
    console.log("total:");
    let subTotal = 0;
    let insumos = 0;
    for (let i = 0; i < data.length; i++) {
      subTotal += data[i]["precio"];
    }
    for (let i = 0; i < dataInsumo.length; i++) {
      insumos += dataInsumo[i]["precio"] * dataInsumo[i]["cantidad"];
    }
    let total = totalFactura + subTotal + insumos;

    document.getElementById("totalFactura").value = total;
    document.getElementById("totalDeConfirmacion").innerText = `${total} BS`;
    document.getElementById("inputTotalDeConfirmacion").value = total;
  }
  //esto es para ocultar los botones de siguiente y  vaciar
  function ocultarBotones() {
    if (data.length > 0 || dataInsumo.length > 0) {
      document.querySelectorAll(".btn-escondidos").forEach((ele) => {
        ele.classList.remove("d-none");
      });
    } else {
      document.querySelectorAll(".btn-escondidos").forEach((ele) => {
        ele.classList.add("d-none");
      });
    }
  }

  //boton del modal de tio de pago
  const tiposDePago = document.querySelectorAll(".tiposDePago");
  const btnTipoDePago = document.querySelector("#btnTipoDePago");
  //inputs de la validacion
  const inputsDeValidacion = document.querySelectorAll(".inputsDeValidacion");
  //label de los inputs de validacion
  const labelForma1 = document.getElementById("forma1");
  const labelForma2 = document.getElementById("forma2");
  const labelForma3 = document.getElementById("forma3");
  //input de la referencia
  const referencia = document.getElementById("referencia");
  //funcion por si es 2 formas
  function dosFormas(forma1, forma2) {
    labelForma1.innerText = forma1;
    labelForma2.innerText = forma2;
    btnTipoDePago.classList.remove("d-none");
    inputsDeValidacion[2].classList.add("d-none");
    labelForma3.innerText = "";
    pagosDeConfirmacion.innerText = forma1;
    pagosDeConfirmacion2.innerText = forma2;
    pagosDeConfirmacion3.innerText = "";
    inputsDePago[1].setAttribute("name", "formasDePago[]");
    inputsDeMontos[1].setAttribute("name", "montosDePago[]");
    if (forma1 == "Efectivo" && forma2 == "Divisas") {
      referencia.classList.add("d-none");
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    } else if (forma1 == "Efectivo" && forma2 == "PagoMovil") {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[1].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Transferencia";
      pagosDeConfirmacion2.innerText = "Transferencia";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.add("d-none");
    } else if (forma1 == "Efectivo" && forma2 == "Transferencia") {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[2].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Pago Movil";
      pagosDeConfirmacion2.innerText = "Pago Movil";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.add("d-none");
    } else if (forma1 == "Divisas" && forma2 == "PagoMovil") {
      inputsDePago[0].value = tiposDePago[3].value;
      inputsDePago[1].value = tiposDePago[1].value;
      referencia.classList.remove("d-none");
      labelForma2.innerText = "Transferencia";
      pagosDeConfirmacion2.innerText = "Transferencia";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma1.innerText = "Divisas en BS";
    } else if (forma1 == "Divisas" && forma2 == "Transferencia") {
      inputsDePago[0].value = tiposDePago[3].value;
      inputsDePago[1].value = tiposDePago[2].value;
      referencia.classList.remove("d-none");
      console.log(labelForma1.innerText);
      labelForma2.innerText = "Pago Movil";
      pagosDeConfirmacion2.innerText = "Pago Movil";
      inputsDeValidacion[0].classList.remove("d-none");
      inputsDeValidacion[1].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma1.innerText = "Divisas en BS";
    }
  }

  //funcion por si son tres formas de pago
  function tresFormas(forma1, forma2, forma3) {
    labelForma1.innerText = forma1;
    labelForma2.innerText = forma2;
    labelForma3.innerText = forma3;
    btnTipoDePago.classList.remove("d-none");
    pagosDeConfirmacion.innerText = forma1;
    pagosDeConfirmacion2.innerText = forma2;
    pagosDeConfirmacion3.innerText = forma3;
    inputsDePago[2].setAttribute("name", "formasDePago[]");
    inputsDeMontos[2].setAttribute("name", "montosDePago[]");
    if (
      forma1 == "Efectivo" &&
      forma2 == "Divisas" &&
      forma3 == "Transferencia"
    ) {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      inputsDePago[2].value = tiposDePago[2].value;
      labelForma3.innerText = "Pago Movil";
      pagosDeConfirmacion3.innerText = "Pago Movil";
      referencia.classList.remove("d-none");
      inputsDeValidacion[2].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    } else {
      inputsDePago[0].value = tiposDePago[0].value;
      inputsDePago[1].value = tiposDePago[3].value;
      inputsDePago[2].value = tiposDePago[1].value;
      labelForma3.innerText = "Transferencia";
      pagosDeConfirmacion3.innerText = "Transferencia";
      referencia.classList.remove("d-none");
      inputsDeValidacion[2].classList.remove("d-none");
      btnValidacion.classList.add("d-none");
      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      labelForma2.innerText = "Divisas en BS";
    }
  }
  //Aqui iran los nombres de tipos de pagos
  const pagosDeConfirmacion = document.getElementById("pagosDeConfirmacion");
  const pagosDeConfirmacion2 = document.getElementById("pagosDeConfirmacion2");
  const pagosDeConfirmacion3 = document.getElementById("pagosDeConfirmacion3");
  //inputs De Formas De pago
  const inputsDePago = document.querySelectorAll("#divInputPago input");

  //inputs de montos de los pagos
  const inputsDeMontos = document.querySelectorAll("#divMontosPago input");
  //funcion para realizar las debidas validaciones de los tipos de pago
  function checkearTiposDePago(metodosPago) {
    let efectivo = metodosPago[0];
    let pagoMovil = metodosPago[1];
    let transferencia = metodosPago[2];
    let divisa = metodosPago[3];
    btnTipoDePago.setAttribute("data-bs-toggle", "modal");
    //cuando elige solo efectivo
    if (
      efectivo.checked &&
      pagoMovil.checked == false &&
      transferencia.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
      btnTipoDePago.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Efectivo";
      inputsDePago[0].value = efectivo.value;

      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      console.log(pagosDeConfirmacion);
      //aqui se le da el valor del monto al input

      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");

      document.getElementById("p_referencia").innerText = "";
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
      document
        .getElementById("referencia_confirmar")
        .setAttribute("name", "referencia");
      //cuando elige solo pago movil
    } else if (
      pagoMovil.checked &&
      efectivo.checked == false &&
      transferencia.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      btnTipoDePago.classList.remove("d-none");
      inputsDeValidacion[0].classList.add("d-none");
      inputsDeValidacion[1].classList.add("d-none");
      referencia.classList.remove("d-none");
      btnValidacion.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Transferencia";
      inputsDePago[0].value = pagoMovil.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");
      //cuando elige solo transferencia
      document
        .querySelector(".suguiente")
        .addEventListener("click", function () {
          document.getElementById("p_referencia").innerText =
            "Ref " + referencia.value;
          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
      console.log(document.getElementById("p_referencia").innerText);
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
    } else if (
      transferencia.checked &&
      efectivo.checked == false &&
      pagoMovil.checked == false &&
      divisa.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      btnTipoDePago.classList.remove("d-none");
      inputsDeValidacion[0].classList.add("d-none");
      inputsDeValidacion[1].classList.add("d-none");
      referencia.classList.remove("d-none");
      btnValidacion.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Pago Movil";
      inputsDePago[0].value = transferencia.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");
      document
        .querySelector(".suguiente")
        .addEventListener("click", function () {
          document.getElementById("p_referencia").innerText =
            "Ref " + referencia.value;
          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
      document.getElementById("equivalenteDivisas").classList.add("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //cuando elige solo divisas
    } else if (
      divisa.checked &&
      efectivo.checked == false &&
      pagoMovil.checked == false &&
      transferencia.checked == false
    ) {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-confirmacion");
      btnTipoDePago.classList.remove("d-none");
      pagosDeConfirmacion.innerText = "Divisa";
      inputsDePago[0].value = divisa.value;
      pagosDeConfirmacion.innerText =
        pagosDeConfirmacion.innerText +
        " " +
        document.getElementById("totalDeConfirmacion").innerText;
      inputsDeMontos[0].value = document
        .getElementById("totalDeConfirmacion")
        .innerText.replace("BS", "");

      document.getElementById("p_referencia").innerText = "";

      document.getElementById("equivalenteDivisas").classList.remove("d-none");
      pagosDeConfirmacion2.innerText = "";
      pagosDeConfirmacion3.innerText = "";

      //referencia
      document.getElementById("referencia_confirmar").setAttribute("name", "");
    } else {
      btnTipoDePago.setAttribute("data-bs-target", "#modal-validacion");
      if (
        efectivo.checked &&
        divisa.checked &&
        pagoMovil.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Efectivo", "Divisas");

        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });

        document.getElementById("p_referencia").innerText = "";

        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");

        pagosDeConfirmacion3.innerText = "";

        //referencia
        document
          .getElementById("referencia_confirmar")
          .setAttribute("name", "");
      } else if (
        efectivo.checked &&
        pagoMovil.checked &&
        divisa.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Efectivo", "PagoMovil");

        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Transferencia: " + inputsDeValidacion[1].value + " BS";
          document.getElementById("p_divisas").innerText = "";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document.getElementById("equivalenteDivisas").classList.add("d-none");

        pagosDeConfirmacion3.innerText = "";
      } else if (
        efectivo.checked &&
        transferencia.checked &&
        divisa.checked == false &&
        pagoMovil.checked == false
      ) {
        dosFormas("Efectivo", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion2.innerText =
            "Pago Movil: " + inputsDeValidacion[1].value + " BS";
          document.getElementById("p_divisas").innerText = "";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document.getElementById("equivalenteDivisas").classList.add("d-none");

        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        pagoMovil.checked &&
        efectivo.checked == false &&
        transferencia.checked == false
      ) {
        dosFormas("Divisas", "PagoMovil");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Transferencia: " + inputsDeValidacion[0].value + " BS";
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        transferencia.checked &&
        efectivo.checked == false &&
        pagoMovil.checked == false
      ) {
        dosFormas("Divisas", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Pago Movil: " + inputsDeValidacion[0].value + " BS";
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;

            //referencia
            document.getElementById("referencia_confirmar").value =
              document.getElementById("referencia").value;
            document
              .getElementById("referencia_confirmar")
              .setAttribute("name", "referencia");
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        //apartir de aqui empiezan los casos que son 3 formas
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        transferencia.checked &&
        efectivo.checked &&
        pagoMovil.checked == false
      ) {
        tresFormas("Efectivo", "Divisas", "Transferencia");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion3.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion3.innerText =
            "Pago Movil: " + inputsDeValidacion[2].value + " BS";
          console.log(inputsDeValidacion[2].value);
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
          inputsDeMontos[2].value = inputsDeValidacion[2].value;

          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
        pagosDeConfirmacion3.innerText = "";
      } else if (
        divisa.checked &&
        pagoMovil.checked &&
        efectivo.checked &&
        transferencia.checked == false
      ) {
        tresFormas("Efectivo", "Divisas", "Pago Movil");
        btnValidacion.addEventListener("click", function () {
          pagosDeConfirmacion.innerText = "";
          pagosDeConfirmacion2.innerText = "";
          pagosDeConfirmacion3.innerText = "";
          pagosDeConfirmacion.innerText =
            "Divisas En Bs: " + inputsDeValidacion[1].value;
          pagosDeConfirmacion2.innerText =
            "Efectivo: " + inputsDeValidacion[0].value + " BS";
          pagosDeConfirmacion3.innerText =
            "Tranferencia: " + inputsDeValidacion[2].value + " BS";
          console.log(inputsDeValidacion[2].value);
          document.getElementById("p_divisas").innerText =
            "Equivalente en Divisas: " +
            document.getElementById("equivalenteDivisas").value +
            " $";

          inputsDeMontos[0].value = inputsDeValidacion[0].value;
          inputsDeMontos[1].value = inputsDeValidacion[1].value;
          inputsDeMontos[2].value = inputsDeValidacion[2].value;

          //referencia
          document.getElementById("referencia_confirmar").value =
            document.getElementById("referencia").value;
          document
            .getElementById("referencia_confirmar")
            .setAttribute("name", "referencia");
        });
        document
          .querySelector(".suguiente")
          .addEventListener("click", function () {
            document.getElementById("p_referencia").innerText =
              "Ref " + referencia.value;
          });
        document
          .getElementById("equivalenteDivisas")
          .classList.remove("d-none");
      } else {
        btnTipoDePago.classList.add("d-none");
      }
    }
  }
  //aqui se ejecuta el checkeo de los tipos de  llamando a la funcion checkearTiposDePago
  tiposDePago.forEach((tipoDePago) => {
    tipoDePago.addEventListener("change", function () {
      checkearTiposDePago(tiposDePago);
    });
  });
  //boton del modal de validacion
  const btnValidacion = document.getElementById("btnValidacion");
  //funcion para validar el precio de las 2 formas en el modal de validacion
  function dosPrecios(precio1, precio2) {
    let precioInt1 = parseFloat(precio1.value) || 0;
    let precioInt2 = parseFloat(precio2.value) || 0;
    let total = parseFloat(document.getElementById("totalFactura").value) || 0;
    let totalInput = precioInt1 + precioInt2;
    if (totalInput == total) {
      btnValidacion.classList.remove("d-none");
    } else {
      btnValidacion.classList.add("d-none");
    }
  }
  //funcion para validar el precio de las 3 formas en el modal de validacion
  function tresPrecios(precio1, precio2, precio3) {
    let precioInt1 = parseFloat(precio1.value) || 0;
    let precioInt2 = parseFloat(precio2.value) || 0;
    let precioInt3 = parseFloat(precio3.value) || 0;
    let total = parseFloat(document.getElementById("totalFactura").value) || 0;
    let totalInput = precioInt1 + precioInt2 + precioInt3;
    if (totalInput == total) {
      btnValidacion.classList.remove("d-none");
    } else {
      btnValidacion.classList.add("d-none");
    }
  }
  //aqui se usa un evento para validar los precios de los input de el modal de validacion
  inputsDeValidacion.forEach((inputDeValidacion) => {
    inputDeValidacion.addEventListener("keyup", function () {
      if (inputsDeValidacion[2].classList.contains("d-none")) {
        dosPrecios(inputsDeValidacion[0], inputsDeValidacion[1]);
      } else {
        tresPrecios(
          inputsDeValidacion[0],
          inputsDeValidacion[1],
          inputsDeValidacion[2]
        );
      }
    });
  });
  //funcion para llenar el modal de confirmacion
  function mostrarConfirmacion() {
    const tbodyDelModal = document.getElementById("tbodyDelModal");
    // Aqui pondremos el codigo HTML que tendra el body de la tabla
    let html = ``;
    let htmlInsumos = "";
    data.forEach((element, index) => {
      html += `
        <tr>
        <td><input type="hidden" name="servicios[]" value="${element["id_servicioMedico"]}">
        <div class="fw-bolder">S/E:</div>${element["servicio"]}</td>
        <td><div class="fw-bolder">DOCTOR:</div> ${element["doctor"]}</td>
        <td><div class="fw-bolder">PRECIO:</div> ${element["precio"]} BS</td>
        <td>
        <tr>`;
    });

    dataInsumo.forEach((element, index) => {
      htmlInsumos += `
        <tr>
        <td><input type="hidden" name="insumos[]" value="${element["id_insumo"]}">
        <div class="fw-bolder">INSUMO:</div>${element["nombreInsumo"]}</td>
        <td><input type="hidden" name="cantidad[]" value="${element["cantidad"]}"><div class="fw-bolder">CANTIDAD</div> ${element["cantidad"]}</td>
        <td><div class="fw-bolder">PRECIO:</div> ${element["precio"]} BS</td>
        <td><input type="hidden" name="numero_de_lote[]" value="${element["numero_de_lote"]}"><div class="fw-bolder">LOTE</div> ${element["numero_de_lote"]}</td>
        <td class="border-top"><div class="fw-bolder">SUB-TOTAL:</div>${element["subTotal"]} BS</td>
        <td>
        <tr>`;
    });
    // Recorremos la lista de arriba y añadimos los datos a la variable html
    tbodyDelModal.innerHTML = html;
    if (window.location.href.includes("idH")) {
      console.log("si es hospitalizacion")
    } else {
      document.getElementById("tbodyInsumos").innerHTML = htmlInsumos;
    }

    console.log(data);
  }

  let urlActual = window.location.href;

  if (urlActual.includes("id_cita")) {
    // document.getElementById("desplegarAyudafactura").classList.add("d-none");
    // document
    //   .getElementById("desplegarAyudafacturaIDCita")
    //   .classList.remove("d-none");
    // document
    //   .getElementById("cuerpoTablaConfirmaroperacion")
    //   .classList.remove("d-none");
  } else if (urlActual.includes("idH")) {

  } else {
    document.getElementById("desplegarAyudafactura").classList.remove("d-none");
    document
      .getElementById("desplegarAyudafacturaIDCita")
      .classList.add("d-none");
    document
      .getElementById("cuerpoTablaConfirmaroperacion")
      .classList.add("d-none");
  }


// .............. buscador de insumos en la vista ................
  let inputBuscI = document.querySelector("#inputBuscarI");
  const notifi = document.querySelector(".notifiI");

  // buscador de insumos
  function buscarI() {
      let contadorI = 0;
      let contadorINo = 0;

      // selecciono todos los tr de la tabla
      const filas = document.querySelectorAll(".tbodyI tr");
      // recolecto el nombre del input
      let nombreInpI = inputBuscI.value;
      // se convierte en minúscula
      nombreInpI = nombreInpI.toLowerCase();

      // recorro las filas de la tabla
      filas.forEach((fila) => {
          // cuenta los síntomas que existen.
          contadorI = contadorI + 1;

          let nombre = fila.children[1].innerText;
          let lote = fila.children[4].innerText;
          // se convierte en minúscula
          nombre = nombre.toLowerCase();
          // verifico si el nombre existe
          if (nombre.includes(nombreInpI)) {
              fila.classList.remove("d-none");
              notifi.classList.add("d-none");
          } else if(lote.includes(nombreInpI)){
              fila.classList.remove("d-none");
              notifi.classList.add("d-none");
          }else {
              fila.classList.add("d-none");
              // cuenta las veces que no encuentra un síntoma
              contadorINo = contadorINo + 1;
          }
      });

      // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes
      if (contadorI === contadorINo) {
          // muestra el texto.
          notifi.classList.remove("d-none");
      }
  }

  inputBuscI.addEventListener("keyup", () => {
      buscarI();
  });


}); //llave que termina el evento del DOM
