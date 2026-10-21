<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;
use App\modelos\Db;

class ClienteEliminarTest extends TestCase
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

    public function testEliminarCliente()
    {
        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula("9912346");
        $this->modelo->setNombre("Eliminar");
        $this->modelo->setApellido("Cliente");
        $this->modelo->setTelefono("04123454321");
        $this->modelo->setDireccion("en su casa");
        $this->modelo->setFn("2002-02-20");
        $this->modelo->setGenero("Masculino");
        $this->modelo->guardarCliente(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'cliente', 'id_cliente');

        $this->modelo = new ModeloCliente();
        $this->modelo->setIdCliente($this->idCreado);
        $resultado = $this->modelo->eliminarCliente(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
