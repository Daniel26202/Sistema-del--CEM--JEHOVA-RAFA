<?php

use App\modelos\ModeloInicio;
use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloSanetizarJSON;
use App\config\Cifrado;


function inicioTienePermiso($modulo, $permiso = 'consultar')
{
    if (empty($_SESSION['id_usuario']) || empty($_SESSION['id_rol'])) {
        return false;
    }

    $modeloPermisos = new ModeloPermisos();
    $modeloPermisos->setIdRol((string)$_SESSION['id_rol']);
    $modeloPermisos->setModulo($modulo);
    $idModulo = $modeloPermisos->returnIdModule();
    if (!$idModulo) {
        return false;
    }

    $modeloPermisos->setIdModulo($idModulo);
    $modeloPermisos->setPermiso($permiso);
    return (bool)$modeloPermisos->gestionarPermisos();
}

function exigirPermisoInicio($modulo)
{
    if (inicioTienePermiso($modulo)) {
        return true;
    }

    http_response_code(403);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'No tiene permiso para consultar esta información.']);
    return false;
}


function inicio($parametro)
{
    $modeloInicio = new ModeloInicio();
    $bitacora = new ModeloBitacora();
    $usuario = new ModeloUsuarios();

    if ($parametro != "" && $parametro[0] == "cerrar") {
        // verifica si la sesión esta activa.
        // if (session_status() !== PHP_SESSION_ACTIVE) {
        //     session_start();
        // } que esto ya esta en index

        // Guardar la bitácora

        $bitacora->setId_usuario($_SESSION['id_usuario']);
        $bitacora->setActividad("Ha cerrado la session");
        $bitacora->setTabla("cerrar session");

        $bitacora->insertarBitacora();
        // Destruyen las variables de las sesión 
        session_unset();
        session_destroy();

        // Redireccionar al inicio

        header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion");
        exit();
    }

    if (!isset($_SESSION['id_personal'])) {
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion");
        exit();
    }

    $modeloInicio->setIdPersonal($_SESSION["id_personal"]);
    $validarCargo = $modeloInicio->comprobarCargo();
    if (!is_numeric($validarCargo)) {
        throw new \RuntimeException('No se pudo determinar el cargo del usuario.');
    }
    $validarCargo = (int)$validarCargo === 1;
    $datos_de_personal = $modeloInicio->datos_personal(['id_usuario' => $_SESSION["id_usuario"]]);
    if (empty($datos_de_personal)) {
        throw new \RuntimeException('No se encontraron los datos del personal autenticado.');
    }

    $puedeVerEstadisticas = inicioTienePermiso('Estadisticas');
    $puedeConsultarCitas = inicioTienePermiso('Citas');
    $puedeMostrarCalendario = $puedeVerEstadisticas || ($validarCargo && $puedeConsultarCitas);
    $agendaPersonal = ($validarCargo && $puedeConsultarCitas)
        ? $modeloInicio->obtenerAgendaPersonal($_SESSION['id_personal'])
        : [];
    $horarioSemanal = $validarCargo
        ? $modeloInicio->obtenerHorarioSemanal($_SESSION['id_personal'])
        : [];
    $idPersonalCalendario = $validarCargo ? hashId((int)$_SESSION['id_personal']) : '';

    $ayuda = "btnayudaInicio";
    $vistaActiva = "inicio";

    require_once './src/vistas/dashboard.php';
}

//valida y guarda en sesión la tasa de cambio recibida del navegador.
function valorDolar($datos)
{
    $tasa = is_array($datos) ? ($datos[0] ?? null) : null;

    if (!is_numeric($tasa)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => 'Tasa de cambio inválida.']);
        exit;
    }

    $tasa = (float)$tasa;

    // Rango plausible para el dólar. Fuera de él lo más probable es un error
    // de formato o una manipulación.
    if ($tasa <= 0 || $tasa > 100000) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => 'Tasa de cambio fuera de rango razonable.']);
        exit;
    }

    // Redondeo a 2 decimales SIN separador de miles.
    $tasa = round($tasa, 2);

    $_SESSION["dolar"] = $tasa;
    $_SESSION["dolar_fecha"] = date('Y-m-d');

    header('Content-Type: application/json');
    echo json_encode(['ok' => true, 'tasa' => $tasa]);
}


function manualUsuario()
{
    // Ruta al archivo PDF que deseas descargar
    $archivo = './src/assets/fpdf/Manual.pdf';


    if (file_exists($archivo)) {

        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: ');
        header('Content-Length: ' . filesize($archivo));


        ob_clean();
        flush();


        readfile($archivo);
        exit;
    } else {
        echo "El archivo no existe.";
    }
}

function servicios()
{
    $modeloInicio = new ModeloInicio();
    echo json_encode($modeloInicio->servicios());
}



function citasDeHoy()
{
    if (!exigirPermisoInicio('Citas')) {
        return;
    }

    $modelo = new ModeloInicio();
    echo json_encode($modelo->contarCitasDeHoy());
}

function cerrarSession()
{
    $bitacora = new ModeloBitacora(false);
    $usuario = new ModeloUsuarios();
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }


    $bitacora->setId_usuario(empty($_SESSION['id_usuario']) ? $_SESSION['id_usuario_verificar'] : $_SESSION['id_usuario']);
    $bitacora->setActividad("Ha cerrado la session");
    $bitacora->setTabla("cerrar session");

    $bitacora->insertarBitacora();
    // Destruyen las variables de las sesión 
    session_destroy();
    // session_unset();


    echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
}

function citas()
{
    if (!exigirPermisoInicio('Citas')) {
        return;
    }

    $modelo = new ModeloInicio();
    echo json_encode($modelo->contarCitasPendientes());
}

function pacientes_hospitalizados()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();
    echo json_encode($modelo->pacientes_hospitalizados());
}

function especialidades_solicitadas()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();
    echo json_encode($modelo->especialidades_solicitadas());
}
function especialidades_solicitadas_filtradas($datos)
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();
    $modelo->setFechaInicio($datos[0]);
    $modelo->setFechaFinal($datos[1]);
    echo json_encode($modelo->especialidades_solicitadas());
}

function todas_las_especialidades()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();

    echo json_encode($modelo->todas_las_especialidades());
}

function sintomas_comunes()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();

    echo json_encode($modelo->sintomas_comunes());
}

function sintomas_comunes_filtrados($datos)
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();
    $modelo->setFechaInicio($datos[0]);
    $modelo->setFechaFinal($datos[1]);
    echo json_encode($modelo->sintomas_comunes());
}

function todos_los_sintomas()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloInicio();

    echo json_encode($modelo->todos_los_sintomas());
}

//Datos del horario del doctor
function mostrarHorario($datos)
{
    $modelo = new ModeloCita();
    $modelo->setIdDoctor(unhashId($datos[0]));
    echo json_encode($modelo->mostrarHorarioDoctores());
}

function retornarDoctores()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    $modelo = new ModeloDoctores();
    $sanitizador = new ModeloSanetizarJSON();
    $sanitizador->setHashKeys(['id_personal']);
    echo json_encode($sanitizador->sanitizeRecursive($modelo->selectDoctoresParaEstadisticas()));
}

function exportar_pdf()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        return;
    }

    // Leer los datos JSON enviados por AJAX
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["imagen"])) {
        http_response_code(400);
        echo json_encode(["error" => "No se recibió la imagen"]);
        exit;
    }

    // Procesar la imagen en Base64
    $imgData = str_replace('data:image/png;base64,', '', $data["imagen"]);
    $imgData = str_replace(' ', '+', $imgData);
    $imgDecoded = base64_decode($imgData);

    // Guardar la imagen temporalmente
    $fileName = './src/assets/fpdf/grafico_temp.png';
    file_put_contents($fileName, $imgDecoded);

    // Datos para el reporte: descripción y leyenda estadística
    $descripcion = isset($data["descripcion"]) ? $data["descripcion"] : "Reporte de servicios más solicitados.";
    // Aquí podrías incluir cálculos estadísticos adicionales (media, moda, etc.)
    $leyenda = "El análisis muestra que la especialidad con mayor demanda es la que presenta la mayor frecuencia de solicitudes. Se han calculado medidas estadísticas para brindar un panorama completo.";

    // Crear el PDF usando FPDF
    require_once './src/assets/fpdf/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('Reporte de Servicios Más Solicitados'), 0, 1, 'C');

    $pdf->Ln(10);
    // Insertar la imagen del gráfico
    $pdf->Image($fileName, 35, $pdf->GetY(), 140);
    $pdf->Ln(90);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode("Leyenda:\n" . $leyenda));
    $pdf->Ln(5);
    $pdf->MultiCell(0, 10, utf8_decode("Descripción:\n" . $descripcion));

    // Enviar el PDF al navegador
    header("Content-Type: application/pdf");
    $pdf->Output("reporte_servicios.pdf", "I");

    // Eliminar la imagen temporal
    unlink($fileName);
}



function diasConMasCitas($parametro)
{
    $modelo = new ModeloInicio();
    if (!inicioTienePermiso('Estadisticas')) {
        $id_personal = $_SESSION['id_personal'] ?? 0;
        if (!inicioTienePermiso('Citas') || !$id_personal) {
            exigirPermisoInicio('Estadisticas');
            return;
        }

        $modelo->setIdPersonal($id_personal);
        $esDoctor = $modelo->comprobarCargo();
        if (!is_numeric($esDoctor)) {
            throw new \RuntimeException('No se pudo determinar el cargo del usuario.');
        }
        if ((int)$esDoctor !== 1) {
            exigirPermisoInicio('Estadisticas');
            return;
        }
    } else {
        $id_personal = isset($parametro[0]) && $parametro[0] !== '' ? unhashId($parametro[0]) : 0;
    }

    $modelo->setIdPersonal($id_personal);
    echo json_encode($modelo->obtenerDiasConMasCitas());
}


function especialidadesApk()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        exit;
    }

    if (ob_get_length()) ob_clean();
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('America/Caracas');

    try {
        $modelo = new ModeloInicio();
        if (isset($_GET['inicio']) && isset($_GET['final'])) {
            $modelo->setFechaInicio($_GET['inicio']);
            $modelo->setFechaFinal($_GET['final']);
        }
        $especialidades = $modelo->especialidades_solicitadas();
        $totalEspecialidades = $modelo->todas_las_especialidades();

        echo json_encode(Cifrado::cifrarRespuesta([
            'especialidades' => $especialidades,
            'totalEspecialidades' => $totalEspecialidades,
        ]));
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(Cifrado::cifrarRespuesta(["ok" => false, "error" => $e->getMessage()]));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(Cifrado::cifrarRespuesta(["ok" => false, "error" => "Error interno: " . $e->getMessage()]));
    }
    exit;
}

function sintomasApk()
{
    if (!exigirPermisoInicio('Estadisticas')) {
        exit;
    }

    if (ob_get_length()) ob_clean();
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('America/Caracas');

    try {
        $modelo = new ModeloInicio();
        if (isset($_GET['inicio']) && isset($_GET['final'])) {
            $modelo->setFechaInicio($_GET['inicio']);
            $modelo->setFechaFinal($_GET['final']);
        }
        $sintomas = $modelo->sintomas_comunes();
        $totalSintomas = $modelo->todos_los_sintomas();

        echo json_encode(Cifrado::cifrarRespuesta([
            'sintomas' => $sintomas,
            'totalSintomas' => $totalSintomas,
        ]));
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(Cifrado::cifrarRespuesta(["ok" => false, "error" => $e->getMessage()]));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(Cifrado::cifrarRespuesta(["ok" => false, "error" => "Error interno: " . $e->getMessage()]));
    }
    exit;
}
