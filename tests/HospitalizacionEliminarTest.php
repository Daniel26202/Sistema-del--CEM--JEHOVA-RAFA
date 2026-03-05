<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;

class HospitalizacionEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloHospitalizacion();
    }

    public function testEliminarHospitalizacion()
    {
        $this->modelo->setId_hospitalizacion(28);
        $this->modelo->setEstado(false);
        $resultado = $this->modelo->eliminaLogico() ;
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
