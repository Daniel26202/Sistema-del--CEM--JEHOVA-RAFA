document.addEventListener('DOMContentLoaded', function () {
  function Ayuda() {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "¡BIENVENIDO AL INICIO DE DEL SISTEMA!",
          },

          {
            element: document.querySelector(".Inicioh1"),
            intro: "DESDE AQUÍ PODRÁS ENCONTRAR INFORMACIÓN RELEVANTE ADEMAS DE PODER NAVEGAR POR EL SISTEMA",
          },
          {
            element: document.querySelector("#tarjetaInicio1"),
            intro: "AQUÍ PODRÁS ENCONTRAR EL NUMERO DE CITAS PENDIENTES EN EL SISTEMA.",
          },
          {
            element: document.querySelector("#tarjetaInicio2"),
            intro: "AQUÍ PODRÁS ENCONTRAR EL NUMERO DE CITAS PARA HOY EN EL SISTEMA.",
          },
          {
            element: document.querySelector("#tarjetaInicio3"),
            intro: "AQUÍ PODRÁS ENCONTRAR EL NUMERO DE HOSPITALIZACIONES PENDIENTES EN EL SISTEMA.",
          },
          {
            element: document.querySelector("#grafica1"),
            intro: "AQUÍ PODRÁS VISUALIZAR INFORMACION DE LAS 5 ESPECIALIDADES MAS SOLICITADAS EN FORMA GRAFICA.",
          },
          {
            element: document.querySelector("#btnGrafica1"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF",
          },
          {
            element: document.querySelector("#grafica2"),
            intro: "AQUÍ PODRÁS VISUALIZAR INFORMACION DE LAS 5 SINTOMAS  MAS COMUNES EN FORMA GRAFICA.",
          },
          {
            element: document.querySelector("#btnGrafica2"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF",
          },
          {
            element: document.querySelector("#calendarCard"),
            intro: "AQUÍ EN EL CALENDARIO PODRAS CONSULTAR LAS FECHAS CON MAS CITAS Y FILTRAR LAS POR DOCTOR",
          },
          {
            element: document.querySelector("#precioConsultas"),
            intro: "AQUÍ  PODRAS VISUALIZAR LOS PRECIOS DE LAS CONSULTAS QUE OFRECEMOS DE UNA MANERA RAPIDA",
          },
          {
            element: document.querySelector("#aside"),
            intro: "MENÚ DE NAVEGACIÓN",
          },
          {
            element: document.querySelector("#menu"),
            intro: "AL HACER CLICK A ESTE BOTÓN SE DESPLIEGA EL MENÚ",
          },
          {
            element: document.querySelector("#menuInicio"),
            intro: "AL PULSAR ESTE ÍCONO PODRÁS VOLVER AL INICIO DESDE CUALQUIER PARTE DEL SISTEMA",
          },
          {
            element: document.querySelector("#menuPacientes"),
            intro: "TE DIRIGE AL MÓDULO DE PACIENTES",
          },
          {
            element: document.querySelector("#menuPatologias"),
            intro: "TE DIRIGE AL MÓDULO DE PATOLOGIAS",
          },
          {
            element: document.querySelector("#menuFacturacion"),
            intro: "TE DIRIGE AL MÓDULO DE FACTURACIÓN",
          },
          {
            element: document.querySelector("#menuCitas"),
            intro: "TE DIRIGE AL MÓDULO DE CITAS",
          },
          {
            element: document.querySelector("#menuServicios"),
            intro: "TE DIRIGE AL MODULO DE SERVICIOS  DONDE ENCONTRARÁS LOS SERVICIOS MÉDICOS QUE OFRECEMOS",
          },
          {
            element: document.querySelector("#menuDirectorioMedico"),
            intro: "TE DIRIGE AL DIRECTORIO MÉDICO DONDE ENCONTRARÁS EL REGISTRO DE DOCTORES",
          },
          {
            element: document.querySelector("#menuControlMedico"),
            intro: "TE DIRIGE AL MÓDULO DE CONTROL MÉDICO",
          },
          {
            element: document.querySelector("#menuHospitalizacion"),
            intro: "TE DIRIGE AL MÓDULO DE HOSPITALIZACIONES",
          },
          {
            element: document.querySelector("#menuInsumos"),
            intro: "TE DIRIGE AL INVENTARIO DONDE PODRÁS GESTIONAR LOS INSUMOS, LAS ENTRADAS Y LOS PROVEEDORES",
          },
          {
            element: document.querySelector("#menuUsuarios"),
            intro: "TE DIRIGE AL MÓDULO DE USUARIOS",
          },
          {
            element: document.querySelector("#menuReportes"),
            intro: "TE DIRIGE AL MÓDULO DE REPORTES",
          },
          {
            element: document.querySelector("#menuReportesEstadisticos"),
            intro: "TE DIRIGE AL MÓDULO DE REPORTES ESTADISTICOS",
          },

          {
            element: document.querySelector(".desplegableAyuda"),
            intro:
              "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL , EL BOTÓN PARA ACCEDER A LA AYUDA ,CONFIGURACIONES Y CERRAR SESSION",
          },

          {
            intro: "FIN DEL RECORRIDO POR EL INICIO, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  }


  // pantalla grande 
  document.querySelector('#btnayudaInicio').addEventListener("click", function () {
    Ayuda();
  })

  // // modo responsivo
  // document.querySelector('#btnayudaInicioDos').addEventListener("click", function () {
  //   Ayuda("btnayudaInicioDos", "inicioCerrarSesionDos", "manualDos", "inicioPerfil");
  // })
  // })

});