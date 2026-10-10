<?php
/**
 * Renderiza factura.php fuera del navegador para inspeccionar el HTML real:
 * detects formas anidadas, ids duplicados y elementos que el parser descartaría.
 *
 * Uso: /opt/lampp/bin/php tests/render_factura.php > /tmp/factura.html
 */

$_SESSION = [
    'usuario' => 'admin',
    'id_usuario' => 1,
    'id_rol' => 1,
    'csrf_token' => 'test',
];

$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';
$_ENV['DB_NAME'] = 'bd';
$_ENV['DB_NAME_SEGURITY'] = 'segurity';
$_ENV['PASSWORD_RESP'] = 'x';

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config/helpers.php';

// Variables que el controlador inyecta antes de incluir la vista.
$modeloInsumos = new App\modelos\ModeloInsumo();
$sanetizar = new App\modelos\ModeloSanetizarJSON();
$sanetizar->setHashKeys(['id_insumo']);
$insumos = $sanetizar->sanitizeRecursive($modeloInsumos->insumos());
$vistaActiva = 'factura';
$ayuda = 'btnayudaFactura';
$parametro = '';

require __DIR__ . '/../src/vistas/vistaFactura/factura.php';