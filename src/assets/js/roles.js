addEventListener("DOMContentLoaded", function () {
  console.log("roles");

  const traerPermisos = async (id, caja) => {
    try {
      let peticion = await fetch(
        "/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrarPermisos/" + id
      );
      let resultado = await peticion.json();
      console.log(resultado);

      let html = ``;

      if (resultado.length > 0) {
        resultado.forEach((res) => {
          html += `<div class="input-modal mt-3">
          <ul uk-accordion="multiple: true" class="uk-accordion">
            <li class="">
              <a
                class="uk-accordion-title text-decoration-none"
                href="#"
                id="uk-accordion-22-title-0"
                role="button"
                aria-controls="uk-accordion-22-content-0"
                aria-expanded="false"
                aria-disabled="false"
              >
                <h6 class="acordion-paciente fw-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    class="bi bi-calendar2-week-fill azul mb-2"
                    viewBox="0 0 16 16"
                  >
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                  </svg>
                 ${res.modulo}
                </h6>
              </a>

              <div
                class="uk-accordion-content" data-index="${res.modulo}"
                id="uk-accordion-22-content-0"
                role="region"
                aria-labelledby="uk-accordion-22-title-0"
                hidden=""
              >
              </div>
            </li>
          </ul>
        </div>`;
        });

        caja.innerHTML = html;

        //elijo el contenedor donde voy a mostar los permisos

        document
          .querySelectorAll(".uk-accordion-content")
          .forEach((content) => {
            console.log(content);

            traerPermisosPorModulo(content.getAttribute("data-index"), content);
          });
      } else {
        console.log("no hay nada");
      }
    } catch (error) {
      console.log("Algo salio mal con los permisos " + error);
    }
  };

  const traerPermisosPorModulo = async (modulo, caja) => {
    try {
      let peticion = await fetch(
        "/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrarPermisosPorModulo/" +
          modulo
      );
      let resultado = await peticion.json();
      console.log(resultado);

      let html = ``;

      if (resultado.length > 0) {
        resultado.forEach((res) => {
          html += `<div class="form-check form-switch d-flex align-items-center">
                        <div>
                            <input class="form-check-input " checked="true" disabled type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                value="${res.idpermisos}">
                        </div>
                        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                
                        ${res.nombre}
                            </label></div>

                    </div>`;
        });

        caja.innerHTML = html;
      } else {
        console.log("no hay nada");
      }
    } catch (error) {
      console.log(
        "algo salio muy mal con la peticion de permisos por modulo " + error
      );
    }
  };

  //Recorrer todos los botones de mostrar
  document.querySelectorAll(".btn-mostrar-permisos").forEach((btn) => {
    //Llamo a un evento click para que cuando se presione el boton se active la funcion
    btn.addEventListener("click", function () {
      //Seleccion la caja especifica que voy a usar

      let cajaModal = document.querySelector(
        ".caja-de-permisos" + this.getAttribute("data-index")
      );

      console.log("hola");

      traerPermisos(this.getAttribute("data-index"), cajaModal);
    });
  });
});
