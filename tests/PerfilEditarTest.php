<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPerfil;

class PerfilEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPerfil();
    }

    public function testEditarPerfil()
    {
        $resultado = $this->modelo->update(
            47,
            2000002,
            "Editado",
            "Modificado",
            "04123454320",
            "Usuario_123",
            "modificado@gmail.com"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
