<?php require_once './src/vistas/head/head.php'; ?>



<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
  <div class="ms-5 d-flex align-items-center" id="inicioPacientes">
    <h1 class="fw-bold">PACIENTES</h1>
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-people ms-2" viewBox="0 0 16 16">
      <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
    </svg>
  </div>

  <div class="me-4">

    <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablePaciente">
        <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
      </svg></a>
    <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
      <ul>
        <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>PERFIL
          </a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="#" id="btnayudaPaciente"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
              <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
            </svg>AYUDA</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="?c=ControladorBitacora/bitacora" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> CONFIGURACIÓN</a></li>
        <li class="uk-nav-divider"></li>

        <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
            <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
            </svg>SALIR</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Modal Cerrar Sesion  -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="m-3">
        <?php

        echo '<h5 class="modal-title" id="exampleModalLabel">
                    ¿' . $_SESSION['usuario'] . '   ' . 'Desea Cerrar 
                    la Sesion?
                    </h5>';
        ?>
      </div>
      <div class="modal-body ">
        Una vez cerrada la sesión tendrá que iniciar sesión nuevamente.
      </div>
      <div class="m-3 me-4 d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
        <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary text-decoration-none">Salir</a>
      </div>
    </div>
  </div>
</div>




<div class="div-tabla contenedorII m-auto mt-3" id="alertas">

<?php if($parametro != ""):?>
  <?php if ($parametro[0] == 'registro'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-registrar">EL paciente se registro correctamente</div>
  <?php elseif ($parametro[0] == 'eliminar'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-eliminar">El Paciente se Elimino correctamente</div>
  <?php elseif ($parametro[0] == 'error'): ?>
      <div class="alert alert-danger w-100 text-center alertas" id="alerta-eliminar">La Cedula ya está registrada</div>
  <?php elseif ($parametro[0] == 'editar'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-editar">El Paciente se Actualizo correctamente</div>
  <?php elseif ($parametro[0] == 'errorfecha'):?>
      <div class="alert alert-danger w-100 text-center alertas" id="alerta-editar">Por Favor Ingrese una fecha de Nacimiento Válida</div>
  <?php elseif ($parametro[0] == 'restablecido'): ?>
      <div class="alert alert-primary w-100 text-center alertas" id="alerta-editar">El Paciente se restableció correctamente</div>
  <?php endif; ?>
<?php endif;?>

  <div class="d-flex">
    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">

            <li class="li">
                <div class="borde-de-menu  mb-1"></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/papeleraPaciente" class="text-decoration-none text-black me-3" id="DMservicioMedico">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
  <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
</svg>Papelera Pacientes</a>
                </div>
            </li>
          

        </ul>

    </div>
</div>

  <div class="d-flex justify-content-between align-items-center">
    <!-- Boton Agregar Pacientes -->
    <div class="mover-input-agregarcita mt-4 ">
      <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-examplePaciente" id="btnRegistrarPaciente">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-person-fill-add me-1" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>Registrar Paciente
      </button>

    </div>



    <!-- Buscador de pacientes -->
    <div class="mover-input-buscar mt-4 validar">
      <form action="?c=ControladorPacientes/mostrarPaciente" method="POST" id="form-buscador" class="d-flex justify-content-end" autocomplete="off">

        <input class="form-control input-buscar tamaño-input-buscar" type="number" name="cedula" placeholder="Ingrese Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="inputB">

        <button class="btn btn-buscar " id="buscar" title="Buscar" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
          </svg>
        </button>
        <!-- <button class="btn btn-buscar " id="buscar" title="Buscar" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
          </svg>
        </button> -->

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

      <table class="table table-striped " id="tabla">
        <thead>
          <tr>
            <th class="d-none">
              Id
            </th>
            <th class=" text-center">CI</th>
            <th class=" text-center border-start">Nombre</th>
            <th class=" text-center border-start">Apellido</th>
            <th class="border-start text-center">Teléfono</th>
            <th class="border-start text-center">Dirección</th>
            <th class="border-start text-center">Fecha de Nacimiento</th>
            <th class="border-start text-center">Acciones</th>
          </tr>
        </thead>
        <tbody class="tbody">

          <?php if ($pacientes): ?>
              <?php foreach ($pacientes as $paciente): ?>

                  <tr>
                    <td class="text-center d-none"><?php echo $paciente['0']; ?>     <?php echo $paciente['11']; ?></td>

                    <td class="text-center"><?php echo $paciente['nacionalidad']; ?>-<?php echo $paciente['cedula']; ?></td>


                    <td class="border-start text-center">
                      <?php echo $paciente['nombre']; ?>
                    </td>


                    <td class="border-start text-center"><?php echo $paciente['apellido']; ?></td>


                    <td class="border-start text-center"><?php echo $paciente['telefono']; ?></td>


                    <td class="border-start text-center "><?php echo $paciente['direccion']; ?></td>

                    <td class="border-start text-center"><?php echo $paciente['fn']; ?></td>

               


                    <td class="border-start">
                      <div class="d-flex justify-content-center">
                        <div class="me-2 d-flex">
                          <a href="#" uk-toggle="target:#editar<?php echo $paciente['id_paciente']; ?>" title="Modificar Paciente" uk-tooltip id="btnModalEditarPaciente" class="svg_tamaño_rsp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square text-black" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                          </a>
                        </div>

                        <!-- Boton Eliminar Pacientes-->

                        <div class="me-2">
                          <a href="#" uk-toggle="target:#eliminar<?php echo $paciente['id_paciente']; ?>" title="Eliminar Paciente" uk-tooltip id="btnModalEliminarPaciente" class="svg_tamaño_rsp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill text-black" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                          </a>
                        </div>



                        <!-- Modal de Modificar -->


                        <div id="editar<?= $paciente['id_paciente']; ?>" uk-modal>
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

                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/setPaciente/<?php echo $paciente['cedula'] ?>" method="POST" id="formEditar">
                              <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'];?>">

                              <input class="form-control input-modal d-none input-disabled" type="text" name="id_paciente" placeholder="Id-paciente" value="<?php echo $paciente['id_paciente']; ?>">

                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_cedulaEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                  </svg>
                                </span>
                                <span class="">
                                  <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidadEditar">
                                
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                  </select>
                                </span>
                                <input class="form-control input-modal input-disabled input-paciente" type="number" id="cedulaEditar" required pattern="^([1-9]{1})([0-9]{5,7})$" maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="cedulaEditar" placeholder="Cedula" value="<?php echo $paciente['cedula']; ?>">
                              </div>

                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_nombreEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                  </svg>
                                </span>
                                <input class="form-control mayuscula input-modal input-disabled input-paciente " type="text" id="nombreEditar" required pattern="^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$" maxlength="11" name="nombreEditar" placeholder="Nombre" value="<?php echo $paciente['nombre']; ?>">
                              </div>

                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_apellidoEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                  </svg>
                                </span>
                                <input class="form-control  mayuscula input-modal input-disabled input-paciente" type="text" id="apellidoEditar" required pattern="^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$" maxlength="11" name="apellidoEditar" placeholder="Apellido" value="<?php echo $paciente['apellido']; ?>">
                              </div>

                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_telefonoEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                  </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-paciente" type="number" id="telefonoEditar" name="telefonoEditar" required pattern="^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$" maxlength="18" placeholder="Telefono" value="<?php echo $paciente['telefono']; ?>">
                              </div>

                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_direccionEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
                                  </svg>
                                </span>
                                <input class="form-control mayuscula input-modal input-disabled input-paciente" type="text" id="direccionEditar" required pattern="([A-Za-z0-9\s\.,#-]+)" maxlength="20" name="direccionEditar" placeholder="Direccion" value="<?php echo $paciente['direccion']; ?>">
                              </div>

                              <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
                              <div class="input-group flex-nowrap margin-inputs validar" id="grp_fnEditar">
                                <span class="input-modal mt-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                  </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-paciente" type="date" id="fnEditar" name="fnEditar" placeholder="Fn" required pattern="\d{2}\/\d{2}\/\d{4}" maxlength="8" value="<?php echo $paciente['fn']; ?>">
                              </div>

                          
                          
                              <div class="mt-3 uk-text-right">
                                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
                                <button class="btn col-4 btn-agregarcita-modal" type="sumit">Modificar</button>
                              </div>
                            </form>
                          </div>
                        </div>



                        <!-- Modal Eliminar -->

                        <div id="eliminar<?= $paciente['id_paciente']; ?>" uk-modal>
                          <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                            <!-- Boton que cierra el modal -->
                            <a href="#">
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

                            <div class="mt-3 uk-text-right">
                              <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                              <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/eliminar/<?php echo $paciente['id_paciente']; ?>/<?php echo $_SESSION['id_usuario']?>">
                                <button class="btn col-4 btn-agregarcita-modal" type="button">Eliminar</button>
                              </a>
                            </div>

                          </div>
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

<table class="table table-striped d-none" style="margin-top: -16px;" id="noresultados">
                <thead>

                </thead>
                <tbody>
                    <tr class="" >
                        <td colspan="9" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                </tbody>

            </table>



  </div>
</div>

</div>

<?php require_once 'modalPaciente.php'; ?>

<?php if($parametro != ""):?>
		<?php $concatenarRuta = "";?>
		  <?php foreach($parametro as $p):?>
        <?php $concatenarRuta .= "../";?>
        <script type="text/javascript" src="<?= $concatenarRuta?>../src/assets/js/validacionesPacientesRegistrar.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta?>../src/assets/js/buscadorPaciente.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta?>../src/assets/js/ayudaPaciente.js"></script>

      <?php endforeach;?>
<?php else:?>
      <script type="text/javascript" src="../src/assets/js/validacionesPacientesRegistrar.js"></script>
      <script type="text/javascript" src="../src/assets/js/buscadorPaciente.js"></script>
      <script type="text/javascript" src="../src/assets/js/ayudaPaciente.js"></script>
<?php endif;?>

<?php require_once './src/vistas/head/footer.php'; ?>