<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloControl;
use App\modelos\Db;

class ControlEditarTest extends TestCase
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

    public function testEditarControl()
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
        $resultadoInsercion = $this->modelo->insertControl(1);
        $this->assertIsArray($resultadoInsercion);
        $this->assertSame("exito", $resultadoInsercion[0]);
        $stmt = $this->db->prepare('SELECT id_control FROM bd.control WHERE id_paciente = :id_paciente');
        $stmt->execute(['id_paciente' => $this->idPacienteCreado]);
        $this->idCreado = (int)$stmt->fetchColumn();
        $this->assertGreaterThan(0, $this->idCreado);

        $this->modelo = new ModeloControl();
        $this->modelo->setIdControl($this->idCreado);
        $this->modelo->setHistorial("Historial actualizado por la prueba");
        $this->modelo->setDiagnostico("Diagnostico editado por prueba");
        $this->modelo->setIndicaciones("Indicaciones editadas por prueba");
        $this->modelo->setFechaRegreso("2027-02-20", true);
        $this->modelo->setSeveridad("MODERADA");
        $this->modelo->setNota("nota editada");

        $resultado = $this->modelo->editarControl(1);

        $this->assertIsArray($resultado);
        $this->assertSame("exito", $resultado[0]);

        $stmt = $this->db->prepare(
            'SELECT diagnostico, medicamentosRecetados, fechaRegreso, nota, historiaclinica, severidad
             FROM bd.control WHERE id_control = :id_control AND id_paciente = :id_paciente'
        );
        $stmt->execute(['id_control' => $this->idCreado, 'id_paciente' => $this->idPacienteCreado]);
        $control = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertSame('Diagnostico editado por prueba', $control['diagnostico']);
        $this->assertSame('Indicaciones editadas por prueba', $control['medicamentosRecetados']);
        $this->assertSame('2027-02-20', $control['fechaRegreso']);
        $this->assertSame('nota editada', $control['nota']);
        $this->assertSame('Historial actualizado por la prueba', $control['historiaclinica']);
        $this->assertSame('MODERADA', $control['severidad']);
    }
}
