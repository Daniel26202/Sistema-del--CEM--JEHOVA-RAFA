<?php
const DEVELOPER_MODE = true;
const ENABLE_REPORTS = true;

const PROJECT_INFO       = ["name" => "Jehova Rafa", "id" => 341];
const PROJECT_ID         = 341;
const TEST_PLAN_INFO     = ['name' => 'Pruebas de integración', 'id' => 681];
const TESTPLAN_ID        = 681;
const TEST_BUILD_INFO    = ["name" => "Pruebas de integracion build", "id" => 1];
const TEST_SUITE_ALFA_INFO = ["name" => "Gestion de pacientes", "id" => 342, "parentId" => 341];

const TESTLINK_URL          = "http://localhost:8080/testlink-1.9.0/testlink-1.9.0/lib/api/xmlrpc.php";
const TESTLINK_USER_API_KEY = "34161aa17e5785c01ed4f8b07556ccf8";
const TESTLINK_API_KEY      = "35ba680c22cfe5ea27b689e765af0e5d65e45567e4b977f8f6e932ac4788c666";

const TEST_LIST = [
    // Pacientes (suite 342)
    ['id' => 359, 'name' => 'Registro de paciente',              'parent_id' => 342],
    ['id' => 353, 'name' => 'Eliminar paciente de manera lógica', 'parent_id' => 342],
    ['id' => 348, 'name' => 'Consultar paciente por cédula',     'parent_id' => 342],
    ['id' => 343, 'name' => 'Modificar paciente',                'parent_id' => 342],

    // Citas (suite 455)
    ['id' => 456, 'name' => 'Registrar cita médica nueva',           'parent_id' => 455],
    ['id' => 463, 'name' => 'Consultar citas médicas por cédula',    'parent_id' => 455],
    ['id' => 475, 'name' => 'Eliminar cita médica de manera lógica', 'parent_id' => 455],

    // Facturación (suite 364)
    ['id' => 365, 'name' => 'Registrar facturación de servicios médicos', 'parent_id' => 364],
    ['id' => 372, 'name' => 'Registrar pago y generar factura completa',  'parent_id' => 364],
    ['id' => 379, 'name' => 'Consultar pago de servicios en facturación', 'parent_id' => 364],
];



// PS C:\xampp\htdocs\Sistema-del--CEM--JEHOVA-RAFA> php scriptTest.php testsuite

//  Begin 

// --- Test Suites (Para Plan ID: 681) ---
// ✅ Test Suite encontrada: ID: **666**, Nombre: **Consulta de estadisticas** (Padre: 341)

// ['name' => 'Consulta de estadisticas', 'id' => 666, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **455**, Nombre: **Gestion de citas** (Padre: 341)

// ['name' => 'Gestion de citas', 'id' => 455, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **385**, Nombre: **Gestion de clientes** (Padre: 341)

// ['name' => 'Gestion de clientes', 'id' => 385, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **506**, Nombre: **Gestion de directorio medico** (Padre: 341)

// ['name' => 'Gestion de directorio medico', 'id' => 506, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **427**, Nombre: **Gestion de facturas** (Padre: 341)

// ['name' => 'Gestion de facturas', 'id' => 427, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **561**, Nombre: **Gestion de insumo (inventario)** (Padre: 341)

// ['name' => 'Gestion de insumo (inventario)', 'id' => 561, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **342**, Nombre: **Gestion de pacientes** (Padre: 341)

// ['name' => 'Gestion de pacientes', 'id' => 342, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **409**, Nombre: **Gestion de patologías** (Padre: 341)

// ['name' => 'Gestion de patologías', 'id' => 409, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **637**, Nombre: **Gestion de reportes** (Padre: 341)

// ['name' => 'Gestion de reportes', 'id' => 637, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **682**, Nombre: **Gestion de usuarios** (Padre: 341)

// ['name' => 'Gestion de usuarios', 'id' => 682, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **585**, Nombre: **Gestion entrada insumos (inventario)** (Padre: 341)

// ['name' => 'Gestion entrada insumos (inventario)', 'id' => 585, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **533**, Nombre: **Gestion hospitalizacion** (Padre: 341)

// ['name' => 'Gestion hospitalizacion', 'id' => 533, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **615**, Nombre: **Gestion proveedores** (Padre: 341)

// ['name' => 'Gestion proveedores', 'id' => 615, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **481**, Nombre: **Gestion servicio medico** (Padre: 341)

// ['name' => 'Gestion servicio medico', 'id' => 481, 'parentId' => 341],
// ✅ Test Suite encontrada: ID: **364**, Nombre: **Gestión de facturación** (Padre: 341)

// ['name' => 'Gestión de facturación', 'id' => 364, 'parentId' => 341],
// PS C:\xampp\htdocs\Sistema-del--CEM--JEHOVA-RAFA> 