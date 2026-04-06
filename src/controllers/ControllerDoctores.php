<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloServicios;
use App\modelos\ModeloUsuarios;
use App\modelos\ModeloRoles;
use App\modelos\ModeloCategoria;
use App\config\RateLimiter;

//muestro los datos de las cuatro tablas
function doctores($parametro)
{
    $modeloDoctores = new ModeloDoctores();
    $modeloServicios = new ModeloServicios();
    $modeloRoles = new ModeloRoles();
    $datosRoles = $modeloRoles->roles();
    $vistaActiva = 'doctores';
    $ayuda = "btnayudaDoctores";
    $datosEspecialidades = $modeloDoctores->selectEspecialidad();
    $doctores = $modeloServicios->mostrarDoctores();
    $todasLasServicios = $modeloServicios->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

//funcion para retornaar los dias de la semana
function mostrarDiasSemana()
{
    $modeloDoctores = new ModeloDoctores();
    echo json_encode($modeloDoctores->selectDias());
}

function selectEspcAjax()
{
    $modeloDoctores = new ModeloDoctores();
    echo json_encode($modeloDoctores->selectEspecialidad());
}

function DoctoresAjax()
{
    $modeloDoctores = new ModeloDoctores();
    $modeloServicio = new ModeloServicios();

    //variable final
    $result = [];
    foreach ($modeloDoctores->select() as $doctor) {
        $id_personal = $doctor['id_personal'];

        //filtrar los horarios para el doctor actual
        $horarioDelDoctor = array_filter($modeloDoctores->selectDiasDoctor(), function ($horario) use ($id_personal) {
            return $horario['id_personal'] === $id_personal;
        });

        //filtrar tambien los servicios 
        $serviciosPorDoctor = array_filter($modeloServicio->mostrarServiciosDoctor(), function ($servicio) use ($id_personal) {
            return $servicio['id_personal'] === $id_personal;
        });

        $datosHorarios = [];
        $servicios = [];

        foreach ($horarioDelDoctor as $hora) {
            $datosHorarios[] = [
                'horaDeEntrada' => $hora['horaDeEntrada'],
                'horaDeSalida' => $hora['horaDeSalida'],
                'id_horario' => $hora['id_horario'],
                'diaslaborables' => $hora['diaslaborables'],
                'id_personal' => $id_personal,
            ];
        }

        foreach ($serviciosPorDoctor as $servicio) {
            $servicios[] = [
                'id_servicioMedico' => $servicio['id_servicioMedico'],
                'nombre' => $servicio['nombre_categoria'],
                'id_personal' => $id_personal,
            ];
        }

        //agregamos el resultado
        $result[] = [
            'id_personal' => $doctor['id_personal'],
            'id_especialidad' => $doctor['id_especialidad'],
            'nacionalidad' => $doctor['nacionalidad'],
            'cedula' => $doctor['cedula'],
            'nombre_d' => $doctor['nombre_d'],
            'apellido' => $doctor['apellido'],
            'telefono' => $doctor['telefono'],
            'correo' => $doctor['correo'],
            'nombre' => $doctor['nombre'],
            'id_usuario' => $doctor['usuario'],
            'datosHorarios' => $datosHorarios,
            'servicios' => $servicios
        ];
    }

    echo json_encode($result);
}

function papelera($parametro)
{
    $modeloDoctores = new ModeloDoctores();
    $modeloServicios = new ModeloServicios();
    $vistaActiva = 'papelera';
    $ayuda = "btnayudaDoctores";
    $datosDias = $modeloDoctores->selectDias();
    $datosEspecialidades = $modeloDoctores->selectEspecialidad();
    $doctores = $modeloServicios->mostrarDoctores();
    $todasLasServicios = $modeloServicios->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

function papeleraDoctoresAjax()
{
    $modeloDoctores = new ModeloDoctores();
    echo json_encode($modeloDoctores->desactivos());
}

// metodo para mostrar los servicios y los doctores
function serviciosDoctor()
{
    $modeloDoctores = new ModeloDoctores();
    $modeloCategiria = new ModeloCategoria();

    echo json_encode([$modeloDoctores->select(), $modeloCategiria->seleccionarCategoria()]);
}


function guardarDoctores()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('guardar_doctor_servicio_' . $idUsuario, 5, 1);

        $servicio = new ModeloServicios();
        $doctores = new ModeloDoctores();
        $bitacora = new ModeloBitacora();

        $servicio->setIdDoctor($_POST["id_doctor"]);
        $servicio->setIdCategoria($_POST["id_categoria"]);

        $bitacora->setId_usuario($_POST['id_usuario_bitacora']);
        $bitacora->setActividad("Ha asignado un servicio medico a un doctor");
        $bitacora->setTabla("Servicio Medico");



        $insercion = $servicio->insertarDoctorServicio();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $bitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
// // agregar doctor
function agregarDoctor()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('guardar_doctor_' . $idUsuario, 5, 1);

        // $modeloServicio = new ModeloServicios();
        $modeloDoctores = new ModeloDoctores();
        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();
        $modeloUsuarios = new ModeloUsuarios();

        // Generamos la contraseña encriptada de la contraseña ingresada
        $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
        // si encuentra la imagen la guardo en la variable si no le doy el valor false
        $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : false;

        $modeloDoctores->setCedula($_POST["cedula"]);
        $modeloDoctores->setNombre($_POST["nombre"]);
        $modeloDoctores->setApellido($_POST["apellido"]);
        $modeloDoctores->setTelefono($_POST["telefono"]);
        $modeloDoctores->setEmail($_POST['correo']);
        $modeloDoctores->setNacionalidad($_POST['nacionalidad']);
        $modeloDoctores->setImagen($imagen);
        $modeloDoctores->setImagenTemporal($_FILES['imagen']['tmp_name']);
        $modeloDoctores->setIdEspecialidad($_POST["id_especialidad"]);
        $modeloDoctores->setDias($_POST['dias']);
        $modeloDoctores->setHoraEntrada($_POST["horaEntrada"]);
        $modeloDoctores->setHoraSalida($_POST["horaSalida"]);
        $modeloDoctores->setIdRol($_POST['id_rol']);


        $modeloDoctores->setUsuario($_POST["usuario"]);
        $modeloDoctores->setPassword($passwordEncrip);

        $insercion = $modeloDoctores->insertarDoctor();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setId_usuario($_SESSION["id_usuario"]);
            $modeloBitacora->setTabla("doctor");
            $modeloBitacora->setActividad("Ha Insertado un nuevo doctor");
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// editar doctor
function editarDoctor()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }



    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('editar_doctor_' . $idUsuario, 5, 1);

        $modeloUsuarios = new ModeloUsuarios();
        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();

        $dias = isset($_POST["dias"]) ? $_POST["dias"] : [];
        $diaAnterio = isset($_POST["diaAnterio"]) ? $_POST["diaAnterio"] : [];

        $idDiaDbE = array_diff($diaAnterio, $dias);
        $idDiaNuevo = array_diff($dias, $diaAnterio);
        $igualesDb = array_intersect($dias, $diaAnterio);
        $checkeds = $dias;

        // // Usar el operador ternario para verificar si $idDiaDbE está vacío
        $idDiaDbE = !empty($idDiaDbE) ? $idDiaDbE : false;
        $idDiaNuevo = !empty($idDiaNuevo) ? $idDiaNuevo : false;
        $igualesDb = !empty($igualesDb) ? $igualesDb : false;

        $modeloDoctores->setCedula($_POST["cedula"]);
        $modeloDoctores->setNombre($_POST["nombre"]);
        $modeloDoctores->setApellido($_POST["apellido"]);
        $modeloDoctores->setTelefono($_POST["telefono"]);
        $modeloDoctores->setIdEspecialidad($_POST["id_especialidad"]);
        $modeloDoctores->setEmail($_POST["correo"]);
        $modeloDoctores->setNacionalidad($_POST["nacionalidad"]);
        $modeloDoctores->setDiasE($idDiaDbE);
        $modeloDoctores->setDiasN($idDiaNuevo);
        $modeloDoctores->setDiasEditar($igualesDb); //aqui
        $modeloDoctores->setCheckeds($checkeds);
        $modeloDoctores->setHoraEntrada($_POST["horaEntrada"]);
        $modeloDoctores->setHoraSalida($_POST["horaSalida"]);
        $modeloDoctores->setCedulaRegistrada($_POST['cedulaRegistrada']);

        $modeloDoctores->setIdUsuario($_POST["id_usuario"]);



        $edicion = $modeloDoctores->updateDoctor();

        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
            $modeloBitacora->setTabla("doctor");
            $modeloBitacora->setActividad("Ha modificado un doctor");
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $edicion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
// eliminación lógica doctor
function borrarDoctor($datos)
{

    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('eliminar_doctor_' . $idUsuario, 5, 1);

        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();

        $id_usuario = $datos[0];
        $id_usuario_bitacora = $datos[1];

        $modeloDoctores->setIdUsuario($id_usuario);

        $eliminacion = $modeloDoctores->eliminacionLogica();

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setId_usuario($id_usuario_bitacora);
            $modeloBitacora->setTabla("doctor");
            $modeloBitacora->setActividad("Ha eliminado un doctor");
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// restablecer lógica doctor
function restablecer($datos)
{

    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('restablecer_doctor_' . $idUsuario, 5, 1);

        $modeloDoctores = new ModeloDoctores();
        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($datos[0]);
        $restablecer = $modeloDoctores->restablecerDoctor();

        if (is_array($restablecer) && $restablecer[0] === "exito") {
            $modeloBitacora->setId_usuario($datos[1]);
            $modeloBitacora->setTabla("doctor");
            $modeloBitacora->setActividad("Ha restablecido un doctor");
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $restablecer]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}



function registrarEspecialidad()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('guardar_especialidad_' . $idUsuario, 5, 1);
        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();

        $modeloDoctores->setNombreEspecialidad($_POST['nombre']);

        $insercion = $modeloDoctores->EspecialidadRegistrar();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setId_usuario($_POST['id_usuario']);
            $modeloBitacora->setTabla("especialidad");
            $modeloBitacora->setActividad("Ha insertado una nueva especialidad");
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
function eliminarEspecialidad($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('eliminar_especialidad_' . $idUsuario, 5, 1);
        $id_especialidad = $datos[0];
        $id_usuario =  $datos[1];

        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();
        $modeloDoctores->setIdEspecialidad($id_especialidad);

        $eliminacion = $modeloDoctores->EspecialidadEliminar();

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setId_usuario($id_usuario);
            $modeloBitacora->setTabla("especialidad");
            $modeloBitacora->setActividad("Ha eliminado una especialidad");
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $eliminacion]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function buscarHorario($datos)
{
    $id_personal = $datos[0];
    $modeloDoctores = new ModeloDoctores();

    $respuesta = $modeloDoctores->horarioDelDoctor($id_personal);
    echo json_encode($respuesta);
}

function permisos($id_rol, $permiso, $modulo)
{
    $modeloPermisos = new ModeloPermisos();
    $modeloPermisos->setIdRol($id_rol);
    $modeloPermisos->setPermiso($permiso);
    $modeloPermisos->setModulo($modulo);
    return $modeloPermisos->gestionarPermisos();
}
