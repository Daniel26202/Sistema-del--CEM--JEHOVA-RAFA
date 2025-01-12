<?php
namespace App\modelos;
use App\modelos\Db;

class ModeloEntrada extends Db
{

	private $conexion;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }
	public function selectProveedores()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado ='ACT' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function todasLasEntradas(){
		$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado != 'VEC' AND i.estado = 'ACT' ORDER BY ei.fechaDeVencimiento ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function insumosEntrada($id_insumo)
	{
		$consulta = $this->conexion->prepare(" SELECT ei.id_entradaDeInsumo,i.*,e.*,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE i.id_insumo=:id_insumo AND e.estado = 'ACT' AND i.estado = 'ACT' ORDER BY e.fechaDeIngreso");
		$consulta->bindParam(":id_insumo", $id_insumo);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function insertarEntrada($id_proveedor, $id_insumo, $fechaDeIngreso, $fechaDeVencimiento, $cantidad, $precio, $lote)
	{
		// print_r($_POST);
		//insertar entrada

		$consulta = $this->conexion->prepare("INSERT INTO entrada VALUES (null, :id_proveedor, :lote, :fechaDeIngreso, 'ACT')");
		$consulta->bindParam(":lote", $lote);
		$consulta->bindParam(":id_proveedor", $id_proveedor);
		$consulta->bindParam(":fechaDeIngreso", $fechaDeIngreso);
		$consulta->execute();
		$id_entrada = $this->conexion->lastInsertId();

		$consulta2 = $this->conexion->prepare("INSERT INTO entrada_insumo VALUES (null, :id_insumo, :id_entrada,:fechaDeVencimiento,:precio, :cantidad)");
		$consulta2->bindParam(":id_insumo", $id_insumo);
		$consulta2->bindParam(":id_entrada", $id_entrada);
		$consulta2->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
		$consulta2->bindParam(":precio", $precio);
		$consulta2->bindParam(":cantidad", $cantidad);
		$consulta2->execute();

		$this->actualizarCantidadEntradas($id_insumo);
		//$this->promedioPonderado($id_insumo);


		//insertar en la tabla inventario


		$consulta3 = $this->conexion->prepare("INSERT INTO inventario VALUES (null, :id_insumo, :cantidad,:fechaVecimiento,:lote)");
		$consulta3->bindParam(":id_insumo", $id_insumo);
		$consulta3->bindParam(":cantidad", $cantidad);
		$consulta3->bindParam(":fechaVecimiento", $fechaDeVencimiento);
		$consulta3->bindParam(":lote", $lote);
		$consulta3->execute();

	}

	public function eliminar($id_entrada, $id_insumo)
	{
		$consulta = $this->conexion->prepare("UPDATE entrada SET estado='DES' WHERE id_entrada =:id_entrada");
		$consulta->bindParam(":id_entrada", $id_entrada);
		$consulta->execute();
		//$this->actualizarCantidadEntrada($id_insumo);
	}


	public function actualizarEntrada($id_entrada, $id_proveedor, $fechaDeVencimiento, $cantidad, $precio, $id_insumo)
	{
		// $consulta = $this->conexion->prepare("UPDATE entrada SET  id_proveedor =:id_proveedor, cantidad =:cantidad, precio =:precio WHERE id_entrada=:id_entrada");

		$consulta = $this->conexion->prepare("UPDATE entrada_insumo SET fechaDeVencimiento=:fechaDeVencimiento,  precio=:precio,cantidad=:cantidad WHERE id_entrada=:id_entrada");

		//return ($consulta->execute()) ? $consulta->fetchAll() : false;
		$consulta->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
		$consulta->bindParam(":cantidad", $cantidad);
		$consulta->bindParam(":precio", $precio);
		$consulta->bindParam(":id_entrada", $id_entrada);
		$consulta->execute();

		//$this->actualizarCantidadEntrada($id_insumo);
	
	}



	private function actualizarCantidadEntrada($id_insumo)
	{
		$consulta = $this->conexion->prepare("SELECT cantidad AS cantidadInsumo FROM insumo WHERE estado = 'ACT'  ");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
		$x = $consulta->fetch();
		$cantidadInsumoPre = $x["cantidadInsumo"];
		echo $cantidadInsumoPre."<br>";

		// $consulta = $this->conexion->prepare("SELECT * FROM entrada e INNER JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo WHERE ei.id_insumo =:id_insumo AND e.estado = 'DES' ");
		// $consulta->bindParam(":id_insumo", $id_insumo);
		// $consulta->execute();
		// $desactivos = $consulta->fetchAll();
		// $totalDesactivo = 0;
		// foreach ($desactivos as $des) {
		// 	$totalDesactivo += $des["cantidad"];
		// }
		// echo $id_insumo;
		// $consultaInsumosFacturados = $this->conexion->prepare("SELECT SUM(cantidad) AS total_cantidad_facturada FROM insumodefactura WHERE estado = 'ACT' AND id_insumo =:id_insumo");
		// $consultaInsumosFacturados->bindParam(":id_insumo", $id_insumo);
		// $consultaInsumosFacturados->execute();
		// $facturados = $consultaInsumosFacturados->fetch();
		
		// $totalFacturado = $facturados["total_cantidad_facturada"];

		// //esto es para restar los insumos que ya fueron facturados

		// $cantidadInsumo = ($cantidadInsumoPre - $totalDesactivo) - $totalFacturado;

		// echo "Pre: " .$cantidadInsumoPre."<br>";
		// echo "Desactivado: ".$totalDesactivo."<br>";
		// echo "Factrado: ".$totalFacturado."<br>";
		// echo $cantidadInsumo;



		$consulta = $this->conexion->prepare("UPDATE insumo SET cantidad =:cantidadInsumo WHERE id_insumo =:id_insumo");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->bindParam(":cantidadInsumo", $cantidadInsumo);
		$consulta->execute();
	}


	//insumos
	public function insumos()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM insumo WHERE estado = 'ACT' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	//esto es para actualizar la cantidad de los insumos
	public function actualizarCantidadEntradas($id_insumo)
	{
		$consulta = $this->conexion->prepare("SELECT i.id_insumo,SUM(ei.cantidad) AS cantidadInsumo, e.estado FROM insumo i INNER JOIN entrada_insumo ei on ei.id_insumo = i.id_insumo INNER JOIN entrada e on ei.id_entrada = e.id_entrada WHERE i.estado = 'ACT' AND ei.id_insumo =:id_insumo AND e.estado != 'VEC' ");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
		$x = $consulta->fetch();
		$cantidadInsumoPre = $x["cantidadInsumo"];
		echo $cantidadInsumoPre."<br>";

		$consulta = $this->conexion->prepare("SELECT * FROM entrada e INNER JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo WHERE ei.id_insumo =:id_insumo AND e.estado = 'DES' ");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
		$desactivos = $consulta->fetchAll();
		$totalDesactivo = 0;
		foreach ($desactivos as $des) {
			$totalDesactivo += $des["cantidad"];
		}



		//insumo vencidos
		$consulta2 = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE e.estado = 'VEC' AND i.estado = 'ACT'AND ei.id_insumo =:id_insumo AND i.cantidad > '0'");
		$consulta2->bindParam(":id_insumo", $id_insumo);
		$consulta2->execute();
		$vencidos = $consulta2->fetchAll();
		$totalVencidos = 0;
		foreach ($vencidos as $vec) {
			$totalVencidos += $vec["cantidad_entrada"];

		}

		
		// echo $id_insumo;
		// $consultaInsumosFacturados = $this->conexion->prepare("SELECT SUM(cantidad) AS total_cantidad_facturada FROM insumodefactura WHERE estado = 'ACT' AND id_insumo =:id_insumo");
		// $consultaInsumosFacturados->bindParam(":id_insumo", $id_insumo);
		// $consultaInsumosFacturados->execute();
		// $facturados = $consultaInsumosFacturados->fetch();
		
		// $totalFacturado = $facturados["total_cantidad_facturada"];

		// //esto es para restar los insumos que ya fueron facturados

		$cantidadInsumo = ($cantidadInsumoPre - $totalDesactivo) -$totalVencidos;

		echo "Pre: " .$cantidadInsumoPre."<br>";
		echo "Desactivado: ".$totalDesactivo."<br>";
		echo "id insumo: ".$id_insumo."<br>";
		echo "Vencidos: ".$totalVencidos."<br>";
		echo $cantidadInsumo;



		$consulta = $this->conexion->prepare("UPDATE insumo SET cantidad =:cantidadInsumo WHERE id_insumo =:id_insumo");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->bindParam(":cantidadInsumo", $cantidadInsumo);
		$consulta->execute();
	}

	//funcion privada para calcular el precio ponderado de el insumo
	// private function promedioPonderado($id_insumo)
	// {
	// 	//total precio
	// 	$sqlTotalPrecio = $this->conexion->prepare("SELECT i.nombre, SUM(e.precio) AS total_precio FROM entrada e INNER JOIN entrada_insumo ei ON e.id_entrada = ei.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo GROUP BY ei.id_insumo HAVING ei.id_insumo = :id_insumo");
	// 	$sqlTotalPrecio->bindParam(":id_insumo", $id_insumo);
	// 	$precio_tota = 0;
	// 	if ($sqlTotalPrecio->execute()) {
	// 		$precio_total = $sqlTotalPrecio->fetch();
	// 		echo "<br>Total Precio: " . $precio_total["total_precio"] . "<br><br>";
	// 	}
	// 	//total cantidad
	// 	$sqlTotalCatidad = $this->conexion->prepare("SELECT i.nombre, i.cantidad AS total_cantidad, e.estado FROM entrada_insumo ei INNER JOIN insumo i ON ei.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada  WHERE i.id_insumo =:id_insumo AND e.estado = 'ACT' LIMIT 1 ");
	// 	$sqlTotalCatidad->bindParam(":id_insumo", $id_insumo);
	// 	$cantidad_total = 0;
	// 	if ($sqlTotalCatidad->execute()) {
	// 		$cantidad_total = $sqlTotalCatidad->fetch();
	// 		echo "<br>Total Cantidad: " . $cantidad_total["total_cantidad"] . "<br><br>";
	// 	}

	// 	$promedio_ponderado = $precio_total["total_precio"] / $cantidad_total["total_cantidad"];

	// 	$con_dos_decimales = number_format($promedio_ponderado, 2, '.', '.');

	// 	echo "<br>Promedio Ponderado: " . $con_dos_decimales . "<br><br>";

	// 	$consulta = $this->conexion->prepare("UPDATE insumo SET precio =:con_dos_decimales WHERE id_insumo =:id_insumo");
	// 	$consulta->bindParam(":id_insumo", $id_insumo);
	// 	$consulta->bindParam(":con_dos_decimales", $con_dos_decimales);
	// 	$consulta->execute();



	// }


	public function seleccionarDesactivos(){
		$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'DES'  ORDER BY ei.fechaDeVencimiento ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function restablecerEntrada($id_entrada)
	{
		$consulta = $this->conexion->prepare("UPDATE entrada SET estado='ACT' WHERE id_entrada =:id_entrada");
		$consulta->bindParam(":id_entrada", $id_entrada);
		$consulta->execute();
	}






	




}
?>