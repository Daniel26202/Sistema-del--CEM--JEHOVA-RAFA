import { executePetition, initDataTable } from "../generic/funtionGeneric.js";

const vistaActiva = document.getElementById("vistaActiva").value;
const selector = ".example";

const readBitacora = async () => {
  try {
    const result = await executePetition("bitacoraAjax", "GET");
    console.log(result);
    let html = "";

    result.forEach((element) => {
      html += `
                <tr>
                    <td class="text-center">${element.nombre} ${element.apellido}</td>
                    <td class="text-center">${element.usuario}</td>
                    <td class="text-center">${element.tabla}</td>
                    <td class="text-center">${element.actividad}</td>
                    <td class="text-center">${element.fecha_hora.split(" ")[0]}</td>
                    <td class="text-center">${element.fecha_hora.split(" ")[1]}</td>
                </tr>
            `;
    });

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    document.querySelector(`${selector} tbody`).innerHTML = html;
    initDataTable(selector);
  } catch (error) {
    console.log(error);
  }
};

readBitacora();
