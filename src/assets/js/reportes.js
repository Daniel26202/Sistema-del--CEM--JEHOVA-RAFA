addEventListener("DOMContentLoaded", function () {
  console.log("Reportes...");
  // const buscarC = document.getElementById("buscarClienteC");
  const infoFactura = document.querySelectorAll(".infoFactura");
  const anularFactura = document.querySelectorAll(".anularfactura");

  const formularioDeFecha = document.getElementById("formularioDeFecha");
  const fechaInicio = document.getElementById("fechaInicio");
  const fechaFinal = document.getElementById("fechaFinal");
  const alertaFecha = document.getElementById("alerta-fecha");


  const formularioDeFechaAnulada = document.getElementById("formularioDeFechaAnulada");
  const fechaInicioAnulada = document.getElementById("fechaInicioAnulada");
  const fechaFinalAnulada = document.getElementById("fechaFinalAnulada");
  // const alertaFecha = document.getElementById("alerta-fecha");

  let idInsumos = [];

  // const Checks = document.querySelectorAll(".obtenerPrecio input");
  // const obtenerCuota = document.getElementById('tbody2').getElementsByTagName('td');
  // const obtenida = obtenerCuota[2].textContent;
  let array = [];
  const informacionCita = async (fac, r) => {
    // array = [];
    console.log(r);
    array.push(r);
    console.log(array);
    try {
      let buscarCita = await fetch(
        "?c=ControladorReportes/buscarCita&id_factura=" + fac
      );
      let respuesta = await buscarCita.json();
      let html = ``;
      let htmlServ = ``;

      if (respuesta.length > 0) {
      
        console.log(respuesta);
        html = ``;
        respuesta.forEach((cita) => {
          html += `<p class="text-center">${cita.especialidad} Dr ${cita.nombre_d} ${cita.apellido_d} ${cita.precio_servicio} Bs</p> `;
        });

        console.log(array)
        array.forEach((mas) => {
          if (mas.id_categoria != 9) {
          htmlServ += ` <p class="text-center">${mas.categoria_servicio} Dr ${mas.nombre_d} ${mas.apellido_d} ${mas.precio} Bs</p>
               `;
               }
        });

        let masServ = document.querySelectorAll(".masSer");
        masServ.forEach((fa) => {
          fa.innerHTML = html;
        });

        let masServicios = document.querySelectorAll(".masServicios");
        masServicios.forEach((fa) => {
          fa.innerHTML = htmlServ;
        });
      } else {
        console.log("No se econtraron resultados");
        let masServ = document.querySelectorAll(".masSer");
        masServ.forEach((fa) => {
          fa.textContent = "";
        });

        let masServicios = document.querySelectorAll(".masServicios");
        masServicios.forEach((fa) => {
          fa.textContent = "";
        });
      }
      // return html;
    } catch (error) {
      console.log("Error en la solicitud:", error);
    }
  };

  const informacionfactura = async (fac) => {
    try {
      let peticionAjax = await fetch(
        "?c=ControladorReportes/buscarPago&id_factura=" + fac
      );
      let respuesta = await peticionAjax.json();
      let html = ``;
      if (respuesta.length > 0) {
        console.log(respuesta);
        html = ``;
        respuesta.forEach((r) => {
          if (r.nombre == "Efectivo") {
            html += `<p class="text-center">${r.nombre} Monto:  ${r.monto} Bs</p>`;
          } else {
            html += `<p class="text-center">${r.nombre} Monto:   ${r.monto} Bs Ref:${r.referencia}</p>`;
          }
        });

        console.log(html);
        let pagofac = document.querySelectorAll(".pagoDefac");
        pagofac.forEach((fa) => {
          fa.innerHTML = html;
        });
      } else {
        console.log("No se econtraron resultados");
      }
      let peticionAjax2 = await fetch(
        "?c=ControladorReportes/buscarMasServicios&id_factura=" + fac
      );
      let respuesta2 = await peticionAjax2.json();
      let html2 = ``;
      if (respuesta2.length > 0) {
        console.log(respuesta2);
        html2 = ``;
        respuesta2.forEach((r) => {
          if (r.id_cita == null) {
           console.log("con servicios")
            
            html2 += `<p class="text-center">${r.categoria_servicio} Dr ${r.nombre_d} ${r.apellido_d} ${r.precio} Bs</p>`;
            // let imprimirpdf = document.querySelectorAll(".pdf");
            // console.log(imprimirpdf);let masServ = document.querySelectorAll(".masSer");
            let masServ = document.querySelectorAll(".masSer");
            masServ.forEach((fa) => {
              fa.innerHTML = html2;
            });
            
          } else {
            console.log("con cita")

            informacionCita(fac, r);
          }
        });
        // let masServ = document.querySelectorAll(".masSer");
        // masServ.forEach((fa) => {
        //   fa.innerHTML = html2;
        // });
      } else {
        let masServ = document.querySelectorAll(".masSer");
        masServ.forEach((fa) => {
          fa.textContent = "";
        });
        let masServicios = document.querySelectorAll(".masServicios");
        masServicios.forEach((fa) => {
          fa.textContent = "";
        });
        console.log("No se econtraron resultados");
      }
      let peticionAjax3 = await fetch(
        "?c=ControladorReportes/buscarInsumos&id_factura=" + fac
      );
      let respuesta3 = await peticionAjax3.json();
      console.log(respuesta3)
      let html3 = ``;

      if (respuesta3.length > 0) {
        console.log(respuesta3);
        html3 = ``;
        respuesta3.forEach((r) => {
          idInsumos.push(r.id_insumo)
          console.log(idInsumos)
          html3 += `<p class="text-center"><input type="hidden" value="${r.numero_de_lote}" name="numero_de_lote">${r.nombre} Cantidad: ${r.cantidad} Unidad:${r.precio} Bs</p>`;
        });
        let insumos = document.querySelectorAll(".insumos");
        insumos.forEach((fa) => {
          fa.innerHTML = html3;
        });
      } else {
        console.log("No se econtraron resultados");
        let insumos = document.querySelectorAll(".insumos");
        insumos.forEach((fa) => {
          fa.textContent = "";
        });
      }
    } catch (error) {
      console.log("Error en la solicitud:"+ error);
    }
  };

  // buscarC.addEventListener("submit", (e) => {
  //     e.preventDefault();
  //     buscarCreditoCliente(buscarC);
  // });

  const anularFac = async (anular,i) => {
    try {
      await fetch("?c=ControladorReportes/anularFactura&id_factura=" + anular+ "&id_insumo="+ i);
      
      //   let respuesta = await buscarCita.json();
      //  let html = ``;
      //   if (respuesta.length > 0) {
      //       console.log(respuesta);
      //       html = ``;
      //       respuesta.forEach((cita) => {

      //         html += `<p class="text-center">${cita.especialidad} Dr ${cita.nombre_d} ${cita.apellido_d} ${cita.precio_servicio} Bs</p>
      //          <p class="text-center">${r.categoria_servicio} Dr ${r.nombre_d} ${r.apellido_d} ${r.precio} Bs</p>`
      //         ;

      //       });

      //       let masServ =  document.querySelectorAll('.masSer');
      //       masServ.forEach(fa => {
      //      fa.innerHTML=html;

      //    });

      //   }else{
      //   console.log("No se econtraron resultados");

      //   }
    } catch (error) {
      console.log("Error en la solicitud:", error);
    }
  };

  function facturaAnular(anular,i) {
    anularFac(anular,i);
    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbody tr");
    // recolecto el nombre del input
    let valorInputPaciente = anular;
    console.log(valorInputPaciente);

    // se convierte en minúscula

    // recorro las filas de la tabla
    filas.forEach((fila) => {
      // cuenta los síntomas que existen.

      console.log(fila.children[0]);
      let paciente = fila.children[0].innerText;

      // se convierte en minúscula
      paciente = paciente.toLowerCase();

      // verifico si el nombre existe
      if (paciente.includes(valorInputPaciente)) {
        fila.classList.add("d-none");
      }
      // else {
      // 	fila.classList.add("d-none");

      // 	// cuenta las veces que no encuentra un síntoma
      // }
    });
  }

  infoFactura.forEach((info) => {
    info.addEventListener("click", () => {
      let fac = info.name;
      array = [];
      console.log("holaaaa");

      informacionfactura(fac);
    });

    anularFactura.forEach((anu) => {
      anu.addEventListener("click", () => {
        let anular = anu.name;
        facturaAnular(anular,idInsumos);
      });
    });
  });

  //sirve para buscar las entradas por rango de fecha
  const traerPorFecha = () => {
    if (fechaInicio.value >= fechaFinal.value) {
      alertaFecha.classList.remove("d-none");
      alertaFecha.innerText =
        "VERIFIQUE QUE LA FECHA DE  INICIO SEA MENOR A LA FECHA FINAL";

      //funcion de js para el tiempo
      setTimeout(function () {
        alertaFecha.classList.add("d-none");
      }, 8000);
    } else {
      document
        .getElementById("tbodyReporte")
        .querySelectorAll("tr")
        .forEach((ele) => {
          //y este es para un insumo en espifico

          if (
            ele.children[3].innerText >= fechaInicio.value &&
            ele.children[3].innerText <= fechaFinal.value
          ) {
            console.log("W");
            document.getElementById("btnImprimir").classList.remove("d-none");
            ele.classList.remove("d-none");
            
          } else {
            ele.classList.add("d-none");
           
          }
        });
    }
  };

  document.getElementById("btnImprimir").addEventListener("click",function(){
    formularioDeFecha.submit();
  })




  //sirve para buscar las entradas por rango de fecha de las facturas
  const traerPorFechaAnulada = () => {
    if (fechaInicioAnulada.value >= fechaFinalAnulada.value) {
      // alertaFecha.classList.remove("d-none");
      // alertaFecha.innerText =
      //   "VERIFIQUE QUE LA FECHA DE  INICIO SEA MENOR A LA FECHA FINAL";

      // //funcion de js para el tiempo
      // setTimeout(function () {
      //   alertaFecha.classList.add("d-none");
      // }, 8000);
    } else {
      document
        .getElementById("tbodyAnuladas")
        .querySelectorAll("tr")
        .forEach((ele) => {
          //y este es para un insumo en espifico

          if (
            ele.children[3].innerText >= fechaInicioAnulada.value &&
            ele.children[3].innerText <= fechaFinalAnulada.value
          ) {
            console.log("W");
            document.getElementById("btnImprimirAnulada").classList.remove("d-none");
            ele.classList.remove("d-none");
          } else {
            ele.classList.add("d-none");
           
          }
        });
    }
  };

  document.getElementById("btnImprimirAnulada").addEventListener("click",function(){
    formularioDeFechaAnulada.submit();
  })



  formularioDeFecha.addEventListener("submit",function(e){
    e.preventDefault();
  })

  document.getElementById("buscarFecha").addEventListener("click",function(){
    traerPorFecha();

  })



//anuladas
  formularioDeFechaAnulada.addEventListener("submit",function(e){
    e.preventDefault();
  })

  document.getElementById("buscarFechaAnulada").addEventListener("click",function(){

    traerPorFechaAnulada();

  })
  console.log(document.getElementById("buscarFechaAnulada"))

  let inputPaciente = document.querySelector("#inputBuscarEspecialidad");

  function buscarPaciente() {
    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbody tr");
    // recolecto el nombre del input
    let valorInputPaciente = inputPaciente.value;
    // se convierte en minúscula
    valorInputPaciente = valorInputPaciente.toLowerCase();
    let coincidenciasEncontradas = 0;
    // recorro las filas de la tabla
    filas.forEach((fila) => {
      // cuenta los síntomas que existen.

      console.log(fila.children[1]);
      let paciente = fila.children[1].innerText;

      // se convierte en minúscula
      paciente = paciente.toLowerCase();

      // verifico si el nombre existe
      if (paciente.includes(valorInputPaciente)) {
        fila.classList.remove("d-none");
        coincidenciasEncontradas++;
      } else {
        fila.classList.add("d-none");

        // cuenta las veces que no encuentra un síntoma
      }

      inputPaciente.addEventListener("keyup", () => {
        if (inputPaciente.value === "") {
          fila.classList.remove("d-none");
        }
      });
    });

    if (coincidenciasEncontradas === 0) {
      document.getElementById("noresultados").classList.remove("d-none");
    } else {
      document.getElementById("noresultados").classList.add("d-none");
    }
  }

  inputPaciente.addEventListener("keyup", function () {
    buscarPaciente();
  });

  let facturasAnuladas = document.querySelector("#buscarFacturasAnuladas");

  function buscarPaciente() {
    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbodyAnuladas tr");
    // recolecto el nombre del input
    let valorfacturasAnuladas = facturasAnuladas.value;
    // se convierte en minúscula
    valorfacturasAnuladas = valorfacturasAnuladas.toLowerCase();
    let coincidenciasEncontradas = 0;
    // recorro las filas de la tabla
    filas.forEach((fila) => {
      // cuenta los síntomas que existen.

      console.log(fila.children[1]);
      let paciente = fila.children[1].innerText;

      // se convierte en minúscula
      paciente = paciente.toLowerCase();

      // verifico si el nombre existe
      if (paciente.includes(valorfacturasAnuladas)) {
        fila.classList.remove("d-none");
        coincidenciasEncontradas++;
      } else {
        fila.classList.add("d-none");

        // cuenta las veces que no encuentra un síntoma
      }

      facturasAnuladas.addEventListener("keyup", () => {
        if (facturasAnuladas.value === "") {
          fila.classList.remove("d-none");
        }
      });
    });

    if (coincidenciasEncontradas === 0) {
      document
        .getElementById("noresultadosAnuladas")
        .classList.remove("d-none");
    } else {
      document.getElementById("noresultadosAnuladas").classList.add("d-none");
    }
  }

  facturasAnuladas.addEventListener("keyup", function () {
    buscarPaciente();
  });
});
