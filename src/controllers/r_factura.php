<?php

require('./Plugins/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('./Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 35);
        $this->Image('./Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 15);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(100, 35, 'FACTURA', 0, 1, 'C');
        $this->SetFont('Arial', '', 15);
        $this->SetXY(108, 30);
        $this->Cell(130, -20, '2024/09/23', 0, 1, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(40);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(62, 10, utf8_decode('CODIGO: 16'), 0, 0, 'C');


$pdf->Ln(15);
$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(14, 169, 181);
$pdf->SetTextColor(255,255,255);

$pdf->Cell(170, 10, utf8_decode('DATOS DEL PACIENTE'), 0, 0, 'C',1);
$pdf->Ln(14);
$pdf->Cell(10);

$pdf->SetFillColor(228, 235, 240);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(85, 10, 'NOMBRE: DIXON BASTIAS', 0, 0, 'L',0);
$pdf->Cell(85, 10, 'C.I:  12345678', 0, 0, 'L',0);


$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(14, 169, 181);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(170, 10, utf8_decode('DETALLES'), 0, 0, 'C',1);


$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFillColor(228, 235, 240);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(85, 10, 'SERVICIO: UROLOGO', 0, 0, 'L',0);
$pdf->Cell(85, 10, 'DOCTOR: JESUS HERNANDEZ', 0, 0, 'L',0);


$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(228, 235, 240, 3);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(170, 10, utf8_decode('SERVICIOS EXTRAS'), 0, 0, 'C',1);


$pdf->Ln(14);



$pdf->Cell(10);
$pdf->SetFillColor(228, 235, 240);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(85, 10, 'SERVICIO: UROLOGO', 0, 0, 'L',0);
$pdf->Cell(85, 10, 'DOCTOR: LUIS LOPEZ', 0, 0, 'L',0);


$pdf->Ln(70);

$pdf->Cell(10);
$pdf->Cell(110, 10, 'METODOS DE PAGO: EFECTIVO', 0, 0, 'L',0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(14, 169, 181);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(50, 10, 'TOTAL: 457 BS', 0, 0, 'C',1);

$pdf->Output();
