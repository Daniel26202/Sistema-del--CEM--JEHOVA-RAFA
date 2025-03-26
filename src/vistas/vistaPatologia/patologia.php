<?php require_once './src/vistas/head/head.php'; ?>



<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
  <div class="ms-5 d-flex align-items-center" id="inicioPacientes">
    <h1 class="fw-bold">PATOLOGÍAS</h1>
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-bandaid-fill ms-2"
      viewBox="0 0 16 16">
      <path
        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
    </svg>
  </div>

  <div class="me-4">

    <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
        class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablePaciente">
        <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
        <path
          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
      </svg></a>
    <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
      <ul>
        <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
              class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>PERFIL
          </a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="#" id="btnayudaPaciente"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
              fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
              <path
                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
            </svg>AYUDA</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="?c=ControladorBitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
              fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
              <path
                d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
            </svg> CONFIGURACIÓN</a></li>
        <li class="uk-nav-divider"></li>

        <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
            <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
              style="margin-left: -4px;">
            </svg>SALIR</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- modal de cerrar sesión -->
<?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>


<div class="div-tabla contenedorII m-auto mt-3" id="alertas">

  <?php if ($parametro != ""): ?>
    <?php if ($parametro[0] == 'agregado'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-registrar">EL Registro Se Inserto Correctamente
      </div>

    <?php elseif ($parametro[0] == 'error'): ?>
      <div class="alert alert-danger w-100 text-center alertas" id="alerta-eliminar">Ya existe la Patología</div>

    <?php elseif ($parametro[0] == 'eliminado'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-editar">La patología se elimino correctamente
      </div>

    <?php elseif ($parametro[0] == 'restablecida'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-editar">La patología se restableció
        correctamente</div>
    <?php endif; ?>

  <?php endif; ?>

  <div class="d-flex">
    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


      <ul class="sin-circulos d-flex justify-content-end">

        <li class="li">
          <div class="borde-de-menu  mb-1"></div>
          <div class="hover-grande">
            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/papeleraPatologias"
              class="text-decoration-none text-black me-3" id="DMservicioMedico">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
                <path
                  d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
              </svg>Papelera Patologías</a>
          </div>
        </li>


      </ul>

    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center">
    <!-- Boton Agregar Pacientes -->
    <!-- <div class="mover-input-agregarcita mt-4 ">
      <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-examplePaciente" id="btnRegistrarPaciente">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-person-fill-add me-1" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>Registrar Paciente
      </button>

    </div> -->

    <div class="mover-input-agregarcita responsive_patologia mt-4">
      <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-exampleAgregarPatologias"
        id="">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
          class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
          <path
            d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
        </svg>Registrar Patologia
      </button>

    </div>




    <!-- Buscador de pacientes -->
    <div class="mover-input-buscar mt-4 validar ">
      <form action="?c=ControladorPacientes/mostrarPaciente" method="POST" id="form-buscador-patologia"
        class="d-flex justify-content-end" autocomplete="off">

        <input class="form-control input-buscar tamaño-input-buscar buscador_responsiv" type="text" name="cedula"
          placeholder="Patología" required id="inputB">

        <button class="btn btn-buscar " title="Buscar" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
            viewBox="0 0 16 16">
            <path
              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
          </svg>
        </button>

      </form>
    </div>
  </div>

  <!-- Tabla -->


  <!-- <div class="m-auto" style="width: 90%;">
    <div class="d-flex justify-content-end">
      <div class="mover-input-agregarcita mt-4 " style="width: 20%;">
        <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-patologia" id="">
          <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-person-fill-add me-1" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
          </svg>Registrar Patologia
        </button>

      </div>
    </div>
  </div> -->

  <div class="d-flex justify-content-center">

    <div class="tamaño-tabla mt-5 contenedor_tabla">

      <table class="table table-striped " id="tablaPatologia">
        <thead>
          <tr>
            <th class="d-none">
              Id
            </th>
            <th class=" text-center">#</th>
            <th class=" text-center border-start">Nombre</th>
            <th class=" text-center border-start">Acción</th>

          </tr>
        </thead>
        <tbody id="cuerpoTablaEspecialidad" class="tbodyPatologia">

          <?php if ($datosPatologias): ?>
            <?php $contadorPatologia = 1; ?>

            <?php foreach ($datosPatologias as $patologia): ?>

              <tr>
                <td class="text-center fw-bold">
                  <?php echo $contadorPatologia++; ?>
                </td>

                <td class="text-center border-start">
                  <?php echo $patologia['nombre_patologia']; ?>
                </td>


                <td class="border-start text-center">
                  <button class="btn btn-tabla mb-1" uk-toggle="target: #eliminarEspecialidad<?= $patologia["0"]; ?>"
                    id="btnEliminarEspecialidad">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                  </button>

                  <div id="eliminarEspecialidad<?= $patologia["0"]; ?>" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                      <!-- Boton que cierra el modal -->
                      <div class="d-flex justify-content-between mb-5">




                        <div class="d-flex align-items-center ajustar" id="eliminarEspecialidad">
                          <div class="svgPapeleraPatologia">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                              class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                              <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                            </svg>
                          </div>
                          <div>
                            <h5>
                              ¿Desea eliminar la Patologia?
                            </h5>
                          </div>
                        </div>
                        <!-- Ayuda Interactiva -->
                        <a href="#">
                          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                          </svg>
                        </a>
                      </div>


                      <div class="mt-5 uk-text-right btn_modal_patologias">
                        <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                          id="cancelarEliminacion">Cancelar</button>

                        <a
                          href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/eliminarPatologia/<?= $patologia["0"]; ?>/<?php echo $_SESSION['id_usuario'] ?>">
                          <button class="btn col-4 btn-agregarcita-modal btnrestablecer"
                            id="btnEliminarEspecialidad">Eliminar</button>
                        </a>

                      </div>

                    </div>
                  </div>


                </td>
              </tr>
            <?php endforeach ?>






          <?php else: ?>


            <tr>
              <td colspan="9" class="text-center">NO HAY REGISTROS

              </td>
            </tr>
          <?php endif ?>



        </tbody>
      </table>

      <table class="table table-striped d-none" style="margin-top: -16px;" id="noResultado">
        <thead>

        </thead>
        <tbody>
          <tr class="">
            <td colspan="9" class="text-center">NO HAY REGISTROS

            </td>
          </tr>
        </tbody>

      </table>



    </div>
  </div>

</div>



<?php require_once "modalesPatologia.php"; ?>
<?php require_once './src/vistas/head/footer.php'; ?>
<?php if ($parametro != ""): ?>
  <?php $concatenarRuta = ""; ?>
  <?php foreach ($parametro as $p): ?>
    <?php $concatenarRuta .= "../"; ?>
    <!-- <script type="text/javascript" src="./src/assets/js/validacionesPacientesRegistrar.js"></script> -->
    <!-- <script type="text/javascript" src="./src/assets/js/buscadorPaciente.js"></script> -->
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/ayudaPaciente.js"></script>
  <?php endforeach; ?>
<?php else: ?>
  <script type="text/javascript" src="../src/assets/js/ayudaPaciente.js"></script>
<?php endif; ?>