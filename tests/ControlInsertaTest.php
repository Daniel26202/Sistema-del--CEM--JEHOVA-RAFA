<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloControl;

class ControlInsertaTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloControl();
    }

    public function testInsertarControl()
    {
        $this->modelo->setId_usuario(25);
        $this->modelo->setTipo_control("historial");
        $this->modelo->setFecha_control("2025-11-01");
        $this->modelo->setIndicaciones("indicaciones");
        $this->modelo->setDiagnostico("diagnostico");
        $this->modelo->setId_cita(1);
        $this->modelo->setNota("nota");
        $resultado = $this->modelo->insertControl();

        $this->assertEquals("exito", $resultado[0]);
    }
}
