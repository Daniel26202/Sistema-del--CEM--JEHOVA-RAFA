<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCita;

class CitaEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCita();
    }

    public function testEliminarCita()
    {
        $this->modelo->setId_cita(66);
        $resultado = $this->modelo->eliminarCita();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
