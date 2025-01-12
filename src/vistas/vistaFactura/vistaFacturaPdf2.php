<?php


$datosFactura = $this->modelo->consultarFactura($_GET["id_factura"]);
$datosPago = $this->modelo->consultarPagoFactura($_GET["id_factura"]);
$datosServiciosExtras = $this->modelo->consultarServiciosExtras($_GET["id_factura"]);
$datosInsumos = $this->modelo->consultarFacturaInsumo($_GET["id_factura"]);
// Creación del objeto de la clase heredada
$pdf = new FPDF();



$pdf->AddPage();

$pdf->Image('./src/assets/Image/depositphotos_87603960-stock-illustration-soft-bending-line-blue-sky-transformed.jpeg', 0, 0, 350);
$pdf->SetFont('Arial', 'B', 35);
$pdf->Image('./src/assets/Image/123.png', 10, -13, 80);
$pdf->SetTextColor(14, 169, 181);
$pdf->SetXY(110, 15);
$pdf->SetFillColor(248, 252, 255);
$pdf->Cell(100, 35, 'FACTURA', 0, 1, 'C');
$pdf->SetFont('Arial', '', 15);
$pdf->SetXY(108, 30);
$pdf->Cell(130, -20, $datosFactura[0]['fecha'], 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 15);

$pdf->Ln(40);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(62, 10, utf8_decode('CODIGO:  ').$datosFactura[0]['id_factura'], 0, 0, 'C') ;


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
$pdf->Cell(85, 10,strtoupper( 'NOMBRE:  '.$datosFactura[0]['nombre_p'].' '.$datosFactura[0]['apellido_p']), 0, 0, 'L',0);
$pdf->Cell(85, 10, 'C.I:  '.$datosFactura[0]['nacionalidad'].'-'.$datosFactura[0]['cedula_p'], 0, 0, 'L',0);


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

$pdf->Cell(55, 10, strtoupper('SERVICIO: '.$datosFactura[0]['categoria_servicio']), 0, 0, 'L',0);
$pdf->Cell(80, 10, strtoupper('DOCTOR: '.$datosFactura[0]['nombre_d'].' '.$datosFactura[0]['apellido_d']), 0, 0, 'L',0);
$pdf->Cell(70, 10, strtoupper('PRECIO: '.$datosFactura[0]['precio_servicio'].' Bs'), 0, 0, 'L',0);

foreach($datosServiciosExtras as $d){
$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFillColor(228, 235, 240);
$pdf->SetTextColor(14, 169, 181);

$pdf->Cell(55, 10, strtoupper('SERVICIO: '.$d['categoria_servicio']), 0, 0, 'L',0);
$pdf->Cell(80, 10, strtoupper('DOCTOR: '.$d['nombre_d'].' '.$d['apellido_d']), 0, 0, 'L',0);
$pdf->Cell(70, 10, strtoupper('PRECIO: '.$d['precio'].' Bs'), 0, 0, 'L',0);


}
foreach($datosInsumos as $insumo){
$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(14, 169, 181);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(170, 10, utf8_decode('INSUMOS'), 0, 0, 'C',1);
$pdf->Ln(14);


$pdf->Cell(10);
$pdf->SetFillColor(228, 235, 240);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(73, 10, strtoupper('NOMBRE: '.$insumo['nombre']), 0, 0, 'L',0);
$pdf->Cell(55, 10, strtoupper('CANTIDAD: '.$insumo['cantidad']), 0, 0, 'L',0);
$pdf->Cell(85, 10, strtoupper('PRECIO: '.$insumo['precio'].' Bs'), 0, 0, 'L',0);

}


$pdf->Ln(90);



$pdf->Cell(10);
$pdf->SetTextColor(14, 169, 181);
$pdf->Cell(110, 10, 'METODOS DE PAGO', 0, 0, 'L',0);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(14, 169, 181);
$pdf->Cell(50, 10, 'TOTAL:  '.$datosFactura[0]['total'] . " BS", 0, 1, 'C',1);
$pdf->SetTextColor(14, 169, 181);

foreach($datosPago as $Value){
	$pdf->Cell(10);
	$pdf->Cell(110, 10, strtoupper($Value["nombre"]. " ". $Value["monto"] . " Bs "), 0, 1, 'L',0);
	
}

$pdf->SetFont('Arial', 'B', 12);

$pdf->Output();
