<?php
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy; // Necesitas esta clase para localizar elementos
use Facebook\WebDriver\WebDriverExpectedCondition;

class PacientesSelenium extends ComunSelenium{
    
    public function __construct(ApiController $testLink){
        parent::__construct();
        $this->testLink = $testLink;
    }
    

    public function testPacientes(){
        $this->print("Inicio de test de registro de paciente",8);
        $this->openSystemDSG(true);
        $this->testRegistrarPaciente();
        $this->testEliminarPaciente();
        $this->closeBrowser();
        
    }

    public function testRegistrarPaciente(){
        
        $this->createSteps();
        $this->startContador();
        try{
            $this->goTo("Pacientes/getPacientes");
             $this->click(selector: "button.btn-agregar-doctores.btnRegistrarPaciente");
             $modal = $this->waitElement('#modal-examplePaciente');
             $this->addSteps('p', 'Formulario de registro de paciente abierto correctamente.');
             $modal->findElement($this->selector('#cedula'))->sendKeys("30218990");
             $modal->findElement(WebDriverBy::cssSelector('#nombre'))->sendKeys("Jose");
             $modal->findElement(WebDriverBy::cssSelector('#apellido'))->sendKeys("Perez");
             $modal->findElement(WebDriverBy::cssSelector('#telefono'))->sendKeys("04260563224");
             $modal->findElement(WebDriverBy::cssSelector('#direccion'))->sendKeys("mi casa donde vivo");
             $modal->findElement(WebDriverBy::cssSelector('#fn'))->sendKeys("01/01/1990");
             $selectGenero = $modal->findElement(WebDriverBy::cssSelector('select[name="genero"]'));
             $options = $selectGenero->findElements(WebDriverBy::tagName('option'));
             foreach ($options as $option) {
                 if ($option->getText() === 'Masculino') {
                     $option->click();
                     break;
                 }
             }
             $this->addSteps('p', 'Se ha rellenado el formulario de registro de paciente.');
             $modal->findElement(WebDriverBy::cssSelector('#botonEnviar'))->click();
             $this->addSteps('p', 'Se ha pulsado el botón de registrar el paciente.');
             $this->driver->wait(5, 500)->until(
                         WebDriverExpectedCondition::invisibilityOfElementLocated($this->selector('#modal-examplePaciente')),
                     );
            $this->fillForm('#dt-search-0', "30218990",0);
            $row = $this->findRowInTableByText('#DataTables_Table_0', 'V-30218990');
            $this->endContador();


        }
        catch(Exception $e){
            $this->blockSteps(3);
        }
            $status = $this->getStatusSteps();
            $this->testLink->reportTest(
                4,
                $status,
                $this->getSteps(),
                $this->lastTime
            );
    }
    public function testEliminarPaciente(){
        $this->createSteps();
        $this->startContador();
        try{
            $this->goTo("Pacientes/getPacientes");
            $this->addSteps('p', 'Página de pacientes abierta correctamente.');
            sleep(2);
            $this->fillForm('#dt-search-0', "30218990",0);
            $row = $this->findRowInTableByText('#DataTables_Table_0', 'V-30218990');
            $this->addSteps('p', 'Se ha encontrado la fila de paciente.');
            $btn = $row->findElement(WebDriverBy::cssSelector('button.btnModalEliminarPaciente'))->click();
            $this->addSteps('p', 'Se ha pulsado el botón de eliminar.');
            $idModalEliminar =$btn->getAttribute('data-id-tabla');
            $modalEliminar = $this->waitElement("#$idModalEliminar");
            $modalEliminar->findElement(WebDriverBy::xpath(".//a[text()='Eliminar']"))->click();
            $this->addSteps('p', 'Se ha confirmado la eliminación del paciente.');

            $this->endContador();
            
        }
        catch(Exception $e){
            $this->blockSteps(4);
        }
            $status = $this->getStatusSteps();
            $this->testLink->reportTest(
                42,
                $status,
                $this->getSteps(),
                $this->lastTime
            );
            return;
    }
}
