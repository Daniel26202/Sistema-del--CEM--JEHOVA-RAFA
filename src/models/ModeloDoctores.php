<?php

namespace App\models;

use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\TraitDelete;
use App\models\ModelBase;


class ModeloDoctores extends ModelBase
{
    private $id_doctor, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $email, $nacionalidad, $idEspecialidad, $dias, $horaSalida, $horaEntrada, $imagen, $especialidad, $imagenTemporal, $checkeds, $diasN, $diasEditar, $diasE;

    private $validator;
    use TraitCreate, TraitUpdate,TraitDelete;

    public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali = null)
    {
        parent::__construct($conn);
        $this->validator = $vali;
    }

    // ── READ────────────────────────────────────────────────

    public function selectDias()
    {
        $this->set_tables(["horario"]);
        $this->set_colums(['id_horario', 'diaslaborables']);
        return $this->read();
    }

    public function selectDiasDoctor()
    {
        $alias = [
            'h',
            'hyd',
            'p'
        ];
        $unions = [
            'h.id_horario = hyd.id_horario',
            'p.id_personal = hyd.id_personal'
        ];

        $this->set_tables(["horario", "horarioydoctor", "personal"]);
        $this->set_colums(['h.id_horario', 'h.diaslaborables', 'hyd.horaDeEntrada', 'hyd.horaDeSalida', 'hyd.id_personal']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional([]);
        $this->set_limit(0);
        return $this->read();
    }


    public function select($estado = 'ACT', $start = 0, $limit = 10, $search = '', $ordenColumn = 'id_personal', $ordenDir = 'DESC')
    {
        $alias = [
            'u',
            'p',
            'es',
            'r'
        ];
        $unions = [
            'p.usuario = u.id_usuario',
            'es.id_especialidad = p.id_especialidad',
            'r.id_rol = u.id_rol'
        ];
        $conditions = [
            'condiciones' => ['u.estado' => $estado, 'es.id_especialidad' => null],
            'conectores' => ['AND'],
            'operadores' => ['=', 'IS NOT']
        ];
        $this->set_tables(["segurity.usuario", "bd.personal", "bd.especialidad", "segurity.rol"]);
        $this->set_colums(['u.id_usuario', 'u.id_rol', 'u.usuario', 'u.correo', 'u.password', 'p.id_personal', 'p.nacionalidad', 'p.cedula', 'p.nombre as nombre_d', 'p.apellido', 'p.telefono', 'p.id_especialidad', 'es.nombre']);

        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional($conditions);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);

        return $this->pagination();
    }



    public function horarioDelDoctor()
    {

        $alias = [
            'hyd',
            'pe',
            'u',
            'h'
        ];
        $unions = [
            'pe.id_personal = hyd.id_personal',
            'u.id_usuario = pe.usuario',
            'h.id_horario = hyd.id_horario'
        ];
        $conditions = [
            'condiciones' => ['pe.id_personal' => $this->getIdDoctor(), 'u.estado' => 'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['=', '=']
        ];

        $this->set_tables(['bd.horarioydoctor', 'bd.personal', 'segurity.usuario', 'bd.horario']);
        $this->set_colums(['pe.id_personal', 'pe.nombre', 'pe.apellido', 'pe.cedula', 'hyd.horaDeEntrada', 'hyd.horaDeSalida', 'h.diaslaborables', 'h.id_horario']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional($conditions);

        return $this->read();
    }

    // ── PRIVADOS ─────────────────────────────────────────

    public function validarCedula()
    {
        $coditions = [
            'condiciones' => ['cedula' => $this->getCedula(), 'id_personal' => $this->getIdDoctor()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["personal"]);
        $this->set_colums(['id_personal']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    public function validarUsuario()
    {
        $coditions = [
            'condiciones' => ['usuario' => $this->getUsuario(), 'id_usuario' => $this->getIdUsuario()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["usuario"]);
        $this->set_colums(['usuario']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    public function insertarDoctorDB()
    {
        try {
            $this->beginTransaction();

            if ($this->validarCedula()) {
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

            $this->set_tables(['segurity.usuario']);
            $idUsuario = $this->guardar($data1,$this->validator);
            $idUsuario = $idUsuario[0];

            $data2 = [
                'nacionalidad'    => $this->getNacionalidad(),
                'cedula'          => $this->getCedula(),
                'nombre'          => $this->getNombre(),
                'apellido'        => $this->getApellido(),
                'telefono'        => $this->getTelefono(),
                'tipodecategoria' => 'Doctor',
                'id_especialidad' => $this->getIdEspecialidad(),
                'usuario'      => $idUsuario
            ];
            $this->set_tables(['bd.personal']);
            $idPersonal = $this->guardar($data2,$this->validator);
            $idPersonal = $idPersonal['id_personal'];

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
                        'horaDeEntrada' => $this->getHoraEntrada()[$contador],
                        'horaDeSalida'     => $this->getHoraSalida()[$contador]
                    ];
                    $this->set_tables(['bd.horarioydoctor']);
                    $this->guardar($data,$this->validator);
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

    public function updateDoctorDB()
    {
        try {
            $this->beginTransaction();
            $coditions = [
                'condiciones' => ['usuario' => $this->getIdUsuario()],
                'conectores' => [],
                'operadores' => ['=']
            ];
            $this->set_tables(["personal"]);
            $this->set_colums(['id_personal','usuario']);
            $this->set_condicion_aditional($coditions);
            $listData = $this->read(false);

            if (empty($listData)) {
                throw new \Exception("El id del usuario no existe.");
            }

            if ($this->validarCedula()) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $idPersonal = $this->read(false);
            $idPersonal = $idPersonal['id_personal'];

            $data2 = [
                'nacionalidad'    => $this->getNacionalidad(),
                'cedula'          => $this->getCedula(),
                'nombre'          => $this->getNombre(),
                'apellido'        => $this->getApellido(),
                'telefono'        => $this->getTelefono(),
                'id_especialidad' => $this->getIdEspecialidad()
            ];
            $this->actualizar($data2,['id_personal'=>$this->getIdDoctor()],$this->validator);
            $this->set_tables(['segurity.usuario']);
            $this->actualizar(['correo' => $this->getEmail()],['id_usuario'=>$this->getIdUsuario()], $this->validator);

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
                        'horaDeEntrada' => $horaEntrada[$contador],
                        'horaDeSalida'     => $horaSalida[$contador]
                    ];
                    $this->set_tables(['horarioydoctor']);
                    $this->guardar($data,$this->validator);
                }
                if ($diasEditar && in_array($idD, $diasEditar)) {
                    $data = ['horaDeEntrada' => $horaEntrada[$contador], 'horaDeSalida' => $horaSalida[$contador]];
                    $this->actualizar($data, ['id_personal'=> $idPersonal['id_personal'], 'id_horario'=> $idD],$this->validator);
                }
                $contador++;
            }

            if ($diasE) {
                foreach ($diasE as $idE) {
                    $this->set_tables(['horarioydoctor']);
                    $this->eliminar(['id_personal' => $idPersonal['id_personal'], 'id_horario' => $idE],$this->validator);
                }
            }
            $this->commit();
            return [$idPersonal['id_personal']];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
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

}
