<?php 
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy; // Necesitas esta clase para localizar elementos
use Facebook\WebDriver\WebDriverExpectedCondition;
class LoginSelenium extends ComunSelenium{
    
    public function __construct(ApiController $testLink){
        parent::__construct();
        $this->testLink = $testLink;
    }
    

    public function testLogin(){

        $this->openSystemDSG(true);
        $this->goTo("Pacientes/getPacientes");
        $this->click("adasfas",)
        
        //$this->testLoginInvalid();
        //sleep(1);
        //$this->testLoginValid();
        //$this->closeBrowser();


    }

    public function testLoginInvalid(){
        $this->createSteps();
        try {
            $this->startContador();
            $this->openSystemDSG(false);


            $this->waitUrl(url('Login'));
            
            $this->addSteps('p'); // ingresar al sistema

            $this->fillForms([
                ['selector' => 'input[name="correo"]', 'value' => 'admin@dsg.com'],
                ['selector' => 'input[name="clave"]', 'value' => 'hola123'],
            ]);
    
            $this->addSteps('p');

            $this->click('button[type="submit"]');

            echo "Credenciales ingresadas y clicado el botón. \n";
            
            $selectorError = 'form > div.text-danger.text-center.fw-medium > span';
            $this->waitElement($selectorError, 5, 500, 'No se muestra el mensaje de error.');

            $this->addSteps('p');

            $this->endContador();
            //code...
        } catch (\Throwable $th) {
            $this->blockSteps(3);
        }
        $status = $this->getStatusSteps();
        $this->testLink->reportTest(
            $this->testLink->getTestCaseByNameProp('TCAL01 - Login Invalido')['id'],
            $status,
            $this->getSteps(),
            $this->lastTime
        );
    }

    public function testLoginValid(){
        $this->createSteps();
        try {
            $this->startContador();
            $this->openSystemDSG(false);

            $this->waitUrl(url('Login'));

            $this->addSteps('p'); // ingresar al sistema
    
            $this->fillForm('input[name="correo"]', 'admin@dsg.com');
            $this->fillForm('input[name="clave"]', 'Hola123');

            $this->addSteps('p');

            $this->click('button[type="submit"]');

            echo "Credenciales ingresadas y clicado el botón. \n";

            $this->waitUrl(url());

            $this->addSteps('p');

            $this->endContador();
            //code...
        } catch (\Throwable $th) {
            $this->blockSteps(3);
        }
        $status = $this->getStatusSteps();
        /* $this->testLink->reportTest(
            $this->testLink->getTestCaseByNameProp('TCAL02 - Login Valido')['id'], // estan en la propiedad testCases de la clase ApiController
            $status,
            $this->getSteps(),
            $this->lastTime
        ); */
    }
}

?>