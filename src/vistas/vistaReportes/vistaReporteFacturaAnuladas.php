<?php



$facturas = $this->modelo->consultarReporteFacturaAnuladas($_POST["fechaInicioAnulada"], $_POST["fechaFinalAnulada"]);


class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('./src/assets/Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 25);
        $this->Image('./src/assets/Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 15);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(90, 15, 'FACTURAS ANULADAS', 0, 1, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);



$pdf->Cell(5);
$pdf->Cell(30, 20, utf8_decode('CODIGO'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('NOMBRE'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('APELLIDO'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('CEDULA'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('FECHA'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('MONTO'), 0, 0, 'C');


foreach($facturas as $factura){

$pdf->Ln(10);






$pdf->SetFont('Arial', '', 10);

$pdf->Cell(5);
$pdf->Cell(30, 20, utf8_decode($factura["id_factura"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($factura["nombre_p"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($factura["apellido_p"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($factura["nacionalidad"].'-'.$factura["cedula_p"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($factura["fecha"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($factura["total"].' '.'BS'), 0, 0, 'C');
}
$pdf->SetFont('Arial', '', 12);





$pdf->Output();