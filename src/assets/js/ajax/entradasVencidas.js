import {
  executePetition,
  alertError,
  initDataTable,
} from "../generic/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Insumos";

const readVencidos = async () => {
  try {
    const result = await executePetition(url + "/vencidos", "GET");
    console.log(result);
    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `<tr>
                            <td class="text-center">${element.nombre}</td>
                            <td class="text-center">${element.proveedor}</td>
                            <td class="text-center">${element.fechaDeIngreso}</td>
                            <td class="text-center">${element.fechaDeVencimiento}</td>
                            <td class="text-center">${element.cantidad_entrada}</td>
                            <td class="text-center">${element.precio_entrada} BS</td>
                            <td class="text-center">${element.numero_de_lote}</td>
                        </tr>`;
    });

    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    // vuelca el html en el tbody
    document.querySelector(selector + " tbody").innerHTML = html;

    // re-inicializa
    initDataTable(selector);
  } catch (error) {
    alertError("Error", error);
  }
};

readVencidos();
