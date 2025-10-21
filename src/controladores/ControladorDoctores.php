<?php

use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloConsultas;

class ControladorDoctores extends ModeloDoctores
{

    private $modelo;
    private $bitacora;
    private $permisos;
    private $modeloConsultas;


    public function __construct()
    {
        $this->modelo = new ModeloDoctores;
        $this->bitacora = new ModeloBitacora;
        $this->permisos = new ModeloPermisos;
        $this->modeloConsultas = new ModeloConsultas;
    }

    //muestro los datos de las cuatro tablas
    public function doctores($parametro)
    {
        $vistaActiva = 'doctores';
        $ayuda = "btnayudaDoctores";
        $datos = $this->modelo->select();
        $datosEspecialidades = $this->modelo->selectEspecialidad();
        $datosDias = $this->modelo->selectDias();
        $doctores = $this->modeloConsultas->mostrarDoctores();
        $todasLasServicios = $this->modeloConsultas->mostrarConsultas();
        require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
    }

    public function papelera($parametro)
    {
        $vistaActiva = 'papelera';
        $ayuda = "btnayudaDoctores";
        $datos = $this->modelo->desactivos();
        $datosEspecialidades = $this->modelo->selectEspecialidad();
        $datosDias = $this->modelo->selectDias();
        $doctores = $this->modeloConsultas->mostrarDoctores();
        $todasLasServicios = $this->modeloConsultas->mostrarConsultas();
        require_once "./src/vistas/vistaDoctores/vistaDoctores.php";
    }

    //metodo para mostrar los servicios de los doctores
    public function serviciosDoctor($datos)
    {
        echo json_encode($this->modeloConsultas->mostrarConsultasDoctor($datos[0]));
    }


    public function guardarDoctores()
    {
        //Validar si el doctor ya tiene ese servicio
        $servicio = $this->modeloConsultas->validarServicioDoctor($_POST["id_servicioMedico"], $_POST["id_doctor"]);

        if ($servicio === "existeC") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorS");
        } else {
            $insercion = $this->modeloConsultas->insertarDoctorServicio($_POST["id_doctor"], $_POST["id_servicioMedico"]);
            if ($insercion) {
                // Guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario'], "Consultas", "Ha añadido un servicio medico a un doctor");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/registro");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/errorSistem");
            }
        }
    }
    // agregar doctor
    public function agregarDoctor()
    {
        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);
        $resultadoDeUsuario = $this->modelo->validarUsuario($_POST['usuario']);
        // NOTA: Esto "||" es "o"
        if ($resultadoDeCedula === "existeC" || $resultadoDeUsuario === "existeU") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorD");
        } else {
            // Generamos la contraseña encriptada de la contraseña ingresada
            $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);

            // si encuentra la imagen la guardo en la variable si no le doy el valor false
            $imagen = isset($_FILES['imagenDoctores']['name']) ? $_FILES['imagenDoctores']['name'] : false;

            $imagenPorDefecto = "doctor.png";


            if ($imagen) {
                $insercion = $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $passwordEncrip,  $_POST['email'], $_POST['nacionalidad'], $_FILES['imagenDoctores']['name'], $_FILES['imagenDoctores']['tmp_name'], $_POST["selectEspecialidad"], $_POST['dias'], $_POST["horaSalida"], $_POST["horaEntrada"]);
                if ($insercion) {
                    // Guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario'], "doctor", "Ha Insertado un doctor");
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/registroD");
                } else {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
                }
            } else {
                $insercion = $this->modelo->insertarDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $passwordEncrip, $_POST['email'], $_POST['nacionalidad'], $imagenPorDefecto, "", $_POST["selectEspecialidad"], $_POST['dias'], $_POST["horaSalida"], $_POST["horaEntrada"]);
                if ($insercion) {
                    // Guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario'], "doctor", "Ha Insertado un doctor");
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/registroD");
                } else {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
                }
            }
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
        // (verificamos si se edito la cédula del  formulario o si es igual)
        if ($cedula == $_POST["cedula"]){ $resultadoDeCedula = false; }

        //verifica si la cédula es igual a la información de la base de datos.
        if ($resultadoDeCedula === "existeC") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorCedula");
        } else {
            $edicion = $this->modelo->updateDoctor($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["id_usuario"], $_POST["id_especialidad"], $_POST['email'], $_POST['nacionalidad'], $idDiaDbE, $idDiaNuevo, $igualesDb, $checkeds, $_POST["horaEntrada"], $_POST["horaSalida"]);
            if ($edicion) {
                // Guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "doctor", "Ha modificado un doctor");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
            }
        }
    }
    // eliminación lógica doctor
    public function borrarDoctor()
    {
        $eliminacion = $this->modelo->eliminacionLogica($_POST["id_usuario"]);
        if ($eliminacion) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "doctor", "Ha eliminado un doctor");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/eliminar");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
        }
    }

    // restablecer lógica doctor
    public function restablecer()
    {
        $restablecer = $this->modelo->restablecerDoctor($_POST["id_usuario"]);
        if ($restablecer) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "doctor", "Ha restablecido un doctor");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/papelera/restablecido");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
        }
    }

    //json para editar
    public function selectDiasDoctorEditar()
    {
        $respuesta = $this->modelo->selectDiasDoctor($_GET["id_personal"]);
        echo json_encode($respuesta);
    }
    public function registrarEspecialidad()
    {
        $insercion = $this->modelo->Especialidadregistrar($_POST['nombre']);
        if ($insercion) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario'], "especialidad", "Ha insertado una nueva especialidad");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/registro");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
        }
    }
    public function eliminarEspecialidad($datos)
    {
        $id_especialidad = $datos[0];
        $id_usuario =  $datos[1];
        $eliminacion = $this->modelo->Especialidadeliminar($id_especialidad);
        //Guardar la bitacora
        if ($eliminacion) {
            $this->bitacora->insertarBitacora($id_usuario, "especialidad", "Ha eliminado una especialidad");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/eliminar");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores/errorSistem");
        }
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
