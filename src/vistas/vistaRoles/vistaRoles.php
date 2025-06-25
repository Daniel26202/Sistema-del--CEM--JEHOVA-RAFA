<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Roles <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            <path
                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
        </svg></h5>



    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
            <div class="d-flex justify-content-end align-items-center">
                <!-- Buscador de Usuarios -->
                <div class="d-flex justify-content-end mt-3 mb-3 col-3 caja-buscador-usuario">
                    <input class="form-control input-busca" type="text" name="" placeholder="Ingrese nombre"
                        id="buscarRol">
                    <button class="btn boton-buscar" title="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="me-4">
                <div class="mt-3 mb-5">
                    <ul class="sin-circulos d-flex justify-content-end paginacion">
                        <li class="borde-menu activo <?= $vistaActiva == 'usuarios'  ? ' activo-borde ' : '' ?>">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios" class="ico text-decoration-none me-3 color-letras">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Usuarios</a>
                        </li>
                        <li class="borde-menu activo <?= $vistaActiva == 'administradores'  ? ' activo-borde ' : '' ?>">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" class="ico text-decoration-none me-3 color-letras">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Administradores</a>
                        </li>

                        <li class="borde-menu activo <?= $vistaActiva == 'roles'  ? ' activo-borde ' : '' ?>">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar" class="ico text-decoration-none text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Roles </a>
                        </li>
                    </ul>
                </div>
            </div>


            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Roles")): ?>
                <!-- no hay -->
            <?php else: ?>
                <div class="">
                    <button class="btn btn-primary btn-usuarios btn-agregar-doctores col-3" uk-toggle="target: #modal-exampleGuardar"
                        id="btnRegistrarrol">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
                            class="bi bi-person-square me-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                        </svg>Registrar Rol
                    </button>
                </div>
            <?php endif; ?>

        </div>

        <div class="table table-responsive">


            <!--TARJETAS DE Usuarios-->

            <!-- linea -->
            <hr class="mb-4 pb-2">

            <div class="d-flex flex-wrap justify-content-center caja-tarjets-responsive  ">
                <?php if ($roles): ?>

                    <?php foreach ($roles as $dato): ?>

                        <div class="card contenido col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta">


                            <img src="<?= $urlBase ?>../src/assets/img/logoRol.jpeg" class="mt-2" alt="...">

                            <div class="mt-3">
                                <div class="ps-3 pe-3 text-center buscar">

                                    <h5 class="card-title mb-1 ">
                                        <?php echo $dato["nombre"] ?>
                                    </h5>
                                    <p class="mb-4">
                                        <?php echo $dato["descripción"]; ?>
                                    </p>

                                </div>

                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class="mostrar mb-3">
                                        <a href="#" class="btn btn-User  text-decoration-none"
                                            uk-toggle="target: #modal-exampleMostrar<?php echo $dato["id_rol"]; ?>">Mostrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endforeach ?>
                <?php else: ?>

                    <div colspan="9" class="text-center">NO HAY REGISTROS

                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>


</div>

<?php require_once './src/vistas/vistaRoles/modal/modalMostrarPermisos.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/roles.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaRoles.js"></script>