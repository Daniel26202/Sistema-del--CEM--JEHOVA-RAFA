<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCategoria;

class CategoriaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCategoria();
    }

    public function testInsertarCategoria()
    {
        $resultado = $this->modelo->registrarCategoria(
            "Categorizacions"
        );
        $this->assertEquals("exito", $resultado[0]);
    }
}
