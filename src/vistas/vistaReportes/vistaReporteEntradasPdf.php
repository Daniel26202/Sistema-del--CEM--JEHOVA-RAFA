<?php

$entradas = $this->modelo->entradasInsumosPdf($_POST['id_insumo'],$_POST["desdeFechaEntradas"], $_POST["fechaHastaEntradas"]);

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('./src/assets/Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
        $this->SetFont('Arial', 'B', 20);
        $this->Image('./src/assets/Image/123.png', 10, -13, 80);
        $this->SetTextColor(14, 169, 181);
        $this->SetXY(100, 4);
        $this->SetFillColor(248, 252, 255);
        $this->Cell(90, 35, 'LISTADO ENTRADAS DE INSUMOS', 0, 1, 'C');
    }
}




// Creación del objeto de la clase heredada

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(5);
$pdf->SetTextColor(14, 169, 181);

foreach($entradas as $entrada){
// AQUI PONES EL FOREACH
$pdf->Cell(10);
$pdf->Cell(40, 20, utf8_decode('INSUMO: '.$entrada["nombre"]), 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(40, 20, utf8_decode('PROVEEDOR: '.$entrada["nombre_proveedor"]), 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(40, 20, utf8_decode('RIF: '.$entrada["rif"]), 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(30, 20, utf8_decode('FECHA DE INGRESO: '.$entrada["fechaDeIngreso"]), 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(40, 20, utf8_decode('FECHA DE VENCIMIENTO: '.$entrada["fechaDeVencimiento"]), 0, 0, 'L');
$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(40, 20, utf8_decode('NUMERO DE LOTE: '.$entrada["numero_de_lote"]), 0, 0, 'L');
$pdf->Ln(10);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(10, 20, utf8_decode('CANTIDAD: '.$entrada["cantidad_entrada"]), 0, 0, 'L');
$pdf->Ln(10);

$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(40, 20, utf8_decode('PRECIO: '.$entrada["precio_entrada"]." BS"), 0, 0, 'L');
$pdf->Ln(10);



$pdf->Cell(10);
$pdf->Cell(80, 20, utf8_decode('-------------------------------------------------------------------------------------------------'), 0, 0, 'L');
$pdf->Ln(12);

}
// AQUI TERMINAS EL FORECAH


ob_end_clean(); // Limpia el búfer de salida
$pdf->Output();
exit;