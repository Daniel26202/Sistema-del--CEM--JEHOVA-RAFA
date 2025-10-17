<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\

class ControladorPacientes
{
    private $modelo;
    private $bitacora;
    private $permisos;
    // private $hospitalizacion;


    function __construct()
    {
        $this->modelo = new ModeloPacientes;
        $this->bitacora = new ModeloBitacora; // Guarda la instancia de la bitacora
        $this->permisos = new ModeloPermisos();
        // $this->hospitalizacion = new ModeloHospitalizacion();
    }



    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }


    public function getPacientes($parametro)
    {
        $ayuda = "btnayudaPaciente";
        $pacientes = $this->modelo->index();
        $vistaActiva = 'pacientes';
        require_once './src/vistas/vistaPacientes/pacientes.php';
    }

    /* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
    public function getHistorialSalud($parametro)
    {
        $historial = $this->modelo->indexHistorial();
        $vistaActiva = 'historial';
        require './src/vistas/vistaPacientes/pacientes.php';
    }

    public function papeleraPaciente($parametro)
    {
        $pacientes = $this->modelo->indexPapelera();
        require_once './src/vistas/vistaPacientes/pacientesPapelera.php';
    }



    public function guardar()
    {
        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);
        // date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d");

        if ($resultadoDeCedula === "existeC") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorCedula");
        } elseif ($fecha <= $_POST['fn']) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorfecha");
        } else {

            $insercion = $this->modelo->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($insercion) {
                // guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha Insertado un nuevo paciente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/registro");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
            }
        }
    }

    public function setPaciente($cedula)
    {
        $cedula = $cedula[0];
        $resultadoDeCedula = $this->modelo->validarCedula($cedula);
        // date_default_timezone_set('America/Mexico_City');
        $fechaEditar = date("Y-m-d");

        //se verifica si la cédula del input es igual a la cédula ya existente 

        if ($fechaEditar <= $_POST['fn']) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorfecha");
            exit();
        } elseif ($cedula == $_POST["cedula"]) {

            $edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($edicion) {
                //guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
            }
            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($cedula != $_POST["cedula"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/error");
            } else {

                $edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

                if ($edicion) {
                    //guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");
                } else {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
                }
            }
        } else {

            $edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($edicion) {
                //guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
            }
        }
    }

    public function eliminar($datos)
    {
        $cedula = $datos[0];
        $id_usuario = $datos[1];
        // guardar la bitacora
        $eliminacion = $this->modelo->delete($cedula);

        if ($eliminacion) {
            $this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha eliminado un  paciente");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/eliminar");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
        }
    }
    public function restablecer($datos)
    {
        $id_paciente = $datos[0];
        $id_usuario = $datos[1];
        // guardar la bitacora
        $restablecimiento = $this->modelo->restablecer($id_paciente);
        if ($restablecimiento) {
            $this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha restablecido un paciente");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/restablecido");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
        }
    }


    public function mostrarPaciente()
    {
        $respuesta = $this->modelo->buscar($_POST['cedula']);
        echo json_encode($respuesta);
    }
}
