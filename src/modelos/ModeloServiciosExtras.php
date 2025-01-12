<?php
namespace App\modelos;
use App\modelos\Db;
class ModeloServiciosExtras extends Db
{

	private $conexion;
	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }
    public function getServiciosExtras()
	{
		$consulta = $this->conexion->prepare("SELECT se.id_servicioExtra, u.nombre, u.apellido, se.nombre, se.precio FROM usuario u JOIN doctor d ON d.id_usuario = u.id_usuario JOIN servicioextra se ON se.id_doctor = d.id_doctor WHERE se.estado= 'ACT' AND u.id_rol = 2 AND u.estado = 'ACT'");
		$consulta->execute();
		
        // SELECT u.nombre, u.apellido FROM usuario u JOIN doctor d ON d.id_usuario = u.id_usuario JOIN servicioextra se ON se.id_doctor = d.id_doctor 
// Codigo para el autoguardado "save_on_focus_lost": true

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
	public function getDoctores()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM usuario u JOIN doctor d ON u.id_usuario = d.id_usuario JOIN doctoryespecialidad dye ON dye.id_doctor = d.id_doctor JOIN especialidad e ON e.id_especialidad = dye.id_especialidad AND u.estado = 'ACT'AND u.id_rol = 2");
		$consulta->execute();
	return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
	public function insertar($nombre, $precio, $id_doctor)
	{
		$consulta = $this->conexion->prepare("INSERT INTO servicioextra (id_servicioExtra, nombre, precio, id_doctor, estado) VALUES (Null, :nombre, :precio, :id_doctor, 'ACT')");
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":precio", $precio);
    $consulta->bindParam(":id_doctor", $id_doctor);
	$consulta->execute();

	}
	public function update($id_servicioExtra, $nombre, $precio, $id_doctor)
	{
		$consulta = $this->conexion->prepare("UPDATE servicioextra SET nombre =:nombre, precio =:precio, id_doctor =:id_doctor WHERE id_servicioExtra = :id_servicioExtra");
	$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":precio", $precio);
    $consulta->bindParam(":id_doctor", $id_doctor);
	$consulta->execute();

	}

	public function delete($id_servicioExtra)
	{
		$consulta = $this->conexion->prepare("UPDATE servicioextra SET estado ='DES' WHERE id_servicioExtra = :id_servicioExtra");
	$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);
	$consulta->execute();

	}
	public function ServAdiBuscar($nombre)
	{
		// $consulta = $this->PDO->prepare("SELECT * FROM servicioextra WHERE estado = 'ACT' AND nombre LIKE :nombre");
		// $busqueda = "%$nombre%";
		// $consulta->bindParam(":nombre", $busqueda);
		
		// return ($consulta->execute()) ? $consulta->fetchAll() : false;
		$consulta = $this->conexion->prepare("SELECT * FROM servicioextra WHERE estado = 'ACT' AND nombre LIKE :nombre");
		$busqueda = "%$nombre%";
		$consulta->bindParam(":nombre", $busqueda);
	
		return ($consulta->execute()) ? $consulta->fetchAll() : false;

	}
}
?>