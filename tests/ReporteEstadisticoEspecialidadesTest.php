<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteEstadisticoEspecialidadesTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // entradas

    public function testConsultarEspecialidades()
    {
        $desdeFecha = "2025-04-10";
        $fechaHasta = "2025-12-10";

        $consulta = $this->pdo->prepare("SELECT   cs.nombre AS especialidad,
COUNT(c.id_cita) AS total_solicitudes
												FROM cita c
												INNER JOIN serviciomedico sm 
												ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
												INNER JOIN categoria_servicio cs 
												ON sm.id_categoria = cs.id_categoria WHERE c.fecha BETWEEN :fechaInicio AND :fechaFinal
												GROUP BY cs.nombre 
												ORDER BY total_solicitudes DESC limit 5");
        $consulta->bindParam(":fechaInicio", $desdeFecha);
        $consulta->bindParam(":fechaFinal", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN DATOS DE LAS ESPECIALIDADES MAS SOLICITADAS DESDE (" . $desdeFecha . " A " . $fechaHasta . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los datos de las especialidades mas solicitadas desde (" . $desdeFecha . " A " . $fechaHasta . ")  existen en la BD");
    }

    public function testConsultarEspecialidadesInexistente()
    {
        $desdeFecha = "2024-04-10";
        $fechaHasta = "2024-12-10";

        $consulta = $this->pdo->prepare("SELECT   cs.nombre AS especialidad,
COUNT(c.id_cita) AS total_solicitudes
												FROM cita c
												INNER JOIN serviciomedico sm 
												ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
												INNER JOIN categoria_servicio cs 
												ON sm.id_categoria = cs.id_categoria WHERE c.fecha BETWEEN :fechaInicio AND :fechaFinal
												GROUP BY cs.nombre 
												ORDER BY total_solicitudes DESC limit 5");
        $consulta->bindParam(":fechaInicio", $desdeFecha);
        $consulta->bindParam(":fechaFinal", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que no existan datos en ese rango de fechas
        $this->assertEmpty($resultado, "Los datos de las especialidades mas solicitadas desde  (" . $desdeFecha . " A " . $fechaHasta . ")  no existen en la BD");
    }
}
