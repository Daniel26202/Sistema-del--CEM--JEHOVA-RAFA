addEventListener("DOMContentLoaded", function () {
  console.log("Reportes Cita...");

  const desdeFecha = document.getElementById("desdeFecha");
  const fechaHasta = document.getElementById("fechaHasta");
  const botonDeImprimir = document.getElementById("botonDeImprimir");
  const formularioCita = document.getElementById("formularioCita");
  const alertaDeFecha = document.getElementById("alertaDeFecha");

  const expresionesReporteCita = {
    fecha: /^\d{4}\-\d{2}\-\d{2}$/,
  };

  const campos = {
    desdeFecha: false,
    fechaHasta: false,
  };

  const validacionDeFechasReporte = (e, ele) => {
    if (e.target.name == "desdeFecha") {
      if (expresionesReporteCita.fecha.test(ele.value)) {
        ele.style.borderBottom = "2px solid rgb(13, 240, 13)";
        campos["desdeFecha"] = true;
      } else {
        ele.style.borderBottom = "2px solid rgb(224, 3, 3)";
        campos["desdeFecha"] = false;
      }
    } else if (e.target.name == "fechaHasta") {
      if (expresionesReporteCita.fecha.test(ele.value)) {
        ele.style.borderBottom = "2px solid rgb(13, 240, 13)";
        campos["fechaHasta"] = true;
      } else {
        ele.style.borderBottom = "2px solid rgb(224, 3, 3)";
        campos["fechaHasta"] = false;
      }
    }
  };

  document.querySelectorAll(".input-expresion").forEach((input) => {
    input.addEventListener("keyup", function (e) {
      validacionDeFechasReporte(e, input);
    });
    input.addEventListener("input", function (e) {
      validacionDeFechasReporte(e, input);
    });
  });

  formularioCita.addEventListener("submit", function (e) {
    e.preventDefault();

    if (desdeFecha.value >= fechaHasta.value) {
      alertaDeFecha.classList.remove("d-none");
      alertaDeFecha.innerText =
        "Verifique que la fecha de inicio sea menor a la fecha final";
      setTimeout(function () {
        alertaDeFecha.classList.add("d-none");
      }, 8000);
    } else {
      if (campos.desdeFecha && campos.fechaHasta) {
        this.submit();
      } else {
        alertaDeFecha.classList.remove("d-none");
        alertaDeFecha.innerText =
          "Verifique que las fechas tengan un formato valido";
        setTimeout(function () {
          alertaDeFecha.classList.add("d-none");
        }, 8000);
      }
    }
  });
});
