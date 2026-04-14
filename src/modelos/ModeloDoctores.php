<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloUsuarios;
use App\modelos\ModeloRoles;


class ModeloDoctores extends ModelBase
{

    private $id_doctor, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $email, $nacionalidad, $idEspecialidad, $dias, $horaSalida, $horaEntrada, $imagen, $especialidad, $imagenTemporal, $checkeds, $diasN, $diasEditar, $diasE, $usuario, $id_usuario, $id_rol, $password;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    private function returnObjectModel()
    {
        return [
            'modeloUsuario' => new ModeloUsuarios,
            'modeloRoles' => new ModeloRoles
        ];
    }

    //seleccionar especialidad
    public function selectEspecialidad()
    {
        try {
            $sql = "SELECT * FROM especialidad WHERE estado = 'ACT'";

            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //seleccionar los dias que el doctor puedad trabajar
    public function selectDias()
    {
        try {
            $sql = "SELECT * FROM horario";

            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function selectDiasDoctor()
    {
        try {
            $sql = "SELECT h.*,hyd.* FROM horario h INNER JOIN horarioydoctor hyd ON  h.id_horario = hyd.id_horario INNER JOIN personal p ON p.id_personal = hyd.id_personal";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //validar usuario
    public function validarUsuario()
    {
        try {

            $data = ['usuario' => $this->returnObjectModel()['modeloUsuario']->getUsuario()];
            $sql = "SELECT u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario =:usuario";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //validar cédula
    private function validarCedula($data)
    {
        try {
            $sql = "SELECT u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE p.cedula = :cedula";

            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //selecciono las cuatro tablas
    public function select()
    {
        try {
            $sql = 'SELECT u.*, p.*, p.nombre as nombre_d, es.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad  inner join segurity.rol r on r.id_rol = u.id_rol WHERE u.estado = "ACT" AND  es.id_especialidad is not null';
            $this->setSQL($sql);

            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //papelera
    public function desactivos()
    {
        try {
            $sql = 'SELECT u.*, p.*, p.nombre as nombre_d, es.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad  inner join segurity.rol r on r.id_rol = u.id_rol WHERE u.estado = "DES" AND  es.id_especialidad is not null ';

            $this->setSQL($sql);

            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    //esto es para agregar un doctor.
    public function insertarDoctor()
    {

        try {
            $this->beginTransaction();


            if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            if ($this->validarUsuario(['usuario' => $this->getUsuario()])) {
                throw new \Exception("El usuario ya está registrada.");
            }

            $imagen = $this->getImagen();
            $imagenTemporal = $this->getImagenTemporal();

            if (!$imagen) {
                $imagen = 'doctor.png';
                $imagenTemporal = "";
            }

            $data1 = [
                'id_rol' => $this->getIdRol(),
                'imagen' => $imagen,
                'usuario' => $this->getUsuario(),
                'correo' => $this->getEmail(),
                'password' => $this->getPassword(),
                'estado' => 'ACT'
            ];
            $sql = "INSERT INTO segurity.usuario(id_usuario, id_rol, imagen, usuario, correo,  password, estado) VALUES (null,:id_rol,:imagen, :usuario, :correo, :password,:estado);";

            $this->setSQL($sql);

            $idUsuario = $this->create($data1);

            $data2 = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula' => $this->getCedula(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'telefono' => $this->getTelefono(),
                'tipodecategoria' => 'Doctor',
                'id_espacialidad' => $this->getIdEspecialidad(),
                'id_usuario' => $idUsuario
            ];

            // $sql = 'INSERT INTO bd.personal(id_personal,nacionalidad, cedula, nombre, apellido, telefono, tipodecategoria, id_especialidad, usuario) VALUES (null,:nacionalidad,:cedula,:nombre,:apellido,:telefono,:tipodecategoria,:id_especialidad,:id_usuario)';
            $sql = 'INSERT INTO bd.personal(id_personal,nacionalidad, cedula, nombre, apellido, telefono, tipodecategoria, id_especialidad, usuario) VALUES (null,:nacionalidad,:cedula,:nombre,:apellido,:telefono,:tipodecategoria,:id_espacialidad,:id_usuario)';

            $this->setSQL($sql);

            $idPersonal = $this->create($data2);

            if ($idUsuario != 0) {
                if ($imagenTemporal != "") {
                    $imagen = $idUsuario . "_" . $imagen;
                    move_uploaded_file($imagenTemporal, "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $imagen);
                }
            }

            //esto es para insertar el horario
            if ($this->getDias() != []) {
                $contadorDias = 0;
                foreach ($this->getDias() as $d) {
                    $data = [
                        'id_personal' => $idPersonal,
                        'id_horario' => $d,
                        'horarioDeEntrada' => $this->getHoraEntrada()[$contadorDias],
                        'horaDeSalida' => $this->getHoraSalida()[$contadorDias]
                    ];

                    $sql = "INSERT INTO bd.horarioydoctor (id_horarioydoctor,id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (null,:id_personal,:id_horario,:horarioDeEntrada,:horaDeSalida)";

                    $this->setSQL($sql);

                    $this->create($data);
                    $contadorDias++;
                }
            }
            $this->commit();
            return ["exito", $data1, $data2];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    public function RegistrarAdmin()
    {
        try {
            $this->beginTransaction();
            $sql = "SELECT * from segurity.usuario where id_usuario=:id_usuario";
            $this->setSQL($sql);
            $validar = $this->search(['id_usuario' => $this->getIdUsuario()]);

            if ($validar == []) {
                throw new \Exception("Fallo el id no existe.");
            }
            $sql = 'INSERT INTO bd.personal VALUES (Null, :nacionalidad, :cedula, :nombre, :apellido, :telefono, "Administrador", Null, :id_usuario)';
            $this->setSQL($sql);
            $data = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula' => $this->getCedula(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'telefono' => $this->getTelefono(),
                'id_usuario' => $this->getIdUsuario()
            ];
            $this->create($data);
            $this->commit();
            return ['exito'];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    //esto es para editar un doctor.
    public function updateDoctor()
    {
        try {
            $this->beginTransaction();

            $data1 = [
                'idUsuario' => $this->getIdUsuario()
            ];

            $data2 = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula' => $this->getCedula(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'telefono' => $this->getTelefono(),
                'id_espacialidad' => $this->getIdEspecialidad()
            ];

            $sql = "SELECT * from personal where usuario=:idUsuario";
            $this->setSQL($sql);

            $validar  = $this->search($data1, false);

            if ($validar == []) {
                throw new \Exception("El id del usuario no existe");
            }

            if ($this->getCedula() != $this->getCedulaRegistrada() && $this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $sql = 'SELECT id_personal FROM personal  WHERE usuario = :idUsuario';
            $this->setSQL($sql);
            $idPersonal = $this->search($data1, false);

            //Editar el usuario (el usuario del doctor).

            $sql = "UPDATE personal SET nacionalidad=:nacionalidad,cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono,id_especialidad=:id_espacialidad WHERE id_personal=:id";

            $this->setSQL($sql);
            $this->update($data2, $idPersonal['id_personal']);

            // // Editar el usuario (el correo del doctor).
            $sql = 'UPDATE segurity.usuario SET correo =:correo WHERE id_usuario=:id';
            $this->setSQL($sql);
            $this->update(['correo' => $this->getEmail()], $this->getIdUsuario());


            $checkeds = $this->getCheckeds();
            $diasN = $this->getDiasN();
            $diasEditar = $this->getDiasEditar();
            $horaEntrada = $this->getHoraEntrada();
            $horaSalida = $this->getHoraSalida();
            $diasE = $this->getDiasE();

            $contadorDias = 0;
            foreach ($checkeds as $idD) {
                if ($diasN) {
                    // return['nuevo'];
                    //si el id existe en el array se inserta
                    if (in_array($idD, $diasN)) {
                        $data = [
                            "id_personal" => $idPersonal["id_personal"],
                            "id_horario" => $idD,
                            "horarioDeEntrada" => $horaEntrada[$contadorDias],
                            "horaDeSalida" => $horaSalida[$contadorDias]
                        ];

                        $sqlHorario = "INSERT INTO horarioydoctor(id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (:id_personal, :id_horario, :horarioDeEntrada, :horaDeSalida);";
                        $this->setSQL($sqlHorario);

                        $this->create($data);
                    }
                }
                if ($diasEditar) {
                    // return ['editar'];

                    //si el id existe en el array se inserta
                    if (in_array($idD, $diasEditar)) {

                        $sqlHorarioEdi = "UPDATE horarioydoctor SET horaDeEntrada=:horarioDeEntrada,horaDeSalida=:horaDeSalida WHERE id_personal = :id AND id_horario = :id_horario";
                        $this->setSQL($sqlHorarioEdi);
                        $data = [
                            "id_horario" => $idD,
                            "horarioDeEntrada" => $horaEntrada[$contadorDias],
                            "horaDeSalida" => $horaSalida[$contadorDias]
                        ];
                        $this->update($data, $idPersonal["id_personal"]);
                    }
                }

                $contadorDias++;
            }


            // // si el id existe es porque se deselecciono y se elimina
            if ($diasE) {
                // return ['eliminar'];

                foreach ($diasE as $idE) {

                    $sqlHorarioE = "DELETE FROM horarioydoctor WHERE id_personal = :id_personal AND id_horario = :id_horario";
                    $this->setSQL($sqlHorarioE);
                    $this->delete(["id_personal" => $idPersonal["id_personal"], "id_horario" => $idE]);
                }
            }

            $this->commit();
            return ["exito", $data1, $data2, $idPersonal['id_personal']];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    //esto es para editar el estado (en activo a desactivo) del doctor.
    public function eliminacionLogica()
    {
        try {
            $data = [
                'id_usuario' => $this->getIdUsuario()
            ];

            $sql = "SELECT * from segurity.usuario where id_usuario=:id_usuario";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del usuario no existe");
            }

            $sql = 'UPDATE segurity.usuario SET estado = "DES" WHERE id_usuario = :id';
            $this->setSQL($sql);

            $this->update_logic($data['id_usuario']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function restablecerDoctor()
    {
        try {
            $data = [
                'id_usuario' => $this->returnObjectModel()['modeloUsuario']->getIdUsuario()
            ];

            $sql = "SELECT * from segurity.usuario where id_usuario=:id_usuario";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del usuario no existe");
            }

            $sql = 'UPDATE segurity.usuario SET estado = "ACT" WHERE id_usuario = :id';
            $this->setSQL($sql);

            $this->update_logic($data['id_usuario']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EspecialidadRegistrar()
    {
        try {
            $data = [
                'nombre' => $this->getNombreEspecialidad(),
                'estado' => 'ACT'
            ];
            $sql = "INSERT INTO especialidad (nombre, estado) VALUES (:nombre, :estado)";
            $this->setSQL($sql);

            $this->create($data);
            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function EspecialidadEliminar()
    {
        try {
            $data = [
                'id_especialidad' => $this->getIdEspecialidad()
            ];

            $sql = "SELECT * from especialidad where id_especialidad=:id_especialidad";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id de la especialidad no existe");
            }

            $sql = 'UPDATE especialidad SET estado = "DES" WHERE id_especialidad = :id';
            $this->setSQL($sql);

            $this->update_logic($data['id_especialidad']);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public function horarioDelDoctor()
    {
        try {
            $data = [
                'id_personal' => $this->getIdDoctor(),
                'estado' => 'ACT'
            ];

            $sql = "SELECT pe.id_personal,pe.nombre,pe.apellido,pe.cedula,hyd.horaDeEntrada,hyd.horaDeSalida,h.diaslaborables,h.id_horario FROM bd.horarioydoctor hyd INNER JOIN bd.personal pe ON pe.id_personal = hyd.id_personal INNER JOIN segurity.usuario u ON u.id_usuario = pe.usuario INNER JOIN bd.horario h ON h.id_horario = hyd.id_horario WHERE pe.id_personal =:id_personal AND u.estado =:estado";
            $this->setSQL($sql);
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    // --- Getters ---
    public function getIdDoctor()
    {
        return $this->id_doctor;
    }

    public function getCedula()
    {
        return $this->cedula;
    }
    public function getCedulaRegistrada()
    {
        return $this->cedulaRegistrada;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getIdEspecialidad()
    {
        return $this->idEspecialidad;
    }

    public function getDias()
    {
        return $this->dias;
    }

    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }

    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getImagenTemporal()
    {
        return $this->imagenTemporal;
    }

    public function getNombreEspecialidad()
    {
        return $this->especialidad;
    }

    public function getCheckeds()
    {
        return $this->checkeds;
    }

    public function getDiasN()
    {
        return $this->diasN;
    }

    public function getDiasEditar()
    {
        return $this->diasEditar;
    }

    public function getDiasE()
    {
        return $this->diasE;
    }


    public function getUsuario()
    {
        return $this->usuario;
    }



    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getIdRol()
    {
        return $this->id_rol;
    }

    public function getPassword()
    {
        return $this->password;
    }



    // --- Setters ---
    public function setDiasEditar($diasEditar)
    {
        $this->diasEditar = $diasEditar;
    }

    public function setDiasE($diasE)
    {
        $this->diasE = $diasE;
    }

    public function setDiasN($diasN)
    {
        $this->diasN = $diasN;
    }

    public function setCheckeds($checkeds)
    {
        $this->checkeds = $checkeds;
    }

    public function setIdDoctor($id_doctor)
    {
        if (!preg_match("/^[0-9]+$/", $id_doctor)) {
            throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
        }

        if ((int)$id_doctor <= 0) {
            throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
        }
        $this->id_doctor = $id_doctor;
    }

    public function setNacionalidad($nacionalidad)
    {
        if (!preg_match("/^[A-Z]{1,3}$/", $nacionalidad)) {
            throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
        }
        $this->nacionalidad = $nacionalidad;
    }

    public function setCedula($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
        }
        $this->cedula = $cedula;
    }

    public function setCedulaRegistrada($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
        }
        $this->cedulaRegistrada = $cedula;
    }

  public function setNombre($nombre)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->nombre = $nombre;
	}

	public function setApellido($apellido)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
			throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->apellido = $apellido;
	}

    public function setTelefono($telefono)
    {
        if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
            throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
        }
        $this->telefono = $telefono;
    }

    public function setEmail($email)
    {
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email)) {
            throw new \InvalidArgumentException("El correo debe estar bien escrito.");
        }
        $this->email = $email;
    }

    public function setIdEspecialidad($id_especialidad)
    {
        if (!preg_match("/^[0-9]+$/", $id_especialidad)) {
            throw new \InvalidArgumentException("El ID del especialidad debe ser un número entero positivo.");
        }

        if ((int)$id_especialidad <= 0) {
            throw new \InvalidArgumentException("El ID del especialidad debe ser mayor que cero.");
        }
        $this->idEspecialidad = $id_especialidad;
    }

    public function setDias($dias = [])
    {
        if ($dias == []) {
            throw new \InvalidArgumentException("los dias no puede estar vacio.");
        }
        $this->dias = $dias;
    }

    public function setHoraEntrada($horaEntrada = [])
    {
        if (!is_array($horaEntrada)) {
            throw new \InvalidArgumentException("las horas de entrada no puede estar vacio.");
        }
        $this->horaEntrada = $horaEntrada;
    }

    public function setHoraSalida($horaSalida = [])
    {
        if (!is_array($horaSalida)) {
            throw new \InvalidArgumentException("las horas de salida no puede estar vacio.");
        }
        $this->horaSalida = $horaSalida;
    }

    public function setImagenTemporal($imagenTemporal)
    {
        $this->imagenTemporal = $imagenTemporal;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function setNombreEspecialidad($especialidad)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $especialidad)) {
            throw new \InvalidArgumentException("La especialidad debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }
        $this->especialidad = $especialidad;
    }

    public function setUsuario($usuario)
    {
        if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
            throw new \InvalidArgumentException("El  usuario esta mal.");
        }


        $this->usuario = $usuario;
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

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
