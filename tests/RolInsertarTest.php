<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRoles;

class RolInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloRoles();
    }

    public function testInsertarRol()
    {

        $this->modelo->setNombre("Nombre");
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

        $resultado = $this->modelo->insertar();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
