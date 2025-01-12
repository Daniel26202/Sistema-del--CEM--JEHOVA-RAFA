<?php

require('./Plugins/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('./Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', '', 15);
        $this->Image('./Image/123.png', 10, -13, 100);

        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 22);
        $this->SetFillColor(248, 252, 255);
        
        $this->Cell(100, 10, 'DIRECCION', 0, 1, 'C');
        $this->SetXY(110, 28.5);

        $this->Cell(100, 10, 'TELEFONO', 0, 1, 'C');
        $this->SetXY(110, 35);

        $this->Cell(100, 10, 'CORREO', 0, 1, 'C');
        $this->SetXY(110, 41);

        $this->Cell(100, 10, 'RIF', 0, 1, 'C');


        $this->Image('./Image/pngwing.com.png', 45, 75, 120);

    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(20);
$pdf->SetTextColor(14, 169, 181);

$pdf->Cell(10);

$pdf->Cell(80, 10, utf8_decode(' SINTOMAS'), 0, 0, 'C');
$pdf->Cell(80, 10, utf8_decode(' INDICACIONES'), 0, 1, 'C');

$pdf->SetY(121);
$pdf->Cell(10);
$pdf->Cell(80, 10, utf8_decode(' DIAGNOSTICO'), 0, 0, 'C');



$pdf->SetFillColor(14, 169, 181);

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(10);
$pdf->SetXY(20, 120);
$pdf->Cell(80, 50, utf8_decode('DIAGNOSTICO123'), 0, 0, 'L');
$pdf->SetXY(105, 70);
$pdf->Cell(80, 100, utf8_decode(' INDICACIONES123'), 0, 1, 'L');
$pdf->Rect(100, 70, 1, 110, 'F');

$pdf->SetY(70);
$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('SINTOMAS1234'), 0, 0, 'L');



$pdf->Ln(110);

$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('DIRECCION DEL MEDICO'), 0, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('TLFN DEL MEDICO'), 0, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('CORREO DEL MEDICO'), 0, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('RIF DEL MEDICO'), 0, 0, 'L');


$pdf->Ln(25);


$pdf->SetFont('Arial', 'B', 18);

$pdf->Cell(10);
$pdf->Cell(80, 50, utf8_decode('FECHA: 2/10/2024'), 0, 0, 'L');



$pdf->Output();
