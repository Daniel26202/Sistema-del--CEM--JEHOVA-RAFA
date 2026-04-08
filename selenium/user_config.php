<?php
// En este archivo pueden sobrescribir las constantes definidas en config.php
// Deben borrar la extension .example para que funcione (es decir, debe quedar user_config.php)
const DEVELOPER_MODE = true;


const TEST_LIST = [
    [ 'id' => 109, 'name' => 'Registrar pago y generar factura completa', 'parent_id' => 108 ],
    [ 'id' => 117, 'name' => 'Registrar facturación de servicios médicos', 'parent_id' => 108 ],
    [ 'id' => 130, 'name' => 'Consultar información de pago antes de registro', 'parent_id' => 108 ],     
    [ 'id' => 124, 'name' => 'Consultar pago de servicios en facturación', 'parent_id' => 108 ],
];
const ENABLE_REPORTS = true;
const PROJECT_INFO = ["name" => "jftest", "id" => 1];
const TEST_SUITE_ALFA_INFO = ["name" => "TSAL01 - Pruebas Alfa Sistema de Gestión", "id" => 255, "parentId" => 1];
const TEST_PLAN_INFO = ['name' => 'Testeo', 'id' => 9];
const PROJECT_ID = 1;
const TESTPLAN_ID = 9;

const TEST_BUILD_INFO = ["name" => "DSG-V1", "id" => 2];



const TESTLINK_URL = "http://localhost/testlink20/lib/api/xmlrpc/v1/xmlrpc.php";
const TESTLINK_USER_API_KEY = "7fb692eba8ef73f3bbd9767fc7bb62f5";
const TESTLINK_API_KEY = "35ba680c22cfe5ea27b689e765af0e5d65e45567e4b977f8f6e932ac4788c666";

