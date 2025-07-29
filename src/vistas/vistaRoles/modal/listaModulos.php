<?php

//Array de módulos, cada uno con su nombre y el permiso asociado.
$modulos = [
    ["modulo" => "Pacientes", "permisosPorModulo" => "permisosPacientes"],
    ["modulo" => "Patologias", "permisosPorModulo" => "permisosPatologias"],
    ["modulo" => "Factura", "permisosPorModulo" => "permisosFacturas"],
    ["modulo" => "Citas", "permisosPorModulo" => "permisosCitas"],
    ["modulo" => "Consultas", "permisosPorModulo" => "permisosConsultas"],
    ["modulo" => "Doctores", "permisosPorModulo" => "permisosDoctores"],
    ["modulo" => "Control", "permisosPorModulo" => "permisosControles"],
    ["modulo" => "Hospitalizacion", "permisosPorModulo" => "permisosHospitalizaciones"],
    ["modulo" => "Insumos", "permisosPorModulo" => "permisosInsumos"],
    ["modulo" => "Entrada", "permisosPorModulo" => "permisosEntradas"],
    ["modulo" => "Proveedores", "permisosPorModulo" => "permisosProveedores"],
    ["modulo" => "Usuarios", "permisosPorModulo" => "permisosUsuarios"],
    ["modulo" => "Roles", "permisosPorModulo" => "permisosRoles"],
    ["modulo" => "Reportes", "permisosPorModulo" => "permisosReportes"],
    ["modulo" => "Estadisticas", "permisosPorModulo" => "permisosEstadisticas"],
    ["modulo" => "Mantenimiento", "permisosPorModulo" => "permisosMantenimiento"]
];

// Categorías y clasificamos los módulos en ellas.
$clasificacion = [
    "Administración" => ["Usuarios", "Roles", "Mantenimiento"],
    "Gestión Médica" => ["Pacientes", "Patologias", "Citas", "Consultas", "Hospitalizacion", "Doctores", "Control"],
    "Inventario" => ["Insumos", "Entrada",  "Proveedores"],
    "Reportes" => ["Factura", "Reportes", "Estadisticas"]
];

// Inicializamos un array para almacenar los módulos clasificados por categoría.
$categorias = array_fill_keys(array_keys($clasificacion), []);

// Clasificamos los módulos en las categorías correspondientes.
foreach ($modulos as $modulo) {
    foreach ($clasificacion as $categoria => $modulosCategoria) {
        // Si el módulo pertenece a la categoría actual, lo añadimos a esa categoría.
        if (in_array($modulo["modulo"], $modulosCategoria)) {
            $categorias[$categoria][] = $modulo;
            break; // Salimos del bucle interno una vez clasificado.
        }
    }
}

// Imprimimos las categorías con los módulos clasificados.
return $categorias;
