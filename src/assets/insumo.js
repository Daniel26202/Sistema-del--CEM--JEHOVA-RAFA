addEventListener("DOMContentLoaded", function () {
  // grpFormInCorrect malo
  // grpFormCorrect bueno
  console.log("DOMContentLoaded Insumos");
  const archivo = document.getElementById("imagen");
  const cantidades = document.querySelectorAll(".cantidad");
  const formBuscadorInsumo = document.getElementById("form-buscador-insumo");
  const input = document.querySelector("#form-buscador-insumo input");
  const eliminarInsumo = document.getElementById("eliminarInsumo");
  const inputEditar = document.querySelectorAll(".input-editar");
  const inputEditarImagen = document.querySelector(".input-editar-imagen");
  //href="?c=controladorInsumos/insumos"
  const modalAgregarInsumos = document.getElementById("modalAgregarInsumos");
  const inputs = document.querySelectorAll(
    "#modalAgregarInsumos .input-disabled"
  );

  //editar
  const modalEditarInsumos = document.getElementById("modalEditarInsumos");
  const inputsEditar = document.querySelectorAll("#modalEditarInsumos .input");

  const expresionesInsumos = {
    imagen: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
    nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
    descripcion: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    cantidad: /^([1-9]{1})([0-9]{1,3})?$/,
    precio: /^(\d{1,3}\.\d{3},\d{2}|\d{1,3},\d{2})$/,
    fechaDeVencimiento: /^\d{4}\-\d{2}\-\d{2}$/,
    stockMinimo: /^([1-9]{1})([0-9]{1})?$/,
    lote: /^[A-Za-z0-9-_]{3,10}$/
    //^([0-9]+)$
  };

  const camposInsumos = {
    imagen: true,
    nombre: false,
    descripcion: false,
    cantidad: false,
    precio: false,
    fechaDeVencimiento: false,
    stockMinimo: false,
    lote: false
  };

  const camposEditarInsumos = {
    imagen: true,
    nombre: true,
    descripcion: true,
    cantidad: true,
    precio: true,
    fechaDeVencimiento: true,
    stockMinimo: true,
    lote: true
  };

  //funcion para traer los datos de las entradas de los inusmos que ya se vallan a vencer

  //gestionar insumos vencidos

  const traerInsumoCasiVencidos = async () => {
    let peticion = await fetch("?c=controladorInsumos/retornarLasEntradas");
    let resultado = await peticion.json();
    console.log(resultado);

    const botones = document.querySelectorAll(".botones-mostrar");
    const alertasVencidos = document.querySelectorAll(".alertas-vencidos");

    botones.forEach((ele, index) => {
      const dataIndex = ele.getAttribute("data-index");

      resultado.forEach((res) => {
        if (res !== undefined) {
          console.log(res.id_insumo_e);
          console.log(dataIndex);

          if (res.id_insumo_e == dataIndex) {
            console.log("es igual");
            alertasVencidos[index].classList.remove("d-none");
            alertasVencidos[index].innerText = `El insumo ${res.nombre} del lote ${res.numero_de_lote} vence el ${res.fechaDeVencimiento}`;
            document.getElementById("id_entradaDeInsumo").value =
              res.id_entradaDeInsumo;
            document.getElementById("id_insumo").value = res.id_insumo_e;
          } else {
            console.log("no es igual");
            alertasVencidos[index].classList.add("d-none");
          }
        } else {
          console.log("indefinido");
        }
      });
    });
  };

  traerInsumoCasiVencidos();

  //ajax
  async function infoInsumos(id_insumo) {
    let peticion = await fetch(
      "?c=controladorInsumos/info&id_insumo=" + id_insumo
    );
    let resultado = await peticion.json();
    let parrafos = document.querySelectorAll(".parrafo");
    let fechaVencimiento = new Date();
    let diaVencimiento = fechaVencimiento.getDate();
    let mesVencimiento = fechaVencimiento.getMonth() + 1;
    let yearVencimiento = fechaVencimiento.getFullYear();
    let fechaActualInsumo = `${yearVencimiento}-${mesVencimiento}-${diaVencimiento}`;
    console.log(resultado);
    resultado.forEach((res) => {
      parrafos[0].innerText = `${res.nombre}`;
      parrafos[1].innerText = `${res.descripcion}`;
      parrafos[2].innerText = `${res.precio} BS`;
      //parrafos[3].innerText = `${res.fechaDeVencimiento}`;
      if (res.fechaDeVencimiento <= fechaActualInsumo) {
        document.getElementById("alertaInsumo").classList.remove("d-none");
      } else {
        document.getElementById("alertaInsumo").classList.add("d-none");
      }
      eliminarInsumo.setAttribute(
        "href",
        `?c=controladorInsumos/eliminar&id_insumo=${res.id_insumo}`
      );
      inputEditar[0].value = res.id_insumo;
      inputEditar[1].value = res.nombre;
      inputEditar[2].value = res.descripcion;
      inputEditar[3].value = res.stockMinimo;
      //inputEditar[4].value = res.fechaDeVencimiento

      document
        .querySelector(".img-editar")
        .setAttribute(
          "src",
          `./src/assets/img_ingresadas_por_usuarios/insumos/${res.imagen}`
        );

      document.querySelector(".value-img").value = res.imagen;
    });
  }

  //ajax insumo
  async function buscarAjax() {
    try {
      const datos = new FormData(formBuscadorInsumo);
      const contenido = { method: "POST", body: datos };
      let peticion = await fetch(
        "?c=controladorInsumos/mostrarBusquedaInsumo",
        contenido
      );
      let resultado = await peticion.json();
      let html = ``;
      console.log(resultado);
      if (resultado.length > 0) {
        resultado.forEach((res) => {
          html += `<div class="card ms-3 tarjet mt-2" style="width: 16rem;">
					<img src="./src/assets/img_ingresadas_por_usuarios/insumos/${res.imagen}" class="card-img-top" alt="...">
					<div class="card-body mt-4 tarjeta-ajax">
					<h5 class="card-title titulo">${res.nombre}</h5>
					<p>Skock-Min: ${res.stockMinimo}</p>
					<p>Cantidad: ${res.cantidad}</p>
					<a href="#" class="btn btn-agregarcita-modal text-decoration-none botones-mostrar botones-mostrar-buscador" data-index="${res.id_insumo}"
					uk-toggle="target: #modal-exampleMostrar" id="botones-mostrar-buscador">Mostrar</a>
					</div>
					</div>`;
        });

        document.querySelector(".tar").innerHTML = html;

        document
          .querySelectorAll(".botones-mostrar-buscador")
          .forEach((ele) => {
            ele.addEventListener("click", function () {
              console.log("holaa");
              console.log(this.getAttribute("data-index"));
              infoInsumos(this.getAttribute("data-index"));
            });
          });

        document
          .querySelector(".tar")
          .classList.remove("d-flex", "justify-content-center");
        document
          .getElementById("reiniciarBusquedaInsumo")
          .classList.remove("d-none");
      } else {
        html += `<div class="mt-2 d-flex justify-content-center">
				<div>
				<h4 class="text-center">NO HAY INSUMOS</h4>
				</div>
				</div>`;

        document.querySelector(".tar").innerHTML = html;
        document
          .querySelector(".tar")
          .classList.add("d-flex", "justify-content-center");
        document
          .getElementById("reiniciarBusquedaInsumo")
          .classList.remove("d-none");
      }
    } catch (e) {
      console.log(e);
    }
  }

  //formulario para buscar insumo
  formBuscadorInsumo.addEventListener("submit", function (f) {
    f.preventDefault();
    if (input.value == "") {
      // html += `<div class="mt-2 d-flex justify-content-center">
      // 	<div>
      // 	<h4 class="text-center">EL CAMPO ESTA VACIO</h4>
      // 	</div>
      // 	</div>`;
      // document.querySelector(".tar").innerHTML = html
      // document.querySelector(".tar").innerHTML = ""
      // document.querySelector(".tar").classList.add('d-flex', 'justify-content-center')
    } else {
      buscarAjax();
    }
  });

  document.querySelectorAll(".botones-mostrar").forEach((ele) => {
    ele.addEventListener("click", function () {
      console.log("hola");
      console.log(this.getAttribute("data-index"));
      infoInsumos(this.getAttribute("data-index"));
    });
  });

  // document.getElementById("botones-mostrar-buscador").addEventListener("click",function(){
  // 			console.log("holaa");
  // 			// console.log(this.getAttribute("data-index"))
  // 			// infoInsumos(this.getAttribute("data-index"))
  // 		})

  //imagenes de los insumos
  archivo.addEventListener("change", function (e) {
    leerArchivo(archivo.files);
  });

  function leerArchivo(ar) {
    for (var i = 0; i < ar.length; i++) {
      const reader = new FileReader();
      reader.readAsDataURL(ar[i]);
      reader.addEventListener("load", function (e) {
        let newImg = `<img  style="height: 200px;width: 100%;" src=${e.currentTarget.result}>`;
        document.querySelector("#contenedor-img").innerHTML = newImg;
      });
    }
  }

  inputEditarImagen.addEventListener("change", function (e) {
    leerArchivoEditar(inputEditarImagen.files);
  });

  //editar img
  function leerArchivoEditar(ar) {
    for (var i = 0; i < ar.length; i++) {
      const reader = new FileReader();
      reader.readAsDataURL(ar[i]);
      reader.addEventListener("load", function (e) {
        document
          .querySelector(".img-editar")
          .setAttribute("src", `${e.currentTarget.result}`);
        console.log(e.currentTarget.result);
      });
    }
  }

  //validaciones de guardar

  const validarCamposInsumos = (expresiones, input, campo, camposInsumos) => {
    if (expresiones.test(input.value)) {
      input.parentElement.classList.remove("grpFormInCorrect");
      input.parentElement.classList.add("grpFormCorrect");
      camposInsumos[campo] = true;
    } else {
      input.parentElement.classList.remove("grpFormCorrect");
      input.parentElement.classList.add("grpFormInCorrect");
      camposInsumos[campo] = false;
    }
  };

  function validarFormularioInsumo(e) {
    switch (e.target.name) {
      case "imagen":
        let imagenSeparada = e.target.value.split("\\");
        let nombreImagen = imagenSeparada.pop();
        if (expresionesInsumos.imagen.test(nombreImagen)) {
          e.target.parentElement.classList.remove("grpFormInCorrect");
          e.target.parentElement.classList.add("grpFormCorrect");
          camposInsumos["imagen"] = true;
        } else {
          e.target.parentElement.classList.remove("grpFormCorrect");
          e.target.parentElement.classList.add("grpFormInCorrect");
          camposInsumos["imagen"] = false;
        }

        break;

      case "nombre":
        validarCamposInsumos(
          expresionesInsumos.nombre,
          e.target,
          "nombre",
          camposInsumos
        );

        break;
      case "descripcion":
        validarCamposInsumos(
          expresionesInsumos.descripcion,
          e.target,
          "descripcion",
          camposInsumos
        );

        break;

      case "cantidad":
        validarCamposInsumos(
          expresionesInsumos.cantidad,
          e.target,
          "cantidad",
          camposInsumos
        );

        break;
      case "precio":
        validarCamposInsumos(
          expresionesInsumos.precio,
          e.target,
          "precio",
          camposInsumos
        );
        break;
      case "fecha_de_vencimiento":
        validarCamposInsumos(
          expresionesInsumos.fechaDeVencimiento,
          e.target,
          "fechaDeVencimiento",
          camposInsumos
        );
        break;
      case "stockMinimo":
        validarCamposInsumos(
          expresionesInsumos.stockMinimo,
          e.target,
          "stockMinimo",
          camposInsumos
        );
        break;
      case "lote":
        validarCamposInsumos(
          expresionesInsumos.lote,
          e.target,
          "lote",
          camposInsumos
        );
        break;
    }
  }

  function validarFormularioInsumoEditar(e) {
    switch (e.target.name) {
      case "imagen":
        let imagenSeparada = e.target.value.split("\\");
        let nombreImagen = imagenSeparada.pop();
        if (expresionesInsumos.imagen.test(nombreImagen)) {
          e.target.parentElement.classList.remove("grpFormInCorrect");
          e.target.parentElement.classList.add("grpFormCorrect");
          camposEditarInsumos["imagen"] = true;
        } else {
          e.target.parentElement.classList.remove("grpFormCorrect");
          e.target.parentElement.classList.add("grpFormInCorrect");
          camposEditarInsumos["imagen"] = false;
        }

        break;

      case "nombre":
        validarCamposInsumos(
          expresionesInsumos.nombre,
          e.target,
          "nombre",
          camposEditarInsumos
        );

        break;
      case "descripcion":
        validarCamposInsumos(
          expresionesInsumos.descripcion,
          e.target,
          "descripcion",
          camposEditarInsumos
        );

        break;

      case "cantidad":
        validarCamposInsumos(
          expresionesInsumos.cantidad,
          e.target,
          "cantidad",
          camposEditarInsumos
        );

        break;
      case "fecha_de_vencimiento":
        validarCamposInsumos(
          expresionesInsumos.fechaDeVencimiento,
          e.target,
          "fechaDeVencimiento",
          camposEditarInsumos
        );
        break;
      case "stockMinimo":
        validarCamposInsumos(
          expresionesInsumos.stockMinimo,
          e.target,
          "stockMinimo",
          camposEditarInsumos
        );
        break;
      case "lote":
        validarCamposInsumos(
          expresionesInsumos.lote,
          e.target,
          "lote",
          camposEditarInsumos
        );
        break;
    }
  }

  inputs.forEach((input) => {
    input.addEventListener("input", validarFormularioInsumo);
  });

  modalAgregarInsumos.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      camposInsumos.imagen &&
      camposInsumos.nombre &&
      camposInsumos.descripcion &&
      camposInsumos.cantidad &&
      camposInsumos.precio &&
      camposInsumos.fechaDeVencimiento &&
      camposInsumos.stockMinimo &&
      camposInsumos.lote
    ) {
      modalAgregarInsumos.submit();
    } else {
      document.getElementById("alerta-guardar").classList.remove("d-none");
      setTimeout(function () {
        document.getElementById("alerta-guardar").classList.add("d-none");
      }, 8000);
    }
  });

  inputsEditar.forEach((input) => {
    input.addEventListener("input", validarFormularioInsumoEditar);
  });

  modalEditarInsumos.addEventListener("submit", function (e) {
    e.preventDefault();
    if (
      camposEditarInsumos.imagen &&
      camposEditarInsumos.nombre &&
      camposEditarInsumos.descripcion &&
      camposEditarInsumos.cantidad &&
      camposEditarInsumos.precio &&
      camposEditarInsumos.fechaDeVencimiento &&
      camposEditarInsumos.stockMinimo &&
      camposInsumos.lote
    ) {
      modalEditarInsumos.submit();
    } else {
      document.getElementById("alerta-editar").classList.remove("d-none");
      setTimeout(function () {
        document.getElementById("alerta-editar").classList.add("d-none");
      }, 8000);
    }
  });

  //este es el comentario
  const comentario = document.querySelector(".comentario");
  //si existe el comentario lo muestra y después de 8sg lo oculta
  if (comentario) {
    comentario.style.display = "block";
    setTimeout(function () {
      comentario.style.display = "none";
    }, 8000);
  }
});
