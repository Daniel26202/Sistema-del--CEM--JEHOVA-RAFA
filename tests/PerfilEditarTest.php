<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPerfil;
use App\modelos\Db;

class PerfilEditarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idUsuario = 55;      // usuario de prueba "UsuarioPrueba"
    private $personalOriginal = null;
    private $usuarioOriginal = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPerfil();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba($this->idUsuario);

        // Se guardan los valores originales para restaurarlos al final
        $pdo = $this->db;
        $stmt = $pdo->prepare("SELECT cedula, nombre, apellido, telefono FROM bd.personal WHERE usuario = :id");
        $stmt->execute(['id' => $this->idUsuario]);
        $this->personalOriginal = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT usuario, correo FROM segurity.usuario WHERE id_usuario = :id");
        $stmt->execute(['id' => $this->idUsuario]);
        $this->usuarioOriginal = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    protected function tearDown(): void
    {
        // Restauramos los datos originales del perfil
        if ($this->personalOriginal !== null) {
            $stmt = $this->db->prepare("UPDATE bd.personal SET cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono WHERE usuario = :id");
            $stmt->execute([
                'cedula'   => $this->personalOriginal['cedula'],
                'nombre'   => $this->personalOriginal['nombre'],
                'apellido' => $this->personalOriginal['apellido'],
                'telefono' => $this->personalOriginal['telefono'],
                'id'       => $this->idUsuario,
            ]);
        }
        if ($this->usuarioOriginal !== null) {
            $stmt = $this->db->prepare("UPDATE segurity.usuario SET usuario=:usuario, correo=:correo WHERE id_usuario = :id");
            $stmt->execute([
                'usuario' => $this->usuarioOriginal['usuario'],
                'correo'  => $this->usuarioOriginal['correo'],
                'id'      => $this->idUsuario,
            ]);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testEditarPerfil()
    {
        $this->modelo->setIdUsuario($this->idUsuario);
        $this->modelo->setCedula("30554145");
        $this->modelo->setNombre("Editado");
        $this->modelo->setApellido("Modificado");
        $this->modelo->setTelefono("04123454321");
        $this->modelo->setUsuario($this->usuarioOriginal['usuario']);
        $this->modelo->setCorreo("modificado@gmail.com");

        $resultado = $this->modelo->update_perfil();

        $this->assertEquals("exito", $resultado[0]);
    }
}
