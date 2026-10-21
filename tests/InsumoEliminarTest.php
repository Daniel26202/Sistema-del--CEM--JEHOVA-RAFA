<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInsumo;
use App\modelos\Db;

class InsumoEliminarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $nombre = "Insumo Prueba";

    protected function setUp(): void
    {
        $this->modelo = new ModeloInsumo();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        $this->limpiar();
        $this->cerrarSesionDePrueba();
    }

    private function limpiar(): void
    {
        $filas = $this->db->query("SELECT id_insumo FROM bd.insumo WHERE nombre = '{$this->nombre}'")->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($filas as $idInsumo) {
            $idInsumo = (int)$idInsumo;
            $idsEntrada = $this->db->query("SELECT id_entrada FROM bd.entrada_insumo WHERE id_insumo = {$idInsumo}")->fetchAll(\PDO::FETCH_COLUMN);
            $this->db->exec("DELETE FROM bd.entrada_insumo WHERE id_insumo = {$idInsumo}");
            if ($idsEntrada) {
                $lista = implode(',', array_map('intval', $idsEntrada));
                $this->db->exec("DELETE FROM bd.entrada WHERE id_entrada IN ({$lista})");
            }
            $this->db->exec("DELETE FROM bd.insumo WHERE id_insumo = {$idInsumo}");
        }
    }

    private function crearInsumo(): int
    {
        $this->limpiar();
        $m = new ModeloInsumo();
        $m->setNombre($this->nombre);
        $m->setIdProveedor(6);
        $m->setDescripcion("descripcion prueba de insumo");
        $m->setFechaDeIngreso(date("Y-m-d"));
        $m->setFechaDeVencimiento("2027-12-31");
        $m->setPrecio(10);
        $m->setCantidad(50);
        $m->setStockMinimo(5);
        $m->setLote(12345);
        $m->setMarca("MarcaX");
        $m->setMedida("100 g");
        $m->setIva(0);
        $m->setImagen("insumo_default.png");
        $m->guardarInsumo(1);

        $fila = $this->db->query("SELECT id_insumo FROM bd.insumo WHERE nombre = '{$this->nombre}' ORDER BY id_insumo DESC LIMIT 1")->fetch(\PDO::FETCH_ASSOC);
        return (int)$fila['id_insumo'];
    }

    public function testEliminarInsumos()
    {
        $idInsumo = $this->crearInsumo();

        $this->modelo->setIdInsumo($idInsumo);
        $resultado = $this->modelo->eliminarInsumo(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
