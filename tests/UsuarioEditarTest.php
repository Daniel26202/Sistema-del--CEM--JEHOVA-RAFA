<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloUsuarios;

class UsuarioEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloUsuarios();
    }

    public function testEditarUsuario()
    {
        $this->modelo->setIdUsuario(1); // Asegúrate de que este ID exista en tu base de datos para que la prueba sea válida
        $this->modelo->setNombre("Pedro123");
        $this->modelo->setEdad(50);
        $this->modelo->setImagen("imagen1.png");
        $resultado = $this->modelo->updateUsuario();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
