<?php

use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicioSesion;


class ControladorUsuarios
{

    private $modelo;
    private $doctor;
    private $bitacora;
    private $inicioSesion;

    public function __construct()
    {
        $this->modelo = new ModeloUsuarios();
        $this->doctor = new ModeloDoctores();
        $this->bitacora = new ModeloBitacora();
        $this->inicioSesion = new ModeloInicioSesion();
    }

    public function usuarios($parametro)
    {

        $datosU = $this->modelo->select();
        require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
    }

    public function administradores($parametro)
    {

        $datosU = $this->modelo->selectAdmin();
        require_once './src/vistas/vistaUsuarios/vistaUsuariosAdmin.php';
    }

    // editar usuario
    public function editarUsuario()
    {


        $resultadoDeUsuario = $this->modelo->validarUsuario($_POST['usuario']);


        // NOTA: Esto "&&" es "Y"
        //se verifica si el usuario del input no es igual al usuario ya existente.  
        if ($_POST["usuario"] != $_GET["usuarioDb"]) {

            //verifica si el usuario es igual a la información de la base de datos.
            if ($resultadoDeUsuario === "existeU") {
                header("location:?c=ControladorUsuarios/usuarios&error");
            } else {

                $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);
                // Guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");

                header("location:?c=ControladorUsuarios/usuarios&editado");
            }

            //se verifica si el usuario del input es igual al usuario ya existente.  
        } elseif ($_GET["usuarioDb"] == $_POST["usuario"]) {

            $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");

            header("location:?c=ControladorUsuarios/usuarios&editado");
        } else {

            $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);

            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");

            header("location:?c=ControladorUsuarios/usuarios&editado");
        }
    }

    // eliminación lógica de usuario
    public function borrarUsuario()
    {

        $this->modelo->eliminacionLogica($_POST["usuario"], $_POST["id_usuario"]);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha eliminado un  usuario");

        header("location:?c=ControladorUsuarios/usuarios&eliminado");
    }
    public function registrarAdmin()
    {

        // Generamos la contraseña encriptada de la contraseña ingresada
        $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $id_usuario = $this->modelo->AgregarAdministrador($_POST["usuario"], $passwordEncrip, $_POST["Correo"]);

        $this->doctor->RegistrarAdmin($_POST["nacionalidad"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["Correo"], $id_usuario);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha insertado un administrador ");


        header("location:?c=ControladorUsuarios/administradores&registrado");
    }


    public function editarAdministrador()
    {

        $id_usuario = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES["imagenUsuario"]["name"], $_FILES["imagenUsuario"]["tmp_name"]);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un administrador ");

        header("location: ?c=ControladorUsuarios/administradores&editado");
    }


    public function eliminarAdministrador()
    {
        $this->modelo->eliminacionLogica($_POST["usuario"], $_POST["id_usuario"]);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha eliminado un administador ");


        header("location: ?c=ControladorUsuarios/administradores&eliminado");
    }

    public function verificarPassw()
    {
        if (isset($_POST["passwordActual"])) {
            $datosU = $this->inicioSesion->validarIniciarSesion($_GET["usuario"], $_POST["passwordActual"]);
            $verificar = ($datosU) ? "existe" : false;
            if ($verificar == "existe") {
                // Generamos la contraseña encriptada de la contraseña ingresada
                $passwordEncrip = password_hash($_POST["passwordNew"], PASSWORD_BCRYPT);

                $this->modelo->updatePassword($datosU["id_usuario"], $passwordEncrip);
            }
            echo json_encode($datosU);
        }
    }
}
