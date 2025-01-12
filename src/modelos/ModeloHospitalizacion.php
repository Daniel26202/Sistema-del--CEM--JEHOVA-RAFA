<?php
namespace App\modelos;

use App\modelos\Db;
use PDO;

class ModeloHospitalizacion extends Db
{

    private $conexion;
    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones pendientes)
    public function selectsH()
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total, con.id_control, con.diagnostico, h.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = pe.id_personal WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente" GROUP BY h.id_hospitalizacion;');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }
    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista (de las hospitalizaciones realizadas)
    public function selectsHR()
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total, con.id_control, con.diagnostico, h.historiaclinica, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = pe.id_personal WHERE h.estado = "Realizada" GROUP BY h.id_hospitalizacion;');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // validamos si el paciente existe
    public function validarPacienteH($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT cedula, nombre, apellido FROM paciente WHERE cedula = :cedula AND estado= "ACT"');

        $consulta->bindValue(":cedula", $cedula, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }


    // validamos si el control del paciente existe
    public function validarControlPaciente($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT con.id_control, pac.cedula, pac.nombre, pac.apellido FROM control con INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente WHERE pac.cedula = :cedula AND pac.estado = "ACT" ORDER BY con.id_control DESC LIMIT 1');

        $consulta->bindParam(":cedula", $cedula);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito.
    // selecciono el control de un paciente.
    public function select($cedula)
    {

        $consulta = $this->conexion->prepare('SELECT con.id_control, con.diagnostico, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM control con INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = pe.id_personal WHERE pac.cedula = :cedula AND con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" ORDER by con.id_control DESC LIMIT 1');

        $consulta->bindParam(":cedula", $cedula);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // selecciono todos los insumos
    public function selectsInsumos()
    {

        $consulta = $this->conexion->prepare('SELECT * FROM insumo WHERE estado = "ACT"');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    // buscar insumos por nombre
    public function buscarInsumos($nombre)
    {

        $consulta = $this->conexion->prepare('SELECT id_insumo, nombre, precio FROM insumo WHERE estado = "ACT" AND nombre LIKE :nombre');

        //PDO::PARAM_STR: esto es para que el envió sea de tipo estrin. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":nombre", '%' . $nombre . '%', PDO::PARAM_STR);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function buscarUnInsumo($id)
    {

        $consulta = $this->conexion->prepare('SELECT id_insumo, nombre, precio, cantidad AS limite_insumo FROM insumo WHERE estado = "ACT" AND id_insumo = :id');

        //PDO::PARAM_INT: esto es para que el envió sea de tipo entero. 
        //bindValue: funciona igual que el bindParam la diferencia es, que después del bindValue no se puede modificar nada de la consulta no lo leerá.
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // verifica si la hospitalización existe
    public function verificaHA($idC)
    {
        $consulta = $this->conexion->prepare('SELECT id_hospitalizacion FROM hospitalizacion WHERE id_control = :id_c AND estado = "Pendiente"');

        $consulta->bindParam(":id_c", $idC);
        $consulta->execute();
        return ($consulta->fetch()) ? 1 : false;

    }

    public function insertarH($idControl, $fechaHora, $duracion, $precioHoras, $total, $idInsumos, $cantidad, $historial)
    {

        // insertar hospitalización
        $consulta = $this->conexion->prepare('INSERT INTO hospitalizacion(id_control, id_horacostohospitalizacion, duracion, precio_horas, total, historiaclinica, fecha_hora, estado) VALUES (:id_control, 1, :duracion, :precio_horas, :total, :historial, :fecha_hora, "Pendiente")');

        $consulta->bindParam(":id_control", $idControl);
        $consulta->bindParam(":duracion", $duracion);
        $consulta->bindParam(":precio_horas", $precioHoras);
        $consulta->bindParam(":total", $total);
        $consulta->bindParam(":historial", $historial);
        $consulta->bindParam(":fecha_hora", $fechaHora);

        $consulta->execute();

        //devuelve el id de la hospitalización.
        //obtenemos los datos de la hospitalización que se a agregado. si no se inserta devuelve 0
        $idH = ($this->conexion->lastInsertId() == 0) ? false : $this->conexion->lastInsertId();

        // si hay un id del insumo devuelve verdadero si no, devuelve falso
        if ($idInsumos) {

            $contadorC = 0;

            foreach ($idInsumos as $idI) {

                // insertar insumos de la hospitalización
                $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_insumo, cantidad) VALUES (:id_hospitalizacion, :id_insumo, :cantidad)');

                $consulta->bindParam(":id_hospitalizacion", $idH);
                $consulta->bindParam(":id_insumo", $idI);
                $consulta->bindParam(":cantidad", $cantidad[$contadorC]);

                $consulta->execute();

                $contadorC++;
            }


        }


    }

    // traer insumos por el id de la hospitalización
    public function EInsumosM($id)
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, idh.id_insumo, idh.cantidad, ins.nombre, ins.precio, h.duracion, ins.cantidad AS limite_insumo FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = pe.id_personal INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN insumo ins ON idh.id_insumo = ins.id_insumo WHERE con.estado = "ACT" AND u.estado = "ACT" AND ins.estado = "ACT" AND h.id_hospitalizacion = :id GROUP BY ins.id_insumo');

        $consulta->bindValue(":id", $id, PDO::PARAM_INT);

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function editarH($duracion, $precioHoras, $total, $idInsumosA, $cantidadE, $cantidadA, $historial, $idHos, $idIDH, $idInsElim, $enfermerE)
    {

        // editar hospitalización
        $consulta = $this->conexion->prepare('UPDATE hospitalizacion SET duracion= :duracion, precio_horas= :precio_horas, total= :total, historiaclinica= :historial WHERE id_hospitalizacion = :idHosp AND estado = "Pendiente";');

        $consulta->bindParam(":duracion", $duracion);
        $consulta->bindParam(":precio_horas", $precioHoras);
        $consulta->bindParam(":total", $total);
        $consulta->bindParam(":idHosp", $idHos);
        $consulta->bindParam(":historial", $historial);

        $consulta->execute();

        // es para a editar insumos
        // si hay un id del insumo de hospitalización devuelve verdadero si no, devuelve falso
        if ($idIDH) {

            $contador = 0;

            foreach ($idIDH as $idInDHos) {

                // se edita los insumos de la hospitalización
                $consulta = $this->conexion->prepare('UPDATE insumodehospitalizacion SET cantidad= :cantidad WHERE id_insumoDeHospitalizacion = :id_hdi');

                $consulta->bindParam(":cantidad", $cantidadE[$contador]);
                $consulta->bindParam(":id_hdi", $idInDHos);

                $consulta->execute();

                $contador++;
            }

        }


        // es para agregar insumos
        // si hay un id del insumo devuelve verdadero si no, devuelve falso
        if ($idInsumosA) {

            $contadorC = 0;

            foreach ($idInsumosA as $idIA) {

                // insertar insumos de la hospitalización
                $consulta = $this->conexion->prepare('INSERT INTO insumodehospitalizacion(id_hospitalizacion, id_insumo, cantidad) VALUES (:id_hospitalizacion, :id_insumo, :cantidad)');

                $consulta->bindParam(":id_hospitalizacion", $idHos);
                $consulta->bindParam(":id_insumo", $idIA);
                $consulta->bindParam(":cantidad", $cantidadA[$contadorC]);

                $consulta->execute();

                $contadorC++;
            }

        }


        // es para eliminar insumos
        // si hay un id del insumo eliminado devuelve verdadero si no, devuelve falso
        if ($idInsElim) {

            foreach ($idInsElim as $idIAEl) {

                // insertar insumos de la hospitalización
                $consulta = $this->conexion->prepare('DELETE FROM insumodehospitalizacion WHERE id_insumoDeHospitalizacion = :id_insumo_eliminado');

                $consulta->bindParam(":id_insumo_eliminado", $idIAEl);
                $consulta->execute();
            }

        }

    }

    // eliminación lógica
    public function eliminaLogico($idH)
    {

        // editar el estado hospitalización
        $consulta = $this->conexion->prepare('UPDATE hospitalizacion SET estado ="DES" WHERE id_hospitalizacion =:id_h ;');

        $consulta->bindParam(":id_h", $idH);
        $consulta->execute();
    }

    // selecciono la hora y el costo 
    public function selectHC()
    {
        $consulta = $this->conexion->prepare('SELECT hora, costo FROM horacostohospitalizacion WHERE id_horacostohospitalizacion = 1');

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }
    // Actualizo la hora y el costo 
    public function updateHC($hora, $costo)
    {
        $consulta = $this->conexion->prepare('UPDATE horacostohospitalizacion SET hora= :hora, costo= :costo WHERE id_horacostohospitalizacion = 1');

        $consulta->bindParam(":hora", $hora);
        $consulta->bindParam(":costo", $costo);

        $datosHC = ($consulta->execute()) ? $consulta->fetch() : false;

    }

    // buscar duracion de la hospitalización
    public function buscarDH($idH)
    {
        $consulta = $this->conexion->prepare('SELECT duracion FROM hospitalizacion WHERE id_hospitalizacion = :idH AND estado = "Pendiente"');

        $consulta->bindParam(":idH", $idH);
        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // actualizar el precio de horas y total de la hospitalización
    public function actualizarPHT($precio_h, $total, $idH)
    {
        $consulta = $this->conexion->prepare('UPDATE hospitalizacion SET precio_horas = :precio_h, total = :total WHERE id_hospitalizacion = :idH;');

        $consulta->bindParam(":precio_h", $precio_h);
        $consulta->bindParam(":total", $total);
        $consulta->bindParam(":idH", $idH);

        return ($consulta->execute()) ? $consulta->fetch() : false;
    }

    // buscar insumos de las hospitalizaciones existentes 
    public function buscarIEH()
    {
        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, idh.id_insumo, idh.cantidad, ins.nombre, ins.cantidad AS cantidadEx, ins.precio, h.duracion FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = pe.id_personal INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN insumo ins ON idh.id_insumo = ins.id_insumo WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND ins.estado = "ACT" AND h.estado = "Pendiente"');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }
}