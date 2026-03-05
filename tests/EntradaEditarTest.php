<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;

class EntradaEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
    }

    public function testEditarEntrada()
    {
        $this->modelo->setId_entrada(75);
        $this->modelo->setId_proveedor(6);
        $this->modelo->setFecha_vencimiento("2025-12-29");
        $this->modelo->setCantidad(1);
        $this->modelo->setPrecio(100);
        $this->modelo->setId_producto(46);
        $resultado = $this->modelo->actualizarEntrada();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
