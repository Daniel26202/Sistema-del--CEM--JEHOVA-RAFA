<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReportePacienteTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // Pacientes
    public function testConsultarPacientes(){
        $consulta = $this->pdo->prepare("SELECT * FROM paciente WHERE estado = 'ACT'");
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN PACIENTES DESDE REGISTRADOS " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los pacientes  existen en la BD");
    }


    public function testConsultarPacientesInexistentes()
    {
        $consulta = $this->pdo->prepare("SELECT * FROM paciente WHERE estado = 'xxx'");
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los pacientes  no existen en la BD");
    }


}