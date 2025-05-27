<?php

use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;

class ControladorHospitalizacion
{

    private $modelo;
    private $bitacora;
    private $permisos;
    private $inicio;

    function __construct()
    {
        $this->modelo = new ModeloHospitalizacion();
        $this->bitacora = new ModeloBitacora();
        $this->permisos = new ModeloPermisos();
        $this->inicio = new ModeloInicio();
    }
    // mostrar los datos de la tabla (hospitalizaciones pendientes) 
    public function traerSesion()
    {
        // verifica si la sesión esta activa.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $idUsuario = $_SESSION['id_usuario'];
        $validacionCargo = $this->inicio->comprobarCargo($idUsuario);
        $sesion = [$_SESSION['rol'], $validacionCargo];
        // datos de las h. pendientes
        $datosH = $this->modelo->selectsH();
        $array = [$sesion, $datosH];
        echo json_encode($array);
    }
    // mostrar los datos de la tabla (hospitalizaciones realizadas) 
    public function traerSesionR()
    {
        session_start();
        $sesion = $_SESSION['rol'];
        // datos de las h. realizadas
        $datosH = $this->modelo->selectsHR();
        $array = [$sesion, $datosH];
        echo json_encode($array);
    }

    public function hospitalizacion($parametro)
    {
        // verifica si la sesión esta activa.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $idUsuario = $_SESSION['id_usuario'];
        $validacionCargo = $this->inicio->comprobarCargo($idUsuario);
        // datos de los insumos
        $datosI = $this->modelo->selectsInsumos();

        require_once "./src/vistas/vistaHospitalizacion/hospitalizacion.php";
    }
    public function hospitalizacionesRealizadas($parametro)
    {
        require_once "./src/vistas/vistaHospitalizacion/hospitalizacionesRealizadas.php";
    }


    //validar paciente 
    public function validarPaciente()
    {
        $vC = $this->modelo->validarPacienteH($_POST["cedula"]);
        echo json_encode($vC);
    }

    //validar control 
    public function validarControl()
    {
        $vC = $this->modelo->validarControlPaciente($_POST["cedula"]);
        echo json_encode($vC);
    }

    //mostrar la información de un paciente doctor y control de la db 
    public function mostrarInformacionPCD()
    {
        $info = $this->modelo->select($_POST["cedula"]);
        echo json_encode($info);
    }

    //mostrar la información de todos los insumos de la db 
    public function mostrarInsumos($datos)
    {
        $nombre = $datos[0];
        $infoInsumos = $this->modelo->buscarInsumos($nombre);
        echo json_encode($infoInsumos);
    }

    //mostrar la información de un insumo de la db 
    public function mostrarUnInsumo($datos)
    {
        $id = $datos[0];
        $infoInsumo = $this->modelo->buscarUnInsumo($id);
        echo json_encode($infoInsumo);
    }

    //para agregar hospitalización
    public function agregarH()
    {
        $verificaH = $this->modelo->verificaHA($_POST["id_control"]);

        print_r($verificaH);
        if (isset($_POST["id_control"])) {

            // es para validar si existe la hospitalización
            if ($verificaH === 1) {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/error");
            } else {
                // no existe
                $idInsumo = (isset($_POST["id_insumo"])) ? $_POST["id_insumo"] : false;
                $cantidad = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;


                // print_r($_POST);
                $this->modelo->insertarH($_POST["id_control"], $_POST["fecha"], $idInsumo, $cantidad, $_POST["historial"]);

                // Guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha Insertado una hospitalizacion");

                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/agregado");
            }
        }
    }

    // traer datos de los insumos correspondiendo a la hospitalización que se edita.
    public function traerInsuDHEd($datos)
    {
        $idH = $datos[0];
        $datosIDH = $this->modelo->EInsumosM($idH);
        echo json_encode($datosIDH);
    }

    // traer datos de los insumos correspondiendo a la hospitalización que se edita.
    public function modificarH()
    {
        // para verificar y agregar
        $idInsumo = (isset($_POST["id_insumoA"])) ? $_POST["id_insumoA"] : false;
        $cantidadA = (isset($_POST["cantidadA"])) ? $_POST["cantidadA"] : false;
        // para verificar y editar
        $idIDH = (isset($_POST["id_idh"])) ? $_POST["id_idh"] : false;
        $cantidadE = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;
        // empty() : verifica si la variable esta vacía, si esta vacío devolverá true. 
        // para verificar si a eliminado (nota 0 es el input 1, uno es el input 2)
        $idInsElim = (empty($_POST["id_insumos_eliminados"][0]) && empty($_POST["id_insumos_eliminados"][1])) ? false : $_POST["id_insumos_eliminados"];

        // si un input esta vacío y el otro no
        $idInsElimUD = ((empty($_POST["id_insumos_eliminados"][0]) && !empty($_POST["id_insumos_eliminados"][1])) || (!empty($_POST["id_insumos_eliminados"][0]) && empty($_POST["id_insumos_eliminados"][1]))) ? false : true;

        // si no elimino insumos la variable sera false
        if ($idInsElim) {

            // los dos inputs llenos
            if ($idInsElimUD) {
                // trasformo el texto en array separando lo por la coma(del segundo input)
                $arrayIE = explode(",", $idInsElim[1]);
                // elimino el ultimo array
                array_pop($arrayIE);

                // el JSON lo convierto en array. el true es para convertirlo en array asociativo
                $array = json_decode($idInsElim[0], true);
                // une los valores de los dos array en uno
                $arrayIE = array_merge($arrayIE, $array);

                // aquí se elimina los valores duplicados
                $arrayIE = array_unique($arrayIE);
                $idInsElim = $arrayIE;

                // un input vacío y uno lleno.
            } else if ($idInsElimUD === false) {

                // si el primer input está lleno devuelve true
                $inputU = (!empty($idInsElim[0])) ? true : false;

                // si el primer input esta lleno devuelve el primero
                if ($inputU) {
                    // el JSON lo convierto en array. el true es para convertirlo en array asociativo
                    $idInsElim = json_decode($idInsElim[0], true);

                    // si el primer input no esta lleno devuelve el segundo
                } else if ($inputU === false) {
                    // trasformo el texto en array separando lo por la coma
                    $idInsElim = explode(",", $idInsElim[1]);
                    // elimino el ultimo array
                    array_pop($idInsElim);
                }
            }
        }

        // esto se puede usar $_POST["id_controlE"]. 
        $this->modelo->editarH($_POST["horas"], $_POST["precioHoras"], $_POST["total"], $idInsumo, $cantidadE, $cantidadA, $_POST["historialE"], $_POST["id_h"], $idIDH, $idInsElim, $_POST["enfermer-e"]);
        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha modificado una hospitalizacion");
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion");
    }

    // elimina la hospitalización lógicamente (lo desactiva).
    public function eliminaL()
    {
        if (isset($_POST["idH"])) {
            $datosIDH = $this->modelo->EInsumosM($_POST["idH"]);

            $this->modelo->eliminaLogico($_POST["idH"], $datosIDH);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha eliminado una hospitalizacion");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/eliminado");
        } else {
        }
    }

    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIExH()
    {
        $datosIns = $this->modelo->buscarIEH();
        echo json_encode($datosIns);
    }

    // enviar los datos de la hospitalización a factura 
    public function enviarAFacturar($datos)
    {
        $idH = $datos[0];
        $fechaHF = $datos[1];
        $monto = $datos[2];
        $montoME = $datos[3];
        $total = $datos[4];
        $totalME = $datos[5];
        $info = $this->modelo->facturarH($idH, $fechaHF, $monto, $montoME, $total, $totalME);
        echo json_encode($info);
    }

    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
