<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInsumo;

class InsumoEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloInsumo();

    }

    public function testEditarInsumos()
    {
        $resultado = $this->modelo->editar(
            45,
            "Insumophpinit",  // nombre
            "descripcion prueba editando",
            10,                     // stock mínimo
            ["name" => ""]  ,                // imagen
            "MarcaX",
            "100 g",
        );

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
