<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRecuperarContr;

/**
 * Módulo: Recuperar contraseña.
 * Sub-módulo: Validación de usuario/correo y actualización de la clave.
 */
class RecuperarContrTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloRecuperarContr();
    }

    /** Un usuario/correo existente se valida correctamente. */
    public function testValidarUsuarioCorreoExistente()
    {
        // Toma un usuario real activo con correo registrado.
        $pdo = (new \App\modelos\Db())->connectionSegurity();
        $fila = $pdo->query("SELECT usuario, correo FROM usuario WHERE estado='ACT' AND correo IS NOT NULL AND correo <> '' LIMIT 1")
            ->fetch(\PDO::FETCH_ASSOC);

        if (!$fila) {
            $this->markTestSkipped('No hay usuarios activos con correo para validar.');
        }

        $this->modelo->setUsuario($fila['usuario']);
        $this->modelo->setCorreo($fila['correo']);
        $resultado = $this->modelo->validarUC();

        $this->assertIsArray($resultado, "La validación debe devolver el registro encontrado");
        $this->assertNotEmpty($resultado);
    }

    /** Un correo mal formado es rechazado por el setter. */
    public function testSetCorreoInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->modelo->setCorreo('correo-invalido');
    }

    /** Un usuario con formato inválido es rechazado por el setter. */
    public function testSetUsuarioInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->modelo->setUsuario('ab');
    }

    /** Un id de usuario no numérico es rechazado por el setter. */
    public function testSetIdUsuarioInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->modelo->setIdUsuario('cero');
    }

    /** Un id de usuario igual a cero es rechazado por el setter. */
    public function testSetIdUsuarioCero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->modelo->setIdUsuario(0);
    }
}
