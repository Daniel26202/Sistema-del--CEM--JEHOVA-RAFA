<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPacientes;

class PacienteRestablecerTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPacientes();
    }

    public function testRestablecerPaciente()
    {
        $this->modelo->setId_paciente(30);
        $resultado = $this->modelo->restablecer();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
