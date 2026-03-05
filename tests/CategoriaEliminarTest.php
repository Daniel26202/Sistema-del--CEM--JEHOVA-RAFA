<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCategoria;

class CategoriaEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCategoria();
    }

    public function testEliminarCategoria()
    {
        $this->modelo->setId_categoria(106);
        $resultado = $this->modelo->eliminarCategoria();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
