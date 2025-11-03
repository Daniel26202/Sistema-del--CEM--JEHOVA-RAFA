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
        $resultado = $this->modelo->insertarBitacora(
            47,
            "PHP UNIT",
            "Prueba unitaria",
        );
        
        $this->assertEquals("exito", $resultado[0]);
    }
}
