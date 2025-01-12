<?php

namespace App\modelos;
use App\modelos\Db;
class ModeloProveedores extends Db
{

	private $conexion;
	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }


	public function consultar()
	{
		$sql = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado='ACT' ");
		$sql->execute();
		return $sql->fetchAll();
	}


	public function papelera()
	{
		$sql = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado='DES' ");
		$sql->execute();
		return $sql->fetchAll();
	}

	public function agregar($nombre, $rif, $telefono, $email, $direccion)
	{
		$sql = $this->conexion->prepare("INSERT INTO proveedor(nombre, rif, telefono, email, direccion, estado) VALUES (:nombre, :rif, :telefono, :email, :direccion, 'ACT');");
		$sql->bindParam(":nombre", $nombre);
		$sql->bindParam(":rif", $rif);
		$sql->bindParam(":telefono", $telefono);
		$sql->bindParam(":email", $email);
		$sql->bindParam(":direccion", $direccion);
		$sql->execute();
	}

	// eliminación logica
	public function update($id_proveedor)
	{
		$sql = $this->conexion->prepare("UPDATE proveedor SET estado='DES' WHERE id_proveedor = :id_proveedor;");
		$sql->bindParam(":id_proveedor", $id_proveedor);
		$sql->execute();
	}

	public function restablecerProveedor($id_proveedor)
	{
		$sql = $this->conexion->prepare("UPDATE proveedor SET estado='ACT' WHERE id_proveedor = :id_proveedor;");
		$sql->bindParam(":id_proveedor", $id_proveedor);
		$sql->execute();
	}


	public function editar($id_proveedor, $nombre, $rif, $telefono,$email,$direccion)
	{
		$sql = $this->conexion->prepare("UPDATE proveedor SET nombre =:nombre, rif =:rif, telefono =:telefono, email=:email, direccion=:direccion WHERE id_proveedor = :id_proveedor");
		$sql->bindParam(":nombre", $nombre);
		$sql->bindParam(":rif", $rif);
		$sql->bindParam(":telefono", $telefono);
		$sql->bindParam(":email", $email);
		$sql->bindParam(":direccion", $direccion);
		$sql->bindParam(":id_proveedor", $id_proveedor);
		$sql->execute();

	}

	public function validarRif($rif)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM proveedor WHERE rif =:rif");

        $consulta->bindParam(":rif", $rif);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeC";
        }

        return 0;
    }

}

?>
