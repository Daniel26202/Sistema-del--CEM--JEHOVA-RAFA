<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCita;
use App\modelos\Db;

class CitaInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCita();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'cita', 'id_cita', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarCita()
    {
        // Doctor 21 atiende los lunes de 10:00 a 12:00 (horarioydoctor)
        $this->modelo->setIdServicioMedico(2);
        $this->modelo->setIdPaciente(25);
        $this->modelo->setIdDoctor(21);
        $this->modelo->setFecha("2026-10-26");
        $this->modelo->setHora("10:00");
        $this->modelo->setHoraSalida("11:00");

        $resultado = $this->modelo->reservarCita(1);
        if ($resultado[0] === "exito") {
            $this->idCreado = (int)$resultado[1];
        }

        $this->assertEquals("exito", $resultado[0]);
    }
}
