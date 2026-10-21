<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;
use App\modelos\Db;

class ProveedorEditarTest extends TestCase
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

    public function testProvedorEditar()
    {
        // Se crea un proveedor propio para poder editarlo sin afectar datos reales
        $this->modelo->setNombre("Carlos");
        $this->modelo->setRif("J122305");
        $this->modelo->setTelefono("04243545561");
        $this->modelo->setEmail("CCC12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $this->modelo->guardarEntrada(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'proveedor', 'id_proveedor');

        // Ahora se edita el registro recién creado
        $this->modelo = new ModeloProveedores();
        $this->modelo->setIdProveedor($this->idCreado);
        $this->modelo->setNombre("Luis Empresa");
        $this->modelo->setRif("J122305");
        $this->modelo->setRifRegistrado("J122305");
        $this->modelo->setTelefono("04243545561");
        $this->modelo->setEmail("luis12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $resultado = $this->modelo->editarEntrada(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
