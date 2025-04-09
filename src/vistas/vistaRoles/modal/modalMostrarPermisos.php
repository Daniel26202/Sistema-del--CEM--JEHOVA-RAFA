<!--MODAL MOSTRAR-->
<?php foreach ($roles as $rol): ?>

    <div id="modal-exampleMostrar<?php echo $rol["id_rol"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">


                <h1 class="text-center">Permisos de <?= $rol["nombre"]; ?></h1>




                <div class="caja-de-permisos<?= $rol["id_rol"]; ?> ">
                    <!-- <h4>Pacientes</h4>
                    <div class="bg-danger d-flex flex-wrap">
                        <div class="form-check form-switch d-flex align-items-center">
                            <div>
                                <input class="form-check-input " type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                    value="">
                            </div>
                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                    Nombre del permiso
                                </label></div>

                        </div>
                    </div>
                     -->


                    


                </div>



                <!-- botones -->
                <div class="uk-card-footer d-flex justify-content-start">

                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4 editarUsuario"
                        uk-toggle="target: #modal-exampleEditar<?php echo $dato["id_usuario"]; ?>">Modificar</a>
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4"
                        uk-toggle="target: #modal-exampleEliminar<?php echo $dato["id_usuario"]; ?>">Eliminar</a>
                </div>
            </div>

        </div>
    </div>

<?php endforeach ?>

<?php //require_once("./src/vistas/vistaUsuarios/modal/modalEditarAdmin.php") 
?>
<?php //require_once("./src/vistas/vistaUsuarios/modal/modalEliminarAdmin.php") 
?>