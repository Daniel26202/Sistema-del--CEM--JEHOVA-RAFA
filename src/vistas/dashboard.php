<?php
require_once './src/vistas/head/head.php';
?>

<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/cssVista/dashboard.css">


<div id="content-wrapper" class="d-flex flex-wrap">
    <!-- Contenedor principal (75%) -->

    <div class="main-content col-12 col-lg-8 p-4" id="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="welcome-card p-4 rounded shadow-sm" id="welcomeCard">
                        <h3>Bienvenido!</h3>
                        <div class="reminder d-flex justify-content-between align-items-center">
                            <h2>Doc. <?= $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?></h2>
                            <img class="img-logo" src="../src/assets/icons/logo.png" alt="user">
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LAS CARDS -->
            <div class="row mt-4">
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Citas pendientes</p>
                        <h4 id="citasPendentes"></h4>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Citas de hoy</p>
                        <h4 id="citasDeHoy"></h4>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Pacientes Hospitalizados</p>
                        <h4 id="pacientes_hospitalizados"></h4>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LOS GRAFICOS -->

            <div class="row mt-4">

                <div class="col-md-6 col-12">
                    <div class="chart-card p-4 rounded shadow-sm">
                        <h5>Especialidades solicitadas</h5>
                        <canvas id="especialidades_solicitadas" width="600" height="600"></canvas>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reporte">
                            Generar Reporte
                        </button>

                    </div>

                </div>
                <div class="col-md-6 col-12">
                    <div class="chart-card p-4 rounded shadow-sm">
                        <h5>sintomas_comunes</h5>
                        <canvas id="sintomas_comunes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar (25%) -->
    <div class="sidebar-content col-12 col-lg-4 p-4 min-vh-100" id="sidebar-content">

        <div class="d-flex justify-content-between ">
            <?php if ($validarCargo): ?>
                <!-- Es un doctor asi que no puede ver el boton -->
            <?php else: ?>

                <div class="w-75 ">
                    <div class="d-flex justify-content-between ">
                        <div class="d-flex justify-content-end mb-4 col-8" id="form-buscadorS">

                            <a class="btn d-none" title="Buscar" id="reiniciarBusquedaSintomas" uk-tooltip="Restablecer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                    <path fill-rule="evenodd"
                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                </svg>
                            </a>

                            <select class="form-control " id="selectDoctor">
                                <!-- js -->
                            </select>
                            <button type="button" class="btn btn-buscar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.442 1.398a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"></path>
                                </svg></button>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <h5 class="w-25">Calendario</h5>
        </div>

        <?php if ($validarCargo): ?>
            <!-- Es un doctor asi que no puede ver el boton -->
        <?php else: ?>
            <button id="btnHorario" class="btn btn-primary mb-2 w-100 d-none" uk-toggle="target: #modal-info-doctores"></button>
        <?php endif; ?>
        <!-- Calendar Container -->
        <div class="card shadow-sm mb-2" id="calendarCard">
            <div class="card-tittle d-flex justify-content-between align-items-center">
                <button id="prev"><img src="../src/assets/icons/izquierda.svg" alt="anterior" style="width: 16px; height: 16px;"></button>
                <h2 id="monthYear" class="mb-0"></h2>
                <button id="next"> <img src="../src/assets/icons/derecha.svg" alt="siguiente" style="width: 16px; height: 16px;"></button>
                <button id="today" class="btn btn-sm">Hoy</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Dom</th>
                            <th>Lun</th>
                            <th>Mar</th>
                            <th>Mié</th>
                            <th>Jue</th>
                            <th>Vie</th>
                            <th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Se inyectan días desde calendar.js -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contenedor de la lista de servicios -->
        <div class="col-md-12 mt-3">
            <div class="card shadow-sm">
                <?php if ($validarCargo): ?>
                    <?php foreach ($datos_de_personal as $d): ?>
                        <div class="card-tittle">
                            <h5 class="mb-0 fw-bolder text-center pt-3">Doctor: <?= $d["nombre"] ?> <?= $d["apellido"] ?></h5>
                        </div>

                        <div class="card-body">
                            <div class="d-flex mt-4">
                                <div class="col-6 m-auto">
                                    <form class="form-modal perfil " id="perfil">
                                        <div class="input-group flex-nowrap">



                                            <span class="input-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                    class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                                </svg>
                                            </span>
                                            <input class="form-control input-modal input-perfil" type="text" name="cedula" placeholder="Cedula"
                                                value="<?= $d["cedula"] ?>" disabled>
                                        </div>

                                        <div class="input-group flex-nowrap">
                                            <span class="input-modal mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                    class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </span>
                                            <input class="form-control input-modal input-perfil" type="text" name="nombreyapellido"
                                                placeholder="Nombre y Apellido" disabled value="<?= $d["usuario"] ?>">

                                        </div>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-modal mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                    class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                </svg>
                                            </span>
                                            <input class="form-control input-modal input-perfil" type="text" name="telefono" placeholder="Teléfono"
                                                disabled value="<?= $d["telefono"] ?>">
                                        </div>

                                        <div class="input-group flex-nowrap">
                                            <span class="input-modal mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                    class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </span>
                                            <input class="form-control input-modal input-perfil" type="text" name="usuario" placeholder="Usuario"
                                                disabled value="<?= $d["usuario"] ?>">
                                        </div>


                                    </form>

                                </div>

                                <div class="m-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" fill="currentColor"
                                        class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </div>
                            <?php endforeach ?>

                            </div>



                        </div>
                    <?php else: ?>
                        <div class="card-tittle">
                            <h5 class="mb-0">Precio consulta</h5>
                        </div>
                        <div class="card-body">
                            <!-- Lista de servicios -->
                            <table class="table table-borderless align-middle" id="precios">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>


                            </table>


                        </div>
                    <?php endif; ?>
            </div>
        </div>



    </div>
</div>


<!-- Modal de horario del doctor -->

<div id="modal-info-doctores" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <form>

            <!-- Botón que cierra el modal -->
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </a>

            <div class="d-flex align-items-center">
                <div>
                </div>
                <div>
                    <h5 class="text-center" id="titulo">
                    </h5>
                </div>
            </div>

            <div class="modal-body horario-insertar ">

            </div>



            <div class="mt-3 uk-text-right">

                <button class="uk-button fw-bold uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                    data-bs-dismiss="modal">Cerrar</button>

            </div>
        </form>
    </div>
</div>

<!-- modal reporte -->
<div class="modal fade" id="reporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimir">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="../src/assets/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="fecha" style="display: flex; align-items: center; padding-right: 20px;     color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
                    <div class="titulo" id="titulo">
                        <h1>Reporte de Especialidades Solicitadas</h1>
                    </div>

                    <!-- filtro de busqueda -->
                    <h5 class="mt-4">Filtrar la Grafica Segun un Periodo de Tiempo</h5>
                    <div class="mt-4 w-100">
                        <div class="alert alert-danger text-center d-none alertaFechaInicio">Por favor la hora de Inicio tiene que ser Menor a la hora final</div>
                        <div class="d-flex">

                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de Inicio">

                            <input type="date" name="fechaFinal" id="fechaFinal" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de final">



                            <a href="#" class="btn btn-buscar " id="buscarFecha" title="Buscar Entradas Por Fecha">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                            <div>
                                <button class="btn btn-tabla ms-5 d-none" id="btnImprimir">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                    </svg>
                                </button>
                            </div>
                        </div>


                    </div>
                    <div class="canva" style="margin: 20px 0;">
                        <canvas id="especialidades_solicitadas_pdf" width="400" height="400"></canvas>
                    </div>
                    <div class="leyenda-container" style="width: 80%; margin: 20px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    </div>
                    <div class="texto" id="texto" style="width: 90%; text-align: justify; font-size: 14px;">
                        <p>Este reporte muestra las especialidades solicitadas en el sistema. Cada especialidad está representada por un color diferente en el gráfico.</p>
                        <p>El gráfico de pastel muestra la distribución porcentual de cada especialidad solicitada, lo que permite identificar las áreas de mayor demanda.</p>
                        <p>Este informe es útil para la toma de decisiones y la planificación de recursos en el ámbito médico.</p>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <button id="especialidades" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/jspdf.umd.min.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/html2canvas.min.js"></script>


<script type=" text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
<script type="text/javascript" src="../src/assets/js/dashboard.js"></script>
<?php
require_once 'src/vistas/head/footer.php';
?>