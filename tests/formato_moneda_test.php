<?php
/**
 * Formato de moneda del proyecto (guía Promp_metodo_pago.md).
 *
 * Réplica de src/assets/js/generic/moneda.js:
 *   USD -> $ 1,250.50     (coma de miles, punto decimal)
 *   BS  -> Bs. 45.643,25  (punto de miles, coma decimal)
 *
 * Y de la lectura de importes escritos por el cajero, que convive con las dos
 * convenciones ("1.234,56" y "1,234.56").
 *
 * Ejecutar:  /opt/lampp/bin/php tests/formato_moneda_test.php
 */

declare(strict_types=1);

$fallos = 0;
$pruebas = 0;

function comprobar(bool $condicion, string $mensaje, string $detalle = ''): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if ($condicion) {
        printf("  ok: %s%s\n", $mensaje, $detalle !== '' ? " ($detalle)" : '');
        return;
    }
    $fallos++;
    printf("  FALLO: %s%s\n", $mensaje, $detalle !== '' ? " ($detalle)" : '');
}

/** Réplica de agrupar() de moneda.js. */
function agrupar(string $entero, string $separador): string
{
    return preg_replace('/\B(?=(\d{3})+(?!\d))/', $separador, $entero);
}

/** Réplica de descomponer() de moneda.js. */
function descomponer(float $valor, int $decimales): array
{
    $fijo = number_format(abs($valor), $decimales, '.', '');
    [$entero, $decimal] = explode('.', $fijo);
    return ['negativo' => $valor < 0, 'entero' => $entero, 'decimal' => $decimal];
}

function formatUSD(float $valor, int $decimales = 2): string
{
    $p = descomponer($valor, $decimales);
    return ($p['negativo'] ? '-' : '') . '$ ' . agrupar($p['entero'], ',') . '.' . $p['decimal'];
}

function formatBS(float $valor, int $decimales = 2): string
{
    $p = descomponer($valor, $decimales);
    return ($p['negativo'] ? '-' : '') . 'Bs. ' . agrupar($p['entero'], '.') . ',' . $p['decimal'];
}

/** Réplica de parseMonto() de moneda.js. */
function parseMonto(?string $texto): ?float
{
    $limpio = preg_replace('/\s+/', '', (string) $texto);
    $limpio = str_replace('$', '', $limpio);
    $limpio = preg_replace('/bs\.?/i', '', $limpio);

    if ($limpio === '') {
        return null;
    }

    $negativo = str_starts_with($limpio, '-');
    if ($negativo) {
        $limpio = substr($limpio, 1);
    }
    if (!preg_match('/^[\d.,]+$/', $limpio)) {
        return null;
    }

    $ultimaComa = strrpos($limpio, ',');
    $ultimoPunto = strrpos($limpio, '.');

    if ($ultimaComa !== false && $ultimoPunto !== false) {
        $normalizado = $ultimaComa > $ultimoPunto
            ? str_replace(',', '.', str_replace('.', '', $limpio))
            : str_replace(',', '', $limpio);
    } elseif ($ultimaComa !== false) {
        $decimales = strlen($limpio) - $ultimaComa - 1;
        $normalizado = $decimales === 3
            ? str_replace(',', '', $limpio)
            : preg_replace('/,/', '.', $limpio);
    } elseif ($ultimoPunto !== false) {
        $puntos = substr_count($limpio, '.');
        $decimales = strlen($limpio) - $ultimoPunto - 1;
        $normalizado = ($puntos > 1 || $decimales === 3)
            ? str_replace('.', '', $limpio)
            : $limpio;
    } else {
        $normalizado = $limpio;
    }

    if (!is_numeric($normalizado)) {
        return null;
    }

    $valor = (float) $normalizado;
    return $negativo ? -$valor : $valor;
}

echo "\n=== Formato USD (coma de miles, punto decimal) ===\n";
comprobar(formatUSD(1250.5) === '$ 1,250.50', 'USD de 4 cifras', formatUSD(1250.5));
comprobar(formatUSD(50) === '$ 50.00', 'USD con dos decimales siempre', formatUSD(50));
comprobar(formatUSD(0) === '$ 0.00', 'USD en cero', formatUSD(0));
comprobar(formatUSD(1234567.891) === '$ 1,234,567.89', 'USD con dos grupos de miles', formatUSD(1234567.891));
comprobar(formatUSD(-5) === '-$ 5.00', 'USD negativo', formatUSD(-5));

echo "\n=== Formato BS (punto de miles, coma decimal) ===\n";
comprobar(formatBS(45643.25) === 'Bs. 45.643,25', 'BS de 5 cifras', formatBS(45643.25));
comprobar(formatBS(886.23) === 'Bs. 886,23', 'tasa del día', formatBS(886.23));
comprobar(formatBS(1949706) === 'Bs. 1.949.706,00', 'total de factura', formatBS(1949706));
comprobar(formatBS(0) === 'Bs. 0,00', 'BS en cero', formatBS(0));
comprobar(formatBS(-5.5) === '-Bs. 5,50', 'BS negativo', formatBS(-5.5));

echo "\n=== Lectura de importes ===\n";
comprobar(parseMonto('1.234,56') === 1234.56, 'formato venezolano', (string) parseMonto('1.234,56'));
comprobar(parseMonto('1234.56') === 1234.56, 'formato plano', (string) parseMonto('1234.56'));
comprobar(parseMonto('Bs. 45.643,25') === 45643.25, 'con símbolo Bs.', (string) parseMonto('Bs. 45.643,25'));
comprobar(parseMonto('$ 1,250.50') === 1250.50, 'USD tal como se muestra', (string) parseMonto('$ 1,250.50'));
comprobar(parseMonto('1.234.567') === 1234567.0, 'solo puntos de miles', (string) parseMonto('1.234.567'));
comprobar(parseMonto('1,250') === 1250.0, 'coma con 3 dígitos = miles', (string) parseMonto('1,250'));
comprobar(parseMonto('1,25') === 1.25, 'coma con 2 dígitos = decimal', (string) parseMonto('1,25'));
comprobar(parseMonto('12.5') === 12.5, 'punto con 1 dígito = decimal', (string) parseMonto('12.5'));
comprobar(parseMonto('') === null, 'texto vacío no es importe');
comprobar(parseMonto('abc') === null, 'texto no numérico no es importe');
comprobar(parseMonto('10,50$') === 10.5, 'símbolo al final', (string) parseMonto('10,50$'));

echo "\n=== Ida y vuelta formato -> lectura ===\n";
foreach ([0.0, 1.25, 50.0, 886.23, 45000.75, 1949706.0] as $monto) {
    $bs = formatBS($monto);
    comprobar(
        abs((parseMonto($bs) ?? -1) - $monto) < 0.001,
        'BS ida y vuelta ' . $bs,
        (string) parseMonto($bs)
    );
}
foreach ([0.0, 1.25, 50.0, 1250.5, 2200.0] as $monto) {
    $usd = formatUSD($monto);
    comprobar(
        abs((parseMonto($usd) ?? -1) - $monto) < 0.001,
        'USD ida y vuelta ' . $usd,
        (string) parseMonto($usd)
    );
}

echo "\n=== Bloque de doble moneda (USD resaltado + BS atenuado) ===\n";
// 50 USD con una tasa de 886.23 = 44311.50 BS
$bloque = '<span class="fw-bolder">' . formatUSD(50) . '</span> <span class="text-muted small">(' . formatBS(44311.5) . ')</span>';
comprobar(
    str_contains($bloque, '$ 50.00') && str_contains($bloque, 'Bs. 44.311,50'),
    'ambas monedas en el mismo bloque',
    strip_tags($bloque)
);

echo "\n" . ($fallos === 0 ? "TODO OK\n" : "$fallos fallo(s)\n");
exit($fallos === 0 ? 0 : 1);
