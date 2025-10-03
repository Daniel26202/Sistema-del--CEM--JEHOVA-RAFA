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
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[1]);
    }
}
