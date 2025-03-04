<div id="modal-examplePaciente" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
    <!-- Boton que cierra el modal -->
    <a href="#">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
      </svg>
    </a>

    <div class="d-flex align-items-center mb-3">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>
      </div>
      <div class="">
        <p class="uk-modal-title fs-5 ">
          Registrar Paciente
        </p>
      </div>

    </div>
    <div class="alert alert-danger d-none" role="alert" id="alerta">
      <div class="">
        <p style="font-size: 13px;" class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
      </div>
    </div>

    <form class="form-modal" id="modalAgregar" action="?c=ControladorPacientes/guardar" method="POST" autocomplete="off">
      <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'];?>">

      <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
          </svg>
        </span>
        <span class="">
          <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
            <option value="V" selected>V</option>
            <option value="E">E</option>
          </select>
        </span>

        <input class="form-control input-modal input-disabled input-paciente" style="width: 7vh !important;" type="number" id="cedula" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
      </div>
      <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>

        <input class="form-control mayuscula input-modal input-disabled input-paciente" type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="11">
      </div>

      <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>
        <input class="form-control input-modal mayuscula input-disabled input-paciente" type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="11">
      </div>

      <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="number" id="telefono" name="telefono" placeholder="Telefono" required maxlength="18">
      </div>

      <div class="input-group flex-nowrap margin-inputs" id="grp_direccion">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
          </svg>
        </span>
        <input class="form-control  mayuscula input-modal input-disabled input-paciente" type="text" id="direccion" name="direccion" placeholder="Direccion" required maxlength="20">
      </div>

      <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
      <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="date" id="fn" name="fn" placeholder="Fn" required pattern="\d{4}-\d{2}-\d{2}">
      </div>


      <!-- <div class="input-modal mt-3">
        <ul uk-accordion="multiple: true">
          <li>
            <a class="uk-accordion-title text-decoration-none" href="#">

              <h6 class="acordion-paciente fw-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                </svg>
                Añadir Patologia Paciente
              </h6>
            </a>

            <div class="uk-accordion-content">
              <div class="d-flex justify-content-between flex-wrap">
                <?php foreach ($datosPatologias as $patologia) : ?>

                  <div class="d-flex w-50 justify-content-between mb-3">

                    <div class="form-check form-switch d-flex align-items-center">
                      <div>
                        <input class="form-check-input " type="checkbox" role="switch" id="flexSwitchCheckDefault" name="patologias[]" value="<?php echo $patologia['id_patologia'] ?>">
                      </div>
                      <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                          <?php echo $patologia['nombre_patologia'] ?>
                        </label></div>

                    </div>


                  </div>
                <?php endforeach ?>


              </div>
            </div>
          </li>
        </ul>



      </div> -->


      <div class="mt-3 uk-text-right">
        <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
        <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="crear" id="botonEnviar">Agregar</button>
      </div>
    </form>
  </div>
</div>


<!-- Modal que Muestra los resultados de la busqueda -->

<!-- Modal -->
<div class="modal fade modalBuscadorP" id="exampleModalBuscador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content modalBuscador">
      <div>
        <a href="#" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
        <h5 class="fw-bolder mt-3 ms-3 text-uppercase" id="exampleModalLabel">Paciente</h5>
      </div>

      <div class="modal-body ">


        <article class="uk-comment" role="comment" id="articulo">
          <header class="uk-comment-header">
            <div class="uk-grid-medium uk-flex-middle" uk-grid>
              <div class="uk-width-auto">

                <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">

                <div class="d-flex justify-content-center mt-2" id="modalesBuscador">
                  <div class="me-2">

                    <a href="#" uk-toggle="target:#Buscadoreditar" data-bs-dismiss="modal" aria-label="Close">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-pencil-square text-black" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                      </svg>
                    </a>
                  </div>

                  <div>
                    <a href="#" uk-toggle="target:#eliminarBuscador" data-bs-dismiss="modal" aria-label="Close">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-trash3-fill text-black " viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                      </svg>
                    </a>
                  </div>
                </div>

              </div>
              <div class="uk-width-expand">

                <h4 class="uk-comment-title uk-margin-remove text-uppercase" id="nombrePaciente"><a class="uk-link-reset text-decoration-none " href="#">Luciano Guédez</a></h4>
                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top mt-2 margin" id="ul">
                  <li><a href="#" class="text-decoration-none" id="cedulab">30554088</a></li>
                  <li><a href="#" class="text-decoration-none" id="edadb">EDAD</a></li>
                  <li class=""><a href="#" class="text-decoration-none " id="telefonob">04245259901</a></li>
                  <li><a href="#" class="text-decoration-none" id="direccionb">La Lagunita</a></li>
                </ul>
                <div class="d-flex">
                  <p class="me-2 text-uppercase" id="patologiab">Hipertensión</p>
                  <p class="text-uppercase" id="descripcionb">Arterial</p>
                </div>
              </div>
            </div>

          </header>

        </article>
      </div>
      <div class="d-flex justify-content-end">
        <button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>
      </div>


    </div>
  </div>
</div>


<!-- <div id="Buscadoreditar" class="modalEditarBuscador" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
    <!-- Boton que cierra el modal -->
    <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
      </svg>
    </a>

    <div class="d-flex align-items-center mb-3">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>
      </div>
      <div class="">
        <p class="uk-modal-title fs-5 ">
          Modificar Paciente
        </p>
      </div>

    </div>

    <form action="?c=ControladorPacientes/setPaciente" method="POST" id="formEditar">

      <input class="form-control input-modal d-none input-disabled" type="text" name="id_paciente" placeholder="Id-paciente" id="id_pacienteBuscador">

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_cedulaEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
          </svg>
        </span>
        <span class="">
          <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidadEditar">
            <option id="selectB"></option>
            <option value="1">V</option>
            <option value="2">E</option>
          </select>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="text" id="cedulaEditarBuscador" required pattern="([0-9]{6,8}\S)|([0-9]{1,2}\.[0-9]{2,3}\.[0-9]{2,3}\S)" maxlength="8" name="cedulaEditar" placeholder="Cedula" value="">
      </div>

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_nombreEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente " type="text" id="nombreEditarBuscador" required pattern="([A-Z]{1})([a-z]{2,10})" maxlength="11" name="nombreEditar" placeholder="Nombre" value="">
      </div>

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_apellidoEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="text" id="apellidoEditarBuscador" required pattern="([A-Z]{1})([a-z]{2,10})" maxlength="11" name="apellidoEditar" placeholder="Apellido" value="">
      </div>

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_telefonoEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="text" id="telefonoEditarBuscador" name="telefonoEditar" required pattern="([+]{1}[\d]{1,4})?[\s.-]?([\d]{3,4})[\s.-]?([\d]{3})[\s.-]?([\d]{4})" maxlength="18" placeholder="Telefono" value="">
      </div>

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_direccionEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="text" id="direccionEditarBuscador" required pattern="([A-Za-z0-9\s\.,#-]+)" maxlength="20" name="direccionEditar" placeholder="Direccion" value="">
      </div>

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_fnEditar">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente" type="date" id="fnEditarBuscador" name="fnEditar" placeholder="Fn" required maxlength="20" value="" pattern="\d{2}\/\d{2}\/\d{4}">
      </div>

      
      
      <div class="mt-3 uk-text-right">
        <button data-bs-toggle="modal" data-bs-target="#exampleModalBuscador" class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
        <button class="btn col-4 btn-agregarcita-modal" type="submit">Modificar</button>
      </div>
    </form>
  </div>
</div> -->



<!-- Modal Eliminar -->

<div id="eliminarBuscador" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
    <!-- Boton que cierra el modal -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
      </svg>
    </a>

    <div class="d-flex align-items-center">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
        </svg>
      </div>
      <div>
        <h6>
          ¿Desea eliminar al Paciente?
        </h6>
      </div>
    </div>

    <form action="?c=ControladorPacientes/eliminarBuscador" method="POST">
      <input class="form-control input-modal d-none input-disabled" type="text" name="id_paciente" placeholder="Id-paciente" id="id_pacienteEliminarBuscador">


      <div class="mt-3 uk-text-right">
        <button data-bs-toggle="modal" data-bs-target="#exampleModalBuscador" class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

        <a href="">
          <button class="btn col-4 btn-agregarcita-modal" type="submit">Eliminar</button>
        </a>
    </form>
  </div>

</div>
</div>