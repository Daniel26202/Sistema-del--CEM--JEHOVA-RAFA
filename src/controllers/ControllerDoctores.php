<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloServicios;


function returnObjectClass()
{
    return [
        "doctores" => new ModeloDoctores(),
        "bitacora" => new ModeloBitacora(),
        'servicio' => new ModeloServicios()
    ];
}

//muestro los datos de las cuatro tablas
function doctores($parametro)
{
    $vistaActiva = 'doctores';
    $ayuda = "btnayudaDoctores";
    $datosDias = returnObjectClass()['doctores']->selectDias();
    $datosEspecialidades = returnObjectClass()['doctores']->selectEspecialidad();
    $doctores = returnObjectClass()['servicio']->mostrarDoctores();
    $todasLasServicios = returnObjectClass()['servicio']->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

function selectEspcAjax()
{
    echo json_encode(returnObjectClass()['doctores']->selectEspecialidad());
}

function DoctoresAjax()
{
    echo json_encode([returnObjectClass()['doctores']->select(), returnObjectClass()['doctores']->selectDias()]);
}

function papelera($parametro)
{
    $vistaActiva = 'papelera';
    $ayuda = "btnayudaDoctores";
    $datosDias = returnObjectClass()['doctores']->selectDias();
    $datosEspecialidades = returnObjectClass()['doctores']->selectEspecialidad();
    $doctores = returnObjectClass()['servicio']->mostrarDoctores();
    $todasLasServicios = returnObjectClass()['servicio']->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

function papeleraDoctoresAjax()
{
    echo json_encode(returnObjectClass()['doctores']->desactivos());
}

//metodo para mostrar los servicios de los doctores
function serviciosDoctor($datos)
{
    returnObjectClass()['doctores']->setIdDoctor($datos[0]);
    echo json_encode(returnObjectClass()['servicio']->mostrarServiciosDoctor());
}


function guardarDoctores()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    $servicio = returnObjectClass()['servicio'];
    $doctores = returnObjectClass()['doctores'];
    $bitacora = returnObjectClass()['bitacora'];

    $doctores->setIdDoctor($_POST["id_doctor"]);
    $servicio->setIdServicioMedico($_POST["id_servicioMedico"]);

    $bitacora->setId_usuario($_POST['id_usuario']);
    $bitacora->setActividad("Ha asignado un servicio medico a un doctor");
    $bitacora->setTabla("Servicio Medico");

    $insercion = returnObjectClass()['servicio']->insertarDoctorServicio();

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

    $servicio = returnObjectClass()['servicio'];
    $doctores = returnObjectClass()['doctores'];
    $bitacora = returnObjectClass()['bitacora'];

    $doctores->setCedula($_POST["cedula"]);
    $doctores->setNombre($_POST["nombre"]);
    $doctores->setApellido($_POST["apellido"]);
    $doctores->setTelefono($_POST["telefono"]);








    // Generamos la contraseña encriptada de la contraseña ingresada
    $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
    // si encuentra la imagen la guardo en la variable si no le doy el valor false
    $imagen = isset($_FILES['imagenDoctores']['name']) ? $_FILES['imagenDoctores']['name'] : false;

    $insercion = $doctores->insertarDoctor(, $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $passwordEncrip,  $_POST['email'], $_POST['nacionalidad'], $_FILES['imagenDoctores']['name'], $_FILES['imagenDoctores']['tmp_name'], $_POST["selectEspecialidad"], $_POST['dias'], $_POST["horaSalida"], $_POST["horaEntrada"], $imagen);


    if (is_array($insercion) && $insercion[0] === "exito") {
        $this->bitacora->insertarBitacora($_POST['id_usuario'], "doctor", "Ha Insertado un doctor");
        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $insercion]);
        exit;
    }
}

// // editar doctor
// function editarDoctor()
// {

//     $idDiaDbE = array_diff($_POST["diaAnterio"], $_POST["dias"]);
//     $idDiaNuevo = array_diff($_POST["dias"], $_POST["diaAnterio"]);
//     $igualesDb = array_intersect($_POST["dias"], $_POST["diaAnterio"]);
//     $checkeds = $_POST["dias"];

//     // Usar el operador ternario para verificar si $idDiaDbE está vacío
//     $idDiaDbE = !empty($idDiaDbE) ? $idDiaDbE : false;
//     $idDiaNuevo = !empty($idDiaNuevo) ? $idDiaNuevo : false;
//     $igualesDb = !empty($igualesDb) ? $igualesDb : false;


//     $edicion = $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds, $_POST["horaEntrada"], $_POST["horaSalida"], $_POST['cedulaRegistrada']);

//     if (is_array($edicion) && $edicion[0] === "exito") {
//         $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "doctor", "Ha modificado un doctor");
//         echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//     } else {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $edicion]);
//         exit;
//     }
// }
// // eliminación lógica doctor
// function borrarDoctor($datos)
// {
//     $id_usuario = $datos[0];
//     $id_usuario_bitacora = $datos[1];
//     $eliminacion = $this->modelo->eliminacionLogica($id_usuario);

//     if (is_array($eliminacion) && $eliminacion[0] === "exito") {
//         $this->bitacora->insertarBitacora($id_usuario_bitacora, "doctor", "Ha eliminado un doctor");
//         echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//     } else {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $eliminacion]);
//         exit;
//     }
// }

// // restablecer lógica doctor
// function restablecer($datos)
// {

//     $restablecer = $this->modelo->restablecerDoctor($datos[0]);

//     if (is_array($restablecer) && $restablecer[0] === "exito") {
//         $this->bitacora->insertarBitacora($datos[1], "doctor", "Ha restablecido un doctor");

//         echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//     } else {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $restablecer]);
//         exit;
//     }
// }

// //json para editar
// function selectDiasDoctorEditar()
// {
//     $respuesta = $this->modelo->selectDiasDoctor($_GET["id_personal"]);
//     echo json_encode($respuesta);
// }
// function registrarEspecialidad()
// {
//     $insercion = $this->modelo->Especialidadregistrar($_POST['nombre']);

//     if (is_array($insercion) && $insercion[0] === "exito") {
//         $this->bitacora->insertarBitacora($_POST['id_usuario'], "especialidad", "Ha insertado una nueva especialidad");

//         echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//     } else {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $insercion]);
//         exit;
//     }
// }
// function eliminarEspecialidad($datos)
// {
//     $id_especialidad = $datos[0];
//     $id_usuario =  $datos[1];
//     $eliminacion = $this->modelo->Especialidadeliminar($id_especialidad);

//     if (is_array($eliminacion) && $eliminacion[0] === "exito") {
//         $this->bitacora->insertarBitacora($id_usuario, "especialidad", "Ha eliminado una especialidad");

//         echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//     } else {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $eliminacion]);
//         exit;
//     }
// }

// function buscarEspecialidad()
// {
//     $respuesta = $this->modelo->especialidadBuscar($_POST["nombre"]);
//     echo json_encode($respuesta);
// }
// function buscarDoctor()
// {
//     $respuesta = $this->modelo->doctorBuscar($_POST["busqueda"]);
//     echo json_encode($respuesta);
// }


// function buscarHorario($datos)
// {
//     $id_personal = $datos[0];
//     $respuesta = $this->modelo->horarioDelDoctor($id_personal);
//     echo json_encode($respuesta);
// }

// function permisos($id_rol, $permiso, $modulo)
// {
//     return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
