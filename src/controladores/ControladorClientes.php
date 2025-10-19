<?php

use App\modelos\ModeloCliente;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\

class ControladorClientes
{
    private $modelo;
    private $bitacora;
    private $permisos;
    // private $hospitalizacion;


    function __construct()
    {
        $this->modelo = new ModeloCliente;
        $this->bitacora = new ModeloBitacora; // Guarda la instancia de la bitacora
        $this->permisos = new ModeloPermisos();
        // $this->hospitalizacion = new ModeloHospitalizacion();
    }



    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }


    public function Clientes($parametro)
    {
        $ayuda = "btnayudaPaciente";
        $vistaActiva = 'clientes';
        $clientes = $this->modelo->index();
        require_once './src/vistas/vistaCliente/vistaCliente.php';
    }


    public function papelera($parametro)
    {
        $vistaActiva = 'papelera';
        $clientes = $this->modelo->indexPapelera();
        require_once './src/vistas/vistaCliente/vistaCliente.php';
    }



    public function guardar()
    {
        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);
        // date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d");

        if ($resultadoDeCedula === "existeC") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorCedula");
        } elseif ($fecha <= $_POST['fn']) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorfecha");
        } else {

            $insercion = $this->modelo->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($insercion) {
                // guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "cliente", "Ha Insertado un nuevo cliente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/registro");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
            }
        }
    }

    public function setCliente($cedula)
    {
        $cedula = $cedula[0];
        $resultadoDeCedula = $this->modelo->validarCedula($cedula);
        // date_default_timezone_set('America/Mexico_City');
        $fechaEditar = date("Y-m-d");

        //se verifica si la cédula del input es igual a la cédula ya existente 

        if ($fechaEditar <= $_POST['fn']) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/Clientes/errorfecha");
            exit();
        } elseif ($cedula == $_POST["cedula"]) {

            $edicion = $this->modelo->update($_POST['id_cliente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($edicion) {
                //guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "cliente", "Ha modificado un cliente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
            }
            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($cedula != $_POST["cedula"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/error");
            } else {

                $edicion = $this->modelo->update($_POST['id_cliente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

                if ($edicion) {
                    //guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario'], "cliente", "Ha modificado un cliente");
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/editar");
                } else {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
                }
            }
        } else {

            $edicion = $this->modelo->update($_POST['id_cliente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

            if ($edicion) {
                //guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
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
            $this->bitacora->insertarBitacora($id_usuario, "cliente", "Ha eliminado un  cliente");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/eliminar");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
        }
    }
    public function restablecer($datos)
    {
        print_r($datos);
        $cedula = $datos[0];
        $id_usuario = $datos[1];
        // guardar la bitacora
        $restablecimiento = $this->modelo->restablecer($cedula);
        if ($restablecimiento) {
            $this->bitacora->insertarBitacora($id_usuario, "cliente", "Ha restablecido un cliente");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/restablecido");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Clientes/Clientes/errorSistem");
        }
    }


}
