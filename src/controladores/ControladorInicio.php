<?php


class ControladorInicio
{

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

}

?>