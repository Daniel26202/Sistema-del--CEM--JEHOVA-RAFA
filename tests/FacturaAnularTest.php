<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloReporte;

class FacturaAnularTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloReporte();
    }

    public function testAnularFactura()
    {
        $resultado = $this->modelo->anularFac(
            57,
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
