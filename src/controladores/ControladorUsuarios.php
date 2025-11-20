<?php

use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloRecuperarContr;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloRoles;


class ControladorUsuarios
{

    private $modelo;
    private $doctor;
    private $bitacora;
    private $inicioSesion;
    private $recuperarContr;
    private $permisos;
    private $roles;

    public function __construct()
    {
        $this->modelo = new ModeloUsuarios();
        $this->doctor = new ModeloDoctores();
        $this->bitacora = new ModeloBitacora();
        $this->inicioSesion = new ModeloInicioSesion();
        $this->recuperarContr = new ModeloRecuperarContr();
        $this->permisos = new ModeloPermisos();
        $this->roles = new ModeloRoles();
    }

    public function usuarios($parametro)
    {
        $ayuda = "btnayudaUsuario";
        $datosU  = $this->modelo->select();
        $vistaActiva = "usuarios";
        require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
    }

    public function usuariosAjax()
    {
        echo json_encode($this->modelo->select());
    }

    public function administradores($parametro)
    {
        $ayuda = "btnayudaAdministrador";
        $datosU  = $this->modelo->selectAdmin();
        $vistaActiva = "administradores";
        $datosRoles = $this->roles->roles();
        require_once './src/vistas/vistaUsuarios/vistaUsuariosAdmin.php';
    }

    public function administradoresAjax()
    {
        echo json_encode($this->modelo->selectAdmin());
    }

    // editar usuario
    public function editarUsuario()
    {

        $edicion = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES['imagenUsuario']["name"], $_FILES['imagenUsuario']['tmp_name'], $_POST['usuarioRegistrado']);


        if (is_array($edicion) && $edicion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un  usuario");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $edicion]);
            exit;
        }
    }

    // eliminación lógica de usuario
    public function borrarUsuario($datos)
    {
        $id_usuario = $datos[0];
        $id_usuario_bitacora = $datos[1];
        $eliminacion = $this->modelo->eliminacionLogica($id_usuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $this->bitacora->insertarBitacora($id_usuario_bitacora, "usuario", "Ha eliminado un  usuario");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    }
    public function registrarAdmin()
    {

        // Generamos la contraseña encriptada de la contraseña ingresada
        $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $id_usuario = $this->modelo->AgregarUsuarios($_POST["usuario"], $passwordEncrip, $_POST["correo"], $_POST["id_rol"]);

        $insercion = $this->doctor->RegistrarAdmin($_POST["nacionalidad"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["correo"], $id_usuario);

        if (is_array($insercion) && $insercion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha insertado un administrador ");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    }


    public function editarAdministrador()
    {

        $id_usuario = $this->modelo->updateUsuario($_POST["usuario"], $_POST["id_usuario"], $_FILES["imagenUsuario"]["name"], $_FILES["imagenUsuario"]["tmp_name"]);

        // Guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un administrador ");


        if (is_array($$id_usuario) && $$id_usuario[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha modificado un administrador ");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $id_usuario]);
            exit;
        }
    }


    public function eliminarAdministrador()
    {
        $eliminacion = $this->modelo->eliminacionLogica($_POST["id_usuario"]);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "usuario", "Ha eliminado un administador ");
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
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
