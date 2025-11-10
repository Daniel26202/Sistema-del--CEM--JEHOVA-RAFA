<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPacientes;

class PacienteEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPacientes();
    }

    public function testEditarPaciente()
    {
        $resultado = $this->modelo->update(
            29,
            "V",
            2000002,
            "Editado",
            "modificado",
            "04123454320",
            "en su casa",
            "2002-02-20",
            "Masculino",
            2000002
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
