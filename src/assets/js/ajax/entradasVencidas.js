import {
  executePetition,
  alertError,
  initDataTable,
} from "../generic/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Insumos";

const readVencidos = async () => {
  try {
    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    const columnsVencidos = [
      { data: "nombre" },
      { data: "proveedor" },
      { data: "fechaDeIngreso" },
      { data: "fechaDeVencimiento" },
      { data: "cantidad_entrada" },
      { data: "precio_entrada" },
      { data: "numero_de_lote" }
    ];

    // re-inicializa
    initDataTable(selector,`${url}/vencidos`,columnsVencidos,(datosServer)=>{console.log(datosServer);
    });
  } catch (error) {
    alertError("Error", error);
  }
};

readVencidos();
