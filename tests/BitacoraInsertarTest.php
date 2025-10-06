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
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
