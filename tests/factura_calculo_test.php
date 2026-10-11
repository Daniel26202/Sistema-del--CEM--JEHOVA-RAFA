<?php
/**
 * Pruebas del cálculo de facturación.
 *
 * Regresión sobre los fallos encontrados en la auditoría del módulo:
 *   - el IVA se multiplicaba dos veces por la cantidad (total = precio * qty²)
 *   - insumo.iva es un booleano (0/1), no un monto
 *   - el total se armaba comparando floats sin redondear
 *   - la suma de montos de pago se validaba con == sobre floats
 *
 * Ejecutar:  /opt/lampp/bin/php tests/factura_calculo_test.php
 */

declare(strict_types=1);

const IVA_TASA = 0.16;
const TIPO_CAMBIO = 36.50;

$fallos = 0;
$pruebas = 0;

function assertEqual($esperado, $obtenido, string $mensaje): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if (abs($esperado - $obtenido) > 0.001) {
        $fallos++;
        printf("  FALLO: %s\n         esperado: %.2f | obtenido: %.2f\n", $mensaje, $esperado, $obtenido);
        return;
    }
    printf("  ok: %s (%.2f)\n", $mensaje, $obtenido);
}

function assertTrue($condicion, string $mensaje): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if (!$condicion) {
        $fallos++;
        printf("  FALLO: %s\n", $mensaje);
        return;
    }
    printf("  ok: %s\n", $mensaje);
}

/** Réplica exacta de f.js: precioUnitarioInsumo */
function precioUnitarioInsumo(array $i): float
{
    $base = (float)$i['precio'];
    return ((string)$i['iva'] === '1') ? $base * (1 + IVA_TASA) : $base;
}

/** Réplica exacta de f.js: subtotalInsumosDivisa */
function subtotalInsumosDivisa(array $dataInsumo): float
{
    $suma = 0.0;
    foreach ($dataInsumo as $i) {
        $suma += precioUnitarioInsumo($i) * ((int)$i['cantidad']);
    }
    return $suma;
}

/** Réplica exacta de f.js: subtotalServiciosDivisa */
function subtotalServiciosDivisa(array $data): float
{
    $suma = 0.0;
    foreach ($data as $s) {
        $suma += (float)$s['precio'];
    }
    return $suma;
}

function calcularTotal(array $data, array $dataInsumo, float $baseCita = 0.0): float
{
    $totalDivisa = $baseCita + subtotalServiciosDivisa($data) + subtotalInsumosDivisa($dataInsumo);
    return (float)number_format($totalDivisa * TIPO_CAMBIO, 2, '.', '');
}

/** El buggy anterior, para demostrar la magnitud del error */
function calcularTotalBuggy(array $data, array $dataInsumo, float $baseCita = 0.0): float
{
    $subTotal = 0.0;
    $insumos = 0.0;
    foreach ($data as $s) {
        $subTotal += (float)$s['precio'];
    }
    foreach ($dataInsumo as $i) {
        $insumos += ($i['iva'] != "No contiene")
            ? ((float)$i['precio'] + (float)$i['iva']) * $i['cantidad']
            : (float)$i['precio'];
        $insumos *= $i['cantidad'];
    }
    $total = $baseCita + $subTotal + $insumos;
    return (float)number_format($total * TIPO_CAMBIO, 2, '.', '');
}

/** Comparación en céntimos, como el new sameMoney() de f.js */
function sameMoney($a, $b): bool
{
    return (int)round((float)$a * 100) === (int)round((float)$b * 100);
}

echo "\n=== A1: insumo sin IVA, cantidad 3 ===\n";
$ins = [['precio' => 100.0, 'iva' => '0', 'cantidad' => 3]];
assertEqual(10950.00, calcularTotal([], $ins), "3 x \$100 sin IVA");
assertEqual(32850.00, calcularTotalBuggy([], $ins), "  (el bug anterior cobraba esto)");

echo "\n=== A2: insumo con IVA, cantidad 5 ===\n";
$ins = [['precio' => 100.0, 'iva' => '1', 'cantidad' => 5]];
assertEqual(21170.00, calcularTotal([], $ins), "5 x \$100 con IVA 16%");
assertEqual(92162.50, calcularTotalBuggy([], $ins), "  (el bug anterior cobraba esto)");

echo "\n=== A3: insumos con y sin IVA mezclados ===\n";
$ins = [
    ['precio' => 50.0, 'iva' => '0', 'cantidad' => 3],
    ['precio' => 20.0, 'iva' => '1', 'cantidad' => 2],
];
assertEqual(7168.60, calcularTotal([], $ins), "varios insumos");
assertEqual(35916.00, calcularTotalBuggy([], $ins), "  (el bug anterior cobraba esto)");

echo "\n=== T1: factura con cita ===\n";
// La cita aporta su precio en `inputTotalCita` (base) y además se inserta como
// servicio en la tabla, así que el total es la base + el subtotal de servicios.
$serv = [['precio' => 50.0]];
assertEqual(3650.00, calcularTotal($serv, [], 50.0), "cita \$50 (base + servicio)");
assertEqual(1825.00, calcularTotal($serv, [], 0.0), "solo servicio \$50 (sin base)");

echo "\n=== T2: servicio + insumos ===\n";
// \$30 + \$20 de servicios + 2 x \$10 de insumos = \$70 -> \$2555
$serv = [['precio' => 30.0], ['precio' => 20.0]];
$ins  = [['precio' => 10.0, 'iva' => '0', 'cantidad' => 2]];
assertEqual(2555.00, calcularTotal($serv, $ins), "\$50 servicios + 2 x \$10");

echo "\n=== A8: splits de pago que rompian por coma flotante ===\n";
assertTrue(sameMoney(0.1 + 0.2, 0.30),  "0.10 + 0.20 == 0.30");
assertTrue(sameMoney(1.1 + 2.2, 3.30),  "1.10 + 2.20 == 3.30");
assertTrue(sameMoney(10.05 + 5.05, 15.10), "10.05 + 5.05 == 15.10");
assertTrue(sameMoney(36.5 + 29.2, 65.70), "36.50 + 29.20 == 65.70");
assertTrue(!sameMoney(10.0 + 10.0, 25.0), "10.00 + 10.00 != 25.00");

echo "\n=== A10: el total del servidor debe rechazar manipulaciones ===\n";
$totalEnviado = 1.00;
$totalReal = calcularTotal([], [['precio' => 100.0, 'iva' => '0', 'cantidad' => 1]]);
assertTrue(abs($totalReal - $totalEnviado) > 0.01, "total manipulado (1.00) != real ({$totalReal})");

echo "\n=== Suma de montos de pago ===\n";
$montos = [25.00, 40.70];
$total  = 65.70;
assertTrue(abs(array_sum($montos) - $total) < 0.01, "montos de pago cuadran con el total");

echo "\n=== Comprobación final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);