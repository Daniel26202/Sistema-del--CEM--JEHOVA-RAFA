<?php

namespace App\modelos;

use App\modelos\Db;


class ModeloInicio extends Db
{

	private $conexion;
	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
	}



	public function servicios()
	{
		$consulta = $this->conexion->prepare("SELECT c.nombre AS categoria, s.precio FROM serviciomedico s INNER JOIN categoria_servicio c ON s.id_categoria = c.id_categoria");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

}
