<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;

class ProveedorRestablecerTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloProveedores();
    }

    public function testProvedorRestablecer()
    {
        $this->modelo->setId_proveedor(8);
        $resultado = $this->modelo->restablecerProveedor();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
