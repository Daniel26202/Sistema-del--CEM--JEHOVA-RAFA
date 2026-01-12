<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloEstadisticas extends ModelBase
{

  private $fechaInicio, $fechaFinal;

  public function __construct($dbSystem = true)
  {
    parent::__construct($dbSystem);
  }

  public function distribucion_edad_genero()
  {
    try {
      $sql = "SELECT * FROM distribucion_edad_genero";

      $this->setSQL($sql);
      return $this->read();
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }


  public function insumos()
  {
    try {
      $sql = "SELECT * FROM insumos_estadisticas";
      $this->setSQL($sql);
      return $this->read();
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function tasa_morbilidad()
  {
    try {
      $data=[
        'fechaInicio'=>$this->getFechaInicio(),
        'fechaFinal'=>$this->getFechaFinal()
      ];
      if ($this->getFechaInicio() == "" && $this->getFechaFinal() == "") {
        $sql = "SELECT * FROM tasa_morbilidad;";
        $this->setSQL($sql);
        return $this->read();
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
        $this->setSQL($sql);
        return $this->search($data);
      }
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function getFechaInicio()
  {
    return $this->fechaInicio;
  }

  public function getFechaFinal()
  {
    return $this->fechaFinal;
  }

  public function setFechaInicio($fechaInicio = '')
  {

    $dt = \DateTime::createFromFormat('Y-m-d', $fechaInicio);
    $fechaHoy = date("Y-m-d");

    if ($fechaInicio == '') {
      $this->fechaInicio = $fechaInicio;
      return;
    }

    if (!$dt || $dt->format('Y-m-d') !== $fechaInicio) {
      throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
    }
    if ($fechaInicio >= $fechaHoy) {
      throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
    }
    $this->fechaInicio = $fechaInicio;
  }

  public function setFechaFinal($fechaFinal = '')
  {
    $dt = \DateTime::createFromFormat('Y-m-d', $fechaFinal);
    $fechaHoy = date("Y-m-d");

    if ($fechaFinal == '') {
      $this->fechaFinal = $fechaFinal;
      return;
    }

    if (!$dt || $dt->format('Y-m-d') !== $fechaFinal) {
      throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
    }
    if ($fechaFinal >= $fechaHoy) {
      throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
    }
    $this->fechaFinal = $fechaFinal;
  }
}
