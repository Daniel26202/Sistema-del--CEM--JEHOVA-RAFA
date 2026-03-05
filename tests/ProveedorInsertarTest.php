<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;

class ProveedorInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloProveedores();
    }

    public function testProvedorInsertar()
    {
        $this->modelo->setNombre_proveedor("Carlos");
        $this->modelo->setRif("J122304");
        $this->modelo->setTelefono("0424354556");
        $this->modelo->setCorreo("CCC12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $resultado = $this->modelo->agregar();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
