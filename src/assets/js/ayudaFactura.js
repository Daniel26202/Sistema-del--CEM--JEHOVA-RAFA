document.getElementById('btnayudaFactura').addEventListener("click", function() {
    introJs().setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE FACTURACIÓN"
        },
    
      {
          element: document.querySelector('#inicioFactura'),
          intro: "DESDE AQUÍ PODRÁS FACTURAR LOS SERVICIOS MÉDICOS, LOS SERVICIOS EXTRAS Y LOS INSUMOS"
        },
        {
            element: document.querySelector('#botonAgregar'),
            intro: "CON ESTE BOTÓN PUEDES INSERTAR SERVICIOS EXTRAS A LA FACTURA"
          },
        {
            element: document.querySelector('#btnInsumos'),
            intro: "AQUI TIENES TODOS LOS INSUMOS DISPONIBLES"
          },
        
        {
            element: document.querySelector('#form-buscador'),
            intro: "AQUÍ TIENES UN BUSCADOR PARA BUSCAR EL PACIENTE AL CUAL SE VA A REALIZAR LA FACTURA"
          },
        {
          element: document.querySelector('#ayudaTabla1'),
          intro: "EN ESTA SECCIÓN SE VA A MOSTRAR EL SERVICIO MÉDICO A FACTURAR"
        },
        {
          element: document.querySelector('#ayudaTabla2'),
          intro: "EN ESTA SECCIÓN SE VAN A MOSTRAR LOS SERVICIOS EXTRAS INSERTADOS"
        },
        {
          element: document.querySelector('#ayudaTabla3'),
          intro: "EN ESTA SECCIÓN SE VAN A MOSTRAR LOS INSUMOS QUE AGREGUES A LA FACTURA"
        },
        {
          element: document.querySelector('#btnVaciar-Siguiente'),
          intro: "EN ESTA PARTE ENCONTRARAS EL BOTON DE VACIAR Y SIGUIENTE (PARA MOSTRARLOS TIENES QUE INSERTAR LOS SERVICIOS A FACTURAR)"
        },
        {
          element: document.querySelector('#totalFac'),
          intro: "AQUÍ PODRAS VER EL TOTAL DE LA FACTURA"
        },
        {
          element: document.querySelector('#desplegablefactura'),
          intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
        },
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DE FACTURACIÓN, ESPERO HABERTE AYUDADO"
        }
      ], 

      nextLabel: "Siguiente",
          prevLabel: "Anterior",
          doneLabel: "Finalizar",
    }).start();
  });


  document.getElementById('btnayudaFacturaIDCita').addEventListener("click", function() {
    introJs().setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE FACTURACIÓN"
        },
    
      {
          element: document.querySelector('#inicioFactura'),
          intro: "DESDE AQUÍ PODRÁS FACTURAR LOS SERVICIOS MÉDICOS, LOS SERVICIOS EXTRAS Y LOS INSUMOS"
        },
        {
            element: document.querySelector('#botonAgregar'),
            intro: "CON ESTE BOTÓN PUEDES INSERTAR SERVICIOS EXTRAS A LA FACTURA"
          },
          {
            element: document.querySelector('#btnInsumos'),
            intro: "AQUI TIENES TODOS LOS INSUMOS DISPONIBLES"
          },
          {
            element: document.querySelector('#btnRetrocederFactura'),
            intro: "AL OPRIMIR ESTE BOTON PODRÁS RETROCEDER AL MÓDULO DE CITAS NUEVAMENTE"
          },
        {
          element: document.querySelector('#tablaDB'),
          intro: "EN ESTA SECCIÓN SE MUESTRA EL SERVICIO MÉDICO A FACTURAR"
        },
        {
          element: document.querySelector('#tablaSE'),
          intro: "EN ESTA SECCIÓN SE MUESTRAN LOS SERVICIOS EXTRAS INSERTADOS"
        },
        {
          element: document.querySelector('#tablaIM'),
          intro: "EN ESTA SECCIÓN SE MUESTRAN LOS INSUMOS QUE AGREGUES A LA FACTURA"
        },
        {
          element: document.querySelector('#vaciarTabla'),
          intro: "AL PULSAR ESTE BOTÓN SE VACÍA LA FACTURA"
        },
        {
          element: document.querySelector('#siguienteFact'),
          intro: "AL PULSAR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL PARA LA GESTIÓN DEL PAGO Y LA CONFIRMACIÓN DE LA FACTURA"
        },
        {
          element: document.querySelector('#totalFac'),
          intro: "AQUÍ PODRAS VER EL TOTAL DE LA FACTURA"
        },
        {
          element: document.querySelector('#desplegablefactura2'),
          intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
        },
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DE FACTURACIÓN, ESPERO HABERTE AYUDADO"
        }
      ], 

      nextLabel: "Siguiente",
          prevLabel: "Anterior",
          doneLabel: "Finalizar",
    }).start();
  });
 