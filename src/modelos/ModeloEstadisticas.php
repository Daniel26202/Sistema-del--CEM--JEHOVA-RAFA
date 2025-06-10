<?php

namespace App\modelos;

use App\modelos\DbSistem;

class ModeloEstadisticas extends DbSistem
{

  private $conexion;

  public function __construct()
  {
    // Llama al constructor de la clase padre para establecer la conexión
    parent::__construct();

    // Aquí puedes usar $this para acceder a la conexión

    $this->conexion = $this; // Guarda la instancia de la conexión

  }

  public function distribucion_edad_genero()
  {
    try {
      $sql = "SELECT * FROM distribucion_edad_genero
";

      $consulta = $this->conexion->prepare($sql);

      return ($consulta->execute()) ? $consulta->fetchAll() : false;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }


  public function insumos()
  {
    try {
      $sql = "SELECT * FROM insumos";
      $consulta = $this->conexion->prepare($sql);

      return ($consulta->execute()) ? $consulta->fetchAll() : false;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function tasa_morbilidad($fechaInicio = "", $fechaFinal = "")
  {
    try {
      if ($fechaInicio == "" && $fechaFinal == "") {
        $sql = "SELECT * FROM tasa_morbilidad;
            ";
        $consulta = $this->conexion->prepare($sql);
      } else {
        $sql = "SELECT
            p.nombre_patologia,
            COUNT(DISTINCT pp.id_paciente) AS casos,
            ROUND(
              COUNT(DISTINCT pp.id_paciente) 
              / (SELECT COUNT(*) FROM paciente)  
              * 1000,/* -- población total */
              2
            ) AS tasa_por_1000
          FROM patologiadepaciente pp
          JOIN patologia p ON pp.id_patologia = p.id_patologia WHERE pp.fecha_registro BETWEEN :fechaInicio AND :fechaFinal
          GROUP BY pp.id_patologia
          ORDER BY casos DESC;";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(":fechaInicio", $fechaInicio);
        $consulta->bindParam(":fechaFinal", $fechaFinal);
      }


      return ($consulta->execute()) ? $consulta->fetchAll() : false;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}
