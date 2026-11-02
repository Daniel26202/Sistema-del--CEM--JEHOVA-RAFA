<?php

use App\modelos\ModeloInicio;
use App\modelos\ModeloPermisos;
use PHPUnit\Framework\TestCase;

class DashboardInicioTest extends TestCase
{
    private $sesionAnterior;

    protected function setUp(): void
    {
        $this->sesionAnterior = $_SESSION ?? [];
    }

    protected function tearDown(): void
    {
        $_SESSION = $this->sesionAnterior;
    }

    public function testMedicoSinPermisoDeEstadisticasVeSuAgendaYEspecialidad(): void
    {
        $html = $this->renderDashboard(true, false, true);

        $this->assertStringContainsString('Mi agenda profesional', $html);
        $this->assertStringContainsString('Horario de atención', $html);
        $this->assertStringContainsString('09:00', $html);
        $this->assertStringContainsString('11:30', $html);
        $this->assertStringContainsString('Domingo', $html);
        $this->assertStringContainsString('03/11/2026', $html);
        $this->assertStringContainsString('Medicina', $html);
        $this->assertStringContainsString('data-puede-ver-estadisticas="false"', $html);
        $this->assertStringContainsString('class="row mt-4 d-none"', $html);
    }

    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    #[\PHPUnit\Framework\Attributes\PreserveGlobalState(false)]
    public function testPersonalSinPermisoDeEstadisticasVeSuPerfilSinCalendarioGlobal(): void
    {
        $html = $this->renderDashboard(false, false, false);

        $this->assertStringContainsString('Ver mi perfil', $html);
        $this->assertStringContainsString('Tu espacio de trabajo', $html);
        $this->assertStringContainsString('Accesos disponibles', $html);
        $this->assertStringContainsString('id="menuPacientes"', $html);
        $this->assertStringNotContainsString('id="menuCitas"', $html);
        $this->assertStringNotContainsString('Mi agenda profesional', $html);
        $this->assertStringContainsString('data-mostrar-calendario="false"', $html);
    }

    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    #[\PHPUnit\Framework\Attributes\PreserveGlobalState(false)]
    public function testMenuMuestraCadaModuloSoloConPermisoDeConsulta(): void
    {
        $html = $this->renderDashboard(false, false, false, ['Entrada']);

        $this->assertStringContainsString('id="collapseInsumos"', $html);
        $this->assertStringContainsString('/Entrada/entrada', $html);
        $this->assertStringNotContainsString('/Insumos/insumos', $html);
        $this->assertStringNotContainsString('id="menuPacientes"', $html);
    }

    public function testUsuarioConPermisoConservaLosWidgetsEstadisticos(): void
    {
        $html = $this->renderDashboard(false, true, true);

        $this->assertStringContainsString('id="grafica1"', $html);
        $this->assertStringContainsString('id="citasPendentes"', $html);
        $this->assertStringNotContainsString('Tu espacio de trabajo', $html);
    }

    public function testAgendaPersonalFiltraPorIdDelProfesionalYNoDevuelveNombreDelPaciente(): void
    {
        $modelo = new DashboardModeloInicioTestDouble();
        $modelo->obtenerAgendaPersonal(42);

        $this->assertSame(['id_personal' => 42], $modelo->paramsCapturados);
        $this->assertStringContainsString('WHERE c.doctor = :id_personal', $modelo->getSQL());
        $this->assertStringContainsString('p.estado = \'ACT\'', $modelo->getSQL());
        $this->assertStringNotContainsString('p.nombre', $modelo->getSQL());
    }

    public function testHorarioSemanalSeLimitaAlDoctorYUsaLaAsignacionMasReciente(): void
    {
        $modelo = new DashboardModeloInicioTestDouble();
        $modelo->obtenerHorarioSemanal(42);

        $this->assertSame(['id_personal' => 42], $modelo->paramsCapturados);
        $this->assertStringContainsString('hyd.id_personal = :id_personal', $modelo->getSQL());
        $this->assertStringContainsString('NOT EXISTS', $modelo->getSQL());
        $this->assertStringContainsString('hyd_reciente.id_horarioydoctor > hyd.id_horarioydoctor', $modelo->getSQL());
    }

    public function testPermisosRetornaSoloNombresDeModulos(): void
    {
        $modelo = new DashboardModeloPermisosTestDouble();
        $modelo->setIdRol('2');
        $modulos = $modelo->modulosConPermiso('consultar');

        $this->assertSame(['Pacientes', 'Citas'], $modulos);
        $this->assertSame(['id_rol' => 2, 'permiso' => 'consultar'], $modelo->paramsCapturados);
    }

    private function renderDashboard(bool $esDoctor, bool $verEstadisticas, bool $consultarCitas, ?array $permisosMenu = null): string
    {
        $_SESSION = [
            'usuario' => 'usuario-prueba',
            'id_rol' => 2,
            'rol' => $esDoctor ? 'doctor' : 'personal',
            'nombre' => 'Usuario',
            'apellido' => 'Prueba',
            'id_personal' => $esDoctor ? 18 : 19,
            'id_usuario' => $esDoctor ? 1 : 2,
            'csrf_token' => 'token-prueba',
        ];

        $parametro = [];
        $urlBase = '';
        $ayuda = 'btnayudaInicio';
        $vistaActiva = 'inicio';
        $validarCargo = $esDoctor;
        $puedeVerEstadisticas = $verEstadisticas;
        $puedeConsultarCitas = $consultarCitas;
        $puedeMostrarCalendario = $verEstadisticas || ($esDoctor && $consultarCitas);
        $modulosAutorizados = $permisosMenu
            ?? ($verEstadisticas ? ['Estadisticas'] : ($consultarCitas ? ['Citas'] : ['Pacientes']));
        $idPersonalCalendario = $esDoctor ? 'doctorhash' : '';
        $agendaPersonal = $esDoctor && $consultarCitas
            ? [['fecha' => '2026-11-03', 'hora' => '09:00:00', 'categoria' => 'Consulta']]
            : [];
        $horarioSemanal = $esDoctor
            ? [
                ['diaslaborables' => 'lunes', 'horaDeEntrada' => '09:00:00', 'horaDeSalida' => '17:00:00'],
                ['diaslaborables' => 'miércoles', 'horaDeEntrada' => '11:30:00', 'horaDeSalida' => '17:30:00'],
            ]
            : [];
        $datos_de_personal = [[
            'nacionalidad' => 'V',
            'cedula' => '123',
            'nombre' => 'Usuario',
            'apellido' => 'Prueba',
            'telefono' => '5550000',
            'especialidad_nombre' => $esDoctor ? 'Medicina' : null,
            'id_usuario' => $esDoctor ? 1 : 2,
            'imagen' => 'doctor.png',
        ]];

        ob_start();
        include dirname(__DIR__) . '/src/vistas/dashboard.php';
        return ob_get_clean();
    }
}

class DashboardModeloInicioTestDouble extends ModeloInicio
{
    public $paramsCapturados = [];

    public function __construct()
    {
    }

    protected function search($params, $all = true)
    {
        $this->paramsCapturados = $params;
        return [];
    }

    protected function read($all = true)
    {
        return ['total' => 0];
    }
}

class DashboardModeloPermisosTestDouble extends ModeloPermisos
{
    public $paramsCapturados = [];

    public function __construct()
    {
        parent::__construct(false);
    }

    protected function search($params, $all = true)
    {
        $this->paramsCapturados = $params;
        return [
            ['nombre' => 'Pacientes'],
            ['nombre' => 'Citas'],
        ];
    }
}
