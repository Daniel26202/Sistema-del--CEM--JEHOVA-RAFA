<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;
use App\modelos\Db;

class ProveedorInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloProveedores();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'proveedor', 'id_proveedor', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testProvedorInsertar()
    {
        $this->modelo->setNombre("Carlos");
        $this->modelo->setRif("J122304");
        $this->modelo->setTelefono("04243545561");
        $this->modelo->setEmail("CCC12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $resultado = $this->modelo->guardarEntrada(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'proveedor', 'id_proveedor');

        $this->assertEquals("exito", $resultado[0]);
    }
}
