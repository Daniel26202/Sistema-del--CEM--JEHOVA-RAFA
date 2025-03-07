<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;

class ControladorDoctores extends ModeloDoctores
{

    private $modelo;
    private $bitacora;

    public function __construct()
    {
        $this->modelo = new ModeloDoctores;
        $this->bitacora = new ModeloBitacora;
    }

    //muestro los datos de las cuatro tablas
    public function doctores()
    {

        $datos = $this->modelo->select();
        $datosEspecialidades = $this->modelo->selectEspecialidad();
        $datosDias = $this->modelo->selectDias();
        require_once "./src/vistas/vistaDoctores/doctores.php";
    }

    // agregar doctor
    public function agregarDoctor()
    {


        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);
        $resultadoDeUsuario = $this->modelo->validarUsuario($_POST['usuario']);

        // NOTA: Esto "||" es "o"
        if ($resultadoDeCedula === "existeC" || $resultadoDeUsuario === "existeU") {
            header("location: ?c=ControladorDoctores/doctores&error");
        } else {

            // convierte el texto en mayúscula


            // si encuentra la imagen la guardo en la variable si no le doy el valor false
            $imagen = isset($_FILES['imagenDoctores']['name']) ? $_FILES['imagenDoctores']['name'] : false;

            $imagenPorDefecto = "doctor.png";


            if ($imagen) {
                $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $_POST["password"], $_POST["especialidad"], $_POST['email'], $_POST['nacionalidad'], $_FILES['imagenDoctores']['name'], $_FILES['imagenDoctores']['tmp_name'], $_POST["selectEspecialidad"]);
            } else {
                $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $_POST["password"], $_POST["especialidad"], $_POST['email'],  $_POST['nacionalidad'], $imagenPorDefecto, "",$_POST["selectEspecialidad"]);

            }

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario'],"doctor","Ha Insertado un doctor");




            header("location: ?c=controladorConsultas/consultas&registrado");
        }
        if($resultadoDeUsuario === "existeU"){
            header("location: ?c=ControladorDoctores/doctores&Usuario");
        }
    }

    // editar doctor
    public function editarDoctor()
    {

        $idDiaDbE = array_diff($_POST["diaAnterio"], $_POST["dias"]);
        $idDiaNuevo = array_diff($_POST["dias"], $_POST["diaAnterio"]);
        $igualesDb = array_intersect($_POST["dias"], $_POST["diaAnterio"]);
        $checkeds = $_POST["dias"];

        // Usar el operador ternario para verificar si $idDiaDbE está vacío
        $idDiaDbE = !empty($idDiaDbE) ? $idDiaDbE : false;
        $idDiaNuevo = !empty($idDiaNuevo) ? $idDiaNuevo : false;
        $igualesDb = !empty($igualesDb) ? $igualesDb : false;

        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);

        //se verifica si la cédula del input es igual a la cédula ya existente 
        if ($_GET["cedulaDb"] == $_POST["cedula"]) {

            $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds,$_POST["horaEntrada"],$_POST["horaSalida"]);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

            header("location:?c=ControladorDoctores/doctores&editado");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($_GET["cedulaDb"] != $_POST["cedula"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
                header("location:?c=ControladorDoctores/doctores&error");

            } else {

                $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds,$_POST["horaEntrada"],$_POST["horaSalida"]);

                // Guardar la bitacora
                 $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

                header("location:?c=ControladorDoctores/doctores&editado");

            }
        } else {

            $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds,$_POST["horaEntrada"],$_POST["horaSalida"]);
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

            header("location:?c=ControladorDoctores/doctores&editado");

        }
    }
    // eliminación lógica doctor
    public function borrarDoctor()
    {

        $this->modelo->eliminacionLogica($_POST["cedula"], $_POST["usuario"], $_POST["id_usuario"], $_POST["id_personal"]);

        // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha eliminado un doctor");

        header("location:?c=ControladorDoctores/doctores&eliminado");
    }

    //json para editar
    public function selectDiasDoctorEditar()
    {
        $respuesta = $this->modelo->selectDiasDoctor($_GET["id_personal"]);
        echo json_encode($respuesta);
    }
    public function registrarEspecialidad()
    {
        $this->modelo->Especialidadregistrar($_POST['nombre']);
        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario'],"especialidad","Ha insertado una nueva especialidad");
        header("location: ?c=ControladorDoctores/doctores&especialidadRegistrar");
    }
    public function eliminarEspecialidad()
    {
        $this->modelo->Especialidadeliminar($_GET['id_especialidad']);
        //Guardar la bitacora
        $this->bitacora->insertarBitacora($_GET['id_usuario'],"especialidad","Ha eliminado una especialidad");
        header("location: ?c=ControladorDoctores/doctores&especialidadEliminar");
    }

    public function buscarEspecialidad()
    {
        $respuesta = $this->modelo->especialidadBuscar($_POST["nombre"]);
        echo json_encode($respuesta);
    }
    public function buscarDoctor()
    {
        $respuesta = $this->modelo->doctorBuscar($_POST["busqueda"]);
        echo json_encode($respuesta);
    }


    public function buscarHorario()
    {
        $respuesta = $this->modelo->horarioDelDoctor($_GET["id_personal"]);
        echo json_encode($respuesta);
    }
}
