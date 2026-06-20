<?php

use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloSintomas;
// use App\config\RateLimiter;

function refrescarSemaforo()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $modeloHosp = new ModeloHospitalizacion();
    $cantidadHP = $modeloHosp->semaforo();
    $_SESSION['semaforo'] = $cantidadHP[0]['cantidadP'];
    return $_SESSION['semaforo'];
}


// mostrar los datos de la tabla (hospitalizaciones pendientes)
function traerHospP()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    // mapeada en el mismo orden que las columnas de la tabla en la vista
    $columnasMapeadas = ['id_hospitalizacion', 'cedula', 'nombre', 'apellido', 'fecha_hospitalizacion']; // ajusta esto a tus columnas reales

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_hospitalizacion';

    $modeloHosp = new ModeloHospitalizacion();

    $datosH = $modeloHosp->selectsH($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $totalRegistros = $modeloHosp->contarTotalH('Pendiente');
    $totalFiltrados = !empty($buscar) ? $modeloHosp->contarTotalH('Pendiente', $buscar) : $totalRegistros;

    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalFiltrados,
        "data" => is_array($datosH) ? $datosH : []
    ];

    echo json_encode($response);
    exit;
}

// mostrar los datos de la tabla (hospitalizaciones realizadas)
function traerHospR()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_hospitalizacion', 'cedula', 'nombre', 'apellido', 'fecha_hospitalizacion']; // ajusta esto a tus columnas reales

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_hospitalizacion';

    $modeloHosp = new ModeloHospitalizacion();

    $datosH = $modeloHosp->selectsHR($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $totalRegistros = $modeloHosp->contarTotalH('Realizada');
    $totalFiltrados = !empty($buscar) ? $modeloHosp->contarTotalH('Realizada', $buscar) : $totalRegistros;

    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalFiltrados,
        "data" => is_array($datosH) ? $datosH : []
    ];

    echo json_encode($response);
    exit;
}


function traerIdURSesion()
{
    // verifica si la sesión esta activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $modeloInicio = new ModeloInicio();

    $modeloInicio->setIdPersonal($_SESSION['id_personal']);
    $validacionCargo = $modeloInicio->comprobarCargo();


    $array = ["id_usuario" => $_SESSION["id_usuario"], "id_rol" => $_SESSION["id_rol"], "validacionCargo" => $validacionCargo, "semaforoH" => refrescarSemaforo()];
    echo json_encode($array);
}

function hospitalizacion($parametro)
{
    // verifica si la sesión esta activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $modeloHosp = new ModeloHospitalizacion();
    $modeloInicio = new ModeloInicio();
    $modeloSintomas = new ModeloSintomas();
    $modeloPatologia = new ModeloPatologia();

    $vistaActiva = 'hospitalizacion';

    $idUsuario = $_SESSION['id_usuario'];
    $modeloInicio->setIdPersonal($_SESSION['id_personal']);
    $validacionCargo = $modeloInicio->comprobarCargo();
    // datos de los insumos
    $datosI = $modeloHosp->selectsInsumos();
    $doctores = $modeloHosp->selectDoctores();

    $datosS = $modeloSintomas->selects();
    $datosPatologias = $modeloPatologia->mostrarPatologias();

    require_once "./src/vistas/vistaHospitalizacion/hospitalizacion.php";
}
function hospitalizacionesRealizadas($parametro)
{
    // verifica si la sesión esta activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $modeloInicio = new ModeloInicio();
    $vistaActiva = 'hospitalizacion';


    $idUsuario = $_SESSION['id_usuario'];
    $modeloInicio->setIdPersonal($_SESSION['id_personal']);
    $validacionCargo = $modeloInicio->comprobarCargo();
    require_once "./src/vistas/vistaHospitalizacion/hospitalizacionesRealizadas.php";
}

function selectServiciosD()
{
    $modeloHosp = new ModeloHospitalizacion();

    $servicios = $modeloHosp->selectServiciosD();
    echo json_encode($servicios);
}
function serviciosDH($datos)
{
    $modeloHosp = new ModeloHospitalizacion();

    $idH = $datos[0];
    $modeloHosp->setIdH($idH);
    $servicios = $modeloHosp->selectServiciosDH();
    echo json_encode($servicios);
}

//validar paciente 
function validarPaciente()
{
    $modeloHosp = new ModeloHospitalizacion();

    $modeloHosp->setCedula($_POST["cedula"]);
    $vC = $modeloHosp->validarPacienteH();
    echo json_encode($vC);
}

//mostrar la información de un paciente doctor y control de la db 
function mostrarInformacionPCD()
{
    $modeloHosp = new ModeloHospitalizacion();
    $modeloHosp->setCedula($_POST["cedula"]);
    $info = $modeloHosp->select();
    echo json_encode($info);
}

//mostrar la información de todos los insumos de la db 
function mostrarInsumos($datos)
{
    $modeloHosp = new ModeloHospitalizacion();

    $nombre = $datos[0];
    $modeloHosp->setNombreInsumo($nombre);
    $infoInsumos = $modeloHosp->buscarInsumos();
    echo json_encode($infoInsumos);
}

//mostrar la información de un insumo de la db 
function mostrarUnInsumo($datos)
{
    $modeloHosp = new ModeloHospitalizacion();

    $id = $datos[0];
    $modeloHosp->setIdInsumo($id);
    $infoInsumo = $modeloHosp->buscarUnInsumo();
    echo json_encode($infoInsumo);
}

//para agregar hospitalización
function agregarH()
{
    // verifica si la sesión esta activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    if (refrescarSemaforo() >= 2) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "En estos momentos, no hay camillas disponibles."]);
        exit;
    }
    try {

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        // $limiter = new RateLimiter();
        // $limiter->verificar('guardar_hospitalizacion' . $idUsuario, 5, 1);

        $modeloBitacora = new ModeloBitacora();
        $modeloHosp = new ModeloHospitalizacion();

        $modeloHosp->setFechaControl($_POST["fecha"]);
        $modeloHosp->setIdPaciente($_POST["id_paciente"]);
        $modeloHosp->setIdDoctor($_POST["id_personal"]);
        $verificaH = $modeloHosp->verificaHA();


        // es para validar si existe la hospitalización
        if ($verificaH) {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => "La hospitalización ya existe."]);
            exit;
        } else {
            // no existe
            $idInsumo = (isset($_POST["id_insumo"])) ? $_POST["id_insumo"] : false;
            $cantidadI = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;

            $idServicio = (isset($_POST["id_servicio"])) ? $_POST["id_servicio"] : false;
            $cantidadS = (isset($_POST["cantidadS"])) ? $_POST["cantidadS"] : false;

            $modeloHosp->setFechaHora($_POST["fecha"]);
            $modeloHosp->setIdInsumo($idInsumo);
            $modeloHosp->setCantidadIns($cantidadI);
            $modeloHosp->setCantidadSer($cantidadS);
            $modeloHosp->setIdServicio($idServicio);
            $modeloHosp->setHistorial($_POST["historial"]);
            $modeloHosp->setSeveridad($_POST["severidad"]);
            $modeloHosp->setDiagnostico($_POST["diagnostico"]);
            $modeloHosp->setIdDoctor($_POST["id_personal"]);
            $modeloHosp->setIdPaciente($_POST["id_paciente"]);

            $registro = $modeloHosp->insertarH();

            if (is_array($registro) && $registro[0] === "exito") {
                // Guardar la bitacora
                $modeloBitacora->setTabla("hospitalizacion");
                $modeloBitacora->setActividad("Ha Insertado una hospitalizacion");
                $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
                $modeloBitacora->insertarBitacora();

                echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
            } else {
                http_response_code(409);
                echo json_encode(['ok' => false, 'error' => $registro]);
                exit;
            }
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


// traer datos de los insumos correspondiendo a la hospitalización que se edita.
function traerInsuDHEd($datos)
{
    $modeloHosp = new ModeloHospitalizacion();

    $idH = $datos[0];
    $modeloHosp->setIdH($idH);
    $datosIDH = $modeloHosp->EInsumosM();
    echo json_encode($datosIDH);
}

// traer datos de los insumos correspondiendo a la hospitalización que se edita.
function modificarH()
{
    $modeloBitacora = new ModeloBitacora();
    $modeloHosp = new ModeloHospitalizacion();


    $idServicio = (isset($_POST["id_servicio"])) ? $_POST["id_servicio"] : [];
    $cantidadS = (isset($_POST["cantidadS"])) ? $_POST["cantidadS"] : false;


    // para verificar y agregar
    $idInsumo = (isset($_POST["id_insumoA"])) ? $_POST["id_insumoA"] : false;
    $cantidadA = (isset($_POST["cantidadA"])) ? $_POST["cantidadA"] : false;
    // para verificar y editar
    $idIDH = (isset($_POST["id_idh"])) ? $_POST["id_idh"] : false;
    $cantidadE = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;
    // empty() : verifica si la variable esta vacía, si esta vacío devolverá true. 
    // para verificar si a eliminado (nota 0 es el input 1, uno es el input 2)
    $idInsElim = (empty($_POST["id_insumos_eliminados"][0]) && empty($_POST["id_insumos_eliminados"][1])) ? false : $_POST["id_insumos_eliminados"];

    // si un input esta vacío y el otro no
    $idInsElimUD = ((empty($_POST["id_insumos_eliminados"][0]) && !empty($_POST["id_insumos_eliminados"][1])) || (!empty($_POST["id_insumos_eliminados"][0]) && empty($_POST["id_insumos_eliminados"][1]))) ? false : true;

    // si no elimino insumos la variable sera false
    if ($idInsElim) {

        // los dos inputs llenos
        if ($idInsElimUD) {
            // trasformo el texto en array separando lo por la coma(del segundo input)
            $arrayIE = explode(",", $idInsElim[1]);
            // elimino el ultimo array
            array_pop($arrayIE);

            // el JSON lo convierto en array. el true es para convertirlo en array asociativo
            $array = json_decode($idInsElim[0], true);
            // une los valores de los dos array en uno
            $arrayIE = array_merge($arrayIE, $array);

            // aquí se elimina los valores duplicados
            $arrayIE = array_unique($arrayIE);
            $idInsElim = $arrayIE;

            // un input vacío y uno lleno.
        } else if ($idInsElimUD === false) {

            // si el primer input está lleno devuelve true
            $inputU = (!empty($idInsElim[0])) ? true : false;

            // si el primer input esta lleno devuelve el primero
            if ($inputU) {
                // el JSON lo convierto en array. el true es para convertirlo en array asociativo
                $idInsElim = json_decode($idInsElim[0], true);

                // si el primer input no esta lleno devuelve el segundo
            } else if ($inputU === false) {
                // trasformo el texto en array separando lo por la coma
                $idInsElim = explode(",", $idInsElim[1]);
                // elimino el ultimo array
                array_pop($idInsElim);
            }
        }
    }



    $modeloHosp->setIdInsumosA($idInsumo);
    $modeloHosp->setCantidadE($cantidadE);
    $modeloHosp->setCantidadA($cantidadA);
    $modeloHosp->setIdH($_POST["id_h"]);
    $modeloHosp->setIdInsH($idIDH);
    $modeloHosp->setIdInsElim($idInsElim);
    $modeloHosp->setIdServicio($idServicio);
    $modeloHosp->setCantidadSer($cantidadS);

    $modeloHosp->setHistorial($_POST["historialE"]);
    $modeloHosp->setDiagnostico($_POST["diagnostico"]);


    // esto se puede usar $_POST["id_controlE"]. 
    $edicion =  $modeloHosp->editarH();

    // Guardar la bitacora
    if (is_array($edicion) && $edicion[0] === "exito") {
        $modeloBitacora->setTabla("hospitalizacion");
        $modeloBitacora->setActividad("Ha modificado una hospitalización");
        $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
        $modeloBitacora->insertarBitacora();

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $edicion]);
        exit;
    }
}

// elimina la hospitalización lógicamente (lo desactiva).
function eliminaL($datos)
{
    if (isset($datos)) {
        // verifica si la sesión esta activa.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        try {
            $idUsuario = $_SESSION['id_usuario'];

            $modeloBitacora = new ModeloBitacora();
            $modeloHosp = new ModeloHospitalizacion();

            $idH = $datos[0];

            $modeloHosp->setIdH($idH);
            $eliminacion = $modeloHosp->eliminaLogico($idUsuario);

            if (is_array($eliminacion) && $eliminacion[0] === "exito") {
                $modeloBitacora->setTabla("hospitalizacion");
                $modeloBitacora->setActividad("Ha eliminado una hospitalizacion");
                $modeloBitacora->setId_usuario($idUsuario);
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
}

// buscar insumos de las hospitalizaciones existentes 
function buscarIExH()
{
    $modeloHosp = new ModeloHospitalizacion();

    $datosIns = $modeloHosp->buscarIEH();
    echo json_encode($datosIns);
}

// enviar los datos de la hospitalización a factura 
function enviarAFacturar()
{
    $modeloHosp = new ModeloHospitalizacion();

    $idH = $_POST["idH"];
    date_default_timezone_set('America/Caracas');
    $fechaHF = date("Y-m-d H:i:s");
    $monto = round($_POST["monto"], 2);
    $montoME = round($_POST["montoME"], 2);
    $total = round($_POST["total"], 2);
    $totalME = round($_POST["totalME"], 2);

    $modeloHosp->setIdH($idH);
    $modeloHosp->setFechaHoraFinal($fechaHF);
    $modeloHosp->setMonto($monto);
    $modeloHosp->setMontoME($montoME);
    $modeloHosp->setTotal($total);
    $modeloHosp->setTotalME($totalME);

    $modeloHosp->setHistorial($_POST["historialEnF"]);

    $modeloHosp->setSintomasId(isset($_POST["sintomas"]) ? $_POST["sintomas"] : []);
    $modeloHosp->setPatologiasId(isset($_POST["patologias"]) ? $_POST["patologias"] : []);
    $modeloHosp->setNota($_POST["nota"]);
    $modeloHosp->setIndicaciones($_POST["indicaciones"]);
    $modeloHosp->setFechaRegreso($_POST["fechaDeCita"]);
    $modeloHosp->setDiagnostico($_POST["diagnostico"]);
    $modeloHosp->setSeveridad($_POST["severidad"]);

    $irF = $modeloHosp->facturarH();
    echo json_encode(["success" => $irF, "data" => $_POST]);
}

function permisos($id_rol, $permiso, $modulo)
{
    $modeloPermisos = new ModeloPermisos();
    $modeloPermisos->setIdRol($id_rol);
    $modeloPermisos->setPermiso($permiso);
    $modeloPermisos->setModulo($modulo);
    return $modeloPermisos->gestionarPermisos();
}

function hospitalizacionApk()
{
    if (ob_get_length()) ob_clean();
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");

    date_default_timezone_set('America/Caracas');

    try {
        $modelo    = new ModeloHospitalizacion();
        $pacientes = $modelo->mostrarHospitalizacionesApk();

        if (!is_array($pacientes)) {
            throw new \Exception("Error al obtener hospitalizaciones: " . $pacientes);
        }

        // Contar ingresos de hoy comparando con fecha PHP (no CURDATE de MySQL)
        $hoy          = date("Y-m-d");
        $ingresosHoy  = 0;
        foreach ($pacientes as $p) {
            if (substr($p['fecha_hora_inicio'], 0, 10) === $hoy) {
                $ingresosHoy++;
            }
        }

        $altasHoy = $modelo->contarAltasHoy($hoy);

        echo json_encode([
            'pacientes' => $pacientes,
            'stats'     => [
                'total_camas'  => 2,
                'ocupadas'     => count($pacientes),
                'disponibles'  => 2 - count($pacientes),
                'ingresos_hoy' => $ingresosHoy,
                'altas_hoy'    => $altasHoy,
            ]
        ]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(["ok" => false, "error" => $e->getMessage()]);
    }
    exit;
}
