<?php

namespace App\modelos;

use App\modelos\ModelBase;


class ModeloUsuarios extends ModelBase
{

    private $id_usuario, $usuario, $password, $correo, $imagen, $imagenTemporal, $id_rol, $usuarioRegistrado;

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }
    //buscamos a los usuarios en la base de datos
    public function select()
    {
        try {
            $sql = 'SELECT u.usuario as user, u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p on p.usuario = u.id_usuario INNER JOIN segurity.rol r on u.id_rol = r.id_rol WHERE u.estado= "ACT" AND p.id_especialidad IS NOT null';
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //buscamos a los usuarios en la base de datos
    public function selectAdmin()
    {
        try {
            $sql = 'SELECT u.usuario as user, u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p on p.usuario = u.id_usuario INNER JOIN segurity.rol r on u.id_rol = r.id_rol WHERE u.estado= "ACT" AND p.id_especialidad IS null';
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //validar usuario
    private function validarUsuario($data, $returnUsuario = false)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE usuario =:usuario";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            if ($returnUsuario) {
                return !empty($listData) ? $listData['usuario'] : 0;
            } else {
                return !empty($listData) ? 1 : 0;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }





    //esto es para editar un usuario.
    public function updateUsuario()
    {
        try {
            $this->beginTransaction();
            $sql = "SELECT * from usuario where id_usuario=:id_usuario";
            $this->setSQL($sql);
            $validar = $this->search(['id_usuario' => $this->getIdUsuario()]);
            if ($validar == []) {
                throw new \Exception("Fallo");
            }
            $usuario = $this->getUsuario();
            $usuarioRegistrado = $this->getUsuarioRegistrado();

            if ($usuario == $usuarioRegistrado) {
            } else {
                if ($this->validarUsuario(['usuario' => $this->getUsuario()], true)) {
                    throw new \Exception("El usuario ya está registrada.");
                }
            }

            if ($this->getImagen() == null) {

                $sql = 'UPDATE usuario SET  usuario = :usuario WHERE id_usuario = :id';
                $this->setSQL($sql);
                $this->update(['usuario' => $this->getUsuario()], $this->getIdUsuario());
            } else {
                $sql = "SELECT imagen FROM usuario WHERE id_usuario=:id_usuario";
                $this->setSQL($sql);
                $img = $this->search(['id_usuario' => $this->getIdUsuario()], false);
                $nombreImagenAntigua = $img["imagen"];

                // Editar el usuario.
                $data = [
                    'imagen' => $this->getImagen(),
                    'usuario' => $this->getUsuario()
                ];
                $sql = 'UPDATE usuario SET imagen = :imagen, usuario = :usuario WHERE id_usuario = :id';
                $this->setSQL($sql);

                $this->update($data, $this->getIdUsuario());

                $rutaImagenAntigua = "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $nombreImagenAntigua;
                if (file_exists($rutaImagenAntigua) && $nombreImagenAntigua != "doctor.png") {
                    unlink($rutaImagenAntigua);
                }

                move_uploaded_file($this->getImagenTemporal(), "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $this->getImagen());
            }
            $this->commit();
            return ["exito"];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    //esto es para editar el estado (en activo a desactivo) del usuario.
    public function eliminacionLogica()
    {
        try {
            $sql = "SELECT * from usuario where id_usuario=:id_usuario";
            $this->setSQL($sql);
            $validar = $this->search(['id_usuario' => $this->getIdUsuario()]);
            if ($validar == []) {
                throw new \Exception("Fallo el id no existe");
            }
            //editar al doctor.
            $sqlUsuario = 'UPDATE usuario SET estado = "DES" WHERE id_usuario = :id';
            $this->setSQL($sqlUsuario);
            $this->update_logic($this->getIdUsuario());
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function AgregarUsuarios()
    {
        try {
            $this->beginTransaction();
            $imagenU = $this->getImagen();

            $resultadoDeUsuario = $this->validarUsuario(['usuario' => $this->getUsuario()]);

            if ($resultadoDeUsuario) {

                throw new \Exception("Fallo el usuario ya existe...");
            } else {
                $imagenComprobacion = isset($imagenU['name']) ? $imagenU['name'] : false;
                if ($imagenComprobacion) {
                    $nombreImagenUsuario = $imagenU['name'];

                    $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, :id_rol, :imagen, :usuario, :correo, :password, "ACT")';
                    $this->setSQL($sqlUsuario);
                    $data = [
                        'imagen' => $nombreImagenUsuario,
                        'usuario' => $this->getUsuario(),
                        'correo' => $this->getCorreo(),
                        'password' => $this->getPassword(),
                        'id_rol' => $this->getIdRol()
                    ];
                    $id_usuario = $this->create($data);

                    $imagen = $id_usuario . "_" . $imagenU['name'];

                    $imagen_temporal = $imagenU['tmp_name'];
                    move_uploaded_file($imagen_temporal, "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                    return ($id_usuario);
                } else {
                    $nombreImagenUsuario = "doctor.png";

                    $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, :id_rol, :imagen, :usuario, :correo, :password, "ACT")';
                    $this->setSQL($sqlUsuario);
                    $data = [
                        'imagen' => $nombreImagenUsuario,
                        'usuario' => $this->getUsuario(),
                        'correo' => $this->getCorreo(),
                        'password' => $this->getPassword(),
                        'id_rol' => $this->getIdRol()
                    ];
                    $id_usuario = $this->create($data);
                    $imagen = $nombreImagenUsuario;

                    $imagen_temporal = $imagenU['tmp_name'];
                    move_uploaded_file($imagen_temporal, "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                    $this->commit();
                    return ($id_usuario);
                }
            }
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getIdRol()
    {
        return $this->id_rol;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getUsuarioRegistrado()
    {
        return $this->usuarioRegistrado;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getCorreo()
    {
        return $this->correo;
    }

    public function getImagenTemporal()
    {
        return $this->imagenTemporal;
    }

    public function getImagen()
    {
        return $this->imagen;
    }


    public function setImagenTemporal($imagenT)
    {
        // // Validar que el archivo se haya subido sin errores
        // if ($imagenT['error'] !== UPLOAD_ERR_OK) {
        //     throw new \InvalidArgumentException('Error al subir la imagen.');
        // }

        // // Validar extensión
        // $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        // $extension = strtolower(pathinfo($imagenT['name'], PATHINFO_EXTENSION));

        // if (!in_array($extension, $extensionesPermitidas)) {
        //     throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
        // }

        // // Validar tamaño (ejemplo: máximo 5 MB)
        // if ($imagenT['size'] > 5 * 1024 * 1024) {
        //     throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
        // }

        // Si todo está bien, guardamos el nombre temporal para moverlo después
        $this->imagenTemporal = $imagenT;
    }

    public function setImagen($imagen)
    {
        // Validar que el archivo se haya subido sin errores
        // if ($imagen['error'] !== UPLOAD_ERR_OK) {
        //     throw new \InvalidArgumentException('Error al subir la imagen.');
        // }

        // // Validar extensión
        // $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        // $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

        // if (!in_array($extension, $extensionesPermitidas)) {
        //     throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
        // }

        // // Validar tamaño (ejemplo: máximo 5 MB)
        // if ($imagen['size'] > 5 * 1024 * 1024) {
        //     throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
        // }

        // Si todo está bien, guardamos el nombre temporal para moverlo después
        $this->imagen = $imagen;
    }

    public function setIdUsuario($id_usuario)
    {
        if (!preg_match("/^[0-9]+$/", $id_usuario)) {
            throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
        }

        if ((int)$id_usuario <= 0) {
            throw new \InvalidArgumentException("El ID del usuario debe ser mayor que cero.");
        }

        $this->id_usuario = (int)$id_usuario;
    }

    public function setIdRol($id_rol)
    {
        if (!preg_match("/^[0-9]+$/", $id_rol)) {
            throw new \InvalidArgumentException("El ID del rol debe ser un número entero positivo.");
        }

        if ((int)$id_rol <= 0) {
            throw new \InvalidArgumentException("El ID del rol debe ser mayor que cero.");
        }

        $this->id_rol = (int)$id_rol;
    }

    public function setUsuario($usuario)
    {
        if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
            throw new \InvalidArgumentException("El usuario esta mal escrito.");
        }
        $this->usuario = $usuario;
    }

    public function setUsuarioRegistrado($usuario)
    {
        if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
            throw new \InvalidArgumentException("El usuario esta mal escrito.");
        }
        $this->usuarioRegistrado = $usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setCorreo($correo)
    {
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $correo)) {
            throw new \InvalidArgumentException("El correo debe estar bien escrito.");
        }
        $this->correo = $correo;
    }
}
