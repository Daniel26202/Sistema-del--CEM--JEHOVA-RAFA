<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;
use App\modelos\Db;

class ClienteInsertarTest extends TestCase
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

    public function testInsertarCliente()
    {
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912347");
        $this->modelo->setNombre("Pedro");
        $this->modelo->setApellido("Perez");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $resultado = $this->modelo->guardarCliente(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'cliente', 'id_cliente');

        $this->assertEquals("exito", $resultado[0]);
    }
}
