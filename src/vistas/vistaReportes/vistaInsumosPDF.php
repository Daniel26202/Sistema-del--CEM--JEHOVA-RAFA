<?php

// Ruta al archivo PDF que deseas descargar
// $archivo = './src/assets/fpdf/descarga.pdf';

// // Verificar si el archivo existe
// if (file_exists($archivo)) {
//     // Establecer las cabeceras para la descarga
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/pdf');
//     header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($archivo));
    
//     // Limpiar el búfer de salida
//     ob_clean();
//     flush();
    
//     // Leer el archivo y enviarlo al navegador
//     readfile($archivo);
//     exit;
// } else {
//     echo "El archivo no existe.";
// }
// ?
$insumos = $this->modelo->pdfInsumos($_GET["pdf"]);

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('./src/assets/Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 30);
        $this->Image('./src/assets/Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 15);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(90, 35, 'INSUMOS', 0, 1, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);



$pdf->Cell(4);
$pdf->Cell(50, 20, utf8_decode('NOMBRE'), 0, 0, 'C');
$pdf->Cell(50, 20, utf8_decode('DESCRIPCIÓN'), 0, 0, 'C');
$pdf->Cell(50, 20, utf8_decode('CANTIDAD'), 0, 0, 'C');
$pdf->Cell(40, 20, utf8_decode('PRECIO'), 0, 0, 'C');

foreach($insumos as $insumo){
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 15);


$pdf->Cell(4);
$pdf->Cell(50, 20, utf8_decode($insumo["nombre"]), 0, 0, 'C');
$pdf->Cell(50, 20, utf8_decode($insumo["descripcion"]), 0, 0, 'C');
$pdf->Cell(50, 20, utf8_decode($insumo["cantidad"]), 0, 0, 'C');
$pdf->Cell(40, 20, utf8_decode($insumo["precio"]." "."BS"), 0, 0, 'C');


}
$pdf->Ln(10);


$pdf->Cell(10);
$pdf->Cell(80, 20, utf8_decode('-------------------------------------------------------------------------------------------------'), 0, 0, 'L');
$pdf->Ln(12);






// Establecer las cabeceras para la descarga del PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="insumos.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Generar el PDF y enviarlo al navegador
$pdf->Output('D'); // 'D' indica que se debe descargar el archivo
exit;
?>