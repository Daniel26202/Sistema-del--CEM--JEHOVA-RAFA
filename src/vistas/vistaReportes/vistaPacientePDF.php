<?php



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
        $this->Cell(90, 35, 'PACIENTES', 0, 1, 'C');
    }
}



// // Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);



$pdf->Cell(5);
$pdf->Cell(30, 20, utf8_decode('NOMBRE'), 0, 0, 'C');
$pdf->Cell(35, 20, utf8_decode('APELLIDO'), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode('CEDULA'), 0, 0, 'C');
$pdf->Cell(45, 20, utf8_decode('TELEFONO'), 0, 0, 'C');
$pdf->Cell(40, 20, utf8_decode('DIRECCIÓN'), 0, 0, 'C');
foreach($pacientes as $paciente){

$pdf->Ln(10);






$pdf->SetFont('Arial', '', 10);

$pdf->Cell(5);
$pdf->Cell(30, 20, utf8_decode($paciente["nombre"]), 0, 0, 'C');
$pdf->Cell(35, 20, utf8_decode($paciente["apellido"]), 0, 0, 'C');
$pdf->Cell(30, 20, utf8_decode($paciente["nacionalidad"].'-'.$paciente["cedula"]), 0, 0, 'C');
$pdf->Cell(45, 20, utf8_decode($paciente["telefono"]), 0, 0, 'C');
$pdf->Cell(40, 20, utf8_decode($paciente["direccion"]), 0, 0, 'C');
}
$pdf->SetFont('Arial', '', 12);








ob_end_clean(); // Limpia el búfer de salida
$pdf->Output();
exit;