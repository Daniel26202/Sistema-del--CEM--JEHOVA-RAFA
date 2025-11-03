<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloFactura;

class FacturaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloFactura();
    }

    public function testInsertarFactura()
    {
        $resultado = $this->modelo->insertaFactura(
            "2025-10-02",
            1000,
           [ 0 => 5],
            [0 => 25],
            25,
            [0 => 36],
            [0 => 1],
            [0 => 1080],
            null,
            null,
            null,
            [0 => 18]

        );

        $this->assertEquals("exito", $resultado[1]);
    }
}
