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
        require_once './src/vistas/vistaCliente/vistaCliente.php';
    }
    public function clientesAjax()
    {
        echo json_encode($this->modelo->index());
    }


    public function papelera($parametro)
    {
        $vistaActiva = 'papelera';
        require_once './src/vistas/vistaCliente/vistaCliente.php';
    }

    public function papeleraAjax()
    {
        echo json_encode($this->modelo->indexPapelera());
    }



    public function guardar()
    {
        $insercion = $this->modelo->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero']);

        // Verifica si es un array con clave "exito"
        if (is_array($insercion) && $insercion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario'], "cliente", "Ha Insertado un nuevo cliente");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    }

    public function setCliente()
    {

        $edicion = $this->modelo->update($_POST['id_cliente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero'], $_POST['cedulaRegistrada']);

        // // Verifica si es un array con clave "exito"
        if (is_array($edicion) && $edicion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario'], "cliente", "Ha modificado un cliente");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $edicion]);
            exit;
        }
    }

    public function eliminar($datos)
    {
        $cedula = $datos[0];
        $id_usuario = $datos[1];

        $eliminacion = $this->modelo->delete($cedula);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $this->bitacora->insertarBitacora($id_usuario, "cliente", "Ha eliminado un  cliente");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    }
    public function restablecer($datos)
    {

        $id_cliente = $datos[0];
        $id_usuario = $datos[1];

        $restablecimiento = $this->modelo->restablecer($id_cliente);

        if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
            $this->bitacora->insertarBitacora($id_usuario, "cliente", "Ha restablecido un  cliente");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $restablecimiento]);
            exit;
        }
    }
}
