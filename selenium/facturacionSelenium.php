<?php
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy; // Necesitas esta clase para localizar elementos
use Facebook\WebDriver\WebDriverExpectedCondition;

class FacturacionSelenium extends ComunSelenium {

    public function __construct(ApiController $testLink){
        parent::__construct();
        $this->testLink = $testLink;
    }

    public function testFacturacion(){
        $this->print("Inicio de test de facturacion",8);

        $this->openSystemDSG(true);

        // Llamamos a pruebas internas
        $this->testRegistraFacturacionSM();
        // $this->testConsultarCitaXCedula();
        // $this->testEliminarCita();
        // $this->closeBrowser(); 
    }

    public function testRegistraFacturacionSM(){

        $this->createSteps();
        $this->startContador();

        try{
            $this->goTo("Factura/factura");
            
            $formSearch = $this->waitElement('#form-buscador-factura');

            $formSearch->findElement(WebDriverBy::cssSelector('#inputBusPaCi'))->sendKeys("30218990");
            $formSearch->findElement(WebDriverBy::cssSelector('button.btn-buscar'))->click();
            $this->addSteps('p', 'Ingreso al modulo de facturación y búsqueda de paciente por cédula.');
            sleep(1);
            $this->waitElement('button#botonAgregar')->click();
            $this->waitElement('.insertar_servicio')->click();
            $this->waitElement('#siguiente')->click();
            $this->addSteps('p', 'Servicios medicos e insumos utilizados registrados.');
            $this->waitElement('#insertarServicio')->click();
            $this->waitElement('#btnSiguiente')->click();
            $this->waitElement('#botonPC')->click();
            $modalPago = $this->waitElement('#modal-pago');
            $modalPago->findElement(WebDriverBy::cssSelector('input[value="5"]'))->click();
            $this->addSteps('p', 'Método de pago seleccionado.');
            $this->waitElement('#btnTipoDePago')->click();
            $modalConfirmacion = $this->waitElement('#modal-confirmacion');
            $modalConfirmacion->findElement(WebDriverBy::cssSelector('button[type="submit"]'))->click();
            $this->addSteps('p', 'Facturación confirmada correctamente.');
        $this->endContador();

    } catch (Exception $e) {
        $this->blockSteps(5);
    }

    $status = $this->getStatusSteps();

    $this->testLink->reportTest(
        17,
        $status,
        $this->getSteps(),
        $this->lastTime
    );
}


    public function testEliminarCita(){

        $this->createSteps();
        $this->startContador();

        try{

            $this->goTo("Citas/citas");
            $this->addSteps('p', 'Página de Citas abierta correctamente.');

            // 1. Buscar la cita
            $this->fillForm('#dt-search-0', "30218990");
            $this->addSteps('p', 'buscar la cita segun la cedula.');

            sleep(2);

            $row = $this->findRowInTableByText('#tabla', '30218990',1);

            // 2. Click en eliminar
            $btn = $row->findElement(WebDriverBy::cssSelector('#eliminarCitaP'))->click();
            $this->addSteps('p', 'Botón de eliminar cita pulsado.');

            // 3. Confirmar en modal
            $idModal = $btn->getAttribute('data-id-tabla');
            $modalEliminar = $this->waitElement("#$idModal");
            $modalEliminar->findElement(WebDriverBy::xpath(".//a[text()='Eliminar']"))->click();

            $this->addSteps('p', 'Confirmada la eliminación de la cita.');

            $this->endContador();

        } catch(Exception $e){
            $this->blockSteps(4);
        }

        $status = $this->getStatusSteps();

        $this->testLink->reportTest(
            157, // ID TEST CASE TESTLINK
            $status,
            $this->getSteps(),
            $this->lastTime
        );
    }

    public function testConsultarCitaXCedula(){
        $this->createSteps();
        $this->startContador();

        try{

            $this->goTo("Citas/citas");
            $this->addSteps('p', 'Página de Citas abierta correctamente.');
            $this->addSteps('p', 'Selecciona filtrar por citas pendientes.');
            // 1. Buscar la cita
            $this->fillForm('#dt-search-0', "30218990", 0);
            
            $row = $this->findRowInTableByText('#tabla', '30218990',1);
            $this->addSteps('p', 'Se ha ingresado la cedula del paciente en el campo de busqueda.');
        }
        catch(Exception $e){
                $this->blockSteps(3);
            }

            $status = $this->getStatusSteps();

            $this->testLink->reportTest(
                145,
                $status,
                $this->getSteps(),
                $this->lastTime
            );
        }
}
?>