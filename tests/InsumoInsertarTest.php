<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInsumo;
use App\modelos\Db;

class InsumoInsertarTest extends TestCase
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
        $fila = $this->db->query("SELECT id_insumo FROM bd.insumo WHERE nombre = '{$this->nombre}'")->fetch(\PDO::FETCH_ASSOC);
        if ($fila) {
            $idInsumo = (int)$fila['id_insumo'];
            $idsEntrada = $this->db->query("SELECT id_entrada FROM bd.entrada_insumo WHERE id_insumo = {$idInsumo}")->fetchAll(\PDO::FETCH_COLUMN);
            $this->db->exec("DELETE FROM bd.entrada_insumo WHERE id_insumo = {$idInsumo}");
            if ($idsEntrada) {
                $lista = implode(',', array_map('intval', $idsEntrada));
                $this->db->exec("DELETE FROM bd.entrada WHERE id_entrada IN ({$lista})");
            }
        }
        $this->db->exec("DELETE FROM bd.insumo WHERE nombre = '{$this->nombre}'");
    }

    public function testInsertarInsumos()
    {
        $this->limpiar();

        $this->modelo->setNombre($this->nombre);
        $this->modelo->setIdProveedor(6);
        $this->modelo->setDescripcion("descripcion prueba de insumo");
        $this->modelo->setFechaDeIngreso(date("Y-m-d"));
        $this->modelo->setFechaDeVencimiento("2027-12-31");
        $this->modelo->setPrecio(10);
        $this->modelo->setCantidad(50);
        $this->modelo->setStockMinimo(5);
        $this->modelo->setLote(12345);
        $this->modelo->setMarca("MarcaX");
        $this->modelo->setMedida("100 g");
        $this->modelo->setIva(0);
        $this->modelo->setImagen("insumo_default.png");

        $resultado = $this->modelo->guardarInsumo(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
