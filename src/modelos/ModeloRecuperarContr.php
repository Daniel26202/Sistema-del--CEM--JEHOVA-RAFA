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


    public function updatePassword($id_usuario, $password)
    {

            $consulta = $this->Db->prepare('UPDATE usuario SET  password = :password WHERE id_usuario = :id_usuario');
            
            $consulta->bindParam(":password", $password);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->execute();

    }
    
}

?>