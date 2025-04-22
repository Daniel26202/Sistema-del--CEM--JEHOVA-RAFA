<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorDoctores extends ModeloDoctores
{

    private $modelo;
    private $bitacora;
    private $permisos;

    public function __construct()
    {
        $this->modelo = new ModeloDoctores;
        $this->bitacora = new ModeloBitacora;
        $this->permisos = new ModeloPermisos;
    }

    //muestro los datos de las cuatro tablas
    public function doctores($parametro)
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
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/error");
        } else {


            // Generamos la contraseña encriptada de la contraseña ingresada
            $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);

            // si encuentra la imagen la guardo en la variable si no le doy el valor false
            $imagen = isset($_FILES['imagenDoctores']['name']) ? $_FILES['imagenDoctores']['name'] : false;

            $imagenPorDefecto = "doctor.png";


            if ($imagen) {
                $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $passwordEncrip, $_POST["especialidad"], $_POST['email'], $_POST['nacionalidad'], $_FILES['imagenDoctores']['name'], $_FILES['imagenDoctores']['tmp_name'], $_POST["selectEspecialidad"]);
            } else {
                $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $passwordEncrip, $_POST["especialidad"], $_POST['email'], $_POST['nacionalidad'], $imagenPorDefecto, "", $_POST["selectEspecialidad"]);
            }

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario'],"doctor","Ha Insertado un doctor");




            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/registrado");
        }
        if ($resultadoDeUsuario === "existeU") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/Usuario");
        }
    }

    // editar doctor
    public function editarDoctor($datos)
    {
        $cedula = $datos[0];

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
        if ($cedula == $_POST["cedula"]) {

            $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds,$_POST["horaEntrada"],$_POST["horaSalida"]);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/editado");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($cedula != $_POST["cedula"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/error");

            } else {

                $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds, $_POST["horaEntrada"], $_POST["horaSalida"]);

                // Guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

                // // Guardar la bitacora
                // $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/editado");

            }
        } else {

            $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $_POST['selectEspecialidad'], $_POST['id_personalyespecialidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds, $_POST["horaEntrada"], $_POST["horaSalida"]);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha modificado un doctor");

            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/editado");

        }
    }
    // eliminación lógica doctor
    public function borrarDoctor()
    {

        $this->modelo->eliminacionLogica($_POST["cedula"], $_POST["usuario"], $_POST["id_usuario"], $_POST["id_personal"]);

        // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"doctor","Ha eliminado un doctor");

        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/eliminado");
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
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/especialidadRegistrar");
    }
    public function eliminarEspecialidad($datos)
    {
        $id_especialidad = $datos[0];
        $id_usuario =  $datos[1];
        $this->modelo->Especialidadeliminar($id_especialidad);
        //Guardar la bitacora
        $this->bitacora->insertarBitacora($id_usuario,"especialidad","Ha eliminado una especialidad");
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/especialidadEliminar");
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


    public function buscarHorario($datos)
    {
        $id_personal = $datos[0];
        $respuesta = $this->modelo->horarioDelDoctor($id_personal);
        echo json_encode($respuesta);
    }

    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
