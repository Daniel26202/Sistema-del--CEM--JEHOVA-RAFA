<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;


class ModeloUsuarios extends ModelBase
{

    private $id_usuario, $usuario, $password, $correo, $imagen, $imagenTemporal, $id_rol, $usuarioRegistrado, $token_inicio_sesion;
    private $validator;
    use TraitCreate, TraitUpdate;

    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->validator = $vali;
    }

    // ── READ ────────────────────────────────────────────────
    //select all user

    public function selectAllUser()
    {
        $coditions = [
            'condiciones' => ['estado' => 'BLOQUED'],
            'conectores' => [''],
            'operadores' => ['!=']
        ];
        $alias = ['u', 'p', 'r'];
        $unions = [
            'p.usuario = u.id_usuario',
            'u.id_rol = r.id_rol'
        ];
        $this->set_tables(['segurity.usuario', 'bd.personal', 'segurity.rol']);
        $this->set_colums(['u.usuario AS user', 'u.id_usuario', 'u.id_rol', 'u.imagen', 'u.correo', 'p.id_personal', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido', 'p.telefono']);
        $this->set_condicion_aditional($coditions);
        $this->set_alias($alias);
        $this->set_union($unions);
        return $this->read();
    }


    //buscamos a los usuarios en la base de datos
    public function select()
    {
        $coditions = [
            'condiciones' => ['p.id_especialidad' => null, 'u.estado' => 'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['IS NOT', '=']
        ];
        $alias = ['u', 'p', 'r'];
        $unions = [
            'p.usuario = u.id_usuario',
            'u.id_rol = r.id_rol'
        ];
        $this->set_tables(['segurity.usuario', 'bd.personal', 'segurity.rol']);
        $this->set_colums(['u.usuario AS user', 'u.id_usuario', 'u.id_rol', 'u.imagen', 'u.correo', 'p.id_personal', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido', 'p.telefono']);
        $this->set_condicion_aditional($coditions);
        $this->set_alias($alias);
        $this->set_union($unions);
        return $this->read();
    }



    //buscamos a los usuarios en la base de datos
    public function selectAdmin()
    {
        $coditions = [
            'condiciones' => ['p.id_especialidad' => null, 'u.estado' => 'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['IS', '=']
        ];
        $alias = ['u', 'p', 'r'];
        $unions = [
            'p.usuario = u.id_usuario',
            'u.id_rol = r.id_rol'
        ];
        $this->set_tables(['segurity.usuario', 'bd.personal', 'segurity.rol']);
        $this->set_colums(['u.usuario AS user', 'u.id_usuario', 'u.id_rol', 'u.imagen', 'u.correo', 'p.id_personal', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido', 'p.telefono']);
        $this->set_condicion_aditional($coditions);
        $this->set_alias($alias);
        $this->set_union($unions);
        return $this->read();
    }

    public function selectUserInBlackList($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_usuario', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['estado' => 'BLOQUED'],
            'conectores' => [''],
            'operadores' => ['!=']
        ];
        $alias = ['u', 'p', 'r'];
        $unions = ['p.usuario = u.id_usuario', 'u.id_rol = r.id_rol'];
        $this->set_tables(["segurity.usuario", 'bd.personal', 'segurity.rol']);
        $this->set_colums(['u.usuario AS user', 'u.id_usuario', 'u.id_rol', 'u.imagen', 'u.correo', 'p.id_personal', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido', 'p.telefono']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);

        return $this->pagination();
    }


    //validar usuario
    public function validarUsuario()
    {
        $coditions = [
            'condiciones' => ['usuario' => $this->getUsuario(), 'id_proveedor' => $this->getIdUsuario()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["usuario"]);
        $this->set_colums(['id_usuario']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    //metodo para actualizar el token de inicio de sesión del usuario
    // public function actualizarTokenInicioSesion()
    // {
    //     $data = [
    //         'token_session' => $this->getTokenInicioSesion(),
    //     ];

    //     $sql = "UPDATE usuario SET token_session = :token_session WHERE id_usuario = :id";
    //     $this->setSQL($sql);

    //     $this->update($data, $this->getIdUsuario());
    //     return ['exito', $data];
    // }

    // Dentro de tu modelo
    // public function verificarTokenActivo()
    // {
    //     // Buscamos el token que manda actualmente en la base de datos
    //     $sql = "SELECT token_session FROM segurity.usuario WHERE id_usuario = :id";
    //     $this->setSQL($sql);
    //     $resultado = $this->search(['id' => $this->getIdUsuario()], false);

    //     return $resultado ? $resultado['token_session'] : null;
    // }

    // ── PRIVADOS─────────────────────────────────────────


    //esto es para editar un usuario.
    private function updateUsuario()
    {
        try {
            $this->beginTransaction();
            $coditions = [
                'condiciones' => ['id_usuario' => $this->getIdUsuario()],
                'conectores' => [],
                'operadores' => ['=']
            ];
            $this->set_tables(['usuario']);
            $this->set_colums(['id_usuario','imagen']);
            $this->set_condicion_aditional($coditions);

            $validar = $this->read(false);
            if ($validar == []) {
                throw new \Exception("el id usuario no existe.");
            }

            if ($this->validarUsuario()) {
                throw new \Exception("El usuario ya está registrado.");
            }

            $imagenNueva = $this->getImagen();
            $imagenAntigua = $validar['imagen'];
            $imagen = '';

            if ($imagenNueva) {
                // SI HAY IMAGEN NUEVA: Borrar la vieja y actualizar campo
                $rutaImagenAntigua = "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $imagenAntigua;
                if (!empty($imagenAntigua) && file_exists($rutaImagenAntigua)) {
                    unlink($rutaImagenAntigua);
                }
                move_uploaded_file($this->getImagenTemporal(), "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $imagenNueva);
                $imagen = $imagenNueva;
            } else {
                $imagen = $imagenAntigua;
            }

            $data = [
                'imagen' => $imagen,
                'usuario' => $this->getUsuario()
            ];
            $this->actualizar($data,['id_usuario'=>$this->getIdUsuario()],$this->validator);
            $this->commit();
            return [1];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }


    // private function agregar()
    // {
    //     try {
    //         $this->beginTransaction();
    //         $imagenU = $this->getImagen();

    //         $resultadoDeUsuario = $this->validarUsuario(['usuario' => $this->getUsuario()]);

    //         if ($resultadoDeUsuario) {

    //             throw new \Exception("Fallo el usuario ya existe...");
    //         } else {
    //             $imagenComprobacion = isset($imagenU['name']) ? $imagenU['name'] : false;
    //             if ($imagenComprobacion) {
    //                 $nombreImagenUsuario = $imagenU['name'];

    //                 $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, :id_rol, :imagen, :usuario, :correo, :password, "ACT")';
    //                 $this->setSQL($sqlUsuario);
    //                 $data = [
    //                     'imagen' => $nombreImagenUsuario,
    //                     'usuario' => $this->getUsuario(),
    //                     'correo' => $this->getCorreo(),
    //                     'password' => $this->getPassword(),
    //                     'id_rol' => $this->getIdRol()
    //                 ];
    //                 $id_usuario = $this->create($data);

    //                 $imagen = $id_usuario . "_" . $imagenU['name'];

    //                 $imagen_temporal = $imagenU['tmp_name'];
    //                 move_uploaded_file($imagen_temporal, "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $imagen);
    //                 return ($id_usuario);
    //             } else {
    //                 $nombreImagenUsuario = "doctor.png";

    //                 $sqlUsuario = 'INSERT INTO  usuario VALUES (Null, :id_rol, :imagen, :usuario, :correo, :password, "ACT")';
    //                 $this->setSQL($sqlUsuario);
    //                 $data = [
    //                     'imagen' => $nombreImagenUsuario,
    //                     'usuario' => $this->getUsuario(),
    //                     'correo' => $this->getCorreo(),
    //                     'password' => $this->getPassword(),
    //                     'id_rol' => $this->getIdRol()
    //                 ];
    //                 $id_usuario = $this->create($data);
    //                 $imagen = $nombreImagenUsuario;

    //                 $imagen_temporal = $imagenU['tmp_name'];
    //                 move_uploaded_file($imagen_temporal, "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $imagen);
    //                 $this->commit();
    //                 return ($id_usuario);
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         $this->rollBack();
    //         return $e->getMessage();
    //     }
    // }


    // ── PÚBLICOS  QUE LLAMAN A LOS PRIVADOS────────────────────


    // GETTERS Y SETTERS
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
    public function getTokenInicioSesion()
    {
        return $this->token_inicio_sesion;
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

    public function setTokenInicioSesion($token_inicio_sesion)
    {
        $this->token_inicio_sesion = $token_inicio_sesion;
    }
}
