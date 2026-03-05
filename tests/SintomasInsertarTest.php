<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloSintomas;

class SintomasInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloSintomas();
    }

    public function testInsertarSintomas()
    {
        $this->modelo->setDescripcion("Sin n n");
        $resultado = $this->modelo->insertar();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
