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

  //tarjetas
  const tarjetas = document.querySelectorAll(".tarjet");

  const expresionesInsumos = {
    imagen: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
    nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
    descripcion: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    cantidad: /^([1-9]{1})([0-9]{1,4})?$/,
    precio: /^(\d{1,3}\.\d{3}.\d{2}|\d{1,3}.\d{2})$/,
    fechaDeVencimiento: /^\d{4}\-\d{2}\-\d{2}$/,
    stockMinimo: /^([1-9]{1})([0-9]{1})?$/,
    lote: /^[0-9-_]{4,10}$/,
    marca: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ\s\d]{4,16}$/,
    medida: /^\d+\s?(ml|L|g|kg|m|cm|mm)$/,
    //^([0-9]+)$
  };

  const camposInsumos = {
    imagen: true,
    nombre: false,
    descripcion: false,
    cantidad: false,
    precio: false,
    precioD: false,
    fechaDeVencimiento: false,
    stockMinimo: false,
    lote: false,
    marca: false,
    medida: false,
  };

  const camposEditarInsumos = {
    imagen: true,
    nombre: true,
    descripcion: true,
    cantidad: true,
    precio: true,
    precioD: true,
    fechaDeVencimiento: true,
    stockMinimo: true,
    lote: true,
    marca: true,
    medida: true,
  };



  //funcion para traer los datos de las entradas de los inusmos que ya se vallan a vencer

  //gestionar insumos vencidos

  const traerInsumoCasiVencidos = async () => {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Insumos/retornarLasEntradas"
    );
    let resultado = await peticion.json();
    console.log(resultado);

    const botones = document.querySelectorAll(".botones-mostrar");
    const alertasVencidos = document.querySelectorAll(".alertas-vencidos");

    botones.forEach((ele, index) => {
      const dataIndex = ele.getAttribute("data-index");
      const insumoEncontrado = resultado.find(
        (res) => res && res.id_insumo_e == dataIndex
      );
      console.log(alertasVencidos[index].children[1]);
      if (insumoEncontrado) {
        alertasVencidos[index].classList.remove("d-none");
        alertasVencidos[index].classList.add("uk-alert-danger");
        alertasVencidos[index].children[1].classList.add(
          "p-error-validaciones"
        );
        alertasVencidos[
          index
        ].children[1].innerText = `El insumo ${insumoEncontrado.nombre} del lote ${insumoEncontrado.numero_de_lote} vence el ${insumoEncontrado.fechaDeVencimiento}.`;
        document.getElementById("id_entradaDeInsumo").value =
          insumoEncontrado.id_entradaDeInsumo;
        document.getElementById("id_insumo").value =
          insumoEncontrado.id_insumo_e;
      } else {
        let tarjeta =
          alertasVencidos[index].parentElement.parentElement.parentElement;
        tarjeta.children[0].style.height = "56%";
      }
    });
  };

  traerInsumoCasiVencidos();

  //evento para que si le da a la x de la alerta la tarjeta se haga mas pequeña
  document.querySelectorAll(".uk-alert-close").forEach((ele) => {
    ele.addEventListener("click", function () {
      let tarjeta =
        this.parentElement.parentElement.parentElement.parentElement;
      tarjeta.children[0].style.height = "56%";
    });
  });

  //ajax
  async function infoInsumos(id_insumo) {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Insumos/info/" + id_insumo
    );
    let resultado = await peticion.json();
    let parrafos = document.querySelectorAll(".parrafo");
    console.log(resultado);
    resultado["insumo"].forEach((res) => {
      console.log(res.nombre)
      parrafos[0].innerText = `${res.nombre}`;
      parrafos[1].innerText = `${res.descripcion}`;
      parrafos[2].innerText = `${res.marca}`;
      parrafos[3].innerText = `${res.precio * parseFloat(resultado["dolar"])
        } BS`;
      parrafos[4].innerText = `${parseFloat(res.precio)} $`;
      parrafos[5].innerText = `${(res.iva) ? "Contiene IVA" : "Excento de IVA"}`;
      parrafos[6].innerText = `${resultado["vencimiento"][0][0]}`;



      eliminarInsumo.setAttribute(
        "href",
        `/Sistema-del--CEM--JEHOVA-RAFA/Insumos/eliminar/${res.id_insumo}/${document.getElementById("id_usuario_bitacora").value
        }`
      );
      inputEditar[0].value = res.id_insumo;
      inputEditar[1].value = res.nombre;
      inputEditar[2].value = res.descripcion;
      inputEditar[3].value = res.marca;
      inputEditar[4].value = res.medida;
      inputEditar[5].value = res.stockMinimo;
      //inputEditar[4].value = res.fechaDeVencimiento

      document
        .querySelector(".img-editar")
        .setAttribute(
          "src",
          `../src/assets/img_ingresadas_por_usuarios/insumos/${res.imagen}`
        );

      document.querySelector(".value-img").value = res.imagen;
    });
  }

  //funcion para buscar insumos
  function buscarInsumos(input) {
    console.log(input);
    document.querySelectorAll(".titulo").forEach((ele, index) => {
      let nombre = ele.innerText.toLowerCase();
      let codigo = tarjetas[index].innerText;

      if (input.value != "") {
        if (
          nombre.includes(input.value.toLowerCase()) ||
          codigo.includes(input.value)
        ) {
          tarjetas[index].classList.remove("d-none");
        } else {
          tarjetas[index].classList.add("d-none");
        }
      }else{
        tarjetas[index].classList.remove("d-none");
      }
    });
  }

  //formulario para buscar insumo
  formBuscadorInsumo.children[0].addEventListener("keyup", function () {
    buscarInsumos(this);
  });

  document.querySelectorAll(".botones-mostrar").forEach((ele) => {
    ele.addEventListener("click", function () {
      console.log("hola");
      console.log(this.getAttribute("data-index"));
      infoInsumos(this.getAttribute("data-index"));
    });
  });

  // document.getElementById("botones-mostrar-buscador").addEventListener("click",function(){
  //      console.log("holaa");
  //      // console.log(this.getAttribute("data-index"))
  //      // infoInsumos(this.getAttribute("data-index"))
  //    })

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

  // Nueva función para validar fechas no futuras ni pasadas
  function validarFecha(input, pError, campo, campos) {
    const valorFecha = new Date(input.value);
    const fechaHoy = new Date();
    fechaHoy.setHours(0, 0, 0, 0); // Establece el tiempo a la medianoche para comparación

    pError.classList.add("fw-bold");
    pError.style.color = "rgb(224, 3, 3)";

    if (campo == "fechaDeVencimiento") {
      if (!expresionesInsumos.fechaDeVencimiento.test(input.value)) {
        // Validamos con la expresión regular
        pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
        pError.classList.remove("d-none");
        return false;
      } else if (valorFecha <= fechaHoy) {
        // Validamos que no sea una fecha del pasado
        pError.textContent = "La fecha no puede ser del pasado.";
        pError.classList.remove("d-none");
        return false;
      }
    }

    // Si pasa todas las validaciones
    pError.classList.add("d-none");
    // actualizarEstadoInput(input, "incorrecto", formulario);

    camposInsumos[campo] = true;
  }

  //validaciones de guardar

  const validarCamposInsumos = (expresiones, input, campo, camposInsumos) => {
    const pErrorGuardar = document.querySelector(".p-error-" + input.name);
    console.log(pErrorGuardar);
    pErrorGuardar.classList.add("fw-bold");
    pErrorGuardar.classList.add("p-error-validaciones");
    console.log(pErrorGuardar);
    if (input.name == "fecha_de_vencimiento") {
      console.log("2trabaje con la echa");
      validarFecha(input, pErrorGuardar, campo, camposInsumos);
    } else {
      if (expresiones.test(input.value)) {
        input.parentElement.classList.remove("grpFormInCorrect");
        input.parentElement.classList.add("grpFormCorrect");
        pErrorGuardar.classList.add("d-none");
        camposInsumos[campo] = true;
      } else {
        input.parentElement.classList.remove("grpFormCorrect");
        input.parentElement.classList.add("grpFormInCorrect");
        pErrorGuardar.classList.remove("d-none");
        camposInsumos[campo] = false;
      }
    }
  };

  function validarFormularioInsumo(e) {
    switch (e.target.name) {
      case "imagen":
        const pErrorGuardarImagen = document.querySelector(".p-error-imagen");
        console.log(pErrorGuardarImagen);
        pErrorGuardarImagen.classList.add("fw-bold");
        pErrorGuardarImagen.classList.add("p-error-validaciones");
        let imagenSeparada = e.target.value.split("\\");
        let nombreImagen = imagenSeparada.pop();
        if (expresionesInsumos.imagen.test(nombreImagen)) {
          e.target.parentElement.classList.remove("grpFormInCorrect");
          e.target.parentElement.classList.add("grpFormCorrect");
          pErrorGuardarImagen.classList.add("d-none");
          camposInsumos["imagen"] = true;
        } else {
          e.target.parentElement.classList.remove("grpFormCorrect");
          e.target.parentElement.classList.add("grpFormInCorrect");
          pErrorGuardarImagen.classList.remove("d-none");
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
      case "precioD":
        validarCamposInsumos(
          expresionesInsumos.precio,
          e.target,
          "precioD",
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

      case "marca":
        validarCamposInsumos(
          expresionesInsumos.marca,
          e.target,
          "marca",
          camposEditarInsumos
        );
        break;
      case "medida":
        validarCamposInsumos(
          expresionesInsumos.medida,
          e.target,
          "medida",
          camposEditarInsumos
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
      case "marca":
        validarCamposInsumos(
          expresionesInsumos.marca,
          e.target,
          "marca",
          camposEditarInsumos
        );
        break;
      case "medida":
        validarCamposInsumos(
          expresionesInsumos.medida,
          e.target,
          "medida",
          camposEditarInsumos
        );
        break;
    }
  }

  inputs.forEach((input) => {
    input.addEventListener("input", validarFormularioInsumo);
  });

  inputs.forEach((input) => {
    input.addEventListener("keyup", validarFormularioInsumo);
  });

  inputs.forEach((input) => {
    input.addEventListener("blur", validarFormularioInsumo);
  });

  inputEditar.forEach((input) => {
    input.addEventListener("input", validarFormularioInsumoEditar);
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
      console.log("si se envia");
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
      camposEditarInsumos.stockMinimo
    ) {
      modalEditarInsumos.submit();
    } else {
      console.log(camposInsumos.lote);
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




  //funcion para manejar el checkbox del iva
  document.querySelector(".checkboxIva").addEventListener("change",function () {
    if (this.checked) {
      this.value = 1;
    } else {
      this.value = 0;
    }
  })
});
