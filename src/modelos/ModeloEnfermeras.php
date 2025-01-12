<?php

namespace App\modelos;
use App\modelos\Db;


class ModeloEnfermeras extends Db
{

	private $modelo;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->modelo = $this; // Guarda la instancia de la conexión
    }

	public function consultar()
	{
		$sql = $this->modelo->prepare("SELECT * FROM enfermeras WHERE estado='ACT' ");
		$sql->execute();
		return $sql->fetchAll();
	}


	public function agregar($cedula, $nombre, $apellido, $fechaNacimiento, $telefono, $correo, $turno)
	{
		$sql = $this->modelo->prepare("INSERT INTO enfermeras(cedula, nombre, apellido, fechaNacimiento, telefono, correo, turno, estado) VALUES (:cedula, :nombre, :apellido, :fechaNacimiento, :telefono, :correo, :turno, 'ACT');");
		$sql->bindParam(":cedula", $cedula);
		$sql->bindParam(":nombre", $nombre);
		$sql->bindParam(":apellido", $apellido);
		$sql->bindParam(":fechaNacimiento", $fechaNacimiento);
		$sql->bindParam(":telefono", $telefono);
		$sql->bindParam(":correo", $correo);
		$sql->bindParam(":turno", $turno);
		$sql->execute();
	}

	// eliminación logica
	public function update($id_enfermeras)
	{
		$sql = $this->modelo->prepare("UPDATE enfermeras SET estado='DES' WHERE id_enfermeras = :id_enfermeras;");
		$sql->bindParam(":id_enfermeras", $id_enfermeras);
		$sql->execute();
	}


	public function editar($id_enfermeras, $cedula, $nombre, $apellido, $fechaNacimiento, $telefono, $correo, $turno)
	{
		$sql = $this->modelo->prepare("UPDATE enfermeras SET cedula =:cedula, nombre =:nombre, apellido =:apellido, fechaNacimiento =:fechaNacimiento, telefono =:telefono, correo =:correo, turno =:turno WHERE id_enfermeras = :id_enfermeras");
		$sql->bindParam(":cedula", $cedula);
		$sql->bindParam(":nombre", $nombre);
		$sql->bindParam(":apellido", $apellido);
		$sql->bindParam(":fechaNacimiento", $fechaNacimiento);
		$sql->bindParam(":telefono", $telefono);
		$sql->bindParam(":correo", $correo);
		$sql->bindParam(":turno", $turno);
		$sql->bindParam(":id_enfermeras", $id_enfermeras);
		$sql->execute();

	}

}

?>