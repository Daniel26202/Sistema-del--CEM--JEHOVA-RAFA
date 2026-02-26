import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
  cargarImg,
} from "./generic/funtionGeneric.js";
import Paginator from "./generic/Paginator.js"; //paginacion
import { inicializarValidacionFormulario } from "./generic/expresionesModulares.js";

addEventListener("DOMContentLoaded", function () {
  console.log("insumos/");

  const modalAgreInsumos = new bootstrap.Modal(
    document.getElementById("exampleModalagregarInsumos"),
  );

  const divTarjetsInsumo = document.getElementById("div-tarjets");
  const imagenInsumo = document.getElementById("imagen");

  const formInsumos = document.getElementById("modalAgregarInsumos");
  const inputEditar = formInsumos.querySelectorAll(".campo-editar");

  const contenedorImgEditar = document.getElementById("contenedor-img-editar");
  const imgEditar = document.getElementById("imgEditar");
  const contenedorImg = document.getElementById("contenedor-img");
  const idInsumoOculto = document.getElementById("idInsumoOculto");

  console.log(formInsumos);

  const divPapelera = document.getElementById("div-papelera");
  const urlBase = document.getElementById("urlBase").value;

  const selector = ".exampleTable";

  let url = "/Sistema-del--CEM--JEHOVA-RAFA/Insumos";
  let urlActual = window.location.href;

  const traerInsumoCasiVencidos = async () => {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Insumos/retornarLasEntradas",
    );
    let resultado = await peticion.json();
    console.log(resultado);

    const botones = document.querySelectorAll(".botones-mostrar");
    const alertasVencidos = document.querySelectorAll(".alertas-vencidos");

    botones.forEach((ele, index) => {
      const dataIndex = ele.getAttribute("data-index");
      const insumoEncontrado = resultado.find(
        (res) => res && res.id_insumo_e == dataIndex,
      );
      console.log(alertasVencidos[index].children[1]);
      if (insumoEncontrado) {
        alertasVencidos[index].classList.remove("d-none");
        alertasVencidos[index].classList.add("uk-alert-danger");
        alertasVencidos[index].children[1].classList.add(
          "p-error-validaciones",
        );
        alertasVencidos[index].children[1].innerText =
          `El insumo ${insumoEncontrado.nombre} del lote ${insumoEncontrado.numero_de_lote} vence el ${insumoEncontrado.fechaDeVencimiento}.`;
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

  const infoInsumos = async (id_insumo) => {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Insumos/info/" + id_insumo,
    );
    let resultado = await peticion.json();
    let parrafos = document.querySelectorAll(".parrafo");
    console.log(resultado);
    let srcImg = "";
    resultado["insumo"].forEach((res, index) => {
      console.log(res.nombre);
      srcImg = res.imagen;
      parrafos[0].innerText = `${res.nombre}`;
      parrafos[1].innerText = `${res.descripcion}`;
      parrafos[2].innerText = `${res.marca}`;
      parrafos[3].innerText = `${res.precio * parseFloat(resultado["dolar"])} BS`;
      parrafos[4].innerText = `${parseFloat(res.precio)} $`;
      parrafos[5].innerText = `${res.iva ? "Contiene IVA" : "Excento de IVA"}`;
      parrafos[6].innerText = `${resultado["vencimiento"][index].fechaDeVencimiento}`;

      // inputEditar[0].value = res.id_insumo;
      inputEditar[1].value = res.nombre;
      inputEditar[2].value = res.descripcion;
      inputEditar[3].value = res.marca;
      inputEditar[4].value = res.medida;
      inputEditar[5].value = resultado["vencimiento"][index].fechaDeVencimiento;
      inputEditar[6].value = res.stockMinimo;

      formInsumos.querySelectorAll(".input-validar").forEach((inp) => {
        let divParent = inp.closest(".campo-custom");

        if (!inp.classList.contains("campo-editar")) {
          divParent.classList.add("d-none");

          //le coloco d-none a los label tambien
          divParent.previousElementSibling.classList.add("d-none");
          inp.parentElement.classList.add("valido");
        } else {
          // se activa la validacion con todos excepto con el inputt de la imagen
          if (inp.getAttribute("type") == "file") {
            console.log(inp.parentElement);
            inp.parentElement.classList.add("valido");
            // divParent.classList.add("valido");
          } else {
            inp.dispatchEvent(new Event("keyup", { bubbles: true }));
          }
        }
      });

      contenedorImg.classList.add("d-none");
      //ahora gestionar la imagen del insumo es decir mostrar un previsualizacion en el modal de editar
      contenedorImgEditar.classList.remove("d-none");
      imgEditar.setAttribute(
        "src",
        `../src/assets/images/img_ingresadas_por_usuarios/insumos/${srcImg}`,
      );

      document
        .querySelector(".btn-eliminar")
        .setAttribute("data-index", res.id_insumo);

      //darle el valaor del id al input
      idInsumoOculto.value = id_insumo;

      //agregar la clase editar al formulario
      formInsumos.classList.add("editar");
    });
  };

  const readInsumos = async (contenedor) => {
    try {
      
      const items = await executePetition(`${url}/insumosAjax`, 'GET');
      console.log(items)
      const paginator = new Paginator(
        items,
        1,
        "cardContainer",
        "pagination",
        "searchInput",
        returnFragmentHtml,
      );

      paginator.displayItems();


      document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
        ele.value = document.getElementById("id_usuario_session").value;
      });

      document.querySelectorAll(".botones-mostrar").forEach((ele) => {
        ele.addEventListener("click", function () {
          infoInsumos(this.getAttribute("data-index"));
        });
      });

      //llamar las funcion de eliminar

      document
        .querySelector(".btn-eliminar")
        .addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            document.getElementById("id_usuario_bitacora").value,
          ];
          console.log(data);
          alertConfirm(
            "Esta seguro de eliminar el insumo?",
            deleteInsumo,
            data,
          );
        });
    } catch (error) {
      console.log(error);
      alertError("Error", error);
    }
  };

  const readPapeleraInsumos = async (contenedor) => {
    try {
      const result = await executePetition(url + "/papeleraInsumosAjax", "GET");

      let html = "";

      //html para la papelera
      if (result.length > 0) {
        result.forEach((element) => {
          html += `<tr>
                <td class="text-center">${element.nombre}</td>
                <td class="text-center">${element.descripcion}</td>
                <td class="text-center">${element.precio} BS</td>
                <td class="text-center">${element.cantidad_inventario}</td>
                <td class="text-center">${element.stockMinimo}</td>

                <td class="d-flex justify-content-center">

                  <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer" data-index="${element.id_insumo}" title="Restablecer" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                      <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                    </svg></button>
                </td>

              </tr> `;
        });
      }

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }

      contenedor.innerHTML = html;

      initDataTable(selector);

      document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
        ele.value = document.getElementById("id_usuario_session").value;
      });

      //llamar las funcion de eliminar

      document.querySelectorAll(".btnRestablecer").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            document.getElementById("id_usuario_session").value,
          ];
          alertConfirm(
            "Esta seguro de restablecer el insumo?",
            restablecerInsumos,
            data,
          );
        });
      });
    } catch (error) {
      alertError("Error", error);
    }
  };

  //restablecer
  const restablecerInsumos = async (data) => {
    try {
      const result = await executePetition(
        url + `/restablecerInsumo/${data}`,
        "GET",
      );
      if (result.ok) {
        alertSuccess(result.message);

        readPapeleraInsumos(divPapelera);
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //create
  const createInsumos = async (form) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(url + "/guardarInsumo", "POST", data);
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);
        modalAgreInsumos.hide();
        readInsumos(divTarjetsInsumo);
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //delete

  const deleteInsumo = async (data) => {
    try {
      const result = await executePetition(url + `/eliminar/${data}`, "GET");
      if (result.ok) {
        alertSuccess(result.message);

        readInsumos(divTarjetsInsumo);
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //update
  const updateInsumos = async (form) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(url + "/editar", "POST", data);
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);

        modalAgreInsumos.hide();
        readInsumos(divTarjetsInsumo);
      } else throw new Error(`${result.error}`);
    } catch (error) {
      console.log(error);
      alertError("Error", error);
    }
  };

  //RETURN fragment html card
  const returnFragmentHtml = (element) => {
    return `
    <div class="card contenido mb-4 mx-2" style="width: 18rem;">
        <img src="${urlBase}../src/assets/images/img_ingresadas_por_usuarios/insumos/${
          element.imagen
        }" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class=" titulo">${element.nombre}</h5>

            <p class="mt-3">Medida: ${element.medida}</p>
            <p class="mt-3">Stock-Min: ${element.stockMinimo}</p>

              <p class="${parseInt(element.cantidad_inventario) <= 0 ? "text-danger" : ""}">Cantidad: ${
                element.cantidad_inventario
              }</p>                                   

                                    <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                                      element.id_insumo
                                    }"
                                        data-bs-toggle="modal" data-bs-target="#modal-exampleMostrar">Mostrar</button>
        </div>
    </div>`;
  };

  //funcion la imagen en el formulario para  que se visualize

  //llamar a la funcion para cargar la imagen del insumo
  imagenInsumo.addEventListener("change", function (e) {
    let newImg = `<img  style="height: 200px;width: 100%;" src=''>`;

    contenedorImg.classList.remove("d-none");
    contenedorImgEditar.classList.add("d-none");
    cargarImg(this.files, newImg, contenedorImg);
  });

  traerInsumoCasiVencidos();

  console.log(urlActual);
  if (!urlActual.includes("papelera")) {
    readInsumos(divTarjetsInsumo);
  } else {
    readPapeleraInsumos(divPapelera);
  }

  let verificarFormularioInsumo = inicializarValidacionFormulario(formInsumos);

  formInsumos.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarFormularioInsumo();

    if (esValido) {
      if (formInsumos.classList.contains("editar")) {
        console.log("editar");
        updateInsumos(this);
      } else {
        createInsumos(this);
        console.log("guardar");
      }
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });
});
