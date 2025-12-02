<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;


class ControladorPatologias
{
	private $patologia;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->patologia = new ModeloPatologia();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	public function patologias($parametro)
	{
		$ayuda = "btnayudaPatologia";
		require_once './src/vistas/vistaPatologia/patologia.php';
	}

	public function patologiasAjax()
	{
		echo json_encode($this->patologia->mostrarPatologias());
	}
	public function papeleraPatologias($parametro)
	{
		$ayuda = "btnayudaPatologia";
		require_once './src/vistas/vistaPatologia/patologiapapelera.php';
	}
	public function papeleraAjax()
	{
		echo json_encode($this->patologia->mostrarPatologiasEliminadas());
	}

	//insertar patologia 
	public function registrarPatologia()
	{

		$insercion = $this->patologia->insertarPatologia($_POST["nombre"]);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "patologia", "Ha Insertado una nueva patologia");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}
	}

	//eliminar patologia
	public function eliminarPatologia($datos)
	{

		$id_patologia = $datos[0];
		$id_usuario = $datos[1];

		$eliminar = $this->patologia->eliminarPatologia($id_patologia);

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha eliminado una patologia");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminar]);
			exit;
		}
	}


	public function restablecerPatologia($datos)
	{
		$id_patologia = $datos[0];
		$id_usuario = $datos[1];

		$restablecer = $this->patologia->restablecer($id_patologia);

		if (is_array($restablecer) && $restablecer[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha restablecido una patologia");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecer]);
			exit;
		}
	}



	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
