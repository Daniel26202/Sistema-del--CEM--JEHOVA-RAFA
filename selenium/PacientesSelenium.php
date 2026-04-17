<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy; // Necesitas esta clase para localizar elementos
use Facebook\WebDriver\WebDriverExpectedCondition;

class PacientesSelenium extends ComunSelenium
{

    public function __construct(ApiController $testLink)
    {
        parent::__construct();
        $this->testLink = $testLink;
    }


    public function testPacientes()
    {
        $this->print("Inicio de test de registro de paciente", 8);
        $this->openSystemDSG(true);
        $this->testRegistrarPaciente();
        $this->testEliminarPaciente();
        $this->closeBrowser();
    }

    // public function testRegistrarPaciente()
    // {

    //     $this->createSteps();
    //     $this->startContador();
    //     try {
    //         $this->goTo("Pacientes/getPacientes");
    //         $this->click("#btnOpenModal");
    //         $modal = $this->waitElement('#exampleModalagregarPaciente');
    //         $this->addSteps('p', 'Formulario de registro de paciente abierto correctamente.');
    //         $modal->findElement($this->selector('#cedulaPaciente'))->sendKeys("30218990");
    //         $modal->findElement(WebDriverBy::cssSelector('#nombre'))->sendKeys("Jose");
    //         $modal->findElement(WebDriverBy::cssSelector('#apellido'))->sendKeys("Perez");
    //         $modal->findElement(WebDriverBy::cssSelector('#telefono'))->sendKeys("04260563224");
    //         $modal->findElement(WebDriverBy::cssSelector('#direccion'))->sendKeys("mi casa donde vivo");
    //         $modal->findElement(WebDriverBy::cssSelector('#feNacimiento'))->sendKeys("1990-01-01");

    //         $selectGenero = $modal->findElement(WebDriverBy::cssSelector('select[name="genero"]'));
    //         $options = $selectGenero->findElements(WebDriverBy::tagName('option'));
    //         foreach ($options as $option) {
    //             if ($option->getText() === 'Masculino') {
    //                 $option->click();
    //                 break;
    //             }
    //         }
    //         $this->addSteps('p', 'Se ha rellenado el formulario de registro de paciente.');

    //         $modal->findElement(WebDriverBy::cssSelector('#botonEnviar'))->click();
    //         $this->addSteps('p', 'Se ha pulsado el botón de registrar el paciente.');

    //         $this->driver->wait(5, 500)->until(
    //             WebDriverExpectedCondition::invisibilityOfElementLocated($this->selector('#modal-examplePaciente')),
    //         );
    //         $this->fillForm('#dt-search-0', "30218990", 0);
    //         $row = $this->findRowInTableByText('#DataTables_Table_0', 'V-30218990');
    //         $this->endContador();
    //     } catch (Exception $e) {
    //         $this->blockSteps(4);
    //     }
    //     $status = $this->getStatusSteps();
    //     $this->testLink->reportTest(
    //         353,
    //         $status,
    //         $this->getSteps(),
    //         $this->lastTime
    //     );
    // }

    public function testRegistrarPaciente()
    {
        $this->createSteps();
        $this->startContador();
        try {
            $this->goTo("Pacientes/getPacientes");
            $this->click("#btnOpenModal");
            $modal = $this->waitElement('#exampleModalagregarPaciente');
            $this->addSteps('p', 'Formulario abierto correctamente.');

            // Función helper para llenar y disparar eventos
            $fillAndTrigger = function ($selector, $value) {
                $input = $this->driver->findElement(WebDriverBy::cssSelector($selector));
                $input->clear();
                $input->sendKeys($value);
                // Disparar eventos de validación
                $this->driver->executeScript(
                    "arguments[0].dispatchEvent(new Event('input', {bubbles:true}));
                 arguments[0].dispatchEvent(new Event('keyup', {bubbles:true}));
                 arguments[0].dispatchEvent(new Event('blur', {bubbles:true}));",
                    [$input]
                );
            };

            $fillAndTrigger('#cedulaPaciente', '30218990');
            $fillAndTrigger('input[name="nombre"]', 'Jose');
            $fillAndTrigger('input[name="apellido"]', 'Perez');
            $fillAndTrigger('input[name="telefono"]', '04260563224');
            $fillAndTrigger('input[name="direccion"]', 'mi casa donde vivo');

            // La fecha necesita JavaScript porque type="date" no acepta sendKeys bien
            $inputFecha = $this->driver->findElement(WebDriverBy::cssSelector('input[name="fn"]'));
            $this->driver->executeScript(
                "arguments[0].value = '1990-01-01';
             arguments[0].dispatchEvent(new Event('input', {bubbles:true}));
             arguments[0].dispatchEvent(new Event('blur', {bubbles:true}));",
                [$inputFecha]
            );

            // Seleccionar género
            $selectGenero = $modal->findElement(WebDriverBy::cssSelector('select[name="genero"]'));
            $options = $selectGenero->findElements(WebDriverBy::tagName('option'));
            foreach ($options as $option) {
                if ($option->getText() === 'Masculino') {
                    $option->click();
                    $this->driver->executeScript(
                        "arguments[0].dispatchEvent(new Event('input', {bubbles:true}));
                     arguments[0].dispatchEvent(new Event('blur', {bubbles:true}));",
                        [$selectGenero]
                    );
                    break;
                }
            }

            $this->addSteps('p', 'Formulario rellenado correctamente.');
            sleep(1); // Esperar que la validación procese

            $modal->findElement(WebDriverBy::cssSelector('#botonModal'))->click();
            $this->addSteps('p', 'Botón registrar presionado.');

            $this->driver->wait(5, 500)->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(
                    $this->selector('#exampleModalagregarPaciente')
                )
            );

            $this->fillForm('.dataTables_filter input', "30218990", 0);
            $row = $this->findRowInTableByText('.exampleTable', 'V-30218990');
            $this->endContador();
        } catch (Exception $e) {
            $this->blockSteps(3);
        }
        $status = $this->getStatusSteps();
        $this->testLink->reportTest(359, $status, $this->getSteps(), $this->lastTime);
    }

    public function testEliminarPaciente()
    {
        $this->createSteps();
        $this->startContador();
        try {
            $this->goTo("Pacientes/getPacientes");
            $this->addSteps('p', 'Página de pacientes abierta correctamente.');
            sleep(2);
            $this->fillForm('#dt-search-0', "30218990", 0);
            $row = $this->findRowInTableByText('#DataTables_Table_0', 'V-30218990');
            $this->addSteps('p', 'Se ha encontrado la fila de paciente.');
            $btn = $row->findElement(WebDriverBy::cssSelector('button.btnModalEliminarPaciente'))->click();
            $this->addSteps('p', 'Se ha pulsado el botón de eliminar.');
            $idModalEliminar = $btn->getAttribute('data-id-tabla');
            $modalEliminar = $this->waitElement("#$idModalEliminar");
            $modalEliminar->findElement(WebDriverBy::xpath(".//a[text()='Eliminar']"))->click();
            $this->addSteps('p', 'Se ha confirmado la eliminación del paciente.');

            $this->endContador();
        } catch (Exception $e) {
            $this->blockSteps(4);
        }
        $status = $this->getStatusSteps();
        $this->testLink->reportTest(
            353,
            $status,
            $this->getSteps(),
            $this->lastTime
        );
        return;
    }
}
