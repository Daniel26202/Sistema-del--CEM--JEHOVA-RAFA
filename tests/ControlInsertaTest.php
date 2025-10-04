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
        $resultado = $this->modelo->insertControl(
            "historial",
            1,
            25,
            "diagnostico",
            [0 =>'6', 1 => '8'],
            "indicaciones",
            "2025-11-01",
            [0 => '5', 1 => '7'],
            "nota"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
