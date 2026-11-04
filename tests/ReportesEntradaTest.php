<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;
use App\modelos\ModeloEntrada;

class ReportesEntradaTest extends TestCase
{
    use Tests\TestHelpers;

    private $pdo;
    private $idInsumoPrueba;
    private $lotePrueba;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();

        $this->iniciarSesionDePrueba();
        $this->idInsumoPrueba = $this->idInsumoActivo();
        $this->lotePrueba = (string)random_int(100000000, 999999999);

        $entrada = new ModeloEntrada();
        $entrada->setIdProveedor($this->idProveedorActivo());
        $entrada->setIdInsumo($this->idInsumoPrueba);
        $entrada->setFechaDeIngreso(date('Y-m-d'));
        $entrada->setFechaDeVencimiento(date('Y-m-d', strtotime('+1 year')));
        $entrada->setPrecio(10);
        $entrada->setCantidadDisponible(1);
        $entrada->setLote($this->lotePrueba);
        $resultado = $entrada->guardarEntrada(1);
        $this->assertSame('exito', $resultado[0] ?? null, json_encode($resultado));
    }

    protected function tearDown(): void
    {
        if ($this->lotePrueba !== null) {
            $stmt = $this->pdo->prepare(
                'DELETE ei FROM bd.entrada_insumo ei INNER JOIN bd.entrada e ON e.id_entrada = ei.id_entrada WHERE e.numero_de_lote = :lote'
            );
            $stmt->execute(['lote' => $this->lotePrueba]);
            $stmt = $this->pdo->prepare('DELETE FROM bd.entrada WHERE numero_de_lote = :lote');
            $stmt->execute(['lote' => $this->lotePrueba]);
        }
        $this->cerrarSesionDePrueba();
    }

    // entradas

    public function testConsultarEntrada()
    {
        $desdeFecha = date('Y-01-01');
        $fechaHasta = date('Y-12-31');
        $id_insumo = $this->idInsumoPrueba;

        $consulta = $this->pdo->prepare("SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :desdeFecha AND :fechaHasta AND ei.id_insumo =:id_insumo ORDER BY e.fechaDeIngreso");
        $consulta->bindParam(":id_insumo", $id_insumo);
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN ENTRADAAS DESDE (" . $desdeFecha . " A " . $fechaHasta . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la entrada si exista
        $this->assertNotEmpty($resultado, "Las entradas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  existen en la BD");
    }

    public function testConsultarEntradaInexistente()
    {
        $desdeFecha = "2020-04-10";
        $fechaHasta = "2021-12-10";

        $id_insumo = 2147483647;

        $consulta = $this->pdo->prepare("SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :desdeFecha AND :fechaHasta AND ei.id_insumo =:id_insumo ORDER BY e.fechaDeIngreso");
        $consulta->bindParam(":id_insumo", $id_insumo);
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que no existan entradas en ese rango
        $this->assertEmpty($resultado, "Las entradas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  no existen en la BD");
    }

}
