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
        $this->modelo->setId_control(34);
        $this->modelo->setTipo_control("historial");
        $this->modelo->setFecha_control("2025-11-01");
        $this->modelo->setIndicaciones("nota editada");
        $resultado = $this->modelo->editarControl(); 
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
