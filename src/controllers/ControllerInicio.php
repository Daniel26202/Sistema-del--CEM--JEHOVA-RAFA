<?php

use App\models\Db;
use App\models\ModeloInicio;
use App\models\ModeloCita;
use App\models\ModeloBitacora;
use App\models\ModeloUsuarios;
use App\models\ModeloDoctores;
use App\models\Validator;

function inicio($parametro)
{
    $db = new Db();
    $validator = new Validator();
    $validator->set_session($_SESSION);
    $validator->set_id_usuario($_SESSION['id_usuario']);

    $modeloInicio = new ModeloInicio($db,$validator);
    $bitacora = new ModeloBitacora($db,$validator);
    $usuario = new ModeloUsuarios($db,$validator);

    if ($parametro != "" && $parametro[0] == "cerrar") {
        // verifica si la sesión esta activa.
        // if (session_status() !== PHP_SESSION_ACTIVE) {
        //     session_start();
        // } que esto ya esta en index

        //actualizar el token de inicio de session a su estado original es decir Null
        //actualizar el token del usuario
        $usuario->setIdUsuario($_SESSION['id_usuario']);
        $usuario->setTokenInicioSesion(NULL);
        // $usuario->actualizarTokenInicioSesion();


        // Guardar la bitácora

        $bitacora->setId_usuario($_SESSION['id_usuario']);
        $bitacora->setActividad("Ha cerrado la session");
        $bitacora->setTabla("cerrar session");

        $bitacora->guardar($bitacora->get_all(), $_SESSION['id_usuario']);

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

    $validarCargo = $modeloInicio->setIdPersonal($_SESSION["id_personal"]);
    $validarCargo = $modeloInicio->comprobarCargo();
    $datos_de_personal =  $modeloInicio->datos_doctor(['id_usuario' => $_SESSION["id_usuario"]]);

    $ayuda = "btnayudaInicio";
    $vistaActiva = "inicio";

    require_once './src/vistas/dashboard.php';
}

//Retorna el precio  del dolar y guardarlo en la session
function valorDolar($datos)
{
    $_SESSION["dolar"] = number_format($datos[0], 2, '.', '.');
    echo json_encode($_SESSION["dolar"]);
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
    $db = new Db();
    $modeloInicio = new ModeloInicio($db);
    echo json_encode($modeloInicio->servicios());
}



function citasDeHoy()
{
    $db = new Db();
    $validator = new Validator();
    $modelo = new ModeloCita($db, $validator);
    echo json_encode($modelo->mostrarCitaHoy());
}

function cerrarSession()
{
    $db = new Db();
    $validator = new Validator();
    $bitacora = new ModeloBitacora($db, $validator);
    $usuario = new ModeloUsuarios($db, $validator);
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    // if (session_status() !== PHP_SESSION_ACTIVE) {
    //     session_start();
    // } Y otra vez
    // Guardar la bitácora
    $usuario->setTokenInicioSesion(null);
    $usuario->setIdUsuario(empty($_SESSION['id_usuario']) ? $_SESSION['id_usuario_verificar'] : $_SESSION['id_usuario']);
    // $usuario->actualizarTokenInicioSesion();
    
    $bitacora->setId_usuario(empty($_SESSION['id_usuario']) ? $_SESSION['id_usuario_verificar'] : $_SESSION['id_usuario']);
    $bitacora->setActividad("Ha cerrado la session");
    $bitacora->setTabla("cerrar session");

    $bitacora->guardar($bitacora->get_all(), $_SESSION['id_usuario']);

    // Destruyen las variables de las sesión 
    session_unset();
    session_destroy();

    echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
}

function citas()
{
    $db = new Db();
    $validator = new Validator();
    $modelo = new ModeloCita($db,$validator);
    echo json_encode($modelo->mostrarCita());
}

function pacientes_hospitalizados()
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    echo json_encode($modelo->pacientes_hospitalizados());
}

function especialidades_solicitadas()
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    // echo json_encode($modelo->especialidades_solicitadas());
    echo json_encode([]);
}
function especialidades_solicitadas_filtradas($datos)
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    $modelo->setFechaInicio($datos[0]);
    $modelo->setFechaFinal($datos[1]);
    // echo json_encode($modelo->especialidades_solicitadas());
    echo json_encode([]);
}

function todas_las_especialidades()
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    echo json_encode($modelo->todas_las_especialidades());
}

function sintomas_comunes()
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    // echo json_encode($modelo->sintomas_comunes());
    echo json_encode([]);
}

function sintomas_comunes_filtrados($datos)
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    $modelo->setFechaInicio($datos[0]);
    $modelo->setFechaFinal($datos[1]);
    // echo json_encode($modelo->sintomas_comunes());
    echo json_encode([]);
}

function todos_los_sintomas()
{
    $db = new Db();
    $modelo = new ModeloInicio($db);
    echo json_encode($modelo->todos_los_sintomas());
}

//Datos del horario del doctor
function mostrarHorario($datos)
{
    $db = new Db();
    $validator = new Validator();
    $modelo = new ModeloCita($db, $validator);
    // $modelo->setIdDoctor($datos[0]);
    // echo json_encode($modelo->mostrarHorarioDoctores());
    echo json_encode([]);
}

function retornarDoctores()
{
    $db = new Db();
    $validator = new Validator();
    $modelo = new ModeloDoctores($db, $validator);
    echo json_encode($modelo->select());
}

function exportar_pdf()
{
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
    $db = new Db();
    $modelo = new ModeloInicio($db);
    $id_personal = isset($parametro[0]) ? $parametro[0] : 0;
    $modelo->setIdPersonal($id_personal);
    // echo json_encode($modelo->obtenerDiasConMasCitas());
    echo json_encode([]);
}
