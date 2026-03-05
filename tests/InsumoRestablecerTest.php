<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInsumo;

class InsumoRestablecerTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloInsumo();
    }

    public function testRestablecerInsumos()
    {
        $this->modelo->setId_insumo(45);
        $resultado = $this->modelo->restablecerInsumo();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
