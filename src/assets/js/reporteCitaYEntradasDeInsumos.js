addEventListener("DOMContentLoaded", function () {
  console.log("Reportes Cita...");


  //constantes de cita
  const desdeFecha = document.getElementById("desdeFecha");
  const fechaHasta = document.getElementById("fechaHasta");
  const botonDeImprimir = document.getElementById("botonDeImprimir");
  const formularioCita = document.getElementById("formularioCita");
  const alertaDeFecha = document.getElementById("alertaDeFecha");

  //constante de entradas de insumos

  const checkboxEntradas = document.getElementById("checkboxEntradas");
  const desdeFechaEntradas = document.getElementById("desdeFechaEntradas");
  const fechaHastaEntradas = document.getElementById("fechaHastaEntradas");
  const cajaModalEntradas = document.getElementById("cajaModalEntradas");
  const botonDeImprimirEntradas = document.getElementById("botonDeImprimirEntradas");
  const selectInsumoEntradas = document.getElementById("selectInsumoEntradas");
  const formularioEntradas = document.getElementById("formularioEntradas");
  const alertaDeFechaEntradas = document.getElementById("alertaDeFechaEntradas");
  const cajaCheckboxEntrada = document.getElementById("cajaCheckboxEntrada");


  //funcionamiento de citas
  const expresionesReporteCita = {
    fecha: /^\d{4}\-\d{2}\-\d{2}$/,
  };

  const campos = {
    desdeFecha: false,
    fechaHasta: false,
  };

  const camposEntradas = {
    desdeFechaEntradas: false,
    fechaHastaEntradas: false,
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
    }else if (e.target.name == "desdeFechaEntradas") {
      if (expresionesReporteCita.fecha.test(ele.value)) {
        ele.style.borderBottom = "2px solid rgb(13, 240, 13)";
        camposEntradas["desdeFechaEntradas"] = true;
      } else {
        ele.style.borderBottom = "2px solid rgb(224, 3, 3)";
        camposEntradas["desdeFechaEntradas"] = false;
      }
    }else if (e.target.name == "fechaHastaEntradas") {
      if (expresionesReporteCita.fecha.test(ele.value)) {
        ele.style.borderBottom = "2px solid rgb(13, 240, 13)";
        camposEntradas["fechaHastaEntradas"] = true;
      } else {
        ele.style.borderBottom = "2px solid rgb(224, 3, 3)";
        camposEntradas["fechaHastaEntradas"] = false;
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





  //funcionamiento de entradas de insumos


//checkear si quiere filtar por fecha o no
checkboxEntradas.addEventListener("change", function() {
  if (this.checked) {
    cajaModalEntradas.classList.remove("d-none");
    desdeFechaEntradas.name = "desdeFechaEntradas";
    fechaHastaEntradas.name = "fechaHastaEntradas";
  } else {
    cajaModalEntradas.classList.add("d-none");
    desdeFechaEntradas.name = "";
    fechaHastaEntradas.name = "";
  }
})


//ver que insumo selecciona para el reporte 
selectInsumoEntradas.addEventListener("change", function() {
  botonDeImprimirEntradas.classList.remove("d-none");
  cajaCheckboxEntrada.classList.remove("d-none");
})




formularioEntradas.addEventListener("submit", function (e) {
  e.preventDefault();

  if(cajaModalEntradas.classList.contains("d-none")) {
    this.submit();
  } else {
    if (desdeFechaEntradas.value >= fechaHastaEntradas.value) {
      alertaDeFechaEntradas.classList.remove("d-none");
      alertaDeFechaEntradas.innerText =
      "Verifique que la fecha de inicio sea menor a la fecha final";
      setTimeout(function () {
        alertaDeFechaEntradas.classList.add("d-none");
      }, 8000);
    } else {
      if (camposEntradas.desdeFechaEntradas && camposEntradas.fechaHastaEntradas) {
        this.submit();
      } else {
        alertaDeFechaEntradas.classList.remove("d-none");
        alertaDeFechaEntradas.innerText =
        "Verifique que las fechas tengan un formato valido";
        setTimeout(function () {
          alertaDeFechaEntradas.classList.add("d-none");
        }, 8000);
      }
    }
  }
});





});


