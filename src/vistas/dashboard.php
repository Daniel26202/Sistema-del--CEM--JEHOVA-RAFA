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
                            <p>Doc. <?= $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] ?></p>
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
                        <h4 id="hospitalizados"></h4>
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
    <div class="sidebar-content col-12 col-lg-4 p-4 min-vh-100" id="sidebar-content">
        <h5 style="color: rgb(42, 109, 172);">Calendario</h5>
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

        <!-- Modal para eventos -->
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Agregar/Editar Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="eventForm">
                            <div class="form-group">
                                <label for="eventTitle">Título del Evento</label>
                                <input type="text" class="form-control" id="eventTitle" required>
                            </div>
                            <div class="form-group">
                                <label for="recurrentCheckbox">Recurrente Anualmente</label>
                                <input type="checkbox" id="recurrentCheckbox">
                            </div>
                            <input type="hidden" id="eventDate">
                            <button type="submit" class="btn btn-primary" id="guardarEvent">Guardar</button>
                            <button type="button" class="btn btn-danger" id="deleteEvent">Eliminar</button>
                        </form>
                    </div>
                </div>
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
                    <table class="table table-borderless align-middle example" id="precios">
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


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
<script type="text/javascript" src="../src/assets/js/dashboard.js"></script>
<?php
require_once 'src/vistas/head/footer.php';
?>