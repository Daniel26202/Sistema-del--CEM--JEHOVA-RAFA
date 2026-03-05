<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRoles;

class RolEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloRoles();
    }

    public function testEditarRolExitoso()
    {
        // 1. Preparamos los datos (Asumiendo que existen estos setters en tu modelo)
        $id_existente = 11;
        $this->modelo->setIdRol($id_existente);
        $this->modelo->setNombre("Nombre Editado");
        $this->modelo->setDescripcion("Descripción desde el test");

        // El modelo espera que los módulos sean un array de strings
        $modulos = ["Usuarios", "Roles"];
        $this->modelo->setModulos($modulos);

        // El modelo espera que los permisos sean un array asociativo: ['Modulo' => [id1, id2]]
        $permisos = [
            "Usuarios" => [1, 2, 3], // IDs de los permisos para Usuarios
            "Roles"    => [1, 2]     // IDs de los permisos para Roles
        ];
        $this->modelo->setPermisos($permisos);

        // 2. Ejecutamos el método (que no recibe parámetros)
        $resultado = $this->modelo->editar();

        // 3. Verificamos el resultado
        // Nota: Como tu método devuelve ["exito"] (un array), la aserción debe ser igual
        $this->assertEquals(["exito"], $resultado);
    }
}
