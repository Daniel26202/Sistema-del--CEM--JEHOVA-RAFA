<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloBitacora;

class BitacoraInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloBitacora();
    }

    public function testInsertarBitacora()
    {
        $this->modelo->setId_usuario(47);
        $this->modelo->setActividad("se hizo una prueba unitaria");
        $this->modelo->setTabla("php unit");

        $resultado = $this->modelo->insertarBitacora();
        $this->assertEquals("exito", $resultado[0]);
    }
}
