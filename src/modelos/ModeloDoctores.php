<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloUsuarios;
use App\modelos\ModeloRoles;


class ModeloDoctores extends ModelBase
{
    private $id_doctor, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $email, $nacionalidad, $idEspecialidad, $dias, $horaSalida, $horaEntrada, $imagen, $especialidad, $imagenTemporal, $checkeds, $diasN, $diasEditar, $diasE, $usuario, $id_usuario, $id_rol, $password;

    private $columnasPermitidasDoctores = ['id_personal','cedula', 'nombre_d', 'apellido', 'telefono', 'correo', 'nombre'];
    private $columnasPermitidasEspec = ['id_especialidad','nombre'];
    private $ordenesPermitidos = ['ASC', 'DESC'];

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    // ── READ────────────────────────────────────────────────

    public function selectEspecialidad()
    {
        try {
            $sql = "SELECT id_especialidad, nombre FROM especialidad WHERE estado = 'ACT'";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectTodasEspecialidades($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_especialidad', $ordenDir = 'DESC')
    {
        try {
            $sql = "SELECT id_especialidad, nombre FROM especialidad WHERE estado = 'ACT' ";
            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND (nombre LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }
            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidasEspec) ? $ordenColumna : 'id_especialidad';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';
            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectDias()
    {
        try {
            $sql = "SELECT id_horario, diaslaborables FROM horario";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectDiasDoctor()
    {
        try {
            $sql = "SELECT h.id_horario, h.diaslaborables, hyd.horaDeEntrada, hyd.horaDeSalida, hyd.id_personal FROM horario h INNER JOIN horarioydoctor hyd ON h.id_horario = hyd.id_horario INNER JOIN personal p ON p.id_personal = hyd.id_personal";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function validarUsuario()
    {
        try {
            $data    = ['usuario' => $this->getUsuario()];
            $sql     = "SELECT u.*, p.* FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario";
            $this->setSQL($sql);
            $listData = $this->search($data, false);
            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function select($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_personal', $ordenDir = 'DESC')
    {
        
        try {
            $sql = 'SELECT u.id_usuario,u.id_rol,u.usuario,u.correo,u.password,p.id_personal,p.nacionalidad,p.cedula, p.nombre as nombre_d,p.apellido, p.telefono,p.id_especialidad, es.nombre FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad INNER JOIN segurity.rol r ON r.id_rol = u.id_rol WHERE u.estado = "ACT" AND es.id_especialidad IS NOT NULL';
            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND (u.correo LIKE :buscar OR u.nacionalidad LIKE :buscar OR u.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar)  OR p.telefono LIKE :buscar";
                $data['buscar'] = "%$buscar%";
            }
            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidasDoctores) ? $ordenColumna : 'id_personal';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';
            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function desactivos($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_personal', $ordenDir = 'DESC')
    {
        try {
            $sql = 'SELECT u.id_usuario,u.id_rol,u.usuario,u.correo,u.password,p.id_personal,p.nacionalidad,p.cedula, p.nombre as nombre_d,p.apellido, p.telefono,p.id_especialidad, es.nombre FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad INNER JOIN segurity.rol r ON r.id_rol = u.id_rol WHERE u.estado = "DES" AND es.id_especialidad IS NOT NULL';
            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND (u.correo LIKE :buscar OR u.nacionalidad LIKE :buscar OR u.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar)  OR p.telefono LIKE :buscar";
                $data['buscar'] = "%$buscar%";
            }
            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidasDoctores) ? $ordenColumna : 'id_personal';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function contarTotalDoctores($estado, $buscar = '')
    {
        try {
            $data = ['estado' => $estado];
            $sql = 'SELECT COUNT(*) as total FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario INNER JOIN bd.especialidad es ON es.id_especialidad = p.id_especialidad INNER JOIN segurity.rol r ON r.id_rol = u.id_rol WHERE u.estado =:estado AND es.id_especialidad IS NOT NULL';

            if (!empty($buscar)) {
                $sql .= " AND (u.correo LIKE :buscar OR u.nacionalidad LIKE :buscar OR u.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar)  OR p.telefono LIKE :buscar";
                $data['buscar'] = "%$buscar%";
            }
            $this->setSQL($sql);
            $resultado = $this->search($data, false);

            if (is_array($resultado) && isset($resultado['total'])) {
                return (int)$resultado['total'];
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function contarTotalEspecialidades($estado, $buscar = '')
    {
        try {
            $data = ['estado' => $estado];
            $sql = 'SELECT COUNT(*) as total FROM especialidad WHERE estado =:estado ';

            if (!empty($buscar)) {
                $sql .= " AND (nombre LIKE :buscar)  ";
                $data['buscar'] = "%$buscar%";
            }
            $this->setSQL($sql);
            $resultado = $this->search($data, false);

            if (is_array($resultado) && isset($resultado['total'])) {
                return (int)$resultado['total'];
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function horarioDelDoctor()
    {
        try {
            $data = ['id_personal' => $this->getIdDoctor(), 'estado' => 'ACT'];
            $sql  = "SELECT pe.id_personal, pe.nombre, pe.apellido, pe.cedula, hyd.horaDeEntrada, hyd.horaDeSalida, h.diaslaborables, h.id_horario FROM bd.horarioydoctor hyd INNER JOIN bd.personal pe ON pe.id_personal = hyd.id_personal INNER JOIN segurity.usuario u ON u.id_usuario = pe.usuario INNER JOIN bd.horario h ON h.id_horario = hyd.id_horario WHERE pe.id_personal = :id_personal AND u.estado = :estado";
            $this->setSQL($sql);
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ── PRIVADOS ─────────────────────────────────────────

    private function validarCedula($data)
    {
        try {
            $sql = "SELECT p.cedula FROM segurity.usuario u INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE p.cedula = :cedula";
            $this->setSQL($sql);
            $listData = $this->search($data, false);
            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function insertarDoctorDB()
    {
        try {
            $this->beginTransaction();

            if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }
            if ($this->validarUsuario()) {
                throw new \Exception("El usuario ya está registrado.");
            }

            $imagen         = $this->getImagen() ?: 'doctor.png';
            $imagenTemporal = $this->getImagenTemporal() ?: '';

            $data1 = [
                'id_rol'   => $this->getIdRol(),
                'imagen'   => $imagen,
                'usuario'  => $this->getUsuario(),
                'correo'   => $this->getEmail(),
                'password' => $this->getPassword(),
                'estado'   => 'ACT'
            ];
            $sql = "INSERT INTO segurity.usuario (id_usuario, id_rol, imagen, usuario, correo, password, estado) VALUES (null, :id_rol, :imagen, :usuario, :correo, :password, :estado)";
            $this->setSQL($sql);
            $idUsuario = $this->create($data1);

            $data2 = [
                'nacionalidad'    => $this->getNacionalidad(),
                'cedula'          => $this->getCedula(),
                'nombre'          => $this->getNombre(),
                'apellido'        => $this->getApellido(),
                'telefono'        => $this->getTelefono(),
                'tipodecategoria' => 'Doctor',
                'id_espacialidad' => $this->getIdEspecialidad(),
                'id_usuario'      => $idUsuario
            ];
            $sql = 'INSERT INTO bd.personal (id_personal, nacionalidad, cedula, nombre, apellido, telefono, tipodecategoria, id_especialidad, usuario) VALUES (null, :nacionalidad, :cedula, :nombre, :apellido, :telefono, :tipodecategoria, :id_espacialidad, :id_usuario)';
            $this->setSQL($sql);
            $idPersonal = $this->create($data2);

            if ($idUsuario && $imagenTemporal !== '') {
                $imagen = $idUsuario . '_' . $imagen;
                move_uploaded_file($imagenTemporal, './src/assets/images/img_ingresadas_por_usuarios/usuarios/' . $imagen);
            }

            if (!empty($this->getDias())) {
                $contador = 0;
                foreach ($this->getDias() as $d) {
                    $data = [
                        'id_personal'      => $idPersonal,
                        'id_horario'       => $d,
                        'horarioDeEntrada' => $this->getHoraEntrada()[$contador],
                        'horaDeSalida'     => $this->getHoraSalida()[$contador]
                    ];
                    $sql = "INSERT INTO bd.horarioydoctor (id_horarioydoctor, id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (null, :id_personal, :id_horario, :horarioDeEntrada, :horaDeSalida)";
                    $this->setSQL($sql);
                    $this->create($data);
                    $contador++;
                }
            }

            $this->commit();
            return ["exito", $data1, $data2];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    private function insertarAdmin()
    {
        try {
            $this->beginTransaction();

            if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $data = [
                'nacionalidad'    => $this->getNacionalidad(),
                'cedula'          => $this->getCedula(),
                'nombre'          => $this->getNombre(),
                'apellido'        => $this->getApellido(),
                'telefono'        => $this->getTelefono(),
                'tipodecategoria' => 'Administrador',
                'id_espacialidad' => null,
                'id_usuario'      => $this->getIdUsuario()
            ];
            $sql = 'INSERT INTO bd.personal (id_personal, nacionalidad, cedula, nombre, apellido, telefono, tipodecategoria, id_especialidad, usuario) VALUES (null, :nacionalidad, :cedula, :nombre, :apellido, :telefono, :tipodecategoria, :id_espacialidad, :id_usuario)';
            $this->setSQL($sql);
            $this->create($data);

            $this->commit();
            return ["exito", $data];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    private function updateDoctorDB()
    {
        try {
            $this->beginTransaction();

            $data1 = ['idUsuario' => $this->getIdUsuario()];
            $sql   = "SELECT usuario FROM personal WHERE usuario = :idUsuario";
            $this->setSQL($sql);
            if ($this->search($data1, false) == []) {
                throw new \Exception("El id del usuario no existe.");
            }

            if ($this->getCedula() != $this->getCedulaRegistrada() && $this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $sql       = 'SELECT id_personal FROM personal WHERE usuario = :idUsuario';
            $this->setSQL($sql);
            $idPersonal = $this->search($data1, false);

            $data2 = [
                'nacionalidad'    => $this->getNacionalidad(),
                'cedula'          => $this->getCedula(),
                'nombre'          => $this->getNombre(),
                'apellido'        => $this->getApellido(),
                'telefono'        => $this->getTelefono(),
                'id_espacialidad' => $this->getIdEspecialidad()
            ];
            $sql = "UPDATE personal SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, id_especialidad=:id_espacialidad WHERE id_personal = :id";
            $this->setSQL($sql);
            $this->update($data2, $idPersonal['id_personal']);

            $sql = 'UPDATE segurity.usuario SET correo = :correo WHERE id_usuario = :id';
            $this->setSQL($sql);
            $this->update(['correo' => $this->getEmail()], $this->getIdUsuario());

            $checkeds   = $this->getCheckeds();
            $diasN      = $this->getDiasN();
            $diasEditar = $this->getDiasEditar();
            $horaEntrada = $this->getHoraEntrada();
            $horaSalida  = $this->getHoraSalida();
            $diasE      = $this->getDiasE();
            $contador   = 0;

            foreach ($checkeds as $idD) {
                if ($diasN && in_array($idD, $diasN)) {
                    $data = [
                        'id_personal'      => $idPersonal['id_personal'],
                        'id_horario'       => $idD,
                        'horarioDeEntrada' => $horaEntrada[$contador],
                        'horaDeSalida'     => $horaSalida[$contador]
                    ];
                    $sql = "INSERT INTO horarioydoctor (id_personal, id_horario, horaDeEntrada, horaDeSalida) VALUES (:id_personal, :id_horario, :horarioDeEntrada, :horaDeSalida)";
                    $this->setSQL($sql);
                    $this->create($data);
                }
                if ($diasEditar && in_array($idD, $diasEditar)) {
                    $data = ['id_horario' => $idD, 'horarioDeEntrada' => $horaEntrada[$contador], 'horaDeSalida' => $horaSalida[$contador]];
                    $sql  = "UPDATE horarioydoctor SET horaDeEntrada=:horarioDeEntrada, horaDeSalida=:horaDeSalida WHERE id_personal = :id AND id_horario = :id_horario";
                    $this->setSQL($sql);
                    $this->update($data, $idPersonal['id_personal']);
                }
                $contador++;
            }

            if ($diasE) {
                foreach ($diasE as $idE) {
                    $sql = "DELETE FROM horarioydoctor WHERE id_personal = :id_personal AND id_horario = :id_horario";
                    $this->setSQL($sql);
                    $this->delete(['id_personal' => $idPersonal['id_personal'], 'id_horario' => $idE]);
                }
            }

            $this->commit();
            return ["exito", $data1, $data2, $idPersonal['id_personal']];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }

    private function eliminacionLogicaDB($estado ='DES')
    {
        try {
            $data = ['id_usuario' => $this->getIdUsuario()];
            $sql  = "SELECT id_usuario FROM segurity.usuario WHERE id_usuario = :id_usuario";
            $this->setSQL($sql);
            if ($this->search($data, false) == []) {
                throw new \Exception("El id del usuario no existe.");
            }
            $sql = 'UPDATE segurity.usuario SET estado =:estado WHERE id_usuario = :id';
            $this->setSQL($sql);
            $this->update(['estado'=>$estado],$data['id_usuario']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function restablecerDoctorDB()
    {
        try {
            $data = ['id_usuario' => $this->getIdUsuario()];
            $sql  = "SELECT id_usuario FROM segurity.usuario WHERE id_usuario = :id_usuario";
            $this->setSQL($sql);
            if ($this->search($data, false) == []) {
                throw new \Exception("El id del usuario no existe.");
            }
            $sql = 'UPDATE segurity.usuario SET estado = "ACT" WHERE id_usuario = :id';
            $this->setSQL($sql);
            $this->update_logic($data['id_usuario']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function especialidadRegistrarDB()
    {
        try {
            $data = ['nombre' => $this->getNombreEspecialidad(), 'estado' => 'ACT'];
            $sql  = "INSERT INTO especialidad (nombre, estado) VALUES (:nombre, :estado)";
            $this->setSQL($sql);
            $this->create($data);
            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function especialidadEliminarDB($estado = 'DES')
    {
        try {
            $data = ['id_especialidad' => $this->getIdEspecialidad()];
            $sql  = "SELECT id_especialidad FROM especialidad WHERE id_especialidad = :id_especialidad";
            $this->setSQL($sql);
            if ($this->search($data, false) == []) {
                throw new \Exception("El id de la especialidad no existe.");
            }
            $sql = 'UPDATE especialidad SET estado =:estado WHERE id_especialidad = :id';
            $this->setSQL($sql);
            $this->update(['estado'=>$estado],$data['id_especialidad']);
            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ── PÚBLICOS────────────────────

    private function validarSesion($idUsuario): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['id_usuario']) && $idUsuario === null) {
            throw new \Exception('No hay sesión activa o usuario no autenticado.');
        }
    }

    private function validarCamposObligatorios(array $campos, string $contexto = ''): void
    {
        foreach ($campos as $campo) {
            if (empty($campo)) {
                throw new \Exception("No se permiten campos vacíos{$contexto}.");
            }
        }
    }

    public function insertarDoctor($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->cedula,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->email,
            $this->nacionalidad,
            $this->idEspecialidad,
            $this->usuario,
            $this->password,
            $this->id_rol
        ], ' al registrar un doctor');
        return $this->insertarDoctorDB();
    }

    public function registrarAdmin($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->cedula,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->nacionalidad,
            $this->idEspecialidad,
        ], ' al registrar un administrador');
        return $this->insertarAdmin();
    }

    public function updateDoctor($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->cedula,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->email,
            $this->nacionalidad,
            $this->idEspecialidad,
            $this->id_usuario
        ], ' al editar un doctor');
        return $this->updateDoctorDB();
    }

    public function eliminacionLogica($idUsuario = null,$estado = 'DES')
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->id_usuario], ' al eliminar un doctor');
        return $this->eliminacionLogicaDB($estado);
    }

    public function restablecerDoctor($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->id_usuario], ' al restablecer un doctor');
        return $this->restablecerDoctorDB();
    }

    public function EspecialidadRegistrar($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->especialidad], ' al registrar una especialidad');
        return $this->especialidadRegistrarDB();
    }

    public function EspecialidadEliminar($idUsuario = null,$estado ='DES')
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->idEspecialidad], ' al eliminar una especialidad');
        return $this->especialidadEliminarDB($estado);
    }

    // ── Getters & Setters ──────────────────────────────────────

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
        if (!preg_match("/^[0-9]+$/", $id_doctor) || (int)$id_doctor <= 0) {
            throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
        }
        $this->id_doctor = $id_doctor;
    }

    public function setNacionalidad($nacionalidad)
    {
        if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
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
            throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula y tener al menos 3 letras.");
        }
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
            throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula y tener al menos 3 letras.");
        }
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono)
    {
        if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
            throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido.");
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
        if (!preg_match("/^[0-9]+$/", $id_especialidad) || (int)$id_especialidad <= 0) {
            throw new \InvalidArgumentException("El ID de la especialidad debe ser un número entero positivo.");
        }
        $this->idEspecialidad = $id_especialidad;
    }

    public function setDias($dias = [])
    {
        if (empty($dias)) {
            throw new \InvalidArgumentException("Los días no pueden estar vacíos.");
        }
        $this->dias = $dias;
    }

    public function setHoraEntrada($horaEntrada = [])
    {
        if (!is_array($horaEntrada)) {
            throw new \InvalidArgumentException("Las horas de entrada no pueden estar vacías.");
        }
        $this->horaEntrada = $horaEntrada;
    }

    public function setHoraSalida($horaSalida = [])
    {
        if (!is_array($horaSalida)) {
            throw new \InvalidArgumentException("Las horas de salida no pueden estar vacías.");
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
            throw new \InvalidArgumentException("La especialidad debe contener solo letras y tener al menos 2 caracteres.");
        }
        $this->especialidad = $especialidad;
    }

    public function setUsuario($usuario)
    {
        if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
            throw new \InvalidArgumentException("El usuario no es válido.");
        }
        $this->usuario = $usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        if (!preg_match("/^[0-9]+$/", $id_usuario) || (int)$id_usuario <= 0) {
            throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
        }
        $this->id_usuario = (int)$id_usuario;
    }

    public function setIdRol($id_rol)
    {
        if (!preg_match("/^[0-9]+$/", $id_rol) || (int)$id_rol <= 0) {
            throw new \InvalidArgumentException("El ID del rol debe ser un número entero positivo.");
        }
        $this->id_rol = (int)$id_rol;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
