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
                        <button id="especialidades" class="btn btn-primary">Descargar</button>
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

        <div class="d-flex justify-content-between">
            <div class="w-75 ">
                <div class="d-flex justify-content- ">
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
            <h5 class="w-25">Calendario</h5>
        </div>
        <!-- Calendar Container -->
        <div class="card shadow-sm my-4" id="calendarCard">
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
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm">
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
            </div>
        </div>



    </div>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
<script type="text/javascript" src="../src/assets/js/dashboard.js"></script>
<?php
require_once 'src/vistas/head/footer.php';
?>