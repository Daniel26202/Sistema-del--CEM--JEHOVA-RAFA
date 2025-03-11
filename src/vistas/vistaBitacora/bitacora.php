<?php require_once './src/vistas/head/head.php'; ?>



<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
  <div class="ms-5 d-flex align-items-center" id="inicioPacientes">
    <h1 class="fw-bold">BITACORA</h1>
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

        <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
          <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
        </svg>SALIR</a></li>
      </ul>
    </div>
  </div>
</div>


<!-- bitacora -->
<?php $bitacora = $this->modelo->consultarBitacora($_SESSION['id_usuario']);?>

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

  <div class="d-flex">
    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


      </div>
    </div>

    <div class="d-flex justify-content-end align-items-center">
      



      <!-- Buscador de pacientes -->
      <div class="mover-input-buscar mt-4 validar">
        <form action="?c=ControladorPacientes/mostrarPaciente" method="POST" id="form-buscador" class="d-flex justify-content-end" autocomplete="off">

          <input class="form-control input-buscar tamaño-input-buscar" type="number" name="cedula" placeholder="Ingrese Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="inputB">

          <button class="btn btn-buscar " id="buscar" title="Buscar" data-bs-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </button>

      </form>
    </div>
  </div>

  <!-- Tabla -->



  <div class="d-flex justify-content-center">

    <div class="tamaño-tabla mt-5 contenedor_tabla">

      <table class="table table-striped " id="tabla">
        <thead>
          <tr>
            <th class=" text-center border-start">Nombre Apellido</th>
            <th class=" text-center border-start">Usuario</th>
            <th class=" text-center border-start">Modulo</th>
            <th class="border-start text-center" colspan="2">Actividad</th>
            <th class="border-start text-center">Fecha</th>
            <th class="border-start text-center">Hora</th>
          </tr>
        </thead>
        <tbody class="tbody">

          <?php if ($bitacora): ?>
            <?php foreach ($bitacora as $b): ?>

              <tr>

                <td class="border-start text-center">
                  <?php echo $b['nombre']." ".$b["apellido"]; ?>
                </td>


                <td class="border-start text-center"><?php echo $b['usuario']; ?></td>


                <td class="border-start text-center"><?php echo $b['tabla']; ?></td>


                <td class="border-start text-center " colspan="2"><?php echo $b['actividad']; ?></td>


                <?php $fecha_hora_separadas =explode(" ", $b['fecha_hora']);?>

                <td class="border-start text-center"><?php echo $fecha_hora_separadas[0]; ?></td>


                <td class="border-start text-center"><?php echo $fecha_hora_separadas[1]; ?></td>






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


<?php require_once './src/vistas/head/footer.php'; ?>