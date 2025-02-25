<?php
namespace App\modelos;

use App\modelos\Db;

class ModeloRecuperarContr extends Db
{

    private $Db;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión
        $this->Db = $this; // Guarda la instancia de la conexión
    }

    // valido el usuario y el correo
    public function validarUC($usuario, $cE)
    {
        $consulta = $this->Db->prepare("SELECT id_usuario, usuario, correo FROM usuario WHERE usuario = :usuario AND correo = :ce AND estado = 'ACT'");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":ce", $cE);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // insertar datos de recuperación de contraseña
    public function insertDatosRC($idUsuario, $codigo, $fechaExp)
    {
        $consulta = $this->Db->prepare("INSERT INTO recuperar_contr(id_usuario, codigo, fecha_expiracion, intentos_fallidos) VALUES (:id_usuario, :codigo, :fecha_exp, 0)");
        $consulta->bindParam(":id_usuario", $idUsuario);
        $consulta->bindParam(":codigo", $codigo);
        $consulta->bindParam(":fecha_exp", $fechaExp);

        $consulta->execute();
    }

    // valido el código
    public function validarC($idUsuario, $codigo, $fechaHoy, $fechaDesbloqueo)
    {
        // verificación el codigo
        $consulta = $this->Db->prepare("SELECT * FROM recuperar_contr WHERE id_recuperar_contr = (SELECT MAX(id_recuperar_contr) as id_recuperar_contr FROM recuperar_contr WHERE id_usuario = :id_usuario) AND codigo = :codigo");
        $consulta->bindParam(":id_usuario", $idUsuario);
        $consulta->bindParam(":codigo", $codigo);

        // verificación de intentos fallidos 
        $consulta = $this->Db->prepare("SELECT * FROM recuperar_contr WHERE id_recuperar_contr = :id_recuperar_contr AND intentos_fallidos < 3");

        $resultadoIF = ($consulta->execute()) ? $consulta->fetch() : "bloqueado";


        $resultado = ($consulta->execute()) ? $consulta->fetch() : false;

        if ($resultado) {
            $idRecuperarContr = $resultado["id_recuperar_contr"];

            // verificación de fecha de expiración 
            $consulta = $this->Db->prepare("SELECT * FROM recuperar_contr WHERE id_recuperar_contr = :id_recuperar_contr AND fecha_expiracion > :fecha_hoy");
            $consulta->bindParam(":id_recuperar_contr", $idRecuperarContr);
            $consulta->bindParam(":fecha_hoy", $fechaHoy);

            $resultado = ($consulta->execute()) ? $consulta->fetch() : "expiro";

            if ($resultado === false || $resultado == "expiro" && $resultado != "bloqueado") {
                // se aumenta el intento fallido
                $consulta = $this->Db->prepare("UPDATE recuperar_contr SET intentos_fallidos =intentos_fallidos + 1 WHERE id_recuperar_contr = :id_recuperar_contr");
                $consulta->bindParam(":id_recuperar_contr", $idRecuperarContr);

                $consulta->execute();

            } else if ($resultadoIF == "bloqueado") {
                // se establece la fecha de desbloqueo 
                $consulta = $this->Db->prepare("UPDATE recuperar_contr SET fecha_desbloqueo= :fecha_desbloqueo WHERE id_recuperar_contr = :id_recuperar_contr");
                $consulta->bindParam(":id_recuperar_contr", $idRecuperarContr);
                $consulta->bindParam(":fecha_desbloqueo", $fechaDesbloqueo);

                $consulta->execute();
            }

            return $resultado;

        } else {
            // se aumenta el intento fallido
            $consulta = $this->Db->prepare("UPDATE recuperar_contr SET intentos_fallidos =intentos_fallidos + 1 WHERE id_recuperar_contr = (SELECT id_recuperar_contr 
            FROM (SELECT MAX(id_recuperar_contr) AS id_recuperar_contr FROM recuperar_contr WHERE id_usuario = 1) AS subconsulta)");
            $consulta->bindParam(":id_usuario", $idUsuario);

            $consulta->execute();

            // if ($resultadoIF == "bloqueado") {
            //     // se establece la fecha de desbloqueo 
            //     $consulta = $this->Db->prepare("UPDATE recuperar_contr SET fecha_desbloqueo= :fecha_desbloqueo WHERE id_recuperar_contr = (SELECT id_recuperar_contr 
            //     FROM (SELECT MAX(id_recuperar_contr) AS id_recuperar_contr FROM recuperar_contr WHERE id_usuario = :id_usuario) AS subconsulta)");
            //     $consulta->bindParam(":fecha_desbloqueo", $fechaDesbloqueo);
            //     $consulta->bindParam(":id_usuario", $idUsuario);


            //     $consulta->execute();
            // }

            return "incorrecto";
        }

    }


    // public function update($usuario, $ps, $rs, $password)
    // {
    //     $consulta = $this->Db->prepare("UPDATE usuario SET password =:password WHERE usuario =:usuario AND preguntaDeSeguridad =:ps AND respuestaDeSeguridad =:rs");
    //     $consulta->bindParam(":usuario", $usuario);
    //     $consulta->bindParam(":ps", $ps);
    //     $consulta->bindParam(":rs", $rs);
    //     $consulta->bindParam(":password", $password);
    //     $consulta->execute();
    // }
}

?>