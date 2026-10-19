<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPacientes;
use App\modelos\Db;

class PacienteEliminarTest extends TestCase
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

    public function testEliminarPaciente()
    {
        // Se crea un paciente propio para eliminarlo sin afectar datos reales
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912343");
        $this->modelo->setNombre("Pedro");
        $this->modelo->setApellido("Perez");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $this->modelo->guardarPaciente(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'paciente', 'id_paciente');

        // Ahora se elimina lógicamente el registro recién creado
        $this->modelo = new ModeloPacientes();
        $this->modelo->setIdPaciente($this->idCreado);
        $resultado = $this->modelo->eliminarPaciente(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
