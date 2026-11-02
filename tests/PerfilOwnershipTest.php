<?php

use App\modelos\ModeloPerfil;
use PHPUnit\Framework\TestCase;

class PerfilOwnershipTest extends TestCase
{
    private $sesionAnterior;

    protected function setUp(): void
    {
        $this->sesionAnterior = $_SESSION ?? [];
        $_SESSION = ['id_usuario' => 10];
    }

    protected function tearDown(): void
    {
        $_SESSION = $this->sesionAnterior;
    }

    public function testWebProfileUpdateRejectsAnotherUsersIdBeforeDatabaseAccess(): void
    {
        $modelo = $this->modeloSinConexion();
        $modelo->setIdUsuario(11);

        $resultado = $modelo->update_perfil();

        $this->assertSame(
            'No se puede modificar un perfil distinto al usuario autenticado.',
            $resultado
        );
    }

    public function testMobileProfileUpdateRejectsAnotherUsersIdBeforeDatabaseAccess(): void
    {
        $modelo = $this->modeloSinConexion();
        $modelo->setIdUsuario(11);

        $resultado = $modelo->update_perfil_apk();

        $this->assertSame(
            'No se puede modificar un perfil distinto al usuario autenticado.',
            $resultado
        );
    }

    private function modeloSinConexion(): ModeloPerfil
    {
        $reflexion = new ReflectionClass(ModeloPerfil::class);
        return $reflexion->newInstanceWithoutConstructor();
    }
}
