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
        // Doctor 21 atiende los lunes de 10:00 a 12:00 (horarioydoctor).
        // La fecha NO puede estar fija: el modelo rechaza fechas del pasado y
        // el test empezaba a fallar solo porque pasó el día. Se calcula el
        // próximo lunes a partir de hoy.
        $fecha = new DateTimeImmutable('today');
        $diasHastaLunes = (8 - (int)$fecha->format('N')) % 7;
        $lunes = $fecha->modify("+{$diasHastaLunes} day");

        $this->modelo->setIdServicioMedico(2);
        $this->modelo->setIdPaciente(25);
        $this->modelo->setIdDoctor(21);
        $this->modelo->setFecha($lunes->format('Y-m-d'));
        $this->modelo->setHora("10:00");
        $this->modelo->setHoraSalida("11:00");

        $resultado = $this->modelo->reservarCita(1);
        if ($resultado[0] === "exito") {
            $this->idCreado = (int)$resultado[1];
        }

        $this->assertEquals("exito", $resultado[0]);
    }
}
