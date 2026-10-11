#!/bin/bash
# Ejecuta toda la suite de pruebas del módulo de facturación.
# Uso:  ./tests/run.sh

set -e
cd "$(dirname "$0")/.."

PHP="${PHP_BIN:-/opt/lampp/bin/php}"

echo "═══════════════════════════════════════════════════════════"
echo " Suite de pruebas · Módulo de Facturación"
echo "═══════════════════════════════════════════════════════════"

fallos=0

echo ""
echo "▸ Sintaxis PHP"
for f in src/modelos/ModeloFactura.php \
         src/modelos/ModeloFacturaHospitalizacion.php \
         src/controllers/ControllerFactura.php \
         src/vistas/vistaFactura/comprobante.php \
         src/vistas/vistaFactura/factura.php \
         src/vistas/vistaFactura/facturaCita.php \
         src/vistas/vistaFactura/facturaHospitalizacion.php \
         src/vistas/vistaFactura/modalAgregarFactura.php \
         src/config/config.php \
         tests/conversion_factura_test.php \
         src/config/tasaCambio.php \
         src/config/equivalencias.php; do
    if $PHP -l "$f" > /dev/null 2>&1; then
        echo "  ok: $f"
    else
        echo "  FALLO: $f"
        $PHP -l "$f"
        fallos=$((fallos + 1))
    fi
done

echo ""
echo "▸ Cálculo de facturación"
$PHP tests/factura_calculo_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Validaciones del modelo"
$PHP tests/factura_validacion_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Flujo completo (típico, atípico e inventario)"
$PHP tests/flujo_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Identificadores (hash/unhash)"
$PHP tests/ids_test.php || fallos=$((fallos + 1))
$PHP tests/endpoint_cita_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Parámetros SQL (HY093)"
$PHP tests/parametros_test.php || fallos=$((fallos + 1))
$PHP tests/parametros_db_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Conversión de moneda en la factura"
$PHP tests/conversion_factura_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Tasa de cambio del día"
$PHP tests/tasa_cambio_test.php || fallos=$((fallos + 1))

echo ""
echo "▸ Integración frontend ↔ backend"
$PHP tests/factura_integracion_test.php || fallos=$((fallos + 1))

echo ""
echo "═══════════════════════════════════════════════════════════"
if [ $fallos -eq 0 ]; then
    echo " Todas las suites pasaron."
    exit 0
else
    echo " $fallos suite(s) con fallos."
    exit 1
fi