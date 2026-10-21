<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloBitacora;

/**
 * Módulo: Bitácora.
 * Sub-módulo: Registro y consulta de la actividad de los usuarios.
 */
class BitacoraTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloBitacora();
    }

    protected function tearDown(): void
    {
        $this->cerrarSesionDePrueba();
    }

    /** La consulta general devuelve un arreglo paginado. */
    public function testConsultarBitacoraGeneral()
    {
        $resultado = $this->modelo->consultarBitacora(null, 0, 10);

        $this->assertIsArray($resultado, "La bitácora general debe devolver un arreglo");
    }

    /** La consulta de un usuario real filtra por su id. */
    public function testConsultarBitacoraPorUsuario()
    {
        $resultado = $this->modelo->consultarBitacora(self::$idUsuarioPrueba, 0, 10);

        $this->assertIsArray($resultado, "La bitácora por usuario debe devolver un arreglo");
    }

    /** El conteo total es un entero no negativo. */
    public function testContarTotalBitacora()
    {
        $total = $this->modelo->contarTotalBitacora(null);

        $this->assertIsInt($total, "El total debe ser un entero");
        $this->assertGreaterThanOrEqual(0, $total);
    }

    /** Se puede registrar una actividad real del usuario autenticado. */
    public function testInsertarBitacora()
    {
        $idRegistro = $this->ultimoIdGenerado('segurity', 'bitacora', 'id_bitacora');

        $this->modelo->setTabla('paciente');
        $this->modelo->setActividad('Prueba unitaria: consulta del módulo de pacientes');
        $resultado = $this->modelo->insertarBitacora(self::$idUsuarioPrueba);

        $this->assertIsArray($resultado, "El registro en bitácora debe ser exitoso");
        $this->assertEquals('exito', $resultado[0]);

        // Limpieza: elimina el registro creado por la prueba.
        $nuevoId = $this->ultimoIdGenerado('segurity', 'bitacora', 'id_bitacora');
        if ($nuevoId !== null && $nuevoId !== $idRegistro) {
            $this->borrarRegistro('segurity', 'bitacora', 'id_bitacora', $nuevoId);
        }
    }

    /** No se permite registrar una actividad vacía. */
    public function testInsertarBitacoraCamposVacios()
    {
        $this->modelo->setTabla('');
        $this->modelo->setActividad('');

        $this->expectException(\Exception::class);
        $this->modelo->insertarBitacora(self::$idUsuarioPrueba);
    }

    /** El setter de usuario rechaza identificadores inválidos. */
    public function testSetIdUsuarioInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->modelo->setId_usuario('abc');
    }
}
