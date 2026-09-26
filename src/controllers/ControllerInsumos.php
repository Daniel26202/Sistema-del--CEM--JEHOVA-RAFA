<?php

use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;


function insumos($parametro)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$idUsuario = $_SESSION['id_usuario'];
	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_proveedor', 'id_insumo']);
	$ayuda = "btnayudaInsumo";
	$vistaActiva = "insumos";

	$proveedores = $sanetizar->sanitizeRecursive($modeloInsumo->selectProveedores());
	$insumos = $sanetizar->sanitizeRecursive($modeloInsumo->insumos());
	if ($insumos) {
		$modeloInsumo->vencerInsumos($idUsuario);
		//$modeloInsumo->insumoProximos();
	}
	require_once './src/vistas/vistaInsumos/vistaInsumos.php';
}

function insumosAjax()
{
	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_insumo']);
	echo json_encode($sanetizar->sanitizeRecursive($modeloInsumo->insumos()));
}


function InsumosVencidos($parametro)
{
	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_insumo']);

	$ayuda = "btnayudaVencido";
	$vistaActiva = "vencidos";
	$insumos = $sanetizar->sanitizeRecursive($modeloInsumo->insumos());
	require_once './src/vistas/vistaInsumos/vistaInsumosVencidos.php';
}

function vencidos()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['nombre', 'proveedor', 'fechDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';
	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_entrada';
	}

	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_insumo', 'id_insumo_e', 'id_entradaDeInsumo', 'id_entrada', 'id_proveedor']);

	$vencidos = $sanetizar->sanitizeRecursive($modeloInsumo->InsumosVencidos($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloInsumo->contarTotalInsumosVencidos();
	$totalFiltrados = !empty($buscar) ? $modeloInsumo->contarTotalInsumosVencidos($buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($vencidos) ? $vencidos : []
	];

	echo json_encode($response);
	exit;
}

function info($datos)
{
	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();


	$id_insumo = unhashId($datos[0]);
	$modeloInsumo->setIdInsumo($id_insumo);
	$sanetizar->setHashKeys(['id_insumo']);

	$datosDeInsumo = $sanetizar->sanitizeRecursive($modeloInsumo->insumosInfo());
	$datosDeVencimiento =  $sanetizar->sanitizeRecursive($modeloInsumo->retornarFechaDeVencimiento());
	$informacion = array(
		'insumo' => $datosDeInsumo,
		'vencimiento' => $datosDeVencimiento,
		'dolar' => $_SESSION["dolar"]
	);
	echo json_encode($informacion);
}


function mostrarBusquedaInsumo()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();

	$modeloInsumo->setParametro($_POST['nombre']);
	$sanetizar->setHashKeys(['id_insumo']);

	$respuesta = $sanetizar->sanitizeRecursive($modeloInsumo->buscarInsumos());
	echo json_encode($respuesta);
}

function guardarInsumo()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];
		$bitacora = new ModeloBitacora();
		$modeloInsumo = new ModeloInsumo();

		// 1. Validar la imagen ANTES de tocar el disco
		if (!isset($_FILES['imagen'])) {
			throw new InvalidArgumentException('No se recibió ninguna imagen.');
		}
		$modeloInsumo->validarImagen($_FILES['imagen']);

		// 2. Procesar el precio
		$valor = str_replace('.', '', $_POST['precioD']);   // quitar separador de miles
		$valor = str_replace(',', '.', $valor);              // coma decimal -> punto
		$numero = (float)$valor;
		$iva = isset($_POST["iva"]) && $_POST["iva"] == 1 ? 1 : 0;

		if ($iva === 1) {
			$numero += $numero * 0.30;
		}

		// 3. Validar TODOS los demás campos (aún no se ha tocado el disco)
		$modeloInsumo->setNombre($_POST['nombre']);
		$modeloInsumo->setIdProveedor(unhashId($_POST['proveedor']));
		$modeloInsumo->setDescripcion($_POST['descripcion']);
		$modeloInsumo->setFechaDeIngreso(date("Y-m-d"));
		$modeloInsumo->setFechaDeVencimiento($_POST['fechaDeVencimiento']);
		$modeloInsumo->setCantidad($_POST['cantidad']);
		$modeloInsumo->setStockMinimo($_POST['stockMinimo']);
		$modeloInsumo->setLote($_POST['lote']);
		$modeloInsumo->setMarca($_POST['marca']);
		$modeloInsumo->setMedida($_POST['medida']);
		$modeloInsumo->setIva($iva);
		$modeloInsumo->setPrecio($numero);

		// 4. Todo validado — recién ahora se mueve el archivo
		$tiempo = new DateTime();
		$fecha = date("Y-m-d");
		$imagen = $fecha . "_" . $tiempo->getTimestamp() . "_" . basename($_FILES['imagen']['name']);

		if (!move_uploaded_file($_FILES['imagen']['tmp_name'], "./src/assets/images/img_ingresadas_por_usuarios/insumos/" . $imagen)) {
			throw new InvalidArgumentException('No se pudo guardar la imagen.');
		}
		$modeloInsumo->setImagen($imagen);

		$insercion = $modeloInsumo->guardarInsumo($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setTabla("insumo");
			$bitacora->setActividad("Ha Insertado un insumo");
			$bitacora->insertarBitacora($idUsuario);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			if (is_string($insercion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $insercion]);
			} else {
				http_response_code(409);
				error_log("Error en guardarInsumo: " . print_r($insercion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al guardar el insumo.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminar()
{

	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];
		$bitacora = new ModeloBitacora();
		$modeloInsumo = new ModeloInsumo();

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input["id"] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$modeloInsumo->setIdInsumo(unhashId($id));

		$eliminacion = $modeloInsumo->eliminarInsumo($idUsuario, $estado);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha {$text} un insumo");
			$bitacora->setTabla("insumo");
			$bitacora->insertarBitacora($idUsuario);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			if (is_string($eliminacion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $eliminacion]);
			} else {
				http_response_code(409);
				error_log("Error en eliminar: " . print_r($eliminacion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al ' . $text_error . ' el insumo.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
function editar()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}
		$idUsuario = $_SESSION['id_usuario'];

		$bitacora = new ModeloBitacora();
		$modeloInsumo = new ModeloInsumo();

		// 1. Verificar si se subió una imagen nueva
		$hayNuevaImagen = (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK);

		// 2. Si hay imagen nueva, validarla ANTES de tocar el disco
		if ($hayNuevaImagen) {
			$modeloInsumo->validarImagen($_FILES['imagen']);
		}

		// 3. Validar el resto de los campos (aún no se ha tocado el disco)
		$modeloInsumo->setIdInsumo(unhashId($_POST["idInsumoOculto"]));
		$modeloInsumo->setNombre($_POST["nombre"]);
		$modeloInsumo->setDescripcion($_POST['descripcion']);
		$modeloInsumo->setStockMinimo($_POST["stockMinimo"]);
		$modeloInsumo->setMarca($_POST["marca"]);
		$modeloInsumo->setMedida($_POST["medida"]);

		// 4. Todo validado — recién ahora se mueve el archivo, si corresponde
		if ($hayNuevaImagen) {
			$tiempo = new DateTime();
			$fecha = date("Y-m-d");
			$nombreImagen = $fecha . "_" . $tiempo->getTimestamp() . "_" . basename($_FILES['imagen']['name']);

			if (!move_uploaded_file($_FILES['imagen']['tmp_name'], "./src/assets/images/img_ingresadas_por_usuarios/insumos/" . $nombreImagen)) {
				throw new InvalidArgumentException('No se pudo guardar la imagen.');
			}
			$modeloInsumo->setImagen($nombreImagen);
		} else {
			$modeloInsumo->setImagen(null); // Indicamos que no hay cambio de imagen
		}

		$edicion = $modeloInsumo->editarInsumo($idUsuario);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha modificado un insumo");
			$bitacora->setTabla("insumo");

			$bitacora->insertarBitacora($idUsuario);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
		} else {
			if (is_string($edicion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $edicion]);
			} else {
				http_response_code(409);
				error_log("Error en editar: " . print_r($edicion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al editar el insumo.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}


function papelera($parametro)
{
	require_once './src/vistas/vistaInsumos/insumosPapelera.php';
}

function papeleraInsumosAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['id_insumo', 'imagen', 'nombre', 'descripcion', 'marca', 'medida', 'precio', 'stockMinimo', 'iva', 'cantidad_inventario'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

	$modeloInsumo = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_insumo']);

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_insumo';
	}
	$data = $sanetizar->sanitizeRecursive($modeloInsumo->papelera($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloInsumo->contarTotal();
	$totalFiltrados = !empty($buscar) ? $modeloInsumo->contarTotal($buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($data) ? $data : []
	];

	echo json_encode($response);
	exit;
}
