<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;
use App\modelos\Db;

class HospitalizacionInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;
    private $idControlCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloHospitalizacion();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'hospitalizacion', 'id_hospitalizacion', $this->idCreado);
        }
        if ($this->idControlCreado !== null) {
            $this->borrarRegistro('bd', 'control', 'id_control', $this->idControlCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarHospitalizacion()
    {
        // paciente 25 y doctor (personal) 19 existen y están activos
        $idControlAntes = (int)$this->ultimoIdGenerado('bd', 'control', 'id_control');

        $this->modelo->setIdPaciente(25);
        $this->modelo->setIdDoctor(19);
        $this->modelo->setFechaHora(date("Y-m-d H:i:s"));
        $this->modelo->setHistorial("Historial de prueba de hospitalizacion valido");
        $this->modelo->setDiagnostico("Diagnostico de prueba de hospitalizacion");
        $this->modelo->setFechaControl(date("Y-m-d H:i:s"));
        $this->modelo->setSeveridad("LEVE");

        $resultado = $this->modelo->insertarH();

        $this->idCreado = $this->ultimoIdGenerado('bd', 'hospitalizacion', 'id_hospitalizacion');

        $idControlDespues = (int)$this->ultimoIdGenerado('bd', 'control', 'id_control');
        if ($idControlDespues > $idControlAntes) {
            $this->idControlCreado = $idControlDespues;
        }

        // insertarH devuelve ["exito", datos]
        $this->assertEquals("exito", $resultado[0]);
    }
}
