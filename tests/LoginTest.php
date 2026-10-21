<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInicioSesion;

/**
 * Módulo: Autenticación de Usuario.
 * Sub-módulo: Iniciar sesión.
 *
 * Cubre la validación de credenciales contra la base de datos real
 * (segurity.usuario + bd.personal + segurity.rol).
 */
class LoginTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloInicioSesion();
    }

    /** El usuario existe y su contraseña es correcta. */
    public function testLoginValido()
    {
        $this->modelo->setUsuario("WDaniel123");
        $this->modelo->setPassword("Sistema.30");

        $resultado = $this->modelo->validarIniciarSesion();

        $this->assertIsArray($resultado, "El login válido debe retornar los datos del usuario");
        $this->assertArrayHasKey('id_usuario', $resultado);
        $this->assertArrayHasKey('id_rol', $resultado);
    }

    /** La contraseña es incorrecta para un usuario existente. */
    public function testLoginPasswordIncorrecta()
    {
        $this->modelo->setUsuario("WDaniel123");
        $this->modelo->setPassword("claveIncorrecta123");

        $resultado = $this->modelo->validarIniciarSesion();

        $this->assertFalse($resultado, "Una contraseña incorrecta no debe permitir el acceso");
    }

    /** El usuario no existe en el sistema. */
    public function testLoginUsuarioInexistente()
    {
        $this->modelo->setUsuario("usuarioQueNoExiste999");
        $this->modelo->setPassword("cualquiera");

        $resultado = $this->modelo->validarIniciarSesion();

        $this->assertFalse($resultado, "Un usuario inexistente no debe permitir el acceso");
    }

    /** validarUsuarioExistente devuelve el registro cuando existe. */
    public function testValidarUsuarioExistente()
    {
        $this->modelo->setUsuario("WDaniel123");

        $resultado = $this->modelo->validarUsuarioExistente();

        $this->assertIsArray($resultado);
        $this->assertEquals("WDaniel123", $resultado['usuario']);
    }
}
