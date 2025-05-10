<?php

namespace App\modelos;
use App\modelos\Db;

class ModeloEstadisticas extends Db
{

	private $conexion;
	
	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión

    }

}