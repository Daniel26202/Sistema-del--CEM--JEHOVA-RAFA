<?php
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy; // Necesitas esta clase para localizar elementos
use Facebook\WebDriver\WebDriverExpectedCondition;

class CitasSelenium extends ComunSelenium {

    public function __construct(ApiController $testLink){
        parent::__construct();
        $this->testLink = $testLink;
    }

    public function testCitas(){
        $this->print("Inicio de test de módulo Citas", 8);

        $this->openSystemDSG(true);

        // Llamamos a pruebas internas
        $this->testRegistrarCita();
        $this->testConsultarCitaXCedula();
        $this->testEliminarCita();
        $this->closeBrowser(); 
    }

    public function testRegistrarCita(){

        $this->createSteps();
        $this->startContador();

        try{
            // 1. Entrar al módulo Citas
            $this->goTo("Citas/citas");
            
            // 2. Abrir modal Registrar 
            $this->click("button.btn-agregar-doctores");
            $this->addSteps('p', 'Página de Citas y modal de registro cita abierto correctamente.');
            $modal = $this->waitElement('#modal-examplecita');

            // 3. Completar formulario 
            $modal->findElement(WebDriverBy::cssSelector('#cedulaCita'))->sendKeys("30218990");
            $modal->findElement(WebDriverBy::cssSelector('#buscarPacienteCita'))->click();
            $this->addSteps('p', 'Cédula del paciente ingresada y botón Buscar presionado.');
             $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('#contenedorFormCitas')
            )
        );

         // ========================
        //     SELECCIONAR SERVICIO
        // ======================== 
        $selectServ = $modal->findElement(WebDriverBy::cssSelector('#especialidad'));
        $options = $selectServ->findElements(WebDriverBy::tagName('option'));
        foreach ($options as $op) {
            if ($op->getText() == 'CARDIOLOGIA') {
                $op->click();
                break;
            }
        }

        // ========================
        //      SELECCIONAR DOCTOR
        // ========================

        $this->driver->wait(10, 500)->until(
    WebDriverExpectedCondition::presenceOfElementLocated(
        WebDriverBy::cssSelector('#listaDoctores input[type="radio"]')
    )
);

// Seleccionar el primer radio
$doctorRadio = $modal->findElement(WebDriverBy::cssSelector('#listaDoctores input[type="radio"]'));
$doctorRadio->click();


        // ========================
        //      SELECCIONAR FECHA
        // ========================

      /*   $inputFecha = $modal->findElement(WebDriverBy::cssSelector('#fecha')); */
        $this->fillForm('#fecha', "01-12-2025");

        // ========================
        //      SELECCIONAR HORA
        // ========================

        $modal->findElement(WebDriverBy::cssSelector('#horaCita'))->sendKeys("20:05");
        $this->addSteps('p', 'campos de la cita rellenados.');

        // ========================
        //        GUARDAR
        // ========================

        $modal->findElement(WebDriverBy::cssSelector('#btnAgregarCita'))->click();
        $this->addSteps('p', 'Botón Agregar cita presionado.');

        // 5. Esperar que modal cierre
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated($this->selector('#modal-examplecita'))
        );

        // 6. Verificar cita registrada buscándola en tabla
        $this->fillForm('#dt-search-0', "30218990", 0);
        $this->findRowInTableByText('#tabla', '30218990',1);


        $this->endContador();

    } catch (Exception $e) {
        $this->blockSteps(4);
    }

    $status = $this->getStatusSteps();

    $this->testLink->reportTest(
        138,
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