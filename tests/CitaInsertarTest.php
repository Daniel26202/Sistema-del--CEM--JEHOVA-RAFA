<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCita;

class CitaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCita();
    }

    public function testInsertarCita()
    {
        $this->modelo->setId_usuario(25);
        $this->modelo->setId_servicio(24);
        $this->modelo->setFecha("2025-10-06");
        $this->modelo->setHora("20:00");
        $this->modelo->setEstado("Pendiente");
        $this->modelo->setId_cliente(19);
        $resultado = $this->modelo->insertarCita();

        $this->assertEquals("exito", $resultado[0]);
    }
}
