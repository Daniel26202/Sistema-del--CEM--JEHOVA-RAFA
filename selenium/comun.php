<?php 
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Remote\RemoteWebElement;

    class ComunSelenium{

        public $driver;
        public ApiController $testLink;
        public $steps;
        public $startCounter;
        public $lastTime;
        private $triedStepNote = null;

        public function __construct(){
            $this->startCounter = null;
            $this->lastTime = 0;
            $this->steps = array();

            $this->openBrowser();
        }

        public function openSystemDSG($login = true){
            $this->driver->get("http://localhost:8081/Sistema-del--CEM--JEHOVA-RAFA/");
            if($login){
                $this->login();
            }
        }
        public function login($clave = "Sistema.30", $usuario = "WDaniel123"){

            try {
                $this->driver->wait(5, 500)->until(
                    WebDriverExpectedCondition::urlIs("http://localhost:8081/Sistema-del--CEM--JEHOVA-RAFA/")
                );

                $this->fillForm('#inputUno', $usuario);
                $this->fillForm('#inputDos', $clave);
                $this->scrollTo('#boton_inicio_sesion');
                $this->click('#boton_inicio_sesion');

                $this->waitUrl(url("Inicio/inicio"), 5);
            } catch (\Exception $th) {
                $this->print("No se pudo iniciar sesi n automáticamente, por favor inicie sesi n manualmente.",3);
            }

        }

        public function closeBrowser(){
            $this->driver->quit();
            $this->driver = null;
        }
        public function openBrowser(){
            $host = 'http://localhost:9516'; // Conexión directa a ChromeDriver (Opción 2)
            $capabilities = DesiredCapabilities::chrome();
            $driver = RemoteWebDriver::create($host, $capabilities);
            $this->driver = $driver;
        }
        public function wait($funcion, $timeout = 3, $interval = 500, $mensaje = ''){
            $this->driver->wait($timeout, $interval)->until($funcion, $mensaje);
        }
        
        public function createSteps(){
            $this->steps = array();
            $this->triedStepNote = null;
        }
        public function triedStepNote($note){
            $this->triedStepNote = $note;
        }

        /**
         * @param 'p'|'f'|'b' $result 
         * * p = passed
         * * f = failed
         * * b = blocked
         * @param string $notas
         */
        public function addSteps(string $result, string $notas = ''){
            $contador = count($this->steps);
            $this->steps[] = array(
                'step_number' => $contador + 1,
                'result' => $result,
                'notes' => $notas
            );
        }
        /**
         * Bloquea los pasos de la prueba creando pasos con un resultado "b" hasta que 
         * el contador de pasos llegue a $num a partir del actual
         * @param int $num total de pasos
         */
        public function blockSteps(int $num){
            $this->endContador();
            $contador = count($this->steps);
            $result = "f";
            $notas = $this->triedStepNote ?? '';
            for($i = $contador + 1; $i <= $num; $i++){
                $this->steps[] = array(
                    'step_number' => $i,
                    'result' => $result,
                    'notes' => $notas
                );
                $result = "b";
            }
        }
        public function getStatusSteps(){
            $status = "p";
            foreach($this->steps as $step){
                if($step['result'] == "f"){
                    $status = "f";
                }
                else if ($step['result'] == "b"){
                    $status = "b";
                    break;
                }
            }
            return $status;
        }

        

        public function startContador(){
            $this->startCounter = microtime(true);
        }
        public function endContador(){
            if($this->startCounter == null){
                return 0;
            }
            $time = microtime(true) - $this->startCounter; 
            $this->lastTime = $time;
            $this->startCounter = null;
            return $time;
        }
        public function getSteps(){
            return $this->steps;
        }


        public function click($selector, $timeout = 3, $interval = 500){
            try {
                $selector = $this->selector($selector);
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($selector)
                );
                $this->driver->findElement($selector)->click();
            } catch (\Exception $th) {
                echo "Error al hacer click en el elemento :: {$th->getMessage()}\n" ;
            }
        }
        public function fillForm ($selector, $value, $timeout = 3, $interval = 500, $mensaje = ''){
            try {
                $selector = $this->selector($selector);
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($selector),
                    $mensaje
                );
                $this->driver->findElement($selector)->clear();
                $this->driver->findElement($selector)->sendKeys($value);
            } catch (\Exception $th) {
                echo "Error al llenar el formulario :: {$th->getMessage()}\n" ;
            }
        }
        /**
         * llena un formulario por un array
         * @param array<array{selector: string, value: string}> $inputs
         * @return void
         */
        public function fillForms(array $inputs, $timeout = 3, $interval = 500, $mensaje = ''){
            foreach($inputs as $input){
                $this->fillForm($input['selector'], $input['value'], $timeout, $interval, $mensaje);
            }
        }

        /**
         * epera que un elemento se encuentre visible
         * @param WebDriverBy|string  $selector
         * @param int $timeout
         * @param int $interval
         * @param string $mensaje
         * @return RemoteWebElement
         */
        public function waitElement($selector, $timeout = 3, $interval = 500, $mensaje = ''){
            try {
                $selector = $this->selector($selector);
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($selector), 
                    $mensaje
                );
                return $this->driver->findElement($selector);
            } catch (\Throwable $th) {
                echo "Error al esperar el elemento :: {$th->getMessage()}\n" ;
                throw $th;
            }
        }
        public function waitUrl($url, $timeout = 3, $interval = 500, $mensaje = ''){
            try {
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::urlIs($url), 
                    $mensaje
                );
            } catch (\Exception $th) {
                echo "Error al esperar la url :: {$th->getMessage()}\n" ;
                throw $th;
            }
        }
        /**
         * Espera que una alerta se muestre
         * @param string $text
         * @param 'success'|'danger' | 'warning' $type = 'success'
         * @param int $timeout
         * @param int $interval
         * @param string $mensaje
         * @return void
         */
        public function waitAlert($text = '', $type = 'success', $timeout = 3, $interval = 500, $mensaje = ''){
            try {
                $condition = WebDriverExpectedCondition::visibilityOfElementLocated(
                    WebDriverBy::cssSelector('div.toastify.on[style*="--bs-'.$type.'"]')
                );
                if(!empty($text)){
                    $condition = WebDriverExpectedCondition::elementTextContains(
                        WebDriverBy::cssSelector('div.toastify.on[style*="--bs-'.$type.'"]'),
                        $text);
                }
                $this->wait(
                    $condition,
                    $timeout,
                    $interval,
                    $mensaje
                );
                
            } catch (\Exception $th) {
                $this->print("Error al esperar la alerta",6);
                echo ":: {$th->getMessage()}\n" ;
                throw $th;
            }


        }

        public function goTo($url){
            $this->driver->get(url($url));
        }
        /**
         * Convierte un selector CSS o un objeto WebDriverBy en un objeto WebDriverBy para utilizarlo en las funciones de espera.
         * Si el par metro es un string, se asume que es un selector CSS.
         * Si el par metro es un objeto WebDriverBy, se devuelve el mismo objeto sin realizar ninguna acci n.
         * @param string|WebDriverBy $selector Un selector CSS, un objeto WebDriverBy, o un elemento ya encontrado.
         * @return WebDriverBy El objeto WebDriverBy resultante de la conversi n.
         */
        public function selector(WebDriverBy|string $selector){
            if(is_string($selector)){
                return WebDriverBy::cssSelector($selector);
            }
            else return $selector;
            
        }

        /**
         * Desplaza la página hasta que el elemento especificado (por selector o por objeto) esté visible 
         * y luego se asegura de que sea clicable.
         * @param string|WebDriverBy $selector Un selector CSS/XPath, un objeto WebDriverBy, o un elemento ya encontrado.
         * @return RemoteWebElement|null El elemento encontrado, o null si falla.
         */
        public function scrollTo($selector) {
            $auxSelector = $selector;
            // Asumimos que tienes acceso a $this->driver y a un método $this->wait
            $elemento = null; 

            try {
                // --- 1. Determinar el Objeto del Elemento (RemoteWebElement) ---
                
                // Caso A: Selector pasado como string (asumimos CSS Selector por defecto)
                $by = $this->selector($selector);
                
                // Esperar que el elemento esté visible antes de encontrarlo
                $this->driver->wait(3, 500)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($by)
                );
                $elemento = $this->driver->findElement($by);
                
                // Si no se pudo encontrar el elemento por alguna razón
                if (!$elemento) {
                    return null;
                }

                // --- 2. Realizar el Scroll y Esperar la Condición de Clic ---

                // Usamos arguments[0].scrollIntoView(true) para asegurarnos de que el borde superior 
                // del elemento esté en la parte superior de la vista.
                $this->driver->executeScript("arguments[0].scrollIntoView({behavior: 'instant', block: 'center', inline: 'nearest'});", [$elemento]);
                

                $this->wait(WebDriverExpectedCondition::elementToBeClickable($by)); 
                
                return $elemento;

            } catch (\Exception $th) {
                echo "❌ Error al hacer scroll o esperar elemento: {$th->getMessage()}\n";
                throw $th;
            }
        }

        /**
         * Espera a que el elemento de mensajes de error de los input/select este visible 
         * * si se le pasa el mensaje verifica que sea el mismo
         * * usage:
         * * <code> $this->waitFormText($this->selector('idInput'), 'El mensaje a esperar'); </code>
         * * input:
         * <code>
         * con data-span
         * <input type="text" data-span="spanId">
         * <span id="spanId" class="form-text invalid-feedback ">El mensaje a esperar</span>
         * 
         * con data-formtext
         * <input type="text" data-formtext="spanId">
         * <span id="spanId" class="form-text invalid-feedback ">El mensaje a esperar</span>
         * 
         * sin data (por el elemento hermano con la clase form-text invalid-feedback )
         * <input type="text">
         * <span class="form-text invalid-feedback ">El mensaje a esperar</span>
         * 
         * sin data (por el elemento padre y luego un elemento hijo con la clase form-text invalid-feedback )
         * <div>
         *   <input id="passID" type="password" name="clave" class="form-control" placeholder="Contraseña" data-span="test">
         *   <div>algo a mitad</div>
         *   <span class="form-text invalid-feedback d-block">queso</span>
         * </div>
         * 
         * </code>
         * 
         * si el idElemnent es un input/textarea/select desde donde encontrar el form-text este metodo tambien validara el valid de html5 ej. required pattern
         * @param string $idElemnent selector css del input
         * @param string $mensaje mensaje a esperar
         * @param bool $xpath si el idElemnent es un xpath al input||.form-text
         * @param mixed $timeout tiempo de espera
         * @param mixed $interval iteraciones de espera
         * 
         * @return RemoteWebElement;
         */
        public function waitFormText($idElemnent, $mensaje = '', $xpath = false, $timeout = 3, $interval = 500){
            try {
                $input = '';
                $this->print("  buscando form-text",5);
                
                if($xpath){
                    $by = WebDriverBy::xpath($idElemnent);
                }
                else{
                    $by = $this->selector("$idElemnent");
                }
                
                $elem = $this->driver->findElement($by);
                
                if(!$elem){
                    throw new Exception("No se pudo encontrar el elemento por su selector");
                }
                
                $class = $elem->getAttribute('class');
                
                $span = '';
                
                if(str_contains($class, 'form-text') || str_contains($class, 'invalid-feedback')){
                    $span = $elem;
                    echo "span: seleccionado directamente\n";
                    $this->print("  form-text encontrado directamente",4);

                }
                else{
                    $span = $elem->getAttribute('data-span') ?? $elem->getAttribute('data-formtext') ?? '';
                    


                    
                    if(empty($span)){
                        $input = $by;
                        
                        try {// buscamos el hermano
                            $next = $elem->findElement(WebDriverBy::xpath(".//following-sibling::*[1][contains(@class, 'form-text') or contains(@class, 'invalid-feedback')]"));
                        } catch (\Throwable $th) {
                            // buscamos el padre y luego el hijo
                            try {
                                $next = $elem->findElement(WebDriverBy::xpath(".//ancestor::*[1]/descendant::*[contains(@class,'form-text') or contains(@class,'invalid-feedback')]"));
                            } catch (\Throwable $th) {
                                $next = '';
                            }
                        }
                        $span = $next;
                        $this->print("  form-text encontrado desde el elemento [input|select|textarea (elemento campo origen)] como hermano o hijo del padre del elemento",4);

                    }
                    else{
                        $span = $this->driver->findElement($this->selector("#$span"));
                        $this->print("  form-text encontrado desde el data-span|data-formtext del elemento",4);
                    }

                }
                

                if(!($span instanceof RemoteWebElement) && !($input instanceof WebDriverBy) ){
                    throw new Exception("No se pudo encontrar el span de error por su selector");
                }
                if($input instanceof WebDriverBy ){

                    $this->print("  validando con estado de input o elemento .invalid-feedback",4);
                    if($input instanceof WebDriverBy and $span instanceof RemoteWebElement){
                        $this->driver->wait($timeout, $interval)->until(
                            function (RemoteWebDriver $driver) use ($elem, $span, $mensaje) {
                                /**
                                 * @var RemoteWebElement $span
                                 */
                                $validInput = !$this->driver->executeScript("return arguments[0].validity.valid", [$elem]);
                                if($mensaje != ""){
                                    $validSpan = $span->isDisplayed() && $span->getText() == $mensaje;
                                }
                                else{
                                    $validSpan = $span->isDisplayed();
                                }
    
                                return $validInput || $validSpan;
                                
                            }
                        );
                    }
                    else if($input instanceof WebDriverBy){
                        $this->driver->wait($timeout, $interval)->until(
                            function (RemoteWebDriver $driver) use ($elem, $span, $mensaje) {
                                /**
                                 * @var RemoteWebElement $span
                                 */
                                $validInput = !$this->driver->executeScript("return arguments[0].validity.valid", [$elem]);
    
                                return $validInput;
                                
                            }
                        );
                    }
                    else{
                        throw new Exception("No se pudo encontrar el span de error por su selector");
                    }

                }
                else{
                    $this->driver->wait($timeout, $interval)->until(
                        WebDriverExpectedCondition::visibilityOf($span)
                    );
                    
                }
                if($mensaje != ""){
                    if(!$span->getText() == $mensaje){
                        throw new Exception("El mensaje no es el esperado \nEsperado: {$mensaje} \nObtenido: {$span->getText()} != {$mensaje}");
                    }
                }
                return $span;
                
            } catch (\Throwable $th) {
                $this->print(" Error al esperar el elemento",3);
                echo "\n ($idElemnent) \n";
                echo $th->getMessage();
                throw $th;
            }
            
        }

        
        /**
         * Imprime una cadena con un icono al inicio
         * 
         * @param string $str la cadena a imprimir
         * @param int $icon el icono a imprimir (1: ✅, 2: ⚠ , 3:❌ , 4: 🔎, 5: ༼ つ ◕_◕ ༽つ, 6: `(*>﹏<*)′, 7: ✍(◔◡◔), 8: (✿◠‿◠))
         */
        public function print($str,$icon = 1){
            $icon--;
            $icons = [
                "✅",
                "⚠️",
                "❌",
                "🔎",
                "༼ つ ◕_◕ ༽つ",

                "`(*>﹏<*)′",
                
                "✍ (◔◡◔)",
                "(✿ ◠‿◠)"
            ];

            preg_match("/^([\t|\s]*)/", $str, $matches);
            $message = preg_replace("/^[\t|\s]*/", "", $str);
            echo $matches[1] . $icons[$icon] .' '. $message . "\n";
        }


        /**
         * Llena un select con el valor especificado
         * 
         * @param WebDriverBy|string $selectorOrigen el selector del elemento select
         * @param string $value el valor a buscar en el select
         * @param 'text'|'value' $selectBy el criterio de busqueda en el select (text o value)
         * @param int $timeout el tiempo de espera en segundos
         * @param int $interval el intervalo de espera en milisegundos
         * @param string $mensaje el mensaje a mostrar en caso de error
         * @throws Exception si no se encuentra el elemento o no se puede llenar el formulario
         */
        public function fillSelect($selectorOrigen, $value,$selectBy = 'text', $timeout = 3, $interval = 500, $mensaje = 'Elemento no encontrado') {
            try {
                $selector = $this->selector($selectorOrigen);
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($selector),
                    $mensaje
                );
                $select = $this->driver->findElement($selector);
                if ($select->getTagName() != 'select') {
                    throw new \Exception('El elemento no es un select');
                }
                
                $select->click();

                $options = $select->findElements(WebDriverBy::tagName('option'));
                $found = false;
                foreach ($options as $option) {
                    if ($selectBy == 'text' && $option->getText() == $value || $selectBy == 'value' && $option->getAttribute('value') == $value) {
                        $option->click();
                        $select->click();
                        $found = true;
                        break;
                    }
                }
                if(!$found){
                    throw new Exception("No se encontro el elemento");
                }

            } catch (\Exception $th) {
                $this->print("  Error seleccionar opcion de select". (is_string($selectorOrigen) ? " ({$selectorOrigen})" : '') ,3);
                echo "      {$th->getMessage()}\n";
            }
        }

        /**
         * Llena varios select con los valores especificados en un array.
         * Cada elemento del array debe tener una clave "selector" con el valor del selector del elemento select,
         * una clave "value" con el valor a buscar en el select y opcionalmente una clave "selectBy" con el criterio de busqueda en el select (text o value).
         * 
         * @param array{selector: WebDriverBy|string, value: string, selectBy?: 'text'|'value'}[] $elements un array con los elementos a llenar
         * * **selector: WebDriverBy|string** el selector del elemento select
         * * **value: string** el valor a buscar en el select
         * * **selectBy: 'text'|'value'** el criterio de busqueda en el select (text o value)
         * @param int $timeout el tiempo de espera en segundos
         * @param int $interval el intervalo de espera en milisegundos
         * @param string $mensaje el mensaje a mostrar en caso de error
         * @throws Exception si no se encuentra alguno de los elementos o no se puede llenar alguno de los formulario
         */
        public function fillSelects(array $elements, $timeout = 3, $interval = 500, $mensaje = 'Elemento no encontrado') {
            try {
                foreach ($elements as $element) {
                    $this->fillSelect($element['selector'], $element['value'], $element['selectBy'] ?? 'text', $timeout, $interval, $mensaje);
                }
            } catch (\Exception $th) {
                $this->print("Error al seleccionar opciones",3);
                echo "{$th->getMessage()}\n" ;
            }
        }


        /**
         * Busca una fila en una tabla con un texto especificado.
         * La busqueda se puede realizar en una columna especifica o en todas las columnas.
         * Si la columna es especificada, se busca con el texto especificado en esa columna.
         * Si no se especifica la columna, se busca el texto en todas las columnas.
         * 
         * @param string $tableSelector el selector del elemento table
         * @param string $text el texto a buscar en la tabla
         * @param int|null $inColumn la columna en la que se debe buscar el texto (si es null, se busca en todas las columnas)
         * @param int $timeout el tiempo de espera en segundos
         * @param int $interval el intervalo de espera en milisegundos
         * @param string $mensaje el mensaje a mostrar en caso de error
         * @return RemoteWebElement la fila encontrada con el texto especificado
         * @throws Exception si no se encuentra la tabla o no se puede buscar la fila con el texto especificado
         */
        public function findRowInTableByText($tableSelector, $text, $inColumn = null, $timeout = 3, $interval = 500, $mensaje = 'Elemento no encontrado') {
            try {
                $tableBy = $this->selector($tableSelector);
                $this->driver->wait($timeout, $interval)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated($tableBy),
                    $mensaje
                );
                $table = $this->driver->findElement($tableBy);
                if ($table->getTagName() != 'table') {
                    throw new \Exception('      El elemento no es una tabla');
                }


                $rows = $table->findElements(WebDriverBy::tagName('tr'));
                foreach ($rows as $row) {
                    $td = null;
                    if(is_int($inColumn)){
                        try {
                            $td = $row->findElement(WebDriverBy::xpath(".//td[{$inColumn}][contains(.,'{$text}')]"));
                            $this->print("      Fila encontrada con el texto especificado ( {$text} ) en la columna {$inColumn}");
                            break;
                        } catch (\Throwable $th) {
                            $td = null;
                        }
                    }
                    else{
                        try {
                            $td = $row->findElement(WebDriverBy::xpath(".//td[contains(.,'{$text}')]"));
                            $this->print("      Fila encontrada con el texto especificado ( {$text} )");
                            break;
                        } catch (\Throwable $th) {
                            $td = null;
                        }
                        
                    }
                }

                if ($td) {
                    return $row;
                };
                $this->print("      Fila no encontrada con el texto especificado ( {$text} ) ",6);
                throw new Exception("", 1);
            } catch (\Exception $th) {
                $this->print(" Error al buscar la fila en la tabla". (is_string($tableSelector) ? " ({$tableSelector})" : '') ,3);
                echo "      {$th->getMessage()}\n";
                throw $th;
            }
        }



    }

 ?>