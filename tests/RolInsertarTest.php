<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRoles;
use App\modelos\Db;

class RolInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        // ModeloRoles usa por defecto la conexión a segurity
        $this->modelo = new ModeloRoles();
        $this->db = (new Db())->connectionSegurity();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('segurity', 'permisos_de_rol', 'id_rol', $this->idCreado);
            $this->borrarRegistro('segurity', 'rol', 'id_rol', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarRol()
    {
        $this->modelo->setNombre("RolPrueba");
        $this->modelo->setDescripcion("Descripcion desde el test");
        $this->modelo->setModulos(["Usuarios", "Roles"]);
        $this->modelo->setPermisos([
            "Usuarios" => [30, 31, 32],
            "Roles"    => [30, 31]
        ]);

        $resultado = $this->modelo->guardarRol(1);
        $this->idCreado = $this->ultimoIdGenerado('segurity', 'rol', 'id_rol');

        $this->assertEquals("exito", $resultado[0]);
    }
}
