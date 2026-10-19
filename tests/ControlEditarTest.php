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

    protected function setUp(): void
    {
        $this->modelo = new ModeloControl();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->db->exec("DELETE FROM bd.sintomas_control WHERE id_control = " . (int)$this->idCreado);
            $this->borrarRegistro('bd', 'control', 'id_control', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testEditarControl()
    {
        // Se crea un control propio para editarlo
        $this->modelo->setIdUsuario(1);
        $this->modelo->setIdPaciente(25);
        $this->modelo->setHistorial("Paciente refiere sintomas leves");
        $this->modelo->setDiagnostico("Diagnostico de prueba automatizada");
        $this->modelo->setIndicaciones("Reposo y control en una semana");
        $this->modelo->setFechaRegreso("2027-01-15");
        $this->modelo->setSeveridad("LEVE");
        $this->modelo->setNota("nota de prueba");
        $this->modelo->insertControl(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'control', 'id_control');

        // Ahora se edita
        $this->modelo = new ModeloControl();
        $this->modelo->setIdControl($this->idCreado);
        $this->modelo->setHistorial("Historial actualizado por la prueba");
        $this->modelo->setDiagnostico("Diagnostico editado por prueba");
        $this->modelo->setIndicaciones("Indicaciones editadas por prueba");
        $this->modelo->setFechaRegreso("2027-02-20", true);
        $this->modelo->setSeveridad("MODERADA");
        $this->modelo->setNota("nota editada");

        $resultado = $this->modelo->editarControl(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
