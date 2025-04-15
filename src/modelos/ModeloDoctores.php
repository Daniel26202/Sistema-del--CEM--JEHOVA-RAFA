<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloDoctores extends Db
{

    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }

    //seleccionar especialidad
    public function selectEspecialidad()
    {
        $consulta = $this->conexion->prepare("SELECT * FROM especialidad WHERE estado = 'ACT'");
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    //seleccionar los dias que el doctor puedad trabajar
    public function selectDias()
    {
        $consulta = $this->conexion->prepare("SELECT * FROM horario");
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function selectDiasDoctor($id_personal)
    {
        $consulta = $this->conexion->prepare("SELECT h.*,hyd.* FROM horario h INNER JOIN horarioydoctor hyd ON  h.id_horario = hyd.id_horario INNER JOIN personal p ON p.id_personal = hyd.id_personal WHERE p.id_personal = :id_personal AND p.tipodecategoria = 'Doctor'");
        $consulta->bindParam(":id_personal", $id_personal);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    //validar usuario
    public function validarUsuario($usuario)
    {
        $consulta = $this->conexion->prepare("SELECT u.*, p.* FROM usuario u INNER JOIN personal p ON p.id_usuario = u.id_usuario WHERE u.usuario =:usuario");

        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeU";
        }

        return 0;
    }

    //validar cédula
    public function validarCedula($cedula)
    {
        $consulta = $this->conexion->prepare("SELECT u.*, p.* FROM usuario u INNER JOIN personal p ON p.id_usuario = u.id_usuario WHERE p.cedula = :cedula");

        $consulta->bindParam(":cedula", $cedula);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeC";
        }

        return 0;
    }

    //selecciono las cuatro tablas
    public function select()
    {

        $sql = 'SELECT u.*, p.*, p.nombre as nombre_d, es.* FROM usuario u INNER JOIN personal p ON p.id_usuario = u.id_usuario INNER JOIN especialidad es ON es.id_especialidad = p.id_especialidad WHERE u.estado = "ACT" ';

        $consulta = $this->conexion->prepare($sql);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    //esto es para agregar un doctor.
    public function insertarDoctor($cedula, $nombre, $apellido, $telefono, $usuario, $password, $especialidad, $email, $nacionalidad, $nombreImagen, $imagenTemporal, $idEspecialidad)
    {

        //agregamos al doctor como usuario.
        $consultaDeUsuario = $this->conexion->prepare('INSERT INTO usuario(id_rol, imagen, usuario, correo,  password, estado) VALUES ("8",:imagen, :usuario, :correo, :password,"ACT");');

        $consultaDeUsuario->bindParam(":imagen", $nombreImagen);
        $consultaDeUsuario->bindParam(":usuario", $usuario);
        $consultaDeUsuario->bindParam(":correo", $email);
        $consultaDeUsuario->bindParam(":password", $password);

        $consultaDeUsuario->execute();

        //devuelve el id del usuario.
        //obtenemos los datos del usuario que se a agregado. si no se inserta devuelve 0
        $idUsuario = ($this->conexion->lastInsertId() == 0) ? false : $this->conexion->lastInsertId();


        //agregamos al doctor como usuario.
        $consultaDePersonal = $this->conexion->prepare('INSERT INTO personal(nacionalidad, cedula, nombre, apellido, telefono, id_especialidad, id_usuario) VALUES (:nacionalidad,:cedula,:nombre,:apellido,:telefono,:id_especialidad,:id_usuario)');

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
                echo "No Vacio";
                $imagen = $idUsuario . "_" . $nombreImagen;
                move_uploaded_file($imagenTemporal, "./src/assets/img_ingresadas_por_usuarios/usuarios/" . $imagen);
            }
        }


        //esto es para insertar el horario

        $dias = $_POST['dias'];
        $horaSalida = $_POST["horaSalida"];
        $horaEntrada = $_POST["horaEntrada"];
        if ($dias != "NO") {
            $contadorDias = 0;
            foreach ($dias as $d) {
                $sqlHorario = $this->conexion->prepare("INSERT INTO horarioydoctor (id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (:id_personal,:id_horario,:horarioDeEntrada,:horaDeSalida)");
                $sqlHorario->bindParam(":id_personal", $idPersonal);
                $sqlHorario->bindParam(":id_horario", $d);
                $sqlHorario->bindParam(":horarioDeEntrada", $horaEntrada[$contadorDias]);
                $sqlHorario->bindParam(":horaDeSalida", $horaSalida[$contadorDias]);
                $sqlHorario->execute();


                $contadorDias++;
            }
        }
    }

    //esto es para editar un doctor.
    public function updateDoctor($cedula, $nombre, $apellido, $telefono, $idUsuario, $idEspecialidad, $email, $nacionalidad, $selectEsp, $idDoctorEspec, $diasE, $diasN, $diasEditar, $checkeds, $horaEntrada, $horaSalida)
    {

        $consultaU = $this->conexion->prepare('SELECT id_personal FROM personal p INNER JOIN usuario u ON p.id_usuario = u.id_usuario WHERE u.id_usuario = :id_usuario');

        $consultaU->bindParam(":id_usuario", $idUsuario);
        $consultaU->execute();
        $idPersonal = ($consultaU->execute()) ? $consultaU->fetch() : false;
        print_r($_POST["id_especialidad"]);


        //Editar el usuario (el usuario del doctor).
        $consultaDeUsuario = $this->conexion->prepare('UPDATE personal SET nacionalidad=:nacionalidad,cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono,id_especialidad=:id_especialidad WHERE id_personal=:id_personal');

        $consultaDeUsuario->bindParam(":cedula", $cedula);
        $consultaDeUsuario->bindParam(":nombre", $nombre);
        $consultaDeUsuario->bindParam(":apellido", $apellido);
        $consultaDeUsuario->bindParam(":telefono", $telefono);
        $consultaDeUsuario->bindParam(":nacionalidad", $nacionalidad);
        $consultaDeUsuario->bindParam(":id_personal", $idPersonal["id_personal"]);
        $consultaDeUsuario->bindParam(":id_especialidad", $_POST["id_especialidad"]);
        


        $consultaDeUsuario->execute();



        //Editar el usuario (el correo del doctor).
        $consultaDeUsuario = $this->conexion->prepare('UPDATE usuario SET correo =:correo WHERE id_usuario=:id_usuario');

        $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);
        $consultaDeUsuario->bindParam(":correo", $email);
        $consultaDeUsuario->execute();

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



    }

    //esto es para editar el estado (en activo a desactivo) del doctor.
    public function eliminacionLogica($cedula, $usuario, $idUsuario, $id_personal)
    {

        //editar al doctor.
        $sqlUsuario = 'UPDATE usuario SET estado = "DES" WHERE id_usuario = :id_usuario AND usuario = :usuario;';

        $consultaDeUsuario = $this->conexion->prepare($sqlUsuario);

        $consultaDeUsuario->bindParam(":usuario", $usuario);
        $consultaDeUsuario->bindParam(":id_usuario", $idUsuario);

        $consultaDeUsuario->execute();


        $sqlServiciosMedicos = 'UPDATE serviciomedico SET estado = "DES" WHERE id_personal = :id_personal';
        $consultaDeServicio = $this->conexion->prepare($sqlServiciosMedicos);
        $consultaDeServicio->bindParam(":id_personal", $id_personal);
        $consultaDeServicio->execute();
    }

    public function Especialidadregistrar($nombre)
    {

        $consulta = $this->conexion->prepare("INSERT INTO especialidad (nombre, estado) VALUES (:nombre, 'ACT')");
        $consulta->bindParam(":nombre", $nombre);
        $consulta->execute();
    }
    public function Especialidadeliminar($id_especialidad)
    {

        $consulta = $this->conexion->prepare("UPDATE especialidad set estado = 'DES' WHERE id_especialidad = :id_especialidad");
        $consulta->bindParam(":id_especialidad", $id_especialidad);
        $consulta->execute();
    }
    public function especialidaDbuscar($nombre)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM especialidad WHERE estado = 'ACT' AND nombre LIKE :nombre");
        $busqueda = "%$nombre%";
        $consulta->bindParam(":nombre", $busqueda);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    public function doctorBuscar($busqueda)
    {

        $sql = 'SELECT * FROM usuario u INNER JOIN personal pe ON u.id_usuario = pe.id_usuario INNER JOIN especialidad e ON e.id_especialidad = pe.id_especialidad WHERE pe.cedula = :busqueda AND u.estado = "ACT";';
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(":busqueda", $busqueda);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }





    public function horarioDelDoctor($id_personal)
    {
        $consulta = $this->conexion->prepare("SELECT pe.id_personal,pe.nombre,pe.apellido,pe.cedula,hyd.horaDeEntrada,hyd.horaDeSalida,h.diaslaborables,h.id_horario FROM horarioydoctor hyd INNER JOIN personal pe ON pe.id_personal = hyd.id_personal INNER JOIN usuario u ON u.id_usuario = pe.id_usuario INNER JOIN horario h ON h.id_horario = hyd.id_horario WHERE pe.id_personal =:id_personal AND u.estado = 'ACT' ");
        $consulta->bindParam(":id_personal", $id_personal);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function RegistrarAdmin($nacionalidad , $cedula ,$nombre ,$apellido, $telefono, $email, $id_usuario)
    {

        $sql = 'INSERT INTO personal VALUES (Null, :nacionalidad, :cedula, :nombre, :apellido, :telefono, :email, "Administrador", Null, :id_usuario)';
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(":nacionalidad", $nacionalidad);
        $consulta->bindParam(":cedula", $cedula);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":apellido", $apellido);
        $consulta->bindParam(":telefono", $telefono);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
    }

}
