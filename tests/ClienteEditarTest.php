<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;
use App\modelos\Db;

class ClienteEditarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'cliente', 'id_cliente', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testEditarCliente()
    {
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912345");
        $this->modelo->setNombre("Editado");
        $this->modelo->setApellido("Modificado");
        $this->modelo->setTelefono("04123454320");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $this->modelo->guardarCliente(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'cliente', 'id_cliente');

        // Ahora se edita el registro recién creado
        $this->modelo = new ModeloCliente();
        $this->modelo->setIdCliente($this->idCreado);
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912345");
        $this->modelo->setCedulaRegistrada("9912345");
        $this->modelo->setNombre("Editadoss");
        $this->modelo->setApellido("Modificados");
        $this->modelo->setTelefono("04123454320");
        $this->modelo->setDireccion("en su casa editada");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->editarCliente(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
