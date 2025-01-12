document.addEventListener('DOMContentLoaded', function () {

  function Ayuda() {
    introJs().setOptions({
      steps: [
        {
          intro: "¡BIENVENIDO AL INICIO DE DEL SISTEMA!"
        },

        {
          element: document.querySelector('#Inicioh1'),
          intro: "DESDE AQUÍ PODRÁS ENCONTRAR INFORMACIÓN RELEVANTE ADEMAS DE PODER NAVEGAR POR EL SISTEMA"
        },
        {
          element: document.querySelector('#tarjetaInicio1'),
          intro: "INFORMACIÓN RELEVANTE"
        },
        {
          element: document.querySelector('#tarjetaInicio2'),
          intro: "INFORMACIÓN RELEVANTE"
        },
        {
          element: document.querySelector('#aside'),
          intro: "MENÚ DE NAVEGACIÓN"
        },
        {
          element: document.querySelector('#menu'),
          intro: "AL HACER CLICK A ESTE BOTÓN SE DESPLIEGA EL MENÚ"
        },
        {
          element: document.querySelector('#menuInicio'),
          intro: "AL PULSAR ESTE ÍCONO PODRÁS VOLVER AL INICIO DESDE CUALQUIER PARTE DEL SISTEMA"
        },
        {
          element: document.querySelector('#menuPacientes'),
          intro: "TE DIRIGE AL MÓDULO DE PACIENTES"
        },
        {
          element: document.querySelector('#menuFacturacion'),
          intro: "TE DIRIGE AL MÓDULO DE FACTURACIÓN"
        },
        {
          element: document.querySelector('#menuCitas'),
          intro: "TE DIRIGE AL MÓDULO DE CITAS"
        },
        {
          element: document.querySelector('#menuDirectorioMedico'),
          intro: "TE DIRIGE AL DIRECTORIO MÉDICO DONDE ENCONTRARÁS LOS SERVICIOS MÉDICOS, EL REGISTRO DE DOCTORES Y LOS SERVICIOS EXTRAS QUE OFRECEMOS"
        },
        {
          element: document.querySelector('#menuControlMedico'),
          intro: "TE DIRIGE AL MÓDULO DE CONTROL MÉDICO"
        },
        {
          element: document.querySelector('#menuHospitalizacion'),
          intro: "TE DIRIGE AL MÓDULO DE HOSPITALIZACIONES"
        },
        {
          element: document.querySelector('#menuInsumos'),
          intro: "TE DIRIGE AL INVENTARIO DONDE PODRÁS GESTIONAR LOS INSUMOS, LAS ENTRADAS Y LOS PROVEEDORES"
        },
        {
          element: document.querySelector('#menuUsuarios'),
          intro: "TE DIRIGE AL MÓDULO DE USUARIOS"
        },
        {
          element: document.querySelector('#menuReportes'),
          intro: "TE DIRIGE AL MÓDULO DE REPORTES"
        },
        {
          element: document.querySelector(`#${btnPerfil}`),
          intro: "TE DIRIGE A TU PERFIL DONDE PODRÁS VISUALIZAR TUS DATOS"
        },
        {
          element: document.querySelector(`#${btnManual}`),
          intro: "AL PRESIONAR ESTE BOTÓN CIERRAS LA SESIÓN, UNA VEZ CIERRES SESIÓN TENDRÁS QUE INGRESAR NUEVAMENTE CON TU USUARIO Y CONTRASEÑA"
        },
        {
          element: document.querySelector(`#${btnCS}`),
          intro: "AL PRESIONAR ESTE BOTÓN CIERRAS LA SESIÓN, UNA VEZ CIERRES SESIÓN TENDRÁS QUE INGRESAR NUEVAMENTE CON TU USUARIO Y CONTRASEÑA"
        },
        {
          element: document.querySelector(`#${btnAyuda}`),
          intro: "PUEDES ACCEDER A LA AYUDA HACIENDO CLICK A ESTE BOTÓN"
        },


        {
          intro: "FIN DEL RECORRIDO POR EL INICIO, ESPERO HABERTE AYUDADO"
        }
      ],
      
      nextLabel: "Siguiente",
      prevLabel: "Anterior",
      doneLabel: "Finalizar",
    }).start();
  }


  // pantalla grande 
  document.querySelector('#btnayudaInicio').addEventListener("click", function () {
    Ayuda("btnayudaInicio", "inicioCerrarSesion", "manual", "inicioPerfil");
  })

  // modo responsivo
  document.querySelector('#btnayudaInicioDos').addEventListener("click", function () {
    Ayuda("btnayudaInicioDos", "inicioCerrarSesionDos", "manualDos", "inicioPerfil");
  })

});


//   document.getElementById("btnayudaInicio").addEventListener("click", function () {
    // introJs().setOptions({
    //   steps: [
    //     {
    //       intro: "¡BIENVENIDO AL INICIO DE DEL SISTEMA!"
    //     },

    //     {
    //       element: document.querySelector('#Inicioh1'),
    //       intro: "DESDE AQUÍ PODRÁS ENCONTRAR INFORMACIÓN RELEVANTE ADEMAS DE PODER NAVEGAR POR EL SISTEMA"
    //     },
    //     {
    //       element: document.querySelector('#tarjetaInicio1'),
    //       intro: "INFORMACIÓN RELEVANTE"
    //     },
    //     {
    //       element: document.querySelector('#tarjetaInicio2'),
    //       intro: "INFORMACIÓN RELEVANTE"
    //     },
    //     {
    //       element: document.querySelector('#aside'),
    //       intro: "MENÚ DE NAVEGACIÓN"
    //     },
    //     {
    //       element: document.querySelector('#menu'),
    //       intro: "AL HACER CLICK A ESTE BOTON SE DESPLIEGA EL MENÚ"
    //     },
    //     {
    //       element: document.querySelector('#menuInicio'),
    //       intro: "AL PULSAR ESTE ÍCONO PODRÁS VOLVER AL INICIO DESDE CUALQUIER PARTE DEL SISTEMA"
    //     },
    //     {
    //       element: document.querySelector('#menuPacientes'),
    //       intro: "TE DIRIJE AL MÓDULO DE PACIENTES"
    //     },
    //     {
    //       element: document.querySelector('#menuFacturacion'),
    //       intro: "TE DIRIJE AL MÓDULO DE FACTURACIÓN"
    //     },
    //     {
    //       element: document.querySelector('#menuCitas'),
    //       intro: "TE DIRIJE AL MÓDULO DE CITAS"
    //     },
    //     {
    //       element: document.querySelector('#menuDirectorioMedico'),
    //       intro: "TE DIRIJE AL DIRECTORIO MÉDICO DONDE ENCONTRARÁS LOS SERVICIOS MÉDICOS, EL REGISTRO DE DOCTORES Y LOS SERVICIOS EXTRAS QUE OFRECEMOS"
    //     },
    //     {
    //       element: document.querySelector('#menuControlMedico'),
    //       intro: "TE DIRIJE AL MÓDULO DE CONTROL MÉDICO"
    //     },
    //     {
    //       element: document.querySelector('#menuHospitalizacion'),
    //       intro: "TE DIRIJE AL MÓDULO DE HOSPITALIZACIONES"
    //     },
    //     {
    //       element: document.querySelector('#menuEmergencias'),
    //       intro: "TE DIRIJE AL MÓDULO DE EMERGENCIAS"
    //     },
    //     {
    //       element: document.querySelector('#menuInsumos'),
    //       intro: "TE DIRIJE AL INVENTARIO DONDE PODÁS GESTIONAR LOS INSUMOS, LAS ENTRADAS Y LOS PROVEEEDORES"
    //     },
    //     {
    //       element: document.querySelector('#menuUsuarios'),
    //       intro: "TE DIRIJE AL MÓDULO DE USUARIOS"
    //     },
    //     {
    //       element: document.querySelector('#menuReportes'),
    //       intro: "TE DIRIJE AL MÓDULO DE REPORTES"
    //     },
    //     {
    //       element: document.querySelector('#inicioPerfil'),
    //       intro: "TE DIRIJE A TU PERFIL DONDE PODRÁS VISUALIZAR TUS DATOS"
    //     },
    //     {
    //       element: document.querySelector('#inicioCerrarSesion'),
    //       intro: "AL PRESIONAR ESTE BOTÓN CIERRAS LA SESIÓN, UNA VEZ CIERRES SESIÓN TENDRÁS QUE INGRESAR NUEVAMENTE CON TU USUARIO Y CONTRASEÑA"
    //     },
    //     {
    //       element: document.querySelector('#btnayudaInicio'),
    //       intro: "PUEDES ACCEDER A LA AYUDA HACIENDO CLICK A ESTE BOTÓN"
    //     },


    //     {
    //       intro: "FIN DEL RECORRIDO POR EL INICIO, ESPERO HABERTE AYUDADO"
    //     }
    //   ],

    //   nextLabel: "Siguiente",
    //   prevLabel: "Anterior",
    //   doneLabel: "Finalizar",
    // }).start();
