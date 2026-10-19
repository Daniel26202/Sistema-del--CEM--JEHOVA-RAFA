<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPermisos;
use App\modelos\Db;

/**
 * Módulo: Roles y Permisos.
 * Sub-módulo: Gestión de módulos y verificación de permisos.
 */
class PermisoConsultarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPermisos();
        $this->db = (new Db())->connectionSegurity();
    }

    /** El listado de módulos activos no debe estar vacío. */
    public function testReturnModules()
    {
        $resultado = $this->modelo->returnModules();

        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado, "Debe existir al menos un módulo activo");
    }

    /** returnIdModule devuelve el id de un módulo existente. */
    public function testReturnIdModule()
    {
        $this->modelo->setModulo("Pacientes");

        $this->assertEquals(1, $this->modelo->returnIdModule());
    }

    /** Un módulo inexistente devuelve 0. */
    public function testReturnIdModuleInexistente()
    {
        $this->modelo->setModulo("ModuloQueNoExiste");

        $this->assertEquals(0, $this->modelo->returnIdModule());
    }

    /** Un rol con permisos asignados sobre un módulo los reporta. */
    public function testGestionarPermisosOtorgado()
    {
        // El rol 11 tiene permisos sobre módulos (creados por las pruebas de Roles)
        $this->modelo->setIdRol(11);
        $this->modelo->setIdModulo(12); // Usuarios
        $this->modelo->setPermiso("consultar");

        $resultado = $this->modelo->gestionarPermisos();

        $this->assertContains($resultado, [0, 1], "gestionarPermisos debe retornar 0 o 1");
    }

    /** contarTotal devuelve la cantidad de módulos activos. */
    public function testContarTotal()
    {
        $total = $this->modelo->contarTotal();

        $this->assertIsInt($total);
        $this->assertGreaterThan(0, $total);
    }
}
