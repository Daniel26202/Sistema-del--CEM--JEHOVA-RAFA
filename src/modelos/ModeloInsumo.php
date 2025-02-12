<?php
// SELECT i.*,e.*,SUM(e.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN insumo i ON e.id_insumo = i.id_insumo GROUP BY i.nombre HAVING i.id_insumo = 2
namespace App\modelos;

use App\modelos\Db;
use DateTime;

class ModeloInsumo extends Db
{

	private $conexion;

	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
	}

	public function selectProveedores()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM proveedor");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function insumos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM insumo WHERE estado ='ACT' ");
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}


	public function InsumosVencidos()
	{
		$sql = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_disponible AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE ei.fechaDeVencimiento <= CURRENT_DATE ");
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}


	public function insumosInfo($id_insumo)
	{
		$sql = $this->conexion->prepare("SELECT * FROM insumo WHERE id_insumo =:id_insumo");
		$sql->bindParam(":id_insumo", $id_insumo);
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	//metodo para taerme el insumo que su fecha de vencimiento esta mas cercana para mostrarlo en el modal de info
	public function retornarFechaDeVencimiento($id_insumo)
	{
		$sql = $this->conexion->prepare("SELECT fechaDeVencimiento FROM entrada_insumo WHERE id_insumo =:id_insumo ORDER BY fechaDeVencimiento LIMIT 1");
		$sql->bindParam(":id_insumo", $id_insumo);
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}


	//cantidad insumos
	public function cantidadInsumos($id_insumo)
	{
		$sql = $this->conexion->prepare("SELECT i.id_insumo,SUM(ei.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN entrada_insumo ei ON e.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo GROUP BY i.nombre HAVING i.id_insumo =:id_insumo");
		$sql->bindParam(":id_insumo", $id_insumo);
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	public function buscarInsumos($parametro)
	{
		$sql = $this->conexion->prepare("SELECT * FROM insumo WHERE nombre LIKE :buscar AND estado = 'ACT' OR id_insumo LIKE :buscar AND estado = 'ACT' ");
		$buscar = "$parametro%";
		$sql->bindParam(":buscar", $buscar);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}



	//insertar insumo
	public function insertarInsumos($nombre, $id_proveedor, $descripcion, $fechaDeIngreso, $fechaDeVecimiento, $precio, $cantidad, $stockMinimo, $estado, $lote)
	{

		$promedio_ponderado = number_format(($precio / $cantidad), 2, '.', '');
		$decimal = floatval($promedio_ponderado);
		echo $decimal;


		$tiempo = new DateTime();
		$fecha = date("Y-m-d");

		$imagen = $fecha . "_" . $tiempo->getTimestamp() . "_" . $_FILES['imagen']['name'];

		$imagen_temporal = $_FILES['imagen']['tmp_name'];

		move_uploaded_file($imagen_temporal, "./src/assets/img_ingresadas_por_usuarios/insumos/" . $imagen);

		$consulta = $this->conexion->prepare("INSERT INTO insumo VALUES (null, :imagen, :nombre, :descripcion, :precio , :cantidad, :stockMinimo, 'ACT')");
		$consulta->bindParam(":imagen", $imagen);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":descripcion", $descripcion);
		$consulta->bindParam(":precio", $decimal);
		$consulta->bindParam(":cantidad", $cantidad);
		$consulta->bindParam(":stockMinimo", $stockMinimo);

		$consulta->execute();
		$id_insumo = $this->conexion->lastInsertId();

		//insertar entrada

		$consulta = $this->conexion->prepare("INSERT INTO entrada VALUES (null, :id_proveedor, :lote, :fechaDeIngreso, 'ACT')");
		$consulta->bindParam(":lote", $lote);
		$consulta->bindParam(":id_proveedor", $id_proveedor);
		$consulta->bindParam(":fechaDeIngreso", $fechaDeIngreso);
		$consulta->execute();
		$id_entrada = $this->conexion->lastInsertId();

		//insertar en la tabla intermedia

		$consulta2 = $this->conexion->prepare("INSERT INTO entrada_insumo VALUES (null, :id_insumo, :id_entrada,:fechaDeVecimiento,:precio, :cantidad_entrante, :cantidad_disponible)");
		$consulta2->bindParam(":id_insumo", $id_insumo);
		$consulta2->bindParam(":id_entrada", $id_entrada);
		$consulta2->bindParam(":fechaDeVecimiento", $fechaDeVecimiento);
		$consulta2->bindParam(":precio", $precio);
		$consulta2->bindParam(":cantidad_entrante", $cantidad);
		$consulta2->bindParam(":cantidad_disponible", $cantidad);
		$consulta2->execute();



		//insertar en la tabla inventario


		$consulta3 = $this->conexion->prepare("INSERT INTO inventario VALUES (null, :id_insumo, :cantidad,:fechaVecimiento,:lote)");
		$consulta3->bindParam(":id_insumo", $id_insumo);
		$consulta3->bindParam(":cantidad", $cantidad);
		$consulta3->bindParam(":fechaVecimiento", $fechaDeVecimiento);
		$consulta3->bindParam(":lote", $lote);
		$consulta3->execute();

	}



	public function eliminar($id_insumo)
	{
		$consulta = $this->conexion->prepare("UPDATE insumo SET estado = 'DES' WHERE id_insumo =:id_insumo");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
	}


	public function editar($id_insumo, $nombre, $descripcion, $stockMinimo, $imagen)
	{

		$consulta1 = $this->conexion->prepare("SELECT * FROM insumo WHERE id_insumo =:id_insumo");
		$consulta1->bindParam(":id_insumo", $id_insumo);
		$consulta1->execute();
		$datos = $consulta1->fetch();
		$imagen_antigua = $datos["imagen"];
		$rutaImagenAntigua = "./src/assets/img_ingresadas_por_usuarios/insumos/" . $imagen_antigua;
		// echo "<img src=".$imagen_antigua.">";
		$imagen_editar = isset($imagen) ? $imagen : "";
		print_r($imagen_editar);
		if ($imagen_editar["name"] != "") {

			echo "nO Vacio";
			if (file_exists($rutaImagenAntigua)) {
				unlink($rutaImagenAntigua);
			}
			$tiempo = new DateTime();
			$fecha = date("Y-m-d");
			$imagen_editar = $fecha . "_" . $tiempo->getTimestamp() . "_" . $_FILES['imagen']['name'];
			$imagen_temporal = $_FILES['imagen']['tmp_name'];
			move_uploaded_file($imagen_temporal, "./src/assets/img_ingresadas_por_usuarios/insumos/" . $imagen_editar);

			$consulta2 = $this->conexion->prepare("UPDATE insumo SET imagen =:imagen, nombre =:nombre, descripcion =:descripcion, stockMinimo =:stockMinimo WHERE id_insumo =:id_insumo");
			$consulta2->bindParam(":nombre", $nombre);
			$consulta2->bindParam(":descripcion", $descripcion);
			$consulta2->bindParam(":stockMinimo", $stockMinimo);
			$consulta2->bindParam(":imagen", $imagen_editar);
			$consulta2->bindParam(":id_insumo", $id_insumo);
			$consulta2->execute();
		} else {

			echo "Vacio";
			$consulta3 = $this->conexion->prepare("UPDATE insumo SET nombre =:nombre, descripcion =:descripcion, stockMinimo =:stockMinimo WHERE id_insumo =:id_insumo");
			$consulta3->bindParam(":nombre", $nombre);
			$consulta3->bindParam(":descripcion", $descripcion);
			$consulta3->bindParam(":stockMinimo", $stockMinimo);
			$consulta3->bindParam(":id_insumo", $id_insumo);
			$consulta3->execute();
		}
	}


	//gestionar salidas
	public function todasLasEntradas()
	{
		$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  i.estado = 'ACT' AND e.estado = 'ACT' AND fechaDeVencimiento BETWEEN CURRENT_DATE + INTERVAL 1 DAY AND CURRENT_DATE + INTERVAL 7 DAY ORDER BY  ei.fechaDeVencimiento");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;


		
	}






	public function vencerInsumos($fecha)
	{

		// $consulta = $this->conexion->prepare("UPDATE entrada SET estado = 'VEC' WHERE 
		// 	(SELECT fechaDeVencimiento FROM entrada_insumo WHERE entrada.id_entrada = entrada_insumo.id_entrada)
		// 	<= :fecha ");
		// $consulta->bindParam(":fecha", $fecha);
		// $consulta->execute();
		// $id_insumoVencidos = $this->id_insumoVencidos();
		//print_r($id_insumoVencidos);
		
		$insumos = $this->insumos();
		foreach ($insumos as $key) {
			//echo $key["id_insumo"]."<br>";
			$cantidad = $this->actualizar_cantidad_insumo($key["id_insumo"]);
			// print_r($cantidad[0]["cantidad"]);

			//esto es para actualizar la cantidad de insumos
			$consulta = $this->conexion->prepare("UPDATE insumo SET cantidad=:cantidad WHERE id_insumo=:id_insumo");
			$consulta->bindParam(":cantidad",$cantidad[0]["cantidad"]);
			$consulta->bindParam(":id_insumo",$key["id_insumo"]);
			$consulta->execute();


		}
		// $this->actualizarCantidadEntrada($id_insumoVencidos["id_insumo"]);

	}

	private function id_insumoVencidos(){
		$consulta2 = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE e.estado = 'VEC' AND i.estado = 'ACT' ORDER BY ei.fechaDeVencimiento");
		return ($consulta2->execute()) ? $consulta2->fetchAll() : false;
	}

	//funcion mejorada de actualizacion de la cantidad
	public function actualizar_cantidad_insumo($id_insumo){
		$consulta = $this->conexion->prepare(" SELECT id_insumo, fechaDeVencimiento, SUM(cantidad_disponible) AS cantidad FROM entrada_insumo WHERE id_insumo =:id_insumo AND fechaDeVencimiento > CURRENT_DATE ");
		$consulta->bindParam(":id_insumo",$id_insumo);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}







	public function insumoProximos()
	{
		// Obtener la fecha actual
		$fechaActual = date('Y-m-d');

		// Calcular la fecha límite (10 días a partir de hoy)
		$fechaLimite = $this->restarDiasDeFecha($fechaActual, -10); // Restar -10 días es sumar 10 días

		// Actualizar el estado de los productos que están a 10 días o menos de vencer
		$sql = "UPDATE entrada SET estado = 'por_vencer' WHERE 
		(SELECT fechaDeVencimiento FROM entrada_insumo WHERE entrada.id_entrada = entrada_insumo.id_entrada)
		<= :fechaLimite AND estado='ACT' ";
		$consulta = $this->conexion->prepare($sql);
		$consulta->bindParam(':fechaLimite', $fechaLimite);
		$consulta->execute();
	}



	//
	public function papelera()
	{
		$sql = $this->conexion->prepare("SELECT * FROM insumo WHERE estado ='DES' ");
		$sql->execute();
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}



	public function restablecerInsumo($id_insumo)
	{
		$consulta = $this->conexion->prepare("UPDATE insumo SET estado = 'ACT' WHERE id_insumo =:id_insumo");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
	}





}
