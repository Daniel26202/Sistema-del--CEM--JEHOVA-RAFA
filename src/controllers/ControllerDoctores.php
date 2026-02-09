<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloServicios;
use App\modelos\ModeloUsuarios;

//muestro los datos de las cuatro tablas
function doctores($parametro)
{
    $modeloDoctores = new ModeloDoctores();
    $modeloServicios = new ModeloServicios();

    $vistaActiva = 'doctores';
    $ayuda = "btnayudaDoctores";
    $datosDias = $modeloDoctores->selectDias();
    $datosEspecialidades = $modeloDoctores->selectEspecialidad();
    $doctores = $modeloServicios->mostrarDoctores();
    $todasLasServicios = $modeloServicios->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

function selectEspcAjax()
{
    $modeloDoctores = new ModeloDoctores();
    echo json_encode($modeloDoctores->selectEspecialidad());
}

function DoctoresAjax()
{
    $modeloDoctores = new ModeloDoctores();
    echo json_encode([$modeloDoctores->select(), $modeloDoctores->selectDias()]);
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

//metodo para mostrar los servicios de los doctores
function serviciosDoctor($datos)
{
    $modeloDoctores = new ModeloDoctores();
    $modeloServicios = new ModeloServicios();
    $modeloDoctores->setIdDoctor($datos[0]);
    echo json_encode($modeloServicios->mostrarServiciosDoctor());
}


function guardarDoctores()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    $servicio = new ModeloServicios();
    $doctores = new ModeloDoctores();
    $bitacora = new ModeloBitacora();

    $doctores->setIdDoctor($_POST["id_doctor"]);
    $servicio->setIdServicioMedico($_POST["id_servicioMedico"]);

    $bitacora->setId_usuario($_POST['id_usuario']);
    $bitacora->setActividad("Ha asignado un servicio medico a un doctor");
    $bitacora->setTabla("Servicio Medico");

    $insercion = $servicio->insertarDoctorServicio();

    if (is_array($insercion) && $insercion[0] === "exito") {
        $bitacora->insertarBitacora();
        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $insercion]);
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

    // $modeloServicio = new ModeloServicios();
    $modeloDoctores = new ModeloDoctores();
    $modeloDoctores = new ModeloDoctores();
    $modeloBitacora = new ModeloBitacora();
    $modeloUsuarios = new ModeloUsuarios();

    // Generamos la contraseña encriptada de la contraseña ingresada
    $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
    // si encuentra la imagen la guardo en la variable si no le doy el valor false
    $imagen = isset($_FILES['imagenDoctores']['name']) ? $_FILES['imagenDoctores']['name'] : false;

    $modeloDoctores->setCedula($_POST["cedula"]);
    $modeloDoctores->setNombre($_POST["nombre"]);
    $modeloDoctores->setApellido($_POST["apellido"]);
    $modeloDoctores->setTelefono($_POST["telefono"]);
    $modeloDoctores->setEmail($_POST['email']);
    $modeloDoctores->setNacionalidad($_POST['nacionalidad']);
    $modeloDoctores->setImagen($imagen);
    $modeloDoctores->setImagenTemporal($_FILES['imagenDoctores']['tmp_name']);
    $modeloDoctores->setIdEspecialidad($_POST["selectEspecialidad"]);
    $modeloDoctores->setDias($_POST['dias']);
    $modeloDoctores->setHoraEntrada($_POST["horaEntrada"]);
    $modeloDoctores->setHoraSalida($_POST["horaSalida"]);
    $modeloDoctores->setHoraSalida($_POST["horaSalida"]);

    $modeloUsuarios->setUsuario($_POST["usuario"]);
    $modeloUsuarios->setPassword($passwordEncrip);

    $insercion = $modeloDoctores->insertarDoctor();

    if (is_array($insercion) && $insercion[0] === "exito") {
        $modeloBitacora->setId_usuario($_POST['id_usuario']);
        $modeloBitacora->setTabla("doctor");
        $modeloBitacora->setActividad("Ha Insertado un nuevo doctor");
        $modeloBitacora->insertarBitacora();
        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $insercion]);
        exit;
    }
}

// editar doctor
function editarDoctor()
{
    $modeloUsuarios = new ModeloUsuarios();
    $modeloDoctores = new ModeloDoctores();
    $modeloBitacora = new ModeloBitacora();


    $idDiaDbE = array_diff($_POST["diaAnterio"], $_POST["dias"]);
    $idDiaNuevo = array_diff($_POST["dias"], $_POST["diaAnterio"]);
    $igualesDb = array_intersect($_POST["dias"], $_POST["diaAnterio"]);
    $checkeds = $_POST["dias"];

    // Usar el operador ternario para verificar si $idDiaDbE está vacío
    $idDiaDbE = !empty($idDiaDbE) ? $idDiaDbE : false;
    $idDiaNuevo = !empty($idDiaNuevo) ? $idDiaNuevo : false;
    $igualesDb = !empty($igualesDb) ? $igualesDb : false;

    $modeloDoctores->setCedula($_POST["cedula"]);
    $modeloDoctores->setNombre($_POST["nombre"]);
    $modeloDoctores->setApellido($_POST["apellido"]);
    $modeloDoctores->setTelefono($_POST["telefono"]);
    $modeloDoctores->setIdEspecialidad($_POST["id_especialidad"]);
    $modeloDoctores->setEmail($_POST["email"]);
    $modeloDoctores->setNacionalidad($_POST["nacionalidad"]);
    $modeloDoctores->setNacionalidad($_POST["nacionalidad"]);
    
    $modeloUsuarios->setIdUsuario($_POST["id_usuario"]);


    $edicion = $modeloDoctores->updateDoctor($idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds, $_POST["horaEntrada"], $_POST["horaSalida"], $_POST['cedulaRegistrada']);

    if (is_array($edicion) && $edicion[0] === "exito") {
        $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
        $modeloBitacora->setTabla("doctor");
        $modeloBitacora->setActividad("Ha modificado un doctor");
        $modeloBitacora->insertarBitacora();
        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $edicion]);
        exit;
    }
}
// eliminación lógica doctor
function borrarDoctor($datos)
{
    $id_usuario = $datos[0];
    $id_usuario_bitacora = $datos[1];
    $eliminacion = $this->modelo->eliminacionLogica($id_usuario);

    if (is_array($eliminacion) && $eliminacion[0] === "exito") {
        $this->bitacora->insertarBitacora($id_usuario_bitacora, "doctor", "Ha eliminado un doctor");
        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $eliminacion]);
        exit;
    }
}

// restablecer lógica doctor
function restablecer($datos)
{

    $restablecer = $this->modelo->restablecerDoctor($datos[0]);

    if (is_array($restablecer) && $restablecer[0] === "exito") {
        $this->bitacora->insertarBitacora($datos[1], "doctor", "Ha restablecido un doctor");

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $restablecer]);
        exit;
    }
}

//json para editar
function selectDiasDoctorEditar()
{
    $respuesta = $this->modelo->selectDiasDoctor($_GET["id_personal"]);
    echo json_encode($respuesta);
}
function registrarEspecialidad()
{
    $insercion = $this->modelo->Especialidadregistrar($_POST['nombre']);

    if (is_array($insercion) && $insercion[0] === "exito") {
        $this->bitacora->insertarBitacora($_POST['id_usuario'], "especialidad", "Ha insertado una nueva especialidad");

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $insercion]);
        exit;
    }
}
function eliminarEspecialidad($datos)
{
    $id_especialidad = $datos[0];
    $id_usuario =  $datos[1];
    $eliminacion = $this->modelo->Especialidadeliminar($id_especialidad);

    if (is_array($eliminacion) && $eliminacion[0] === "exito") {
        $this->bitacora->insertarBitacora($id_usuario, "especialidad", "Ha eliminado una especialidad");

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $eliminacion]);
        exit;
    }
}

function buscarEspecialidad()
{
    $respuesta = $this->modelo->especialidadBuscar($_POST["nombre"]);
    echo json_encode($respuesta);
}
function buscarDoctor()
{
    $respuesta = $this->modelo->doctorBuscar($_POST["busqueda"]);
    echo json_encode($respuesta);
}


function buscarHorario($datos)
{
    $id_personal = $datos[0];
    $respuesta = $this->modelo->horarioDelDoctor($id_personal);
    echo json_encode($respuesta);
}

function permisos($id_rol, $permiso, $modulo)
{
    return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}
