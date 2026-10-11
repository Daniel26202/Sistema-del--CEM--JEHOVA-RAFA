<?php
// config.php
// define es para hacer una constante global
define('host_cos', $_ENV['DB_HOST']);
define('user_cos', $_ENV['DB_USER']);
define('pass_cos', $_ENV['DB_PASS']);
define('dbsegname_cos', $_ENV['DB_NAME_SEGURITY']);
define('dbname_cos', $_ENV['DB_NAME']);

define('passwordResp_cos', $_ENV['PASSWORD_RESP']);

// Tasa de impuesto aplicada a los insumos que tienen IVA activo (insumo.iva = 1).
// Fuente unica de verdad: la usan el calculo del front (meta tag), el del modelo
// y el comprobante, para que nunca se desincronicen.
define('TASA_IMPUESTO', isset($_ENV['IVA_TASA']) && is_numeric($_ENV['IVA_TASA'])
	? (float)$_ENV['IVA_TASA']
	: 0.16);