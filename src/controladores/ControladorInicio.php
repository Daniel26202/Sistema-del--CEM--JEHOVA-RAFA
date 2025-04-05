<?php

use App\modelos\ModeloInicio;
use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;

class ControladorInicio
{

    private $modeloInicio;
    private $modeloCitas;
    private $bitacora;

    public function __construct()
    {
        $this->modeloInicio = new ModeloInicio();
        $this->modeloCitas = new ModeloCita();
        $this->bitacora = new ModeloBitacora();
    }

    public function inicio($parametro)
    {
        if ($parametro != "" && $parametro[0] == "cerrar") {
            // verifica si la sesión esta activa.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            // Guardar la bitácora
            $this->bitacora->insertarBitacora($_SESSION['id_usuario'], "cerrar session", "Ha cerrado la session ");
            // Destruyen las variables de las sesión 
            session_unset();
            session_destroy();

            // Redireccionar al inicio
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion");
            exit();
        }

        require_once './src/vistas/dashboard.php';
    }
    public function manualUsuario()
    {
        // Ruta al archivo PDF que deseas descargar
        $archivo = './src/assets/fpdf/Manual.pdf';


        if (file_exists($archivo)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));


            ob_clean();
            flush();


            readfile($archivo);
            exit;
        } else {
            echo "El archivo no existe.";
        }
    }

    public function servicios()
    {
        $dataDeServicios = $this->modeloInicio->servicios();
        echo json_encode($dataDeServicios);
    }



    public function citasDeHoy()
    {
        $dataDeCitasHoy = $this->modeloCitas->mostrarCitaHoy(date("Y-m-d"));
        echo json_encode($dataDeCitasHoy);
    }

    public function citas()
    {
        $dataDeCitas = $this->modeloCitas->mostrarCita();
        echo json_encode($dataDeCitas);
    }

    public function pacientes_hospitalizados()
    {
        $pacientes_hospitalizados = $this->modeloInicio->pacientes_hospitalizados();
        echo json_encode($pacientes_hospitalizados);
    }

    public function especialidades_solicitadas()
    {
        $especialidades_solicitadas = $this->modeloInicio->especialidades_solicitadas();
        echo json_encode($especialidades_solicitadas);
    }

    public function sintomas_comunes()
    {
        $sintomas_comunes = $this->modeloInicio->sintomas_comunes();
        echo json_encode($sintomas_comunes);
    }

    public function exportar_pdf()
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
}
