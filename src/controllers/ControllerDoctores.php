<?php

use App\models\Validator;
use App\models\Db;
use App\models\ModeloDoctores;
use App\models\ModeloEspecialidad;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\ModeloServicios;
use App\models\ModeloRoles;
use App\models\ModeloCategoria;

//muestro los datos de las cuatro tablas
function doctores($parametro)
{
    $db = new Db();
    $modeloEspecialidad = new ModeloEspecialidad($db);
    $modeloServicios = new ModeloServicios($db);
    $modeloRoles = new ModeloRoles($db);
    $datosRoles = $modeloRoles->roles();
    $vistaActiva = 'doctores';
    $ayuda = "btnayudaDoctores";
    $datosEspecialidades = $modeloEspecialidad->seleccionarEspecialidad();
    // $doctores = $modeloServicios->mostrarDoctores();
    $todasLasServicios = $modeloServicios->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

//funcion para retornaar los dias de la semana
function mostrarDiasSemana()
{
    $db = new Db();
    $modeloDoctores = new ModeloDoctores($db);
    echo json_encode($modeloDoctores->selectDias());
}

function selectEspcAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }
    $db = new Db();
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_especialidad','nombre'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_especialidad';

    $modeloEspecialidad = new ModeloEspecialidad($db);
    $data = $modeloEspecialidad->select($inicio, $limite, $buscar, $ordenColumna, $ordenDir);


    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => is_array($data['data']) ? $data['data']:[]
    ]);
    exit;
}

function DoctoresAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }

    $db = new Db();
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['cedula', 'nombre_d', 'apellido', 'telefono', 'correo', 'nombre'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_personal';

    $modeloDoctores = new ModeloDoctores($db);
    $modeloServicio = new ModeloServicios($db);

    //variable final
    $data = $modeloDoctores->select('ACT', $inicio, $limite, $buscar, $ordenColumna, $ordenDir);
    $cont = 0;
    $result = [];
    foreach ($data['data'] as $doctor) {
        $id_personal = $doctor['id_personal'];

        // filtrar los horarios para el doctor actual
        $horarioDelDoctor = array_filter($modeloDoctores->selectDiasDoctor(), function ($horario) use ($id_personal) {
            return $horario['id_personal'] === $id_personal;
        });
        // filtrar tambien los servicios 
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
                'nombre' => $servicio['categoria'],
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
            'id_usuario' => $doctor['id_usuario'],
            'datosHorarios' => $datosHorarios,
            'servicios' => $servicios
        ];
        $cont += 1;
    }


    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => $result
    ]);
    exit;
}

function papelera($parametro)
{
    $db = new Db();
    $modeloDoctores = new ModeloDoctores($db);
    $modeloEspecialidad = new ModeloEspecialidad($db);
    $modeloServicios = new ModeloServicios($db);
    $vistaActiva = 'papelera';
    $ayuda = "btnayudaDoctores";
    $datosDias = $modeloDoctores->selectDias();
    $datosEspecialidades = $modeloEspecialidad->seleccionarEspecialidad();
    // $doctores = $modeloServicios->mostrarDoctores();
    $todasLasServicios = $modeloServicios->mostrarServicios();
    require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
}

function papeleraDoctoresAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }

    $db = new Db();

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['cedula', 'nombre_d', 'apellido', 'telefono', 'correo', 'nombre'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_personal';

    $modeloDoctores = new ModeloDoctores($db);
    $modeloServicio = new ModeloServicios($db);

    $result = [];
    $data = $modeloDoctores->select('DES', $inicio, $limite, $buscar, $ordenColumna, $ordenDir);
    foreach ($modeloDoctores->select('DES', $inicio, $limite, $buscar, $ordenColumna, $ordenDir) as $doctor) {
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
            'id_usuario' => $doctor['id_usuario'],
            'datosHorarios' => $datosHorarios,
            'servicios' => $servicios
        ];
    }
    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => $result
    ]);
    exit;
}

// metodo para mostrar los servicios y los doctores
function serviciosDoctor()
{
    $db = new Db();
    $modeloDoctores = new ModeloDoctores($db);
    // $modeloCategiria = new ModeloCategoria($db, $validator);

    // echo json_encode([$modeloDoctores->select(), $modeloCategiria->seleccionarCategoria()]);
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

        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $servicio = new ModeloServicios($db, $validator);
        $doctores = new ModeloDoctores($db, $validator);
        $bitacora = new ModeloBitacora($db, $validator);

        // $servicio->setIdDoctor($_POST["id_doctor"]);
        // $servicio->setIdCategoria($_POST["id_categoria"]);

        $bitacora->setId_usuario($idUsuario);
        $bitacora->setActividad("Ha asignado un servicio medico a un doctor");
        $bitacora->setTabla("Servicio Medico");

        // $insercion = $servicio->asignarServicioDoctor($idUsuario);
        // echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);

        // if (is_array($insercion) && $insercion[0] === "exito") {
        //     $bitacora->insertarBitacora();
        //     echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
        // } else {
        //     http_response_code(409);
        //     echo json_encode(['ok' => false, 'error' => $insercion]);
        //     exit;
        // }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// function agregarDoctor()
// {
//     if (empty($_POST)) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
//         exit;
//     }
//     try {
//         if (session_status() !== PHP_SESSION_ACTIVE) session_start();
//         $idUsuario = $_SESSION['id_usuario'];

//         $modeloDoctores = new ModeloDoctores();
//         $modeloBitacora = new ModeloBitacora();

//         $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
//         $imagen         = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : false;

//         $modeloDoctores->setCedula($_POST["cedula"]);
//         $modeloDoctores->setNombre($_POST["nombre"]);
//         $modeloDoctores->setApellido($_POST["apellido"]);
//         $modeloDoctores->setTelefono($_POST["telefono"]);
//         $modeloDoctores->setEmail($_POST['correo']);
//         $modeloDoctores->setNacionalidad($_POST['nacionalidad']);
//         $modeloDoctores->setImagen($imagen);
//         $modeloDoctores->setImagenTemporal($_FILES['imagen']['tmp_name']);
//         $modeloDoctores->setIdEspecialidad($_POST["id_especialidad"]);
//         $modeloDoctores->setDias($_POST['dias']);
//         $modeloDoctores->setHoraEntrada($_POST["horaEntrada"]);
//         $modeloDoctores->setHoraSalida($_POST["horaSalida"]);
//         $modeloDoctores->setIdRol($_POST['id_rol']);
//         $modeloDoctores->setUsuario($_POST["usuario"]);
//         $modeloDoctores->setPassword($passwordEncrip);

//         $insercion = $modeloDoctores->insertarDoctor($idUsuario);

//         if (is_array($insercion) && $insercion[0] === "exito") {
//             $modeloBitacora->setId_usuario($idUsuario);
//             $modeloBitacora->setTabla("doctor");
//             $modeloBitacora->setActividad("Ha Insertado un nuevo doctor");
//             $modeloBitacora->insertarBitacora($idUsuario);
//             echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
//         } else {
//             http_response_code(409);
//             echo json_encode(['ok' => false, 'error' => $insercion]);
//             exit;
//         }
//     } catch (InvalidArgumentException $e) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
//         exit;
//     }
// }

// function editarDoctor()
// {
//     if (empty($_POST)) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
//         exit;
//     }
//     try {
//         $idUsuario = $_SESSION['id_usuario'];

//         $modeloDoctores = new ModeloDoctores();
//         $modeloBitacora = new ModeloBitacora();

//         $dias      = isset($_POST["dias"])      ? $_POST["dias"]      : [];
//         $diaAnterio = isset($_POST["diaAnterio"]) ? $_POST["diaAnterio"] : [];

//         $idDiaDbE   = !empty($x = array_diff($diaAnterio, $dias))   ? $x : false;
//         $idDiaNuevo = !empty($x = array_diff($dias, $diaAnterio))   ? $x : false;
//         $igualesDb  = !empty($x = array_intersect($dias, $diaAnterio)) ? $x : false;

//         $modeloDoctores->setCedula($_POST["cedula"]);
//         $modeloDoctores->setNombre($_POST["nombre"]);
//         $modeloDoctores->setApellido($_POST["apellido"]);
//         $modeloDoctores->setTelefono($_POST["telefono"]);
//         $modeloDoctores->setIdEspecialidad($_POST["id_especialidad"]);
//         $modeloDoctores->setEmail($_POST["correo"]);
//         $modeloDoctores->setNacionalidad($_POST["nacionalidad"]);
//         $modeloDoctores->setDiasE($idDiaDbE);
//         $modeloDoctores->setDiasN($idDiaNuevo);
//         $modeloDoctores->setDiasEditar($igualesDb);
//         $modeloDoctores->setCheckeds($dias);
//         $modeloDoctores->setHoraEntrada($_POST["horaEntrada"]);
//         $modeloDoctores->setHoraSalida($_POST["horaSalida"]);
//         $modeloDoctores->setCedulaRegistrada($_POST['cedulaRegistrada']);
//         $modeloDoctores->setIdUsuario($_POST["id_usuario"]);

//         $edicion = $modeloDoctores->updateDoctor($idUsuario);

//         if (is_array($edicion) && $edicion[0] === "exito") {
//             $modeloBitacora->setId_usuario($idUsuario);
//             $modeloBitacora->setTabla("doctor");
//             $modeloBitacora->setActividad("Ha modificado un doctor");
//             $modeloBitacora->insertarBitacora($idUsuario);
//             echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
//         } else {
//             http_response_code(409);
//             echo json_encode(['ok' => false, 'error' => $edicion]);
//             exit;
//         }
//     } catch (InvalidArgumentException $e) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
//         exit;
//     }
// }

// function borrarDoctor($datos)
// {
//     if (empty($_GET)) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
//         exit;
//     }
//     try {
//         $idUsuario           = $_SESSION['id_usuario'];
//         $id_usuario_doctor   = $datos[0];


//         $modeloDoctores = new ModeloDoctores();
//         $modeloBitacora = new ModeloBitacora();

//         $modeloDoctores->setIdUsuario($id_usuario_doctor);
//         $eliminacion = $modeloDoctores->eliminacionLogica($idUsuario);

//         if (is_array($eliminacion) && $eliminacion[0] === "exito") {
//             $modeloBitacora->setId_usuario($idUsuario);
//             $modeloBitacora->setTabla("doctor");
//             $modeloBitacora->setActividad("Ha eliminado un doctor");
//             $modeloBitacora->insertarBitacora($idUsuario);
//             echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
//         } else {
//             http_response_code(409);
//             echo json_encode(['ok' => false, 'error' => $eliminacion]);
//             exit;
//         }
//     } catch (InvalidArgumentException $e) {
//         http_response_code(409);
//         echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
//         exit;
//     }
// }

function restablecer($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }
    try {
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloDoctores = new ModeloDoctores($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloDoctores->setIdUsuario($datos[0]);
        $restablecer = $modeloDoctores->restablecerDoctor($idUsuario);

        if (is_array($restablecer) && $restablecer[0] === "exito") {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setTabla("doctor");
            $modeloBitacora->setActividad("Ha restablecido un doctor");
            $modeloBitacora->insertarBitacora($idUsuario);
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
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }
    try {
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloEspecialidad = new ModeloEspecialidad($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloEspecialidad->setNombre($_POST['nombre']);
        $insercion = $modeloEspecialidad->guardar($modeloEspecialidad->get_all(),$validator);

        if (is_array($insercion)) {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setTabla("especialidad");
            $modeloBitacora->setActividad("Ha insertado una nueva especialidad");
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
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
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }
    try {
        $idUsuario       = $_SESSION['id_usuario'];
        $id_especialidad = $datos[0];
        $db=new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloEspecialidad = new ModeloEspecialidad($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloEspecialidad->setIdEspecialidad($id_especialidad);
        $eliminacion = $modeloEspecialidad->actualizar(['estado'=>'DES'],['id_especialidad'=>$modeloEspecialidad->getIdEspecialidad()],$validator);

        if (is_array($eliminacion)) {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setTabla("especialidad");
            $modeloBitacora->setActividad("Ha eliminado una especialidad");
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
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
    $db =new Db();
    $modeloDoctores = new ModeloDoctores($db);
    $modeloDoctores->setIdDoctor($id_personal);
    $respuesta = $modeloDoctores->horarioDelDoctor();
    echo json_encode($respuesta);
}