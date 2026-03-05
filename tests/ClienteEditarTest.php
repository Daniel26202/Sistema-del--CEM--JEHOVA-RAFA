<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;

class ClienteEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
    }

    public function testEditarCliente()
    {
        $this->modelo->setId_cliente(2);
        $this->modelo->setTipo_identificacion("V");
        $this->modelo->setNumero_identificacion(2000002);
        $this->modelo->setNombre("Editado");
        $this->modelo->setApellido("Modificado");
        $this->modelo->setTelefono("04123454320");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFecha_nacimiento("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->update();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
