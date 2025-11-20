<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Usuarios <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            <path
                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
        </svg></h5>



    <input type="hidden" name="urlBase" id="urlBase" value="<?= $urlBase ?>">
    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
            <div class="d-flex justify-content-end align-items-center">

                <!-- Buscador de Usuarios -->
                <div class="d-flex justify-content-end mt-3 mb-3 col-3 caja-buscador-usuario">
                    <input class="form-control input-busca" type="text" name="" placeholder="Ingrese nombre" id="Buscarusuario">
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


        </div>

        <div class="table table-responsive">


            <!--TARJETAS DE Usuarios-->

            <!-- linea -->
            <hr class="mb-4 pb-2">

            <div class="d-flex flex-wrap justify-content-center  caja-tarjets-responsive" id="div-tarjet-user">
                <!-- js -->

            </div>
        </div>

    </div>
</div>

<?php require_once './src/vistas/vistaUsuarios/modal/modalMostrarUsuario.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>


<script type="module" src="<?= $urlBase ?>../src/assets/ajax/usuarios.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/admin.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaUsuario.js"></script>