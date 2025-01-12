<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
        <h1 class="fw-bold">INSUMOS</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-capsule ms-2"
        viewBox="0 0 16 16">
        <path
        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
    </svg>
</div>

<div class="me-4">

    <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
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
            <li><a href="#" id="btnayudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
            </svg>AYUDA</a></li>
            <li class="uk-nav-divider"></li>

            <li><a href="#" data-bs-toggle="modal"
                data-bs-target="#eliminar">
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
                <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary  text-decoration-none">Salir</a>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">

    <?php if (isset($_GET["editado"])): ?>
        <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Se actualizo correctamente.</p>
        </div>
    <?php endif ?>
    <?php if (isset($_GET["eliminado"])): ?>
        <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Se ha eliminado correctamente.</p>
        </div>
    <?php endif ?>
    <?php if (isset($_GET["error"])): ?>
        <div class="uk-alert-danger comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">El rif del proveedor se encuentra registrado</p>
        </div>
    <?php endif ?>
    <?php if (isset($_GET["agregado"])): ?>
        <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Se ha agregado correctamente.</p>
        </div>
    <?php endif ?>

</div>

<!-- paginación servicio medico -->
<div class="d-flex">

    <div class="w-75 ms-5">
        <h3 class="fw-bold" id="inicioServicio">PAPELERA PROVEEDORES

            <img src="./src/assets/img/proveedor (1).png" width="25" height="25" uk-svg class="mb-2">
        </h3>

    </div>

    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">

            <li class="li">
                <div class="borde-de-menu  mb-1"></div>
                <div class="hover-grande">
                    <a href="?c=controladorInsumos/insumos" class="text-decoration-none text-black me-3" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-capsule me-1"
                        viewBox="0 0 16 16">
                        <path
                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>Insumos</a>
                </div>
            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 "></div>
                <div class="hover-grande">
                    <a href="?c=controladorEntrada/entrada" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>Entradas de Insumo</a>
                    </div>

                </li>
                <li class="li">
                    <div class="borde-de-menu mb-1 color-linea activo-border"></div>
                    <div class="hover-grande">

                        <a href="?c=controladorProveedores/proveedores" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                            <img src="./src/assets/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
                        </div>

                    </li>

                    <li class="li">
                        <div class="borde-de-menu mb-1 "></div>
                        <div class="hover-grande">
                            <a href="?c=controladorInsumos/InsumosVencidos" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
                                    <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                                </svg>Entrada de Insumos Vencidas</a>
                            </div>

                        </li>


                    </ul>

                </div>
            </div>



            <div  style="width: 95%;">
              <div class=" me-3 mb-4  d-flex justify-content-end w-100">


                <ul class="sin-circulos d-flex justify-content-end">



                  <li class="li">
                    <div class="borde-de-menu mb-1 color-linea "></div>
                    <div class="hover-grande">
                      <a href="?c=controladorEntrada/papelera" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1 azul" viewBox="0 0 16 16">
                          <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                      </svg>Papelera Proveedores</a>
                  </div>

              </li>




          </ul>

      </div>
  </div>



  <div class="div-tabla contenedor m-auto mt-3">
    <div class="d-flex justify-content-end align-items-center">
        <!-- Boton Agregar Proveedores-->

        <!-- Buscador de proveedores-->
        <div class="mover-input-buscar mt-4">
            <form id="form-buscador" class="d-flex justify-content-end" autocomplete="off">
                <input class="form-control input-buscar tamaño-input-buscar" type="text" name="cedula"
                placeholder="Ingrese Rif" id="inputBuscarProveedor">

                <button class="btn btn-buscar " title="Buscar" id="buscarProveedor">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Tabla -->

<div class="d-flex justify-content-center">
    <div class="contenedor_tabla_entradas tamaño_tabla mt-4">
        <table class="table table-striped" id="tabla">
            <thead>
                <tr>
                    <th class=" text-center d-none">Id</th>
                    <th class=" text-center ">Nombre/Razon Social</th>

                    <th class=" text-center border-start">Rif</th>
                    <th class="border-start text-center">Telefono</th>
                    <th class="border-start text-center">Gmail</th>
                    <th class="border-start text-center">Direccion</th>
                    <th class="border-start text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="tbody">

                <?php foreach ($proveedor as $proveedor): ?>
                    <tr>


                        <td class=" text-center d-none ">
                            <?php echo $proveedor["id_proveedor"] ?>
                        </td>
                        <td class="border-start text-center border-start-0">
                            <?php echo $proveedor["nombre"] ?>
                        </td>
                        <td class="border-start text-center">
                            <?php echo $proveedor["rif"] ?>
                        </td>
                        <td class="border-start text-center">
                            <?php echo $proveedor["telefono"] ?>
                        </td>
                        <td class="border-start text-center">
                            <?php echo $proveedor["email"] ?>
                        </td>
                        <td class="border-start text-center">
                            <?php echo $proveedor["direccion"] ?>
                        </td>


                        <td class="border-start d-flex justify-content-center">

                            <!-- Editar Proveedor -->



                            <!-- Eliminar Proveedores-->

                            <div class="me-2">
                                <a href="#" class="btns-accion" uk-toggle="target: #modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-tooltip="Eliminar Proveedores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                    </svg>
                                </a>
                            </div>

                        </td>
                    </tr>


                    <!--ELIMINAR MODAL-->

                    <div id="modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-modal>


                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                            <!-- Boton que cierra el modal -->
                            <div class="d-flex justify-content-between mb-5">




                              <div class="d-flex align-items-center ajustar" id="eliminarEspecialidad">
                                <div class="svgPapeleraPatologia">

                                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-counterclockwise azul me-2 mb-1 " viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                </svg>
                            </div>
                            <div>
                              <h5>
                                ¿Desea restablecer la Entrada del Insumo?
                            </h5>
                        </div>
                    </div>
                    <!-- Ayuda Interactiva -->
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                          <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                      </svg>
                  </a>
              </div>


              <div class="mt-5 uk-text-right btn_modal_patologias">
                  <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                  id="cancelarEliminacion">Cancelar</button>

                  <a href="?c=controladorProveedores/restablecerProveedor&id_proveedor=<?= $proveedor["id_proveedor"]; ?>">
                    <button class="btn col-4 btn-agregarcita-modal btnrestablecer" id="btnEliminarEspecialidad">Restablecer</button>
                </a>

            </div>

        </div>




    </div>




<?php endforeach ?>
</tbody>
</table>
</div>
</div>

</div>

</div>
<?php require_once 'modalProveedores.php'; ?>

<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="./src/assets/js/validacionProveedores.js"></script>