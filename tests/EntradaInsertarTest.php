<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;

class EntradaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
    }

    public function testInsertarEntrada()
    {
        $resultado = $this->modelo->insertarEntrada(
            6,               
            44,
            "2025-10-03",           
            "2025-12-31",         
            1,                   
            100,                    
            "12345679",         
        );

        $this->assertEquals("exito", $resultado[0]);
    }
}
