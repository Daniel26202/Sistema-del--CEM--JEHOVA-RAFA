<?php require_once './src/vistas/head/head.php';  ?>


<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">

    <h5 style="width: 95%; " class="m-auto mb-3">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
            <path
                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
        </svg>
    </h5>

    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">



    <input type="hidden" id="dolar" value="<?= $_SESSION["dolar"] ?>?>">



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas"
                class="btn-guardar-responsive btn btn-primary btn-agregar-doctores text-decoration-none col-8" id="">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Servicios
            </a>


        </div>



        <div class="table table-responsive">
            <table class="exampleTable  table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark">Servicio</th>
                        <th class="text-dark">Precio en BS</th>
                        <th class="text-dark">Precio en $</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>


    <!-- modal de agregar -->








</div>

</div>
</div>



<script type="module" src="<?= $urlBase; ?>../src/assets/ajax/servicios.js"></script>

<?php require_once './src/vistas/head/footer.php';  ?>