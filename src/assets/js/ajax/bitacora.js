import { executePetition, initDataTable } from "../generic/funtionGeneric.js";

const vistaActiva = document.getElementById("vistaActiva").value;
const selector = ".example";
let urlActual = window.location.href;

const readBitacora = async () => {
  try {
    let metodo = urlActual.includes("bitacoraUsuario")
      ? "bitacoraAjaxUser"
      : "bitacoraAjaxAdmin";
    const columnsBitacora = [
      {
        data: "nombre",
        render: (data, type, row) => `${data} ${row.apellido}`,
      },
      { data: "usuario" },
      { data: "tabla" },
      { data: "actividad" },
      {
        data: "fecha",
        render: (data, type, row) => `${row.fecha_hora.split(" ")[0]}`,
      },
      {
        data: "hora",
        render: (data, type, row) => `${row.fecha_hora.split(" ")[1]}`,
      },
    ];

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    initDataTable(
      selector,
      metodo,
      columnsBitacora,
      (datosServer) => console.log(datosServer),
    );
  } catch (error) {
    console.log(error);
  }
};

readBitacora();
