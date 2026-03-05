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
        $this->modelo->setId_proveedor(8);
        $this->modelo->setNombre_proveedor("Luis Empresa");
        $this->modelo->setRif("J122334");
        $this->modelo->setTelefono("0424354556");
        $this->modelo->setCorreo("luis12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $resultado = $this->modelo->editar();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
