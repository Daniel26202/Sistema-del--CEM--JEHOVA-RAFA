<?php

use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloRecuperarContr;
use App\modelos\ModeloPermisos;


class ControladorUsuarios
{

    private $modelo;
    private $doctor;
    private $bitacora;
    private $inicioSesion;
    private $recuperarContr;
    private $permisos;

    public function __construct()
    {
        $this->modelo = new ModeloUsuarios();
        $this->doctor = new ModeloDoctores();
        $this->bitacora = new ModeloBitacora();
        $this->inicioSesion = new ModeloInicioSesion();
        $this->recuperarContr = new ModeloRecuperarContr();
        $this->permisos = new ModeloPermisos();
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
    public function editarUsuario($datos)
    {

        $usuarioDb = $datos[0];

        $resultadoDeUsuario = $this->modelo->validarUsuario($_POST['usuario']);

        // NOTA: Esto "&&" es "Y"
        //se verifica si el usuario del input no es igual al usuario ya existente.  
        if ($_POST["usuario"] != $usuarioDb) {

            //verifica si el usuario es igual a la información de la base de datos.
            if ($resultadoDeUsuario === "existeU") {
                header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/error");
            } else {

                $edicion = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);

                if ($edicion) {
                    $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");
                    header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/editado");
                } else {
                    header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/errorSistem");
                }
            }

            //se verifica si el usuario del input es igual al usuario ya existente.  
        } elseif ($usuarioDb == $_POST["usuario"]) {

            $edicion = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);

            if ($edicion) {
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");
                header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/editado");
            } else {
                header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/errorSistem");
            }
        } else {
            $edicion = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name']);
            if ($edicion) {
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");
                header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/editado");
            } else {
                header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/errorSistem");
            }
        }
    }

    // eliminación lógica de usuario
    public function borrarUsuario()
    {
        $eliminacion = $this->modelo->eliminacionLogica($_POST["usuario"], $_POST["id_usuario"]);
        if ($eliminacion) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha eliminado un  usuario");
            header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/eliminado");
        } else {
            header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios/errorSistem");
        }
    }
    public function registrarAdmin()
    {

        // Generamos la contraseña encriptada de la contraseña ingresada
        $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $id_usuario = $this->modelo->AgregarAdministrador($_POST["usuario"], $passwordEncrip, $_POST["Correo"]);

        $insercion = $this->doctor->RegistrarAdmin($_POST["nacionalidad"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["Correo"], $id_usuario);
        if ($insercion) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha insertado un administrador ");
            header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores/registrado");
        } else {
            header("location:/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores/errorSistem");
        }
    }


    public function editarAdministrador()
    {

        $id_usuario = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES["imagenUsuario"]["name"], $_FILES["imagenUsuario"]["tmp_name"]);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un administrador ");

        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores/editado");
    }


    public function eliminarAdministrador()
    {
        $eliminacion = $this->modelo->eliminacionLogica($_POST["usuario"], $_POST["id_usuario"]);
        if ($eliminacion) {
            // Guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha eliminado un administador ");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores/eliminado");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores/errorSistem");
        }
    }

    public function verificarPassw()
    {
        if (isset($_POST["passwordActual"])) {
            $datosU = $this->inicioSesion->validarIniciarSesion($_GET["usuario"], $_POST["passwordActual"]);
            $verificar = ($datosU) ? "existe" : false;
            if ($verificar == "existe") {
                // Generamos la contraseña encriptada de la contraseña ingresada
                $passwordEncrip = password_hash($_POST["passwordNew"], PASSWORD_BCRYPT);

                $this->recuperarContr->updatePassword($datosU["id_usuario"], $passwordEncrip);
            }
            echo json_encode($datosU);
        }
    }

    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
