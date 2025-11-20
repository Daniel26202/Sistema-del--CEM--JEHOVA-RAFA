<?php 
use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Response;
use PhpXmlRpc\Value;
use function PHPUnit\Framework\arrayHasKey;

// api de testlink
/*
 php scriptTest.php
 */



class ApiController
{

    const Pass = 'p';
    const Fail = 'f';
    private $client;
    private $apiKey;
    private $userApiKey;
    public $projectInfo;
    public $testPlan;
    public $testBuild;
    public $testSuiteAlfa;
    public $testCases;
    public function __construct()
    {
        $this->projectInfo = PROJECT_INFO;
        $this->testPlan = TEST_PLAN_INFO;
        $this->testBuild = TEST_BUILD_INFO;
        $this->testSuiteAlfa = TEST_SUITE_ALFA_INFO;

        $this->testCases = TEST_LIST;



        $testlinkUrl = TESTLINK_URL;
        $this->userApiKey = TESTLINK_USER_API_KEY;
        $this->apiKey = TESTLINK_API_KEY;
        if(ENABLE_REPORTS){
            $this->client = new Client($testlinkUrl);
        }
        $this->buildName = "dsg";
    }
    /**
     * Reports a result for a single test case for Testlink
     * @param int|string $testCase id del testcase | nombre del testcase
     * @param 'p'|'f' $status 'p' or 'f'
     * @param array {step_number:int, result:'p'|'f', notes:string} $steps array de los pasos
     * @param mixed $duration string in seconds
     * @param string $testSuite Opcional nombre del testsuite
     * @throws \Exception
     * @return bool
     */
    public function reportTest(int|string $testCase, string $status, array $steps, $duration = null, string $testSuite = null, $notes = null ){
        if(ENABLE_REPORTS == false) return true;
        $ok = true;
        try {
            if( is_string($testCase) && is_string($testSuite) ){
                $testCase = $this->getTestCaseIdByName($testSuite,$testCase);
                if(is_array($testCase) and arrayHasKey('id', $testCase)){
                    $testCase = $testCase['id'];
                }
                else{
                    throw new Exception("No se pudo obtener el testCase", 1);
                }
            }
            else if(is_string($testCase) and !preg_match("/^[0-9]+$/", $testCase)){
                $testCase = $this->getTestCaseByNameProp($testCase);
                if($testCase["found"]){
                    $testCase = $testCase["id"];
                }
                else{
                    throw new Exception("No se pudo obtener el testCase", 1);
                }
            }
            $params = [
                'devKey' => new Value($this->userApiKey, "string"),
                'testcaseid' => new Value(intval($testCase), "int"),
            ];

            $paramStruct = new Value($params, "struct");

            $request = new Request("tl.getTestCase", [$paramStruct]);
            $response = $this->client->send($request);
            if ($response->faultCode() != 0) {
                throw new Exception("No existe el testCase", 1);
            }
            /**
             * @var Value
             */
            $responseArray = $response->value()[0];
            try {
                //code...
                $name = $this->getValStruc($responseArray, 'name');
                $steps_Tc = $this->getValStruc($responseArray, 'steps');
            } catch (\Throwable $th) {
                throw new Exception("No se pudo obtener el testCase o no existe", 1);
            }

            if(is_array($steps_Tc)){
                if(count($steps_Tc) != count($steps)){
                    $actual = count($steps);
                    $requested = count($steps_Tc);
                    throw new Exception("No se estan enviando todos los steps Actual: {$actual} Requested: {$requested}", 1);
                }
            }
            else{
                throw new Exception("No se pudo obtener los steps", 1);
            }
            
            
            $params = [];
            $params["devKey"] = new Value($this->userApiKey, "string");
            $params["testcaseid"] = new Value(intval($testCase), "int");
            $params["testplanid"] = new Value(intval($this->testPlan['id']), "int");
            $params["buildid"] = new Value(intval($this->testBuild['id']), "int");
            if(isset($duration)){
                // Aseguramos que sea un número (float) y lo enviamos como 'double' en XML-RPC
                $params["execduration"] = new Value((string)$duration, "string"); 
            }
            $params["status"] = new Value($status, "string");
            $newSteps = $this->sctructSteps($steps);
            $params["steps"] = new Value($newSteps, "array");

            if(isset($notes)){
                $params["notes"] = new Value($notes, "string");
            }
            
            $structValue = new Value($params, "struct");
            $request = new Request("tl.reportTCResult", [$structValue]);
            $response = $this->client->send($request);

            if ($response->faultCode() != 0) {
                $ok = false;
                echo "❌ ERROR de API TestLink: " . $response->faultString() . "\n";
            }

            $xml = $response->serialize();

            if(!is_string($xml)){
                $ok = false;
                echo "❌ ERROR de API TestLink: \n";
            }

            
            $xml = new SimpleXMLElement($xml);

            echo findResponseXml($xml, "message") . "\n";

            if(findResponseXml($xml, "message") != "Success!"){
                $ok = false;
                echo "❌ ERROR de API TestLink: " . findResponseXml($xml, "message") . "\n";
            }
            else{
                echo "✅ TEST REPORT COMPLETED: Resultado reportado para el test case: " . $name . "\n";

            }

            

            
        } catch (\Throwable $th) {
            $ok = false;
            echo "❌ ERROR de API TestLink: " . $th->getMessage() . "::linte {$th->getLine()} \n:: file {$th->getFile()}\n";
        }
        return $ok;

    }

/**
 * Reporta un estado único (p, f, b) para un caso de prueba,
 * aplicando automáticamente ese estado a TODOS sus pasos.
 * para usarlo con condicionales en las que si una prueba falla y la siguiente necesita que halla 
 * ocurrido exitosamente se puede usar reportTestStatusOnly para reportrar una prueba como bloqueada
 *
 * @param int|string $testCase ID o Nombre del Test Case.
 * @param string $status Estado a reportar ('p', 'f', 'b').
 * @param float|null $duration Duración opcional de la ejecución.
 * @param string|null $testSuite Nombre del Test Suite (necesario si $testCase es un string).
 * @param string|null $notes Notas opcionales para la ejecución general.
 * @return bool true si el reporte fue exitoso, false en caso contrario.
 */
public function reportTestStatusOnly(int|string $testCase, string $status, $duration = null, string $testSuite = null, $notes = null)
{
    if (ENABLE_REPORTS == false) return true;
    $ok = true;
    try {
        // 1. Resolver el ID del Test Case (idéntico a reportTest)
        if (is_string($testCase) && is_string($testSuite)) {
            $testCase = $this->getTestCaseIdByName($testSuite, $testCase);
            if (is_array($testCase) and arrayHasKey('id', $testCase)) {
                $testCase = $testCase['id'];
            } else {
                throw new Exception("No se pudo obtener el testCase", 1);
            }
        }
        else if(is_string($testCase) and !preg_match("/^[0-9]+$/", $testCase)){
            $testCase = $this->getTestCaseByNameProp($testCase);
            if($testCase["found"]){
                $testCase = $testCase["id"];
            }
            else{
                throw new Exception("No se pudo obtener el testCase", 1);
            }
        }

        // 2. Obtener los detalles del Test Case (para saber cuántos steps tiene)
        $params = [
            'devKey' => new Value($this->userApiKey, "string"),
            'testcaseid' => new Value(intval($testCase), "int"),
        ];
        $paramStruct = new Value($params, "struct");
        $request = new Request("tl.getTestCase", [$paramStruct]);
        $response = $this->client->send($request);
        if ($response->faultCode() != 0) {
            throw new Exception("No existe el testCase", 1);
        }

        /**
         * @var Value
         */
        $responseArray = $response->value()[0];
        $name = $this->getValStruc($responseArray, 'name'); // Para el mensaje de éxito
        $steps_Tc = $this->getValStruc($responseArray, 'steps'); // Los steps definidos en TestLink

        // 3. GENERAR EL ARRAY DE STEPS
        $generatedSteps = [];
        if (is_array($steps_Tc)) {
            $contador = 0;
            // Iteramos sobre los steps que TestLink nos devuelve
            foreach ($steps_Tc as $step_definition) {
                // Creamos un resultado de step para cada uno
                $generatedSteps[] = array(
                    'step_number' => $contador + 1,
                    'result' => $status, // Aplicamos el estado general
                    'notes' => ''
                );
                $contador++;
            }
        } else {
            // Si $steps_Tc no es un array, puede que el test no tenga steps
            // o que la respuesta de la API sea inesperada.
            // Si el test NO tiene steps, $steps_Tc debería ser un array vacío
            // y el foreach simplemente no se ejecutaría, lo cual es correcto.
            // Lanzamos error solo si no es un array y esperábamos que lo fuera.
            if ($steps_Tc !== null && !is_array($steps_Tc)) {
                throw new Exception("No se pudo obtener la estructura de steps del test case", 1);
            }
            // Si $steps_Tc es null o un array vacío, $generatedSteps quedará como []
        }

        // 4. Reportar el resultado (Lógica de reportTCResult)
        $params = [];
        $params["devKey"] = new Value($this->userApiKey, "string");
        $params["testcaseid"] = new Value(intval($testCase), "int");
        $params["testplanid"] = new Value(intval($this->testPlan['id']), "int");
        $params["buildid"] = new Value(intval($this->testBuild['id']), "int");
        if (isset($duration)) {
            $params["execduration"] = new Value((string)$duration, "string");
        }
        $params["status"] = new Value($status, "string"); // Estado general del Test Case
        
        // Usamos los steps que acabamos de generar
        $newSteps = $this->sctructSteps($generatedSteps); 
        $params["steps"] = new Value($newSteps, "array");

        if (isset($notes)) {
            $params["notes"] = new Value($notes, "string");
        }
        
        $structValue = new Value($params, "struct");
        $request = new Request("tl.reportTCResult", [$structValue]);
        $response = $this->client->send($request);

        // 5. Manejar la respuesta (idéntico a reportTest)
        if ($response->faultCode() != 0) {
            $ok = false;
            echo "❌ ERROR de API TestLink: " . $response->faultString() . "\n";
        }

        $xml = $response->serialize();

        if (!is_string($xml)) {
            $ok = false;
            echo "❌ ERROR de API TestLink: \n";
        }

        
        $xml = new SimpleXMLElement($xml);

        echo findResponseXml($xml, "message") . "\n";

        if (findResponseXml($xml, "message") != "Success!") {
            $ok = false;
            echo "❌ ERROR de API TestLink: " . findResponseXml($xml, "message") . "\n";
        } else {
            echo "✅ TEST REPORT COMPLETED: Resultado reportado para el test case: " . $name . "\n";
        }

        
    } catch (\Throwable $th) {
        $ok = false;
        echo "❌ ERROR de API TestLink: " . $th->getMessage() . "::linte {$th->getLine()} \n:: file {$th->getFile()}\n";
    }
    return $ok;
}

    public function getTestCaseByNameProp($name){
        $resp = ["found" => false, "id" => 0, "name" => "", "parent_id" => 0];
        foreach ($this->testCases as $testCase) {
            if($testCase["name"] == $name){
                $testCase["found"] = true;
                return $testCase;
            }
        }
        return $resp;
    }

    public function getProjects() {
        
        // 1. Prepara la solicitud (ya funciona)
        $args = ["devKey" => new Value($this->userApiKey, "string")];
        $structValue = new Value($args, "struct");
        $request = new Request("tl.getProjects", [$structValue]);
        $response = $this->client->send($request);
        
        if ($response->faultCode() != 0) {
            echo "❌ ERROR de API TestLink: " . $response->faultString() . "\n";
            return null;
        }

        // El contenedor principal: es un array de proyectos
        $xmlRpcArray = $response->value(); 

        // Verificar si es realmente un array y si tiene elementos
        if ($xmlRpcArray->kindOf() !== 'array' || $xmlRpcArray->arraySize() === 0) {
            echo "Advertencia: No se encontraron proyectos de prueba.\n";
            return [];
        }
        
        $proyectosEncontrados = [];
        
        // 2. Iterar sobre los proyectos dentro del array
        $numProyectos = $xmlRpcArray->arraySize();
        echo "Total de proyectos encontrados: {$numProyectos}\n";
        
        for ($i = 0; $i < $numProyectos; $i++) {
            
            // Obtenemos el elemento 'i' del array. Este elemento es un <struct> (un proyecto)
            $proyectoStruct = $xmlRpcArray->arrayMem($i);
            
            // 3. Acceder a los miembros del struct (id, name, etc.)
            
            // Acceder al miembro 'id'. structMem('id') devuelve otro objeto Value.
            $id = $this->getValStruc($proyectoStruct, 'id');
            
            // Acceder al miembro 'name'
            $name = $this->getValStruc($proyectoStruct, 'name');
            
            echo "✅ Proyecto Encontrado: ID: '{$id}', Nombre: '{$name}'\n";

            //$this->debugStruct($proyectoStruct);
            
            // Guardar el par ID/Nombre
            $proyectosEncontrados[] = ['id' => $id, 'name' => $name];
        }
        
        return $proyectosEncontrados;
    }

// Asume que esta es la clase donde tienes el constructor y client
// Cambia esto a un nuevo método en tu clase (ej: getTestPlans)
    public function getTestPlans($projectId, $showStruct = false)
    {
        if(!ENABLE_REPORTS){
            echo "❌ LOS REPORTES NO ESTAN HABILITADOS\n";
            return null;
        }
        // 1. Prepara los argumentos: devKey y testprojectid (¡como enteros!)
        $args = [
            "devKey" => new Value($this->userApiKey, "string"),
            "testprojectid" => new Value($projectId, "int") // Usaremos el ID 1
        ];

        // 2. Envuelve los argumentos en una estructura
        $structValue = new Value($args, "struct");
        
        // 3. Crea y envía la solicitud
        $request = new Request("tl.getProjectTestPlans", [$structValue]);
        $response = $this->client->send($request);
        
        if ($response->faultCode() != 0) {
            echo "❌ ERROR al obtener Planes de Prueba: " . $response->faultString() . "\n";
            return null;
        }

        $xmlRpcArray = $response->value();
        
        // Verificar si es realmente un array y si tiene elementos
        if ($xmlRpcArray->kindOf() !== 'array' || $xmlRpcArray->arraySize() === 0) {
            echo "Advertencia: No se encontraron proyectos de prueba.\n";
            return [];
        }

        $totalElementos = $xmlRpcArray->arraySize();
        echo "Total de Planes de Prueba encontrados: {$totalElementos}\n";
        
        $testPlans = [];
        
        for ($i = 0; $i < $totalElementos; $i++) {
            $testPlanStruct = $xmlRpcArray->arrayMem($i);
            $valuesFoud = $this->debugStruct($testPlanStruct, print: $showStruct);
            
            if(in_array("id", $valuesFoud)){
                $id = $this->getValStruc($testPlanStruct, 'id');
                $name = $this->getValStruc($testPlanStruct, 'name');
                echo "✅ Plan de Prueba Encontrado: ID: '{$id}', Nombre: '{$name}'\n";
                // ["name" => "plan de pruebas generales", "id" => 10]
                echo "\n['name' => '{$name}', 'id' => {$id}]\n";
                $testPlans[] = ['id' => $id, 'name' => $name];
            }
            else{
                echo "❌ ERROR al obtener Planes de Prueba\n";
                if(in_array("message", $valuesFoud)){
                    echo "Error: " . $this->getValStruc($testPlanStruct, 'message') . "\n";
                }
            }
        }

        return $testPlans;
    }
    /*
     * @param mixed $testPlanID
     * @param mixed $buildID
     * @param array {}
     * @return void
     */
    public function getBuildsForTestPlan($planId, $showStruct = false)
    {
        if(!ENABLE_REPORTS){
            echo "❌ LOS REPORTES NO ESTAN HABILITADOS\n";
            return null;
        }
        // 1. Prepara los argumentos: devKey y testplanid
        $args = [
            "devKey" => new Value($this->userApiKey, "string"),
            "testplanid" => new Value($planId, "int") // Usaremos el ID 10
        ];

        // 2. Envuelve los argumentos en una estructura
        $structValue = new Value($args, "struct");
        
        // 3. Crea y envía la solicitud
        $request = new Request("tl.getBuildsForTestPlan", [$structValue]);
        $response = $this->client->send($request);
        
        if ($response->faultCode() != 0) {
            echo "❌ ERROR al obtener Builds: " . $response->faultString() . "\n";
            return null;
        }

        $xmlRpcArray = $response->value();
        
        echo "--- BUILDS (Para Plan ID: {$planId}) ---\n";
        
        // Extraer y devolver las builds como un array limpio (usando la lógica de iteración)
        $builds = [];
        $numBuilds = $xmlRpcArray->arraySize();
        
        if ($numBuilds > 0) {
            for ($i = 0; $i < $numBuilds; $i++) {
                $buildStruct = $xmlRpcArray->arrayMem($i);
                
                // Usamos tu función debugStruct para ver todos los campos de la primera build
                $values = $this->debugStruct($buildStruct,print:false);
                if ($i === 0 && $showStruct) {
                    echo "\n== DETALLE COMPLETO DE LA PRIMERA BUILD ==\n";
                    $this->debugStruct($buildStruct);
                    echo "==========================================\n";
                }

                if(in_array('id',$values)){
                    $id = $buildStruct->structMem('id')->scalarVal();
                    $name = $buildStruct->structMem('name')->scalarVal();
                    $builds[] = ['id' => $id, 'name' => $name];
                    echo "✅ Build encontrada: ID: **{$id}**, Nombre: **{$name}**\n";
                    echo "\n['name' => '{$name}', 'id' => {$id}];\n";
                }
                else{
                    echo "❌No se encontraron builds para este plan.\n";
                    if(in_array('message', $values)){
                        echo "❌ ERROR: " . $buildStruct->structMem('message')->scalarVal() . "\n";
                    }
                }
            }
        } else {
            echo "No se encontraron builds para este plan.\n";
        }

        return $builds;
    }

    public function getTestSuitesForTestPlan($planId)
    {
        if(!ENABLE_REPORTS){
            echo "❌ LOS REPORTES NO ESTAN HABILITADOS\n";
            return null;
        }
        // Parámetros adicionales requeridos para este método:
        $args = [
            "devKey" => new Value($this->userApiKey, "string"),
            "testplanid" => new Value($planId, "int"), // ID del Plan (10)
            // Puedes filtrar, pero por ahora obtenemos todos:
        ];

        $structValue = new Value($args, "struct");
        $request = new Request("tl.getTestSuitesForTestPlan", [$structValue]);
        $response = $this->client->send($request);

        if ($response->faultCode() != 0) {
            echo "❌ ERROR al obtener Test Cases: " . $response->faultString() . "\n";
            return null;
        }

        $xmlRpcArray = $response->value();
        
        echo "\n--- Test Suites (Para Plan ID: {$planId}) ---\n";
        
        $testCases = [];
        $numCases = $xmlRpcArray->arraySize();
        
        if ($numCases > 0) {
            for ($i = 0; $i < $numCases; $i++) {
                $caseStruct = $xmlRpcArray->arrayMem($i);
                
                $valuesfound = $this->debugStruct($caseStruct,print:false);
                if(in_array('id', $valuesfound)){
                    $name = $this->getValStruc($caseStruct, 'name');
                    $id = $this->getValStruc($caseStruct, 'id');
                    $parentId = $this->getValStruc($caseStruct, 'parent_id');
                    echo "✅ Test Suite encontrada: ID: **{$id}**, Nombre: **{$name}** (Padre: {$parentId})\n";
                    echo "\n['name' => '{$name}', 'id' => {$id}, 'parentId' => {$parentId}],\n";
                }
                else{
                    echo "❌No se encontraron testsuite para este plan.\n";
                    if(in_array('message', $valuesfound)){
                        echo "❌ ERROR: " . $caseStruct->structMem('message')->scalarVal() . "\n";
                    }
                }
            }
        } else {
            echo "No se encontraron casos de prueba asociados a este plan.\n";
        }
        
        return $testCases;
    }

    public function getTestCasesForTestSuite($suiteId)
    {
        if(!ENABLE_REPORTS){
            echo "❌ LOS REPORTES NO ESTAN HABILITADOS\n";
            return null;
        }
        // Parámetros adicionales requeridos para este método:
        $args = [
            "devKey" => new Value($this->userApiKey, "string"),
            "testsuiteid" => new Value($suiteId, "int"), // ID del Suite (255)
        ];

        $structValue = new Value($args, "struct");
        $request = new Request("tl.getTestCasesForTestSuite", [$structValue]);
        $response = $this->client->send($request);

        if ($response->faultCode() != 0) {
            echo "❌ ERROR al obtener Test Cases: " . $response->faultString() . "\n";
            return null;
        }

        $xmlRpcArray = $response->value();
        
        echo "\n--- Test Cases (Para Suite ID: {$suiteId}) ---\n";
        
        $testCases = [];
        $numCases = $xmlRpcArray->arraySize();
        
        if ($numCases > 0) {
            for ($i = 0; $i < $numCases; $i++) {
                $caseStruct = $xmlRpcArray->arrayMem($i);
                
                //$this->debugStruct($caseStruct);
                /**
                 * lista de campos disponibles:
                 * id
                 * name
                 * parent_id
                 * 
                 */
                $name = $this->getValStruc($caseStruct, 'name');
                $id = $this->getValStruc($caseStruct, 'id');
                $parentId = $this->getValStruc($caseStruct, 'parent_id');
                //echo "✅ Test Case encontrado: ID: **{$id}**, Nombre: **{$name}** (Padre: {$parentId}) \n";
                echo "[ 'id' => {$id}, 'name' => '{$name}', 'parent_id' => {$parentId} ],\n";
            }
        } else {
            echo "No se encontraron casos de prueba asociados a este suite.\n";
        }
        
        return $testCases;
    }

    public function getTestCaseIdByName($testSuiteName, $testCaseName)
    {
        if(!ENABLE_REPORTS){
            echo "❌ LOS REPORTES NO ESTAN HABILITADOS\n";
            return null;
        }
        $args = [
            "devKey" => new Value($this->userApiKey, "string"),
            "testsuitename" => new Value($testSuiteName, "string"),
            "testcasename" => new Value($testCaseName, "string"),
        ];

        $structValue = new Value($args, "struct");
        $request = new Request("tl.getTestCaseIDByName", [$structValue]);
        $response = $this->client->send($request);

        if ($response->faultCode() != 0) {
            echo "❌ ERROR al obtener Test Cases: " . $response->faultString() . "\n";
            return null;
        }

        $xmlRpcArray = $response->value();
        
        $testCases = [];
        $numCases = $xmlRpcArray->arraySize();
        
        if ($numCases > 0) {
            for ($i = 0; $i < $numCases; $i++) {
                $caseStruct = $xmlRpcArray->arrayMem($i);
                // $this->debugStruct($caseStruct);
                $id = $this->getValStruc($caseStruct, 'id');
                $name = $this->getValStruc($caseStruct, 'name');
                $parentId = $this->getValStruc($caseStruct, 'parent_id');
                $tc_external_id = $this->getValStruc($caseStruct, 'tc_external_id');
                $ts_name = $this->getValStruc($caseStruct, 'tsuite_name');
                echo "✅ Test Case encontrado: ID: **{$id}**, Nombre: **{$name}** (Padre: {$parentId})\n";
                $testCases = [
                    'id' => $id,
                    'name' => $name,
                    'parent_id' => $parentId,
                    'tc_external_id' => $tc_external_id,
                    'ts_name' => $ts_name
                ];
            }
        } else {
            echo "No se encontraron casos de prueba asociados a este suite.\n";
        }
        
        return $testCases;
    }



    /**
 * Muestra recursivamente los miembros y valores de un objeto PhpXmlRpc\Value de tipo struct.
 * @param Value $structValue El objeto PhpXmlRpc\Value de tipo struct a inspeccionar.
 * @param string $indent El sangrado para mejorar la legibilidad.
 */
public function debugStruct(Value $structValue, $indent = "", $print = true) {

    $valuesFound = [];
    
    // 1. Verificar si el objeto es un <struct> (necesario para la iteración)
    if ($structValue->kindOf() === 'array') {
        foreach ($structValue as $value) {
            $this->debugStruct($value, $indent . "  ");
        }
        unset($value);
    }
    else if ($structValue->kindOf() !== 'struct') {
        if($print) echo "Advertencia: El objeto no es una estructura ('struct'). Tipo actual: " . $structValue->kindOf() . "\n";
        return [];
    }

    if($print) echo "{$indent}Iniciando inspección de la estructura:\n";
    
    // 2. Usar foreach para iterar sobre todos los miembros del struct
    // El iterador devuelve el nombre del miembro como clave ($key) 
    // y el valor (otro objeto Value) como valor ($memberValue)
    foreach ($structValue as $key => $memberValue) {
        
        $currentType = $memberValue->kindOf();
        
        // 3. Imprimir el nombre y el tipo del miembro
        if($print) echo "{$indent}  **Miembro:** {$key} ";
        if($print) echo "(Tipo XML-RPC: {$currentType})";
        $valuesFound[] = $key;

        // 4. Si el miembro es un valor escalar, imprimir su contenido.
        if ($currentType === 'string' || $currentType === 'int' || $currentType === 'boolean') {
            if($print) echo " => Valor: **" . $memberValue->scalarVal() . "**\n";
        } 
        
        // 5. Si el miembro es otra estructura o array, llamar recursivamente
        elseif ($currentType === 'struct' || $currentType === 'array') {
            echo " => (Contenido anidado):\n";
            // Llamada recursiva para explorar estructuras anidadas (ej. el miembro 'opt' de TestLink)
            $valuesFound[$key] = $this->debugStruct($memberValue, $indent . "  "); 
        } 
        
        // 6. Manejo de otros tipos (como datetime, base64)
        else {
            if($print) echo " => Tipo complejo (no impreso).\n";
        }
    }
    if($print) echo "{$indent}Fin de la inspección.\n";

    return $valuesFound;
}

public function showStruct(Value $structValue, $indent = "") {
   
    // 1. Verificar si el objeto es un <struct> (necesario para la iteración)
    if ($structValue->kindOf() === 'array') {
        foreach ($structValue as $value) {
            $this->showStruct($value, $indent . "  ");
        }
        unset($value);
    }
    else if ($structValue->kindOf() !== 'struct') {
        echo "Advertencia: El objeto no es una estructura ('struct'). Tipo actual: " . $structValue->kindOf() . "\n";
        return;
    }
    
    // 2. Usar foreach para iterar sobre todos los miembros del struct
    // El iterador devuelve el nombre del miembro como clave ($key) 
    // y el valor (otro objeto Value) como valor ($memberValue)
    foreach ($structValue as $key => $memberValue) {
        
        $currentType = $memberValue->kindOf();
        
        // 3. Imprimir el nombre y el tipo del miembro
        echo "{$indent} key => {$key} ";
        echo "(Tipo XML-RPC: {$currentType})";

        // 4. Si el miembro es un valor escalar, imprimir su contenido.
        if ($currentType === 'string' || $currentType === 'int' || $currentType === 'boolean') {
            echo " => Valor: **" . $memberValue->scalarVal() . "**\n";
        } 
        
        // 5. Si el miembro es otra estructura o array, llamar recursivamente
        elseif ($currentType === 'struct' || $currentType === 'array') {
            echo " => (Contenido anidado):\n";
            // Llamada recursiva para explorar estructuras anidadas (ej. el miembro 'opt' de TestLink)
            $this->showStruct($memberValue, $indent . "  "); 
        } 
        
        // 6. Manejo de otros tipos (como datetime, base64)
        else {
            echo " value => {$this->getValStruc($structValue, $key)}\n";
        }
    }
    echo "{$indent}Fin de la inspección.\n";

}

public function getValStruc(Value $structValue, $key = '', $printExtro = false){
    if($key == '') return $structValue->scalarVal();
    else{
        $val = $this->getValStruc($structValue->structMem($key));
        if($printExtro) echo "✅ key: {$key} => {$val}\n";
        return $val;
    } 
}

public function sctructSteps(array $steps) {
    
    $xmlRpcSteps = [];
    
    foreach ($steps as $step) {
        // Asumiendo que cada $step es un array asociativo como: 
        // ['step_number' => 1, 'result' => 'p', 'notes' => 'Todo OK']
        
        $stepArgs = [];
        
        // Convertir cada campo del step a un Value de XML-RPC (estructura interna)
        foreach ($step as $key => $val) {
             // Asumiendo que todos los valores son strings o enteros
             $type = is_int($val) ? "int" : "string"; 
             $stepArgs[$key] = new Value($val, $type);
        }
        
        // Envolver el step (que es una colección de campos) como un <struct>
        $xmlRpcSteps[] = new Value($stepArgs, "struct");
    }
    
    // Devolver un array donde CADA elemento es un objeto Value (de tipo struct)
    return $xmlRpcSteps; 
}



    
}


function echoDebug($var){
    ob_start();
    var_dump($var);
    $var = ob_get_clean();
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}


/**
 * Busca un elemento en la respuesta XML-RPC que tenga como nombre el par metro $name.
 * Si se encuentra, devuelve el valor del elemento como un string, boolean o int, dependiendo de su tipo.
 * Si no se encuentra, devuelve null.
 * para despues de aplicar un $elem->serialize();
 *
 * @param SimpleXMLElement $xml La respuesta XML-RPC.
 * @param string $name El nombre del elemento a buscar.
 * @return string|boolean|int|null El valor del elemento encontrado, o null si no se encuentra.
 * @throws Throwable Si ocurre un error al procesar la respuesta XML-RPC.
 */
function findResponseXml ($xml, $name) {

    try {
        $elem = $xml->xpath("//member[name='" . $name . "']/value/*");
        
        if (count($elem) > 0) {
            //return $elem[0]->__toString();
            if($elem[0]->getName() == "string") return $elem[0]->__toString();
            if($elem[0]->getName() == "boolean") return (in_array($elem[0]->__toString(), ["true", "1"]) ? true : false) ;
            if($elem[0]->getName() == "int") return intval($elem[0]->__toString());
            return null;
        }
    } catch (\Throwable $th) {
        return null;
    }
};


 ?>