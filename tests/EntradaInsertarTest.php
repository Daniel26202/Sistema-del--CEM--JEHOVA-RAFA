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
        $this->modelo->setId_proveedor(6);
        $this->modelo->setFecha_vencimiento("2025-12-31");
        $this->modelo->setCantidad(1);
        $this->modelo->setPrecio(100);
        $this->modelo->setId_producto(44);
        $this->modelo->setFecha_entrada("2025-10-03");
        $this->modelo->setCodigo("12345679");
        $resultado = $this->modelo->insertarEntrada();

        $this->assertEquals("exito", $resultado[0]);
    }
}
