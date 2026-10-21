<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPacientes;
use App\modelos\Db;

class PacienteInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPacientes();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'paciente', 'id_paciente', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarPaciente()
    {
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912341");
        $this->modelo->setNombre("Pedro");
        $this->modelo->setApellido("Perez");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->guardarPaciente(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'paciente', 'id_paciente');

        $this->assertEquals("exito", $resultado[0]);
    }
}
