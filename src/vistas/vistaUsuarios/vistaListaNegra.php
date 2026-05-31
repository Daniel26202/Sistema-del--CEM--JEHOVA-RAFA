<?php require_once './src/vistas/head/head.php'; ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Lista Negra de Usuarios <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            <path
                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
        </svg></h5>



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto " id="inicioClientes" style="width: 95%;">
        <div class="me-2 ps-3 col-12 d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start">
            <div class="mb-2 mb-md-0 caja-btn-margin">


                <button class="caja-btn-margin btn btn-modals btnOpenModal" style="width: 100% !important" data-bs-toggle="modal" data-bs-target="#modalAddUserBlckList" id="btnOpenModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                    </svg>Agregar a la lista negra
                </button>
            </div>


        </div>

        <div class="table table-responsive">
            <table class="exampleTable table table-striped">
                <thead>
                    <tr class="text-align-left">
                        <th class="text-dark">Cédula</th>
                        <th class="text-dark">Nombre</th>
                        <th class="text-dark">Apellido</th>
                        <th class="text-dark">Teléfono</th>
                        <th class="text-dark">Correo</th>
                        <th class="text-dark">Usuario</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>

</div>


<?php require_once './src/vistas/head/footer.php'; ?>
<?php require_once './src/vistas/vistaUsuarios/modal/modalAddUserBlackList.php'; ?>
<script type="module" src="<?= $urlBase; ?>../src/assets/js/ajax/blackListUser.js"></script>