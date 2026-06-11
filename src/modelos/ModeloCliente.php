<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\RateLimiter;

class ModeloCliente extends ModelBase
{
    private $id_cliente, $nacionalidad, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $direccion, $fn, $genero;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    // ── READ ────────────────────────────────────────────────

    public function index($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cliente', $ordenDir = 'DESC')
    {
        try {
            $sql = "SELECT id_cliente, nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero FROM cliente WHERE estado='ACT' ";

            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND (cedula LIKE :buscar OR nombre LIKE :buscar OR apellido LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";

            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function indexPapelera($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cliente', $ordenDir = 'DESC')
    {
        try {
            $sql = "SELECT id_cliente, nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero FROM cliente WHERE estado='DES' ";

            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND (cedula LIKE :buscar OR nombre LIKE :buscar OR apellido LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

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

    public function contarTotalClientes($estado, $buscar = '')
    {
        try {
            $data = [
                'estado' => $estado
            ];
            $sql = "SELECT COUNT(*) as total FROM cliente WHERE estado = :estado";

            if (!empty($buscar)) {
                $sql .= " AND (cedula LIKE :buscar OR nombre LIKE :buscar OR apellido LIKE :buscar)";
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

    public function buscar()
    {
        try {
            $data = ['cedula' => $this->getCedula()];
            $sql  = "SELECT paciente.id_paciente, paciente.nacionalidad, paciente.cedula, paciente.nombre, paciente.apellido,
                            paciente.telefono, paciente.direccion, paciente.fn, patologia.id_patologia, patologia.nombre_patologia
                     FROM paciente
                     JOIN patologiadepaciente ON paciente.id_paciente = patologiadepaciente.id_paciente
                     JOIN patologia ON patologiadepaciente.id_patologia = patologia.id_patologia
                     WHERE paciente.cedula = :cedula AND paciente.estado = 'ACT'";
            $this->setSQL($sql);
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ── PRIVADOS─────────────────────────────────────────

    private function insertar()
    {
        try {
            $data = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula'       => $this->getCedula(),
                'nombre'       => $this->getNombre(),
                'apellido'     => $this->getApellido(),
                'telefono'     => $this->getTelefono(),
                'direccion'    => $this->getDireccion(),
                'fn'           => $this->getFn(),
                'genero'       => $this->getGenero(),
                'estado'       => 'ACT'
            ];

            if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $sql = "INSERT INTO cliente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero, estado)
                    VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, :estado)";
            $this->setSQL($sql);
            $id_cliente = $this->create($data);

            return ["exito", $id_cliente];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function update_cliente()
    {
        try {
            $data  = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula'       => $this->getCedula(),
                'nombre'       => $this->getNombre(),
                'apellido'     => $this->getApellido(),
                'telefono'     => $this->getTelefono(),
                'direccion'    => $this->getDireccion(),
                'fn'           => $this->getFn(),
                'genero'       => $this->getGenero()
            ];
            $data2 = ['id_cliente' => $this->getIdCliente()];

            $sql = "SELECT id_cliente FROM cliente WHERE id_cliente = :id_cliente";
            $this->setSQL($sql);
            if ($this->search($data2, false) == []) {
                throw new \Exception("El id del cliente no existe.");
            }

            $cedulaEnBD = $this->validarCedula(['cedula' => $this->getCedula()], true);

            // Si la cédula cambió, verificar que no esté duplicada
            if ($this->getCedulaRegistrada() !== $cedulaEnBD) {
                if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                    throw new \Exception("La cédula ya está registrada.");
                }
            }

            $sql = "UPDATE cliente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre,
                        apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero
                    WHERE id_cliente = :id";
            $this->setSQL($sql);
            $this->update($data, $this->getIdCliente());

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function delete_cliente()
    {
        try {
            $data = ['id_cliente' => $this->getIdCliente()];

            $sql = "SELECT id_cliente FROM cliente WHERE id_cliente = :id_cliente";
            $this->setSQL($sql);
            if ($this->search($data, false) == []) {
                throw new \Exception("El id del cliente no existe.");
            }

            $sql = "UPDATE cliente SET estado = 'DES' WHERE id_cliente = :id";
            $this->setSQL($sql);
            $this->update_logic($data['id_cliente']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function restablecer()
    {
        try {
            $data = ['id_cliente' => $this->getIdCliente()];

            $sql = "SELECT id_cliente FROM cliente WHERE id_cliente = :id_cliente";
            $this->setSQL($sql);
            if ($this->search($data, false) == []) {
                throw new \Exception("El id del cliente no existe.");
            }

            $sql = "UPDATE cliente SET estado = 'ACT' WHERE id_cliente = :id";
            $this->setSQL($sql);
            $this->update_logic($data['id_cliente']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Privado 
    private function validarCedula($data, $returnCedula = false)
    {
        try {
            $sql = "SELECT id_cliente,cedula FROM cliente WHERE cedula = :cedula";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            if ($returnCedula) {
                return !empty($listData) ? $listData['cedula'] : 0;
            }
            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // ── PÚBLICOS ────────────────────

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

    public function guardarCliente($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->nacionalidad,
            $this->cedula,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->direccion,
            $this->fn,
            $this->genero
        ], ' al registrar un cliente');
        (new RateLimiter())->verificar('guardar_cliente_' . $idUsuario, 5, 1);
        return $this->insertar();
    }

    public function editarCliente($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->id_cliente,
            $this->nacionalidad,
            $this->cedula,
            $this->cedulaRegistrada,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->direccion,
            $this->fn,
            $this->genero
        ], ' al editar un cliente');
        (new RateLimiter())->verificar('editar_cliente_' . $idUsuario, 5, 1);
        return $this->update_cliente();
    }

    public function eliminarCliente($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->id_cliente], ' al eliminar un cliente');
        (new RateLimiter())->verificar('eliminar_cliente_' . $idUsuario, 5, 1);
        return $this->delete_cliente();
    }

    public function restablecerCliente($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([$this->id_cliente], ' al restablecer un cliente');
        (new RateLimiter())->verificar('restablecer_cliente_' . $idUsuario, 5, 1);
        return $this->restablecer();
    }

    // ── Getters & Setters ─────────────────────────────────────────────────────

    public function getIdCliente()
    {
        return $this->id_cliente;
    }
    public function getNacionalidad()
    {
        return $this->nacionalidad;
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
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getFn()
    {
        return $this->fn;
    }
    public function getGenero()
    {
        return $this->genero;
    }

    public function setIdCliente($id_cliente)
    {
        if (!preg_match("/^[0-9]+$/", $id_cliente) || (int)$id_cliente <= 0) {
            throw new \InvalidArgumentException("El ID del cliente debe ser un número entero positivo.");
        }
        $this->id_cliente = (int)$id_cliente;
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

    public function setDireccion($direccion)
    {
        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $direccion)) {
            throw new \InvalidArgumentException("La dirección debe estar completa y detallada.");
        }
        $this->direccion = $direccion;
    }

    public function setFn($fn)
    {
        $dt = \DateTime::createFromFormat('Y-m-d', $fn);
        if (!$dt || $dt->format('Y-m-d') !== $fn) {
            throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
        }
        if ($fn >= date("Y-m-d")) {
            throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
        }
        $this->fn = $fn;
    }

    public function setGenero($genero)
    {
        if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
            throw new \InvalidArgumentException("El género debe ser 'Masculino' o 'Femenino'.");
        }
        $this->genero = $genero;
    }
}
