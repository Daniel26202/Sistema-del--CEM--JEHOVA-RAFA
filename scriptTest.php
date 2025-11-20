<?php
require_once 'vendor/autoload.php';
require_once 'selenium/apiController.php';
require_once 'selenium/user_config.php';
/*
    php scriptTest.php [test1 test2 ...]
    ❌
    ✅
    🔎
*/
define("LIST_TESTS", ["login"]);



echo "\n Begin \n";

$apicontroller = new ApiController();

$listTest = LIST_TESTS;

// IGNORAR DESDE AQUI

    $searchTest = false;

    $list = [];
    if($argc > 1) {
        $searchTest = true;
        foreach ($argv as $elem) {
            $list[] = $elem;
        }
    }
    if(in_array("projects", $list)) {$apicontroller->getProjects(); die;}
    if(in_array("plans", $list)) {$apicontroller->getTestPlans($list[2] ?? PROJECT_ID); die;}
    if(in_array("builds", $list)) {$apicontroller->getBuildsForTestPlan( $list[2] ?? TESTPLAN_ID); die;}
    if(in_array("testsuite", $list)) {$apicontroller->getTestSuitesForTestPlan( $list[2] ??  TESTPLAN_ID); die;}
    if(in_array("testcase", $list)) {$apicontroller->getTestCasesForTestSuite(  $list[2] ?? $apicontroller->testSuiteAlfa['id']); die;}

    $__executeTest = function ($test) use ($searchTest, $list, $listTest) {
        if(!$searchTest ) return true; // si no esta buscando un test especifico, se ejecutan todos
        else{
            if(in_array($test, $list) and in_array($test, $listTest)) return true;
            else return false;
        }
    };

// IGNORAR HASTA AQUI

if($__executeTest("login")) (new LoginSelenium($apicontroller))->testLogin();



echo "\n END \n";














/**
 * devuelve la url por ejemplo 'http://localhost:8081/Sistema-del--CEM--JEHOVA-RAFA' si el parametro esta vacio
 * @param mixed $url agrega al final de la url ej.(Area) http://localhost:8081/Sistema-del--CEM--JEHOVA-RAFA/Area
 * @return string
 */
function url($url='') { return "http://localhost:8081/Sistema-del--CEM--JEHOVA-RAFA/".$url; }