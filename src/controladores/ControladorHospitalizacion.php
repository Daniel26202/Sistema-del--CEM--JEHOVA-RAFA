<?php

use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloSintomas;

class ControladorHospitalizacion
{

    private $modelo;
    private $bitacora;
    private $permisos;
    private $inicio;
    private $modeloSintomas;
    private $modeloPatologia;

    function __construct()
    {
        $this->modelo = new ModeloHospitalizacion();
        $this->bitacora = new ModeloBitacora();
        $this->permisos = new ModeloPermisos();
        $this->inicio = new ModeloInicio();
        $this->modeloSintomas = new ModeloSintomas();
        $this->modeloPatologia = new ModeloPatologia();

        $this->semaforo();
    }

    public function semaforo()
    {
        // verifica si la sesión esta activa.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $cantidadHP = $this->modelo->semaforo();
        $_SESSION['semaforo'] = $cantidadHP[0];
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
        $sesion = [$_SESSION['rol'], $validacionCargo, $_SESSION['semaforo']];
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
        $doctores = $this->modelo->selectDoctores();

        $datosS = $this->modeloSintomas->selects();
        $datosPatologias = $this->modeloPatologia->mostrarPatologias();

        require_once "./src/vistas/vistaHospitalizacion/hospitalizacion.php";
    }
    public function hospitalizacionesRealizadas($parametro)
    {
        require_once "./src/vistas/vistaHospitalizacion/hospitalizacionesRealizadas.php";
    }

    public function selectServiciosD()
    {
        $servicios = $this->modelo->selectServiciosD();
        echo json_encode($servicios);
    }
    public function serviciosDH($datos)
    {
        $idH = $datos[0];
        $servicios = $this->modelo->selectServiciosDH($idH);
        echo json_encode($servicios);
    }

    //validar paciente 
    public function validarPaciente()
    {
        $vC = $this->modelo->validarPacienteH($_POST["cedula"]);
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

        if (empty($_POST['doctor']) || empty($_POST['diagnostico']) || empty($_POST['historial'])) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/error");
            return;
        }
        // verifica si la sesión esta activa.
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if ($_SESSION["semaforo"] >= 2) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/errSemaforo");
            // echo "Las camillas disponibles estan ocupadas";
        } else {

            $verificaH = $this->modelo->verificaHA($_POST["id_paciente"], $_POST["doctor"]);

            if (isset($_POST["id_paciente"])) {

                // es para validar si existe la hospitalización
                if ($verificaH) {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/error");
                } else {
                    // no existe
                    $idInsumo = (isset($_POST["id_insumo"])) ? $_POST["id_insumo"] : false;
                    $cantidadI = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;

                    $idServicio = (isset($_POST["id_servicio"])) ? $_POST["id_servicio"] : false;
                    $cantidadS = (isset($_POST["cantidadS"])) ? $_POST["cantidadS"] : false;


                    print_r($_POST);
                    $this->modelo->insertarH($_POST["fecha"], $idInsumo, $cantidadI, $_POST["historial"], $_POST["doctor"], $_POST["id_paciente"], $_POST["severidad"], $cantidadS, $idServicio, $_POST["diagnostico"]);

                    // Guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha Insertado una hospitalizacion");

                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/agregado");
                }
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

        $idServicio = (isset($_POST["id_servicio"])) ? $_POST["id_servicio"] : [];
        $cantidadS = (isset($_POST["cantidadS"])) ? $_POST["cantidadS"] : false;



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
        $this->modelo->editarH($idInsumo, $cantidadE, $cantidadA, $_POST["historialE"], $_POST["id_h"], $idIDH, $idInsElim, $_POST["diagnostico"], $idServicio, $cantidadS);
        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha modificado una hospitalización");
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion");
    }

    // elimina la hospitalización lógicamente (lo desactiva).
    public function eliminaL()
    {
        if (isset($_POST["idH"])) {
            $datosIDH = $this->modelo->EInsumosM($_POST["idH"]);
            print_r($_POST);
            $this->modelo->eliminaLogico($_POST["idH"], $datosIDH);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "hospitalizacion", "Ha eliminado una hospitalizacion");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion/eliminado");
        }
    }

    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIExH()
    {
        $datosIns = $this->modelo->buscarIEH();
        echo json_encode($datosIns);
    }

    // enviar los datos de la hospitalización a factura 
    public function enviarAFacturar()
    {
        $idH = $_POST["idH"];
        date_default_timezone_set('America/Caracas');
        $fechaHF = date("Y-m-d H:i:s");
        $monto = round($_POST["monto"], 2);
        $montoME = round($_POST["montoME"], 2);
        $total = round($_POST["total"], 2);
        $totalME = round($_POST["totalME"], 2);
        $this->modelo->facturarH($idH, $fechaHF, $monto, $montoME, $total, $totalME, $_POST["historialEnF"], $_POST["sintomas"], $_POST["patologias"], $_POST["nota"], $_POST["indicaciones"], $_POST["fechaRegreso"], $_POST["severidad"], $_POST["severidad"]);
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/facturarHospitalizacion/H$idH");
    }

    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
