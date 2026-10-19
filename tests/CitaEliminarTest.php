<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCita;
use App\modelos\Db;

class CitaEliminarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCita();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'cita', 'id_cita', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testEliminarCita()
    {
        // Se crea una cita propia para no alterar los datos existentes
        $stmt = $this->db->prepare("INSERT INTO bd.cita (fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor)
            VALUES (CURRENT_DATE, '23:00', 'Pendiente', 23, 25, '23:59', 21)");
        $stmt->execute();
        $this->idCreado = (int)$this->db->lastInsertId();

        $this->modelo->setIdCita($this->idCreado);
        $resultado = $this->modelo->eliminarCitaPublic(1);

        $this->assertEquals("exito", $resultado[0]);

        // La cita quedó con estado DES (borrado lógico aplicado por el modelo)
        $stmt = $this->db->query("SELECT estado FROM bd.cita WHERE id_cita = " . (int)$this->idCreado);
        $this->assertEquals('DES', $stmt->fetch(\PDO::FETCH_ASSOC)['estado']);
    }
}
