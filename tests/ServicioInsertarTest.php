<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloServicios;

class ServicioInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloServicios();
    }

    public function testInsertarServicio()
    {
        $this->modelo->setIdCategoria(9);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(100);
        $resultado = $this->modelo->insertar();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
