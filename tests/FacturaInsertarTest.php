<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloFactura;

class FacturaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloFactura();
    }

    public function testInsertarFactura()
    {
        $this->modelo->setFecha("2025-10-02");
        $this->modelo->setTotal(1000);
        $this->modelo->setId_cliente(25);   
        $this->modelo->setId_usuario(25);
        $this->modelo->setId_cita(36);
        $this->modelo->setId_servicio(1);
        $this->modelo->setId_producto([0 => 5]);
        $this->modelo->setCantidad([0 => 25]);
        $this->modelo->setPrecio([0 => 1080]);
        $this->modelo->setId_especialidad([0 => 18]);
        $this->modelo->setDescuento(null);
        $this->modelo->setIva(null);
        $resultado = $this->modelo->insertaFactura();

        $this->assertEquals("exito", $resultado[1]);
    }
}
