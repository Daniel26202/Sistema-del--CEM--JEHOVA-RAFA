<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloUsuarios;

class UsuarioEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloUsuarios();
    }

    public function testEliminarUsuario()
    {
        $this->modelo->setIdUsuario(50); // Asegúrate de que este ID exista en tu base de datos para que la prueba sea válida
        $resultado = $this->modelo->eliminacionLogica();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
