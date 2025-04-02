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

    public function especialidades_solicitadas()
    {
        $especialidades_solicitadas = $this->modeloInicio->especialidades_solicitadas();
        echo json_encode($especialidades_solicitadas);
    }
}
