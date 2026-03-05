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
        $this->modelo->setId_usuario(47);
        $this->modelo->setCedula("2000002");
        $this->modelo->setNombre("Usuario_123");
        $this->modelo->setApellido("Modificado");
        $this->modelo->setTelefono("04123454320");
        $this->modelo->setUsuario("Usuario_123");
        $this->modelo->setCorreo("modificado@gmail.com");
        
        $resultado = $this->modelo->update();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
