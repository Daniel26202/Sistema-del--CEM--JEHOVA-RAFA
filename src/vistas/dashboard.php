<?php
require_once './src/vistas/head/head.php';
?>
<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/cssVista/dashboard.css">

<div
    id="dashboardConfig"
    data-puede-ver-estadisticas="<?= $puedeVerEstadisticas ? 'true' : 'false' ?>"
    data-puede-consultar-citas="<?= $puedeConsultarCitas ? 'true' : 'false' ?>"
    data-es-doctor="<?= $validarCargo ? 'true' : 'false' ?>"
    data-mostrar-calendario="<?= $puedeMostrarCalendario ? 'true' : 'false' ?>"
    data-id-personal-calendario="<?= htmlspecialchars($idPersonalCalendario, ENT_QUOTES, 'UTF-8') ?>">
</div>

<div id="content-wrapper" class="d-flex flex-wrap Inicioh1">
    <!-- Contenedor principal (75%) -->

    <div class="main-content col-12 <?= $puedeVerEstadisticas ? 'col-lg-8' : 'col-lg-7' ?> p-4" id="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="welcome-card p-4 rounded shadow-sm" id="welcomeCard">
                        <h3 class="welcome-card-title">Bienvenido!</h3>
                        <div class="reminder d-flex justify-content-between align-items-center">
                            <h2 class="welcome-user-name"><?= htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido'], ENT_QUOTES, 'UTF-8') ?></h2>
                            <img class="img-logo" src="<?= $urlBase ?>../src/assets/images/icons/logo.png" alt="user">
                        </div>
                        <p class="mb-0">Cargo: <?= htmlspecialchars((string)$_SESSION['rol'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LAS CARDS -->
            <div class="row mt-4 <?= !$puedeVerEstadisticas ? 'd-none' : '' ?>">
                <?php if ($puedeConsultarCitas): ?>
                    <div class="col-md-4 col-12 mb-2" id="tarjetaInicio1">
                        <div class="metric-card p-3 rounded shadow-sm card-container">
                            <p>Citas pendientes</p>
                            <h4 id="citasPendentes"></h4>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mb-2" id="tarjetaInicio2">
                        <div class="metric-card p-3 rounded shadow-sm card-container">
                            <p>Citas de hoy</p>
                            <h4 id="citasDeHoy"></h4>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-4 col-12 mb-2" id="tarjetaInicio3">
                    <div class="metric-card p-3 rounded shadow-sm card-container">
                        <p>Pacientes Hospitalizados</p>
                        <h4 id="pacientes_hospitalizados"></h4>
                    </div>
                </div>
            </div>

            <!-- AQUI EMPIEZAN LOS GRAFICOS -->

            <div class="row mt-4 <?= !$puedeVerEstadisticas ? 'd-none' : '' ?>">

                <div class="col-md-6 col-12 mb-2">
                    <div class="chart-card p-4 rounded shadow-sm" id="grafica1">
                        <h5>Especialidades solicitadas</h5>
                        <canvas id="especialidades_solicitadas" width="600" height="600"></canvas>
                        <div class="text-center mt-4">
                            <button id="btnGrafica1" type="button" class="btn btn-primary 75 m-auto" data-bs-toggle="modal" data-bs-target="#reporte">
                                Generar Reporte
                            </button>
                        </div>

                    </div>

                </div>
                <div class="col-md-6 col-12 mb-2">
                    <div class="chart-card p-4 rounded shadow-sm" id="grafica2">
                        <h5>Síntomas comunes</h5>
                        <canvas id="sintomas_comunes"></canvas>
                        <div class="text-center mt-4">
                            <button id="btnGrafica2" type="button" class="btn btn-primary 75 m-auto  reporte-sintomas" data-bs-toggle="modal" data-bs-target="#reporteSintomas">
                                Generar Reporte
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <?php if (!$puedeVerEstadisticas): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="doctor-agenda-card p-4 rounded shadow-sm">
                            <?php if ($validarCargo): ?>
                                <h5>Mi agenda profesional</h5>
                                <?php if ($puedeConsultarCitas): ?>
                                    <?php if (!empty($agendaPersonal)): ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Hora</th>
                                                        <th>Servicio</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($agendaPersonal as $cita): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($cita['fecha'])), ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td><?= htmlspecialchars(substr((string)$cita['hora'], 0, 5), ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td><?= htmlspecialchars($cita['categoria'], ENT_QUOTES, 'UTF-8') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p class="mb-0">No tienes citas pendientes próximas.</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="mb-0">Tu perfil está disponible. No tienes permiso para consultar la agenda.</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <h5>Tu espacio de trabajo</h5>
                                <p class="mb-0">Consulta tu perfil y utiliza los módulos disponibles según los permisos de tu cuenta.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $atajosDisponibles = [
                        'Citas' => ['Citas', '/Sistema-del--CEM--JEHOVA-RAFA/Citas/citas'],
                        'Pacientes' => ['Pacientes', '/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes'],
                        'Clientes' => ['Clientes', '/Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes'],
                        'Patologias' => ['Patologías', '/Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias'],
                        'Factura' => ['Facturación', '/Sistema-del--CEM--JEHOVA-RAFA/Factura/factura'],
                        'Servicios' => ['Servicios', '/Sistema-del--CEM--JEHOVA-RAFA/Servicios/servicios'],
                        'Doctores' => ['Directorio médico', '/Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores'],
                        'Control' => ['Control médico', '/Sistema-del--CEM--JEHOVA-RAFA/Control/control'],
                        'Hospitalizacion' => ['Hospitalización', '/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion'],
                        'Insumos' => ['Insumos', '/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos'],
                        'Entrada' => ['Entradas', '/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada'],
                        'Proveedores' => ['Proveedores', '/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores'],
                        'Usuarios' => ['Usuarios', '/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios'],
                        'Roles' => ['Roles', '/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar'],
                        'Reportes' => ['Reportes', '/Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportes'],
                        'Estadisticas' => ['Estadísticas', '/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/estadisticas'],
                        'Mantenimiento' => ['Mantenimiento', '/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento'],
                    ];
                    $atajosDisponibles = array_filter(
                        $atajosDisponibles,
                        static fn($atajo, $modulo) => in_array($modulo, $modulosAutorizados, true),
                        ARRAY_FILTER_USE_BOTH
                    );
                    ?>
                    <div class="col-12 mt-3">
                        <section class="dashboard-shortcuts-card" aria-labelledby="dashboardShortcutsTitle">
                            <div>
                                <span class="dashboard-shortcuts-eyebrow">Tu espacio de trabajo</span>
                                <h5 id="dashboardShortcutsTitle">Accesos disponibles</h5>
                                <p>Entra directamente a las secciones habilitadas para tu cuenta.</p>
                            </div>
                            <?php if (!empty($atajosDisponibles)): ?>
                                <nav class="dashboard-shortcuts-list" aria-label="Secciones disponibles">
                                    <?php foreach ($atajosDisponibles as [$etiqueta, $url]): ?>
                                        <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8') ?></a>
                                    <?php endforeach; ?>
                                </nav>
                            <?php else: ?>
                                <p class="dashboard-shortcuts-empty">No tienes secciones adicionales habilitadas. Si necesitas acceso, contacta con el administrador.</p>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar (25%) -->
    <div class="sidebar-content col-12 <?= $puedeVerEstadisticas ? 'col-lg-4 min-vh-100' : 'col-lg-5' ?> p-4" id="sidebar-content">

        <div class="caja_buscador_calendario <?= !$puedeMostrarCalendario ? 'd-none' : '' ?>">
            <?php if ($validarCargo): ?>
                <!-- Es un doctor asi que no puede ver el boton -->
            <?php else: ?>

                <div class=" caja-select-doctor ">
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
            <h5 class="text-calendario">Calendario</h5>
        </div>

        <?php if ($validarCargo): ?>
            <!-- Es un doctor asi que no puede ver el boton -->
        <?php else: ?>
            <button id="btnHorario" class="btn btn-primary mb-2 w-100 d-none" data-bs-toggle="modal" data-bs-target="#exampleModalInfoDoctor"></button>
        <?php endif; ?>
        <!-- Calendar Container -->
        <div class="card shadow-sm mb-2 table table-responsive <?= !$puedeMostrarCalendario ? 'd-none' : '' ?>" id="calendarCard">
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
        <div class="col-12 mt-3 <?= $puedeVerEstadisticas ? 'h-50' : '' ?>" id="precioConsultas">
            <div class="card shadow-sm <?= $puedeVerEstadisticas ? 'h-100' : '' ?>">
                <?php if ($validarCargo): ?>
                    <?php foreach ($datos_de_personal as $d): ?>
                        <?php
                        $diasSemana = [
                            'lunes' => 'Lunes',
                            'martes' => 'Martes',
                            'miercoles' => 'Miércoles',
                            'jueves' => 'Jueves',
                            'viernes' => 'Viernes',
                            'sabado' => 'Sábado',
                            'domingo' => 'Domingo',
                        ];
                        $horarioPorDia = [];
                        foreach ($horarioSemanal as $turno) {
                            $dia = strtolower(strtr(trim((string)$turno['diaslaborables']), [
                                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                                'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
                            ]));
                            $horarioPorDia[$dia] = $turno;
                        }
                        ?>
                        <article class="doctor-profile-card">
                            <header class="doctor-profile-header">
                                <img
                                    src="<?= in_array($d['imagen'], ['doctor.png', 'imagen-generica.svg'], true) ? '../src/assets/images/img/' . rawurlencode($d['imagen']) : '../src/assets/images/img_ingresadas_por_usuarios/usuarios/' . $d['id_usuario'] . '_' . rawurlencode($d['imagen']) ?>"
                                    data-image-fallback="../src/assets/images/img/imagen-generica.svg"
                                    alt="Foto de <?= htmlspecialchars($d['nombre'] . ' ' . $d['apellido'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="doctor-profile-avatar">
                                <div class="doctor-profile-heading">
                                    <span class="doctor-profile-eyebrow">Mi perfil profesional</span>
                                    <h2><?= htmlspecialchars($d['nombre'] . ' ' . $d['apellido'], ENT_QUOTES, 'UTF-8') ?></h2>
                                    <p><?= htmlspecialchars((string)$d['especialidad_nombre'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            </header>
                            <div class="doctor-profile-details">
                                <div class="doctor-profile-detail">
                                    <span>Cédula</span>
                                    <strong><?= htmlspecialchars($d['nacionalidad'] . '-' . $d['cedula'], ENT_QUOTES, 'UTF-8') ?></strong>
                                </div>
                                <div class="doctor-profile-detail">
                                    <span>Teléfono</span>
                                    <strong><?= htmlspecialchars((string)$d['telefono'], ENT_QUOTES, 'UTF-8') ?></strong>
                                </div>
                            </div>
                            <section class="doctor-weekly-schedule" aria-labelledby="doctorWeeklyScheduleTitle">
                                <div class="doctor-weekly-schedule-heading">
                                    <div>
                                        <span class="doctor-profile-eyebrow">Disponibilidad</span>
                                        <h3 id="doctorWeeklyScheduleTitle">Horario de atención</h3>
                                    </div>
                                    <span class="doctor-weekly-schedule-badge">Semanal</span>
                                </div>
                                <ul class="doctor-weekly-schedule-list">
                                    <?php foreach ($diasSemana as $diaClave => $diaNombre): ?>
                                        <?php $turno = $horarioPorDia[$diaClave] ?? null; ?>
                                        <li class="<?= $turno ? 'is-working-day' : 'is-day-off' ?>">
                                            <span><?= $diaNombre ?></span>
                                            <?php if ($turno): ?>
                                                <time><?= htmlspecialchars(substr((string)$turno['horaDeEntrada'], 0, 5), ENT_QUOTES, 'UTF-8') ?> – <?= htmlspecialchars(substr((string)$turno['horaDeSalida'], 0, 5), ENT_QUOTES, 'UTF-8') ?></time>
                                            <?php else: ?>
                                                <span class="doctor-weekly-day-off">No atiende</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                            <a class="doctor-profile-link" href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil">Ver mi perfil completo</a>
                        </article>
                        <div class="card-body doctor-profile-legacy" aria-hidden="true">
                            <div class="d-flex mt-1">
                                <div class="col-12 m-auto">
                                    <div class="form-modal perfil " id="perfil">
                                        <div class="mx-5">

                                            <img id="imgUser" src="<?= in_array($d['imagen'], ['doctor.png', 'imagen-generica.svg'], true) ? '../src/assets/images/img/' . rawurlencode($d['imagen']) : '../src/assets/images/img_ingresadas_por_usuarios/usuarios/' . $d['id_usuario'] . '_' . rawurlencode($d['imagen']) ?>" data-image-fallback="../src/assets/images/img/imagen-generica.svg" alt="Foto de perfil" class="img-perfil-inicio">
                                        </div>
                                        <div class="">
                                            <label class="label-custom">Cédula</label>
                                            <div class="campo-custom">
                                                <div class="input-custom">
                                                    <span class="icono-izq">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z"></path>
                                                        </svg>
                                                    </span>

                                                    <select class="form-control-plaintext tamaño-select-mini inputs" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                                                        <option value="V" selected="">V</option>
                                                        <option value="E">E</option>
                                                    </select>

                                                    <input disabled="true" class="form-control txt-custom input-validar inputs" id="cedulaPaciente" name="cedula" value="<?= htmlspecialchars($d['cedula'], ENT_QUOTES, 'UTF-8') ?>" type="number" placeholder="Cédula del personal">

                                                    <span class="icono-der">
                                                        <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                                        </svg>
                                                        <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                                        </svg>
                                                    </span>
                                                </div>

                                                <p class="error-msg d-none"></p>
                                            </div>
                                        </div>

                                        <div class="">
                                            <label class="label-custom">Teléfono</label>
                                            <div class="campo-custom">
                                                <div class="input-custom">
                                                    <span class="icono-izq">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                        </svg>
                                                    </span>
                                                    <input disabled class="form-control txt-custom input-validar inputs" name="telefono" type="number" placeholder="Teléfono del personal" value="<?= htmlspecialchars($d['telefono'], ENT_QUOTES, 'UTF-8') ?>">
                                                    <span class="icono-der">
                                                        <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                        </svg>
                                                        <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <p class="error-msg d-none"></p>
                                            </div>
                                            <div class="mt-3">
                                                <label class="label-custom">Especialidad</label>
                                                <input disabled class="form-control txt-custom" value="<?= htmlspecialchars((string)$d['especialidad_nombre'], ENT_QUOTES, 'UTF-8') ?>">
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            <?php endforeach ?>

                            </div>



                        </div>
                    <?php elseif (!$puedeVerEstadisticas): ?>
                        <?php $perfil = $datos_de_personal[0]; ?>
                        <div class="card-body">
                            <h5 class="card-title">Mi información</h5>
                            <p><strong>Nombre:</strong> <?= htmlspecialchars($perfil['nombre'] . ' ' . $perfil['apellido'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Cargo:</strong> <?= htmlspecialchars((string)$_SESSION['rol'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Cédula:</strong> <?= htmlspecialchars($perfil['nacionalidad'] . '-' . $perfil['cedula'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Teléfono:</strong> <?= htmlspecialchars($perfil['telefono'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if (!empty($perfil['especialidad_nombre'])): ?>
                                <p><strong>Especialidad:</strong> <?= htmlspecialchars($perfil['especialidad_nombre'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>
                            <a class="btn btn-primary" href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil">Ver mi perfil</a>
                        </div>
                    <?php else: ?>
                        <div class="card-tittle">
                            <h4 class="mb-0">Precio consulta</h4>
                        </div>
                        <div class="card-body p-0">
                            <!-- Slider de servicios -->
                            <div class="servicios-slider" id="serviciosSlider">
                                <div class="servicios-slider-viewport">
                                    <div class="servicios-slider-track" id="serviciosSliderTrack">
                                        <!-- Los servicios se inyectan aquí vía JS -->
                                    </div>
                                </div>
                                <div class="servicios-slider-nav">
                                    <button class="servicios-slider-btn" id="serviciosSliderPrev" aria-label="Anterior">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </button>
                                    <div class="servicios-slider-dots" id="serviciosSliderDots"></div>
                                    <button class="servicios-slider-btn" id="serviciosSliderNext" aria-label="Siguiente">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
        </div>



    </div>
</div>


<!-- Modal de horario del doctor -->

<div class="modal fade" id="exampleModalInfoDoctor" tabindex="-1" aria-labelledby="exampleModalLabelDoctores" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content tamaño-modal doctor-schedule-modal">
            <div class="modal-header">
                <div class="doctor-schedule-heading">
                    <span class="doctor-schedule-heading-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3.5" y="5" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M7.5 3.5v3M16.5 3.5v3M3.5 9.5h17M8 13h3M8 16.5h3M14 13h2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div>
                        <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelDoctores">Disponibilidad médica</h5>
                        <p class="doctor-schedule-subtitle mb-0">Horario de atención</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="horario-insertar" aria-live="polite" aria-busy="false">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php require_once 'src/vistas/vistaEstadisticas/modalsEstadisticas.php'; ?>


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/jspdf.umd.min.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/html2canvas.min.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/doctorSchedule.js"></script>
<!-- jQuery y DataTables ya se cargan en head/footer.php; aquí solo se
     referenciaban con una ruta inexistente (src/assets/DataTable/...),
     lo que generaba dos 404 en cada carga del panel. -->
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/dashboard.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaInteractiva/ayudaDashboard.js"></script>
<?php
require_once 'src/vistas/head/footer.php';
?>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/chart.js"></script>