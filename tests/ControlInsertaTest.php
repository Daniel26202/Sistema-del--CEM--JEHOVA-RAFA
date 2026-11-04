<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloControl;
use App\modelos\Db;

class ControlInsertaTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;
    private $idPacienteCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloControl();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idPacienteCreado !== null) {
            $this->borrarPacienteSintetico($this->idPacienteCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarControl()
    {
        $this->idPacienteCreado = $this->crearPacienteSintetico();
        $this->modelo->setIdUsuario(1);
        $this->modelo->setIdPaciente($this->idPacienteCreado);
        $this->modelo->setHistorial("Paciente refiere sintomas leves");
        $this->modelo->setDiagnostico("Diagnostico de prueba automatizada");
        $this->modelo->setIndicaciones("Reposo y control en una semana");
        $this->modelo->setFechaRegreso("2027-01-15");
        $this->modelo->setSeveridad("LEVE");
        $this->modelo->setNota("nota de prueba");
        $this->modelo->setSintomas([8]);
        $this->modelo->setPatologias([2]);

        $resultado = $this->modelo->insertControl(1);

        $this->assertIsArray($resultado);
        $this->assertSame("exito", $resultado[0]);
        $stmt = $this->db->prepare('SELECT id_control FROM bd.control WHERE id_paciente = :id_paciente');
        $stmt->execute(['id_paciente' => $this->idPacienteCreado]);
        $this->idCreado = (int)$stmt->fetchColumn();
        $this->assertGreaterThan(0, $this->idCreado);
        $this->assertSame(1, (int)$this->db->query(
            'SELECT COUNT(*) FROM bd.sintomas_control WHERE id_control = ' . $this->idCreado . ' AND id_sintomas = 8'
        )->fetchColumn());
        $this->assertSame(1, (int)$this->db->query(
            'SELECT COUNT(*) FROM bd.patologiadepaciente WHERE id_paciente = ' . $this->idPacienteCreado . ' AND id_patologia = 2'
        )->fetchColumn());
    }
}
