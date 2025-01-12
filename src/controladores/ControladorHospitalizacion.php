<?php
use App\modelos\ModeloHospitalizacion;

class ControladorHospitalizacion
{

    private $modelo;

    function __construct()
    {
        $this->modelo = new ModeloHospitalizacion();
    }
    // mostrar los datos de la tabla (hospitalizaciones pendientes) 
    public function traerSesion()
    {
        session_start();
        $sesion = $_SESSION['rol'];
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

    public function hospitalizacion()
    {
        // datos de los insumos
        $datosI = $this->modelo->selectsInsumos();
        require_once "./src/vistas/vistaHospitalizacion/hospitalizacion.php";
    }
    public function hospitalizacionesRealizadas()
    {
        require_once "./src/vistas/vistaHospitalizacion/hospitalizacionesRealizadas.php";
    }

    //traer enfermer@s
    public function traerEnfermer()
    {
        $datosEnf = $this->modelo->buscarEnfermer();
        echo json_encode($datosEnf);
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
    public function mostrarInsumos()
    {
        $infoInsumos = $this->modelo->buscarInsumos($_GET["nombre"]);
        echo json_encode($infoInsumos);
    }

    //mostrar la información de un insumo de la db 
    public function mostrarUnInsumo()
    {
        $infoInsumo = $this->modelo->buscarUnInsumo($_GET["id"]);
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
                header("location: ?c=ControladorHospitalizacion/hospitalizacion&error");
            } else {
                // no existe
                $idInsumo = (isset($_POST["id_insumo"])) ? $_POST["id_insumo"] : false;
                $cantidad = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : false;

                $this->modelo->insertarH($_POST["id_control"], $_POST["fecha"], $_POST["horas"], $_POST["precioHoras"], $_POST["total"], $idInsumo, $cantidad, $_POST["historial"]);

                header("location: ?c=ControladorHospitalizacion/hospitalizacion&agregado");


            }


        }
    }

    // traer datos de los insumos correspondiendo a la hospitalización que se edita.
    public function traerInsuDHEd()
    {
        $datosIDH = $this->modelo->EInsumosM($_GET["idH"]);
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
        header("location: ?c=ControladorHospitalizacion/hospitalizacion");
    }

    // elimina la hospitalización lógicamente (lo desactiva).
    public function eliminaL()
    {
        if (isset($_POST["idH"])) {

            $this->modelo->eliminaLogico($_POST["idH"]);
            header("location: ?c=ControladorHospitalizacion/hospitalizacion&eliminado");


        } else {

        }
    }

    public function traerHoraCosto()
    {
        $datosHC = $this->modelo->selectHC();
        echo json_encode($datosHC);
    }

    // editar costo y hora.
    public function editarHC()
    {
        if (isset($_GET["hora"])) {
            $this->modelo->updateHC($_GET["hora"], $_GET["costo"]);
        }
    }

    // editar el precio de horas y total de la hospitalización
    public function mostrarDHos()
    {
        $datosDHos = $this->modelo->buscarDH($_GET["idH"]);
        echo json_encode($datosDHos);
    }

    // editar el precio de horas y total de la hospitalización
    public function editarPHT()
    {
        $this->modelo->actualizarPHT($_GET["precio_h"], $_GET["total"], $_GET["idH"]);
    }

    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIExH()
    {
        $datosIns = $this->modelo->buscarIEH();
        echo json_encode($datosIns);
    }
}