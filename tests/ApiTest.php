<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloApi;

/**
 * Módulo: API de integración (componente inteligente).
 * Sub-módulo: Consultas clínicas de solo lectura por paciente/usuario.
 */
class ApiTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $pdo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloApi();
        $this->pdo = (new \App\modelos\Db())->connectionSistema();
    }

    /** Un usuario que pertenece al personal del centro es reconocido. */
    public function testEsPersonalDelCentro()
    {
        $fila = $this->pdo->query("SELECT usuario FROM personal WHERE usuario IS NOT NULL LIMIT 1")
            ->fetch(\PDO::FETCH_ASSOC);

        if (!$fila) {
            $this->markTestSkipped('No hay registros de personal para validar.');
        }

        $this->assertTrue(
            $this->modelo->esPersonalDelCentro((int)$fila['usuario']),
            "Un usuario del personal debe ser reconocido"
        );
    }

    /** Un id de usuario inexistente no pertenece al personal del centro. */
    public function testEsPersonalDelCentroInexistente()
    {
        $this->assertFalse($this->modelo->esPersonalDelCentro(999999));
    }

    /** El historial de un paciente real devuelve un arreglo. */
    public function testHistorialDePaciente()
    {
        $idPaciente = $this->pdo->query("SELECT id_paciente FROM paciente LIMIT 1")
            ->fetchColumn();

        if (!$idPaciente) {
            $this->markTestSkipped('No hay pacientes registrados.');
        }

        $resultado = $this->modelo->historialDePaciente((int)$idPaciente);

        $this->assertIsArray($resultado, "El historial debe ser un arreglo");
    }

    /** Las citas de un paciente real devuelven un arreglo. */
    public function testCitasDePaciente()
    {
        $idPaciente = $this->pdo->query("SELECT id_paciente FROM paciente LIMIT 1")
            ->fetchColumn();

        if (!$idPaciente) {
            $this->markTestSkipped('No hay pacientes registrados.');
        }

        $resultado = $this->modelo->citasDePaciente((int)$idPaciente);

        $this->assertIsArray($resultado, "Las citas deben ser un arreglo");
    }

    /** Un paciente inexistente no tiene datos asociados. */
    public function testPacienteDeUsuarioInexistente()
    {
        $this->assertNull($this->modelo->pacienteDeUsuario(999999));
    }
}
