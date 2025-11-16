import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Insumos";


    const readVencidos = async () => {
      try {
    
        const result = await executePetition(url + "/vencidos", "GET");
        console.log(result)
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
        $(selector).DataTable({
          language: {
            language: {
              decimal: ",",
              thousands: ".",
              lengthMenu: "Mostrar por página _MENU_ ",
              zeroRecords: "No se encontraron resultados",
              info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
              infoEmpty: "No hay registros disponibles",
              infoFiltered: "(filtrado de _MAX_ registros en total)",
              search: "Buscar:",
            },
          },
        });
      } catch (error) {
        alertError("Error", error)
      }
    };

    readVencidos();