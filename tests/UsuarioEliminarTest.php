<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloUsuarios;
use App\modelos\Db;

class UsuarioEliminarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;
    private $usuarioNombre = "UsrPrueba002";

    protected function setUp(): void
    {
        $this->modelo = new ModeloUsuarios();
        $this->db = (new Db())->connectionSegurity();
        $this->iniciarSesionDePrueba();

        // Se crea un usuario de prueba directamente en segurity
        $stmt = $this->db->prepare("INSERT INTO usuario (id_rol, imagen, usuario, correo, password, estado) VALUES (11, 'doctor.png', :usuario, 'usrprueba2@test.com', 'x', 'ACT')");
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

    public function testEliminarUsuario()
    {
        $this->modelo->setIdUsuario($this->idCreado);
        $resultado = $this->modelo->eliminarUsuario(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
