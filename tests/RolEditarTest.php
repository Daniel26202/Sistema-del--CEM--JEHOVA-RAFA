<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRoles;
use App\modelos\Db;

class RolEditarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
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

    public function testEditarRolExitoso()
    {
        // Se crea un rol propio para poder editarlo sin afectar datos reales
        $this->modelo->setNombre("RolPrueba");
        $this->modelo->setDescripcion("Descripcion desde el test");
        $this->modelo->setModulos(["Usuarios", "Roles"]);
        $this->modelo->setPermisos([
            "Usuarios" => [30, 31, 32],
            "Roles"    => [30, 31]
        ]);
        $this->modelo->guardarRol(1);
        $this->idCreado = $this->ultimoIdGenerado('segurity', 'rol', 'id_rol');

        // Ahora se edita el rol recién creado
        $this->modelo = new ModeloRoles();
        $this->modelo->setIdRol($this->idCreado);
        $this->modelo->setNombre("RolEditado");
        $this->modelo->setDescripcion("Descripcion editada del rol");
        $this->modelo->setModulos(["Usuarios", "Roles"]);
        $this->modelo->setPermisos([
            "Usuarios" => [30, 31],
            "Roles"    => [30]
        ]);

        $resultado = $this->modelo->editarRol(1);

        $this->assertEquals(["exito"], $resultado);
    }
}
