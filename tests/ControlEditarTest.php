<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloControl;

class ControlEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloControl();
    }

    public function testEditarControl()
    {
        $resultado = $this->modelo->editarControl(
            "historial",
            34,
           "indicaciones",           
            "2025-11-01",
            "nota editada"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
