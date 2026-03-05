<?php
use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPacientes;

class PacienteInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPacientes();
    }

    public function testInsertarPaciente()
    {
        $this->modelo->setTipo_identificacion("V");
        $this->modelo->setNumero_identificacion(3722999);
        $this->modelo->setNombre("Pedro");
        $this->modelo->setApellido("Perez");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFecha_nacimiento("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->insertar();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}