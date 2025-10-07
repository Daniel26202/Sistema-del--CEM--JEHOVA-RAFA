<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloRoles;

class RolEdiatarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloRoles();
    }

    public function testEditarRol()
    {
        $resultado = $this->modelo->editar(
            11,
            "Nombree",
            "es un nombre al editar",
            [
                "Usuarios",
                "Roles",
                "Mantenimiento",
                "Pacientes",
                "Patologias",
                "Citas",
                "Consultas",
                "Doctores",
                "Control",
                "Hospitalizacion",
                "Insumos",
                "Entrada",
                "Proveedores",
                "Factura",
                "Reportes",
                "Estadisticas"
            ],
            [
                "permisosUsuarios",
                "permisosRoles",
                "permisosMantenimiento",
                "permisosPacientes",
                "permisosPatologias",
                "permisosCitas",
                "permisosConsultas",
                "permisosDoctores",
                "permisosControles",
                "permisosHospitalizaciones",
                "permisosInsumos",
                "permisosEntradas",
                "permisosProveedores",
                "permisosFacturas",
                "permisosReportes",
                "permisosEstadisticas"
            ]

        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
