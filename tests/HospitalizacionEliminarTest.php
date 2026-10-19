<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;
use App\modelos\Db;

class HospitalizacionEliminarTest extends TestCase
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

    public function testEliminarHospitalizacion()
    {
        // Se crea una hospitalización propia para eliminarla sin afectar datos reales
        $idControlAntes = (int)$this->ultimoIdGenerado('bd', 'control', 'id_control');

        $this->modelo->setIdPaciente(25);
        $this->modelo->setIdDoctor(19);
        $this->modelo->setFechaHora(date("Y-m-d H:i:s"));
        $this->modelo->setHistorial("Historial de prueba de hospitalizacion valido");
        $this->modelo->setDiagnostico("Diagnostico de prueba de hospitalizacion");
        $this->modelo->setFechaControl(date("Y-m-d H:i:s"));
        $this->modelo->setSeveridad("LEVE");
        $this->modelo->insertarH();

        $this->idCreado = $this->ultimoIdGenerado('bd', 'hospitalizacion', 'id_hospitalizacion');
        $idControlDespues = (int)$this->ultimoIdGenerado('bd', 'control', 'id_control');
        if ($idControlDespues > $idControlAntes) {
            $this->idControlCreado = $idControlDespues;
        }

        // Ahora se elimina lógicamente la hospitalización recién creada
        $this->modelo = new ModeloHospitalizacion();
        $this->modelo->setIdH((int)$this->idCreado);
        $resultado = $this->modelo->eliminaLogico(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
