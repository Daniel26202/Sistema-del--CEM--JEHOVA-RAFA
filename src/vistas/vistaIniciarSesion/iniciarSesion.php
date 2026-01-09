<?php
// Obtiene la ruta local eliminando barras inclinadas iniciales y finales.
$ruta_local = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');

// Establece un valor predeterminado para el "concatenador especial"
$concatenadorEspecial = '.';

// Define una función personalizada para verificar si una cadena termina con un sufijo dado.
function ends_with($haystack, $needle)
{
    $length = strlen($needle);
    if ($length === 0) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}

// Verifica si $ruta_local termina con el texto especificado.
if (ends_with($ruta_local, 'Sistema-del--CEM--JEHOVA-RAFA')) {
    $concatenadorEspecial = "";
}

// Inicializa una cadena vacía para construir la ruta concatenada.
$concatenarRuta = "";

// Verifica si el array $parametro no está vacío.
if (!empty($parametro)) {
    foreach ($parametro as $p) {
        $concatenarRuta .= "../";
    }
}

$urlBase = $concatenarRuta . '' . $concatenadorEspecial;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEM - Sistema Clínico</title>

    <!-- Bootstrap 5 CSS -->
    <link href="<?= $urlBase ?>./src/assets/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Intro.js para ayuda interactiva -->
    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/library/intro/introjs.min.css">
    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/library/intro/introjs-modern.css">
    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/cssVista/inicioSesion.css">
</head>

<body>
    <!-- Contenedor principal de Bootstrap -->
    <div class="container mb-5 mt-3 ">


        <!-- Fecha Actual -->
        <div class="text-center mb-4">
            <small class="text-bg-light-custom text-uppercase fw-medium" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                <?php
                setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain');
                echo strftime("%A, %d DE %B, %Y");
                ?>
            </small>
        </div>
        <div class="row justify-content-center  ">
            <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-7">


                <!-- Card de Bootstrap -->
                <div class="card rounded-4 shadow-lg ">
                    <div class="card-body p-4">


                        <div class="d-flex justify-content-center mb-3 mt-1 ">
                            <img src="<?= $urlBase ?>./src/assets/icons/logo3.png" alt="Logo" class="logo" style="">
                        </div>
                        <!-- Logo y Nombre -->
                        <div class="text-center mb-3 d-flex flex-wrap justify-content-center align-items-center">
                            <div class="mb-3 logo-icon rounded-4 d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-heart-pulse-fill text-white fs-4"></i>
                            </div>
                            <div class=" ms-3 ">
                                <h1 class="clinic-name h4 fw-bold mb-1">CEM JEHOVA-RAFA</h1>
                                <p class="text-primary-custom small fw-medium mb-3">Sistema de Gestión Clínica</p>
                            </div>
                            <div class="ms-5 ps-2"></div>
                        </div>


                        <!-- Formulario de Login -->
                        <form id="loginForm">
                            <div class="me-md-5 pe-md-4 mt-1">

                                <!-- Campo de Usuario con icono flotante -->
                                <div class="mb-3 d-flex flex-wrap justify-content-center align-items-center col-12">
                                    <!-- Label -->
                                    <div class="text-center text-sm-end col-12 col-sm-4 col-md-4">
                                        <label for="username" class="form-label text-dark me-sm-3">Usuario</label>
                                    </div>

                                    <!-- Input con icono -->
                                    <div class="input-icon-wrapper col-9 col-sm-7 col-md-7">
                                        <i class="bi bi-person-fill input-icon"></i>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="username"
                                            name="username"
                                            placeholder="Tu correo o usuario"
                                            required
                                            data-intro="Ingrese su nombre de usuario o correo electrónico"
                                            data-step="1">
                                    </div>
                                </div>

                                <!-- Campo de Contraseña con icono flotante -->
                                <div class="mb-3 d-flex flex-wrap justify-content-center align-items-center col-12">
                                    <!-- Label -->
                                    <div class="text-center text-sm-end col-12 col-sm-4 col-md-4">
                                        <label for="password" class="form-label text-dark me-sm-3">Contraseña</label>
                                    </div>

                                    <!-- Input con icono -->
                                    <div class="input-icon-wrapper position-relative col-9 col-sm-7 col-md-7 ">
                                        <i class="bi bi-lock-fill input-icon"></i>
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password"
                                            name="password"
                                            placeholder="Contraseña"
                                            required
                                            data-intro="Ingrese su contraseña segura"
                                            data-step="2">
                                        <button
                                            type="button"
                                            class="btn btn-link password-toggle text-muted p-2"
                                            onclick="togglePassword()"
                                            title="Mostrar/Ocultar contraseña">
                                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Google reCAPTCHA -->
                            <div class="d-flex justify-content-center ">

                                <div class="mt-2 mb-1 g-recaptcha" data-sitekey="6Le_rOgqAAAAANVWXtJV-5eOd2CEzOFgzphoNkd1" style="margin-left: 15%; transform: scale(0.95); transform-origin: center; transform: scale(0.88);"></div>

                            </div>

                            <!-- Botón de Ingresar con Bootstrap -->
                            <div class="col-12 d-flex justify-content-center" id="">
                                <div class="d-grid gap-2 mt-4 col-7">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg rounded-5"
                                        data-intro="Haga clic aquí para iniciar sesión"
                                        data-step="3">
                                        INGRESAR
                                    </button>
                                </div>
                            </div>
                            <div class="text-center m-3">
                                <a href="#" class="text-decoration-none text-primary-custom small fw-medium ">Has olvidado tu contraseña?</a>
                            </div>

                            <!-- Mensaje de Seguridad -->
                            <div class="text-center mt-4 pt-2">
                                <small class="text-secondary-custom">
                                    <i class="bi bi-shield-check text-success security-icon me-1"></i>
                                    Acceso seguro y encriptado
                                </small>
                            </div>
                        </form>

                        <!-- Enlaces del Footer -->
                        <div class="text-center mt-4  footer-links">
                            <small class="text-muted">
                                Tu salud, nuestra misión © <?= date('Y') ?> CEM •
                                <a href="#" class="text-decoration-none">Privacidad</a> •
                                <a href="#" class="text-decoration-none">Soporte</a>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- SweetAlert2 -->
    <script type="text/javascript" src="<?= $urlBase ?>./src/assets/library/sweetalert2@11.js"></script>

    <script src="<?= $urlBase ?>./src/assets/library/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $urlBase ?>./src/assets/library/intro/intro.min.js"></script>
    <script src="<?= $urlBase ?>./src/assets/js/generic/expresionesModulares.js"></script>
    <script src="<?= $urlBase ?>./src/assets/js/ayudaInteractiva/ayudaInteractiva.js"></script>
    <script src="<?= $urlBase ?>./src/assets/app.js"></script>
    <script type="module" src="<?= $urlBase ?>./src/assets/js/ajax/inicioSesion.js"></script>

    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-fill');
                toggleIcon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash-fill');
                toggleIcon.classList.add('bi-eye-fill');
            }
        }
    </script>
</body>

</html>