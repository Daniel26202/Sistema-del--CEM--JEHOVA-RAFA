<?php

use App\modelos\ModeloEntrada;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;




function entrada($parametro)
{
	$ayuda = "btnayudaEntrada";
	$vistaActiva = "entradas";
	// $insumos = $this->modelo->insumos();
	// $proveedores = $this->modelo->selectProveedores();
	// require_once './src/vistas/vistaEntrada/vistaEntrada.php';
	echo  "entradas";
}

// function entradasAjax()
// {
// 	echo json_encode($this->modelo->todasLasEntradas());
// }

// function papelera($parametro)
// {
// 	$insumos = $this->modelo->insumos();
// 	require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
// }

// function entradasPapeleraAjax()
// {
// 	echo json_encode($this->modelo->seleccionarDesactivos());
// }

// function restablecerEntrada($datos)
// {
// 	$id_entrada = $datos[0];
// 	$id_usuario_bitacora = $datos[1];
// 	$restablecimiento = $this->modelo->restablecerEntrada($id_entrada);


// 	if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
// 		$this->bitacora->insertarBitacora($id_usuario_bitacora, "entrada", "Ha restablecido una entrada");
// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
// 	} else {
// 		http_response_code(409);
// 		echo json_encode(['ok' => false, 'error' => $restablecimiento]);
// 		exit;
// 	}
// }

// function proveedoresEditar()
// {
// 	$respuesta = $this->modelo->selectProveedores();
// 	echo json_encode($respuesta);
// }



// function guardar()
// {

// 	// 1. Quitar separadores de miles
// 	$valor = str_replace('.', '', $_POST['precioD']);

// 	// 2. Cambiar coma decimal por punto
// 	$valor = str_replace(',', '.', $valor);

// 	// 3. Convertir a float
// 	$numero = (float)$valor;

// 	$insercion = $this->modelo->insertarEntrada($_POST["id_proveedor"], $_POST["id_insumo"], $_POST["fechaDeIngreso"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $numero, $_POST["lote"]);

// 	if (is_array($insercion) && $insercion[0] === "exito") {
// 		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "entrada", "Ha insertado una entrada");
// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
// 	} else {
// 		http_response_code(409);
// 		echo json_encode(['ok' => false, 'error' => $insercion]);
// 		exit;
// 	}
// }

// function eliminar($datos)
// {
// 	$id_entrada = $datos[0];
// 	$id_usuario_bitacora = $datos[1];
// 	$elimincion = $this->modelo->eliminar($id_entrada);

// 	if (is_array($elimincion) && $elimincion[0] === "exito") {
// 		$this->bitacora->insertarBitacora($id_usuario_bitacora, "entrada", "Ha eliminado una entrada");
// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
// 	} else {
// 		http_response_code(409);
// 		echo json_encode(['ok' => false, 'error' => $elimincion]);
// 		exit;
// 	}
// }

// function editar()
// {
// 	// 1. Quitar separadores de miles
// 	$valor = str_replace('.', '', $_POST['precioD']);

// 	// 2. Cambiar coma decimal por punto
// 	$valor = str_replace(',', '.', $valor);

// 	// 3. Convertir a float
// 	$numero = (float)$valor;

// 	$edicion = $this->modelo->actualizarEntrada($_POST["id_entrada"], $_POST["id_proveedor"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $numero, $_POST["id_insumo"], $_POST["lote"]);

// 	if (is_array($edicion) && $edicion[0] === "exito") {
// 		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "entrada", "Ha modificado una entrada");
// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
// 	} else {
// 		http_response_code(409);
// 		echo json_encode(['ok' => false, 'error' => $edicion]);
// 		exit;
// 	}
// }

// function entradaInsumo()
// {
// 	$respuesta = $this->modelo->insumosEntrada($_GET['id_insumo']);
// 	echo json_encode($respuesta);
// }

// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
