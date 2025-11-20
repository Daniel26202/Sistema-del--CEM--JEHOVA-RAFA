<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloUsuarios;

class ModeloDoctores extends Db
{

    private $conexion;
    private $modeloUsuario;

    public function __construct()
    {
        $this->conexion = $this->connectionSistema();
        $this->modeloUsuario = new ModeloUsuarios();
    }

    //seleccionar especialidad
    public function selectEspecialidad()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM especialidad WHERE estado = 'ACT'");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //seleccionar los dias que el doctor puedad trabajar
    public function selectDias()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM horario");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function selectDiasDoctor($id_personal)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT h.*,hyd.* FROM horario h INNER JOIN horarioydoctor hyd ON  h.id_horario = hyd.id_horario INNER JOIN personal p ON p.id_personal = hyd.id_personal WHERE p.id_personal = :id_personal AND p.tipodecategoria = 'Doctor'");
            $consulta->bindParam(":id_personal", $id_personal);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //validar usuario
    public function validarUsuario($usuario)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario =:usuario");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            while ($consulta->fetch()) {
                return "existeU";
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //validar cédula
    public function validarCedula($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE p.cedula = :cedula");
            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();
            while ($consulta->fetch()) {
                return "existeC";
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //selecciono las cuatro tablas
    public function select()
    {
        try {
            $sql = 'SELECT u.*, p.*, p.nombre as nombre_d, es.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad  inner join segurity.rol r on r.id_rol = u.id_rol WHERE u.estado = "ACT" AND  es.id_especialidad is not null';
            $consulta = $this->conexion->prepare($sql);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //papelera
    public function desactivos()
    {
        try {
            $sql = 'SELECT u.*, p.*, p.nombre as nombre_d, es.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad  inner join segurity.rol r on r.id_rol = u.id_rol WHERE u.estado = "DES" AND  es.id_especialidad is not null ';
            $consulta = $this->conexion->prepare($sql);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }
    //esto es para agregar un doctor.
    public function insertarDoctor($cedula, $nombre, $apellido, $telefono, $usuario, $password, $email, $nacionalidad, $nombreImagen, $imagenTemporal, $idEspecialidad, $dias, $horaSalida, $horaEntrada, $imagen)
    {

        try {
            $this->conexion->beginTransaction();

            if ($this->validarCedula($cedula) === "existeC") {
				throw new \Exception("La cédula ya está registrada.");
            }

            if ($this->validarUsuario($usuario) === "existeU") {
                throw new \Exception("El usuario ya está registrada.");
            }

            if (!$imagen) {
                $nombreImagen= 'doctor.png';
                $imagenTemporal = "";
            } 

            //agregamos al doctor como usuario.
            $consultaDeUsuario = $this->conexion->prepare('INSERT INTO segurity.usuario(id_rol, imagen, usuario, correo,  password, estado) VALUES (8,:imagen, :usuario, :correo, :password,"ACT");');
            $consultaDeUsuario->bindParam(":imagen", $nombreImagen);
            $consultaDeUsuario->bindParam(":usuario", $usuario);
            $consultaDeUsuario->bindParam(":correo", $email);
            $consultaDeUsuario->bindParam(":password", $password);
            $consultaDeUsuario->execute();
            //devuelve el id del usuario.
            //obtenemos los datos del usuario que se a agregado. si no se inserta devuelve 0
            $idUsuario = ($this->conexion->lastInsertId() == 0) ? false : $this->conexion->lastInsertId();

            //agregamos al doctor como usuario.
            $consultaDePersonal = $this->conexion->prepare('INSERT INTO bd.personal(nacionalidad, cedula, nombre, apellido, telefono, id_especialidad, usuario) VALUES (:nacionalidad,:cedula,:nombre,:apellido,:telefono,:id_especialidad,:id_usuario)');
            $consultaDePersonal->bindParam(":cedula", $cedula);
            $consultaDePersonal->bindParam(":nombre", $nombre);
            $consultaDePersonal->bindParam(":apellido", $apellido);
            $consultaDePersonal->bindParam(":telefono", $telefono);
            $consultaDePersonal->bindParam(':nacionalidad', $nacionalidad);
            $consultaDePersonal->bindParam(':id_usuario', $idUsuario);
            $consultaDePersonal->bindParam(':id_especialidad', $idEspecialidad);
            $consultaDePersonal->execute();
            //devuelve el id del personal.
            //obtenemos los datos del pesonal que se a agregado. si no se inserta devuelve 0
            $idPersonal = ($this->conexion->lastInsertId() == 0) ? false : $this->conexion->lastInsertId();

            if ($idUsuario != 0) {
                if ($imagenTemporal != "") {
                    $imagen = $idUsuario . "_" . $nombreImagen;
                    move_uploaded_file($imagenTemporal, "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                }
            }

            //esto es para insertar el horario
            if ($dias != "NO") {
                $contadorDias = 0;
                foreach ($dias as $d) {
                    $sqlHorario = $this->conexion->prepare("INSERT INTO bd.horarioydoctor (id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (:id_personal,:id_horario,:horarioDeEntrada,:horaDeSalida)");
                    $sqlHorario->bindParam(":id_personal", $idPersonal);
                    $sqlHorario->bindParam(":id_horario", $d);
                    $sqlHorario->bindParam(":horarioDeEntrada", $horaEntrada[$contadorDias]);
                    $sqlHorario->bindParam(":horaDeSalida", $horaSalida[$contadorDias]);
                    $sqlHorario->execute();
                    $contadorDias++;
                }
            }
            $id = $this->conexion->lastInsertId();

            $consulta = $this->conexion->prepare("SELECT * from bd.personal where id_personal=:id_personal");
            $consulta->bindParam(":id_personal", $id);
            $consulta->execute();
            $data = ($consulta->execute()) ? $consulta->fetch() : false;

            $this->conexion->commit();
            return ["exito", $data];
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return $e->getMessage();
        }
    }

    //esto es para editar un doctor.
    public function updateDoctor($cedula, $nombre, $apellido, $telefono, $idUsuario, $idEspecialidad, $email, $nacionalidad, $diasE, $diasN, $diasEditar, $checkeds, $horaEntrada, $horaSalida)
    {
        try {
            $this->conexion->beginTransaction();

            $validar = $this->conexion->prepare("SELECT * from personal where usuario=:idUsuario");
            $validar->bindParam(":idUsuario", $idUsuario);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            $consultaU = $this->conexion->prepare('SELECT id_personal FROM personal  WHERE usuario = :id_usuario');
            $consultaU->bindParam(":id_usuario", $idUsuario);
            $consultaU->execute();
            $idPersonal = ($consultaU->execute()) ? $consultaU->fetch() : false;

            //Editar el usuario (el usuario del doctor).
            $consultaDeUsuario = $this->conexion->prepare('UPDATE personal SET nacionalidad=:nacionalidad,cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono,id_especialidad=:id_especialidad WHERE id_personal=:id_personal');

            $consultaDeUsuario->bindParam(":cedula", $cedula);
            $consultaDeUsuario->bindParam(":nombre", $nombre);
            $consultaDeUsuario->bindParam(":apellido", $apellido);
            $consultaDeUsuario->bindParam(":telefono", $telefono);
            $consultaDeUsuario->bindParam(":nacionalidad", $nacionalidad);
            $consultaDeUsuario->bindParam(":id_personal", $idPersonal["id_personal"]);
            $consultaDeUsuario->bindParam(":id_especialidad", $_POST["selectEspecialidad"]);

            $consultaDeUsuario->execute();




            //Editar el usuario (el correo del doctor).
            $consultaDeUsuario = $this->conexion->prepare('UPDATE segurity.usuario SET correo =:correo WHERE id_usuario=:id_usuario');

            $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);
            $consultaDeUsuario->bindParam(":correo", $email);
            $consultaDeUsuario->execute();

            // $this->modeloUsuario->updateUsuario($usuario, $idUsuario,);

            $contadorDias = 0;
            foreach ($checkeds as $idD) {
                if ($diasN) {
                    //si el id existe en el array se inserta
                    if (in_array($idD, $diasN)) {
                        $sqlHorario = $this->conexion->prepare("INSERT INTO horarioydoctor(id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (:id_personal, :id_horario, :horarioDeEntrada, :horaDeSalida);");
                        $sqlHorario->bindParam(":id_personal", $idPersonal["id_personal"]);
                        $sqlHorario->bindParam(":id_horario", $idD);
                        $sqlHorario->bindParam(":horarioDeEntrada", $horaEntrada[$contadorDias]);
                        $sqlHorario->bindParam(":horaDeSalida", $horaSalida[$contadorDias]);
                        $sqlHorario->execute();
                    }
                }
                if ($diasEditar) {
                    //si el id existe en el array se inserta
                    if (in_array($idD, $diasEditar)) {

                        $sqlHorarioEdi = $this->conexion->prepare("UPDATE horarioydoctor SET horaDeEntrada=:horarioDeEntrada,horaDeSalida=:horaDeSalida WHERE id_personal = :id_personal AND id_horario = :id_horario");
                        $sqlHorarioEdi->bindParam(":horarioDeEntrada", $horaEntrada[$contadorDias]);
                        $sqlHorarioEdi->bindParam(":horaDeSalida", $horaSalida[$contadorDias]);
                        $sqlHorarioEdi->bindParam(":id_personal", $idPersonal["id_personal"]);
                        $sqlHorarioEdi->bindParam(":id_horario", $idD);
                        $sqlHorarioEdi->execute();
                    }
                }

                $contadorDias++;
            }


            // si el id existe es porque se deselecciono y se elimina
            if ($diasE) {
                foreach ($diasE as $idE) {

                    $sqlHorarioE = $this->conexion->prepare("DELETE FROM horarioydoctor WHERE id_personal = :id_personal AND id_horario = :id_horario");
                    $sqlHorarioE->bindParam(":id_personal", $idPersonal["id_personal"]);
                    $sqlHorarioE->bindParam(":id_horario", $idE);
                    $sqlHorarioE->execute();
                }
            }

            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return 0;
        }
    }

    //esto es para editar el estado (en activo a desactivo) del doctor.
    public function eliminacionLogica($idUsuario)
    {
        try {
            $this->conexion->beginTransaction();

            $validar = $this->conexion->prepare("SELECT * from segurity.usuario where id_usuario=:id_usuario");
            $validar->bindParam(":id_usuario", $idUsuario);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            //editar al doctor.
            $sqlUsuario = 'UPDATE segurity.usuario SET estado = "DES" WHERE id_usuario = :id_usuario ';
            $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);
            $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);

            $consultaDeUsuario->execute();

            $this->conexion->commit();
            return ["exito"];
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return $e->getMessage();
        }
    }

    public function restablecerDoctor($idUsuario)
    {
        try {
            $this->conexion->beginTransaction();

            $validar = $this->conexion->prepare("SELECT * from segurity.usuario where id_usuario=:id_usuario");
            $validar->bindParam(":id_usuario", $idUsuario);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo el id no existe");
            }

            //editar al doctor.
            $sqlUsuario = 'UPDATE segurity.usuario SET estado = "ACT" WHERE id_usuario = :id_usuario ';
            $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);
            $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);

            $consultaDeUsuario->execute();

            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return 0;
        }
    }

    public function Especialidadregistrar($nombre)
    {
        try {
            $consulta = $this->conexion->prepare("INSERT INTO especialidad (nombre, estado) VALUES (:nombre, 'ACT')");
            $consulta->bindParam(":nombre", $nombre);
            $consulta->execute();

            $id = $this->conexion->lastInsertId();
            $consulta = $this->conexion->prepare("SELECT * from entrada where id_entrada=:id_entrada");
            $consulta->bindParam(":id_entrada", $id);
            $consulta->execute();
            $data = ($consulta->execute()) ? $consulta->fetch() : false;


            return ["exito", $data];
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function Especialidadeliminar($id_especialidad)
    {
        try {
            $validar = $this->conexion->prepare("SELECT * from especialidad where id_especialidad=:id_especialidad");
            $validar->bindParam(":id_especialidad", $id_especialidad);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }
            $consulta = $this->conexion->prepare("UPDATE especialidad set estado = 'DES' WHERE id_especialidad = :id_especialidad");
            $consulta->bindParam(":id_especialidad", $id_especialidad);
            $consulta->execute();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function especialidaDbuscar($nombre)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM especialidad WHERE estado = 'ACT' AND nombre LIKE :nombre");
            $busqueda = "%$nombre%";
            $consulta->bindParam(":nombre", $busqueda);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function doctorBuscar($busqueda)
    {
        try {
            $sql = 'SELECT * FROM usuario u INNER JOIN personal pe ON u.id_usuario = pe.id_usuario INNER JOIN especialidad e ON e.id_especialidad = pe.id_especialidad WHERE pe.cedula = :busqueda AND u.estado = "ACT";';
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(":busqueda", $busqueda);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }





    public function horarioDelDoctor($id_personal)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT pe.id_personal,pe.nombre,pe.apellido,pe.cedula,hyd.horaDeEntrada,hyd.horaDeSalida,h.diaslaborables,h.id_horario FROM bd.horarioydoctor hyd INNER JOIN bd.personal pe ON pe.id_personal = hyd.id_personal INNER JOIN segurity.usuario u ON u.id_usuario = pe.usuario INNER JOIN bd.horario h ON h.id_horario = hyd.id_horario WHERE pe.id_personal =:id_personal AND u.estado = 'ACT' ");
            $consulta->bindParam(":id_personal", $id_personal);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function RegistrarAdmin($nacionalidad, $cedula, $nombre, $apellido, $telefono, $email, $id_usuario)
    {
        try {
            $validar = $this->conexion->prepare("SELECT * from segurity.usuario where id_usuario=:id_usuario");
            $validar->bindParam(":id_usuario", $id_usuario);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo el id no existe.");
            }
            $sql = 'INSERT INTO bd.personal VALUES (Null, :nacionalidad, :cedula, :nombre, :apellido, :telefono, "Administrador", Null, :id_usuario)';
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(":nacionalidad", $nacionalidad);
            $consulta->bindParam(":cedula", $cedula);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":apellido", $apellido);
            $consulta->bindParam(":telefono", $telefono);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->execute();
            return ['exito'];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
