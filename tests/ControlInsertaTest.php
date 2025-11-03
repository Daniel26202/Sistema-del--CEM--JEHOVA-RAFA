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

        $this->assertEquals("exito", $resultado[0]);
    }
}
