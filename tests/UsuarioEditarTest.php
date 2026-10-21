<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloUsuarios;
use App\modelos\Db;

class UsuarioEditarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;
    private $usuarioNombre = "UsrPrueba001";

    protected function setUp(): void
    {
        $this->modelo = new ModeloUsuarios();
        $this->db = (new Db())->connectionSegurity();
        $this->iniciarSesionDePrueba();

        // Se crea un usuario de prueba directamente en segurity
        $stmt = $this->db->prepare("INSERT INTO usuario (id_rol, imagen, usuario, correo, password, estado) VALUES (11, 'doctor.png', :usuario, 'usrprueba@test.com', 'x', 'ACT')");
        $stmt->execute(['usuario' => $this->usuarioNombre]);
        $this->idCreado = (int)$this->db->lastInsertId();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('segurity', 'usuario', 'id_usuario', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testEditarUsuario()
    {
        $this->modelo->setIdUsuario($this->idCreado);
        $this->modelo->setUsuario("UsrEditado01");
        $this->modelo->setUsuarioRegistrado($this->usuarioNombre);
        $resultado = $this->modelo->editarUsuario(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
