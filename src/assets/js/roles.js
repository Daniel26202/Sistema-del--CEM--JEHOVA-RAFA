addEventListener("DOMContentLoaded", function () {
  console.log("roles");

  const traerPermisos = async (id, listaDeCheckbox, modulos) => {
    try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrarPermisos/" + id
    );
    let resultado = await peticion.json();
    console.log(resultado);

    if (resultado.length > 0) {
      modulos.forEach((modulo, index) => {
        let porModulo = listaDeCheckbox.filter(
          (element) =>
            element.getAttribute("data-index") === modulo.innerText.trim()
        );

        let permisos = resultado[index]?.permisos
          ? resultado[index].permisos.split(",")
          : [];

        porModulo.forEach((checkbox, indexPermisos) => {
          checkbox.checked = false; // Reinicia el checkbox antes de asignar un valor

          if (
            permisos[indexPermisos] !== undefined &&
            permisos[indexPermisos] == checkbox.value
          ) {
            checkbox.checked = true;
          }
        });
      });
    }
    } catch (error) {
      console.log("Algo salió mal con la petición de permisos: " + error);
    }
  };

  // const traerPermisosPorModulo = async (modulo, caja) => {
  //   try {
  //     let peticion = await fetch(
  //       "/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrarPermisosPorModulo/" +
  //         modulo
  //     );
  //     let resultado = await peticion.json();
  //     console.log(resultado);

  //     let html = ``;

  //     if (resultado.length > 0) {
  //       resultado.forEach((res) => {
  //         html += `<div class="form-check form-switch d-flex align-items-center">
  //                       <div>
  //                           <input class="form-check-input checkboxPermiso" type="checkbox" role="switch" id="flexSwitchCheckDefault"
  //                               value="${res.idpermisos}">
  //                       </div>
  //                       <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                
  //                       ${res.nombre}
  //                           </label></div>

  //                   </div>`;
  //       });

  //       caja.innerHTML = html;

  //       let id_rol =
  //         caja.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement
  //           .getAttribute("id")
  //           .substring(20);
  //       //Llamar a la funcion para checkear los permisos del rol

  //       document.querySelectorAll(".checkboxPermiso").forEach((checkbox) => {
  //         //console.log(checkbox.getAttribute("data-index"));
  //         checkearPermisos(checkbox.value, checkbox, id_rol);
  //       });
  //     } else {
  //       console.log("no hay nada");
  //     }
  //   } catch (error) {
  //     console.log(
  //       "algo salio muy mal con la peticion de permisos por modulo " + error
  //     );
  //   }
  // };

  //funcion para checkear los permisos que tiene el usuario

  const checkearPermisos = async (id, checkbox, rol) => {
    // try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Roles/permisosRol/" + id + "/" + rol
    );
    let resultado = await peticion.json();
    //console.log(resultado)

    // console.log("id_permisos"+id)
    // console.log("id_permisos json" + resultado.idpermisos);

    // console.log("id_rol" + rol);
    // console.log("id_rol json" + resultado.id_rol);

    if (id == resultado.idpermisos && rol == resultado.id_rol) {
      console.log(checkbox);
      checkbox.setAttribute("checked", true);
    } else {
      checkbox.setAttribute("checked", false);
    }
    // } catch (error) {
    //   console.log("Algo salio mal al checkear los permisos "+ error);
    // }
  };

  //Recorrer todos los botones de mostrar
  document.querySelectorAll(".btn-mostrar-permisos").forEach((btn) => {
    //Llamo a un evento click para que cuando se presione el boton se active la funcion
    btn.addEventListener("click", function () {
      //Seleccion la caja especifica que voy a usar

      let id_rol = this.getAttribute("data-index");

      const modalMostrar = document.getElementById(
        "modal-exampleMostrar" + id_rol
      );

      let listaDeCheckbox = modalMostrar.querySelectorAll(".checkboxPermiso");

      let modulo = modalMostrar.querySelectorAll(".acordion-mostrar");

      traerPermisos(id_rol, listaDeCheckbox, modulo);
    });
  });
});
