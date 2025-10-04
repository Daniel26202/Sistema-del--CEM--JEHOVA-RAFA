<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;

class ProveedorEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloProveedores();
    }

    public function testProvedorEditar()
    {
        $resultado = $this->modelo->editar(
            8,
            "Luis Empresa",
            "J122334",
            "0424354556",
            "luis12345@gmail.com",
            "El Tocuyo"
        );

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
