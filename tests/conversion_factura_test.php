<?php
/**
 * Pruebas de coherencia de monedas entre el navegador y el servidor.
 *
 * El navegador manda los precios unitarios en DIVISA (serviciomedico.precio e
 * insumo.precio están en dólares) y el TOTAL en bolívares. Si el servidor no
 * aplica la conversión, subtotal (divisa) nunca cuadra con el total (Bs) y
 * TODA factura se rechaza.
 *
 * Estas pruebas reproducen el cálculo de los dos lados y comprueban que cuadran.
 *
 * Ejecutar: /opt/lampp/bin/php tests/conversion_factura_test.php
 */

declare(strict_types=1);

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
require_once $raiz . 'src/config/tasaCambio.php';
require_once $raiz . 'src/config/config.php';

$tasa = 36.50; // tasa fija para que el test no dependa de la API

$fallos = 0;
$pruebas = 0;

function check(bool $ok, string $mensaje, string $detalle = ''): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if ($ok) {
        printf("  ok: %s\n", $mensaje);
    } else {
        $fallos++;
        printf("  FALLO: %s%s\n", $mensaje, $detalle ? " — $detalle" : '');
    }
}

/** Lo que hace el servidor al guardar cada línea del detalle. */
function subtotalServidor(float $precioDivisa, float $tasa): float
{
    return round(round($precioDivisa * $tasa, 2), 2);
}

function subtotalInsumoServidor(float $precioDivisa, int $cantidad, float $tasa): float
{
    $unitario = round($precioDivisa * $tasa, 2);
    return round($unitario * $cantidad, 2);
}

/** Lo que hace calcularTotal() del navegador. */
function totalNavegador(array $serviciosDivisa, array $insumos, float $baseDivisa, float $tasa): float
{
    $suma = $baseDivisa;
    foreach ($serviciosDivisa as $p) {
        $suma += (float)$p;
    }
    foreach ($insumos as $i) {
        $suma += (float)$i['precio'] * (int)$i['cantidad'];
    }
    return (float)number_format($suma * $tasa, 2, '.', '');
}

echo "\n=== Servicio: divisa -> bolivares ===\n";
check(abs(subtotalServidor(50.00, $tasa) - 1825.00) < 0.001, "\$50 -> 1825.00 BS");
check(abs(subtotalServidor(100.00, $tasa) - 3650.00) < 0.001, "\$100 -> 3650.00 BS");
check(abs(subtotalServidor(0.01, $tasa) - 0.37) < 0.001, "\$0.01 -> 0.37 BS (redondeo a 2 decimales)");

echo "\n=== Insumo con cantidad ===\n";
check(abs(subtotalInsumoServidor(100.00, 3, $tasa) - 10950.00) < 0.001, "\$100 x 3 -> 10950.00 BS");
check(abs(subtotalInsumoServidor(116.00, 5, $tasa) - 21170.00) < 0.001, "\$116 x 5 (con IVA) -> 21170.00 BS");

echo "\n=== El total del servidor cuadra con el del navegador ===\n";
// Caso típico: un servicio de \$50 y 3 insumos de \$100.
$servicios = [50.00];
$insumos = [['precio' => 100.00, 'cantidad' => 3]];

$totalNav = totalNavegador($servicios, $insumos, 0.0, $tasa);
$totalSrv = subtotalServidor(50.00, $tasa) + subtotalInsumoServidor(100.00, 3, $tasa);

printf("    navegador: %.2f BS\n    servidor:  %.2f BS\n", $totalNav, $totalSrv);
check(abs($totalNav - $totalSrv) < 0.05, "los dos totales coinciden");

echo "\n=== Con base de cita (inputTotalCita en divisa) ===\n";
$totalNav = totalNavegador($servicios, $insumos, 40.00, $tasa);
$totalSrv = subtotalServidor(40.00, $tasa)
    + subtotalServidor(50.00, $tasa)
    + subtotalInsumoServidor(100.00, 3, $tasa);
printf("    navegador: %.2f BS\n    servidor:  %.2f BS\n", $totalNav, $totalSrv);
check(abs($totalNav - $totalSrv) < 0.05, "con base de cita tambien cuadra");

echo "\n=== Hospitalizacion (total_MoEx esta en divisa) ===\n";
$moEx = 20.00; // total_MoEx de la hospitalizacion
$totalNav = totalNavegador([], [], $moEx, $tasa);
$totalSrv = subtotalServidor($moEx, $tasa);
printf("    navegador: %.2f BS\n    servidor:  %.2f BS\n", $totalNav, $totalSrv);
check(abs($totalNav - $totalSrv) < 0.05, "el total_MoEx se convierte igual");

echo "\n=== La tasa se registra en la factura ===\n";
$modelo = file_get_contents($raiz . 'src/modelos/ModeloFactura.php');
check(strpos($modelo, "'tipo_cambio' => \$tasa,") !== false, 'la factura guarda la tasa aplicada');
check(strpos($modelo, 'precio_divisa') !== false, 'se guarda el precio en divisa');
check(
    strpos($modelo, '$precioUnitario = round($precioUnitarioDivisa * $tasa, 2);') !== false,
    'el insumo se convierte a bolivares'
);
check(
    strpos($modelo, '$precio = round($precioDivisa * $tasa, 2);') !== false,
    'el servicio se convierte a bolivares'
);
check(
    preg_match_all("/precio_divisa/", $modelo) >= 3,
    'los tres tipos de linea (cita, servicio, insumo) llevan precio_divisa'
);

$ctrl = file_get_contents($raiz . 'src/controllers/ControllerFactura.php');
check(strpos($ctrl, 'setTipoCambio') !== false, 'el controlador recibe la tasa');

$js = file_get_contents($raiz . 'src/assets/js/f.js');
check(strpos($js, 'name="tipo_cambio"') !== false || strpos(file_get_contents($raiz . 'src/vistas/vistaFactura/modalAgregarFactura.php'), 'name="tipo_cambio"') !== false,
    'el formulario envia la tasa usada');

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);