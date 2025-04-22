<?php

$citas = $this->modelo->Citaspdf($_POST["desdeFecha"], $_POST["fechaHasta"]);

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('./src/assets/Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 30);
        $this->Image('./src/assets/Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(110, 15);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(90, 35, 'LISTADO CITAS', 0, 1, 'C');
    }
}

// Creación del objeto de la clase heredada

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);

foreach($citas as $cita){
// AQUI PONES EL FOREACH
$pdf->Cell(10);
$pdf->Cell(40, 20, utf8_decode('FECHA: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode('').$cita["fecha"], 0, 0, 'L');

$pdf->Cell(20);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(30, 20, utf8_decode('HORA: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode($cita["hora"]), 0, 0, 'L');

$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('DOCTOR: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, strtoupper($cita["nombre_d"].' '.$cita["apellido_d"]), 0, 0, 'L');

$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('PACIENTE: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, strtoupper($cita["nombre_p"].' '.$cita["apellido_p"]), 0, 0, 'L');


$pdf->Cell(35);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(10, 20, utf8_decode('       CI: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, strtoupper('       '.$cita["nacionalidad"].'-'.$cita["cedula_p"]), 0, 0, 'L');

$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('TELEFONO: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(20, 20, utf8_decode($cita["telefono_p"]), 0, 0, 'L');

$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(40, 20, utf8_decode('ESTADO: '), 0, 0, 'L');
$pdf->Cell(20, 20, strtoupper($cita["estado"]), 0, 0, 'L');
$pdf->Ln(12);

$pdf->Cell(10);
$pdf->Cell(80, 20, utf8_decode('-------------------------------------------------------------------------------------------------'), 0, 0, 'L');
$pdf->Ln(12);

}
// AQUI TERMINAS EL FORECAH



ob_end_clean(); // Limpia el búfer de salida
$pdf->Output();
exit;