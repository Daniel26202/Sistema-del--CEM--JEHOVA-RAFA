<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;
use App\modelos\ModeloEntrada;
use App\modelos\ModeloInsumo;

class InventarioLotesTest extends TestCase
{
    use Tests\TestHelpers;

    private $db;
    private $idInsumo;
    private $nombre;

    protected function setUp(): void
    {
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
        $this->nombre = 'Qainsumo' . $this->tokenAlfabetico(8);

        $insumo = new ModeloInsumo();
        $insumo->setNombre($this->nombre);
        $insumo->setIdProveedor($this->idProveedorActivo());
        $insumo->setDescripcion('Insumo de prueba');
        $insumo->setFechaDeIngreso(date('Y-m-d'));
        $insumo->setFechaDeVencimiento(date('Y-m-d', strtotime('+30 days')));
        $insumo->setPrecio(10);
        $insumo->setCantidad(10);
        $insumo->setStockMinimo(1);
        $insumo->setLote((string)random_int(100000000, 999999999));
        $insumo->setMarca('QaMarca');
        $insumo->setMedida('1 g');
        $insumo->setIva(0);
        $insumo->setImagen('insumo_default.png');

        $resultado = $insumo->guardarInsumo(1);
        $this->assertSame('exito', $resultado[0] ?? null, json_encode($resultado));

        $stmt = $this->db->prepare('SELECT id_insumo FROM bd.insumo WHERE nombre = :nombre');
        $stmt->execute(['nombre' => $this->nombre]);
        $this->idInsumo = (int)$stmt->fetchColumn();
        $this->assertGreaterThan(0, $this->idInsumo, 'Debe existir el insumo sintético.');
    }

    protected function tearDown(): void
    {
        if ($this->idInsumo) {
            $stmt = $this->db->prepare('SELECT id_entrada FROM bd.entrada_insumo WHERE id_insumo = :id_insumo');
            $stmt->execute(['id_insumo' => $this->idInsumo]);
            $idsEntrada = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));

            $stmt = $this->db->prepare('DELETE FROM bd.entrada_insumo WHERE id_insumo = :id_insumo');
            $stmt->execute(['id_insumo' => $this->idInsumo]);
            if ($idsEntrada) {
                $placeholders = implode(',', array_fill(0, count($idsEntrada), '?'));
                $stmt = $this->db->prepare("DELETE FROM bd.entrada WHERE id_entrada IN ({$placeholders})");
                $stmt->execute($idsEntrada);
            }

            $stmt = $this->db->prepare('DELETE FROM bd.insumo WHERE id_insumo = :id_insumo');
            $stmt->execute(['id_insumo' => $this->idInsumo]);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testStockSoloSumaLotesVigentesYActivosYListaVencidos(): void
    {
        $loteVigente = (string)random_int(100000000, 999999999);
        $entrada = new ModeloEntrada();
        $entrada->setIdProveedor($this->idProveedorActivo());
        $entrada->setIdInsumo($this->idInsumo);
        $entrada->setFechaDeIngreso(date('Y-m-d'));
        $entrada->setFechaDeVencimiento(date('Y-m-d', strtotime('+60 days')));
        $entrada->setPrecio(12);
        $entrada->setCantidadDisponible(7);
        $entrada->setLote($loteVigente);
        $resultado = $entrada->guardarEntrada(1);
        $this->assertSame('exito', $resultado[0] ?? null, json_encode($resultado));

        $loteVencido = (string)random_int(100000000, 999999999);
        $stmt = $this->db->prepare(
            "INSERT INTO bd.entrada (id_proveedor, numero_de_lote, fechaDeIngreso, estado)
             VALUES (:id_proveedor, :lote, :fecha_ingreso, 'ACT')"
        );
        $stmt->execute([
            'id_proveedor' => $this->idProveedorActivo(),
            'lote' => $loteVencido,
            'fecha_ingreso' => date('Y-m-d'),
        ]);
        $idEntradaVencida = (int)$this->db->lastInsertId();

        $stmt = $this->db->prepare(
            'INSERT INTO bd.entrada_insumo
             (id_insumo, id_entrada, fechaDeVencimiento, precio, cantidad_entrante, cantidad_disponible)
             VALUES (:id_insumo, :id_entrada, :vencimiento, 5, 99, 99)'
        );
        $stmt->execute([
            'id_insumo' => $this->idInsumo,
            'id_entrada' => $idEntradaVencida,
            'vencimiento' => date('Y-m-d', strtotime('-1 day')),
        ]);

        $modelo = new ModeloInsumo();
        $inventario = $modelo->insumos();
        $resumen = array_values(array_filter(
            $inventario,
            fn(array $fila): bool => (int)$fila['id_insumo'] === $this->idInsumo
        ));
        $this->assertCount(1, $resumen);
        $this->assertSame(17, (int)$resumen[0]['disponible']);

        $vencidos = $modelo->InsumosVencidos(0, 25, $this->nombre, 'fechaDeVencimiento', 'ASC');
        $coincidencias = array_values(array_filter(
            $vencidos,
            fn(array $fila): bool => (int)$fila['id_insumo_e'] === $this->idInsumo
                && (int)$fila['id_entrada'] === $idEntradaVencida
        ));
        $this->assertCount(1, $coincidencias);

        $stmt = $this->db->prepare("UPDATE bd.entrada SET estado = 'DES' WHERE numero_de_lote = :lote");
        $stmt->execute(['lote' => $loteVigente]);
        $inventario = $modelo->insumos();
        $resumen = array_values(array_filter(
            $inventario,
            fn(array $fila): bool => (int)$fila['id_insumo'] === $this->idInsumo
        ));
        $this->assertCount(1, $resumen);
        $this->assertSame(10, (int)$resumen[0]['disponible']);
    }

    public function testCantidadNegativaEsRechazada(): void
    {
        $modeloInsumo = new ModeloInsumo();
        $this->expectException(InvalidArgumentException::class);
        $modeloInsumo->setCantidad(-1);
    }

    public function testFechaDeVencimientoImposibleEsRechazada(): void
    {
        $entrada = new ModeloEntrada();
        $this->expectException(InvalidArgumentException::class);
        $entrada->setFechaDeVencimiento('2026-02-31');
    }

    private function tokenAlfabetico(int $longitud): string
    {
        $token = '';
        for ($i = 0; $i < $longitud; $i++) {
            $token .= chr(random_int(97, 122));
        }
        return $token;
    }
}
