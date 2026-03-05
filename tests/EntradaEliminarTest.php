<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;

class EntradaEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
    }

    public function testEditarEntrada()
    {
        $this->modelo->setId_entrada(75);
        $resultado = $this->modelo->eliminar();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
