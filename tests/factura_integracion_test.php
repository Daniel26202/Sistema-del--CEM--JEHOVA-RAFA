<?php
/**
 * Pruebas de integración frontend ↔ backend del módulo de facturación.
 *
 * Verifica los contratos que se rompieron en la auditoría:
 *   - cada ruta que f.js llama existe en el controlador
 *   - cada id que f.js busca existe en las vistas
 *   - cada campo que f.js envía viaja dentro del <form> de confirmación
 *   - las vistas no referencian scripts inexistentes
 *
 * Ejecutar:  /opt/lampp/bin/php tests/factura_integracion_test.php
 */

declare(strict_types=1);

$raiz = dirname(__DIR__) . '/';
$fallos = 0;
$pruebas = 0;

function comprobar(bool $condicion, string $mensaje): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if ($condicion) {
        printf("  ok: %s\n", $mensaje);
    } else {
        $fallos++;
        printf("  FALLO: %s\n", $mensaje);
    }
}

$js = file_get_contents("$raiz/src/assets/js/f.js");
$ctrl = file_get_contents("$raiz/src/controllers/ControllerFactura.php");

// Las vistas que factura.php incluye al final.
$vistas = '';
foreach (glob("$raiz/src/vistas/vistaFactura/*.php") as $v) {
    $vistas .= file_get_contents($v);
}
$vistas .= file_get_contents("$raiz/src/vistas/vistaPacientes/modalAgregarPaciente.php");
$vistas .= file_get_contents("$raiz/src/vistas/vistaCliente/modalAgregarCliente.php");

echo "\n=== Rutas chamadas por f.js existen en el controlador ===\n";
preg_match_all('#"/Sistema-del--CEM--JEHOVA-RAFA/([A-Za-z]+)/([A-Za-z]+)#', $js, $m);
$vistos = [];
foreach ($m[1] as $i => $modulo) {
    if ($modulo !== 'Factura') {
        continue;
    }
    $accion = $m[2][$i];
    if (isset($vistos[$accion])) {
        continue;
    }
    $vistos[$accion] = true;
    comprobar(
        (bool)preg_match('/^function\s+' . preg_quote($accion, '/') . '\s*\(/mi', $ctrl),
        "Factura/$accion"
    );
}

echo "\n=== Rutas usadas por las vistas existen ===\n";
foreach (glob("$raiz/src/vistas/vistaFactura/*.php") as $vista) {
    preg_match_all('#/Factura/([A-Za-z]+)#', file_get_contents($vista), $mm);
    foreach (array_unique($mm[1]) as $accion) {
        comprobar(
            (bool)preg_match('/^function\s+' . preg_quote($accion, '/') . '\s*\(/mi', $ctrl),
            basename($vista) . " -> Factura/$accion"
        );
    }
}

echo "\n=== Elementos que f.js busca por id existen en las vistas ===\n";
preg_match_all('/byId\("([^"]+)"\)/', $js, $m);
$opcionales = [
    'total-modal-validacion', 'inputHospitalizacion', 'inputCliente',
    'inputTotalCita', 'totalFactura', 'btnSiguiente', 'vaciarTabla',
    'totalDeConfirmacion', 'inputTotalDeConfirmacion', 'tbodyDelModal',
    'tbodyInsumos', 'form-buscador-factura', 'modalAgregar',
    'exampleModalagregarPaciente',
];
foreach (array_unique($m[1]) as $id) {
    if (in_array($id, $opcionales, true)) {
        continue;
    }
    comprobar(strpos($vistas, 'id="' . $id . '"') !== false, "#$id");
}

echo "\n=== Inputs que f.js escribe existen ===\n";
foreach (['inputCliente', 'inputHospitalizacion', 'inputIdCita', 'inputPaciente',
          'referencia_confirmar', 'inputTotalDeConfirmacion'] as $id) {
    comprobar(strpos($vistas, 'id="' . $id . '"') !== false, "#$id");
}

echo "\n=== El form de confirmacion esta bien formado ===\n";
$modal = file_get_contents("$raiz/src/vistas/vistaFactura/modalAgregarFactura.php");
// Se ignoran los comentarios PHP, que mencionan "<form>" al explicar el arreglo.
$modalLimpio = preg_replace('/<\?php.*?\?>/s', '', $modal);
// Dos forms legitimos y separados: el buscador de cliente y el de confirmacion.
// Lo que no puede haber es uno dentro del otro.
comprobar(substr_count($modalLimpio, '<form') === 2, 'hay exactamente 2 <form> (antes 3 anidados)');
comprobar(substr_count($modalLimpio, '</form>') === 2, 'los 2 forms estan cerrados');
comprobar(
    strpos($modal, 'id="form-buscador-otro-cliente"') < strpos($modal, 'id="formConfirmarFactura"'),
    'el form buscador se cierra antes de abrir el de confirmacion'
);

$ini = strpos($modal, 'id="formConfirmarFactura"');
$fin = strpos($modal, '</form>', $ini);
comprobar($ini !== false && $fin !== false, 'el form de confirmacion existe y esta cerrado');

foreach (['tbodyDelModal', 'tbodyInsumos', 'divTypePagoCofirm', 'totalDeConfirmacion',
          'inputTotalDeConfirmacion', 'referencia_confirmar', 'inputPaciente',
          'inputIdCita', 'inputCliente', 'inputHospitalizacion'] as $id) {
    $pos = strpos($modal, 'id="' . $id . '"');
    comprobar(
        $pos !== false && $pos > $ini && $pos < $fin,
        "#$id esta dentro del form de confirmacion"
    );
}

foreach (['id_cita', 'id_cliente', 'id_hospitalizacion', 'total', 'referencia', 'id_paciente'] as $campo) {
    comprobar(strpos($modal, 'name="' . $campo . '"') !== false, "name=\"$campo\"");
}
$pos = strpos($modal, 'name="csrf_token"');
comprobar($pos !== false && $pos > $ini && $pos < $fin, 'name="csrf_token" dentro del form');

echo "\n=== Scripts referenciados por las vistas existen ===\n";
foreach (glob("$raiz/src/vistas/vistaFactura/*.php") as $vista) {
    $contenido = file_get_contents($vista);
    preg_match_all('#<script[^>]*src="[^"]*?\.\./\.\./([^"]+)"#', $contenido, $sm);
    foreach (array_unique($sm[1]) as $ruta) {
        comprobar(
            file_exists("$raiz/$ruta"),
            basename($vista) . " -> $ruta"
        );
    }
}

echo "\n=== El total ya no se confia en el cliente ===\n";
$modelo = file_get_contents("$raiz/src/modelos/ModeloFactura.php");
comprobar(strpos($modelo, 'calcularTotalDesdeDetalle') !== false, 'el modelo recalcula el total');
comprobar(
    strpos($modelo, 'El total no coincide con el detalle') === false,
    'ya no se rechaza por total manipulado: se corrige con el calculado'
);
comprobar(
    strpos($modelo, 'no cubre el total de la factura') !== false,
    'valida que los pagos cubran el total real'
);
comprobar(
    strpos($modelo, 'precioRealServicio') !== false && strpos($modelo, 'datosRealesInsumo') !== false,
    'los precios se buscan en la base, no vienen del navegador'
);
comprobar(strpos($modelo, "'exito' => false") !== false, 'el error se devuelve como array, no como string');

echo "\n=== El comprobante escapa la salida ===\n";
$comp = file_get_contents("$raiz/src/vistas/vistaFactura/comprobante.php");
comprobar(strpos($comp, 'htmlspecialchars') !== false, 'usa htmlspecialchars');
comprobar(strpos($comp, '* 0.30') === false, 'ya no recalcula el IVA con un 30% fijo');
comprobar(strpos($comp, '<div class="card-body px-4 px-md-5 bg-comprobante">' . "\nd") === false, 'se elimino la "d" suelta');

echo "\n=== Consultas corregidas ===\n";
// Se aísla el cuerpo de cada método para no comparar contra el archivo entero.
preg_match('/function consultarServiciosExtras\(\)(.*?)\n\t\}/s', $modelo, $cse);
comprobar(!empty($cse[1]), 'se encuentra consultarServiciosExtras');
// Los comentarios mencionan el problema histórico; se ignoran para el chequeo.
$sqlServicios = preg_replace(['#//[^\r\n]*#', '#/\*.*?\*/#s'], '', $cse[1] ?? '');
comprobar(
    stripos($sqlServicios, 'LIMIT') === false,
    'consultarServiciosExtras ya no tiene LIMIT'
);
comprobar(
    empty($cse[1]) || strpos($cse[1], "tipo = 'Servicio'") !== false,
    'consultarServiciosExtras filtra por tipo = Servicio'
);
comprobar(strpos($modelo, 'reservarLotes') !== false, 'existe la reserva de lotes con bloqueo');
comprobar(strpos($modelo, 'FOR UPDATE') !== false, 'las reservas usan FOR UPDATE');
comprobar(strpos($modelo, "personal_id_personal") !== false, 'se persiste el doctor del servicio');

echo "\n=== Busqueda de paciente (Enter no debe recargar) ===\n";
$facturaVista = file_get_contents("$raiz/src/vistas/vistaFactura/factura.php");
$codigoJs = preg_replace('#//[^\r\n]*#', '', $js);

// El input NO puede tener dos id: el parser ignora el segundo.
preg_match('/<input[^>]*id="input-cedula-paciente"[^>]*>/s', $facturaVista, $input);
$inputTag = $input[0] ?? '';
comprobar($inputTag !== '', 'se encuentra el input de cédula');
comprobar(
    substr_count($inputTag, 'id=') === 1,
    'el input de cédula tiene un solo id (antes tenía dos duplicados)'
);
comprobar(strpos($facturaVista, 'id="inputBusPaCi"') === false, 'el id duplicado inputBusPaCi ya no está');

// El form no debe tener action/method: si el submit se dispara, recarga.
comprobar(
    preg_match('/<form[^>]*id="form-buscador-factura"/s', $facturaVista, $formTag) === 1,
    'el form de búsqueda existe'
);
comprobar(
    !preg_match('/action=/', $formTag[0] ?? '') && !preg_match('/method=/', $formTag[0] ?? ''),
    'el form de búsqueda no define action ni method'
);
comprobar(strpos($facturaVista, 'novalidate') !== false, 'el form no usa validación nativa');

// El listener debe registrarse ANTES de cualquier await en el arranque.
$posAwait = strpos($codigoJs, 'await Promise.all');
$posListener = strpos($codigoJs, 'formularioPaciente.addEventListener');
comprobar($posListener !== false, 'existe el listener de submit del buscador');
comprobar($posAwait !== false && $posListener !== false && $posListener < $posAwait,
    'el listener se registra ANTES de esperar la carga de datos');

// submit debe llamar preventDefault en todas partes (función o arrow function).
$submitCalls = preg_match_all('/addEventListener\("submit"/', $codigoJs);
$prevents = preg_match_all(
    '/addEventListener\("submit",\s*(?:async\s+)?(?:function\s*\(\s*e\s*\)\s*\{\s*e\.preventDefault\(\)|\(\s*e\s*\)\s*=>\s*e\.preventDefault\(\))/',
    $codigoJs
);
comprobar($submitCalls === $prevents, "todos los submit hacen preventDefault ($prevents/$submitCalls)");

// Un fallo de red no debe impedir que la interfaz quede operativa.
comprobar(
    strpos($codigoJs, 'const cargar = (etiqueta, promesa)') !== false,
    'las cargas de datos se aíslan para no romper la interfaz'
);

// ── Zona muerta temporal (TDZ) ──────────────────────────────────────
// Un `const` usado antes de su declaración lanza ReferenceError y aborta todo
// el handler: sin listeners, el buscador recarga la página en vez de buscar.
$declLinea = [];
foreach (explode("\n", $js) as $n => $l) {
    if (preg_match('/^  (?:const|let)\s+([A-Za-z_$][\w$]*)\s*=/', $l, $m)) {
        $declLinea[$m[1]] ??= $n;
    }
}
$creaPaginadores = strpos($codigoJs, 'crearPaginadores();');
$declaraPaginador = strpos($codigoJs, 'let paginadorServicios');

comprobar($declaraPaginador !== false, 'los paginadores se declaran sin instanciar');
comprobar($creaPaginadores !== false, 'existe crearPaginadores()');
comprobar(
    $creaPaginadores !== false && $declaraPaginador !== false && $creaPaginadores > $declaraPaginador,
    'crearPaginadores() se invoca DESPUÉS de declararlos'
);

// Ningún callback puede pasarse a Paginator como referencia desnuda: debe ir
// dentro de una arrow function para evaluarse en el momento de la llamada.
$bloque = preg_match(
    '/const crearPaginadores = \(\) => \{(.*?)\n  \};/s',
    $codigoJs,
    $m
) ? $m[1] : '';
comprobar($bloque !== '', 'se encuentra el cuerpo de crearPaginadores()');
foreach (['addServicioTable', 'addInsumoTable', 'returnFragmentHtmlSer', 'returnFragmentHtml'] as $cb) {
    comprobar(
        preg_match('/\(\s*\w+\s*\)\s*=>\s*' . $cb . '\(/', $bloque) === 1,
        "$cb se pasa como arrow function (no en zona muerta temporal)"
    );
    comprobar(
        preg_match('/^\s*' . $cb . '\s*,?\s*$/m', $bloque) !== 1,
        "$cb no se pasa como referencia desnuda"
    );
}

echo "\n=== Tasa de cambio ===\n";
$conversion = file_get_contents("$raiz/src/assets/js/generic/coversion.js");
comprobar(strpos($conversion, 'CLAVE_TASA_FECHA') !== false, 'la tasa guarda su fecha');
comprobar(strpos($conversion, 'AbortController') !== false, 'la peticion a la API tiene timeout');
comprobar(strpos($conversion, 'promesaEnVuelo') !== false, 'no se duplican peticiones simultaneas');
// Se ignoran los comentarios: lo que importa es que no haya un await real.
$jsCodigo = preg_replace('#//[^\r\n]*#', '', $js);
comprobar(
    strpos($jsCodigo, 'await inicializarTasa') === false,
    'f.js NO espera a la API antes de pintar (la pantalla no puede quedar vacia)'
);
comprobar(
    preg_match('/^\s*inicializarTasa\(\);/m', $jsCodigo) === 1,
    'la tasa se inicializa de forma sincrona, sin bloquear'
);
comprobar(
    strpos($js, 'tasaGuardada()') !== false,
    'f.js aplica primero la tasa cacheada de forma sincronica'
);
comprobar(
    strpos($js, 'datosListos') !== false,
    'los repintados por cambio de tasa solo ocurren con datos ya cargados'
);
comprobar(
    strpos($js, 'num(localStorage.getItem("valorDelDolar")) || 0') === false,
    'f.js ya no lee la tasa directo de localStorage'
);
comprobar(
    strpos($vistas, 'id="tasaCambioActual"') !== false &&
    strpos($vistas, 'id="btnGuardarTasa"') !== false,
    'la vista permite ver y ajustar la tasa'
);
comprobar(
    strpos($js, 'guardarTasaManual') !== false,
    'existe la via para fijar la tasa a mano'
);

// Ningún id puede repetirse DENTRO de una misma página: el parser ignora el
// segundo y getElementById siempre devuelve el primero, así que un id
// duplicado rompe silenciosamente la funcionalidad.
// Solo se comparan los archivos que se incluyen juntos en una página.
$paginas = [
    'factura' => [
        "$raiz/src/vistas/vistaFactura/factura.php",
        "$raiz/src/vistas/vistaFactura/modalAgregarFactura.php",
        "$raiz/src/vistas/vistaPacientes/modalAgregarPaciente.php",
        "$raiz/src/vistas/vistaCliente/modalAgregarCliente.php",
    ],
];
$ids = [];
foreach ($paginas as $nombre => $archivos) {
    foreach ($archivos as $a) {
        if (!file_exists($a)) {
            continue;
        }
        preg_match_all('/id="([^"]+)"/', file_get_contents($a), $m2);
        foreach ($m2[1] as $id) {
            $ids[$id][] = basename($a);
        }
    }
}
$idsFactura = [];
foreach ($paginas['factura'] as $a) {
    if (file_exists($a)) {
        preg_match_all('/id="([^"]+)"/', file_get_contents($a), $m3);
        $idsFactura = array_merge($idsFactura, $m3[1]);
    }
}

// Ids que el flujo de facturación manipula: si uno estuviera duplicado,
// getElementById devolvería el primero y la actualización se perdería.
$idsCriticos = [
    'data-cliente', 'data-cliente-modal', 'form-buscador-factura',
    'formConfirmarFactura', 'input-cedula-paciente', 'botonPC', 'btnSiguiente',
    'vaciarTabla', 'totalFactura', 'inputIdCita', 'inputCliente',
    'inputHospitalizacion', 'cajaTasaCambio', 'btnGuardarTasa',
];
foreach ($idsCriticos as $id) {
    $n = count(array_keys($idsFactura, $id, true));
    comprobar($n === 1, "#$id existe exactamente una vez en la página");
}

// Duplicados preexistentes fuera del flujo de facturación: se reportan como
// aviso, sin hacer fallar la suite (corregirlos es un trabajo aparte).
$avisos = [];
$ids = $ids ?? [];
foreach ($ids as $id => $donde) {
    if (count($donde) > 1 && !in_array($id, $idsCriticos, true)) {
        $avisos[] = sprintf('#%s (%dx)', $id, count($donde));
    }
}
if ($avisos) {
    echo "\n  Aviso: ids duplicados preexistentes, fuera del flujo de facturación:\n";
    echo "    " . implode("\n    ", array_slice($avisos, 0, 8)) . "\n";
    if (count($avisos) > 8) {
        echo "    ... y " . (count($avisos) - 8) . " mas\n";
    }
}

echo "\n=== Modal de cliente en la factura ===\n";
$facturaJs = file_get_contents($raiz . 'src/assets/js/f.js');
comprobar(
    strpos($facturaJs, 'byId("modalAgregarCliente")') !== false,
    'se busca el modal de cliente (modalAgregarCliente)'
);
comprobar(
    preg_match('/modalAgregarCliente[\s\S]{0,120}inicializarValidacionFormulario/', $facturaJs) === 1,
    'el modal de cliente usa las mismas validaciones modulares'
);
comprobar(
    strpos($facturaJs, 'createCliente(') !== false,
    'existe el envio del formulario de cliente'
);
comprobar(
    strpos($facturaJs, 'Clientes/guardar') !== false,
    'guarda por el endpoint del modulo de Clientes'
);
comprobar(
    preg_match('/createCliente[\s\S]{0,900}?buscarCliente\(form\)/', $facturaJs) === 1,
    'tras registrar, vuelve a buscar para obtener el id_cliente'
);
comprobar(
    strpos($facturaJs, 'modalCliente') !== false,
    'usa la instancia del modal de Clientes (modalCliente)'
);

// El input oculto #inputCliente debe existir una sola vez en la pagina.
$modalFactura = file_get_contents($raiz . 'src/vistas/vistaFactura/modalAgregarFactura.php');
comprobar(
    substr_count($modalFactura, 'name="id_cliente"') === 1,
    'el formulario de confirmacion tiene un solo campo id_cliente'
);
// El boton "Siguiente" del modal debe mostrarse al encontrar/registrar cliente.
comprobar(
    preg_match('/if \(botonPC\) botonPC\.classList\.toggle\("d-none", edad < 18\);/', $facturaJs) === 1,
    'al encontrar cliente se quita el d-none del boton Siguiente'
);

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);