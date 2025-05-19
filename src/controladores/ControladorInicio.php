<?php

use App\modelos\ModeloInicio;
use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloDoctores;

class ControladorInicio
{

    private $modeloInicio;
    private $modeloCitas;
    private $bitacora;
    private $permisos;
    private $modeloDoctores;

    public function __construct()
    {
        $this->modeloInicio = new ModeloInicio();
        $this->modeloCitas = new ModeloCita();
        $this->bitacora = new ModeloBitacora();
        $this->permisos = new ModeloPermisos();
        $this->modeloDoctores = new ModeloDoctores();
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


        $validarCargo = $this->modeloInicio->comprobarCargo($_SESSION["id_usuario"]);
        $datos_de_personal =  $this->modeloInicio->datos_doctor($_SESSION["id_usuario"]);

        require_once './src/vistas/dashboard.php';
    }

    //Retorna el precio  del dolar y guardarlo en la session
    public function valorDolar($datos)
    {
        $_SESSION["dolar"] = number_format($datos[0], 2, '.', '.');
        echo json_encode($_SESSION["dolar"]);
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
    public function especialidades_solicitadas_filtradas($datos)
    {
        $especialidades_solicitadas = $this->modeloInicio->especialidades_solicitadas($datos[0],$datos[1]);
        echo json_encode($especialidades_solicitadas);
    }

    public function todas_las_especialidades()
    {
        $todas_las_especialidades = $this->modeloInicio->todas_las_especialidades();
        echo json_encode($todas_las_especialidades);
    }

    public function sintomas_comunes()
    {
        $sintomas_comunes = $this->modeloInicio->sintomas_comunes();
        echo json_encode($sintomas_comunes);
    }

    public function sintomas_comunes_filtrados($datos)
    {
        $sintomas_comunes = $this->modeloInicio->sintomas_comunes($datos[0],$datos[1]);
        echo json_encode($sintomas_comunes);
    }

    public function todos_los_sintomas()
    {
        $todos_los_sintomas = $this->modeloInicio->todos_los_sintomas();
        echo json_encode($todos_los_sintomas);
    }

    //Datos del horario del doctor
    public function mostrarHorario($datos)
    {
        echo json_encode($this->modeloCitas->mostrarHorarioDoctores($datos[0]));
    }

    public function retornarDoctores()
    {
        echo json_encode($this->modeloDoctores->select());
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

    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }


    public function diasConMasCitas($parametro)
    {
        $id_personal = isset($parametro[0]) ? $parametro[0] : "";
        // Llama al modelo para obtener los datos
        $diasConMasCitas = $this->modeloInicio->obtenerDiasConMasCitas($id_personal);
        // Retorna los datos como JSON
        echo json_encode($diasConMasCitas);
    }
}
