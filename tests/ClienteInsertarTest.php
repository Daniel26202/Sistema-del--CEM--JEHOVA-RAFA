<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;

class ClienteInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
    }

    public function testInsertarCliente()
    {
        $this->modelo->setTipo_documento("V");
        $this->modelo->setNumero_documento(3722999); 
        $this->modelo->setNombre("Pedro");
        $this->modelo->setApellido("Perez");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFecha_nacimiento("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->insertar();

        $this->assertEquals("exito", $resultado[0]);
    }
}
