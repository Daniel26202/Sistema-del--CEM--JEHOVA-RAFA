<?php
require_once 'src/vistas/head/head.php';
?>

<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/cssVista/dashboard.css">



<div id="content-wrapper" class="d-flex flex-wrap">
    <!-- Contenedor principal (75%) -->
    <div class="main-content col-12 col-lg-9 p-4" id="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="welcome-card p-4 rounded shadow-sm" id="welcomeCard">
                        <h3>Bienvenido!</h3>
                        <div class="reminder d-flex justify-content-between align-items-center">
                            <p>Doc. Nombre Apellido </p>
                            <img class="img-logo" src="../src/assets/Image/123.png" alt="user">
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LAS CARDS -->
            <div class="row mt-4">
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Citas pendientes</p>
                        <h4>29</h4>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Citas de hoy</p>
                        <h4>19</h4>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Pacientes Hospitalizados</p>
                        <h4>5</h4>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LOS GRAFICOS -->
            <div class="row mt-4">
                <div class="col-md-6 col-12">
                    <div class="chart-card p-4 rounded shadow-sm">
                        <h5>Body Fluids Compositions</h5>
                        <canvas id="chartFluids"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="chart-card p-4 rounded shadow-sm">
                        <h5>Upcoming Check-ups</h5>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar (25%) -->
    <div class="sidebar-content col-12 col-lg-3 p-4 min-vh-100" id="sidebar-content">
        <h5>Menú</h5>

    </div>
</div>



<script type="text/javascript" src="../src/assets/js/dashboard.js"></script>

<?php
require_once 'src/vistas/head/footer.php';
?>