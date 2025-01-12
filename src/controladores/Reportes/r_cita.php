<?php

require('./Plugins/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('./Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 30);
        $this->Image('./Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 15);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(90, 35, 'NOTA DE CITA', 0, 1, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);



$pdf->Cell(10);
$pdf->Cell(40, 20, utf8_decode('FECHA: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('20/10/2024'), 0, 0, 'L');


$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('HORA: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('2:00 PM'), 0, 0, 'L');


$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('DOCTOR: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('WILMER DANIEL BAEZ RIVERO'), 0, 0, 'L');



$pdf->Ln(15);

$pdf->Cell(10);
$pdf->Cell(80, 20, utf8_decode('-------------------------------------------------------------------------------------------------'), 0, 0, 'L');

$pdf->Ln(15);




$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('PACIENTE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('DIXON BASTIAS'), 0, 0, 'L');


$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('CI: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('30256894'), 0, 0, 'L');



$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('TELEFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('04161214717'), 0, 0, 'L');



$pdf->Ln(30);
$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(40, 50, utf8_decode('ESTADO: '), 0, 0, 'L');
$pdf->Cell(20, 50, utf8_decode('PENDIENTE'), 0, 0, 'L');






$pdf->Output();
