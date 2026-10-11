<?php
/**
 * Pruebas de las validaciones del modelo de facturación.
 *
 * Verifica que los setters rechazan lo que antes pasaba de largo:
 * precios negativos, cantidades absurdas, identificadores manipulados y
 * montos de pago no numéricos.
 *
 * No requiere base de datos: solo exercise la validación de entrada.
 *
 * Ejecutar:  /opt/lampp/bin/php tests/factura_validacion_test.php
 */

declare(strict_types=1);

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
// config.php lee estas variables al incluirse; aquí no hay conexión a la BD.
$_ENV += [
    'DB_HOST' => 'localhost', 'DB_USER' => 'root', 'DB_PASS' => '',
    'DB_NAME' => 'bd', 'DB_NAME_SEGURITY' => 'segurity', 'PASSWORD_RESP' => 'x',
];
require_once $raiz . 'src/modelos/Db.php';
require_once $raiz . 'src/modelos/ModelBase.php';
require_once $raiz . 'src/modelos/ModeloFactura.php';

use App\modelos\ModeloFactura;

$fallos = 0;
$pruebas = 0;

/** Crea el modelo sin tocar la BD: se inyecta un PDO nulo tras el constructor. */
function modelo(): ModeloFactura
{
    $reflexion = new ReflectionClass(ModeloFactura::class);
    $modelo = $reflexion->newInstanceWithoutConstructor();
    return $modelo;
}

function esperaError(callable $fn, string $mensaje): void
{
    global $fallos, $pruebas;
    $pruebas++;
    try {
        $fn();
        $fallos++;
        printf("  FALLO: %s -> se acepto un valor invalido\n", $mensaje);
    } catch (\InvalidArgumentException $e) {
        printf("  ok: %s rechazado (%s)\n", $mensaje, $e->getMessage());
    } catch (\DomainException $e) {
        printf("  ok: %s rechazado (%s)\n", $mensaje, $e->getMessage());
    } catch (\Throwable $e) {
        $fallos++;
        printf("  FALLO: %s -> excepcion inesperada %s: %s\n", $mensaje, get_class($e), $e->getMessage());
    }
}

function esperaAceptado(callable $fn, string $mensaje): void
{
    global $fallos, $pruebas;
    $pruebas++;
    try {
        $fn();
        printf("  ok: %s aceptado\n", $mensaje);
    } catch (\Throwable $e) {
        $fallos++;
        printf("  FALLO: %s -> rechazado valido: %s\n", $mensaje, $e->getMessage());
    }
}

echo "\n=== Precios de servicio ===\n";
$precioOk = function () { modelo()->setPrecioServicio(['50.00', '20.5']); };
$precioNeg = function () { modelo()->setPrecioServicio(['-10']); };
$precioCero = function () { modelo()->setPrecioServicio(['0']); };
$precioTexto = function () { modelo()->setPrecioServicio(['abc']); };
$precioNoArray = function () { modelo()->setPrecioServicio('50'); };

esperaAceptado($precioOk, 'precios validos');
esperaError($precioNeg, 'precio negativo');
esperaError($precioCero, 'precio en cero');
esperaError($precioTexto, 'precio no numerico');
esperaError($precioNoArray, 'precio que no es arreglo');

echo "\n=== Precios de insumo ===\n";
esperaAceptado(function () { modelo()->setPrecioInsumo(['116.00']); }, 'precio de insumo valido');
esperaError(function () { modelo()->setPrecioInsumo(['-5']); }, 'precio de insumo negativo');
esperaError(function () { modelo()->setPrecioInsumo(['NaN']); }, 'precio de insumo NaN');

echo "\n=== Cantidades ===\n";
esperaAceptado(function () { modelo()->setCatidad(['3', '10']); }, 'cantidades validas');
esperaError(function () { modelo()->setCatidad(['0']); }, 'cantidad en cero');
esperaError(function () { modelo()->setCatidad(['-3']); }, 'cantidad negativa');
esperaError(function () { modelo()->setCatidad(['999999']); }, 'cantidad fuera de rango');
esperaError(function () { modelo()->setCatidad(['dos']); }, 'cantidad no numerica');

echo "\n=== Montos de pago ===\n";
esperaAceptado(function () { modelo()->setMontosPago(['25.00', '40.70']); }, 'montos validos');
esperaError(function () { modelo()->setMontosPago(['-5']); }, 'monto negativo');
esperaError(function () { modelo()->setMontosPago(['0']); }, 'monto en cero');
esperaError(function () { modelo()->setMontosPago(['gratis']); }, 'monto no numerico');

echo "\n=== Identificadores manipulados ===\n";
esperaError(function () { modelo()->setInsumos(['abc', '1 OR 1=1']); }, 'insumos no numericos');
esperaError(function () { modelo()->setServicios(['1; DROP TABLE factura']); }, 'servicios no numericos');
esperaError(function () { modelo()->setDoctores(['xyz']); }, 'doctor no numerico');
esperaAceptado(function () { modelo()->setDoctores(['12', null]); }, 'doctores validos');

echo "\n=== Total y referencia ===\n";
esperaAceptado(function () { modelo()->setTotal('3650.50'); }, 'total valido');
esperaError(function () { modelo()->setTotal('0'); }, 'total en cero');
esperaError(function () { modelo()->setTotal('1'); }, 'total en uno');
esperaError(function () { modelo()->setTotal('-100'); }, 'total negativo');
esperaError(function () { modelo()->setTotal('abc'); }, 'total no numerico');

esperaAceptado(function () { modelo()->setReferencia('1234'); }, 'referencia de 4 digitos');
esperaError(function () { modelo()->setReferencia('123'); }, 'referencia de 3 digitos');
esperaError(function () { modelo()->setReferencia('abcd'); }, 'referencia no numerica');

echo "\n=== Indicador de IVA ===\n";
esperaAceptado(function () { modelo()->setAplicaIVA(['1', '0', '']); }, 'indicadores de IVA');
esperaError(function () { modelo()->setAplicaIVA('1'); }, 'IVA que no es arreglo');

echo "\n=== Cedula ===\n";
esperaAceptado(function () { modelo()->setCedula('12345678'); }, 'cedula de 8 digitos');
esperaError(function () { modelo()->setCedula('123456'); }, 'cedula de 6 digitos');
esperaError(function () { modelo()->setCedula('abcdefgh'); }, 'cedula no numerica');

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);