<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class PacientesSelenium extends ComunSelenium
{

    public function __construct(ApiController $testLink)
    {
        parent::__construct();
        $this->testLink = $testLink;
    }

    private $datosPacientes = [
        [
            'cedula'    => '32211990',
            'nombre'    => 'Jose',
            'apellido'  => 'Perez',
            'telefono'  => '04260563224',
            'direccion' => 'avenida libertador con calle cinco edificio central',
            'fn'        => '1990-01-01',
            'genero'    => 'Masculino',
        ],
        // [
        //     'cedula'    => '22163456',
        //     'nombre'    => 'Maria',
        //     'apellido'  => 'Lopez',
        //     'telefono'  => '04140123456',
        //     'direccion' => 'urb santa monica calle los mangos casa quince',
        //     'fn'        => '1985-06-15',
        //     'genero'    => 'Femenino',
        // ],
        // [
        //     'cedula'    => '12365632',
        //     'nombre'    => 'Carlos',
        //     'apellido'  => 'Gonzalez',
        //     'telefono'  => '04120987654',
        //     'direccion' => 'sector la trinidad avenida principal bloque ocho',
        //     'fn'        => '1995-03-20',
        //     'genero'    => 'Masculino',
        // ],
    ];

    //   comienza aca 
    public function testPacientes()
    {
        $this->print("Inicio de test de módulo Pacientes", 8);
        $this->openSystemDSG(true);

        foreach ($this->datosPacientes as $index => $paciente) {
            $this->print("--- Paciente " . ($index + 1) . " de " . count($this->datosPacientes) . " ---", 7);
            $this->testRegistrarPaciente($paciente);
            $this->testConsultarPacientePorCedula($paciente);
            $this->testEliminarPaciente($paciente);
        }

        $this->closeBrowser();
    }

    //   Registrar paciente
    public function testRegistrarPaciente(array $paciente)
    {
        $this->createSteps();
        $this->startContador();

        try {
            // navegar y abrir modal 
            $this->goTo("Pacientes/getPacientes");
            sleep(2);

            $this->click("#btnOpenModal");
            $modal = $this->waitElement('#exampleModalagregarPaciente', 5);
            $this->addSteps('p', 'Página de pacientes abierta y modal de registro visible.');

            // rellenar formulario y enviar
            //llenarYDisparar
            $fillAndTrigger = function (string $selector, string $value) {
                $input = $this->driver->findElement(WebDriverBy::cssSelector($selector));
                $input->clear();
                $input->sendKeys($value);
                $this->driver->executeScript(
                    "var el = arguments[0];
                     el.dispatchEvent(new Event('input',  {bubbles:true}));
                     el.dispatchEvent(new Event('keyup',  {bubbles:true}));
                     el.dispatchEvent(new Event('blur',   {bubbles:true}));",
                    [$input]
                );
            };

            $fillAndTrigger('#exampleModalagregarPaciente input[name="cedula"]',    $paciente['cedula']);
            $fillAndTrigger('#exampleModalagregarPaciente input[name="nombre"]',    $paciente['nombre']);
            $fillAndTrigger('#exampleModalagregarPaciente input[name="apellido"]',  $paciente['apellido']);
            $fillAndTrigger('#exampleModalagregarPaciente input[name="telefono"]',  $paciente['telefono']);
            $fillAndTrigger('#exampleModalagregarPaciente input[name="direccion"]', $paciente['direccion']);

            // fecha: type="date" necesita JS
            $inputFecha = $this->driver->findElement(
                WebDriverBy::cssSelector('#exampleModalagregarPaciente input[name="fn"]')
            );
            $this->driver->executeScript(
                "var el = arguments[0];
                 el.value = '{$paciente['fn']}';
                 el.dispatchEvent(new Event('input', {bubbles:true}));
                 el.dispatchEvent(new Event('blur',  {bubbles:true}));",
                [$inputFecha]
            );

            // Género
            $selectGenero = $modal->findElement(WebDriverBy::cssSelector('select[name="genero"]'));
            foreach ($selectGenero->findElements(WebDriverBy::tagName('option')) as $option) {
                if ($option->getText() === $paciente['genero']) {
                    $option->click();
                    $this->driver->executeScript(
                        "arguments[0].dispatchEvent(new Event('input', {bubbles:true}));
                         arguments[0].dispatchEvent(new Event('blur',  {bubbles:true}));",
                        [$selectGenero]
                    );
                    break;
                }
            }

            sleep(1);
            $modal->findElement(WebDriverBy::cssSelector('#botonModal'))->click();

            // Esperar que el modal cierre
            $this->driver->wait(10, 500)->until(
                WebDriverExpectedCondition::invisibilityOfElementLocated(
                    $this->selector('#exampleModalagregarPaciente')
                )
            );

            $this->addSteps('p', "Formulario de {$paciente['nombre']} {$paciente['apellido']} enviado y modal cerrado.");

            // verificar en tabla        
            
            // $this->goTo("Pacientes/getPacientes");
            // sleep(2);

            // $this->fillForm('#dt-search-0', $paciente['cedula'], 3);
            // sleep(1);

            // $this->findRowInTableByText('.exampleTable', 'V-' . $paciente['cedula']);
            // $this->addSteps('p', "Paciente V-{$paciente['cedula']} encontrado en la tabla.");

            $this->endContador();

        } catch (Exception $e) {
            $this->print("Error en testRegistrarPaciente: " . $e->getMessage(), 3);
            $this->blockSteps(3);
        }

        $status = $this->getStatusSteps();
        $this->testLink->reportTest(359, $status, $this->getSteps(), $this->lastTime);
    }

    //consultar paciente por cédula
    public function testConsultarPacientePorCedula(array $paciente)
    {
        $this->createSteps();
        $this->startContador();

        try {
            // $this->goTo("Pacientes/getPacientes");
            sleep(2);
            $this->addSteps('p', 'Página de pacientes abierta correctamente.');

            $this->fillForm('#dt-search-0', $paciente['cedula'], 3);
            sleep(1);
            $this->addSteps('p', "Cédula {$paciente['cedula']} ingresada en el buscador.");

            $this->findRowInTableByText('.exampleTable', 'V-' . $paciente['cedula']);
            $this->addSteps('p', "Paciente V-{$paciente['cedula']} encontrado correctamente.");

            $this->endContador();

        } catch (Exception $e) {
            $this->print("Error en testConsultarPacientePorCedula: " . $e->getMessage(), 3);
            $this->blockSteps(3);
        }

        $status = $this->getStatusSteps();
        $this->testLink->reportTest(348, $status, $this->getSteps(), $this->lastTime);
    }

    public function testEliminarPaciente(array $paciente)
    {
        $this->createSteps();
        $this->startContador();

        try {
            $this->goTo("Pacientes/getPacientes");
            sleep(2);
            $this->addSteps('p', 'Página de pacientes abierta correctamente.');

            $this->fillForm('#dt-search-0', $paciente['cedula'], 3);
            sleep(1);
            $row = $this->findRowInTableByText('.exampleTable', 'V-' . $paciente['cedula']);
            $this->addSteps('p', "Fila del paciente V-{$paciente['cedula']} localizada en la tabla.");

            // FIX: usamos JavaScript click en lugar de WebDriver click.
            // El click normal a veces no dispara el listener del evento
            // porque el elemento queda fuera del viewport o bajo algún
            // overlay invisible. JS click bypasea eso completamente.
            $btnEliminar = $row->findElement(WebDriverBy::cssSelector('button.btn-eliminar'));
            $this->driver->executeScript(
                "arguments[0].scrollIntoView({block:'center'});",
                [$btnEliminar]
            );
            // pequeña pausa tras el scroll
            sleep(1); 
            $this->driver->executeScript("arguments[0].click();", [$btnEliminar]);
            $this->addSteps('p', 'Botón eliminar presionado (JS click).');

            $this->confirmSweetAlert2("Eliminar SweetAlert2");
            sleep(2);
            $this->addSteps('p', "Eliminación de V-{$paciente['cedula']} confirmada.");

            $this->endContador();

        } catch (Exception $e) {
            $this->print("Error en testEliminarPaciente: " . $e->getMessage(), 3);
            $this->blockSteps(4);
        }

        $status = $this->getStatusSteps();
        $this->testLink->reportTest(353, $status, $this->getSteps(), $this->lastTime);
    }


    private function confirmSweetAlert2(string $descripcion = 'SweetAlert2', int $timeout = 7)
    {
        $this->driver->wait($timeout, 300)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('.swal2-popup')
            ),
            "Timeout esperando $descripcion (.swal2-popup no apareció en {$timeout}s)"
        );

        // Click en confirmar
        $this->driver->findElement(WebDriverBy::cssSelector('.swal2-confirm'))->click();

        // Esperar que desaparezca
        $this->driver->wait($timeout, 300)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(
                WebDriverBy::cssSelector('.swal2-popup')
            ),
            "Timeout esperando cierre de $descripcion"
        );
    }
}
