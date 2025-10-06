<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteCitaTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaCitas(){
        $desdeFecha = "2025-04-10";
        $fechaHasta = "2025-12-10";

        $consulta = $this->pdo->prepare("SELECT p.nacionalidad, d.nombre AS nombre_d, d.apellido AS apellido_d,s.*, p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p, c.id_cita, c.fecha, c.hora, c.estado, e.nombre AS especialidad, e.id_especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico =  ps.serviciomedico_id_servicioMedico INNER JOIN personal d ON ps.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.fecha BETWEEN :desdeFecha AND :fechaHasta AND (c.estado = 'Pendiente' OR c.estado = 'Realizadas')");
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado=  $consulta->fetchAll(); 
        echo "EXISTEN CITAS DESDE (" . $desdeFecha . " A " . $fechaHasta . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Las citas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  existen en la BD");
    }

    public function testConsultaCitasInexistente()
    {
        $desdeFecha = "2020-04-10";
        $fechaHasta = "2021-12-10";

        $consulta = $this->pdo->prepare(" SELECT p.nacionalidad, d.nombre AS nombre_d, d.apellido AS apellido_d,s.*, p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p, c.id_cita, c.fecha, c.hora, c.estado, e.nombre AS especialidad, e.id_especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico =  ps.serviciomedico_id_servicioMedico INNER JOIN personal d ON ps.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.fecha BETWEEN :desdeFecha AND :fechaHasta AND (c.estado = 'Pendiente' OR c.estado = 'Realizadas')");
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Las citas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  no existen en la BD");
    }





}
