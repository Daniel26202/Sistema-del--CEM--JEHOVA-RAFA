<?php

namespace App\modelos;

use App\modelos\Db;


class ModeloUsuarios extends Db
{


    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión

    }
    //buscamos a los usuarios en la base de datos
    public function select()
    {
        $sql = 'SELECT u.*, p.* FROM usuario u INNER JOIN personal p on p.id_usuario = u.id_usuario INNER JOIN rol r on u.id_rol = r.id_rol WHERE r.id_rol = 2 AND u.estado= "ACT" ';

        $consulta = $this->conexion->prepare($sql);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    //buscamos a los usuarios en la base de datos
    public function selectAdmin()
    {
        $sql = 'SELECT u.*, p.* FROM usuario u INNER JOIN personal p on p.id_usuario = u.id_usuario INNER JOIN rol r on u.id_rol = r.id_rol WHERE r.id_rol = 1 AND u.estado= "ACT" ';

        $consulta = $this->conexion->prepare($sql);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    //validar usuario
    public function validarUsuario($usuario)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM usuario WHERE usuario =:usuario");

        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeU";
        }
    }

    //esto es para editar un usuario.
    public function updateUsuario($usuario, $password, $idUsuario, $imagenUsuario, $imagenUsuarioTemporal)
    {

        if ($imagenUsuario == "") {
            $sql = 'UPDATE usuario SET  usuario = :usuario, password = :password WHERE id_usuario = :id_usuario';

            $consulta = $this->conexion->prepare($sql);


            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindParam(":password", $password);
            $consulta->bindParam(":id_usuario", $idUsuario);
            $consulta->execute();
        } else {
            $consultaImg = $this->conexion->prepare("SELECT imagen FROM usuario WHERE id_usuario=:id_usuario");
            $consultaImg->bindParam(":id_usuario", $idUsuario);
            $consultaImg->execute();
            $img = $consultaImg->fetch();
            $nombreImagenAntigua = $img["imagen"];

            //Editar el usuario.
            $sql = 'UPDATE usuario SET imagen = :imagen, usuario = :usuario, password = :password WHERE id_usuario = :id_usuario';

            $consulta = $this->conexion->prepare($sql);

            $consulta->bindParam(":imagen", $imagenUsuario);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindParam(":password", $password);
            $consulta->bindParam(":id_usuario", $idUsuario);
            if ($consulta->execute()) {
                $rutaImagenAntigua = "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $idUsuario . "_" . $nombreImagenAntigua;
                if (file_exists($rutaImagenAntigua) && $nombreImagenAntigua != "doctor.png") {

                    unlink($rutaImagenAntigua);
                }

                move_uploaded_file($imagenUsuarioTemporal, "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $idUsuario . "_" . $imagenUsuario);
            }
        }
    }

    //esto es para editar el estado (en activo a desactivo) del usuario.
    public function eliminacionLogica($usuario, $idUsuario)
    {

        //editar al doctor.
        $sqlUsuario = 'UPDATE usuario SET estado = "DES" WHERE id_usuario = :id_usuario  AND usuario = :usuario;';

        $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);


        $consultaDeUsuario->bindParam(":usuario", $usuario);
        $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);

        $consultaDeUsuario->execute();
    }
    public function AgregarAdministrador($usuario, $password, $correo)
    {

        $resultadoDeUsuario = $this->validarUsuario($_POST['usuario']);

        if ($resultadoDeUsuario === "existeU") {

            header("location: ?c=ControladorUsuarios/administradores&error");


        } else {
            $imagenComprobacion = isset($_FILES['imagenUsuario']['name']) ? $_FILES['imagenUsuario']['name'] : false;
            if ($imagenComprobacion) {
                $nombreImagenUsuario = $_FILES['imagenUsuario']['name'];

                $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, 1, :imagen, :usuario, :correo, :password, "ACT")';
                $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);
                $consultaDeUsuario->bindParam(":imagen", $nombreImagenUsuario);
                $consultaDeUsuario->bindParam(":usuario", $usuario);
                $consultaDeUsuario->bindParam(":correo", $correo);
                $consultaDeUsuario->bindParam(":password", $password);
                $consultaDeUsuario->execute();
                $id_usuario = $this->conexion->lastInsertId();
                $imagen = $id_usuario . "_" . $_FILES['imagenUsuario']['name'];

                $imagen_temporal = $_FILES['imagenUsuario']['tmp_name'];
                move_uploaded_file($imagen_temporal, "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                return ($id_usuario);
            } else {
                $nombreImagenUsuario = "doctor.png";

                $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, 1, :imagen, :usuario, :correo, :password, "ACT")';
                $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);
                $consultaDeUsuario->bindParam(":imagen", $nombreImagenUsuario);
                $consultaDeUsuario->bindParam(":usuario", $usuario);
                $consultaDeUsuario->bindParam(":correo", $correo);
                $consultaDeUsuario->bindParam(":password", $password);
                $consultaDeUsuario->execute();
                $id_usuario = $this->conexion->lastInsertId();
                $imagen = $nombreImagenUsuario;

                $imagen_temporal = $_FILES['imagenUsuario']['tmp_name'];
                move_uploaded_file($imagen_temporal, "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                return ($id_usuario);
            }
        }



    }




}
