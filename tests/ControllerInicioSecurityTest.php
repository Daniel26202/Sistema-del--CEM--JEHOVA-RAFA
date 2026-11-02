<?php

use App\modelos\ModeloDoctores;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/src/controllers/ControllerInicio.php';

class ControllerInicioSecurityTest extends TestCase
{
    private $sesionAnterior;

    protected function setUp(): void
    {
        $this->sesionAnterior = $_SESSION ?? [];
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = $this->sesionAnterior;
    }

    public function testDoctorListRejectsUnauthenticatedRequests(): void
    {
        $statusAnterior = http_response_code();
        ob_start();
        try {
            retornarDoctores();
            $respuesta = ob_get_contents();
            $statusRespuesta = http_response_code();
        } finally {
            ob_end_clean();
            if ($statusAnterior !== false) {
                http_response_code($statusAnterior);
            }
        }

        $this->assertSame(403, $statusRespuesta);
        $this->assertSame(
            ['ok' => false, 'error' => 'No tiene permiso para consultar esta información.'],
            json_decode($respuesta, true)
        );
    }

    public function testStatisticsPermissionRequiresAnAuthenticatedUserId(): void
    {
        $_SESSION = ['id_rol' => 2];

        $this->assertFalse(inicioTienePermiso('Estadisticas'));
    }

    public function testStatisticsDoctorQuerySelectsOnlyPublicFields(): void
    {
        $modelo = new class extends ModeloDoctores {
            public $sqlCapturado;

            public function __construct()
            {
            }

            protected function read($all = true)
            {
                $this->sqlCapturado = $this->getSQL();
                return [['id_personal' => 12, 'nombre_d' => 'Ana', 'apellido' => 'Prueba']];
            }
        };

        $doctores = $modelo->selectDoctoresParaEstadisticas();

        $this->assertSame(
            [['id_personal' => 12, 'nombre_d' => 'Ana', 'apellido' => 'Prueba']],
            $doctores
        );
        $this->assertStringNotContainsString('password', strtolower($modelo->sqlCapturado));
        $this->assertStringNotContainsString('correo', strtolower($modelo->sqlCapturado));
        $this->assertStringNotContainsString('cedula', strtolower($modelo->sqlCapturado));
    }
}
